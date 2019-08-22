# Microservice Lumen - DevOps 
![](https://img.shields.io/badge/version-3.0.2--beta-green.svg)
![](https://img.shields.io/badge/docker--compose-build-blue.svg)
![](https://img.shields.io/badge/docker-build-blue.svg)

##Description

Microservice Lumen è un'infrastruttura docker che permette di avviare un microservizio php basato sul framework Lumen. 
Mette a disposizione svariati strumenti e servizi che aiutano lo sviluppatore, che con pochi comandi gestisce l'ambiente di sviluppo/staging/produzione. 
Di base sono disponibili i container Nginx per il webserver, MySQL e Redis per il db e cache, e PHP 7.3 per l'applicazione, configurabili facilmente con il file di configurazione. 
Ricordare che l'immagine da usare in produzione o staging fa riferimento al Dockerfile presente nella dir application.

## Let's go
#### Develop env
**- require**
    
    Docker version 18.09.6, build 481bc77
    docker-compose version 1.24.0, build 0aa59064

**- setup and run**

    1. Start this project https://github.com/FabrizioCafolla/docker-as-infrastructure
    
    2. Edit command.sh if you would rename app(not required) *
        app_name=your_app_name
       Edit .env.docker if you would change composer env (not required)
        BACKEND_ENV_COMPOSER=composer.json 

    3. Only first time
        chmod +x docker-compose/command.sh 
        ./command.sh --setup
    
    4. Run
        ./command.sh --build
        ./command.sh --up
        
    5. Test
        localhost/api/v1/test 
        localhost/api/v1/discovery
    
    (*) Replace APP_NAME with name of your app. Docker-compose use it with option -p for exec all command.
    The development environment is set up so that the docker-compose infrastructure does not conflict with other successful containers on your machine. Take advantage of the -p option of Docker so that it assigns a unique name to your app, and the names of the containers and services must be unique and not conflict with the other containers. This will allow you if you want to start more apps in a development environment without conflicts
    
**- command.sh**

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
        
    (*) replace 'PATH' with your path (ex. /var/www/example/docker-compose), and  replace 'microservice' with what you want
    
#### Production env

**- manual builds** 

    //build and run microservice
    docker build --tag microservice-lumen .
    docker run -d -p 9000:9000 --name name-of-container -it microservice-lumen /bin/sh

    //enter in microservice bash     
    docker exec -it name-of-container /bin/sh
    
    //stop and start microservice
    docker stop name-of-container
    docker start name-of-container
    docker rm name-of-container

[manual push](https://docs.docker.com/engine/reference/commandline/push/) in registry 

**- automatic builds** 

    //pull image from dockerhub (tagname: develop or latest)
    docker pull fabriziocaf/microservice-lumen:tagname
    
[docker hub example](https://hub.docker.com/r/fabriziocaf/microservice-lumen) with microservice-lumen.

If you want create automatic builds for your repository [see here](https://hub.docker.com/r/fabriziocaf/microservice-lumen).

### Features 

**Host machine env**

    Use this project https://github.com/FabrizioCafolla/docker-as-infrastructure for set your docker environment
     
**Application env** 
    
    -Webserver Nginx 1.17-alpine
    -Application: PHP 7.3.8-fpm-alpine

**Kosmos X**

    -Support: services for manipulate data with Transformer, Api discovery, and more;
    -Response: create rest response more efficently;
    -Cache: services for manage File and Redis cache;
    -Auth: implement JWT auth and service to authenticate;
    -Helpers: function to help developer, artisan commands to create Repository, ApiController, Provider and Transoformers
    
### Changelog

  ##### v3.0.2 beta
    -Remove Redis e Mysql container
    -Move directory application into application/backend for support multi-service
    -Update php version
    -Remove framework package and fix bootstrap app

  ##### v3.0.1 beta
    -Fix context docker-compose file
    -Fix context Dockerfile 
    
  ##### v3.0.0 beta
    -Refactoring and clean code

## License

This project is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
