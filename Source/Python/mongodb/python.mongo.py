#!/usr/bin/python

import profile
import pymongo
from pymongo import MongoClient


connection = MongoClient('localhost', 27017)
db = connection.test_database
collection = db.test_collection
import datetime

def main():
 data = [
  {'exp': 1, 'trial': 1, 'name': '1', 'm1': 'a', 'm2': 1, 'm3': 1.0},
  {'exp': 1, 'trial': 1, 'name': '2', 'm1': 'b', 'm2': 2, 'm3': 2.0},
  {'exp': 1, 'trial': 1, 'name': '3', 'm1': 'c', 'm2': 3, 'm3': 3.0},
  {'exp': 1, 'trial': 1, 'name': '4', 'm1': 'd', 'm2': 4, 'm3': 4.0},
  {'exp': 1, 'trial': 1, 'name': '5', 'm1': 'e', 'm2': 5, 'm3': 5.0},
  {'exp': 1, 'trial': 2, 'name': '1', 'm1': 'v', 'm2': 22, 'm3': 1.0},
  {'exp': 1, 'trial': 2, 'name': '2', 'm1': 'w', 'm2': 23, 'm3': 2.0},
  {'exp': 1, 'trial': 2, 'name': '3', 'm1': 'x', 'm2': 24, 'm3': 3.0},
  {'exp': 1, 'trial': 2, 'name': '4', 'm1': 'y', 'm2': 25, 'm3': 4.0},
  {'exp': 1, 'trial': 2, 'name': '5', 'm1': 'z', 'm2': 26, 'm3': 5.0}]

 results = db.results
 data_id = results.insert(data)

#for row in results.find({"trial": 1}):
#  print row
#print " "

#for row in results.find({"trial": 1}):
#  print row
#print " "

#for row in results.find({"exp": 1, "trial": 2, "m1": "v"}).sort("_id"):
#  print row

#print results.find({"exp": 1, "trial": 1}).count()
#print results.find({"exp": 1, "trial": 2}).count()

 results.remove()

#main()
profile.run('main()')
