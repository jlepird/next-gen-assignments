#!/bin/bash

./hashPasswords.py ../data/test.csv

cmd="./psql/bin/psql $DATABASE_URL -c"

$cmd "truncate table users cascade;"
$cmd "\copy users from        '../data/users.csv.hash' csv;"
$cmd "\copy billetowners from '../data/owners.csv' csv;"
$cmd "\copy billetData from   '../data/out.csv' header csv;"
$cmd "\copy billetDescs from  '../data/outdescs.csv' header csv;"