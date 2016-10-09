#!/bin/bash 

stmt="source createTables.sql;"

stmt="$stmt load data infile '`pwd`/../data/aadCodes.csv' into table allowableDegrees
fields terminated by ',' enclosed by '\"';"

echo $stmt

sudo mysql -u root -e "$stmt"