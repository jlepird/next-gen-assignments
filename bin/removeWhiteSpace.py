#!/usr/bin/python2

import sys

with open(sys.argv[1], "r") as fIn, open(sys.argv[1] + ".clean", "w") as fOut:
    for line in fIn:
        spl = line.split(",")
        for i in range(len(spl)):
            spl[i] = spl[i].strip()
        fOut.write(",".join(spl))
        fOut.write("\n")