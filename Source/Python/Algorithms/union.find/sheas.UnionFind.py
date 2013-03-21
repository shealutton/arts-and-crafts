#! /usr/bin/python

class QuickUnion:
  def __init__(self, node):
    self.i = int(node)
    self.id = []
    self.size = []
    self.counter = 0

    #if (self.counter == 0 or self.counter < N):
    #  self.id.extend(int(self.i))
    #  self.counter += 1

    self.id.append(self.i)

  def root(i):
    while not ( i == self.id[i] ):
      i = self.id[i] 
    return int(i)

  def hello():
    return "Hello"

  def find (p, q):
    hello()
    #if self.root(p) == self.root(q):
    #if :
    #  return True
    #else:
    #  return False

  def unite(p, q):
    i = root(int(p))
    j = root(int(q))
    id[i] = j


nodes = ['shea', 'nancy', 'susan', 'lou', 'david']
count = 0
d = {}
for n in nodes:
  d[count] = n
  count += 1

#for item in d.keys():
q = QuickUnion(0)

print q.find(0)
