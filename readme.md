# Xenforo Keycloak Auth Provider

## Development env setup

1. Download a copy of xenforo 2 from your account panel, place into this directory and rename as `xenforo.zip`
2. Run `./install-from-zip.sh` to unpack the xenforo source
3. Run `docker-compose up -d` to start the server
4. Run `docker exec xenforo php cmd.php xf:install --user=admin --password=admin --clear` to run the database migrations

> Note: you can run step 2 again if you need to restore any default xenforo files to default

## Running xenforo CLI

If you want to use the xenforo CLI to it's full extent, you can execute it via the docker CLI to run within the PHP container

```sh
docker exec xenforo php cmd.php
```
