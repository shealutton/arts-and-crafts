#!/usr/bin/python
# A pipeline model, always push data downstream. Start -> Middle -> Finish
# Messages are load balanced across all downstream subscribers
# Run with args ~ tcp://*:8080

# ./start.py tcp://*:8080
# ./middle.py tcp://localhost:8080 tcp://*:8081
# ./middle.py tcp://localhost:8080 tcp://*:8082
# ./middle.py tcp://localhost:8080 tcp://*:8083
# ./finish.py tcp://localhost:8081 tcp://localhost:8082 tcp://localhost:8083

import sys
import time
import zmq
import signal

list = range(0,1000)
finished = False
context = zmq.Context()
sock = context.socket(zmq.PUSH)
sock.setsockopt(zmq.HWM, 10000)                 # Flow control, max messages queued
control = context.socket(zmq.REQ)

### DEF
def start_sockets(addresses):
  control.connect("tcp://127.0.0.1:5000")	# start control socket
  for arg in addresses:                 	# start data socket (fan out)
    sock.bind(arg)

def main():
  while ( finished == False ):
    for i in list:			# Send data to workers
      time.sleep(0.001)
      sock.send(str(i))
      test = "BS " + str(i) 
      control.send(test)
  
    while True:                         # Check for control msgs
      msg = "DONE " + str(len(list))
      control.send(msg)
      print "Sending:", msg

      try:
        control_handler(control.recv(zmq.NOBLOCK))
      except zmq.ZMQError:
        pass
      time.sleep(1)

def control_handler(reply):
    if ( reply == "FINISHED" ):		# If start.py and finish.py agree we are done
      print "Response: ", reply
      quit(1,1)				# Then quit. 
    else:
      print reply			# Otherwise, resend missing packets
      for i in reply:
        sock.send(i)

def quit(signum, frame):
    sock.close()
    control.close()
    context.destroy()
    sys.exit(0)

# Register signal handlers to gracefully quit
signal.signal(signal.SIGINT, quit)
signal.signal(signal.SIGHUP, quit)
signal.signal(signal.SIGTERM, quit)

start_sockets(sys.argv[1:])
main()
print "leaving"
