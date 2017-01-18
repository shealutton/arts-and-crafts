#!/usr/bin/python

"""Read and try to understand the data"""
import sys
import psycopg2
import operator
import math
from optparse import OptionParser

# INPUTS
parser = OptionParser()
parser.add_option("-s", "--start", dest="start", help="Starting time")
parser.add_option("-e", "--end", dest="end", help="Ending time")
(options, args) = parser.parse_args(args=None, values=None)

# SET UP WITH OPTIONS
if options.start:
   start = options.start
if options.end:
   end = options.end

def morning_rush():
    """Which stations have the most departures and arrivals for each hour of the day"""
    global start, end
    station_trips = {}
    departure_list = []
    conn = psycopg2.connect("dbname=divvy user=divvy host=10.211.55.17")
    cur = conn.cursor()
    color_css = ["one","two","three","four","five","six","seven","eight","nine","ten"]

    # iterate through all stations and get the count of where people are leaving from
    cur.execute("select distinct from_station_id from trips order by from_station_id;")
    departing_stations = cur.fetchall()
    for station in departing_stations:
        cur.execute("select count(*) from trips where starttime::time > %s AND starttime::time < %s AND from_station_id = '%s';",(start, end, station[0]))
        departing_station_count = cur.fetchone()
        station_trips[station[0]] = departing_station_count[0]
    sorted_station_ids = sorted(station_trips.iteritems(), key=operator.itemgetter(1))

    # Get the top 5 busiest morning stations from the back of the list 
    for num in range(-10, 0):
        departure_list.append(sorted_station_ids[num][0])
        print departure_list

    for num in range(-10, 0):
        to_and_from = {}
        cur.execute("select distinct to_station_name from trips where to_station_id = '%s';",([sorted_station_ids[num][0]]))
        current_From_name = cur.fetchone()
        #print sorted_station_ids[num][0], current_From_name[0]
        #cur.execute("select distinct to_station_id from trips where starttime::time > '07:00:00' AND starttime::time < '08:00:00' AND from_station_id = '%s';",([sorted_station_ids[num][0]]))
        cur.execute("select distinct to_station_id from trips where starttime::time > %s AND starttime::time < %s AND from_station_id = %s;",(start, end, sorted_station_ids[num][0]))
        station_destinations = cur.fetchall()

        for station in station_destinations:
            cur.execute("select count(*) to_station_id from trips where starttime::time > %s AND starttime::time < %s AND from_station_id = %s AND to_station_id = %s;",(start, end, sorted_station_ids[num][0],station[0]))
            destination_count = cur.fetchone()
            to_and_from[station[0]] = destination_count[0]

        sorted_station_trips = sorted(to_and_from.iteritems(), key=operator.itemgetter(1))
        for secondnum in range(-5, 0):
            try: 
                cur.execute("select distinct from_station_name from trips where from_station_id = '%s';",([sorted_station_trips[secondnum][0]]))
                current_To_name = cur.fetchone()
                if sorted_station_trips[secondnum][0] in departure_list:
                    #cur.execute("select count(*) from trips where starttime::time > '07:00:00' AND starttime::time < '08:00:00' AND from_station_id = '%s';",([sorted_station_trips[secondnum][0]]))
                    cur.execute("select count(*) from trips where starttime::time > %s AND starttime::time < %s AND from_station_id = %s;",(start, end, sorted_station_trips[secondnum][0]))
                    lazy_hack_to_get_departing_station_count= cur.fetchone()
                    strings =  ['{source: "', current_From_name[0], '", source_size: ', str(round(math.sqrt(sorted_station_ids[num][1]),0)), ', target: "', current_To_name[0], '", trips: ', str(round(math.sqrt(lazy_hack_to_get_departing_station_count[0]),0)), ', type: "', color_css[num],'"},']
                else:
                    strings =  ['{source: "', current_From_name[0], '", source_size: ', str(round(math.sqrt(sorted_station_ids[num][1]),0)), ', target: "', current_To_name[0], '", trips: ', str(round(math.sqrt(sorted_station_trips[secondnum][1]))), ', type: "', color_css[num],'"},']
            except:
                pass

            assembled_strings = ''.join(strings)
            print assembled_strings
### I need to create the list of departing station names so that if there is a matching dest, it takes the departing size. That way it won't shring existing from stations. 

def top_departures():
    """Which station have the most departures"""
    station_trips = {}
    departure_list = []
    conn = psycopg2.connect("dbname=divvy user=divvy host=10.211.55.17")
    cur = conn.cursor()

    # iterate through all stations and get the count of where people are leaving from
    cur.execute("select distinct from_station_id from trips order by from_station_id;")
    departing_stations = cur.fetchall()
    for station in departing_stations:
        cur.execute("select count(*) from trips where from_station_id = '%s';",([station[0]]))
        departing_station_count = cur.fetchone()
        station_trips[station[0]] = departing_station_count[0]
    sorted_station_ids = sorted(station_trips.iteritems(), key=operator.itemgetter(1))
    print sorted_station_ids

def top_destinations():
    """Which station have the most departures"""
    station_trips = {}
    departure_list = []
    conn = psycopg2.connect("dbname=divvy user=divvy host=10.211.55.17")
    cur = conn.cursor()

    # iterate through all stations and get the count of where people are leaving from
    cur.execute("select distinct to_station_id from trips order by to_station_id;")
    departing_stations = cur.fetchall()
    for station in departing_stations:
        cur.execute("select count(*) from trips where to_station_id = '%s';",([station[0]]))
        departing_station_count = cur.fetchone()
        station_trips[station[0]] = departing_station_count[0]
    sorted_station_ids = sorted(station_trips.iteritems(), key=operator.itemgetter(1))
    print sorted_station_ids


def rides():
    """How many rides were taken on each bike"""
    conn = psycopg2.connect("dbname=divvy user=divvy")
    cur = conn.cursor()
    cur.execute("select distinct bike_id from trips order by bike_id;")
    bike_list = cur.fetchall()

    max_rides = 0
    max_ride_bike = 0

    for bike in bike_list:
        cur.execute("select count(*) from trips where bike_id = '%s';",(bike))
        rides = cur.fetchone()
        if rides[0] > max_rides:
            max_rides = rides[0]
            max_ride_bike = bike[0]
            print max_ride_bike, max_rides


def main():
    """Main entry point for the script."""
    #rides()
    #morning_rush()
    top_departures()
    top_destinations()


if __name__ == '__main__':
    main()

