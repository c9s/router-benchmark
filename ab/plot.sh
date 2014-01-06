#!/bin/bash
TITLE="ab -n 3000 -c 50"
FILES=*.dat
for file in $FILES ; do
    ID=${file/.dat/}
if [[ ! -e "$ID.dat" ]] ; then
    echo "$ID.dat does not exist"
    exit 0
fi

cat <<DOC > plot.p
#!/usr/bin/env gnuplot

set terminal png
set output "$ID.png"

#set title "$TITLE"

#nicer aspect ratio for image size
set size 1,0.7

# y-axis grid
set grid y

#x-axis label
set xlabel "request"

#y-axis label
set ylabel "response time (ms)"

plot "$ID.dat" using 9 smooth sbezier with lines title "$ID"
DOC
gnuplot plot.p
done
