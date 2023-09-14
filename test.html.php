<?php
$annee = 2023;
$premier_jour = strtotime($annee . '-01-01');
$nom_jour = strftime('%A', $premier_jour);
$number_jour = convDayInNumber($nom_jour);
$test = GenerateTableSecond($annee,$number_jour);
echo $test;
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
    $AllMonth = JourInMonth($annee);
    $NameMonth = ["janvier", "février", "mars", "avril", "mai", "juin", "juillet", "août", "septembre", "octobre", "novembre", "décembre"];
    $idJS = $NameMonth;
    $idJS[2] = "fevrier";$idJS[11] = "decembre";
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
                    ?><td id="<?php echo $idJS[$i]; ?>"><?php
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
    $AllMonth = JourInMonth($annee);
    $NameMonth = ["janvier", "février", "mars", "avril", "mai", "juin", "juillet", "août", "septembre", "octobre", "novembre", "décembre"];
    $idJS = $NameMonth;
    $idJS[2] = "fevrier";
    $idJS[11] = "decembre";
    $counterTemp = 0;
    $booleanTest = false;
    
    $output = ''; // Chaîne de caractères de sortie
    
    for ($i = 0; $i < 12; $i++) {
        $output .= '<div class="tableContainer">';
        $output .= '<table>';
        $output .= '<th colspan="7">';
        $output .= '<div class="MonthContainer">';
        $output .= '<div class="MonthAffich">' . $NameMonth[$i] . '</div>';
        $output .= '</div>';
        $output .= '</th>';
        $output .= '<tr>';
        $output .= '<th class="NameDayAffich" scope="col">lu</th>';
        $output .= '<th class="NameDayAffich" scope="col">ma</th>';
        $output .= '<th class="NameDayAffich" scope="col">me</th>';
        $output .= '<th class="NameDayAffich" scope="col">je</th>';
        $output .= '<th class="NameDayAffich" scope="col">ve</th>';
        $output .= '<th class="NameDayAffich" scope="col">sa</th>';
        $output .= '<th class="NameDayAffich" scope="col" style="border-right:none;">di</th>';
        $output .= '</tr>';
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
                $output .= '<td id="' . $idJS[$i] . '">';
                $output .= $j - $decalageDay + 1;
                $output .= '</td>';
                $counterTemp++;
            }
        }
        
        $booleanTest = true;
        
        $output .= '</table>';
        $output .= '</div>';
    }
    
    $output .= "<script>yearsActually = '" . $annee . "';</script>";
    
    return $output;
}

?>