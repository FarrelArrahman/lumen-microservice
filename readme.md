# Microservice Lumen - DevOps 
![](https://img.shields.io/badge/version-1.5.5--beta-green.svg)
![](https://img.shields.io/badge/docker--compose-build-blue.svg)
![](https://img.shields.io/badge/docker-build-blue.svg)

### Let's go
**Develop env**

    /*only first time*/
    chmod +x ./develop.sh 
    ./develop.sh -s
    
    /*utility*/
    ./develop.sh -b 
    ./develop.sh -u
    ./develop.sh -r
    ./develop.sh -d
    ./develop.sh -c "exec name bash (name = one of workspace, redis, mysql or nginx"
    ./develop.sh -c "exec workspace composer update"
    ./develop.sh -c "run redis-cli"
    
     ./develop.sh --help
    -s
      Setup application use it only first time, create volumes and make workdir setup
    -b
      Build all container of docker-compose file
    -u
      Up all container of docker-compose file with -d mode
    -r
      Build and up all container
    -d
      Down all container started
    -c
      Allows to use all the docker-compose commands. (The commands that you want to launch must be contained between " ")
      Example:
       ./develop.sh -c "up -d"
       ./develop.sh -c "build --no-cache"
       
    /*If use normal commands*/
    cd docker-compose
    docker-compose ...
       
**Production env**
    
    docker build --tag microservice-lumen .
    docker run -d -p 9000:9000 --name name-of-container -it microservice-lumen /bin/bash
    docker exec -it name-of-container bash

    /*or pull image from dockerhub (tagname: develop or latest)*/
    docker pull fabriziocaf/microservice-lumen:tagname
    
[Wiki](https://github.com/FabrizioCafolla/microservice-lumen/wiki)

[Documentation Api](https://fabriziocafolla.com/docs/microservice-lumen/)

### Features 

**Doker** to start the application with `Nginx`, `PHP 7.2.2-fpm`, `MySQL` and `Redis`;

**JWT** for the authentication of routes usable with the implemented service;

**Services** implemented to facilitate work:

    -Api helpers function
    -Response method to manage error/success/exceptions responses
    -Auth for manage user and jwt token
    -ACL method for manipulate user roles and permissions
    -Log method to manage file log
    -Cache implements methods to manage File and Redis cache with serialization
    
**Roles and Permissions** to assign them to users and manage routes with greater security;

**Repository pattern** implemented to manage the models in an abstract way and to allow the scalability of the business logic (used to guarantee also the code cleaning)

**Transformer** classes to manipulate data and better manage the recovery of related information (are transformed through functions implemented in ApiService)
  
**Artisan commands** to create Repository, ApiController, Provider and Transoformers (Other commands to create example file view documentation)

### Changelog

  ##### v1.5.5 beta
    -remove file and add exapmle
    -fixed auth controller
    -update package services
    -fixed Dockerfile prod

  ##### v1.5.4 beta
    -fixed errors
    -remove GraphQL
    -change package framework

  ##### v1.5.3 beta
    -fixed config file
    -fixed controllers REST e GraphQL
    -clean code framework

  ##### v1.5.2 beta
    -fixed docker-compose mysql
    -add docker volumes
    -remove folder data
    
  ##### v1.5.1 beta
    -fixed docker-compose file
    -fixed setup develop env
    -fixed volumes data
    
  ##### v1.5.0 beta
    -Update directory and docker file
    -Update core package 
    -Update response package with new logic 
    -Update and clean code cahce package 
    -Fixed rest controllers
    -Clean code

## License

This project is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
