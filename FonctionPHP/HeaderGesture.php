<?php
function HeaderCreate($name, $boolean,$NumEtu)
/* La fonction HeaderCreate va automatique créer le header d'une quelqu'onque page en fonction
de plusieurs paramêtres
 $name correspond au nom de la page qui appelle la fonction
 $boolean ce boulean permet de vérifier si la page qui l'appelle est une sous page ou pas
 $NumEtu correspond à quel tableau utiliser pour afficher ça page donc l'index
 varie entre 1 et 4;
 Return : La fonction ne return rien
*/
{
    // Array de toutes les différents page du site
    $arrayAllPage = [['Synthèse','Enfant','Foyer','Contrat','Compte'],['Journalier','Hebdomadaire','Mensuel'],
    ["Synthèse","Facturation","Regularisation","Facture","Encaisse"],['Horaire','Générale']];
    ?>
<?php
if($boolean){$chaine = "../";}
else{$chaine = "";}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="<?php echo $chaine ?>../image/logo.png"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo $chaine ?>../css/styleTailwind.css">
    <link rel="stylesheet" href="<?php echo $chaine ?>../css/header.css">
    <title><?php echo $name ?></title>
</head>
    <!-- BARRE DE NAVIGATION -->

    <body>
    
    <nav class="w-full h-auto justify-between  bg-AmaGreen flex  font-bold text-center">
        <div class="flex"> 
            <a class="flex" href="<?php echo $chaine ?>../PageHTML/Accueil.html.php">
                <img  class="p-1 mb-1"src="<?php echo $chaine ?>../Image/logo.png" alt="LogoAma" width="100" height="100" >
            </a>
        </div>
        <div class="flex my-auto space-x-8 mr-8">
        <?php
            // echo $arrayAllPage[$NumEtu-1];
            foreach($arrayAllPage[$NumEtu-1] as $i)
            {
                
                    if ($i != $name)
                    {
                        if($boolean){$chaine2 = '';}
                        else{$chaine2 = 'SousPageHTML/';}
                        echo '<a href="http://ama/ProJectGarderie/PageHTML/'.$chaine2.$i.'.html.php"> <button class=" text-AmaBordure w-32  hover:bg-HoverGreen border-2 rounded-lg border-AmaBordure m-6 h-8" >'.$i.'</button> </a>';
                    }
                    if ($i == $name)
                    {
                        if($boolean){$chaine2 = 'SousPageHTML/';}
                        else{$chaine2 = '';}
                        ?>
                        <div class=" flex flex-col-reverse">
                        <?php
                        echo '<a href="http://ama/ProJectGarderie/PageHTML/'.$chaine2.$i.'.html.php"> <button class=" text-AmaBordure w-32  bg-HoverGreen border-l-2 border-r-2 border-t-2 h-16  rounded-t-lg border-AmaBordure" >'.$i.'</button> </a>';
                        ?>
                        </div>
                        <?php
                    }
                    
                }
            ?>
        </div>
    </nav>
    <!-- FIN BARRE NAV -->
    <?php
}

?>