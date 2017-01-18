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
myset = [0,1,2,6,7,8,9,10,5,4]

context = zmq.Context()
sock = context.socket(zmq.PUSH)
sock.setsockopt(zmq.HWM, 1000000) 		# Flow control, max messages queued
control = context.socket(zmq.REQ)

def start_sockets(addresses):
  control.connect("tcp://127.0.0.1:5000")	# start control socket
  for arg in addresses:                 	# start data socket (fan out)
    sock.bind(arg)

def main():
  #for i in range(0,11):			# Send data to workers
  for i in myset:
    time.sleep(0.001)
    sock.send(str(i))
    print i
  
  msg = "Hello?"
  control.send(msg)
  print "Sending", msg
  msg_in = control.recv()
  print "Reply", msg_in

def quit(signum, frame):
    print " Received signal: %s" % (signum)
    sock.close()
    context.destroy()
    sys.exit(0)

# Register signal handlers to gracefully quit
signal.signal(signal.SIGINT, quit)
signal.signal(signal.SIGHUP, quit)
signal.signal(signal.SIGTERM, quit)

start_sockets(sys.argv[1:])
main()
