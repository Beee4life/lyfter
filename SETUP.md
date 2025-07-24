# Install demo site

## Contents
- [Setup](#setup)
- [Node JS](#nodejs)
- [Composer](#composer)
- [Database](#database)
- [Grunt](#grunt)
- [Docker commands](#docker)
- [Deployment](#deployment)
- [Gotchas](#gotcha)
- [Changelog](#changelog)

<a name="setup"></a>
### Setup
These instructions assume you have a development environment with the following:

1. Have [Docker CE](https://www.docker.com/community-edition) installed
2. An up-to-date version of Composer.
3. An up-to-date version of node.js.
4. A global installation of Grunt CLI.
5. A checkout of the `master branch` of this project.

Or you can just clone this repo and run the theme in your own installation.
Make sure you generate the css before you copy the files.

#### TODO
* create docker config file by copying `docker-compose-example.yml` to `docker-compose.yml`
* change location/ports (only if needed and you know what you're doing)

* create .env config file by copying (DON'T RENAME) `.env` to `.env.local`
* check if all .env values are correct

#### Start Docker
In order to start the development stack you need to run the following command while Docker is running from the project root:

    docker-compose up -d

This will build container images if they have not been built already.


<a name="nodejs"></a>
#### Install Node.js packages

    $ npm install

npm will install all dependencies in `node_modules`.

<a name="composer"></a>
#### Install Composer packages

    $ composer install

Composer will install the following:

1. All PHP dependencies in `vendor`.
2. WordPress in `web/cms`.
3. All required plugins in `web/app/plugins`.

<a name="database"></a>
### Setup Database

Import db.sql

<a name="grunt"></a>
### Grunt tasks

* `$ grunt build` generates all css/js
* `$ grunt watch` starts a watcher for scss/js

<a name="docker"></a>
### Docker commands

    $ docker compose build
    $ docker compose up -d
    $ docker compose stop 
    $ docker stop %container_name%
