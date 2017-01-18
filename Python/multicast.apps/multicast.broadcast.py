#!/usr/bin/python
# Shea Lutton v 2.0

import socket
import time
import datetime
import sys
from optparse import OptionParser

# INPUTS
parser = OptionParser()
parser.add_option("-a", "--address", dest="multicastaddress", help="Multicast Address")
parser.add_option("-p", "--port", dest="port", type=int, help="Port")
parser.add_option("-m", "--max", dest="max", help="exit after max packets, defaults to 1 billion")
parser.add_option("-s", "--sleep", dest="sleeptime", help="sets the sleep time between bursts, defaults to 1 second")
parser.add_option("-b", "--burst", dest="burst", help="sets the number of packets sent in bursts, defaults to 1")
parser.add_option("-t", "--ttl", dest="ttl", help="sets the TTL on the multicast packets, defaults to 16")
(options, args) = parser.parse_args(args=None, values=None)

# SET UP WITH OPTIONS
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
if options.max:
   max = int(options.max) - 1
else:
   max = int(1000000000)
if options.sleeptime:
   sleeptime = int(options.sleeptime)
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
time.sleep(1)
counter = 0

def main():
 global counter
 while True:
   if (burst > 1):
      for x in range(0, burst):
         counter += 1
         timestamp = time.time()
         sock.sendto('%s %s' % (counter, timestamp), (multicastaddress, port))
   else:
      counter += 1
      timestamp = time.time()
      sock.sendto('%s %.6f' % (counter, timestamp), (multicastaddress, port))
   if counter > max:
      print "max has been reached, exiting"
      sys.exit(0)
   if (sleeptime > 0) :
      time.sleep(sleeptime)

main()
#import profile
#profile.run('main()')

