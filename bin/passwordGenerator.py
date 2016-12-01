#!/usr/bin/python2

from hashlib import md5
import sys

if len(sys.argv) != 3:
	raise Exception("Need two arguments: infile and outfile.")

with open(sys.argv[1], "r") as fIn, open(sys.argv[2], "w") as fOut:
	for line in fIn:
		line = line.rstrip() 
		spl = line.split(",")

		if len(spl) != 5:
			raise Exception("Error on line %s" % line)

		spl[2] = md5(spl[2]).hexdigest()
		fOut.write(",".join(spl))
		fOut.write("\n")

