#!/bin/bash 

stmt="set @user = '''$USER''@''localhost''';"

stmt="$stmt source createTables.sql;"

stmt="$stmt load data local infile '`pwd`/../data/aadCodes.csv' into table allowableDegrees
fields terminated by ',' enclosed by '\"';"

stmt="$stmt load data local infile '`pwd`/../data/acqCodes.csv' into table acqLevels
fields terminated by ',';"

stmt="$stmt load data local infile '`pwd`/../data/coreCodes.csv' into table coreCodes
fields terminated by ','; delete from coreCodes where txt like '%RESERVE%' or right(txt, 4) = 'HIST';"

sudo mysql --local-infile -u root -p -e "$stmt"

./updateLocations.py