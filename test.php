<?php
include("ClassePHP/BDDClasse.php");
$host = 'localhost';
$dbname = 'bddprojectama';
$username = 'root';
$password = 'J11Tx1BQ';
$objet = new BDDGestion($host,$dbname,$username,$password);
$objet->StartingConnection();// lancement de la connection à la BDD
$objet->SetNameTable("calendrier");
$test = $objet->SelectSearch(["*"],"annee","2023");
if($test == [])
{
    echo "proute&";
}
else
{
    echo "prouteé";
}
foreach($test as $value)
{
    echo $value[1];
}
?>