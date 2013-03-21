#!/usr/bin/python

import zmq
context = zmq.Context()
socket = context.socket(zmq.REP)
socket.bind("tcp://127.0.0.1:5000")
 
while True:
    msg = str(socket.recv())
    print "Got", msg
    if ( str(msg) == "FINISHED" ):
       print "END"
       reply = "END"
       socket.send(reply)
       break
    else:
       reply = "ok"
       print "Sent: ", reply
       socket.send(reply)
