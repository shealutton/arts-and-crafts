#!/usr/bin/python

import sys
import time
import zmq
import signal

gaps = {}
workdict = {}
max = -1
total = -1
context = zmq.Context()
done = False

# Socket to receive messages on
receiver = context.socket(zmq.PULL)
receiver.bind("tcp://*:5558")

# Socket for start/worker control
controller = context.socket(zmq.PUB)
controller.bind("tcp://*:5559")

# Socket to listen to starter for status updates
status = context.socket(zmq.SUB)
status.connect("tcp://10.10.1.103:5555")
status.setsockopt(zmq.SUBSCRIBE, "")

# Process messages from receiver socket
poller = zmq.Poller()
poller.register(receiver, zmq.POLLIN)
poller.register(status, zmq.POLLIN)

def quit(signum, frame):                        # Quit gracefully and close sockets
  print " Received signal: %s" % (signum)
  receiver.close()
  status.close()
  controller.close()
  context.destroy()
  sys.exit(0)

def gap_detection(current_id, value):
  global gaps, workdict, max
  if ( current_id == (max + 1) ):		# If the id is the next expected
    workdict[current_id] = value		# Add to list and increment expected
    max = current_id
  elif ( current_id in gaps ):			# Else if the id is in the gap dict
    del gaps[current_id]			# Remove from the gap dict and save the value
    workdict[current_id] = value
  elif ( current_id in workdict ):
    pass
  else:						# Otherwise, note the gap(s) in the gaps list
    for i in range((max + 1), current_id):
      if not ( i in gaps ):
        gaps[i] = 0
    workdict[current_id] = value		# Save the value
    max = int(current_id)

def listen():					# Process messages from socket
  global done, total
  while True:
    socks = dict(poller.poll())

    if socks.get(receiver) == zmq.POLLIN:	# Listen for data msg
      try:					# Try to aggregate
        key, value = str.split(receiver.recv())	# Messages take the form: "index", "value"
        gap_detection(int(key), int(value))
      except:					# Else wait for gap detection, replay
        pass

    if socks.get(status) == zmq.POLLIN:		# Listen for status msg
      try:
        message, tot = str.split(status.recv())	
        if ( message == "FINISHED" ):		# Listen for finished msg
          done = True				# Leave listen loop
          total = int(tot)
          break
      except:					# Ignore all other msgs
        pass

def replay(ids):				# Send list to be reprocessed
  controller.send(str(ids))

def main():
  global total, done
  while True:
    while ( done == False ):			# Listen for data and status
      listen()

    if ( len(gaps) > 0 ):			# If gaps, request replay
      done = False
      replay(gaps)
    elif ( total > len(workdict) ):		# If fewer results than expected, replay
      done = False
      missing = range(len(workdict),total)
      replay(missing)
    else:					# No gaps and the right total, then Finished 
      done = True
      print "Kill sent"
      controller.send("KILL")			# Send term signal to all middle and start
      time.sleep(2)
      break
    print "Completed: ", len(workdict), "Gaps: ", len(gaps)

signal.signal(signal.SIGINT, quit)              # Register signal handlers to gracefully quit
signal.signal(signal.SIGHUP, quit)
signal.signal(signal.SIGTERM, quit)

main()
print "Completed: ", len(workdict), "Gaps: ", len(gaps)

