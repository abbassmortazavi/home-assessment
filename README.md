<p align="center"><a href="https://laravel.com" target="_blank"></a> Create Restfull with API Platform




## Services
- Nginx
- Docker
- Postgres
- PHP(8.3)
- Pgadmin
- Composer
- Redis
- Symfony 7.1
- JWT For Authentication


## Clone Project
```sh
- First of All Clone Project From bottom url : 
  https://github.com/abbassmortazavi/home-assessment.git
After clone, in root project in command line run this command before migrate : 
  cp .env.example .env
```



## Installation
```sh
- Install All Container Run These Command : 
  docker-compose up --build
  docker-compose up -d

- Down All Container Use this Command :
  docker-compose down
```

## Composer update or Install
```sh
docker-compose exec -it php bash
 composer i
 composer u
```

## Run Migration And Seed
```sh
docker-compose exec -it php bash
   php bin/console doctrine:database:create
```

## Run Project for test Api
```sh
like this : http://localhost:8082
this is my localhost in my system.
sample : http://localhost:8082/api/login_check
```

## Config Redis
```sh
This Project Use Redis For Caching and also handel queue with redis.
After All container up you can access redis-commander with this url :
 like this: http://localhost:8085
```


## Api Test
```sh
 php artisan test
```