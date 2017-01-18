#!/usr/bin/python

import sys
import zmq
import signal
import time

### Global vars
gaps = {} # a dictionary of the missing or unreconciled job ids
workdict = {} # record all the responses
max = int(-1) # largest work id seen

context = zmq.Context()
sock = context.socket(zmq.PULL)		# Data sockets
control = context.socket(zmq.REP)	# Control socket

### DEFS
def start_sockets(addresses):
  control.bind("tcp://127.0.0.1:5000")	# Start control socket
  for arg in addresses:			# Start data sockets (fan in)
    sock.connect(arg)

def gap_detection(current_id, value):
  global gaps, workdict, max
  if (current_id == (max + 1)):		# If the id is the next expected
    workdict[current_id] = value	# Add to list and increment expected
    max = current_id
  elif current_id in gaps:		# Else if the id is in the gap dict
    del gaps[current_id]		# Remove from the gap dict and save the value
    workdict[current_id] = value
    print "GAP Resolved, Remaining: ", len(gaps)
  else:					# Otherwise, note the gap(s) in the gaps list
    for i in range((max + 1), current_id):
      gaps[i] = 0
    workdict[current_id] = value	# Save the value
    max = int(current_id)

def main():
  while True:
    while True: 			# Prioritize data msgs over control
      try:
        message= sock.recv(zmq.NOBLOCK)	# Check for data msg (non blocking)
        id,val = str.split(message)
        gap_detection(int(id),int(val))
      except zmq.ZMQError:
        break

    while True:				# Check for control msgs
      try:
        control_handler(control.recv(zmq.NOBLOCK))
      except zmq.ZMQError:
        break

def control_handler(msg):
    sig,total = str.split(msg)
    print sig, total
    while True:
      if (len(gaps) > 0 ):
        print "gaps remain"
        for i in gaps:
          print i
          msg = i
          control.send(msg)
        break
      elif ( len(workdict) < total ):
        print "not reached total"
        time.sleep(1)
        break
      elif (len(gaps) == 0 ) and ( len(workdict) == total ):
        msg = "FINISHED"
        print msg, max, len(workdict), gaps
        control.send(msg)
        quit(1,1)
      else:
        print "FUBAR"
        quit(1,1)

def quit(signum, frame):
    sock.close()
    control.close()
    context.destroy()
    sys.exit(0)


### Register signal handlers to gracefully quit
signal.signal(signal.SIGINT, quit)
signal.signal(signal.SIGHUP, quit)
signal.signal(signal.SIGTERM, quit)

start_sockets(sys.argv[1:])
main()
