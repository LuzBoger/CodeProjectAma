<?php
if(isset($_POST["years"]))
{
    GenerateCalendar($_POST["years"]);
}
function GenerateCalendar($years = null)
{
    if($years === null)
    {
        
        $annee = date("Y");
    }
    else
    {
        $annee = $years;
    }
    $premier_jour = strtotime($annee . '-01-01');
    $nom_jour = strftime('%A', $premier_jour);
    $number_jour = convDayInNumber($nom_jour);
    if($years == null)
    {
        // génération de la table directement Le HTML && PHP
        GenerateTableFirst($annee,$number_jour);
    }
    else
    {
        // génération des tables directement depuis le JS
        $calendarHTML = GenerateTableSecond($annee,$number_jour);
        if(strlen($calendarHTML) > 14782)
        {
            $res = ["success" => "OK", "calendarHTML" => $calendarHTML];
        }
        else
        {
            $res = ["success" => "NOK", "calendarHTML" => $calendarHTML];
        }
        echo json_encode($res);
    }
}
function JourInMonth($annee)
{
    $mois = [31,28,
    31,30,31,30,31,31,30,31,30,31];
    if ($annee % 4 == 0 && $annee % 100 != 0 || $annee % 400 == 0)
    {
        $mois[1]+=1;
    }
    return $mois;
}
function convDayInNumber($nom_jour)
{
    if($nom_jour == "Monday"){return 1;}
    if($nom_jour == "Tuesday"){return 2;}
    if($nom_jour == "Wednesday"){return 3;}
    if($nom_jour == "Thursday"){return 4;}
    if($nom_jour == "Friday"){return 5;}
    if($nom_jour == "Saturday"){return 6;}
    if($nom_jour == "Sunday"){return 7;}
}
function GenerateTableFirst($annee,$decalageDay)
{
    include("../../ClassePHP/BDDClasse.php");
    $host = 'localhost';
    $dbname = 'bddprojectama';
    $username = 'root';
    $password = 'J11Tx1BQ';
    $objet = new BDDGestion($host,$dbname,$username,$password);
    $objet->StartingConnection();// lancement de la connection à la BDD
    $objet->SetNameTable("calendrier");
    $AllInfoBDD = $objet->SelectSearch(["*"],"annee",$annee);
    if($AllInfoBDD == [])
    {
        $booleanChangeColor = false;
    }
    else
    {
        $booleanChangeColor = true;
    }
    $AllMonth = JourInMonth($annee);
    $NameMonth = ["janvier", "février", "mars", "avril", "mai", "juin", "juillet", "août", "septembre", "octobre", "novembre", "décembre"];
    $idJS = $NameMonth;
    $idJS[1] = "fevrier";$idJS[7] = "aout";$idJS[11] = "decembre";
    $counterTemp = 0;
    $booleanTest = false;
    for($i = 0;$i<12;$i++)
    {
    ?>
    <div class="tableContainer">
        <table>
            <th colspan="7">
                <div class="MonthContainer">
                    <div class="MonthAffich"><?php echo $NameMonth[$i]; ?></div>
                </div>
            </th>
            <tr>
                <th class="NameDayAffich" scope="col">lu</th>
                <th class="NameDayAffich" scope="col">ma</th>
                <th class="NameDayAffich" scope="col">me</th>
                <th class="NameDayAffich" scope="col">je</th>
                <th class="NameDayAffich" scope="col">ve</th>
                <th class="NameDayAffich" scope="col">sa</th>
                <th class="NameDayAffich" scope="col" style="border-right:none;">di</th>
            </tr>
            <?php
            ?><tr><?php
            if($booleanTest){$decalageDay = $counterTemp;}
            for($j = 0;$j<$decalageDay+$AllMonth[$i];$j++)
            {
                if($j < $decalageDay)
                {
                    if($j != $decalageDay-1 &&  $decalageDay!= 8)
                    {
                        ?>
                        <td style="visibility:border:0;">
                        <?php
                        echo "";
                        ?></td><?php
                    }

                }
                else
                {
                    if ($j == 8 || $j == 15 || $j == 22 || $j == 29 || $j == 36) {
                        ?></tr><tr><?php
                        $counterTemp = 0;$counterTemp++;
                    }
                    ?><td id="<?php echo $idJS[$i].strval($j-$decalageDay); ?>"style="background-color:<?php
                    if($booleanChangeColor == true)
                    {
                        foreach($AllInfoBDD as $value)
                        {
                            if($value[1] == $idJS[$i].strval($j-$decalageDay))
                            {
                                
                                if($value[2] == "VSC"){echo "rgb(255, 215, 0);";}
                                elseif($value[2] == "JDF"){echo "rgb(255, 51, 51);";}
                                elseif($value[2] == "JDC"){echo "rgb(173, 216, 230);";}
                                elseif($value[2] == "JDO"){echo "rgb(152, 255, 152);";}
                            }
                        }
                    }
                     ?>"><?php
                    echo $j-$decalageDay+1;?></td><?php
                    $counterTemp++;
                    
                }
                
            }
            $booleanTest = true;
        ?>
        </table>
        </div>
        <?php
    }
    echo "<script>let yearsActually = '".$annee."';</script>";
}
function GenerateTableSecond($annee, $decalageDay)
{
    include("../ClassePHP/BDDClasse.php");
    $host = 'localhost';
    $dbname = 'bddprojectama';
    $username = 'root';
    $password = 'J11Tx1BQ';
    $objet = new BDDGestion($host, $dbname, $username, $password);
    $objet->StartingConnection(); // Lancement de la connexion à la BDD
    $objet->SetNameTable("calendrier");
    $AllInfoBDD = $objet->SelectSearch(["*"], "annee", $annee);

    if ($AllInfoBDD == []) {
        $booleanChangeColor = false;
    } else {
        $booleanChangeColor = true;
    }
    $AllMonth = JourInMonth($annee);
    $NameMonth = ["janvier", "février", "mars", "avril", "mai", "juin", "juillet", "août", "septembre", "octobre", "novembre", "décembre"];
    $idJS = $NameMonth;
    $idJS[1] = "fevrier";
    $idJS[7] = "aout";
    $idJS[11] = "decembre";
    $counterTemp = 0;
    $booleanTest = false;
    $output = ''; // Variable pour stocker le contenu HTML

    for ($i = 0; $i < 12; $i++) {
        $output .= '<div class="tableContainer">
                        <table>
                            <th colspan="7">
                                <div class="MonthContainer">
                                    <div class="MonthAffich">' . $NameMonth[$i] . '</div>
                                </div>
                            </th>
                            <tr>
                                <th class="NameDayAffich" scope="col">lu</th>
                                <th class="NameDayAffich" scope="col">ma</th>
                                <th class="NameDayAffich" scope="col">me</th>
                                <th class="NameDayAffich" scope="col">je</th>
                                <th class="NameDayAffich" scope="col">ve</th>
                                <th class="NameDayAffich" scope="col">sa</th>
                                <th class="NameDayAffich" scope="col" style="border-right:none;">di</th>
                            </tr>';

        $output .= '<tr>';
        if ($booleanTest) {
            $decalageDay = $counterTemp;
        }
        for ($j = 0; $j < $decalageDay + $AllMonth[$i]; $j++) {
            if ($j < $decalageDay) {
                if ($j != $decalageDay - 1 && $decalageDay != 8) {
                    $output .= '<td style="visibility:border:0;"></td>';
                }
            } else {
                if ($j == 8 || $j == 15 || $j == 22 || $j == 29 || $j == 36) {
                    $output .= '</tr><tr>';
                    $counterTemp = 0;
                    $counterTemp++;
                }
                $output .= '<td id="' . $idJS[$i] . strval($j - $decalageDay) . '" style="background-color:';
                if ($booleanChangeColor == true) {
                    foreach ($AllInfoBDD as $value) {
                        if ($value[1] == $idJS[$i] . strval($j - $decalageDay)) {

                            if ($value[2] == "VSC") {
                                $output .= 'rgb(255, 215, 0);';
                            } elseif ($value[2] == "JDF") {
                                $output .= 'rgb(255, 51, 51);';
                            } elseif ($value[2] == "JDC") {
                                $output .= 'rgb(173, 216, 230);';
                            } elseif ($value[2] == "JDO") {
                                $output .= 'rgb(152, 255, 152);';
                            } else {
                                $output .= 'rgb(152, 255, 152);';
                            }
                        }
                    }
                }
                $output .= '">' . ($j - $decalageDay + 1) . '</td>';
                $counterTemp++;
            }
        }
        $booleanTest = true;
        $output .= '</table>
                    </div>';
    }
    
    return $output;
}

?>