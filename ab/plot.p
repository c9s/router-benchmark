#!/usr/bin/env gnuplot

set terminal png
set output "ab_symfony.png"

#set title "ab -n 3000 -c 50"

#nicer aspect ratio for image size
set size 1,0.7

# y-axis grid
set grid y

#x-axis label
set xlabel "request"

#y-axis label
set ylabel "response time (ms)"

plot "ab_symfony.dat" using 9 smooth sbezier with lines title "ab_symfony"
