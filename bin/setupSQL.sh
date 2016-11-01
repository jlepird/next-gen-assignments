#!/bin/bash

curl https://s3.amazonaws.com/18f-cf-cli/psql-9.4.4-ubuntu-14.04.tar.gz | tar xvz

./psql/bin/psql $DATABASE_URL -f createTables.sql

./psql/bin/psql $DATABASE_URL -c "\copy coreCodes from '`pwd`/../data/coreCodes.csv' with CSV;"

./psql/bin/psql $DATABASE_URL -c "\copy allowableDegrees from '`pwd`/../data/aadCodes.csv' with CSV;"

./psql/bin/psql $DATABASE_URL -c "\copy acqLevels from '`pwd`/../data/acqCodes.csv' with CSV;"