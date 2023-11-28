
How its look https://youtu.be/s1eY40CB0bQ

run container
```bash
docker-compose -f docker/docker-compose.yml down
docker kill $(docker ps -q)
docker-compose --env-file ./.env -f docker/docker-compose.yml up --build
```

composer install 
```bash
docker exec -it mysite sudo -u www-data composer install
```

enter to container
```bash
docker exec -it mysite bash
```
