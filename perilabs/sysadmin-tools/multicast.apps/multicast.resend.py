#!/usr/bin/python

import socket
import struct
import sys
from optparse import OptionParser


# Set things up and process the command line options
parser = OptionParser()

parser.add_option("-a", "--listenaddress", dest="listenmulticastaddress",
                 help="Listen Multicast Address")

parser.add_option("-p", "--listenport", dest="listenport",
                 help="Listen Port")

parser.add_option("-d", "--destaddress", dest="destmulticastaddress",
                 help="Destination Multicast Address")

parser.add_option("-r", "--destport", dest="destport",
                 help="Destination Port")

parser.add_option("-m", "--maxcount", dest="maxcount",
                 help="exit after recieving maxcount packets")

parser.add_option("-c", "--count",
		 action="store_true", dest="count", default=False,
		 help="count packets recieved")

(options, args) = parser.parse_args(args=None, values=None)

listenmulticastaddress = options.listenmulticastaddress
listenport = int(options.listenport)
destmulticastaddress = options.destmulticastaddress
destport = int(options.destport)

count = options.count
if options.maxcount:
   maxcount = options.maxcount
else:
   maxcount=1000000000
maxcount = int(maxcount)
ttl = 16

listensock = socket.socket(socket.AF_INET, socket.SOCK_DGRAM, socket.IPPROTO_UDP)
listensock.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, 1)
listensock.bind(('', listenport))
mreq = struct.pack("4sl", socket.inet_aton(listenmulticastaddress), socket.INADDR_ANY)
listensock.setsockopt(socket.IPPROTO_IP, socket.IP_ADD_MEMBERSHIP, mreq)

destsock = socket.socket(socket.AF_INET, socket.SOCK_DGRAM, socket.IPPROTO_UDP)
destsock.setsockopt(socket.IPPROTO_IP, socket.IP_MULTICAST_TTL, ttl)

counter = 0
while True:
  a = listensock.recv(10240)
  destsock.sendto(a, (destmulticastaddress, destport))
  counter = counter + 1
  if count == True: 
     print counter
  else:
     print a 
  if counter > maxcount:
     print "maxcount has been reached, exiting"
     sys.exit(0)


