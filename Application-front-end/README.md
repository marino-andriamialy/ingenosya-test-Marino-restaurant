# ApplicationFrontEnd

This project was generated with [Angular CLI](https://github.com/angular/angular-cli) version 11.2.14.

## Development server

Run `ng serve` for a dev server. Navigate to `http://localhost:4200/`. The app will automatically reload if you change any of the source files.

## Code scaffolding

Run `ng generate component component-name` to generate a new component. You can also use `ng generate directive|pipe|service|class|guard|interface|enum|module`.

## Build

Run `ng build` to build the project. The build artifacts will be stored in the `dist/` directory. Use the `--prod` flag for a production build.

## Running unit tests

Run `ng test` to execute the unit tests via [Karma](https://karma-runner.github.io).

## Running end-to-end tests

Run `ng e2e` to execute the end-to-end tests via [Protractor](http://www.protractortest.org/).

## Further help

To get more help on the Angular CLI use `ng help` or go check out the [Angular CLI Overview and Command Reference](https://angular.io/cli) page.


///////////////////////////////DOC pour developpeur Marino////////////////////////////////////
il faut que la partie serveur PHP symfony soit configurer avant de pouvoir lancer la partie angular
-pre requis
===========
node v 12.14.0
npm 6.13.4
@angular/cli                    11.2.15


apres etre rentrer dans Application-front-end/ depuis la commande line
faite la commande 
=================
npm install

changer les parametres d'environnemnt
====================================
dans les ficier
Application-front-end\src\environments\environment.prod.ts  pour la production
Application-front-end\src\environments\environment.ts  pour le developement

changer apiURL: 'http://localhost:8000/' par l'url du serveur qui contiendra l'application php (symfony)


lancer l'application en local
=============================
ng serve --open


l'application sera disponible sur http://localhost:4200/

