#!/bin/bash 

stmt="set @user = '''$USER''@''localhost''';"

stmt="$stmt source createTables.sql;"

stmt="$stmt load data local infile '`pwd`/../data/aadCodes.csv' into table allowableDegrees
fields terminated by ',' enclosed by '\"';"

stmt="$stmt load data local infile '`pwd`/../data/acqCodes.csv' into table acqLevels
fields terminated by ',';"

sudo mysql --local-infile -u root -p -e "$stmt"

./updateLocations.py