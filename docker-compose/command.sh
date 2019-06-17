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

#ENV
app_name=microservice

container_webserver=webserver_${app_name}
container_backend=backend_${app_name}
container_mysql=mysql_${app_name}
container_redis=redis_${app_name}

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
    docker-compose -p $app_name $@
}

version() {
    clear

    head "Docker version"
    docker -v

    head "Docker compose version"
    docker-compose -v
}

showHelp() {
    clear

    head "Help, script usage: $(basename $0)"
cat <<-END
   -v | --version | -version
     Print version of Docker, Docker compose

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

END
      exit 1
}

setupApplication() {
    clear

    step "Step 1/4"
    command "build $container_mysql"               #Build and up container
    command "build $container_redis"               #Build and up container
    command "build $container_webserver"               #Build and up container
    command "build $container_backend"               #Build and up container

    command "up -d $container_webserver"

    step "Step 2/4"
    head "Composer install"
    command "exec $container_backend composer install"
    command "exec $container_backend composer update"

    step "Step 3/4"
    head "Copy .env file"
    command "exec $container_backend cp .env.example .env"

    step "Step 4/4"
    head "Generate jwt secret key"
    command "exec $container_backend php artisan jwt:secret"

    finish "Finish application setup"
}

createVolumes(){
    clear

    step "Step 1/2"
    head "Create redis volume"
    docker volume create --driver local \
    --opt type=nfs \
    redis_dump_${app_name}


    step "Step 2/2"
    head "Create mysql volume"
    docker volume create --driver local \
    --opt type=nfs \
    mysql_dump_${app_name}

    finish "Finish volumes setup"
}

createNetworks(){
    clear

    head "Create net_proxy_gateway network"
    docker network create --attachable \
    --driver bridge \
    net_proxy_gateway

    finish "Finish networks setup"
}



#Function to setup application (only first time)
setup() {
    cp .env.docker .env     #Copy env file
    createNetworks
    sleep 0.3
    createVolumes
    sleep 0.3
    setupApplication
}

# $@ is all command line parameters passed to the script.
# -o is for short options like -v
# -l is for long options with double dash like --version
# the comma separates different long options
# -a is for long options with single dash like -version
options=$(getopt -l "help,version,setup,build,up,down,bash,command,run,rebuild" -o "h v s b u d B c r R" -a -- "$@")

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
            command "build ${@:3:$#}"
            ;;
        -u|--up)
            clear
            command "up -d ${@:3:$#}"
            ;;
        -d|--down)
            clear
            command "down"
            ;;
        -B|--bash)
            command "exec ${3} /bin/sh"
            if [ ! ${3} ]; then
                error "Use valid container name"
            fi
            ;;
        -c|--command)
            command ${@:3:$#}
            if [ ${#} -le 2 ]; then
                error "Invalid compose command"
            fi
            ;;
        -r|--run)
            command "run ${3}"
            if [ ! ${3} ]; then
                error "Invalid command"
            fi
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
