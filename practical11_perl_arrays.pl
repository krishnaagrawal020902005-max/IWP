#!/usr/bin/perl
use strict;
use warnings;

# ================================================================
#  PRACTICAL 11 — PERL ARRAYS
#  Run: perl practical11_perl_arrays.pl
# ================================================================

print "=" x 55 . "\n";
print "       PRACTICAL 11 — PERL ARRAY OPERATIONS\n";
print "=" x 55 . "\n\n";

# ---------------------------------------------------------------
# 1. Basic Array Declaration & Initialization
# ---------------------------------------------------------------
print "[ 1 ] Array Declaration & Initialization\n";
print "-" x 40 . "\n";

my @fruits  = ("Mango", "Banana", "Apple", "Grapes", "Orange");
my @numbers = (10, 25, 7, 89, 42, 63, 18, 55);
my @mixed   = ("IWP", 2025, "Perl", 3.14, "Arrays");

print "Fruits   : @fruits\n";
print "Numbers  : @numbers\n";
print "Mixed    : @mixed\n";
print "Length of fruits array: ", scalar(@fruits), "\n\n";


# ---------------------------------------------------------------
# 2. Accessing Elements
# ---------------------------------------------------------------
print "[ 2 ] Accessing Array Elements\n";
print "-" x 40 . "\n";

print "First element  : $fruits[0]\n";
print "Last element   : $fruits[-1]\n";
print "Third element  : $fruits[2]\n";
print "Slice [1..3]   : @fruits[1..3]\n\n";


# ---------------------------------------------------------------
# 3. push, pop, shift, unshift
# ---------------------------------------------------------------
print "[ 3 ] push / pop / shift / unshift\n";
print "-" x 40 . "\n";

my @stack = (1, 2, 3, 4, 5);
print "Original : @stack\n";

push @stack, 99;
print "After push(99)   : @stack\n";

my $popped = pop @stack;
print "After pop        : @stack  [popped: $popped]\n";

my $shifted = shift @stack;
print "After shift      : @stack  [shifted: $shifted]\n";

unshift @stack, 100;
print "After unshift(100): @stack\n\n";


# ---------------------------------------------------------------
# 4. Sorting
# ---------------------------------------------------------------
print "[ 4 ] Sorting Arrays\n";
print "-" x 40 . "\n";

my @sorted_fruits = sort @fruits;
print "Fruits (sorted A-Z)  : @sorted_fruits\n";

my @rev_fruits = reverse sort @fruits;
print "Fruits (sorted Z-A)  : @rev_fruits\n";

my @sorted_nums = sort { $a <=> $b } @numbers;
print "Numbers (ascending)  : @sorted_nums\n";

my @desc_nums = sort { $b <=> $a } @numbers;
print "Numbers (descending) : @desc_nums\n\n";


# ---------------------------------------------------------------
# 5. grep (filter) and map (transform)
# ---------------------------------------------------------------
print "[ 5 ] grep and map\n";
print "-" x 40 . "\n";

my @big = grep { $_ > 40 } @numbers;
print "Numbers > 40     : @big\n";

my @even = grep { $_ % 2 == 0 } @numbers;
print "Even numbers     : @even\n";

my @doubled = map { $_ * 2 } @numbers;
print "Doubled values   : @doubled\n";

my @upper_fruits = map { uc($_) } @fruits;
print "Fruits uppercase : @upper_fruits\n\n";


# ---------------------------------------------------------------
# 6. splice
# ---------------------------------------------------------------
print "[ 6 ] splice — Insert / Remove\n";
print "-" x 40 . "\n";

my @letters = ('a'..'h');
print "Original : @letters\n";

my @removed = splice(@letters, 2, 3);
print "After splice(2,3) removed: @removed\n";
print "Remaining : @letters\n";

splice(@letters, 2, 0, 'X', 'Y', 'Z');
print "After inserting X Y Z at index 2: @letters\n\n";


# ---------------------------------------------------------------
# 7. Multidimensional Array (Array of Arrays)
# ---------------------------------------------------------------
print "[ 7 ] Multidimensional Array (Matrix)\n";
print "-" x 40 . "\n";

my @matrix = (
    [1, 2, 3],
    [4, 5, 6],
    [7, 8, 9],
);

print "Matrix:\n";
for my $row (@matrix) {
    print "  ";
    for my $val (@$row) {
        printf "%4d", $val;
    }
    print "\n";
}

# Transpose
print "\nTransposed Matrix:\n";
for my $c (0..2) {
    print "  ";
    for my $r (0..2) {
        printf "%4d", $matrix[$r][$c];
    }
    print "\n";
}
print "\n";


# ---------------------------------------------------------------
# 8. Array Statistics
# ---------------------------------------------------------------
print "[ 8 ] Array Statistics\n";
print "-" x 40 . "\n";

my $sum = 0;
$sum += $_ for @numbers;
my $count = scalar @numbers;
my $avg   = $sum / $count;
my $max   = (sort { $b <=> $a } @numbers)[0];
my $min   = (sort { $a <=> $b } @numbers)[0];

printf "Array  : @numbers\n";
printf "Count  : %d\n", $count;
printf "Sum    : %d\n", $sum;
printf "Average: %.2f\n", $avg;
printf "Max    : %d\n", $max;
printf "Min    : %d\n\n", $min;


# ---------------------------------------------------------------
# 9. join and split
# ---------------------------------------------------------------
print "[ 9 ] join and split\n";
print "-" x 40 . "\n";

my $joined = join(", ", @fruits);
print "Joined  : $joined\n";

my $csv = "HTML,CSS,JavaScript,PHP,MySQL";
my @techs = split(/,/, $csv);
print "Split   : @techs\n";
print "Count   : ", scalar(@techs), " items\n\n";


# ---------------------------------------------------------------
# 10. Unique elements using a hash
# ---------------------------------------------------------------
print "[ 10 ] Remove Duplicates\n";
print "-" x 40 . "\n";

my @with_dups = (1, 5, 3, 2, 5, 1, 7, 3, 8, 2);
my %seen;
my @unique = grep { !$seen{$_}++ } @with_dups;
print "With duplicates : @with_dups\n";
print "Unique elements : @unique\n\n";

print "=" x 55 . "\n";
print "       END OF PRACTICAL 11\n";
print "=" x 55 . "\n";
