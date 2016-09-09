#!/bin/bash

cd .. 

while true; do 
sleep 60
git pull > /dev/null
echo `date` > ../lastUpdated.txt
done