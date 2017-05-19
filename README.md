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

Changer les paramètres de la base de données contenus dans `parameters.yml` localisé dans le dossier `app/config`
Ensuite éxécuter les commandes :

```
php app/console doctrine:database:create
php app/console doctrine:schema:update --force
php app/console fos:user:create foo foo@bar.com bar
php app/console fos:user:create admin admin@superuser.com superuser --super-admin
```

