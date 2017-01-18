import argparse
import time


parser = argparse.ArgumentParser(description='Multicast Pcap Parser')
parser.add_argument('-f', '--file',  help='Pcap file to open', required=True)
args = parser.parse_args()


FH = open(args.file, 'r')
#FH = open('/Users/shea/Desktop/CMT/Project2-XPM3/pcaps/replication/20161130/20161130.output.NoWARN.csv', 'r')

lines = FH.readlines()


previous = -1
for line in lines:
    words = line.split(',')
    if int(words[1]) == (previous + 1):  # The good state
        previous += 1
    else:
        print('GAP', words[0], int(words[1].strip()), previous, 'Delta:', (int(words[1].strip()) - previous))
        previous = int(words[1].strip())
        time.sleep(0.5)
