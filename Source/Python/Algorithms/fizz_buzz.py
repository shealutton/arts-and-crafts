#!/usr/bin/python

seq = range(1,101)
len(seq)

for i in seq:
  if ( (i % 3) == 0 ) and ( (i % 5) == 0 ):
     print "fizzbuzz"
  elif ( (i % 3) == 0 ):
     print "fizz"
  elif ( (i % 5) == 0 ):
     print "buzz"
  else:
     print i

