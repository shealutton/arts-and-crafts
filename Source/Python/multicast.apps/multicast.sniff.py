#!/usr/bin/python

import socket
import struct
import sys
import time
from optparse import OptionParser


# Set things up and process the command line options
parser = OptionParser()
parser.add_option("-a", "--address", dest="multicastaddress", help="Multicast Address")
parser.add_option("-p", "--port", dest="port", help="Port")
parser.add_option("-m", "--maxcount", dest="maxcount", help="exit after recieving maxcount packets")
parser.add_option("-c", "--count", action="store_true", dest="count", default=False, help="count packets recieved")
parser.add_option("-t", "--time",  action="store_true", dest="receivedtime", default=False, help="print a timestamp when the packet arrived")
parser.add_option("-g", "--gap",   action="store_true", dest="gap", help="Gap Detection")

(options, args) = parser.parse_args(args=None, values=None)

multicastaddress = options.multicastaddress
port = int(options.port)
count = options.count
receivedtime = options.receivedtime
gap = options.gap

if options.maxcount:
   maxcount = int(options.maxcount) - 1
else:
   maxcount = int(1000000000)

sock = socket.socket(socket.AF_INET, socket.SOCK_DGRAM, socket.IPPROTO_UDP)
sock.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, 1)
sock.bind(('', port))
mreq = struct.pack("4sl", socket.inet_aton(multicastaddress), socket.INADDR_ANY)
sock.setsockopt(socket.IPPROTO_IP, socket.IP_ADD_MEMBERSHIP, mreq)

def main_gaps():
 counter = 0
 last_seq = 0
 gaps = 0
 gaplist = []
 while True:
  packet = sock.recv(30)
  seq, time = packet.split(' ')
  if not ( str(seq) == "warmup" ):  
    if ( int(seq) - 1 == int(last_seq) ):
      last_seq = int(seq)
    else:
      gaps += 1
      gaplist.append(seq)
      last_seq = int(seq)
  else:
    pass
  counter += 1
  if count == True: 
     print counter
  elif receivedtime == True:
     timestamp = time.time()
     print ('%s %.6f' % (packet, timestamp))
  else:
     print packet
  if counter > maxcount:
     print "maxcount has been reached, exiting"
     print "Gaps: ", gaps, gaplist
     sys.exit(0)

def main():
 counter = 0
 while True:
  packet = sock.recv(30)
  counter += 1
  if count == True: 
     print counter
  elif receivedtime == True:
     timestamp = time.time()
     print ('%s %.6f' % (packet, timestamp))
  else:
     print packet
  if counter > maxcount:
     print "maxcount has been reached, exiting"
     sys.exit(0)

if gap == True:
  main_gaps()
else:
  main()

#import profile
#profile.run('main()')
