from __future__ import print_function
import argparse
import sys
import time
import struct
import socket
import signal

__author__ = "Shea Lutton, 2016"
__version__ = "1.0.0"
__email__ = "shealutton@gmail.com"

parser = argparse.ArgumentParser(description='Multicast Send/Receive')
parser.add_argument('-a', '--address',  help='Multicast address', required=True)
parser.add_argument('-p', '--port',     help='Multicast port', required=True)
parser.add_argument('-r', '--receive',  help='Receive multicast data', action='store_true')
parser.add_argument('-s', '--send',     help='Send multicast data', action='store_true')
parser.add_argument('-t', '--turnaround', help='Receive mcast data, then resend it. '
                                               'Requires -b, -c.', action='store_true')
parser.add_argument('--return_address', help='A return multicast address to resend on')
parser.add_argument('--return_port',    help='A return multicast port to resend on')
parser.add_argument('-c', '--count',    help='Just count the packets received')
parser.add_argument('-i', '--interval', help='A sleep interval between packets. Default is 1 sec.')
parser.add_argument('-m', '--max',      help='Max count of packets, then exit')
parser.add_argument('-d', '--delta',     help='Subtract timestamp from now', action='store_true')
parser.add_argument('-x', '--interface',    help='Interface to send on')
args = parser.parse_args()

# Set global variables
address = args.address
port = int(args.port)
if args.interval:
    interval = float(args.interval)
else:
    interval = 1

if args.max:
    max = int(args.max)
else:
    max = 10000000  # 10 million packets

if args.delta:
    delta = True


def main():
    signal.signal(signal.SIGINT, quit)
    signal.signal(signal.SIGHUP, quit)

    if args.receive:
        receive()
    elif args.send:
        send()
    elif args.turnaround:
        if not args.return_address or not args.return_port:
            print('--return_address and --return_port are required to use the -t option.')
            sys.exit(1)
        turnaround()
    else:
        print('Either -r, -s, or -t is required. Exiting')
        sys.exit(1)


def turnaround():
    # Prep inbound sockets
    sock_in = socket.socket(socket.AF_INET, socket.SOCK_DGRAM, socket.IPPROTO_UDP)
    sock_in.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, 1)
    sock_in.bind(('', port))
    mreq_in = struct.pack("4sl", socket.inet_aton(address), socket.INADDR_ANY)
    sock_in.setsockopt(socket.IPPROTO_IP, socket.IP_ADD_MEMBERSHIP, mreq_in)

    # Prep outbound sockets
    address_info = socket.getaddrinfo(args.return_address, None)[0]
    sock_out = socket.socket(address_info[0], socket.SOCK_DGRAM)
    ttl = 16  # Set Time-to-live (optional)
    ttl_bin = struct.pack('@i', ttl)
    sock_out.setsockopt(socket.IPPROTO_IP, socket.IP_MULTICAST_TTL, ttl_bin)

    # Loop, printing any data we receive
    counter = 0
    while counter < max:
        data, sender = sock_in.recvfrom(64)
        sock_out.sendto(data, (args.return_address, int(args.return_port)))
        t1 = time.time()

        decoded = data.decode()
        sequence, t0 = decoded.split()
        print(sequence, '{0:.6f}'.format(t1 - float(t0)), t0, t1)
        counter += 1


def send():
    address_info = socket.getaddrinfo(args.address, None)[0]
    sock_out = socket.socket(address_info[0], socket.SOCK_DGRAM)
    ttl = 16      # Set Time-to-live (optional)
    ttl_bin = struct.pack('@i', ttl)
    sock_out.setsockopt(socket.IPPROTO_IP, socket.IP_MULTICAST_TTL, ttl_bin)
    if args.interface:
        sock_out.setsockopt(socket.IPPROTO_IP, socket.IP_MULTICAST_IF, socket.inet_aton(args.interface))

    counter = 0
    while counter < max:
        string = ' {0} {1:.6f}'.format(counter, time.time())
        sock_out.sendto(string.encode('utf-8'), (address, port))
        counter += 1
        time.sleep(interval)


def receive():
    sock = socket.socket(socket.AF_INET, socket.SOCK_DGRAM, socket.IPPROTO_UDP)
    sock.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, 1)
    sock.bind(('', port))
    mreq = struct.pack("4sl", socket.inet_aton(address), socket.INADDR_ANY)
    sock.setsockopt(socket.IPPROTO_IP, socket.IP_ADD_MEMBERSHIP, mreq)

    # Loop, printing any data we receive
    counter = 0
    while counter < max:
        data, sender = sock.recvfrom(64)
        t1 = time.time()
        decoded = data.decode()
        sequence, t0 = decoded.split()
        print(sequence, '{0:.6f} {1} {2:.6f}'.format(t1 - float(t0), t0, t1))
        counter += 1


def quit(signum, frame):
    print(" Received exit signal. ")
    sys.exit(0)


if __name__ == '__main__':
    main()
