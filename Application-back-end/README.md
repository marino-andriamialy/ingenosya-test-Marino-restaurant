
Documentation pour Symfony 4.4
=============

https://symfony.com/doc/current/page_creation.html#creating-a-page-route-and-controller
https://ourcodeworld.com/articles/read/794/how-to-install-and-configure-fosuserbundle-in-symfony-4
https://stackoverflow.com/questions/48446371/unrecognized-option-resource-under-fos-user
https://gmanier.com/memo/3/le-crud-sous-symfony-4



///////////////////////////////DOC pour developpeur Marino////////////////////////////////////

-pre requis
===========
php 7.4
Mysql 5.7
Apache
composer

copier le dossier Application-back-end/ dans la racine de votre serveur
faire pointer l' URL dans le dossier Application-back-end/public

etapes pour installer
======================


-apres etre rentrer dans Application-back-end/ depuis la commande line
executer la commande
======================
 composer install
 
 ///////////////////EN CAS ERREUR composer/////////////////////
 si l'install composer echoue pour quelque raison que ce soit 
 -supprimet le vossier vendor et le fichier composer.lock
 lancer lacommande 
 composer dump-autoload -o && php bin/console c:c
 
 extracter le contenu de l'archive vendor.zip
 
ecraser les fichier existants'il le demande
 


base de donnee
===============
-creer une base de donnee MYSQL
configurer la conneciton a cette base de donne
dans le fichier 
Application-back-end/.env
la ligne contenant 

 DATABASE_URL="mysql://root:xxxxx@127.0.0.1:3306/ingenosia?serverVersion=5.7"

pour laquel  
utilisateur : root
mot de passe : xxxxx
et le nom de la base de donnee: ingenosia

-creer la base de donner a partir du fichier conception.sql 
(cette partie n'est necessaire que pour avoir des donnee)
parceque la commande 

php bin/console doctrine:schema:update --force   
va creer les table dela base de donnee




pour lancer l'application
========================
aller dans le dossier
Application-back-end/public depuis la commande line
et taper la commande: 

php -S localhost:8000


les api de vote application sera disponible sur lurl  http://localhost:8000

il est maintenant temps de passer a la configuration dur front  Angular
salut