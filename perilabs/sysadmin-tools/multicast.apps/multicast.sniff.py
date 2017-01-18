#!/usr/bin/python

import socket
import struct
import sys
import datetime
from optparse import OptionParser


# Set things up and process the command line options
parser = OptionParser()

parser.add_option("-a", "--address", dest="multicastaddress",
                 help="Multicast Address")

parser.add_option("-p", "--port", dest="port",
                 help="Port")

parser.add_option("-m", "--maxcount", dest="maxcount",
                 help="exit after recieving maxcount packets")

parser.add_option("-c", "--count",
		 action="store_true", dest="count", default=False,
		 help="count packets recieved")

parser.add_option("-r", "--receivedtime", 
                 action="store_true", dest="receivedtime", default=False,
                 help="print a timestamp when the packet arrived")

(options, args) = parser.parse_args(args=None, values=None)

multicastaddress = options.multicastaddress
port = int(options.port)
count = options.count
receivedtime = options.receivedtime

if options.maxcount:
   maxcount = options.maxcount
else:
   maxcount=1000000000
maxcount = int(maxcount)

sock = socket.socket(socket.AF_INET, socket.SOCK_DGRAM, socket.IPPROTO_UDP)
sock.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, 1)
sock.bind(('', port))
mreq = struct.pack("4sl", socket.inet_aton(multicastaddress), socket.INADDR_ANY)
sock.setsockopt(socket.IPPROTO_IP, socket.IP_ADD_MEMBERSHIP, mreq)

counter = 0

while True:
  a = sock.recv(10240)
  counter = counter + 1
  if count == True: 
     print counter
  elif receivedtime == True:
     timestamp = str(datetime.datetime.now())
     print a, timestamp
  else:
     print a
  if counter > maxcount:
     print "maxcount has been reached, exiting"
     sys.exit(0)
