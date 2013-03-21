#!/usr/bin/python

import networkx as nx
import matplotlib.pyplot as plt
import sys
import csv 
from optparse import OptionParser

parser = OptionParser()
parser.add_option("-f", "--file", dest="file", help="The file to import")
(options, args) = parser.parse_args(args=None, values=None)

if options.file:
   file = open(options.file, "r")
else:
   print("missing -f file argument")
   sys.exit(1)

Gbuild = nx.Graph()
Gprop = nx.Graph()
G = nx.Graph()
n_id = 1
shea = set()

# Grab edges
for row in csv.reader(file):
   # Add all builders to a graph (will make them unique)
   if not row[3] in Gbuild:
      Gbuild.add_node(row[3], nodeid=n_id)
      G.add_node(n_id, builder=row[3])
      n_id += 1
   # Add all properties to a graph (will make them unique)
   if not row[4] in Gprop:
      Gprop.add_node(row[4], nodeid=n_id)
      G.add_node(n_id, property=row[4])
      n_id += 1
   G.add_edge(Gbuild.node[row[3]]['nodeid'],Gprop.node[row[4]]['nodeid'])

# Remove builders with only one project
G2 = G.copy()
#print len(Gbuild)
#print len(Gprop)
for n in Gbuild:
   id = Gbuild.node[n]['nodeid']
   #print G2.degree(id)
   if G2.degree(id) <= 3:
      G2.remove_node(id)

# Remove properties who's builders were removed
for n in Gprop:
   id = Gprop.node[n]['nodeid']
   if G2.degree(id) <= 1:
      G2.remove_node(id)

print G2.number_of_nodes()
print G2.number_of_edges()


# GRAPHING
pos=nx.spring_layout(G,iterations=20)
plt.figure(1,figsize=(15,15))
plt.axis('off')

nx.draw_networkx_nodes(
        G,
        pos,node_size=100,
        alpha=1,
        node_color='g'
)

nx.write_graphml(G2, "shea.graphml")
try:
        nx.draw_networkx_edges(G,pos,alpha=0.2)
        plt.savefig("image.png")
        plt.show()
except:
        pass



