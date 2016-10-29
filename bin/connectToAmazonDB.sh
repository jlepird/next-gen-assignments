#!/bin/bash

# mysql \
# 	-h af-assignments-db.c2snv5bhsvbv.us-east-1.rds.amazonaws.com \
# 	-P 3306 -u a9 -p

mysql \
	-h awsbroker-mysql-1.ch0moygcdwsl.us-east-1.rds.amazonaws.com \
	-P 3306 -u 0e3vf0f1acpzo04rs3jaf5dbt -pupvughzf3jytyuwr

# {
#  "VCAP_SERVICES": {
#   "aws-rds": [
#    {
#     "credentials": {
#      "db_name": "dbq7n8s29k0ymgeyq",
#      "host": "awsbroker-mysql-1.ch0moygcdwsl.us-east-1.rds.amazonaws.com",
#      "password": "0e3vf0f1acpzo04rs3jaf5dbt",
#      "port": "3306",
#      "uri": "mysql://upvughzf3jytyuwr:0e3vf0f1acpzo04rs3jaf5dbt@awsbroker-mysql-1.ch0moygcdwsl.us-east-1.rds.amazonaws.com:3306/dbq7n8s29k0ymgeyq",
#      "username": "upvughzf3jytyuwr"
#     },
#     "label": "aws-rds",
#     "name": "nextgen",
#     "plan": "shared-mysql",
#     "provider": null,
#     "syslog_drain_url": null,
#     "tags": [
#      "database",
#      "RDS",
#      "postgresql",
#      "mysql"
#     ],
#     "volume_mounts": []
#    }
#   ]
#  }
# }
