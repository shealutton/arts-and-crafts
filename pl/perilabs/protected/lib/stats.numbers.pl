#!/usr/bin/perl -w
# Shea Lutton 2008
use strict;

my $tot = 0;
my $count = 0;
my $length = 0;
my $maxcount = 0;
my $range = 0;
my $max = "X";
my $min = "X";
my $mean = 0.0;
my $median = 0.0;
my $stddev = 0.0;
my $stderr = 0.0;
my (@array, @sorted, @buckets, %bucketvals);
my ($subvalue, $sigmaSubvalue, $bucket, $multiplier, $bin_width);

while (<>) {
  chomp;
  next unless m/^[-+]?[0-9]*\.?([0-9]+)/; # only positive ints, negative ints, positive real, neg real
  push @array, $_;
  $length = length($1) if length($1) > $length;
  $min = $_ if $min eq "X"; # init $min
  $max = $_ if $max eq "X"; # init $max
  $count ++;
  $tot += $_;
  $max = $_ if $_ > $max;
  $min = $_ if $_ < $min;
}
if ( $count == 0 ) { die "I need a column of numbers\n" }
$mean = $tot / $count;

my $r0001 = ( $count * .0001 ); 
my $r01   = ( $count * .01 );
my $r99   = ( $count * .99 );
my $r9999 = ( $count * .9999 );
my $f0001 = sprintf("%.0f", $r0001);
my $f01   = sprintf("%.0f", $r01);
my $f99   = sprintf("%.0f", $r99);
my $f9999 = sprintf("%.0f", $r9999);

# Create histogram buckets
if ( ! ( $min == $max )) {
   $range = $max - $min;
   $bin_width = $range/20;
   $multiplier = 1;
   $bucket = $min;
   while ($bucket < $max) {
      push (@buckets, $bucket);
      $bucket = $min + ($bin_width * $multiplier);
      $multiplier++;
   }

   foreach $bucket (@buckets) {
      $bucketvals{$bucket} = 0; # needed to init the histogram buckets
   }
   foreach (@array) { # iterate through the main array to prep stddev and stder and populate histogram
      $subvalue = (($_ - $mean)**2); # stddev prep
      $sigmaSubvalue += $subvalue; # stddev prep
      $maxcount = $maxcount+1 if $_ eq $max; # tally up the total samples = $max
      foreach $bucket (@buckets) {
         if (( $_ >= $bucket ) && ( $_ < $bucket+$bin_width )) { # this method excludes the $max sample from histogram (see $maxcount)
            $bucketvals{$bucket} ++ ;
         }
      }
   }
   $bucketvals{$min + ($bin_width * 19)} = $bucketvals{$min + ($bin_width * 19)}+$maxcount; # add $maxcount to the largest bucket for an accurate histogram
}
@sorted = sort{ $a <=> $b } @array; # Find the median
if ($tot % 2) { # if an even number
 $median = $sorted[$count/2];
} else { # if an odd number
 $median = ($sorted[$count/2] + $sorted[$count/2 - 1]) / 2;
}
if ($count > 1) {
	$stddev = (sqrt $sigmaSubvalue) / (sqrt ($count - 1));
	$stderr = ($stddev / (sqrt $count));
}

print  "samples:     $count\nmin:         $min\nmax:         $max\n";
printf ("range:       %.${length}f\n", $range);
printf ("sum:         %.${length}f\n", $tot);
printf ("mean:        %.${length}f\n", $mean);
printf ("median:      %.${length}f\n", $median);
printf ("std_dev:     %.${length}f\n", $stddev);
printf ("std_error:   %.${length}f\n", $stderr);
if ( $count > 999 ) { print "   00.01%:     $sorted[$f0001]\n"; }
if ( $count > 99 )  { print "   01.00%:     $sorted[$f01-1]\n"; }
if ( $count > 99 )  { print "   99.00%:     $sorted[$f99-1]\n"; }
if ( $count > 999 ) { print "   99.99%:     $sorted[$f9999-1]\n"; }

print  "Histogram: blah\n";
if ( ! ( $min == $max )) {
   foreach $bucket (@buckets) {
      printf("%10.${length}f: %-10d (%0.1f%%)\n",$bucket, $bucketvals{$bucket}, $bucketvals{$bucket}/$count*100);
   }
}
