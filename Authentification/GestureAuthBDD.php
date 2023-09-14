<?php
session_start();
/*
  Attention faire des echo ou des vardump casse totalement le code avec la méthode asynchrone
*/
//Initialisation des variables ! 
$success = 0;
$msg = "proute";
$adresse = "";

//Verification saisie email et password
if(isset($_POST['email']) && isset($_POST['password']))
{
  $email = htmlspecialchars(strip_tags($_POST['email']));
  $passwordInput = htmlspecialchars(strip_tags($_POST['password']));

  // Les parametres de la BDD ainsi que la fonction
  include('../FonctionPHP/functionBDD.php');

  // appelle de la fonction de connection à la BDD
  $conn = BDDConnection($host,$dbname,$username,$password);

  //Vérification de la saisie de l'@mail
  $statement = $conn->prepare("SELECT email,ID FROM userid");
  $statement->execute();
  while($data = $statement->fetch(PDO::FETCH_OBJ))
  {
    if($email == $data->email)
    {
      $id = $data->ID;
      $statement->closeCursor();
    }
  }
  //Si le @mail est bonne alors vérification du mot de passe
  if(isset($id))
  {
    // Requête SQL
    $statement = $conn->prepare("SELECT MotDePasse,pseudo,ID FROM userid WHERE ID = :IDUser");
    $statement->execute(["IDUser" => $id]);
    $data = $statement->fetch(PDO::FETCH_OBJ);
    $passwordHash = $data->MotDePasse;
    $pseudo = $data->pseudo;
    
    if(password_verify($passwordInput,$passwordHash))
    {
      $success = 1;
      $msg = "Authentification autorisée !";
      $adresse = "../PageHTML/Accueil.html.php";
      $_SESSION['email'] = $email;
      $_SESSION['password'] = $passwordInput;
      $_SESSION['pseudo'] = $pseudo;
    }
    else
    {
      $success = 0;
      $msg = "Une erreur est survenue !";
    }
  }
  else
  {
    $success = 0;
    $msg = "Une erreur est survenue !";
  }

}
else
{
  //Si l'entrée n'est pas valide on renvoie l'utilisateur sur la page d'authentification
  $success = 0;
  $msg = "Une erreur est survenue !";
}
$res = ["success" => $success, "msg" => $msg,"adresse" => $adresse];
echo json_encode($res);
?>