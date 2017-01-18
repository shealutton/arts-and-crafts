from pcapfile import savefile
import argparse
import binascii

__author__ = "Shea Lutton, 2016"
__version__ = "1.0.0"
__email__ = "shealutton@gmail.com"


parser = argparse.ArgumentParser(description='Multicast Pcap Parser')
#parser.add_argument('-f', '--file',  help='Pcap file to open', required=True)
parser.add_argument('-f', '--file',  help='Pcap file to open')
args = parser.parse_args()


sequence_dict = {}  # format = key = seq, value = timestamp
if not args.file:
    testcap = open('/Users/shea/Desktop/CMT/Project2-XPM3/pcaps/mux/20161130.153835.001665773.pcap', 'rb')
else:
    testcap = open(args.file, 'rb')

capfile = savefile.load_savefile(testcap)
file_length = capfile.__length__()
for packet in range(0, file_length):
    pkt = capfile.packets[packet]
    data = binascii.b2a_qp(pkt.raw())
    strings = data.split()
    sequence = strings[-2].decode()
    if sequence not in sequence_dict:
        sequence_dict[sequence] = [pkt.timestamp, pkt.timestamp_us]
    else:
        # The sequence already exists, so it can just be subtracted. In 2016/11, datetime does not support nanoseconds.
        if pkt.timestamp_us > sequence_dict[sequence][1]:
            # the nano of T1 is greater than T0, simply subtract
            print('{0}, {1}'.format(pkt.timestamp_us - sequence_dict[sequence][1], sequence))
        else:  # the significant portions don't match, clock rolled over 1 sec or > 1 sec diff!
            print('WARN: T0:', sequence_dict[sequence][0], sequence_dict[sequence][1], 'T1', pkt.timestamp,
                  pkt.timestamp_us, sequence)

        sequence_dict.pop(sequence)


#print('SCRAPS START')
#for scraps in sorted(sequence_dict):
#    print(scraps, sequence_dict[scraps])
#print('SCRAPS END')
