#!/usr/bin/python

import time
import signal
import sys

def main():
   while True:
      print "scrape_me_bro"
      time.sleep(1)

def quit(signum, frame):
   print "Received signal: %s" % (signal)
   sys.exit(0)

# Register reload_libs to be called on restart
signal.signal(signal.SIGINT, quit)
signal.signal(signal.SIGHUP, quit)

# Main
main()

