#!/usr/bin/python

import socket
import struct
import sys
import signal
import time
import subprocess
from optparse import OptionParser


# Set things up and process the command line options
parser = OptionParser()
parser.add_option("-a", "--address", dest="multicastaddress", help="Multicast Address")
parser.add_option("-p", "--port", dest="port", help="Port")
parser.add_option("-l", "--lineprovider", dest="lineprovider", help="Line Provider (cme_candi, cme_l3, cme_sidera)")
(options, args) = parser.parse_args(args=None, values=None)

if options.lineprovider:
   dbtable = str(options.lineprovider)
   known_db_tables = ['cme_candi','cme_sidera','cme_l3']
   if dbtable not in known_db_tables:
      print "Bad argument for line provider. Please choose cme_candi, cme_l3, cme_sidera"
      sys.exit(1)
else:
   print "missing -l argument for line provider"
   sys.exit(1)

multicastaddress = options.multicastaddress
port = int(options.port)

sock = socket.socket(socket.AF_INET, socket.SOCK_DGRAM, socket.IPPROTO_UDP)
sock.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, 1)
sock.bind(('', port))
mreq = struct.pack("4sl", socket.inet_aton(multicastaddress), socket.INADDR_ANY)
sock.setsockopt(socket.IPPROTO_IP, socket.IP_ADD_MEMBERSHIP, mreq)

def insert(msgid, tzero, tone):
  text = """INSERT INTO """ + dbtable + """ (id, t0, t1) VALUES ('""" + str(msgid) + """', '""" + str(tzero) + """', '""" + str(tone) + """');"""
  p = subprocess.Popen(['psql', '-d', 'time', '-U', 'time', '-h', '192.168.40.22', '-c', text], stdout=subprocess.PIPE, stderr=subprocess.PIPE)
  out, err = p.communicate()
  return out, err

def main():
 counter = 0
 last_seq = -1
 gaps = 0
 gaplist = []
 while True:
  packet = sock.recv(30)
  t = time.time()
  t1 = "%.6f"% (t)
  seq, t0 = packet.split(' ')
  if ( str(seq) == "warmup" ):
    pass
  else:					# a real packet
    if ( int(seq) - 1 == int(last_seq) and not last_seq == -1 ): # if the next pkt is what we expected, no gap
      last_seq = int(seq)
      ok, error = insert(seq, t0, t1)
    elif ( last_seq == -1 ):		# initilize for first packet
      last_seq = int(seq)
      ok, error = insert(seq, t0, t1)
    else:				# There were gaps, insert large values for each gap
      drops = int(seq) - int(last_seq)  # diff between current seq and last seen seq #
      while int(last_seq) < int(seq):	# Insert contrived large values for each missing pkt
        last_seq += 1
        ok, error = insert(seq, 1, 2)
      # After inserting fake data for the gaps, insert the actual pkt you just saw
      ok, error = insert(seq, t0, t1)
      last_seq = int(seq)

def quit(signum, frame):
   print "  Received signal, exiting. "
   sys.exit(0)

signal.signal(signal.SIGINT, quit)
signal.signal(signal.SIGHUP, quit)

main()

