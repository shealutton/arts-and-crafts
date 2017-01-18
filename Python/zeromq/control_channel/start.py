#!/usr/bin/python

import zmq
import re
import time
import signal
import sys

context = zmq.Context()

# Socket to send work messages on
sender = context.socket(zmq.PUSH)
sender.bind("tcp://*:5557")

# Socket for status messages
status = context.socket(zmq.PUB)
status.bind("tcp://*:5555")

# Socket for listening to control feedback
controller = context.socket(zmq.SUB)
controller.connect("tcp://10.10.1.103:5559")
controller.setsockopt(zmq.SUBSCRIBE, "")

# Send status messages and poll controller
poller = zmq.Poller()
poller.register(controller, zmq.POLLIN)

# ---------------------------------------------------
# WORK BLOCK. Define data to send to workers here:
# ---------------------------------------------------
worklist = {}					# Create a blank dict
for i in range(0,100000):				# Add keys and values
  worklist[i] = i				# Save it for later replay if needed

def work():
  for key in worklist:				# Send elements 1 at a time for round robin
    msg = str(key) + " " + str(worklist[key])
    sender.send(msg)				# Send elements
  time.sleep(5)					# Allow worker process time. Increment for heavy work
# ---------------------------------------------------
def quit(signum, frame):			# Quit gracefully and close sockets
  print " Received signal: %s" % (signum)
  sender.close()
  status.close()
  controller.close()
  context.destroy()
  sys.exit(0)

def replay(msg):				# List of missing elements from finish.py
  replay_list = re.findall(r"\d+", msg)		# Pull all ints out of string
  for i in replay_list:
    try:
      k = int(i)
      msg = str(i) + " " + str(worklist[k])
      sender.send(str(msg))			# Resend missing elements from work list
    except:
      pass
  time.sleep(2)					# Allow worker process time. Increment for heavy work

def main():
  while True:
    stat = "FINISHED " + str(len(worklist))	# Send finished msg
    status.send(str(stat))

    socks = dict(poller.poll())

    # Waiting for controller commands
    if socks.get(controller) == zmq.POLLIN:	# Wait for kill or replay request
       message = controller.recv()
       if ( message == "KILL" ):
          print "Start: ", message
          break
       else:
          replay(message)

signal.signal(signal.SIGINT, quit)		# Register signal handlers to gracefully quit
signal.signal(signal.SIGHUP, quit)
signal.signal(signal.SIGTERM, quit)

work()
main()
