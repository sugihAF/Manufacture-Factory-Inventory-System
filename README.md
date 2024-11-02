# Manufacture Inventory Management System

## How to Setup:
1. Initial Environment Development
```
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs
```
2. Rename .env.example to .env
3. Set folder Permission
```
 sudo chmod 777 -R .
```
5. Create Docker Container
```
 ./vendor/bin/sail up -d
```
6. Generate Key
```
 vendor/bin/sail artisan key:generate
```
Open
```
 localhost/login
```
