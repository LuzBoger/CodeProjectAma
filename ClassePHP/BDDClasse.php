<?php
class BDDGestion
{
    /* Initialiation des variable Private de la classe BDDGestion */
    private string $host;
    private string $dbname;
    private string $username;
    private string $password;
    private $conn;
    private string $TableBDD;

    public function __construct(string $host,string $dbname,string $username,string $password) 
    {
        /* Création du constructeur, varaible d'initialisation : 
            $host : Adresse ip de la BDD 
            $dbname : Nom de la base de donnée
            $username : Le nom d'utilisateur
            $password : Mot de passe de connection si nécessaire
        */
        $this->host = $host;
        $this->dbname = $dbname;
        $this->username = $username;
        $this->password = $password;
      }
    public function __destruct() {
        /*Destructeur de la classe, désactivation de la connection puis  */
        // echo "L'objet a été détruit.";
        unset($this->conn);
    }
    /*  Initialisation de la table qui va être utilisée par les autre fonctions via 
        des requêtes SQL.
    */
    public function SetNameTable(string $TableBDD){$this->TableBDD = $TableBDD;}

    public function StartingConnection()
    {
        /*  La fonction "StartingConnection" fait office d'outil de connection à la BDD
            Elle reçoit les 4 parametre minimum de connection initialiser plus tôt par le 
            constructeur de la classe, la gestion d'erreur est aussi gérer dans cette fonction
            elle sera afficher pour l'utilisateur.
        */
        try{
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }catch (PDOException $e){
            echo "Erreur :".$e->getMessage()."<br>";
            die;
            }
    }

    public function SelectColumn(array $arrayColl = ["*"])
    {
        /*  Cette fonction permet d'afficher une colonne précise ou toutes les colonnes,
            voici un exemple concrèt : $arrayColl = ["NOM","PRENOM"];
            ceci va donc afficher Les informations "NOM" && "PRENOM" de chaque ligne
            Si vous ne mettez pas de parametre alors elle recupérera tous les élément de la table.
            Cette fonction va return un tableau de tous les éléments
            Le premier index correspond à la ligne et le deuxième à la colonne
            exemple : $test[1][6] : Première ligne de la table et 6 colonne de cette ligne.
        */
        
        try
        {
            $taille=count($arrayColl);
            $sql = "SELECT ";
            for($i=0;$i<$taille;$i++)
            {  
                if($i==$taille-1) $sql.= $arrayColl[$i];
                else $sql.=$arrayColl[$i].",";
            }
            $sql.=" FROM {$this->TableBDD}";
            $statement = $this->conn->prepare($sql);
            $statement->execute();
            $data = $statement->fetchAll();
            $statement->closeCursor();
            return $data;
        }
        catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
        
    }

    public function SelectSearch(array $arrayColl,$colName,$value,$paramComparaison = "=")
    {
        /*  Cette fonction va chercher un élément dans $colName via la  variable $value
            $ArrayColl permet de choisir quel élement voulez vous récupérer
            si vous rentrez pour $arrayColl = ["*"] alors toutes les informations de la ligne concerner
            vous sera retournez.
            */
        try
        {
            $taille=count($arrayColl);
            $sql = "SELECT ";
            for($i=0;$i<$taille;$i++)
            {  
                if($i==$taille-1) $sql.= $arrayColl[$i];
                else $sql.=$arrayColl[$i].",";
            }
            $sql.=" FROM {$this->TableBDD} WHERE {$colName}$paramComparaison'$value'";
            //echo $sql;
            $statement = $this->conn->prepare($sql);
            $statement->execute();
            $data = $statement->fetchAll();
            $statement->closeCursor();
            return $data;
        }
        catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
        
    }
    public function RequeteSQlTreatment($sql)
    {
        /*Fonction recevant une requte SQL, elle à pour objectif de traiter tous les cas spéciaux
        Qui ne peuvent pas être traiter par la classe actuellement

        */
        try
        {
            $statement = $this->conn->prepare($sql);
            $statement->execute();
            $data = $statement->fetchAll();
            $statement->closeCursor();
            return $data;
        }
        catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }

    }
    public function GetNumberOfRowInTable()
    {
        /*
        Fonction permettant d'obtenir le nombre de ligne dans une table
        quelqu'onque
        input : $nameTable représente le nom de la table que l'on recherche
        return : renvoie le nombre de ligne qu'il y a dans une colonne
        */
        try{
            $statement = $this->conn->prepare("SELECT COUNT(*) FROM ".$this->TableBDD);
            $statement->execute();
            $num_rows = $statement->fetchColumn();
            return $num_rows;
        }
        catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }
    public function UpdateINTOBDD($tableauAssoc,$index)
    {
        try{
            $sql = "UPDATE ".$this->TableBDD." SET ";
            $cles = array_keys($tableauAssoc);
            foreach ($tableauAssoc as $cle => $valeur) {
                if($cle == end($cles))
                {
                    //echo $cle . " : " . $valeur . "<br>";
                    $sql.= $cle." = '".$valeur."'";
                }
                else
                {
                    //echo $cle . " : " . $valeur . "<br>";
                    $sql.= $cle." = '".$valeur."',";
                }
            }
            $sql.=" WHERE id = ".$index;
            $statement = $this->conn->prepare($sql);
            $statement->execute();
            return true;
        }
        catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return false;
        }

    }

}
/*
$host = 'localhost';
$dbname = 'bddprojectama';
$username = 'root';
$password = 'J11Tx1BQ';
$objet = new BDDGestion($host,$dbname,$username,$password);
$objet->StartingConnection();// lancement de la connection à la BDD
$objet->SetNameTable("horaire_garderie");// Attribution de la table dans la quelle on souhaite faire nos requete);
echo "<br>";
$objet->UpdateINTOBDD(array("HEURE_DBT" => "09:30:00","HEURE_FIN" => "17:30:00"),1);
$objet->UpdateINTOBDD(array("HEURE_DBT" => "09:30:00","HEURE_FIN" => "17:30:00"),2);
/*
// $test = $objet->SelectColumn();
// print_r($test);
$test = $objet->SelectSearch(["*"],"NOM","mardi");
print_r($test);

$test = $objet->SelectColumn();//Récupération de tous 
$test=$objet->SelectSearch(["*"],"PRENOM","Arthur");// Récupération d'un élément précis
Via une recherche
print_r($test);//[0][1]ligne numéro 0, colonne numéro 1
echo "\n";
$num_rows = $objet->GetNumberOfRowInTable();
echo $num_rows;
echo "\n";
*/
?>


