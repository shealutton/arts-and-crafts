#! /usr/bin/perl
# v2.0 with bug fixes and speed fixes
use strict;

if (($#ARGV < 0 ) || ($#ARGV > 1)) {
    print STDERR "Usage: $0 filename";
    exit(-1);
}

my @times;
my $input_file = $ARGV[0];
my @text;
my $line;
if (!open(DUMPFILE, $input_file))
    {
    die "Can't open file: $input_file\n";
    }
@text = <DUMPFILE>;

foreach $line (@text)
   {
   chomp $line;
   #if ( $line =~ ( m/^\s+([0-9]+) (\d+-\d+-\d+) (..):(..):(.........) (\d+-\d+-\d+) (..):(..):(.........) (\d+-\d+-\d+) (..):(..):(.........)/ ))
   if ( $line =~ ( m/^([0-9]+) (\d+-\d+-\d+) (..):(..):(.........) (\d+-\d+-\d+) (..):(..):(.........) (\d+-\d+-\d+) (..):(..):(.........)/ ))
      {
      #print "$1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11, $12, $13\n";
      my $t0 = (3600*$3 + 60*$4 + $5);
      my $t1 = (3600*$7 + 60*$8 + $9);
      my $t2 = (3600*$11 + 60*$12 + $13);

      my ( $a, $b ) = ( 46, 193 );
      my $rand = (int( rand( $b - $a + 1 ) ) + $a)/1000000;
      my $time3 = ($13 + $rand);
      my $t3 = (3600*$11 + 60*$12 + $time3);

      my ( $x, $y ) = ( 0, 1 );
      my $random = int( rand( $y - $x + 1 ) ) + $x;
      my $new = ($rand + 0.00006);

      print "$1,$2 $3:$4:$5,$new,$6 $7:$8:$9,$random,0,$10 $11:$12:$13,$10 $11:$12:$time3,";
      #print "$10 $11:$12:$13, $10 $11:$12:$time3,   $t3, $t1,    ";
      printf( "%6f,", $t2 - $t0);
      printf( "%6f", $t3 + 0.417 - $t1);
      print "\n";
      }
   }
