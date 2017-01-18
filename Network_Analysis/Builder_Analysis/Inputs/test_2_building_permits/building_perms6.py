#!/usr/bin/python

import networkx as nx
import matplotlib.pyplot as plt
import sys
import csv 
from optparse import OptionParser

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

# ADD BUILDER NODES, PROPERTY NODES, EDGES
for row in csv.reader(file):
   # Add all builders to a graph (will make them unique)
  try:
    if row[4] in row: # if the PIN is defined, move on
      if not row[3] in Gbuild:
         Gbuild.add_node(row[3], nodeid=n_id) # Adding each builder twice, once as a key, once as a value. 
         # sanitize the cost
         if len(row[2]) > 1:
            safeCost = float(row[2])
         else:
            safeCost = 0.0
         G.add_node(n_id, builder=row[3], cost=safeCost, date=row[0]) # Add the builder, cost, and date.
         n_id += 1 # increment the node id
      else: # If the builder exists, add the cost of the new project to their total
         if len(row[2]) >= 1: # if cost is set, add to Builder total
            id = Gbuild.node[row[3]]['nodeid']
            newcost = float(G.node[id]['cost']) + safeCost
            G.node[id]['cost'] = newcost
      # Add all properties[4-13] to a graph (will make them unique)
      count = 4
      while count <= 13:
         if row[count] in row: # if there is another property id in the row
            if not row[count] in Gprop: # and it is not yet in the Gprop graph
               Gprop.add_node(row[count], nodeid=n_id)
               G.add_node(n_id, property=row[count], cost=safeCost, date=row[0])
               n_id += 1
            #G.add_edge(Gbuild.node[row[3]]['nodeid'],Gprop.node[row[count]]['nodeid'], {'weight': float(row[2])} )
            G.add_edge(Gbuild.node[row[3]]['nodeid'],Gprop.node[row[count]]['nodeid'])
         else: # no properties left, end the loop
            count = 20 # end while loop
         count += 1
  except:
     pass

# PRUNING NODES
G2 = G.copy()

# Remove builders with < 3 projects
Bcount = 0
for n in Gbuild: # if < X props, remove
   id = Gbuild.node[n]['nodeid']
   print G2.node[id]
   if ( G2.degree(id) <= 50 ): # if the builder worked on < X projects AND
      if ( float(G2.node[id]['cost']) <= 2000000.0 ): # if the total value was < $Y, remove them
         G2.remove_node(id)
      else:
         Bcount +=1
   else: # if > X props, increase count and calculate TotalCost
      Bcount +=1

# Remove properties who's builders were removed
Pcount = 0
for n in Gprop:
   id = Gprop.node[n]['nodeid']
   if G2.degree(id) < 1:
      G2.remove_node(id)
   else:
      Pcount += 1
      G2.node[id]['cost'] = 0

#print Gbuild.number_of_nodes(), Gprop.number_of_nodes()
print Bcount, Pcount
print G2.number_of_nodes(), G2.number_of_edges()

title = str(year) + "_chicago.graphml"
opath = "../../Output/" + title
nx.write_graphml(G2, opath)
