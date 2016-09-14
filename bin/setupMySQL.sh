#!/bin/bash

sudo apt-get install mysql-server
sudo mysqld start

mysql -u root -p 

# Within SQL: 
# create user $USER; 