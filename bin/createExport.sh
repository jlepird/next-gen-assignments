#!/bin/bash

# Get configuration data about the instance we have running
guid=`cf app af-talent-marketplace --guid`
pw=`cf ssh-code`

# Determine the file we're going to ouput
DATE=`date`
timeStamp=`date -d"$DATE" +%Y%m%d%H%M%S`
fName="export_$timeStamp.pg"

# Prompt user for password
echo "Password = "
echo $pw

# Run the backup command in the cloud
cf ssh af-talent-marketplace -c "./app/bin/psql/bin/pg_dump --format=custom \$DATABASE_URL > app/data/$fName"

# Download the backup file-- prompts user for above password
sftp -P 2222 cf:$guid/0@ssh.fr.cloud.gov:app/data/$fName

# Uploads the database locally 
pg_restore --clean --no-owner --no-acl --dbname=$DATABASE_URL $fName

# Saves the old data to ./data./
mv $fName ../data/