#!/usr/bin/python

import grouper

g = grouper.Grouper('1')
g.join('3', '4')
g.join('4', '9')
for x in g:
  print x

g.join('8', '0')
g.join('2', '3')
print g.find('8', '3')
print g.find('9', '3')
for x in g:
  print x
print "\n"

g.join('5', '6')
for x in g:
  print x
print "\n"

g.join('2', '9')
for x in g:
  print x
print "\n"

g.join('5', '9')
g.join('7', '3')
g.join('0', '2')
for x in g:
  print x
print g.find('8', '6')
print "\n"

