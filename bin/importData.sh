#!/bin/bash

cmd="./psql/bin/psql $DATABASE_URL -c"

$cmd "truncate table users cascade;"
$cmd "truncate table billetDescs cascade;"
$cmd "truncate table officers cascade;"
$cmd "\copy users from        '../data/users.csv.hash' csv;"
$cmd "\copy billetDescs from  '../data/outdescs.csv'   csv header;"
$cmd "\copy billetOwners from '../data/owners.csv'     csv header;"
$cmd "\copy billetData from   '../data/out.csv'        csv header;"
$cmd "\copy officers from '../data/DASHBOARD_DATA.csv' csv header;"

$cmd "truncate table surfs cascade;"
for surf in ../data/surfs/*.html
do
	let oid=`echo $surf | grep -o '[0-9]*'`
	sed -i "s/'/\"/g" $surf 
	$cmd "insert into surfs values ($oid, '`cat $surf`');"
done 