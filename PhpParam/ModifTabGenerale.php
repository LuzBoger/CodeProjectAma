<?php

if(isset($_POST['tabResult']) && isset($_POST['index']));
{
    include "../FonctionPHP/functionBDD.php";
    $StringCarac = $_POST['tabResult'];
    // Mettre sous forme de tableau les éléments suivants
    $tabFinal = explode("||", $StringCarac);
    $nameOfTable = VerifTabSend($_POST['index']);
    $index = $_POST['index'];
    // Modification des informations dans la BDD
    $conn = BDDConnection($host,$dbname,$username,$password);
    $booleanVerifACT = ModifBDD($conn,$nameOfTable,$tabFinal,$index);
    echo json_encode($booleanVerifACT);

}

function VerifTabSend($index)
{
  /*Cette fonction va return le nom de la table correspond à l'index chosis
  */
  if($index == 0){return "structure";}
  if($index == 1){return "coordonee";}
  if($index == 2){return "document";}
  if($index == 3){return "userid";}
  else{return "Error";}
}
function ModifBDD($conn,$nameOfTable,$tabFinal,$index)
{
  /*Cette fonction va modifier l'intégralité de la table concerner par les changements
  qui ont pue être effectué coté utilisateur
  $conn : variable contenant l'intégralité des informations relatif à la connexion
  dans la bdd
  $nameOfTable : Nom de la table
  $tabFinal : contient toutes les informations de l'interface coté utilisateur
  qui auront pour objectif d'être modifier
  $index : correspond au numéro de table son seul objectif et de bien se positionner
  dans la variable : $tableauAllInfo initialiser ci-dessous
  Il y a donc 3 conditions pour gérer les cas spéciaux qui peut être rencontrer
  comme les images ou le nombre d'utilisateur.
  */
  // tous les format accepter

  //Boucle visant à supprimer les failles d'en l'entrer utilisateur
  try
  {
    for($i = 0;$i<count($tabFinal);$i++)
    {
      $tabFinal[$i] = htmlspecialchars(strip_tags($tabFinal[$i]));
    }
    $tableauOfTypeAccept = ["data:image/jpeg;base64","data:image/png;base64",
    "data:image/gif;base64","data:image/jpg;base64"];
    $tableauAllInfo = [['NomCourt','NomComplet','TypeAccueil','RaisonSocial','Telephone','Fax',
    'Email','SiteInternet','CodeStructure','Codeorganisme','CAF','Academie','AgrementMax'],
    ["Numero","Adresse","Complement","CodePostal","Ville"],
    ['Logo','TexteAtLogo','NumeroSiret','PInformation','ConsigneReglement','Signataire'],
    ['email','pseudo','photoProfile']];
    if($nameOfTable == "structure" || $nameOfTable == "coordonee")
    {
      $sql = "UPDATE `".$nameOfTable."` SET ";
      for($i = 0;$i<count($tabFinal);$i++)
      {
        // Création de la requete SQL
        if($i <count($tabFinal)-1)
        {
          $sql .= $tableauAllInfo[$index][$i]." = '".$tabFinal[$i]."', ";
        }
        else
        {
          $sql .= $tableauAllInfo[$index][$i]." = '".$tabFinal[$i]."'";
        }
        
      }
      $statement = $conn->prepare($sql);
      $statement->execute();
      $statement->closeCursor();

    }
    elseif($nameOfTable == "document")
    {
      $booleanIsOK = false;
      for($e = 0;$e<count($tableauOfTypeAccept);$e++)
      {
        if(strpos($tabFinal[0],$tableauOfTypeAccept[$e]) !== false)
        {
          $booleanIsOK = true;
        }

      }
      
      if($booleanIsOK)
      {
        // Séparation de la base64 en type de fichier et données binaires
        list($type, $data) = explode(';', $tabFinal[0]);
        list(, $data)      = explode(',', $data);

        // Décodage des données binaires
        $data = base64_decode($data);
        // Enregistrement des données dans un fichier dans un répertoire spécifique
        //Récupération du lien de l'image à utiliser
        $statement = $conn->prepare("SELECT Logo from $nameOfTable WHERE id = 1");
        $statement->execute();
        $resultat = $statement->fetch();
        $statement->closeCursor();
        unlink($resultat['Logo']);
        file_put_contents($resultat['Logo'], $data);
      }
      // modification de tous les éléments relatif
      $sql = "UPDATE `".$nameOfTable."` SET ";
      for($i = 1;$i<count($tabFinal);$i++)
      {
        // Création de la requete SQL
        if($i <count($tabFinal)-1)
        {
          $sql .= $tableauAllInfo[$index][$i]." = '".$tabFinal[$i]."', ";
        }
        else
        {
          $sql .= $tableauAllInfo[$index][$i]." = '".$tabFinal[$i]."'";
        }
        
      }
      $statement = $conn->prepare($sql);
      $statement->execute();
      $statement->closeCursor();
    
    }
    elseif($nameOfTable == "userid")
    {
      
      $counter = count($tabFinal);
      $id = 1;
      for($i = 2;$i<$counter;$i+=3)
      {
        $booleanIsOK = false;
        for($e = 0;$e<count($tableauOfTypeAccept);$e++)
        {
          if(strpos($tabFinal[$i],$tableauOfTypeAccept[$e]) !== false)
          {
            $booleanIsOK = true;
            // echo "Je suis vérifier : ".$id."\n";
          }
          else
          {
            // echo "Je ne suis pas vérifier : ".$id."\n";
          }
          
        }
        if($booleanIsOK)
        {
          // Séparation de la base64 en type de fichier et données binaires
          list($type, $data) = explode(';', $tabFinal[$i]);
          list(, $data)      = explode(',', $data);
          // Décodage des données binaires de l'image
          $data = base64_decode($data);
        
          //Récupération du lien actuelle de l'image utiliser
          /* REQUETE SQL */
          $statement = $conn->prepare("SELECT photoProfile from $nameOfTable WHERE id = $id");
          $statement->execute();
          $resultat = $statement->fetch();
          $statement->closeCursor();

          //Récupération du type la new image
          $type = explode("/",$type)[1];
          //Création du nouveau lien de la nouvelle image
          $nameImage = "../ImageBDD/userImage".$id."_".$tabFinal[$i-1].".".$type;
          /* REQUETE SQL */
          $sql = 'UPDATE `'.$nameOfTable.'` SET '.
          $tableauAllInfo[$index][2].' = "'.$nameImage.'"';
          $sql.=" WHERE id = ".$id;
          $statement = $conn->prepare($sql);
          $statement->execute();
          $statement->closeCursor();

          //REPLACE OLD IMAGE BY THE NEW IMAGE
          try{
            unlink($resultat['photoProfile']);
            file_put_contents($nameImage, $data);
          }
          catch(Exception $Error){echo "Erreur : ".$Error->getMessage();}

        }
        $id++;
      }
      $sql = "UPDATE `".$nameOfTable."` SET ";
      $y = 0;
      $AllanGPT = 1;
      
      for($i = 0;$i<count($tabFinal);$i++)
      {
        // Création de la requete SQL
        
        if($i <count($tabFinal)-1 && ($i+1)%3 != 0)
        {
          if($y%2 == 0) $sql .= $tableauAllInfo[$index][$y]." = '".$tabFinal[$i]."', ";
          else $sql .= $tableauAllInfo[$index][$y]." = '".$tabFinal[$i]."'";
        }
        $y++;
        if(($i+1)%3 == 0)
        {
          $y = 0;
          $sql.=" WHERE id =".$AllanGPT;$AllanGPT++;
          $statement = $conn->prepare($sql);
          $statement->execute();
          $statement->closeCursor();
          $sql = "UPDATE `".$nameOfTable."` SET ";
        }
      
      }
    
    }
    return true;
  }
  catch (Exception $e) {
    echo 'Exception reçue : ',  $e->getMessage(), "\n";
    return false;
}
}

?>