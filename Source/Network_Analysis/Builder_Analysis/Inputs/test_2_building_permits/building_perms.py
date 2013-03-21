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

G = nx.Graph()
node_edgelist=[]

# Grab edges
#for row in file:
for row in csv.reader(file):
   n = row[24]
   e = row[13]
   node_edgelist.append((n,e))
   print n, "XXX", e

# Create edges
for f in node_edgelist:
   #for t in node_edgelist:
   if f[0] != f[1]:
         G.add_edge(f[0],f[1])

#def f7(seq):
#    seen = set()
#    seen_add = seen.add
#    return [ x for x in seq if x not in seen and not seen_add(x)]

pos=nx.spring_layout(G,iterations=60)
plt.figure(1,figsize=(15,15))
plt.axis('off')

nx.draw_networkx_nodes(
        G,
        pos,node_size=100,
        alpha=1,
        node_color='g'
)

try:
        nx.draw_networkx_edges(G,pos,alpha=0.2)
        plt.savefig("image.png")
        plt.show()
except:
        pass

