### Data-Generator

This app let you generate data in .sql/.csv format from a model create by the user.


## DEPENDENCIES

You must have on your machine :

* PHP version 7 or higher
* A Web server (Apache)
* MySql

The project has been tested under XAMP and under WINDOWS.

## INSTALLATION

## Under Xamp/windows

Download the zip file from my repository, then save the project under #Xamp/htdocs#.

# Setting up of the site

The website has its own database that you need to load in order to make it functional. 

To do this, go to phpmyadmin and follow these steps:

1. Click on the heading _import_ to your server's database.
2. Download the #SQL_commande.sql# file located where you saved the project in the folder #Fichier_BDD_sql#.
3. Do not forget to select the options **_Character set of the file_:** utf-8 and **_FORMAT_** SQL
4. Click on execute.


Everything is included in the #SQL_commande.sql# file, but if you want to change the connection logins, you can change the constants in the #php/constant.php# file. As long as you don't forget to change them in phpmyadmin.

## Under Linux

Download the zip file from my repository, then save the project under #var/www/html#.

# Setting up of the site

The website has its own database that you need to load in order to make it functional. 

To do this, open your terminal and follow these steps:

1. On your terminal go on #var/www/html/Php-data-generator-public/Fichier_BDD_sql#.
2. Type the following command: ```sudo mysql -u root < SQL_Commande.sql```
3. Go on your web browser and type ##localhost##
4. Normally if Apache2 and other dependancies are correctly installed in your machine, it work.

## USE

To generate randoms data, clic on **générateur de données** and follow the instructions by putting the informations of your table.

When a model exist, you can replay it to create new randoms data. In this case you can just change the number of data and the file's format.
**WARNING !!** If you don't download the file the first time and you replay it a second time the data will not be the same.

The page **back** is used to disable a field type on the home page. 
For example, if you disable a varchar, it will no longer be proposed on the home page, but will appear if you replay a template. You can replay an existing template in the database from the home page.
