# catalog

Clone project and run

``` bash

# run docker images
docker-compose up -d

# install composer dependences
docker-compose run php composer install

# run database migrations
docker-compose run php php bin/console doctrine:migrations:migrate --no-interaction --allow-no-migration

# generate jwt keypair
docker-compose run php bin/console lexik:jwt:generate-keypair

```

API available on http://localhost:8018/.
Swagger available on http://localhost:8018/swagger/.
