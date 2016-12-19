#!/bin/bash

#./hashPasswords.py ../data/test.csv

cmd="./psql/bin/psql $DATABASE_URL -c"

$cmd "truncate table users cascade;"
$cmd "\copy users from        '../data/users.csv.hash' csv;"
$cmd "\copy billetowners from '../data/owners.csv'     csv header;"
$cmd "\copy billetData from   '../data/out.csv'        csv header;"
$cmd "\copy billetDescs from  '../data/outdescs.csv'   csv header;"