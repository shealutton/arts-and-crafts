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

# Create Nodes, Edges
for row in csv.reader(file):
   # Add all builders to a graph (will make them unique)
   if not len(row[4]) == 0: # if the PIN is undefined, move on
      if not row[3] in Gbuild:
         Gbuild.add_node(row[3], nodeid=n_id) # Adding each builder twice, once as a key, once as a value. 
         G.add_node(n_id, builder=row[3], cost=row[2], date=row[0])
         n_id += 1
      else: # If the builder exists, add the cost of the new project to their total
         try: # in a try block to deal with null costs in data
            id = Gbuild.node[row[3]]['nodeid']
            newcost = float(G.node[id]['cost']) + float(row[2])
            G.node[id]['cost'] = newcost
         except:
            pass
      # Add all properties[4-13] to a graph (will make them unique)
      count = 4
      while count <= 13:
         if row[count] in row: # if there is another property in the row
            if not row[count] in Gprop: # and it is not yet in the Gprop graph
               Gprop.add_node(row[count], nodeid=n_id)
               G.add_node(n_id, property=row[count], cost=row[2], date=row[0])
               n_id += 1
            G.add_edge(Gbuild.node[row[3]]['nodeid'],Gprop.node[row[count]]['nodeid'])
         else: # no properties left, end the loop
            count = 20 # end while loop
         count += 1

# Remove builders with < 3 projects
G2 = G.copy()
for n in Gbuild:
   id = Gbuild.node[n]['nodeid']
   if G2.degree(id) <= 100:
      G2.remove_node(id)

# Remove properties who's builders were removed
for n in Gprop:
   id = Gprop.node[n]['nodeid']
   if G2.degree(id) < 1:
   #if G2.degree(id) == 0:
      G2.remove_node(id)

print G2.number_of_nodes()
print G2.number_of_edges()

# GRAPHING
#pos=nx.spring_layout(G,iterations=10)
#plt.figure(1,figsize=(15,15))
#plt.axis('off')

#nx.draw_networkx_nodes(
#        G,
#        pos,node_size=100,
#        alpha=1,
#        node_color='g'
#)
title = str(year) + "_chicago.graphml"
nx.write_graphml(G2, title)
#try:
#        nx.draw_networkx_edges(G,pos,alpha=0.2)
        #plt.savefig("image.png")
#        plt.show()
#except:
#        pass

