<?php
$host = 'localhost';
$dbname = 'bddprojectama';
$username = 'root';
$password = 'J11Tx1BQ';

function BDDConnection($host,$dbname,$username,$password)
{
  /*Cette fonction fait office d'outil de connection à la BDD
    Elle reçoit les 4 parametre minimum de connection
    La gestion d'erreur est aussi gérer dans cette fonction
    elle return $conn, une variable qui contient les informations de connection
  */
  try{
      $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
      return $conn;
      }catch (PDOException $e){
        echo "Erreur :".$e->getMessage()."<br>";
        die;
      }
}
function getNumberowInTable($NameTable,$conn)
{
    /*
    Fonction permettant d'obtenir le nombre de ligne dans une table
    quelqu'onque
    input : $nameTable représente le nom de la table que l'on recherche
    return : renvoie le nombre de ligne qu'il y a dans une colonne
    Warning : Si une erreur est détecté elle ne sera pas afficher juste du 
    */
    try{
        $stmt = $conn->prepare("SELECT COUNT(*) FROM ".$NameTable);
        $stmt->execute();
        $num_rows = $stmt->fetchColumn();
        // echo "Number of rows: " . $num_rows;
        $conn = null;
        return $num_rows;
    }
    catch(Exception $e)
    {
        echo 'Erreur',$e->getMessage(),"/n";
       
    }
}