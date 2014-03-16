#!/usr/bin/python

"""Insert all the divvy data into psql"""
import sys
import psycopg2


def main():
    """Main entry point for the script."""
    conn = psycopg2.connect("dbname=divvy user=divvy")
    cur = conn.cursor()

    f = open('Divvy_Stations_2013.csv', 'r')
    for line in f:
        name,latitude,longitude,cap = line.split(",")
        cur.execute("INSERT INTO stations (name, lat, long, capacity) VALUES (%s, %s, %s, %s)",(name,latitude,longitude,cap))
    conn.commit()

    f2 = open('Divvy_Trips_2013.csv', 'r')
    for line in f2:
        if '"' in line:
            line = line.strip()
            Before,duration,After = line.split('"')
            if "," in duration:
                duration = duration.replace(",", "")
            trip_id,starttime,stoptime,bike_id,junk1 = Before.split(",")
            junk3,from_station_id,from_station_name,to_station_id,to_station_name,usertype,gender,birthyear = After.split(",")
            if "#N/A" in from_station_id:
                from_station_id = 8000
            if "#N/A" in to_station_id:
                to_station_id = 8000
            try:
                cur.execute("INSERT INTO trips (trip_id,starttime,stoptime,bike_id,duration,from_station_id,from_station_name,to_station_id,to_station_name,usertype,gender,birthyear) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",(trip_id,starttime,stoptime,bike_id,duration,from_station_id,from_station_name,to_station_id,to_station_name,usertype,gender,birthyear))
            except:
                print "Skipping ", line
            conn.commit()

        else:
            line = line.strip()
            trip_id,starttime,stoptime,bike_id,duration,from_station_id,from_station_name,to_station_id,to_station_name,usertype,gender,birthyear = line.split(",")
            if "#N/A" in from_station_id:
                from_station_id = 8000
            if "#N/A" in to_station_id:
                to_station_id = 8000
            try:
                cur.execute("INSERT INTO trips (trip_id,starttime,stoptime,bike_id,duration,from_station_id,from_station_name,to_station_id,to_station_name,usertype,gender,birthyear) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",(trip_id,starttime,stoptime,bike_id,duration,from_station_id,from_station_name,to_station_id,to_station_name,usertype,gender,birthyear))
            except:
                print "Skipping ", line
            conn.commit()


if __name__ == '__main__':
    sys.exit(main())

