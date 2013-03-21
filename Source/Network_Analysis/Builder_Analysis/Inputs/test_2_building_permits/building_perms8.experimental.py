#!/usr/bin/python

import networkx as nx
import sys
import csv
from optparse import OptionParser
from random import randint

parser = OptionParser()
parser.add_option("-f", "--file", dest="file", help="The file to import")
parser.add_option("-y", "--year", dest="year", help="The year being processed")
(options, args) = parser.parse_args(args=None, values=None)

if options.file:
   file = open(options.file, "r")
else:
   print("missing -f file argument")
   sys.exit(1)

if options.year:
   year = options.year
else:
   print("missing -y year argument")
   sys.exit(1)

Gbuild = nx.Graph()
Gprop = nx.Graph()
G = nx.Graph()
n_id = 1
TotalValue = 0.0

for row in csv.reader(file):
   # SANITIZE ROW
   # Date
   if len(row[0]) < 1: # if no date, skip
      break
   else:
      safeDate = str(row[0])
   # Cost         
   if len(row[2]) > 1:
      safeCost = round(float(row[2]) / 1000, 2)
   else:
      safeCost = float(0.0)
   # Builder
   if len(row[3]) < 1: # if no builder, skip
      break
   else:
      safeBuilder = str(row[3])
   # PIN
   if row[4] in row:
      if len(row[4]) < 1: 
         safePin = str(randint(1000000000, 9999999999))
      else:
         safePin = str(row[4])
   TotalValue = ( TotalValue + safeCost )

   # ADD BUILDER NODES, PROPERTY NODES, EDGES
   try: # ADD BUILDER
      if not safeBuilder in Gbuild:
         Gbuild.add_node(safeBuilder, nodeid=n_id)
         G.add_node(n_id, builder=safeBuilder, cost=safeCost, date=safeDate)
         n_id += 1
      else:
         id = Gbuild.node[safeBuilder]['nodeid']
         newCost = G.node[id]['cost'] + safeCost
         G.node[id]['cost'] = newCost
   except:
      pass
   
   try: # ADD PIN 1
      if not safePin in Gprop:
         Gprop.add_node(safePin, nodeid=n_id)
         G.add_node(n_id, property=safePin, cost=float(0.0), date=safeDate)
         n_id += 1
      # CREATE EDGE
      G.add_edge(Gbuild.node[safeBuilder]['nodeid'],Gprop.node[safePin]['nodeid'])
   except:
      print "Error with edge:", Gbuild.node[safeBuilder]['nodeid'],Gprop.node[safePin]['nodeid']

   try: # SEARCH FOR EXTRA PINS
      count = 5
      while count <= 13: # ITERATE OVER REMAINING ROW[x]
         if len(row[count]) > 1:
            Gprop.add_node(row[count], nodeid=n_id)
            G.add_node(n_id, property=row[count], cost=float(0.0), date=safeDate)
            n_id += 1
            G.add_edge(Gbuild.node[safeBuilder]['nodeid'],Gprop.node[row[count]]['nodeid'])
         else: # no properties left, end the loop
            break # end while loop
         count += 1
   except:
      pass


# PRUNING NODES
G2 = G.copy()

# Remove builders with < X properties
Bcount = 0
for n in Gbuild: # if < X props, remove the builder
   id = Gbuild.node[n]['nodeid']
   if ( G2.degree(id) <= 100 ) and ( G2.node[id]['cost'] <= 2000.0 ): # if worked < X props AND total cost < $Y, delete
      G2.remove_node(id)
   else:
      Bcount +=1 # if > X props AND > $Y, increase Bcount

# Remove properties who's builders were removed
Pcount = 0
for n in Gprop:
   id = Gprop.node[n]['nodeid']
   if G2.degree(id) < 1:
      G2.remove_node(id)
   else:
      Pcount += 1
      G2.node[id]['cost'] = 0.0

G3 = G2.copy()
for n in G3:
   if G2.degree(n) < 1:
      G2.remove_node(n)

print TotalValue
print Bcount, Pcount
print G2.number_of_nodes(), G2.number_of_edges()

title = str(year) + "_chicago.graphml"
opath = "../../Output/" + title
nx.write_graphml(G2, opath)

