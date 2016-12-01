#!/bin/bash

./passwordGenerator.py ../data/users.csv ../data/users2.csv

cmd="./psql/bin/psql $DATABASE_URL -c"

$cmd "truncate table users cascade;"
$cmd "\copy users from '../data/users2.csv' csv;"
$cmd "\copy billetowners from '../data/owners.csv' header csv;"
$cmd "\copy billetData from '../data/out.csv' header csv;"
$cmd "\copy billetDescs from '../data/outdescs.csv' header csv;"