# Data-Generator


Application permettant de générer de la donnée dans un format SQL/CSV à partir de modèles créés par l'utilisateur.

## Dépendances

Vous devez posséder sur votre machine:

* PHP version 7 ou supérieur
* Un serveur Web (Apache)
* MySQL
Le projet à été essayé sous XAMP et sous WINDOWS.

## Installation

Télécharger le fichier zip à partir de l'ENT, puis enregistrer le projet sous Xamp/htdocs.

## Mise en place du site

Le site possède sa propre base de donnée que vous devez charger afin de le rendre fonctionnel.
Pour ce faire rendez-vous sur phpmyadmin et suivez les étapes suivantes:

  1. Cliquer sur la rubrique import à la base de votre serveur.
  2. Télécharger le fichier SQL_commande.sql se trouvant là où vous avez enregister le projet dans Fichier_création_BDD.
  3. N'oublier pas de sélectionner les options 
  ..* Jeu de caractères du fichier : utf-8
  ..* FORMAT SQL
  4. Cliquer sur executer.


Tout est inclus dans le fichier SQL_commande.sql, mais si vous voulez changer les logins de connexion, vous pouvez changer les constantes dans le fichier php/constante.php.
A condition de ne pas oublier les changer dans phpmyadmin.


## Utilisation

Pour généré des données aléatoires aller sur générateur de donnée puis suiver les étapes en remplissant les champs qui vous conviennes.

Lorsqu'un modèles existe déjà, il est possible de le rejouer et d'en resortir un fichier avec de nouvelles données aléatoires.
Le format de fichier peut être changer, si vous aviez choisit un .sql la première fois vous pouvez choisir un .csv la seconde.
ATTENTION!! Si vous ne téléchargez pas le fichier la première fois et que vous le rejouer les valeurs seront modifier.

La page back est utilisé pour désactiver un type champ sur la page d'accueil. Par exemple, si je désactive un varchar, celui-ci ne sera plus proposé sur la page d'accueil, mais apparaîtra si vous rejouez un modèle. Vous pouvez rejouer un modèle existant dans la base de donnée depuis la page d'accueil.
