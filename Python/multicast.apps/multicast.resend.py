#!/usr/bin/python

import socket
import struct
import sys
import time
from optparse import OptionParser


# Set things up and process the command line options
parser = OptionParser()
parser.add_option("-a", "--listenaddress", dest="listenmulticastaddress", help="Listen Multicast Address")
parser.add_option("-p", "--listenport", dest="listenport", help="Listen Port")
parser.add_option("-d", "--destaddress", dest="destmulticastaddress", help="Destination Multicast Address")
parser.add_option("-r", "--destport", dest="destport", help="Destination Port")
parser.add_option("-m", "--maxcount", dest="maxcount", help="exit after recieving maxcount packets")
parser.add_option("-c", "--count", action="store_true", dest="count", default=False, help="count packets recieved")
parser.add_option("-t", "--time", action="store_true", dest="receivedtime", default=False, help="timestamp incoming packets")
(options, args) = parser.parse_args(args=None, values=None)

listenmulticastaddress = options.listenmulticastaddress
listenport = int(options.listenport)
destmulticastaddress = options.destmulticastaddress
destport = int(options.destport)
receivedtime = options.receivedtime

count = options.count
if options.maxcount:
   maxcount = int(options.maxcount) - 1
else:
   maxcount = int(1000000000)
ttl = 16

listensock = socket.socket(socket.AF_INET, socket.SOCK_DGRAM, socket.IPPROTO_UDP)
listensock.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, 1)
listensock.bind(('', listenport))
mreq = struct.pack("4sl", socket.inet_aton(listenmulticastaddress), socket.INADDR_ANY)
listensock.setsockopt(socket.IPPROTO_IP, socket.IP_ADD_MEMBERSHIP, mreq)

destsock = socket.socket(socket.AF_INET, socket.SOCK_DGRAM, socket.IPPROTO_UDP)
destsock.setsockopt(socket.IPPROTO_IP, socket.IP_MULTICAST_TTL, ttl)


def main():
 counter = 0
 while True:
  if receivedtime == True:
    packet = listensock.recv(40)
    timestamp = time.time()
    print "got here", timestamp
    destsock.sendto('%s %.6f' % (packet, timestamp), (destmulticastaddress, destport))
  else:
    packet = listensock.recv(140)
    destsock.sendto('%s' % (packet), (destmulticastaddress, destport))
  counter += 1
  if count == True: 
     print counter
  else:
     print packet 
  if counter > maxcount:
     print "maxcount has been reached, exiting"
     sys.exit(0)

main()
