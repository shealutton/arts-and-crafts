#!/usr/bin/python

import zmq
context = zmq.Context()
socket = context.socket(zmq.REQ)
socket.connect("tcp://127.0.0.1:5000")

list = [1,2,3,4,"FINISHED"] 
for i in list:
    msg = "%s" % i
    socket.send(msg)
    print "Sending", msg
    msg_in = socket.recv()
    print "got: ", msg_in
