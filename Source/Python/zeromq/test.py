#!/usr/bin/python

import sys
import time
import zmq

context = zmq.Context()
sock = context.socket(zmq.PUSH)
sock.bind(sys.argv[1])
#sock.connect(sys.argv[1])

while True:
    sock.send(time.ctime())
