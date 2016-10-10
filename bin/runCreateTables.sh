#!/bin/bash 

stmt="set @user = '''$USER''@''localhost''';"

stmt="$stmt source createTables.sql;"

stmt="$stmt load data local infile '`pwd`/../data/aadCodes.csv' into table allowableDegrees
fields terminated by ',' enclosed by '\"';"

sudo mysql -u root -p -e "$stmt"