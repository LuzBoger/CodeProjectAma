<?php
function DetailsStruc($conn)

{
    //$tableau est une variable qui parcourent l'intégralité de la table
    //concerné et en affiche les informations
    $tableau = [/*'ID',*/'NomCourt','NomComplet','TypeAccueil','RaisonSocial','Telephone','Fax','Email','SiteInternet'
    ,'CodeStructure','Codeorganisme','CAF','Academie','AgrementMax'];
    //Inclusion de l'outil de connection à la BDD
    //Requete SQL récupérant uniquement la première ligne
    $statement = $conn->prepare("SELECT * FROM structure WHERE ID=1");
    $statement->execute();
    $data = $statement->fetch(PDO::FETCH_ASSOC);
    ?>
    <!-- Création d'une table pour afficher les différents informations concerné -->
    <table><?php
    for($i = 0;$i<count($tableau);$i++)
    {
        ?>
        <tr>
            <td class="tdWithoutModification"><?php echo $tableau[$i] ?></td>
            <td class="tdModification0" contenteditable="false"><?php echo $data[$tableau[$i]]?></td>
        </tr>
    <?php
    }
    $statement->closeCursor();?>
    </table>
    <?php

}?>
<?php
function DetailsCoord($conn)
{
    //$tableau est une variable qui parcourent l'intégralité de la table
    //concerné et en affiche les informations
    $tableau = [/*'ID',*/'Numero','Adresse','Complement','CodePostal','Ville'];
    //Inclusion de l'outil de connection à la BDD
    //Requete SQL récupérant uniquement la première ligne
    $statement = $conn->prepare("SELECT * FROM coordonee WHERE ID=1");
    $statement->execute();
    $data = $statement->fetch(PDO::FETCH_ASSOC);
    ?>
    <!-- Création d'une table pour afficher les différents informations concerné -->
    <table>
    <?php
    for($i = 0;$i<count($tableau);$i++)
    {
        ?>
        <tr>
            <td class="tdWithoutModification1"><?php echo $tableau[$i] ?></td>
            <td class="tdModification1" ><?php echo $data[$tableau[$i]]?></td>
        </tr>
    <?php
    }
    $statement->closeCursor();
    ?>
    </table>
    <?php

}?>
<?php
function DetailsDoc($conn)
{
    /*
    Fonction créant un tableau dans la page Générale des différents informations
    return none;
    */
    //$tableau est une variable qui parcourent l'intégralité de la table
    //concerné et en affiche les informations
    $tableau = [/*'ID',*/'Logo','TexteAtLogo','NumeroSiret','PInformation','ConsigneReglement','Signataire'];
    //Inclusion de l'outil de connection à la BDD
    //Requete SQL récupérant uniquement la première ligne
    $statement = $conn->prepare("SELECT * FROM Document WHERE ID=1");
    $statement->execute();
    $data = $statement->fetch(PDO::FETCH_ASSOC);
    ?>
    <!-- Création d'une table pour afficher les différents informations concerné -->
    <table>
    <?php
    for($i = 0;$i<count($tableau);$i++)
    {
        ?>
        <tr>
            <td class="tdWithoutModification"><?php echo $tableau[$i];?></td>
            <td class="tdModification2"><?php if ($tableau[$i] == 'Logo')
            {
            // création d'une fonction
            echo '<img src= "../imageBDD/logo0.png" width = "50" height = "50" class="ImageInTable"/>';
            }
            else{echo $data[$tableau[$i]];}?></td>
        </tr>
    <?php
    }
    $statement->closeCursor();
    ?>
    </table>
    <?php

}
function DetailsUser($conn)
{
    $numberRow = getNumberowInTable('userid',$conn);
    /*
    Fonction créant un tableau dans la page Générale des différents informations
    return none;
    */
    $tableau = [/*'ID',*/'email','pseudo','photoProfile'];
    $statement = $conn->prepare("SELECT * FROM userid");
    $statement->execute();
    $data = $statement->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <!-- Création d'une table pour afficher les différents informations concerné -->
    <table>
    <?php
    $test = -1;
    for($j = 0;$j<$numberRow;$j++)
    {
        for($i = 0;$i<count($tableau);$i++)
        {
            $test+=1;
            ?>
            <tr>
                <td class="tdWithoutModification"><?php echo $tableau[$i];?></td>
                <td class="tdModification3"><?php if ($tableau[$i] == 'email'){
                    echo $data[$j][$tableau[$i]];
                }
                elseif($tableau[$i] == 'photoProfile'){
                echo '<img src= "'.$data[$j][$tableau[$i]].'"
                width = "50" height = "50" class="ImageInTable"/>';}
                else{echo $data[$j][$tableau[$i]];}?></td>
            </tr>
        <?php
        }
    }
    $statement->closeCursor();
    ?>
    </table>
    <?php

}?>