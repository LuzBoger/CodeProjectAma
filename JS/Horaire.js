//Initialisation des ID des bouttons
let imageBack0 = document.getElementById("Back0");
let imageSave0 = document.getElementById("Save0");
let ActuallyEdit = false;
// Lien pour changer l'affichage des images
let linkSave = "http://ama/ProJectGarderie/Image/save.png";
let linkSaveAfter = "http://ama/ProJectGarderie/Image/saveafter.png";
let linkBack = "http://ama/ProJectGarderie/Image/back.svg";
let linkBackafter = "http://ama/ProJectGarderie/Image/backafter.svg";
//Gestion de l'animation de sauvegarde
let spinImage = document.querySelector('.spinClasse');
let NewImageClasse = document.querySelector('.NewImageClasse');
let Overlay = document.querySelector('.overlay');
// Initialisation des bouttons : Back && Save
imageBack0.classList.remove("animationBiging");
imageBack0.style.cursor = "not-allowed";
imageBack0.src = linkBack;
imageSave0.classList.remove("animationBiging");
imageSave0.style.cursor = "not-allowed";
imageSave0.src = linkSave;
//Initialisation de tous les ID
let EditHoraire = document.getElementById("EditHoraire");
let CheckBoxModif = document.getElementById("IDCheckBoxModif");
let inputs = [
  document.getElementById("IDAmplOuv1"),
  document.getElementById("IDAmplOuv2"),
  document.getElementById("IDLundi1"),
  document.getElementById("IDLundi2"),
  document.getElementById("IDMardi1"),
  document.getElementById("IDMardi2"),
  document.getElementById("IDMercredi1"),
  document.getElementById("IDMercredi2"),
  document.getElementById("IDJeudi1"),
  document.getElementById("IDJeudi2"),
  document.getElementById("IDVendredi1"),
  document.getElementById("IDVendredi2"),
  document.getElementById("IDHoraireR1"),
  document.getElementById("IDHoraireR2")
];
editAmpliFunc(true, "#f2f2f2", "text");
editAllHoraireFunc(true, "#f2f2f2", "text");
//Gestion des TextInput
//Récupération des informations de la base de données
$.ajax({
  type: 'POST',
  url: '../../PhpHoraire/AffichageHoraire.php',
  success: function (response) {
    // console.log(response);
    //Suppréssion des informaitions nuisibles
    response = response.split("|");
    tableauBefore = response.map(chaine => chaine.replace(/(\r\n|\")/g, ""));
    // console.log(tableauBefore);

    //je dois attribué ça au différente case du tableau horaire
    AmplOuvtabBefore = RecupAmpl(tableauBefore);
    tableauBefore.unshift(...AmplOuvtabBefore);
    tableauBefore = tableauBefore.map(element => {
      return element.slice(0, -3);
    });
    editValueHoraire(tableauBefore);
    tableauAfter = tableauBefore.slice();//Attribution des valeurs des tableau
  }
});
//Evènement déclencher l'ors de l'appuie sur le bouton edit
EditHoraire.addEventListener('click', function (e) {
  e.preventDefault();
  ActuallyEdit = true;
  //Activation de tous les textInputs
  editAmpliFunc(false, "#ffffff", "time");
  //Changement de statue de la fleche de retour
  imageBack0.style.cursor = "pointer";
  imageBack0.classList.add("animationBiging");
  imageBack0.src = linkBackafter;

  return false;
})
CheckBoxModif.addEventListener('change', function (e) {
  e.preventDefault();
  if (CheckBoxModif.checked === true) {
    editAllHoraireFunc(false, "#ffffff", "time");
  }
  else if (CheckBoxModif.checked === false) {
    editAllHoraireFunc(true, "#f2f2f2", "text");
  }
  return false;
})
//Evènement déclencher l'ors de l'appuie sur le bouton back
imageBack0.addEventListener('click', function (e) {
  e.preventDefault();
  if (ActuallyEdit == true) {
    imageBack0.classList.remove("animationBiging");
    imageBack0.style.cursor = "not-allowed";
    imageBack0.src = linkBack;
    CheckBoxModif.checked = false;
    editAmpliFunc(true, "#f2f2f2", "text");
    editAllHoraireFunc(true, "#f2f2f2", "text");
    //Modification vers les anciennes valeurs
    editValueHoraire(tableauBefore);
    tableauAfter = tableauBefore.slice();
    verificationTabAfterxBefore();
    ActuallyEdit = false;
  }
  return false;
})
imageSave0.addEventListener('click', function (e) {
  e.preventDefault();
  if (ActuallyEdit == true) {
    //L'objectif sera d'envoyé vers la BDD toutes les informations de la table horaire.
    tableauAfter = tableauAfter.map(element => {
      return element + ":00";
    });
    $.ajax({
      type: 'POST',
      url: '../../PhpHoraire/InsertHoraireBDD.php',
      data: { tableau: tableauAfter },
      success: function (response) {
        console.log(response);
        response = response.replace(/\s/g, "");
        if (response === '1') {
          Overlay.style.display = "flex";
          setTimeout(changeImage, 1000);
        }
        else { alert("Une erreur s'est produite !"); }
      }
    });

  }
  return false;
});
for (let i = 0; i < inputs.length; i++) {

  inputs[i].addEventListener('input', function (e) {
    e.preventDefault();
    //L'objectif de ce début de fonction est de faire en sorte de rajouter des ":"
    //à partir d'un certain moment et de bloquer l'orsqu'on essaie de mettre autre chose que des
    //chiffre
    let contenu = inputs[i].value;
    if (i === 0) {
      //objectif si les amplitude d'ouverture sont changé
      //Alors changer aussi toutes les autres horaires des autres jour automatiquement qui sont aussi égale
      // aux horaires d'avant
      //Chercher tous les index égale à tableauBefore
      tableauAfter = tableauBefore.map((element) => {
        return element === tableauBefore[i] ? contenu : element;
      });
      console.log(contenu);
      const date = new Date('1970-01-01');
      let heure1 = new Date(`${date.toDateString()} ${contenu}`);
      //Maintenant l'objectif est de changer pour tous les inputs concerné
      for (let j = 2; j < tableauAfter.length; j += 2) {
        //utilisation d'un systeme de date pour comparer les dates
        let heure2 = new Date(`${date.toDateString()} ${tableauAfter[j]}`);
        if (heure1 > heure2) {
          tableauAfter[j] = contenu;
        }
      }
      AtribAtTheEnter();

    }
    else if (i === 1) {
      //objectif si les amplitude d'ouverture sont changé
      //Alors changer aussi toutes les autres horaires des autres jour automatiquement qui sont aussi égale
      // aux horaires d'avant
      //Chercher tous les index égale à tableauBefore
      tableauAfter = tableauBefore.map((element) => {
        return element === tableauBefore[i] ? contenu : element;
      });
      console.log(contenu);
      const date = new Date('1970-01-01');
      let heure1 = new Date(`${date.toDateString()} ${contenu}`);
      //Maintenant l'objectif est de changer pour tous les inputs concerné
      for (let j = 1; j < tableauAfter.length; j += 2) {
        //utilisation d'un systeme de date pour comparer les dates
        let heure2 = new Date(`${date.toDateString()} ${tableauAfter[j]}`);
        if (heure1 < heure2) {
          tableauAfter[j] = contenu;
        }
        if ((heure2 > heure1) && tableauAfter[j] !== "00:00") {
          tableauAfter[j] = contenu;

          console.log("prouteSmallTwo");
        }

      }
      AtribAtTheEnter();

    }
    else {
      tableauAfter[i] = contenu;
      // Ajout des caractères ":" après chaque deux chiffres
    }
    //Vérifier si les horaires rentrée sont conforme à un standart des horaires pour vérifier
    //les éventuelle erreurs de frappe.
    inputs[i].value = tableauAfter[i];
    booleanVerif = VerifHoraireIn(tableauAfter[i], i);
    return false;
  });
}
/* ALL FUNCTION ONGLET HORAIRE ALL FUNCTION ONGLET HORAIRE ALL FUNCTION ONGLET HORAIRE */
function editAmpliFunc(bool, color, type) {
  inputs[0].disabled = bool; inputs[1].disabled = bool;
  inputs[0].style.backgroundColor = color; inputs[1].style.backgroundColor = color;
  inputs[0].type = type; inputs[1].type = type;
  CheckBoxModif.disabled = bool;
}
function editAllHoraireFunc(bool, color, type) {
  for (let i = 2; i < inputs.length; i++) {
    inputs[i].disabled = bool;
    inputs[i].style.backgroundColor = color;
    inputs[i].type = type;
  }
}
function editValueHoraire(tableau) {
  for (let i = 0; i < inputs.length; i++) {
    inputs[i].value = tableau[i];
  }
}
function RecupAmpl(tableau) {
  tableauFinal = [];
  const min = arr => arr.reduce((x, y) => Math.min(x, y));
  const max = arr => arr.reduce((x, y) => Math.max(x, y));
  //Récupération de la plus petite horaire d'ouverture
  tableauTemp = [];
  for (let i = 0; i < tableau.length; i++) {
    tempOne = tableau[i].split(":");
    if (parseInt(tempOne[0] + tempOne[1]) !== 0) {
      tableauTemp.push(parseInt(tempOne[0] + tempOne[1]));
    }

  }
  //Le minimum d'ouverture
  const heureOuverturePlusTot = min(tableauTemp);
  //Le maximum d'ouverture
  const heureOuverturePlusTard = max(tableauTemp);
  //récuparation de l'index de l'heure la plus tôt
  const indexHeureOuverturePlusTot = tableau.findIndex(element => {
    const tempOne = element.split(":");
    return parseInt(tempOne[0] + tempOne[1]) === heureOuverturePlusTot;
  });
  //récuparation de l'index de l'heure la plus tard
  const indexHeureOuverturePlusTard = tableau.findIndex(element => {
    const tempOne = element.split(":");
    return parseInt(tempOne[0] + tempOne[1]) === heureOuverturePlusTard;
  });

  tableauFinal.push(tableau[indexHeureOuverturePlusTot]);
  tableauFinal.push(tableau[indexHeureOuverturePlusTard]);
  return tableauFinal;
}
function verificationTabAfterxBefore()
/*  Fontion permettant de vérifier si un élément est différent 
    entre le tableau d'origne ainsi que le nouveaux rentrer par
    l'utilisateur.
*/ {
  // console.log(tableauBefore);
  // console.log(tableauAfter);
  for (let i = 0; i < inputs.length; i++) {
    // console.log(inputs[i].value);
  }
  counterDiff = 0;
  for (let j = 0; j < tableauBefore.length; j++) {
    if (tableauBefore[j] != tableauAfter[j]) {
      counterDiff++;
    }

  }
  if (counterDiff > 0) {
    imageSave0.classList.add("animationBiging");
    imageSave0.style.cursor = "pointer";
    imageSave0.src = linkSaveAfter;
    console.log("proute1");
  }
  else {
    imageSave0.classList.remove("animationBiging");
    imageSave0.style.cursor = "not-allowed";
    imageSave0.src = linkSave;
    console.log("proute2");
  }
}
function AtribAtTheEnter() {
  for (let i = 0; i < tableauAfter.length; i++) {
    inputs[i].value = tableauAfter[i];
  }
}
function VerifHoraireIn(Horaire, index) {
  Horaire = Horaire.split(":");
  if ((parseInt(Horaire[0]) >= 0 && parseInt(Horaire[0]) <= 24) && (parseInt(Horaire[1]) >= 0 && parseInt(Horaire[1]) < 60)) {
    inputs[index].style.backgroundColor = 'rgb(255, 255, 255)';
    verificationTabAfterxBefore();
    return true;
  }
  else {
    inputs[index].style.backgroundColor = '#FFC9C9';
    imageSave0.style.pointerEvents = "none";
    imageSave0.src = linkSave;
    return false;
  }

}

/* GESTION DU CALENDRIER INITIALISATION ETC...*/
let EditCalendrier = document.getElementById("EditCalendrier");
let tableContainers = document.querySelectorAll(".tableContainer");
let containerCalendar = document.getElementById("containerCalendar");
let BackC = document.getElementById("BackC");
let SaveC = document.getElementById("SaveC");
let booleanActuallyEdit = false;

let ArrowCalendarR = document.getElementById("Arrow-right");
let ArrowCalendarL = document.getElementById("Arrow-left");

ArrowCalendarR.classList.remove();
ArrowCalendarL.classList.remove();
//Gestion du secondMinBlock
SquareTab = [
  document.getElementById("Square1"),
  document.getElementById("Square2"),
  document.getElementById("Square3"),
  document.getElementById("Square4")
];
SoulignTab = [
  document.getElementById("VSC"),
  document.getElementById("JDF"),
  document.getElementById("JDC"),
  document.getElementById("JDO")
];
SquareColorAfter = [
  "#FFD700", "#ff3333", "#ADD8E6", "#98FF98"
];
SquareColorBefore = [
  "rgba(255, 215, 0, 0.5)", "#ff6666", "rgba(173, 216, 230, 0.7)", "#BAFFBA"
];
SquareActiv = [false, false, false, false];
/* Link Horaire Arrow */
let linkArrowLeftBack = "http://ama/ProJectGarderie/Image/calendar/arrow-left-back.svg";
let linkArrowRightBack = "http://ama/ProJectGarderie/Image/calendar/arrow-right-back.svg";
let linkArrowLeftAfter = "http://ama/ProJectGarderie/Image/calendar/arrow-left-after.svg";
let linkArrowRightAfter = "http://ama/ProJectGarderie/Image/calendar/arrow-right-after.svg";
/* END OF LINK HORAIRE ARROW */
var monthName = ["janvier", "fevrier", "mars", "avril", "mai", "juin", "juillet", "aout",
  "septembre", "octobre", "novembre", "decembre"];
var month = [31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
EditButtonCal();
var TabOfYearsMonthDay = RecupAllIdOfAllMonth();
let YearsAffic = document.getElementById("YearsAffic");
YearsAffic.textContent = yearsActually;// attribution de l'année actuelle

backgroundColorChoice = "";

EditCalendrier.addEventListener('click', function (e) {
  e.preventDefault();
  if (booleanActuallyEdit == false) {
    booleanActuallyEdit = true;
  }
  EditButtonCal();
  return false;
})
let counterUndoBack = 0;
BackC.addEventListener('click', function (e) {
  e.preventDefault();
  // console.log(counterUndoBack);
  if (counterUndoBack > 0) {
    counterUndoBack--;
  }
  else {
    counterUndoBack = 0;
  }

  if (booleanActuallyEdit == true && counterUndoBack == 0) {
    booleanActuallyEdit = false;
    EditButtonCal();
  }
  //Réinitialisation de toutes les couleurs
  console.log(pushBDDBefore);
  console.log(counterUndoBack);
  for (let i = 0; i < 12; i++) {
    for (let j = 0; j < TabOfYearsMonthDay[i].length; j++) {
      TabOfYearsMonthDay[i][j].style.backgroundColor = pushBDDBefore[counterUndoBack][i][j][1];
      TabOfYearsMonthDay[i][j].BackgroundColorBefore = pushBDDBefore[counterUndoBack][i][j][1];
    }

  }
  pushBDDBefore.splice(counterUndoBack + 1, 1);
  pushBDD.splice(counterUndoBack, 1);
  console.log(pushBDD);


  return false;
})
SaveC.addEventListener('click', function (e) {
  e.preventDefault();
  if (pushBDD.length != 0) {
    SendBDDText = "";
    console.log(pushBDD);
    console.log(pushBDD[counterUndoBack - 1]);
    let InfoTypeOfDay = "";
    pushBDD[counterUndoBack - 1].forEach(function (element, index) {
      if (element[1] == "rgb(255, 215, 0)") { InfoTypeOfDay = "VSC"; }
      if (element[1] == "rgb(255, 51, 51)") { InfoTypeOfDay = "JDF"; }
      if (element[1] == "rgb(173, 216, 230)") { InfoTypeOfDay = "JDC"; }
      if (element[1] == "rgb(152, 255, 152)") { InfoTypeOfDay = "JDO"; }
      SendBDDText += element[0] + "|" + InfoTypeOfDay + "|" + element[2];
      if (index != pushBDD[counterUndoBack - 1].length) {
        SendBDDText += "~"
      }

    })
    SendBDDText = SendBDDText.substring(0, SendBDDText.length - 1);
    console.log(SendBDDText);
    // console.log(SendBDDText);
    $.ajax({
      type: 'POST',
      url: '../../PhpHoraire/InsertHoraireBDD.php',
      data: { SendBDDText: SendBDDText },
      dataType: 'json',
      success: function (response) {
        console.log(response);
        if (response.success == "OK") {
          Overlay.style.display = "flex";
          setTimeout(changeImage, 1000);
          console.log("proute");
        }
        else { alert("Une erreur s'est produite !"); }
      }
    });



  }
  return false;
})
ArrowCalendarR.addEventListener('click', function (e) {
  e.preventDefault();
  if (booleanActuallyEdit == true) {
    counterUndoBack = 0;
    yearsActually = parseInt(yearsActually); yearsActually += 1;
    YearsAffic.textContent = yearsActually;
    //Changement du calendrier
    //Suppression de tous les éléments du calendrier
    RequeteAjax(yearsActually);
    TabOfYearsMonthDay = RecupAllIdOfAllMonth();
    pushBDDBefore = [];
    pushBDD = [];
    GestureColor();


  }
  return false;
});
ArrowCalendarL.addEventListener('click', function (e) {
  e.preventDefault();
  if (booleanActuallyEdit == true) {
    counterUndoBack = 0;
    yearsActually = parseInt(yearsActually); yearsActually -= 1;
    YearsAffic.textContent = yearsActually;
    //Changement du calendrier
    //Suppression de tous les éléments du calendrier
    RequeteAjax(yearsActually);
    TabOfYearsMonthDay = RecupAllIdOfAllMonth();
    pushBDDBefore = [];
    pushBDD = [];
    GestureColor();

  }
  return false;
})

for (let i = 0; i < SquareTab.length; i++) {
  SquareTab[i].addEventListener('click', function (e) {
    e.preventDefault();
    // Si un clique est détecter lancer l'animation sur la bonne interfac
    if (booleanActuallyEdit == true) {
      SoulignTab[i].classList.add("SoulignText");
      SoulignTab[i].classList.add(`highlight${i + 1}`);
      backgroundColorChoice = SquareColorAfter[i];
      SquareActiv[i] = true;
      for (let j = 0; j < SoulignTab.length; j++) {
        if (i != j) {
          SoulignTab[j].classList.remove(`highlight${j + 1}`);
          SquareActiv[j] = false;
        }
      }

    }
    return false;
  })
}
pushBDD = [];
pushBDDBefore = [];
GestureColor();
function GestureColor() {
  if (pushBDD.length === 0 && pushBDDBefore.length === 0) {
    SaveC.src = linkSave;
    SaveC.classList.remove("animationBiging");
    SaveC.style.cursor = "not-allowed";

  }
  //récupération de tous les ID au début de la génération
  FormatPushBDDBefore();// Récupération de toutes les couleurs

  SelectedTDid = [];
  allIDListing = [];
  VerifEndOfNumber = false;
  // GESTION DES EVENEMENTS POUR GERER TOUTES LES CASES DU CALENDRIER
  for (let i = 0; i < TabOfYearsMonthDay.length; i++) {
    TabOfYearsMonthDay[i].forEach(function (td) {
      td["BackgroundColorBefore"] = td.style.backgroundColor;
      td.addEventListener("mouseover", function (e) {
        e.preventDefault();
        for (let j = 0; j < SquareActiv.length; j++) {
          if (booleanActuallyEdit === true && SquareActiv[j] != false) {
            td.style.cursor = "pointer";
            // td.BackgroundColorBefore = td.style.backgroundColor;
            td.style.backgroundColor = SquareColorBefore[j];

            td.classList.add("animationText");
          }
        }
        return false;
      })

      td.addEventListener("mouseout", function (e) {
        e.preventDefault();
        td.style.cursor = "auto";
        if (SelectedTDid[1] != td.id) {
          td.style.backgroundColor = td.BackgroundColorBefore;
        }
        else {
          // console.log("td.id : " + td.id);
          // console.log("SelectedTDid[1] : " + SelectedTDid[1]);
          SelectedTDid = [];

        }
        td.classList.remove("animationText");
        return false;
      })

      td.addEventListener('click', function (e) {
        e.preventDefault();
        if (booleanActuallyEdit === true) {
          SelectedTDid.push(td.id);
          console.log("proute : " + SelectedTDid);
        }

        if (SelectedTDid.length == 2) {
          MonthSelectedB = extraitLettre(SelectedTDid[0]);
          MonthSelectedE = extraitLettre(SelectedTDid[1]);
          MonthCroissant = extraitOrderMonth(MonthSelectedB, MonthSelectedE);
          MonthSelectedB = MonthCroissant[0];
          MonthSelectedE = MonthCroissant[1];
          if (MonthSelectedB != MonthSelectedE) {
            numberB = extraitNombre(SelectedTDid[0]); numberE = extraitNombre(SelectedTDid[1]);
            if (SelectedTDid[0] != MonthSelectedB + numberB) {
              temp = numberB;
              numberB = numberE;
              numberE = temp;
            }
            //C'est pas le même mois
            diff = MonthCroissant[2];
            console.log(MonthSelectedB + numberB);
            console.log(MonthSelectedE + numberE);
            console.log(diff);
            indexMonth = monthName.indexOf(MonthSelectedB);
            tempBoard = [];
            if (diff >= 1) {
              for (j = indexMonth; j <= indexMonth + diff; j++) {
                tempBoard.push(monthName[j])
              }
              console.log(tempBoard)
              counter = 0;
              temp = numberB;
              while (VerifEndOfNumber != true) {

                if (document.getElementById(tempBoard[counter] + temp) !== null) {
                  allIDListing.push(document.getElementById(tempBoard[counter] + temp))
                }
                else {
                  temp = -1;
                  counter++;
                }

                if ((tempBoard[counter] + temp) == (MonthSelectedE + numberE)) {
                  VerifEndOfNumber = true;
                  console.log(tempBoard[counter] + temp);
                }
                temp++;

              }
              VerifEndOfNumber = false;

              // console.log(allIDListing);
            }
            //Attribution de la couleurs aux différent mois nécessaire
          }
          else {
            // C'est le même mois
            numberB = extraitNombre(SelectedTDid[0]); numberE = extraitNombre(SelectedTDid[1]);
            if (numberB > numberE) {
              temp = numberE;
              numberE = numberB;
              numberB = temp;
            }
            for (let j = numberB; j <= numberE; j++) {
              document.getElementById(MonthSelectedB + j).style.backgroundColor = backgroundColorChoice;
              allIDListing.push(document.getElementById(MonthSelectedB + j));
            }

          }

          allIDListing.forEach(function (id) {
            id.style.backgroundColor = backgroundColorChoice;
            id.BackgroundColorBefore = id.style.backgroundColor;

          })
          counterUndoBack++;
          FormatPushBDDBefore();
          FormatPushBDD(allIDListing);
          allIDListing = [];

        }
        return false;
      });
    });
  }

}
function extraitNombre(str) { return Number(str.replace(/[^\d]/g, "")) }
function extraitLettre(chaine) {
  // Utilisation d'une expression régulière pour filtrer les lettres
  var lettres = chaine.match(/[a-zA-Z]/g);
  var resultat = lettres ? lettres.join('') : '';
  return resultat;
}
function extraitOrderMonth(Month1, Month2) {
  MonthOrderTab = [];
  scoretabTemp = [];
  tempCounter = 0;
  monthName.forEach(function (m) {
    if (m == Month1) {
      MonthOrderTab.push(m);
      scoretabTemp.push(tempCounter);
    }
    if (m == Month2) {
      MonthOrderTab.push(m);
      scoretabTemp.push(tempCounter);
    }
    tempCounter++;
  })
  // console.log(scoretabTemp);
  MonthOrderTab.push(scoretabTemp[1] - scoretabTemp[0]);
  return MonthOrderTab;
}
function FormatPushBDDBefore() {
  TempPushBDDBefore2 = [];
  for (let i = 0; i < 12; i++) {
    TempPushBDDBefore = [];
    TabOfYearsMonthDay[i].forEach(function (td) {
      TempPushBDDBefore.push([td, td.style.backgroundColor]);
    });
    TempPushBDDBefore2.push(TempPushBDDBefore);

  }
  pushBDDBefore.push(TempPushBDDBefore2);

}
function FormatPushBDD(allIDListing) {
  pushBDDTemp = [];
  // console.log("longueur : " + pushBDD.length)
  lengthTemp = pushBDD.length;
  if (lengthTemp > 0) {

    pushBDD[lengthTemp - 1].forEach(element => {
      pushBDDTemp.push(element);
    });
  }

  allIDListing.forEach(element => {
    pushBDDTemp.push([element.id, element.style.backgroundColor, yearsActually]);
  });
  pushBDDTemp = DestructAllDoublon(pushBDDTemp);
  pushBDD.push(pushBDDTemp);
  // console.log(pushBDD);
  if (pushBDD.length != 0) {
    SaveC.src = linkSaveAfter;
    SaveC.classList.add("animationBiging");
    SaveC.style.cursor = "pointer";
  }
}
function DestructAllDoublon(pushBDDTemp) {
  let index = 0;
  for (let i = 0; i < pushBDDTemp.length; i++) {
    for (let j = 0; j < pushBDDTemp.length; j++) {
      if (i != j) {
        if (pushBDDTemp[j][0] === pushBDDTemp[i][0]) {
          index = Math.min(j, i);
          pushBDDTemp.splice(index, 1);
          i = 0;
          j = 0;

        }
      }
    }
  }
  // console.log(pushBDDTemp);
  return pushBDDTemp;
}
//RECUPERATION DE TOUS LES ID DE TOUS LES JOURS DE TOUS LES MOIS
function RecupAllIdOfAllMonth() {
  elements = [];
  TabOfYears = [];
  console.log(yearsActually);
  for (let i = 0; i < month.length; i++) {
    for (let j = 0; j < month[i]; j++) {
      if (document.getElementById(monthName[i] + j) != null) {
        elements.push(document.getElementById(monthName[i] + j));
      }
      if (document.getElementById(monthName[1] + 28) != null) {
        // console.log("steak");
      }
    }
    if (elements != null) {
      // console.log(elements);
      TabOfYears.push(elements);
      elements = [];
    }

  }
  return TabOfYears;
}
function RequeteAjax(yearsActually) {
  $.ajax({
    type: 'POST',
    async: false,
    url: '../../PhpHoraire/AffichageCalendrier.php',
    data: { years: yearsActually },
    dataType: 'json',
    success: function (response) {
      if (response.success == "NOK") {
        alert("Une erreur c'est produite lors de la génération du calendrier");

      }
      if (response.success == "OK") {
        $('#containerCalendar').empty();
        $('#containerCalendar').html(response.calendarHTML);
        console.log(response.calendarHTML.length)

      }
      //calendarHTML
    }
  });

}
function EditButtonCal() {
  tableContainers = document.querySelectorAll(".tableContainer");
  if (booleanActuallyEdit === true) {
    ArrowCalendarR.src = linkArrowRightAfter;
    ArrowCalendarR.classList.add("animationBiging");
    ArrowCalendarR.style.cursor = "pointer";

    ArrowCalendarL.src = linkArrowLeftAfter;
    ArrowCalendarL.classList.add("animationBiging");
    ArrowCalendarL.style.cursor = "pointer";

    BackC.src = linkBackafter;
    BackC.classList.add("animationBiging");
    BackC.style.cursor = "pointer";

    for (i = 0; i < tableContainers.length; i++) { tableContainers[i].style.backgroundColor = "#ffffff"; }
    // CREATION D'UN SYSTEME DE COULEURS EFFICACE
    for (let i = 0; i < SquareTab.length; i++) {
      SquareActiv[i] = false;
      SquareTab[i].disabled = false;
      SquareTab[i].style.cursor = "pointer";
      SquareTab[i].classList.add("animationBiging");
      SquareTab[i].style.backgroundColor = SquareColorAfter[i];
    }
  }
  else {
    ArrowCalendarR.src = linkArrowRightBack;
    ArrowCalendarR.classList.remove("animationBiging");
    ArrowCalendarR.style.cursor = "not-allowed";

    ArrowCalendarL.src = linkArrowLeftBack;
    ArrowCalendarL.classList.remove("animationBiging");
    ArrowCalendarL.style.cursor = "not-allowed";
    //
    BackC.src = linkBack;
    BackC.classList.remove("animationBiging");
    BackC.style.cursor = "not-allowed";

    SaveC.src = linkSave;
    SaveC.classList.remove("animationBiging");
    SaveC.style.cursor = "not-allowed";

    for (i = 0; i < tableContainers.length; i++) { tableContainers[i].style.backgroundColor = "#f2f2f2"; }
    // CREATION D'UN SYSTEME DE COULEURS EFFICACE
    for (let i = 0; i < SquareTab.length; i++) {
      SquareTab[i].disabled = true;
      SquareTab[i].style.cursor = "no-drop";
      SquareTab[i].classList.remove("animationBiging");
      SquareTab[i].style.backgroundColor = SquareColorBefore[i];
      SoulignTab[i].classList.remove(`highlight${i + 1}`);
    }
    backgroundColorChoice = "";

  }
}
/* ALL FUNCTION ANIMATION ALL FUNCTION ANIMATION ALL FUNCTION ANIMATION */
function changeImage() {
  spinImage.classList.replace('spinClasse', 'decayClasse');
  spinImage.addEventListener('animationend', function () {
    spinImage.style.display = "none";
    NewImageClasse.style.animation = "GrowImage 1s ease-in-out";
    NewImageClasse.style.display = "block";
    NewImageClasse.addEventListener('animationend', function () {
      NewImageClasse.style.animation = "NormalImage 1s ease-out";
      setTimeout(() => {
        // votre code à exécuter après une seconde d'attente
        window.location.reload(true);
      }, 1000);

    });
  });
}

