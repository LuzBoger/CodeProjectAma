<?php session_start();
if(isset($_SESSION['pseudo']))
{
    // Création de la page Générale
?>
<link rel="stylesheet" href="../css/Générale.css">
<?php
include("../fonctionPHP/HeaderGesture.php");
include("../fonctionPHP/functionBDD.php");
$conn = BDDConnection($host, $dbname, $username, $password);
HeaderCreate("Générale", false, 4);
require('../PhpParam/AffichageTabGénérale.php');
?>
<script src="../JS/jquery-3.6.4.js"></script>
<div style="background:pink;color:#333;position:fixed;right:0;bottom:0;z-index:99999999;font:1em arial;opacity:.9" id="ld"></div>
<script>
    setInterval(function() {
        if ($(window).height() >= $(document).height()) {
            $('#ld').text($(document).width() + ' px & ' + $(window).height() + ' px');
        } else {
            $('#ld').text($(document).width() + 17 + ' px & ' + $(window).height() + ' px');
        }
    }, 150);
</script>
<section>
    <div class="squareWhite shadow-lg shadow-gray-300">
        <div class="title">
            Détail de la structure
        </div>
        <img src="../Image/editButton.svg" id="popUpEdit0" class="flex self-end mr-2 cursor-pointer" width="25px" height="25px"></a>
        <div class="tableauAll overflow-y-auto h-hstrutc" id="Table-1">
            <?php
            DetailsStruc($conn);
            ?>
        </div>
        <div class="buttonSquareGestion">
            <img src="../Image/back.svg" id="Back0" class="animationBiging" width="40px" height="40px">
            <img src="../Image/save.png" id="Save0" class="animationBiging" width="40px" height="40px">
        </div>
    </div>
    <div class="squareWhite shadow-lg shadow-gray-300">
        <div class="title">
            Coordonnées
        </div>
        <img src="../Image/editButton.svg" id="popUpEdit1" class="flex self-end mr-2 cursor-pointer" width="25px" height="25px"></a>
        <div class="tableauAll overflow-y-auto h-hcoord" id="Table-2">
            <?php
            DetailsCoord($conn);
            ?>
        </div>
        <div class="buttonSquareGestion">
            <img src="../Image/back.svg" id="Back1" class="animationBiging" width="40px" height="40px">
            <img src="../Image/save.png" id="Save1" class="animationBiging" width="40px" height="40px">
        </div>
    </div>
    </div>
    <div class="squareWhite shadow-lg shadow-gray-300">
        <div class="title">
            Documents
        </div>
        <img src="../Image/editButton.svg" id="popUpEdit2" class="flex self-end mr-2 cursor-pointer" width="25px" height="25px"></a>
        <div class="tableauAll overflow-y-auto h-hdoc" id="Table-3">
            <?php
            DetailsDoc($conn);
            ?>
        </div>
        <div class="buttonSquareGestion">
            <img src="../Image/back.svg" id="Back2" class="animationBiging" width="40px" height="40px">
            <img src="../Image/save.png" id="Save2" class="animationBiging" width="40px" height="40px">
        </div>
    </div>
    <div class="squareWhite shadow-lg shadow-gray-300">
        <div class="title">
            Utilisateurs
        </div>
        <img src="../Image/editButton.svg" id="popUpEdit3" class="flex self-end mr-2 cursor-pointer" width="25px" height="25px"></a>
        <div class="tableauAll overflow-y-auto h-huser" id="Table-4">
            <?php
            DetailsUser($conn);
            ?>
        </div>
        <div class=" flex flex-row justify-around m-2">
            <div class="buttonUser bg-jotaro" id="buttonAdd">
                AJOUTER
            </div>
            <div class="buttonUser bg-dio" id="buttonRemove">
                SUPPRIMER
            </div>
        </div>
        <div class="buttonSquareGestion">
            <img src="../Image/back.svg" id="Back3" class="animationBiging" width="40px" height="40px">
            <img src="../Image/save.png" id="Save3" class="animationBiging" width="40px" height="40px">
        </div>
    </div>
</section>
<div id="overlay" class="fixed inset-0 bg-gray-300 bg-opacity-30 justify-center items-center hidden">
    <div id="popupAdd" class="PopUPRetour shadow-xl shadow-gray-700 hidden">
        <img src="../image/cross.svg" class="w-6 h-6 flex self-end cursor-pointer" id="exitPopUpAdd">
        <label for="NameEmail">email</label>
        <input type="email" id="email" class="border"></input>
        <label for="NamePassword">password</label>
        <input type="password" id="password" class="border"></input>
        <label for="NamePseudo">pseudo</label>
        <input type="text" id="pseudo" class="border"></input>
        <label for="NameImage">image</label>
        <input type="file" id="image" accept="image/*"></input>
        <img src="../Image/save.png" id="SavePopUp" class="animationBiging pointer-events-none mt-auto self-center mb-3" width="40px" height="40px">
    </div>
    <div id="popupRemove" class="PopUPRetour shadow-xl shadow-gray-700 hidden">
        <img src="../image/cross.svg" class="w-6 h-6 flex self-end cursor-pointer" id="exitPopUpRemove">
        <select id="SelectTri" class="selectClass">
            <option value="">--Veuillez choisir une option--</option>
            <option value="email">Adresse Mail</option>
            <option value="pseudo">Pseudonyme</option>
        </select>
        <select id="SelectList" class="selectClass mt-3">
            <option value=""></option>
        </select>
        <label id="labelInfoUser" class="text-center text-17 font-sans font-normal text-colorWrite self-center mt-5"></label>
        <img src="../Image/save.png" id="SavePopUp2" class="animationBiging pointer-events-none mt-auto self-center mb-3" width="40px" height="40px">
    </div>
</div>
<div class="overlay">
    <img src="../Image/spin.svg" width="150px" height="150px" class="spinClasse">
    <img src="../Image/check.svg" width="147px" height="147px" class="NewImageClasse">
</div>
<script src="../JS/Parametre.js"></script>
</body>

</html>
<?php } ?>