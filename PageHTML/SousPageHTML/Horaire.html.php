<?php session_start();
if(isset($_SESSION['pseudo']))
{
    // Affichage de la page Horaire

include '../../FonctionPHP/HeaderGesture.php';
include '../../PhpHoraire/AffichageCalendrier.php';
HeaderCreate("Horaire", true, 4);
?>
<link rel="stylesheet" href="../../css/Horaire.css">
<script src="../../JS/jquery-3.6.4.js"></script>
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

<body>
    <section>
        <div class="FirstBlock">
            <h1 class="Title ">Horaires
                <img src="../../Image/editButton.svg" id="EditHoraire" class="EditHoraireClass" width="25px" height="25px"></a>
            </h1>
            <div class="BorderTitle"></div>
            <!-- Barre de séparation -->
            <div class="HoraireSize my-auto mx-auto">
                <div class="flex flex-col justify-around">
                    <div class="LignHoraire">
                        <p class="NameRubrique2" style="border-bottom: 1px solid rgb(221, 225, 238);">
                            Amplitude d'ouverture</p>
                        <div class="LigneSquareUniq"></div>
                        <!-- Affichage des horaires par jours  Matin -->
                        <div class="CenterSecondPart">
                            <p class="">de</p>
                            <input class="TextInput" type="text" id="IDAmplOuv1" maxlength="5" min="00:00" max="23:59">
                            <p>à</p>
                            <input class="TextInput" type="text" id="IDAmplOuv2" maxlength="5" min="00:00" max="23:59">
                        </div>
                    </div>
                    <div class="CheckBoxContent">
                        <input type="checkbox" id="IDCheckBoxModif">
                        <label for="AmplOuverture">Horaire d'ouverture par jour</label>
                    </div>
                    <div class="LignHoraire">
                        <p class="NameRubrique2 flex justify-center items-center" style="border-bottom: 1px solid rgb(221, 225, 238);">
                            Lundi</p>
                        <div class="LigneSquareRight"></div>

                        <div class="CenterSecondPart">
                            <p>de</p>
                            <input class="TextInput" type="text" size="5" id="IDLundi1" maxlength="5" min="00:00" max="23:59">
                            <p>à</p>
                            <input class="TextInput" type="text" size="5" id="IDLundi2" maxlength="5" min="00:00" max="23:59">
                        </div>
                    </div>
                    <div class="LignHoraire">
                        <p class="NameRubrique2 flex justify-center items-center" style="border-bottom: 1px solid rgb(221, 225, 238);">
                            Mardi</p>
                        <div class="LigneSquareRight"></div>
                        <!-- Affichage des horaires par jours  Matin -->
                        <div class="CenterSecondPart">
                            <p class="">de</p>
                            <input class="TextInput" type="text" size="5" id="IDMardi1" maxlength="5" min="00:00" max="23:59">
                            <p>à</p>
                            <input class="TextInput" type="text" size="5" id="IDMardi2" maxlength="5" min="00:00" max="23:59">
                        </div>
                    </div>
                    <div class="LignHoraire">
                        <p class="NameRubrique2 flex justify-center items-center" style="border-bottom: 1px solid rgb(221, 225, 238);">
                            Mercredi</p>
                        <div class="LigneSquareRight"></div>
                        <!-- Affichage des horaires par jours  Matin -->
                        <div class="CenterSecondPart">
                            <p class="">de</p>
                            <input class="TextInput" type="text" size="5" id="IDMercredi1" maxlength="5" min="00:00" max="23:59">
                            <p>à</p>
                            <input class="TextInput" type="text" size="5" id="IDMercredi2" maxlength="5" min="00:00" max="23:59">
                        </div>
                    </div>
                    <div class="LignHoraire">
                        <p class="NameRubrique2 flex justify-center items-center" style="border-bottom: 1px solid rgb(221, 225, 238);">
                            Jeudi</p>
                        <div class="LigneSquareRight"></div>
                        <!-- Affichage des horaires par jours  Matin -->
                        <div class="CenterSecondPart">
                            <p class="">de</p>
                            <input class="TextInput" type="text" size="5" id="IDJeudi1" maxlength="5" min="00:00" max="23:59">
                            <p>à</p>
                            <input class="TextInput" type="text" size="5" id="IDJeudi2" maxlength="5" min="00:00" max="23:59">
                        </div>
                    </div>
                    <div class="LignHoraire mb-3">
                        <p class="NameRubrique2 flex justify-center items-center">
                            Vendredi</p>
                        <div class="LigneSquareRight"></div>
                        <!-- Affichage des horaires par jours  Matin -->
                        <div class="CenterSecondPart">
                            <p class="">de</p>
                            <input class="TextInput" type="text" size="5" id="IDVendredi1" maxlength="5" min="00:00" max="23:59">
                            <p>à</p>
                            <input class="TextInput" type="text" size="5" id="IDVendredi2" maxlength="5" min="00:00" max="23:59">
                        </div>
                    </div>
                    <div class="border-b border-stone-300 ml-6 mr-9"></div>
                    <div class="LignHoraire mt-3">
                        <p class="NameRubrique2 flex justify-center items-center">
                            Horaire enfant repas</p>
                        <div class="LigneSquareUniq"></div>
                        <!-- Affichage des horaires par jours repas -->
                        <div class="CenterSecondPart">
                            <p>de</p>
                            <input class="TextInput" type="text" size="5" id="IDHoraireR1" maxlength="5">
                            <p>à</p>
                            <input class="TextInput" type="text" size="5" id="IDHoraireR2" maxlength="5">
                        </div>
                    </div>
                </div><!-- Fin de HoraireSize -->
            </div><!-- SpaceBetween -->
            <div class=" flex justify-evenly items-center my-auto">
                <img src="../../Image/back.svg" id="Back0" class="animationBiging w-10 h-10">
                <img src="../../Image/save.png" id="Save0" class="animationBiging w-10 h-10">
            </div>
        </div> <!-- Fin de FirstBlock -->
        <div class="SecondBlock">

            <h1 class="Title">Calendrier
                <img src="../../Image/editButton.svg" id="EditCalendrier" class="EditHoraireClass" width="25px" height="25px"></a>
            </h1>
            <div class="BorderTitle"></div>
            <div class="ChoiceYears">
                <img src="../../Image/calendar/arrow-left-back.svg" width="100px" height="100px" id="Arrow-left" class="animationBiging pointer-events-auto">
                <label id="YearsAffic"></label>
                <img src="../../Image/calendar/arrow-right-back.svg" width="100px" height="100px" id="Arrow-right" class="animationBiging pointer-events-auto">

            </div>
            <!-- Génération du calendrier dans cette espace -->
            <div class="containerCalendar" id="containerCalendar">
                <?php
                GenerateCalendar();
                ?>
            </div>
            <div class="flex justify-evenly items-center mt-auto pb-2">
                <img src="../../Image/back.svg" id="BackC" class="animationBiging w-10 h-10">
                <img src="../../Image/save.png" id="SaveC" class="animationBiging w-10 h-10">
            </div>
            <div class="SecondMinBlock">
                <!-- création des différents bloc de couleurs -->
                <div class="LignSMB">
                    <div class="SquareSMB" id="Square1">
                        
                    </div>
                    <div class="TextAreaSMB">
                        <span id="VSC">
                        VSC
                        </span>
                    </div>
                </div>
                <div class="LignSMB">
                    <div class="SquareSMB" id="Square2" >
                        
                    </div>
                    <div class="TextAreaSMB">
                        <span id="JDF">
                        JDF
                        </span>
                    </div>
                </div>
                <div class="LignSMB">
                    <div class="SquareSMB" id="Square3" >
                        
                    </div>
                    <div class="TextAreaSMB">
                        <span id="JDC">
                        JDC
                        </span>
                    </div>
                </div>
                <div class="LignSMB">
                    <div class="SquareSMB" id="Square4" >
            
                    </div>
                    <div class="TextAreaSMB">
                        <span id="JDO">
                            JDO
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="overlay">
        <img src="../../Image/spin.svg" width="150px" height="150px" class="spinClasse">
        <img src="../../Image/check.svg" width="147px" height="147px" class="NewImageClasse">
    </div>
    <?php
    // echo $_SESSION['pseudo'];
    ?>
    <script src="../../JS/Horaire.js"></script>

</body>

</html>
<?php
}?>