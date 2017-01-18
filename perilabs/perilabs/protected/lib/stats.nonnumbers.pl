#!/usr/bin/perl -w
# Shea Lutton
use strict;

my $total = 0;
my $count = 0;
my $len = 0;
my $maxcount = 0;
my $max = "X";
my $min = "X";
my $mean = 0.0;
my $median = 0.0;
my $stddev = 0.0;
my $stderr = 0.0;
my (@array, @sorted, @buckets, %bucketvals);
my ($subvalue, $sigmaSubvalue, $range, $bucket, $multiplier, $bin_width);

while (<>) {
  chomp;
  next unless m/^[-+]?[0-9]*\.?([0-9]+)/; # only positive ints, negative ints, positive real, neg real
  push @array, $_;
  $len = length($1) if length($1) > $len;
  $count ++;
}
if ( $count == 0 ) { die "I need a column of numbers\n" }
print  "samples:     $count\n";
