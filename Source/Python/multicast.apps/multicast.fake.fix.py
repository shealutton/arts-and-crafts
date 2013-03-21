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

### REQUIRED OPTIONS / SETUP
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
else: # 1,000,000,000 
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

sock.sendto("warmup fake fix", (multicastaddress, port))
time.sleep(1)
counter = 0
soh = chr(01) + " " 
fix = str("8=FIX.4.1")
bodylength = str("9=154")
msgtype = str("35=6")
SenderCompID = str("49=CME")
IOIid = str("23=115687")
IOITransType = str("28=N")
symbol = str("55=PIRI.MI")
side = str("54=1")
IOIShares = str("27=300000")
Price = str("44=7900.000000")
IOIQltyInd = str("25=H")
CheckSum = str("10=168")

while True:
   for x in range(0, burst):
       counter += 1
       timestamp = str(datetime.datetime.now())
       msg = str(fix + soh + bodylength + soh + msgtype + soh + SenderCompID + soh + str(counter) + soh + str(timestamp) + soh + IOIid + soh + IOITransType + soh + symbol + soh + side + soh + IOIShares + soh + Price + soh + IOIQltyInd + soh + CheckSum)
       sock.sendto('%s' % (msg), (multicastaddress, port))
   if counter > maxcount:
      print "maxcount has been reached, exiting"
      sys.exit(0)
   time.sleep(sleeptime)

