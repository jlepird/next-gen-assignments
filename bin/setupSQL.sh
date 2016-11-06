#!/bin/bash

# Download the psql binary 
curl https://s3.amazonaws.com/18f-cf-cli/psql-9.4.4-ubuntu-14.04.tar.gz | tar xvz

psql="./psql/bin/psql"

# Run the commands to initialize the database
$psql $DATABASE_URL -f createTables.sql

$psql $DATABASE_URL -c "\copy coreCodes from '`pwd`/../data/coreCodes.csv' with CSV;"

$psql $DATABASE_URL -c "\copy allowableDegrees from '`pwd`/../data/aadCodes.csv' with CSV;"

$psql $DATABASE_URL -c "\copy acqLevels from '`pwd`/../data/acqCodes.csv' with CSV;"

$psql $DATABASE_URL -c "delete from coreCodes where txt like '%RESERVE%' or right(txt, 4) = 'HIST';"
