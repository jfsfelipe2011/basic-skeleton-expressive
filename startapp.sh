#!/bin/bash
echo "Setando UID"
export UID=$UID;

echo "Permissões para configs"
chmod 777 -R config/nginx

echo "Subindo container com docker-compose";
docker-compose up -d