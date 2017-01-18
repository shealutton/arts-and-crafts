#!/usr/bin/python

import socket
import time
import sys
import datetime
from optparse import OptionParser

# Set things up and process the command line options
parser = OptionParser()

parser.add_option("-a", "--address", dest="multicastaddress",
                 help="Multicast Address")

parser.add_option("-p", "--port", dest="port", type=int,
                 help="Port")

parser.add_option("-m", "--maxcount", dest="maxcount",
                 help="exit after sending maxcount packets, defaults to 1 billion")

parser.add_option("-s", "--sleep", dest="sleeptime",
                help="sets the sleep time between bursts, defaults to 1 second")

parser.add_option("-b", "--burst", dest="burst",
                help="sets the number of packets burst between the sleeptime, defaults to 1")

parser.add_option("-t", "--ttl", dest="ttl",
                help="sets the TTL on the multicast packets, defaults to 16")

(options, args) = parser.parse_args(args=None, values=None)

if options.multicastaddress:
   multicastaddress = options.multicastaddress
else:
   print "missing -a address argument"
   sys.exit(1)

if options.port:
   port = int(options.port)
else:
   print "missing -p port argument"
   sys.exit(1)

if options.maxcount:
   maxcount = int(options.maxcount)
else:
   maxcount = 1000000000 
maxcount = int(maxcount)

if options.sleeptime:
   sleeptime = float(options.sleeptime)
else:
   sleeptime = 1

if options.burst:
   burst = int(options.burst)
else:
   burst = 1

if options.ttl:
   ttl = int(options.ttl)
else:
   ttl = 16

sock = socket.socket(socket.AF_INET, socket.SOCK_DGRAM, socket.IPPROTO_UDP)
sock.setsockopt(socket.IPPROTO_IP, socket.IP_MULTICAST_TTL, ttl)
sock.sendto("warmup packet", (multicastaddress, port))
time.sleep(2)
counter = 0

while True:
   for x in range(0, burst):
       packet_count = counter + x
       timestamp = str(datetime.datetime.now())
       sock.sendto('  %s %s' % ( packet_count, timestamp), (multicastaddress, port))
   for i in range(0, 1000):
       pass
   counter = counter + burst
   if counter > maxcount:
      print "maxcount has been reached, exiting"
      sys.exit(0)
   time.sleep(sleeptime)
