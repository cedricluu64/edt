# EDT
***
Gestionnaire d'emploi du temps de Hugo Barbaste et Cédric LUU

## Table des matières
1. [Information](#information)
2. [Technologie](#technologie)
3. [Installation](#installation)
4. [Utilisation](#utilisation)


### Information
Ce gestionnaire de projet d'emploi du temps utilise un serveur php et un serveur postgres afin de fonctionner.
Ce système permet de gérer les cours d'un emploi du temps d'un étudiant. Les professeurs sont associés à des matières puis à des cours. Il y a aussi la possibilité de noter les professeurs mais aussi les cours.

### Technologie
Afin de faire fonctionner cette application, il faut installer docker, php, symfony.
Ce système fonctionne avec Vue.js, Vuetify, Axios, BootStrap.

### Installation
*** Si vous voulez modifier le port du site web faites le avant de lancer docker et n'oublier pas de changer le .env *** 
- Télécharger le projet
- Dé zipper le et allez dans le répertoire
- Ouvrir un invité de commande et éxecuté: 
    ```sh
    docker compose up 
    ```
- Importer la base de données en utilisant un application d'administration de base Postgres (DBReaver, PgAdmin) -  login/mdp = symfony
- Aller dans le répertoire public
- Ouvrir un invité de commande et éxecuté:
    ```sh
    php bin/console -S localhost:8667 
    ```

### Utilisation
Une api permet de gérer les professeurs et les avis mais aussi de récupérer les cours et les salles.

Une panneau d'administration est disponible afin de pouvoir gérer l'emploi du temps de façon plus graphique.

Le calendrier permet de voir les cours mais aussi de le noter en cliquant dessus. De plus, vous pourrez noter le professeur en cliquant sur le lien.

Une page permettant de noter son professeur est présente, elle liste tous les professeurs, si vous en choisissez un ces notes apparaitrons et un formulaire de saisi va s'ouvrir



#### Il ne vous reste qu'à utiliser le système via les trois liens suivants:
- [Edt]
- [Admin]
- [Calendrier]


   [Admin]: <http://localhost:8667/admin>
   [Edt]: <http://localhost:8667/edt.php>
   [Calendrier]: <http://localhost:8667/edt.php>
