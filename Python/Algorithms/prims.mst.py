#!/usr/bin/python
# Shea Lutton, adapted from 
# http://programmingpraxis.com/2010/04/09/minimum-spanning-tree-prims-algorithm/

from heapq import heappush, heappop, heapify
from collections import defaultdict

def readfile():
  f = open('./edges.txt', 'r')
  header = f.readline()
  node_count, edge_count = header.split(' ')
  body = f.readlines() 			# format: "node1 node2 cost\n"
  return body

def data_prep( edges ):
  nodes = set()                         # Set of all nodes
  connections = defaultdict( list )     # Dict of edges per node
  for i in edges:                       # for each edge, add to dict by node
    n1, n2, cost = [ int(x.strip()) for x in i.split(' ') ]
    connections[n1].append( (cost, n1, n2) )
    connections[n2].append( (cost, n2, n1) )
    nodes.add(n1)                       # Populate nodes set
    nodes.add(n2)                       # Populate nodes set
  start = n1				# Set a starting node from last known n1
  return start, nodes, connections

def prims( start, nodes, connections ):
  X = set()       			# Set of all discovered nodes
  T = []          			# Final minimum spanning Tree
  graph = []      			# Heap of edges
  total_cost = 0  			# Cost counter
  X.add(start)				# Set a starting node from last known n1
  graph = connections[start][:]
  heapify(graph)

  while not ( len( nodes - X ) == 0 ):	# All nodes - discovered nodes == 0
    cost, n1, n2,  = heappop(graph)
    if n2 not in X:
      X.add(n2)
      T.append( [n1, n2] )
      total_cost += cost
      
      for e in connections[ n2 ]:	# Look up all edges for node 2
        if e[2] not in X:		# If don't already know the peer node
          heappush(graph, e)		# Add to the edge list

  return T, total_cost

data = readfile()
s, n, conn = data_prep( data )		# Get starting point, nodes set, connections
print prims( s, n, conn )

