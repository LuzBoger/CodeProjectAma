<?php
//TABLE STRUCTURE ARTHUR

$sqlTableStructure = "CREATE TABLE IF NOT EXISTS `structure` (
    `ID` int(11) NOT NULL AUTO_INCREMENT,
    `nomCourt` varchar(10) NOT NULL,
    `nomComplet` varchar(50) NOT NULL,
    `typeAccueil` varchar(30) NOT NULL,
    `raisonSocial` varchar(40) NOT NULL,
    `telephone` varchar(15) NOT NULL,
    `fax` varchar(15) NOT NULL,
    `email` varchar(30) NOT NULL,
    `siteInternet` varchar(50) NOT NULL,
    `codeStructure` varchar(50) NOT NULL,
    `codeorganisme` varchar(50) NOT NULL,
    `CAF` varchar(50) NOT NULL,
    `academie` varchar(50) NOT NULL,
    `agrementMax` int(11) NOT NULL,
    PRIMARY KEY (`ID`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;";


//TABLE COORDONNEE ARTHUR


$sqlTableCoordonnee = "CREATE TABLE IF NOT EXISTS `Coordonee` (
    `ID` int(11) NOT NULL AUTO_INCREMENT,
    `numero` INT(10) NOT NULL ,
    `adresse` varchar(50) NOT NULL,
    `complement` varchar(30) NOT NULL,
    `codePostal` INT(6) NOT NULL,
    `ville` VARCHAR(30) NOT NULL,
    PRIMARY KEY (`ID`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;";



//TABLE DOCUMENT ARTHUR

$sqlTableDocument = "CREATE TABLE IF NOT EXISTS `Document` (
    `ID` int(11) NOT NULL AUTO_INCREMENT,
    `logo` blob NOT NULL ,
    `texteAtLogo` varchar(20) NOT NULL ,
    `numeroSiret` varchar(20) NOT NULL,
    `pInformation` varchar(200) NOT NULL,
    `consigneReglement` INT(200) NOT NULL,
    `signataire` VARCHAR(30) NOT NULL,
    PRIMARY KEY (`ID`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;";
//   En discussion : 


//TABLE USER ARTHUR

$sqlTableUser = "CREATE TABLE IF NOT EXISTS `UserID` (
    `ID` int(11) NOT NULL AUTO_INCREMENT,
    `email` varchar(40) NOT NULL ,
    `password` varchar(65) NOT NULL ,
    `pseudo` varchar(20) NOT NULL ,
    `photoProfile` blob,
    PRIMARY KEY (`ID`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;";

//FIN DES TABLES D'ARTHUR



//TABLE FACTURE DAVID

$sqlTableFacture= "CREATE TABLE IF NOT EXISTS `facture` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `libelleFacture` varchar(255) NOT NULL,
  `numeroFacture` varchar(255) NOT NULL,
  `dateEmission` varchar(255) NOT NULL,
  `dateEcheance` varchar(255) NOT NULL,
  `montant` int(11) NOT NULL,
  `solde` int(11) NOT NULL,
  `etat` varchar(255) NOT NULL,
  `trainFacturation` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

//FIN DES TABLES DAVID

// TABLE ENFANT THEO POLVECHE

$sqlTableEnfant = "CREATE TABLE IF NOT EXISTS `enfant` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `nom` varchar(15) NOT NULL,
  `prenom` varchar(15) NOT NULL,
  `sexe` varchar(1) NOT NULL,
  `dateNaissance` date NOT NULL,
  `nomPere` varchar(15) NOT NULL,
  `prenomPere` varchar(15) NOT NULL,
  `telephonePere` int(10) NOT NULL,
  `nomMere` varchar(15) NOT NULL,
  `prenomMere` varchar(15) NOT NULL,
  `telephoneMere` int(10) NOT NULL,
  `nomAllocataire` varchar(15) NOT NULL,
  `numeroAllocataire` int(255) NOT NULL,
  `regimeAllocataire` varchar(255) NOT NULL,
  `deptAllocataire` varchar(255) NOT NULL,
  `nomMedecin` varchar(15) NOT NULL,
  `telephoneMedecin` int(10) NOT NULL,
  `portableMedecin` int(10) ,
  `vaccins` varchar(255) NOT NULL,
  'pap' boolean(1),
  'porteurHandicap' boolean(1),
  'pai' boolean(1),
  'aeeh' boolean(1),
  `restrictionAlimentaire` varchar(255) ,
  `recommandation` varchar(255) ,
  `autorisation` varchar(255) NOT NULL,
   `fournie par les parents` varchar(255) NOT NULL,
     `paiAlimentaire` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;";

//TABLE FOYER THEO POLVECHE

$sqlTableFoyer = "CREATE TABLE IF NOT EXISTS `foyer` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `employeurNom1` varchar(255) NOT NULL,
  `employeurprenom1` varchar(255) NOT NULL,
  `employeurTelephone1` int(255) NOT NULL,
  `employeurMail1` varchar(255) NOT NULL,
  `employeurNom2` varchar(255) NOT NULL,
  `employeurPrenom2` varchar(255) NOT NULL,
  `employeurTelephone2` int(255) NOT NULL,
  `employeurMail2` varchar(255) NOT NULL,
  `assurances` varchar(255) NOT NULL,
  `autoriserNoms` varchar(255) NOT NULL,
  `autoriserPrenom` varchar(255) NOT NULL,
  `autoriserTelephone` int(255) NOT NULL,
  `casurgencesNom` varchar(255) NOT NULL,
  `casurgencesPrenom` varchar(255) NOT NULL,
  `casurgencesTelephone` int(255) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;";

//TABLE CONTRAT THEO POLVECHE

$sqlTableContrat ="CREATE TABLE IF NOT EXISTS `contrat` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `planningHebdomadaire` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;";


//TABLE COMPTE THEO POLVECHE

$sqlTablecompte = "CREATE TABLE IF NOT EXISTS `compte` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `facture` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;";
// FIN THEO POLVECHE


?>