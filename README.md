# Installation
```bash 
git clone git@github.com:maxboom/datetime.git .
```
```bash
docker-compose up -d
```
```bash 
docker-compose exec php-fpm bash
```
```bash 
composer install
```
```bash 
make install-database
```
```bash
php ./bin/console d:m:m
```

## First Task
1. Open http://localhost:92/datetime 
2. Fill the needed date 
3. Submit the form

## Second Task
Add cronjob with the command:
```bash
php ./bin/console app:generate-random-post --summary-title -p 1
```
