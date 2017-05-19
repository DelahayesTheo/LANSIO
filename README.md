LANSIO
======

A Symfony project created on February 26, 2017, 2:05 am.

Site de la LAN des SIO de 2017.

Destiné à préparer la LAN (équipements apportés, jeu(x) au(x)quel(s) le participant compte jouer). Le site est destiné à être couplé à un serveur de communication (Discord ou TeamSpeak) pour une meilleure organisation

Installation
============

Cloner le repository et éxécuter la commande 

```
composer install
```
ou
```
php composer.phar install
```
selon votre installation de composer. (global ou localisé)

Changer les paramètres de la base de données contenus dans `parameters.yml` localisé dans le dossier `app/config`
Ensuite éxécuter les commandes :

```
php app/console doctrine:database:create
php app/console doctrine:schema:update --force
php app/console fos:user:create foo foo@bar.com bar
php app/console fos:user:create admin admin@superuser.com superuser --super-admin
php app/console generate:platform:equipment
php app/console generate:games
```
Soit créer la base de données, créer un utilisateur et un super-admin ainsi que des créer les données nécessaires au fonctionnement du site ( les deux dernières commandes sont disponibles dans `src/AdminBundle/Command`).

Et enfin éxécuter la commande :

```
php app/console server:run
```

PS : Le site à été créé sur le vif, des sections 'en construction' ne sont pas disponibles car je n'ai pas eu le temps de les implémenter à temps. Les jaquettes sont aussi indisponibles du fait du non-changement de la commande :
```
php app/console generate:games
```
après l'implémentation des dites jaquettes.

Je ferais le ménage dans la semaine qui vient mais si je laisse quand même une note si vous corrigez avant mon passage.

