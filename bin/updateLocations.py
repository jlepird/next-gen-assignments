#!/usr/bin/python2

"""
This file uses python's geolocation tools to maintain a table, `locations` which yields the lat/lon coords of all locatiosn in the database. 
"""

import MySQLdb
from geopy.geocoders import Nominatim
import os 

# Connect to the database 
db = MySQLdb.connect(host   = "localhost",
                     user   = os.environ['USER'],         
                     passwd = "", 
                     db     = "nextGen")

cur = db.cursor()

# Clear anything currently in the table 
cur.execute("truncate table locations;")

# Get unique locations that we can look up 
cur.execute("select distinct val from billetData where tkey = 'location';") 
res = cur.fetchall()

# Init geolocator object 
geolocator = Nominatim() 

# For each unique location
for row in res:

	# Look up the location 
	loc = geolocator.geocode(row[0])

	# Add the lat/lon into the sql table  
	cmd = "insert into locations values ('%s', %.10f, %.10f);" % (row[0], loc.latitude, loc.longitude)
	# print cmd # for debug 
	
	# Execute the command and flush the database 
	cur.execute(cmd)
	db.commit()

# Complete, close connection and exit. 
cur.close()
db.close()