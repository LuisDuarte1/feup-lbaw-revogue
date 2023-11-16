#!/bin/bash

# Stop execution if a step fails
set -e

IMAGE_NAME=git.fe.up.pt:5050/lbaw/lbaw2324/lbaw23107 # Replace with your group's image name

docker login git.fe.up.pt:5050

docker buildx build --push --platform linux/amd64 -t $IMAGE_NAME .
# docker build -t $IMAGE_NAME .
# docker push $IMAGE_NAME
