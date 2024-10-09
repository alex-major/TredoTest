# Tredo test task

## prerequisites

1. Docker
2. Download firebase credentials file
3. Create environnement file

### Docker

#### Linux installation

> sudo apt update \
> sudo apt upgrade \
> sudo apt install docker docker-compose

#### Windows installation

> download Docker Desktop from [docker.com](https://www.docker.com) \
> run file "Docker Desktop install.exe"

#### MacOS intallation

>  brew install docker

### Download firebase credentials file

1. Open\create firebase project in [console](https://console.firebase.google.com)
2. Go to *Service account* tab in *Project settings* page
3. Click on *Generate new private key* button
4. After download rename file to *firebase_creadentials.json* and copy to project root directory

### Create environnement file

1. Rename file .env.example to .env
2. Open file .env and typing database settings

> DB_HOST database server address \
> DB_USERNAME database user login \
> DB_PASSWORD database user password

## Run project

> docker-compose run

# Create filament user

> docker-compose exec app php /var/www/artisan make:filament-user

1. Type user name
2. Type user email
3. Type user password

## Create test data

> docker-compose exec app php /var/www/artisan db:seed

## Run tests

> docker-compose exec app php /var/www/artisan test

**WARNING! for testing change database setting to test environnement settings**