<?php
require_once "../ClassePHP/BDDClasse.php";
RecupAllInfoBDD();
function RecupAllInfoBDD()
{
    /* Objectif de cette fonction renvoyer sous forme d'écho toutes les informations de la BDD 
    au javascript*/
    $host = 'localhost';
    $dbname = 'bddprojectama';
    $username = 'root';
    $password = 'J11Tx1BQ';
    $objet = new BDDGestion($host,$dbname,$username,$password);
    $objet->StartingConnection();// lancement de la connection à la BDD
    $objet->SetNameTable("horaire_garderie");// Attribution de la table dans la quelle on souhaite faire nos requete
    $Allcontains = $objet->SelectColumn();
    $ChaineConcatenation = "";
    for($i = 0;$i<6;$i++)
    {
        $ChaineConcatenation .= $Allcontains[$i][2]."|";
        if($i == 5)
        {
            $ChaineConcatenation .= $Allcontains[$i][3];
        }
        else{
            $ChaineConcatenation .= $Allcontains[$i][3]."|";
        }
        
    }
    echo json_encode($ChaineConcatenation);
}
