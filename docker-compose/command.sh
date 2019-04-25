#!/bin/bash

# filename: command.sh
# author: Fabrizio Cafolla

#Style
default='\e[49m'
black='\e[40m'
red='\e[41m'
green='\e[30;42m '
yellow='\e[43m'
blue='\e[44m'
magenta='\e[45m'
cyan='\e[46m'
dark='\e[100m'
white='\e[107m'

message() {
    message_color=${2:-$default}

    echo -e "$message_color"
    echo $1

    tput sgr0

    return
}

head() {
    message "${1}" $blue
    return
}

step(){
    message "${1}" $magenta
    return
}

finish() {
    message "${1}" $cyan
    return
}

success(){
    message "${1}" $green
    return
}

error(){
    message "${1}" $red
    return
}

#Function to exec docker-compose commands
command () {
    docker-compose $@
}

version() {
    clear

    head "Docker version"
    docker -v

    head "Docker compose version"
    docker-compose -v

    head "Workspace PHP version"
    command "exec workspace php -v"
}

showHelp() {
    clear

    head "Help, script usage: $(basename $0)"
cat <<-END
   -v | --version | -version
     Print version of Docker, Docker compose, and PHP

   -s | --setup | -setup
     Setup application use it only first time, create volumes and make workdir setup

   -b | --build | -build
     Build all container of docker-compose file

   -u | --update | -update
     Up all container of docker-compose file with -d mode

   -d | --down | -down
     Down all container started

   -d | --down | -down
     Down all container started

   -r | --run | -run $
     Run container

   -R | --rebuild | -rebuild
     Re-build and up all container

   -B | --bash | -bash
     Exec bash of container.
     Example:
       ./command.sh --bash workspace
       ./command.sh --bash mysql

END
      exit 1
}
setupVolumes(){
    clear

    step "Step 1/2"
    head "create redis volume"
    docker volume create --driver local \
    --opt type=nfs \
    redis_dump


    step "Step 2/2"
    head "mysql volume"
    docker volume create --driver local \
    --opt type=nfs \
    mysql_dump

    finish "Finish volumes setup"
}

setupApplication() {
    clear

    command "up -d --build"               #Build and up container

    step "Step 1/4"
    head "Permission of workspace /var/www"
    docker-compose exec workspace chgrp www-data -R /var/www && chmod 775 -R /var/www && chmod g+s /var/www

    step "Step 2/4"
    head "Composer install"
    docker-compose exec workspace composer install

    step "Step 3/4"
    head "Copy .env file"
    docker-compose exec workspace cp .env.example .env

    step "Step 4/4"
    head "Generate jwt secret key"
    docker-compose exec workspace php artisan jwt:secret

    finish "Finish application setup"
}

#Function to setup application (only first time)
setup() {
    cp .env.docker .env     #Copy env file
    setupVolumes
    sleep 1.0
    setupApplication
    sleep 0.3
}

# $@ is all command line parameters passed to the script.
# -o is for short options like -v
# -l is for long options with double dash like --version
# the comma separates different long options
# -a is for long options with single dash like -version
options=$(getopt -l "help,version,setup,build,update,down,bash,run,rebuild" -o "h v s b u d B r R" -a -- "$@")

# set --:
# If no arguments follow this option, then the positional parameters are unset. Otherwise, the positional parameters
# are set to the arguments, even if some of them begin with a ‘-’.
eval set -- "$options"

while true
do
    case $1 in
        -h|--help)
            showHelp
            ;;
        -v|--version)
            version
            ;;
        -s|--setup)
            setup
            ;;
        -b|--build)
            clear
            command "build ${3:-$NULL}"
            finish "Build completed"
            ;;
        -u|--update)
            clear
            command "up -d"
            finish "Update completed"
            ;;
        -d|--down)
            clear
            command "down"
            finish "Down completed"
            ;;
        -B|--bash)
            if test "${3:-$NULL}" = ''
            then
                error "Add container name (ex. workspace, redis)"
                exit
            fi
            command "exec ${3} bash"
            ;;
        -r|--run)
            if test "${3:-$NULL}" = ''
            then
                error "Add container name (ex. redis-cli)"
                exit
            fi
            command "run ${3:-$NULL}"
            ;;
        -R|--rebuild)
            clear
            command "up -d --build"
            finish "Rebuild completed"
            ;;
        --)
            shift
            break;;
    esac
    shift
done

shift "$(($OPTIND -1))"
