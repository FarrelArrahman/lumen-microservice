# Microservice Lumen - DevOps 
![](https://img.shields.io/badge/version-2.0.3--beta-green.svg)
![](https://img.shields.io/badge/docker--compose-build-blue.svg)
![](https://img.shields.io/badge/docker-build-blue.svg)

## Let's go
#### Develop env

**- setup and run**

    1. Only first time
        chmod +x docker-compose/command.sh 
        ./command.sh --setup
    
    2. Run
        ./command.sh --build
        ./command.sh --up
        
    3. Test
        localhost/api/v1/test 
    
**- utility**

    -v | --version | -version
    Print version of Docker, Docker compose, and PHP
    
    -s | --setup   | -setup
    Setup application use it only first time, create volumes and make workdir setup
    
    -b | --build   | -build
    Build all container of docker-compose file
    
    -u | --up      | -up
    Up all container of docker-compose file with -d mode
    
    -d | --down    | -down
    Down all container started
    
    -d | --down    | -down
    Down all container started
    
    -r | --run     | -run $
    Run container
    
    -R | --rebuild | -rebuild
    Re-build and up all container
    
    -B | --bash    | -bash
    Exec bash of container.
        Example:
        ./command.sh --bash workspace
        ./command.sh --bash mysql
    
    -c | --command | -command
    Exec compose command
        Example:
        ./command.sh -c -- up -d  //If parameters conflicts with script options
        ./command.sh -c "up -d"   //If parameters conflicts with script options
        ./command.sh -c up
       
    /*If use normal commands*/
    cd docker-compose
    docker-compose ...
    
**- create alias command**

    1. Edit .bash_aliases or .bashrc file using: 
        nano ~/.bash_aliases
        
    2. Add this string*: 
        alias microservice='cd PATH/docker-compose && ./command.sh'
        
    3. Save and close the file.
    
    4. Activate alias by typing: 
        source ~/.bash_aliases
        
    5. Use it in shell:
        microservice -help    
        
    *replace 'PATH' with your path (ex. /var/www/example/docker-compose)
    *replace 'microservice' with what you want
    
#### Production env

**- manual builds** 

    //build and run microservice
    docker build --tag microservice-lumen .
    docker run -d -p 9000:9000 --name name-of-container -it microservice-lumen /bin/bash

    //enter in microservice bash     
    docker exec -it name-of-container bash
    
    //stop and start microservice
    docker stop name-of-container
    docker start name-of-container

[manual push](https://docs.docker.com/engine/reference/commandline/push/) in registry 

**- automatic builds** 

    //pull image from dockerhub (tagname: develop or latest)
    docker pull fabriziocaf/microservice-lumen:tagname
    
[docker hub example](https://hub.docker.com/r/fabriziocaf/microservice-lumen) with microservice-lumen.

If you want create automatic builds for your repository [see here](https://hub.docker.com/r/fabriziocaf/microservice-lumen).

### Features 

**Doker** to start the application with `Nginx 1.10`, `PHP 7.3.4-fpm`, `MySQL 5.7` and `Redis 5.0`;

**JWT** for the authentication of routes usable with the implemented service;

**Services** implemented to facilitate work:

    -Api helpers function
    -Rest Response method to manage error/success/exceptions responses
    -Auth for manage user and jwt token
    -Cache implements methods to manage File and Redis cache with serialization
    
**Repository pattern** implemented to manage the models in an abstract way and to allow the scalability of the business logic (used to guarantee also the code cleaning)

**Transformer** classes to manipulate data and better manage the recovery of related information (are transformed through functions implemented in ApiService)
  
**Artisan commands** to create Repository, ApiController, Provider and Transoformers (Other commands to create example file view documentation)

### Changelog

  ##### v2.0.3 beta
    -Revert Dockerfile
    -Fixed console command Auth
    -Update composer json
    -Fixed config manager
    -Add CorsMiddleware

  ##### v2.0.2 beta
    -Update dockerfile

  ##### v2.0.1 beta
    -Update sh script
    -Clean directory
    
  ##### v2.0.0 beta
    -Upgrade Lumen from 5.7 to 5.8
    -Update package: cosmo-microservice is new version of "core-microservice"
    -Update package: front-manager is new version of "resorces-manager"
    -Update package: service-response is new version of "service-response"
    -Update package: cache-system is updated 
    -Clean code

## License

This project is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
