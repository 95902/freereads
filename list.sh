#!/bin/bash

# Charger les variables d'environnement
source ./.env.local

# Configuration du profil du client S3
aws configure set aws_access_key_id $S3_ACCESS_KEY_ID --profile backup
aws configure set aws_secret_access_key $S3_SECRET_ACCESS_KEY --profile backup
aws configure set default.region $S3_REGION --profile backup

# Créer un répertoire pour les logs s'il n'existe pas
mkdir -p ./var/log

# Définir le format de la date et du nom du fichier de log
DATE=$(date +%Y%m%d_%H%M%S)
LOG_FILE="./var/log/list_backup_$DATE.log"

# Démarrer le log
echo "$DATE: Début de la liste des sauvegardes" >> $LOG_FILE

# Liste des objets dans le bucket S3
echo "$DATE: Liste des objets dans le bucket S3" >> $LOG_FILE
aws s3 ls s3://$S3_BUCKET_NAME/ --profile backup --endpoint-url $S3_ENDPOINT_URL >> $LOG_FILE
echo "$DATE: Fin de la liste des objets dans le bucket S3" >> $LOG_FILE

# Finalisation du log
echo "$DATE: Fin de la liste des sauvegardes" >> $LOG_FILE
