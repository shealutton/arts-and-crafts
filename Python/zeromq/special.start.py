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

list = range(0,100)
finished = False
context = zmq.Context()
sock = context.socket(zmq.PUSH)
sock.setsockopt(zmq.HWM, 10000)                 # Flow control, max messages queued
control = context.socket(zmq.PUB)
response = context.socket(zmq.SUB)
poller = zmq.Poller()
poller.register(response, zmq.POLLIN)

### DEF
def start_sockets(addresses):
  control.connect("tcp://127.0.0.1:5000")	# start control socket   
  response.bind("tcp://127.0.0.1:5001")
  for arg in addresses:                 	# start data socket (fan out)
    sock.bind(arg)

def main():
    socks = dict(poller.poll())

    if response in socks and socks[response] == zmq.POLLIN:
        message = control.recv()
        reply = control_handler(message)
        control.send(reply)

    for i in list:                      # Send data to workers
      time.sleep(0.01)
      sock.send(str(i))


def control_handler(reply):
    if ( reply == "FINISHED" ):		# If start.py and finish.py agree we are done
      print "Response: ", reply
      quit(1,1)				# Then quit. 
    else:
      print "Response: ", reply		# Otherwise, resend missing packets

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
