# PetSecur demo opdracht

Voor degene die het gaat checken, loop door alle stappen heen in de setup en als het goed is heb je een werkende installatie aan het einde met een imported database en een actief thema.

[Click here to install](SETUP.md).

### Kanttekeningen/opmerkingen

#### Boilerplate
Zoals jullie het eigen framework Lyfter gebouwd hebben, zo heb ik ook een eigen 'jumping off' point gebouwd, mijn boilerplate noem ik dat en die heb ik bijgehouden door de jaren heen.

Deze repo is een uitgeklede variant daarvan. Ik had al iets opgezet voor ik de opdracht kreeg, wat gedaan was op basis daarvan en daarmee ben ik (in overleg met Carmen en Markus) verder gegaan.

Dit is een volledig custom theme met alles gerenderd in Twig.

CSS wordt compiled door Grunt. Ja, I know niet de meest moderne manier. Webpack of Gulp heb ik ook gebruikt. Hier zit toevallig nog steeds Grunt in. Moet ik nog een keer vervangen, maar staat op de todo list :)

#### Git
Er zit niet de (git) historie in die je normaal bij een project zou hebben. Ik was (voor ik de opdracht kreeg) al bezig met 'iets' in een eigen repo en daarin zit behoorlijk wat code in die ik niet in een openbare repository wil delen.

Ik heb veel eruit gestript en daarom toen alles er zo goed als uit was, alles overgezet naar een nieuwe repo. Er is dus weinig historie en niet veel commit messages e.d. Ik vond het tbh ook een beetje vreemd dat commit messages genoemd werden als 'punt van aandacht'. Mijn werk moet voor zich spreken, niet een notitie als ik iets opsla.

#### Assets
![Screenshot](no-access.png "No access")

De assets waren niet beschikbaar in Figma. Ik weet niet of dit nu wel of niet expres was, maar if so dan vind ik dit niet een goede, representatieve opdracht.

In al mijn jaren dat ik dingen heb gebouwd, heb ik nog nooit moeten bouwen op basis van een Figma design waarbij ik **geen** toegang heb tot de assets. Een designer wil graag dat zijn/haar werk goed wordt vertaald en dus is het niet logisch om geen access te krijgen tot de assets.

Nu moest ik maar een beetje improviseren zonder correcte assets. Ik heb wel een soortgelijke iphone image gedownload om te gebruiken maar dit is natuurlijk niet optimaal.

Zonder de achtergronden en accenten e.d. is het moeilijk om iets goed te laten lijken.

Ja er is wel iets mogelijk maar die accenten e.d. maar dat zijn voornamelijk grafische elementen en die worden dan aangeleverd. Dat realiseren met puur css kan een dedicated front-end developer maybe, maar ik niet.

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

## BELANGRIJK
Ik heb ACF niet included want die installeer ik via composer en ik ga niet mijn key of een paid plugin includen in een public repo. Dus om dit te kunnen gebruiken, moet er even een ACF Pro installed worden in `/app/plugins`.

Het hele theme runt niet als ACF niet actief is dus dit is echt een noodzaak, maar daarvoor krijg je vanzelf een melding.
