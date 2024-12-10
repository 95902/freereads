#!/bin/bash

# Charger les variables d'environnement
source ./.env.local

# Configuration du profil du client S3
aws configure set aws_access_key_id $S3_ACCESS_KEY_ID --profile backup
aws configure set aws_secret_access_key $S3_SECRET_ACCESS_KEY --profile backup
aws configure set default.region $S3_REGION --profile backup

# Définir le format de la date et du nom de fichier
DATE=$(date +%Y%m%d_%H%M%S)
FILE_NAME="db_backup_$DATE.sql.gpg"

# Créer un répertoire pour les logs s'il n'existe pas
mkdir -p ./var/log

# Démarrer le log
LOG_FILE="./var/log/backup_$DATE.log"
echo "$DATE: Début du backup" >> $LOG_FILE

# Exporter le mot de passe PG
export PGPASSWORD=$DB_PASSWORD

# Dump et compression de la base de données
echo "$DATE: Début du dump de la base de données" >> $LOG_FILE
pg_dump -h $DB_HOST -p $DB_PORT -U $DB_USERNAME -F c -b -v -f "db_backup_$DATE.sql" $DB_NAME
echo "$DATE: Fin du dump de la base de données" >> $LOG_FILE

# Chiffrer le fichier dump
echo "$DATE: Début du chiffrement du fichier dump" >> $LOG_FILE
gpg --batch --yes --passphrase "$GPG_PASSPHRASE" --symmetric --cipher-algo AES256 "db_backup_$DATE.sql"
echo "$DATE: Fin du chiffrement du fichier dump" >> $LOG_FILE

# Upload vers S3
echo "$DATE: Début de l'upload vers S3" >> $LOG_FILE
aws s3 cp "db_backup_$DATE.sql.gpg" s3://$S3_BUCKET_NAME/$FILE_NAME --profile backup --endpoint-url $S3_ENDPOINT_URL
echo "$DATE: Fin de l'upload vers S3" >> $LOG_FILE

# Suppression du fichier dump local
echo "$DATE: Début de la suppression du fichier dump local" >> $LOG_FILE
rm "db_backup_$DATE.sql" "db_backup_$DATE.sql.gpg"
echo "$DATE: Fin de la suppression du fichier dump local" >> $LOG_FILE

# Finalisation du log
echo "$DATE: Fin du backup" >> $LOG_FILE

# Désactivation de l'export PGPASSWORD
unset PGPASSWORD
