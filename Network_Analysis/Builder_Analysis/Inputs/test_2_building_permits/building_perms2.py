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

output = open("output.graphml", "w")
G = nx.Graph()
node_edgelist=[]
nodes={}
edges=[]
e_id = 0
n_id = 0

# Grab edges
nodeset = set()
for row in csv.reader(file):
   n1  = row[24]
   n2 = row[13]
   node_edgelist.append((n1,n2))
   # If n1 has already been seen, don't add a new node
   if not n1 in nodeset:
      nodes[n1] = n_id
      n_id += 1
      nodeset.add(n1)
   else:
      pass
   # If n2 has already been seen, don't add a new node
   if not n2 in nodeset:
      nodes[n2] = n_id
      n_id += 1
      nodeset.add(n2)
   else:
      pass 
   # Set the edges
   edge = e_id, nodes[n1], nodes[n2]
   edges.append(edge)
   e_id += 1
   
### FORM THE graphml FILE
header = '<?xml version="1.0" encoding="UTF-8"?>\n\t\t\t<graphml xmlns="http://graphml.graphdrawing.org/xmlns"\n\t\t\txmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"\n\t\t\txsi:schemaLocation="http://graphml.graphdrawing.org/xmlns\n\t\t\thttp://graphml.graphdrawing.org/xmlns/1.0/graphml.xsd">\n'
key = '<key id="0" for="node" attr.name="name" attr.type="string">\n\t<default></default>\n</key>\n<graph id="G" edgedefault="undirected">\n'
footer = '</graph></graphml>\n'

output.write(header)
output.write(key)

for node in nodes:
   v1 = str("%s%s%s" % ('<node id="', nodes[node], '">\n'))
   v2 = str("%s%s%s" % ('        <data key="0"><![CDATA[', node, ']]></data>\n'))
   v3 = str("%s" % ('</node>\n'))
   output.write(v1)
   output.write(v2)
   output.write(v3)

for e in edges:
   print e[1], edges[1].count(e[1])  
   e1 = "%s%s%s%s%s%s%s" % ('<edge id="', e[0], '" source="', e[1], '" target="', e[2], '"></edge>\n')
   output.write(e1)

output.write(footer)



