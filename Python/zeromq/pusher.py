#!/usr/bin/python

import sys
import time
import zmq

context = zmq.Context()
sock = context.socket(zmq.PUSH)
sock.bind(sys.argv[1])

while True:
    time.sleep(1)
    sock.send(sys.argv[1] + ':' + time.ctime())
