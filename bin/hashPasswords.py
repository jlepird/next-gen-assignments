#!/usr/bin/python2

from hashlib import md5
import sys
from random_words import RandomWords
from random import randrange

if len(sys.argv) != 2:
	raise Exception("Expecting one argument: the input CSV file to process")

rw = RandomWords()

with open(sys.argv[1], "r") as fIn, open(sys.argv[1] + ".passwords", "w") as pwOut, open(sys.argv[1] + ".hash", "w") as hashOut:
	for line in fIn:
		line = line.rstrip() 
		spl = line.split(",")

		if len(spl) != 5:
			raise Exception("Error on line %s" % line)

		password = ""
		while len(password) < 10:
			password += rw.random_word()
		password = password + str(randrange(0,999))

				
		spl.insert(2, password)
		pwOut.write(",".join(spl))
		pwOut.write("\n")
		spl[2] = md5(spl[2]).hexdigest()
		hashOut.write(",".join(spl))
		hashOut.write("\n")

