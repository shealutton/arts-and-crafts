#!/usr/bin/python

#a = [1,2,3,5,6,7]
a = [1,2,5,6,7]
b = [1,2,3,4,5,6,7]
a_sum = sum(a)
b_sum = sum(b)
sqrA = (x**2 for x in a)
sqrB = (x**2 for x in b)
a_sqr = sum(sqrA)
b_sqr = sum(sqrB)
print a, a_sum, a_sqr
print b, b_sum, b_sqr
print b_sqr - a_sqr

print a[0], b[0]

