#!/bin/bash

dir() {
    cd docker-compose
}

dir_back() {
    cd ..
}

#Function to exec docker-compose commands
command () {
    dir
    docker-compose $@
}

#Function to setup application (only first time)
setup() {
    dir

    cp .env.docker .env                   #Copy env file
    chmod +x ./setup.sh ./setupVolumes.sh #Permession for script
    ./setupVolumes.sh                     #Script to create volumes

    dir_back

    command "up -d --build"               #Build and up container
    ./setup.sh                            #Setup container workspace
}

#Function to print help command
help() {
# Using a here doc with standard out.
cat <<-END
Script usage: $(basename $0)
-----
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
END
      exit 1
}

while getopts 's b u r d c: h?' OPTION; do
  case "$OPTION" in
    s)
      setup
      ;;

    b)
      command "build"
      ;;

    u)
      command "up -d"
      ;;

    r)
      command "up -d --build"
      ;;

    d)
      command "down"
      ;;

    c)
      command ${OPTARG}
      ;;

    h|\?)
      help
      ;;
  esac
done

shift "$(($OPTIND -1))"

