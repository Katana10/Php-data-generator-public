#------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------


#------------------------------------------------------------
# Table: type_champ
#------------------------------------------------------------

CREATE TABLE type_champ(
        type_champ Varchar (255) NOT NULL ,
        actif      TinyINT NOT NULL
	,CONSTRAINT type_champ_PK PRIMARY KEY (type_champ)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: modele
#------------------------------------------------------------

CREATE TABLE modele(
        libelle       Varchar (50) NOT NULL ,
        nom_fichier   Varchar (50) NOT NULL ,
        nom_table     Varchar (50) NOT NULL ,
        date_creation DateTime NOT NULL
	,CONSTRAINT modele_PK PRIMARY KEY (libelle)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: champs
#------------------------------------------------------------

CREATE TABLE champs(
        id           Int  Auto_increment  NOT NULL ,
        nom_champ    Varchar (50) NOT NULL ,
        longueur     Double NULL ,
        val_min_nb   Double NULL ,
        val_max_nb   Double NULL ,
        val_min_date DateTime NULL ,
        val_max_date DateTime NULL ,
        list_txt     Varchar (255) NULL ,
        fichier      Varchar (255) NULL ,
        type_champ   Varchar (255) NOT NULL ,
        libelle      Varchar (50) NOT NULL
	,CONSTRAINT champs_PK PRIMARY KEY (id)

	,CONSTRAINT champs_type_champ_FK FOREIGN KEY (type_champ) REFERENCES type_champ(type_champ)
	,CONSTRAINT champs_modele0_FK FOREIGN KEY (libelle) REFERENCES modele(libelle)
)ENGINE=InnoDB;

