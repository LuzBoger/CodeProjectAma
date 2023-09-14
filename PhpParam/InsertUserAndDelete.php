<?php
if(isset($_POST['email']) && isset($_POST['password']) && isset($_POST['pseudo'])
 && isset($_POST['image']))
 {
    try
    {
        include('../FonctionPHP/functionBDD.php');
        $conn = BDDConnection($host,$dbname,$username,$password);
        $numberOfLine = getNumberowInTable("userid",$conn);
        /*INITIALISATION DANS VARIABLE */
        $id = $numberOfLine+1;$pseudo = $_POST['pseudo'];
        $password = $_POST['password'];$image = $_POST['image'];
        $email = $_POST['email'];
        // Vérification des input Utilisateur
        $email = htmlspecialchars(strip_tags($email));
        $password = htmlspecialchars(strip_tags($password));
        $pseudo = htmlspecialchars(strip_tags($pseudo));
        $image = htmlspecialchars(strip_tags($image));
        // Hashing du mot de passe
        $HassPassword = HashingPassword($password);
        //ADD IN THE DATABASE
        $booleanTemp = SQLAddUser($conn,$id,$email,$HassPassword,$pseudo,$image);
        if($booleanTemp == true){echo json_encode(true);}
        else{echo json_encode(false);}
        
    }
    catch (Exception $e) {
        echo 'Exception reçue : ',  $e->getMessage(), "\n";
        echo json_encode(false);}
}

function HashingPassword($password)
{
    $HashPassword = password_hash($password, PASSWORD_DEFAULT);
    return $HashPassword;
}
function SQLAddUser($conn,$id,$email,$password,$pseudo,$image)
{
    /* IMAGE IMAGE IMAGE IMAGE IMAGE IMAGE */
    // Séparation de la base64 en type de fichier et données binaires
    list($type, $image) = explode(';', $image);
    list(, $image)      = explode(',', $image);
    // Décodage des données binaires de l'image
    $image = base64_decode($image);
    $type = explode("/",$type)[1];
    $linkImage = "../ImageBDD/userImage".$id."_".$pseudo.".".$type;
    $statement = $conn->prepare("INSERT INTO useridentification(NameOfUser,Password) VALUES(:NameOfUser,:Password)");
    // création de la requete SQL
    try {
        $sql = "INSERT INTO userid(id,email,motDePasse,pseudo,photoProfile)
        VALUES(:id,:email,:password,:pseudo,:linkImage)";
        $statement = $conn->prepare($sql);
        $statement->execute(["id" => $id, "email" => $email, "password" => $password,
        "pseudo" => $pseudo, "linkImage" => $linkImage]);
        $statement->closeCursor();
        // echo "Données insérées avec succès.";
        file_put_contents($linkImage, $image);
        return true;
    } catch(PDOException $e) {
        echo "Erreur lors de l'insertion des données: " . $e->getMessage();
        return false;
    }

}
if(isset($_POST['UserDeleted']))
{
    try
    {
        $userDeleted = $_POST['UserDeleted'];
        include('../FonctionPHP/functionBDD.php');
        $conn = BDDConnection($host,$dbname,$username,$password);
        $sql = "DELETE FROM userid WHERE ID =:IDUserDelete";
        $statement = $conn->prepare($sql);
        $statement->execute(["IDUserDelete" => $userDeleted]);
        $statement->closeCursor();
        //Maintenant l'objectif est de changer L'id
        $statement = $conn->prepare("SET @id = 0");
        $statement->execute();
        
        $statement = $conn->prepare("UPDATE userid SET id = (@id:=@id+1)");
        $statement->execute();
        $statement->closeCursor();
        echo json_encode(true);
    }
    catch (Exception $e) {
        echo 'Exception reçue : ',  $e->getMessage(), "\n";
        echo json_encode(false);}
    
} 
?>