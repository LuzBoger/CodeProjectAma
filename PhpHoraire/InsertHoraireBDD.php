<?php
if(isset($_POST['tableau']))
{
    $tableau = $_POST['tableau'];
    require_once "../ClassePHP/BDDClasse.php";
    $Boolean = InsertAllInfoBDD($tableau);
    echo $Boolean;
}
function InsertAllInfoBDD($tableau)
{
    $tabBoolean = [false,false,false,false,false];
    $host = 'localhost';
    $dbname = 'bddprojectama';
    $username = 'root';
    $password = 'J11Tx1BQ';
    $objet = new BDDGestion($host,$dbname,$username,$password);
    $objet->StartingConnection();
    $objet->SetNameTable("horaire_garderie");
    $tabBoolean[0] = $objet->UpdateINTOBDD(array("HEURE_DBT" => $tableau[2],"HEURE_FIN" => $tableau[3]),1);
    $tabBoolean[1] = $objet->UpdateINTOBDD(array("HEURE_DBT" => $tableau[4],"HEURE_FIN" => $tableau[5]),2);
    $tabBoolean[2] = $objet->UpdateINTOBDD(array("HEURE_DBT" => $tableau[6],"HEURE_FIN" => $tableau[7]),3);
    $tabBoolean[3] = $objet->UpdateINTOBDD(array("HEURE_DBT" => $tableau[8],"HEURE_FIN" => $tableau[9]),4);
    $tabBoolean[4] = $objet->UpdateINTOBDD(array("HEURE_DBT" => $tableau[10],"HEURE_FIN" => $tableau[11]),5);
    $tabBoolean[5] = $objet->UpdateINTOBDD(array("HEURE_DBT" => $tableau[12],"HEURE_FIN" => $tableau[13]),6);
    foreach($tabBoolean as $elem)
    {
        if($elem !== true)
        {
            return false;
        }
    }
    return true;
}
if(isset($_POST['SendBDDText']))
{
    require_once "../ClassePHP/BDDClasse.php";
    $SendText = $_POST['SendBDDText'];
    $SendTextTab = [];
    $SendTextTab = explode("~",$SendText);
    for($i = 0;$i < count($SendTextTab);$i++)
    {
        $SendTextTab[$i] = explode("|",$SendTextTab[$i]);
    }
    $host = 'localhost';
    $dbname = 'bddprojectama';
    $username = 'root';
    $password = 'J11Tx1BQ';
    $objet = new BDDGestion($host,$dbname,$username,$password);
    $objet->StartingConnection();// lancement de la connection à la BDD
    $objet->SetNameTable("calendrier");
    for($i = 0;$i<count($SendTextTab);$i++)
    {
        $returnValue = $objet->SelectSearch(["*"],"idJour", $SendTextTab[$i][0]);
        if($returnValue == [])
        {
            $sql = "INSERT INTO calendrier (idJour,typeInfo,annee) VALUES ";
            $sql .= "('".$SendTextTab[$i][0]."', '".$SendTextTab[$i][1]."', '".$SendTextTab[$i][2]."')";
            $objet->RequeteSQlTreatment($sql);
        }
        else
        {
            $objet->UpdateINTOBDD(array("idJour" => $SendTextTab[$i][0],"typeInfo" => $SendTextTab[$i][1],"annee" => $SendTextTab[$i][2]),$returnValue[0][0]);
        }
    }
    echo json_encode($res = ["success" => "OK"]);
    }
    
?>