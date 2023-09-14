<?php session_start();
if(isset($_SESSION['pseudo']))
{
    // Affichage de la page d'accueil
?>
<!-- Création de la page ACCUEIL -->
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="shortcut icon" href="../Image/logo.png" />
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styleTailwind.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/Accueil.css">
    <script src="../JS/jquery-3.6.4.js"></script>
    <div style="background:pink;color:#333;position:fixed;right:0;bottom:0;z-index:99999999;font:1em arial;opacity:.9" id="ld"></div><script>setInterval(function(){if($(window).height()>=$(document).height()){$('#ld').text($(document).width()+' px & ' + $(window).height() + ' px');}else{$('#ld').text($(document).width()+17+' px & ' + $(window).height() + ' px');}},150);
    </script>
    <title>Accueil</title>
</head>
<body>
    <section>
        <div class="WhiteSquare">
            <div class="Lign">
                <div class="buttonDesign">
                    <h1>Pointage</h1>
                    <a href="Pointage.html.php">
                    <img src="../Image/fleche.svg" class="imageSVG"width="80px" height="80px"></a>

            </div>
                <div class="buttonDesign">
                    <h1>Facturation</h1>
                    <a href="Facturation.html.php">
                    <img src="../Image/fleche.svg" class="imageSVG"width="80px" height="80px"></a>
                </div>
            </div>
            <div class="Lign">
                <div class="buttonDesign">
                    <h1>Dossier</h1>
                    <a href="Dossier.html.php">
                    <img src="../Image/fleche.svg" class="imageSVG"width="80px" height="80px"></a>
                </div>
                <div class="buttonDesign">
                    <h1>Bilan</h1>
                    <a href="Bilan.html.php">
                    <img src="../Image/fleche.svg" class="imageSVG"width="80px" height="80px"></a>
                </div>
            </div>
            <div class="Lign">
                <div class="buttonDesign">
                    <h1>Paramètres</h1>
                    <a href="Générale.html.php">
                    <img src="../Image/fleche.svg" class="imageSVG"width="80px" height="80px"></a>
                </div>
            </div>
            
        </div>
    </section>
    <script src="../JS/Accueil.js"></script>
</body>
</html>

<?php
}   ?>