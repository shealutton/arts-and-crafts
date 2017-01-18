#!/usr/bin/python

import zmq
import sys
import signal

context = zmq.Context()

# Socket to receive messages on
receiver = context.socket(zmq.PULL)
receiver.connect("tcp://10.10.1.103:5557")

# Socket to send messages to
sender = context.socket(zmq.PUSH)
sender.connect("tcp://10.10.1.103:5558")

# Socket for control input
controller = context.socket(zmq.SUB)
controller.connect("tcp://10.10.1.103:5559")
controller.setsockopt(zmq.SUBSCRIBE, "")

# Process messages from receiver and controller
poller = zmq.Poller()
poller.register(receiver, zmq.POLLIN)
poller.register(controller, zmq.POLLIN)

### Define work/computations here:
def work(input):					# Simple work sample
   subkey, subvalue = str.split(input)			# Square the number
   answer = int(subvalue) * int(subvalue)
   return subkey, answer				# Return the key and answer

def quit(signum, frame):                        # Quit gracefully and close sockets
  print " Received signal: %s" % (signum)
  receiver.close()
  sender.close()
  controller.close()
  context.destroy()
  sys.exit(0)

def main():
  while True:						# Process messages from both sockets
    socks = dict(poller.poll())

    if socks.get(receiver) == zmq.POLLIN:		# Listen for data msg
        message = receiver.recv()
        try:						# Process task
           key, value = work(message)			# Do some work, prep response
           msg = str(key) + " " + str(value)
           sender.send(msg)				# Pass results on
        except:
           print "Middle says, 'Bad message: ", message
           pass

    if socks.get(controller) == zmq.POLLIN:		# Listen for control msg
       message = controller.recv()
       if ( message == "KILL" ):			# If kill signal, exit
          print "Middle: ", message
          break
       else:
          pass

signal.signal(signal.SIGINT, quit)              # Register signal handlers to gracefully quit
signal.signal(signal.SIGHUP, quit)
signal.signal(signal.SIGTERM, quit)

main()
