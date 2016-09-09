#!/bin/bash

# This file connects to the AWS server that we're using. 

# Before you run this file, you need to upload the file "nextGenKey.pem" and 
# move it to the directory "$HOME/.ssh/", ie. run 'mv nextGenKey.pem ~/.ssh/'

ssh -i "$HOME/.ssh/nextGenKey.pem" ubuntu@ec2-107-20-100-141.compute-1.amazonaws.com