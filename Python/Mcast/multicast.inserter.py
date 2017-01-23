from __future__ import print_function
import argparse
import sys
import time
import struct
import socket
import signal
import psycopg2


__author__ = "Shea Lutton, 2016"
__version__ = "1.0.0"
__email__ = "shealutton@gmail.com"

parser = argparse.ArgumentParser(description='Multicast Send/Receive')
parser.add_argument('-a', '--address',  help='Multicast address', required=True)
parser.add_argument('-p', '--port',     help='Multicast port', required=True)
parser.add_argument('-s', '--db_server', help='Database server hostname', required=True)
parser.add_argument('-d', '--database',  help='Database name', required=True)
parser.add_argument('-u', '--user',      help='Database user', required=True)
args = parser.parse_args()

# Set global variables
address = args.address
port = int(args.port)


def main():
    signal.signal(signal.SIGINT, quit)
    signal.signal(signal.SIGHUP, quit)
    receive()


def receive():
    conn = psycopg2.connect(host=args.db_server, dbname=args.database, user=args.user,
                            password="")
    cur = conn.cursor()

    sock = socket.socket(socket.AF_INET, socket.SOCK_DGRAM, socket.IPPROTO_UDP)
    sock.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, 1)
    sock.bind(('', port))
    mreq = struct.pack("4sl", socket.inet_aton(address), socket.INADDR_ANY)
    sock.setsockopt(socket.IPPROTO_IP, socket.IP_ADD_MEMBERSHIP, mreq)

    sql = 'INSERT INTO aurchi (id, t0, t1) VALUES (%s, %s, %s)'
    # Loop, inserting any data we receive
    while True:
        data, sender = sock.recvfrom(64)
        t1 = time.time()
        decoded = data.decode()
        sequence, t0 = decoded.split()
        #print(data, sequence, t0, t1)
        cur.execute(sql, (sequence, t0, t1))
        conn.commit()


def quit(signum, frame):
    print(' Received exit signal. ')
    sys.exit(0)


if __name__ == '__main__':
    main()
