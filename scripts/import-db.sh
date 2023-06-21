#!/usr/bin/env bash

# Variables from .env file
HOST=$(grep PROD_HOST website/.env | head -1 | cut -d '=' -f2)
USER=$(grep PROD_USER website/.env | head -1 | cut -d '=' -f2)
DATABASE_HOST=$(grep DATABASE_PROD_HOST website/.env | head -1 | cut -d '=' -f2)
DATABASE_NAME=$(grep DATABASE_PROD_NAME website/.env | head -1 | cut -d '=' -f2)
DATABASE_USER=$(grep DATABASE_PROD_USER website/.env | head -1 | cut -d '=' -f2)
DATABASE_PASSWORD=$(grep DATABASE_PROD_PASSWORD website/.env | head -1 | cut -d '=' -f2)
CURRENT_DATABASE_USER=$(grep DATABASE_USER website/.env | head -1 | cut -d '=' -f2)
CURRENT_DATABASE_PASSWORD=$(grep DATABASE_PASSWORD website/.env | head -1 | cut -d '=' -f2)
CURRENT_DATABASE_NAME=$(grep DATABASE_NAME website/.env | head -1 | cut -d '=' -f2)
DB_FILE=export-$(date +%y%m%d_%H%M%S).sql

# Import db in prod server
ssh ${USER}@${HOST} "mysqldump --host=${DATABASE_HOST} --user=${DATABASE_USER} --password=${DATABASE_PASSWORD} --single-transaction --routines --no-tablespaces ${DATABASE_NAME} > ${DB_FILE}"

# Copy this file on current machine
scp ${USER}@${HOST}:${DB_FILE} exports

# put the sql in own database
mysql -u ${CURRENT_DATABASE_USER} -p ${CURRENT_DATABASE_NAME} < exports/${DB_FILE}

# Replace wordpress uris for local website

# Delete the file on prod server
ssh ${USER}@${HOST} "rm ${DB_FILE}"