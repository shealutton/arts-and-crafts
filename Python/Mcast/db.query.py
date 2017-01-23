from __future__ import print_function
import argparse
import sys
import time
import struct
import socket
import signal
import psycopg2


__author__ = "Shea Lutton, 2017"
__version__ = "1.0.0"
__email__ = "shealutton@gmail.com"

parser = argparse.ArgumentParser(description='Multicast Send/Receive')
parser.add_argument('-s', '--db_server', help='Database server hostname', required=True)
parser.add_argument('-d', '--database',  help='Database name', required=True)
parser.add_argument('-u', '--user',      help='Database user', required=True)
args = parser.parse_args()


def main():
    signal.signal(signal.SIGINT, quit)
    signal.signal(signal.SIGHUP, quit)
    query()


def query():
    conn = psycopg2.connect(host=args.db_server, dbname=args.database, user=args.user,
                            password="")
    cur = conn.cursor()
    cur.execute("SELECT id, t0, t1 FROM aurchi")
    data = cur.fetchall()
    for x in data:
        print(x[0], x[2] - x[1])


def quit(signum, frame):
    print(' Received exit signal. ')
    sys.exit(0)


if __name__ == '__main__':
    main()
