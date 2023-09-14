//Tableau contenant tous les tableaux
/*  Obtention */
let tableauAllClasse = document.querySelectorAll('.tableauAll');
let IDImageInTD = document.querySelectorAll('.ImageInTable');
// POPUP POPUP POPUP POPUP POPUP POPUP POPUP POPUP POPUP 
let overlay = document.getElementById('overlay');
// ADD ADD ADD ADD ADD ADD ADD ADD ADD ADD ADD ADD ADD ADD ADD 
let buttonAdd = document.getElementById("buttonAdd");
let popupAdd = document.getElementById("popupAdd");
// ID pour le boutton cross
let exitPopUpAdd = document.getElementById('exitPopUpAdd');
// ID POUR TOUS LES INPUT DE BUTTON ADD
let SavePopUpADD = document.getElementById('SavePopUp');
let email = document.getElementById("email");
let password = document.getElementById("password");
let pseudo = document.getElementById("pseudo");
let image = document.getElementById("image");
let stockImage = "";

AllTypeAccept = ['image/png', 'image/jpg', 'image/jpeg', 'image/gif'];

//REMOVE REMOVE REMOVE REMOVE REMOVE REMOVE REMOVE REMOVE REMOVE REMOVE 
let buttonRemove = document.getElementById("buttonRemove");
let popupRemove = document.getElementById("popupRemove");
let exitPopUpRemove = document.getElementById('exitPopUpRemove');
let SelectTri = document.getElementById('SelectTri');
let SelectList = document.getElementById('SelectList');
var newOption = [];
labelInfoUser = document.getElementById('labelInfoUser');
SavePopUpREM = document.getElementById('SavePopUp2');
//tableau contenant tous les td de la page
tdElements = [];
// Tableau de vérification
editButtonIsClick = [false, false, false, false];
YouCanSave = [false, false, false, false];
// link back and Save
let linkSave = "http://ama/ProJectGarderie/Image/save.png";
let linkSaveAfter = "http://ama/ProJectGarderie/Image/saveafter.png";
let linkBack = "http://ama/ProJectGarderie/Image/back.svg";
let linkBackafter = "http://ama/ProJectGarderie/Image/backafter.svg";
//GESTION DU SYSTEME D'ANIMATION DE SAUVEGARDE
let spinImage = document.querySelector('.spinClasse');
let NewImageClasse = document.querySelector('.NewImageClasse');
let Overlay = document.querySelector('.overlay');
//GESTION DES TABLEAUX CONTENANT LES INFORMATIONS
let tdAllInformationBefore = [];
let tdAllInformationAfter = [];
counterDiff = 0;
// Désactiver les 2 bouttons 
let imageSave = []; let imageBack = [];
/* Temporaire pour l'instant */
for (let i = 0; i < 4; i++) {
  imageSave[i] = document.getElementById(`Save${i}`);
  imageSave[i].classList.remove("animationBiging");
  imageSave[i].style.cursor = "not-allowed";

  imageBack[i] = document.getElementById(`Back${i}`);
  imageBack[i].classList.remove("animationBiging");
  imageBack[i].style.cursor = "not-allowed";
}
/* Récupération de tous les td dans un tableau */
for (let i = 0; i < 4; i++) {
  tdElements[i] = document.querySelectorAll(`.tdModification${i}`);
}
for (let i = 0; i <= 4; i++) {
}
/* Boucle for pour tous les éléments qui se répetes comme les boutons */
for (let i = 0; i < 4; i++) {
  document.getElementById(`popUpEdit${i}`).addEventListener('click', function (e) {
    e.preventDefault();
    editButtonIsClick[i] = true;
    for (let index = 0; index < editButtonIsClick.length; index++) {

      if (editButtonIsClick[index] == true && index != i) {
        // Réinitialisation du tableau demander
        BackSaveTable(index);
        editButtonIsClick[index] = false;
      }
    }
    for (let k = 0; k < 4; k++) {
      if (i == k) {
        tableauAllClasse[k].style.backgroundColor = "rgb(250, 255, 253)";/* Changement de la couleurs du background de la table */
        for (var j = 0; j < tdElements[i].length; j++) {

          tdElements[k][j].contentEditable = true;/* Rend le contenue modifiable*/
          tdElements[k][j].style.pointerEvents = "auto";/* Désactive les évènements*/
          // Traitement des cas spéciaux
          if (k == 2 && j == 0) {
            // récupération code source de l'image
            tdAllInformationBefore[j] = IDImageInTD[0].src;
            console.log(IDImageInTD[0].src);
          }
          else if (i == 3 && (j + 1) % 3 == 0) {
            // récupération code source de l'image
            counterTemp = 1;
            for (let t = 2; t < tdElements[3].length; t += 3) {
              tdAllInformationBefore[t] = IDImageInTD[counterTemp].src;
              counterTemp++;
            }
            // Besoin de résoudre le problème de répétition dans la boucle
            // Problème d'optimisation 
          }
          else {
            tdAllInformationBefore[j] = tdElements[k][j].innerText;

          }

        }

        imageBack[i].src = linkBackafter;
        imageBack[i].classList.add("animationBiging");
        imageBack[i].style.cursor = "pointer";
        if (i == 3) { buttonAdd.style.display = "flex"; buttonRemove.style.display = "flex"; }
      }
      else {
        tableauAllClasse[k].style.backgroundColor = "rgb(240, 251, 243)";
        for (var j = 0; j < tdElements[k].length; j++) {
          tdElements[k][j].contentEditable = false;
          tdElements[k][j].style.pointerEvents = "none";
        }
        imageBack[i].src = linkBackafter;
        imageBack[i].classList.add("animationBiging");
        imageBack[i].style.cursor = "pointer";
        if (i != 3) {
          buttonAdd.style.display = "none"; buttonRemove.style.display = "none";
          console.log('je devrai dispariatre');
        }
      }
    }
    tdAllInformationAfter = tdAllInformationBefore.slice();
    return false;
  });

  /* Récupération de l'information après modification */
  for (let y = 0; y < tdElements[i].length; y++) {
    tdElements[i][y].addEventListener('blur', function (e) {
      e.preventDefault();
      if (i == 2 && y == 0) {
        // Gestion du logo
        console.log("Gestion logo");
      }
      else if (i == 3 && (1 + y) % 3 == 0) {
        console.log("Gestion User image");
      }
      else {
        // Gestion de tous les autres cas
        console.log("Gestion ALL Case possible");
        tdAllInformationAfter[y] = tdElements[i][y].innerText;
      }
      verificationTabAfterxBefore(i);
      //Changement de couleur de la disquette de sauvegarde si un changement est détecter
      return false;
    });
  }


  document.getElementById(`Back${i}`).addEventListener('click', function (e) {
    // réinitialisation de tous le tableau
    if (editButtonIsClick[i] == true) {
      BackSaveTable(i);
      editButtonIsClick[i] = false;
      console.log(IDImageInTD[3]);
    }

    return false;
  });

  document.getElementById(`Save${i}`).addEventListener('click', function (e) {
    e.preventDefault();
    if (editButtonIsClick[i] == true && YouCanSave[i] == true) {
      // création d'une requete ajax
      tdCaract = tdAllInformationAfter.join('||');
      // console.log(tdCaract);
      $.ajax({
        type: 'POST',
        url: '../PhpParam/ModifTabGenerale.php',
        data: { tabResult: tdCaract, index: i },
        success: function (response) {
          console.log(response);
          response = response.replace(/\s/g, "");
          if (response === 'true') {
            Overlay.style.display = "flex";
            setTimeout(changeImage, 1000);
          }
          else { alert("Une erreur s'est produite !"); console.log(response.length); }
        }
      });

    }
    return false;
  });
}
/*--------------------------------------------------------------------------
  POPUP POPUP POPUP POPUP POPUP POPUP POPUP POPUP POPUP POPUP POPUP POPUP POPUP
  POPUP POPUP POPUP POPUP POPUP POPUP POPUP POPUP POPUP POPUP POPUP POPUP POPUP
  POPUP POPUP POPUP POPUP POPUP POPUP POPUP POPUP POPUP POPUP POPUP POPUP POPUP
  --------------------------------------------------------------------------
*/
// ADD ADD ADD ADD ADD ADD ADD ADD ADD ADD ADD ADD ADD ADD ADD ADD ADD ADD//
buttonAdd.addEventListener('click', function (e) {
  e.preventDefault();
  overlay.style.display = "flex";
  popupAdd.style.display = "flex";
  GestionImagePopUp(false);
  return false;
});
exitPopUpAdd.addEventListener('click', function (e) {
  e.preventDefault();
  overlay.style.display = "none";
  popupAdd.style.display = "none";
  email.value = ""; password.value = ""; pseudo.value = "";
  image.value = "";
  return false;
});

SavePopUpADD.addEventListener('click', function (e) {
  e.preventDefault();
  //Envoie de toutes les données vers un fichier PHP
  $.ajax({
    type: 'POST',
    url: '../PhpParam/InsertUserAndDelete.php',
    data: {
      email: email.value, password: password.value,
      pseudo: pseudo.value, image: stockImage
    },
    success: function (response) {
      console.log(response);
      response = response.replace(/\s/g, "");
      if (response === 'true') {
        Overlay.style.display = "flex";
        setTimeout(changeImage, 1000);
      }
      else { alert("Une erreur s'est produite !"); console.log(response.length); }
    }
  });
  // console.log(email.value);
  // console.log(password.value);
  // console.log(pseudo.value);
  // console.log(stockImage);
  return false;
});
let verifCondition = [false, false, false, false];
/* EMAIL EMAIL EMAIL EMAIL EMAIL EMAIL EMAIL EMAIL EMAIL EMAIL */
email.addEventListener('change', function (e) {
  e.preventDefault();
  verificationGlobalPopup();
  if (!verifCondition[0]) { alert("Email non fonctionnelle ! "); }
  return false;
});
/*PASSWORD PASSWORD PASSWORD PASSWORD PASSWORD PASSWORD PASSWORD */
password.addEventListener('change', function (e) {
  e.preventDefault();
  verificationGlobalPopup();
  if (!verifCondition[1]) { alert("Password trop petit ! "); }
  return false;
});
/*PSEUDO PSEUDO PSEUDO PSEUDO PSEUDO PSEUDO PSEUDO PSEUDO PSEUDO */
pseudo.addEventListener('change', function (e) {
  e.preventDefault();
  verificationGlobalPopup();
  if (!verifCondition[2]) { alert("Pseudo trop petit ! "); }
  return false;
});
/* IMAGE IMAGE IMAGE IMAGE IMAGE IMAGE IMAGE IMAGE IMAGE IMAGE IMAGE*/
image.addEventListener('change', function (event) {
  const file = event.target.files[0];
  const reader = new FileReader();
  reader.addEventListener('load', () => {
    // Accédez au contenu de l'image via `reader.result`
    stockImage = reader.result;
    verificationGlobalPopup();
    if (!verifCondition[3]) { alert("Image non valide ! "); }
  });
  try {
    reader.readAsDataURL(file);
  }
  catch {
    console.log("Une erreur est survenue");
  }

  return false;
});

function verificationGlobalPopup() {
  // vérification si l'email est valide ou non
  const emailRegex = /^[^@\s]+@[^@\s]+\.[^@\s]+$/;
  // Vérification les différentes conditions
  if (emailRegex.test(email.value)) { verifCondition[0] = true; }
  else { verifCondition[0] = false; }
  if (password.value.length > 7) { verifCondition[1] = true; }
  else { verifCondition[1] = false; }
  if (pseudo.value.length > 7) { verifCondition[2] = true; }
  else { verifCondition[2] = false; }
  //--------Vérification image type--------
  for (b = 0; b < AllTypeAccept.length; b++) {
    position = stockImage.indexOf(AllTypeAccept[b]);
    if (position !== -1) { verifCondition[3] = true; break; }
    else { verifCondition[3] = false; }
  }
  //--------FIN Vérification image type--------
  areAllEqual = verifCondition.every(elem => elem === true)
  if (areAllEqual) {
    console.log("All Valide");
    GestionImagePopUp(true);
  }
  else {
    GestionImagePopUp(false);
  }

}
function GestionImagePopUp($boolean) {
  if ($boolean) {
    SavePopUpADD.disabled = false; SavePopUpADD.style.pointerEvents = "auto";
    SavePopUpADD.src = "../Image/saveAfter.png";
  }
  else {

    SavePopUpADD.disabled = true; SavePopUpADD.style.pointerEvents = "none";
    SavePopUpADD.src = "../Image/save.png";
  }
}
// REMOVE REMOVE REMOVE REMOVE REMOVE REMOVE REMOVE REMOVE REMOVE REMOVE //
buttonRemove.addEventListener('click', function (e) {
  e.preventDefault();
  overlay.style.display = "flex";
  popupRemove.style.display = "flex";
  return false;
});
exitPopUpRemove.addEventListener('click', function (e) {
  e.preventDefault();
  popupRemove.style.display = "none";
  overlay.style.display = "none";
  return false;
});

SelectTri.addEventListener("change", function (e) {
  e.preventDefault();
  var selectedOption = this.value;
  for (var i = SelectList.options.length - 1; i >= 1; i--) {
    SelectList.remove(i);
  }
  if (selectedOption == "pseudo") {
    counterTemp = 1;
    for (let i = 1; i < tdAllInformationBefore.length; i += 3) {
      var newOption = document.createElement("option");

      newOption.text = tdAllInformationBefore[i];
      newOption.value = counterTemp;
      SelectList.add(newOption);
      counterTemp++;
    }
  }
  else if (selectedOption == "email") {
    var newOption = document.createElement("option");
    counterTemp = 1;
    for (let i = 0; i < tdAllInformationBefore.length; i += 3) {
      var newOption = document.createElement("option");

      newOption.text = tdAllInformationBefore[i];
      newOption.value = counterTemp;
      SelectList.add(newOption);

      counterTemp++;
    }

  }

  return false;
});
SelectList.addEventListener("change", function (e) {
  e.preventDefault();
  let TabPosValue = [];
  tempBoolean = false;
  if (this.value == 1) {
    TabPosValue.push(tdAllInformationBefore[0]);
    TabPosValue.push(tdAllInformationBefore[1]);
    tempBoolean = true;

  }
  else if (this.value != 0) {

    TabPosValue.push(tdAllInformationBefore[3 * (this.value - 1)]);
    TabPosValue.push(tdAllInformationBefore[3 * (this.value - 1) + 1]);
    tempBoolean = true;
  }
  else {
    labelInfoUser.textContent = "";
  }
  if (tempBoolean == true) {
    SavePopUpREM.src = linkSaveAfter;
    SavePopUpREM.style.pointerEvents = "auto";
    labelInfoUser.textContent = "Email : " + TabPosValue[0] + "\n Pseudo : " + TabPosValue[1];
  }
  else {
    SavePopUpREM.src = linkSave;
    SavePopUpREM.style.pointerEvents = "none";
  }

  return false;
});
SavePopUpREM.addEventListener("click", function (e) {
  e.preventDefault();
  // Objectif envoyer le value selectionner pour supprimer le compte concerner
  $.ajax({
    type: 'POST',
    url: '../PhpParam/InsertUserAndDelete.php',
    data: { UserDeleted: SelectList.value },
    success: function (response) {
      console.log(response);
      response = response.replace(/\s/g, "");
      if (response === 'true') {
        Overlay.style.display = "flex";
        setTimeout(changeImage, 1000);
      }
      else { alert("Une erreur s'est produite !"); }
    }
  });
  return false;
});

/*--------------------------------------------------------------------------
 END POPUP END POPUP END POPUP END POPUP END POPUP END POPUP END POPUP END POPUP
 END POPUP END POPUP END POPUP END POPUP END POPUP END POPUP END POPUP END POPUP
  --------------------------------------------------------------------------
*/
//Gestion des cas spéciaux nottament les images
//Document

tdElements[2][0].addEventListener('keyup', function (e) {
  e.preventDefault();
  const enfant = tdElements[2][0].children[0];
  //Si la case est vide
  if (enfant == undefined) {
    tdAllInformationAfter[0] = tdAllInformationBefore[0];
    // Création d'un bouton
    const button = document.createElement('input');
    button.type = 'file';
    button.accept = "image/*";
    button.style.width = '100px';
    tdElements[2][0].contentEditable = false;
    // Ajouter un écouteur d'événement change à la variable bouton
    button.addEventListener('change', (event) => {
      console.log('Je suis modifier !! ');
      const file = event.target.files[0];
      const reader = new FileReader();

      reader.addEventListener('load', () => {
        // Accédez au contenu de l'image via `reader.result`
        tdAllInformationAfter[0] = reader.result;
        counterVerif = 0;
        for (b = 0; b < AllTypeAccept.length; b++) {
          position = tdAllInformationAfter[0].indexOf(AllTypeAccept[b]);
          if (position !== -1) { counterVerif++; }
        }
        console.log(counterVerif);
        if (counterVerif === 1) {
          // si l'image est conforme à l'un des types accepter
          counterVerif = 0;
          var img = document.createElement("img");
          img.src = reader.result; img.style.width = "50px"; img.style.width = "50px";
          img.classList.add('ImageInTable');
          tdElements[2][0].children[0].remove();
          tdElements[2][0].appendChild(img);
          tdElements[2][0].contentEditable = true;
        }
        // si l'image n'est point conforme à l'un des types accepter
        else {
          alert("Image non valide ! ");
          tdAllInformationAfter[0] = tdAllInformationBefore[0];
        }
        verificationTabAfterxBefore(2);
      });
      try {
        reader.readAsDataURL(file);
      }
      catch {
        tdAllInformationAfter[0] = tdAllInformationBefore[0];
      }
      finally {
        verificationTabAfterxBefore(2);
      }
    });
    // Ajouter le bouton au DOM
    tdElements[2][0].appendChild(button);
  }
});

//Utilisateur
// gestion de tous les cas spéciaux pour les images des utilisateurs
for (let u = 2; u < tdElements[3].length; u += 3) {
  tdElements[3][u].addEventListener('keyup', function (e) {
    e.preventDefault();
    const enfant = tdElements[3][u].children[0];
    //Si la case est vide
    if (enfant == undefined) {
      tdAllInformationAfter[u] = tdAllInformationBefore[u];
      // Création d'un bouton
      const button = document.createElement('input');
      button.type = 'file';
      button.accept = "image/*";
      button.style.width = '100px';
      tdElements[3][u].contentEditable = false;
      // Ajouter un écouteur d'événement change à la variable bouton
      button.addEventListener('change', (event) => {
        console.log('Je suis modifier !! ');
        const file = event.target.files[0];
        const reader = new FileReader();

        reader.addEventListener('load', () => {
          // Accédez au contenu de l'image via `reader.result`
          tdAllInformationAfter[u] = reader.result;
          counterVerif = 0;
          for (b = 0; b < AllTypeAccept.length; b++) {

            position = tdAllInformationAfter[u].indexOf(AllTypeAccept[b]);
            if (position !== -1) { counterVerif++; }
          }
          console.log(counterVerif);
          if (counterVerif === 1) {
            tdAllInformationAfter
            // si l'image est conforme à l'un des types accepter
            counterVerif = 0;
            var img = document.createElement("img");
            img.src = reader.result; img.style.width = "50px"; img.style.width = "50px";
            img.classList.add('ImageInTable');
            tdElements[3][u].children[0].remove();
            tdElements[3][u].appendChild(img);
            tdElements[3][u].contentEditable = true;
          }
          // si l'image n'est point conforme à l'un des types accepter
          else {
            alert("Image non valide ! ");
            tdAllInformationAfter[u] = tdAllInformationBefore[u];
          }
          verificationTabAfterxBefore(3);
        });
        try {
          reader.readAsDataURL(file);
        }
        catch {
          tdAllInformationAfter[u] = tdAllInformationBefore[u];
        }
        finally {
          verificationTabAfterxBefore(3);
        }
      });
      // Ajouter le bouton au DOM
      tdElements[3][u].appendChild(button);
    }
  });

}
// création d'une fonction de réinitialisation
function BackSaveTable(i)
// le numéro i correspond au numéro de WhiteSquare concerner
// Cette fonctionne ne return nothing
{
  tableauAllClasse[i].style.backgroundColor = "rgb(240, 251, 243)";
  for (var j = 0; j < tdElements[i].length; j++) {
    tdElements[i][j].contentEditable = false;
    tdElements[i][j].style.pointerEvents = "none";
    tdElements[i][j].innerText = "";
    if (i == 2 && j == 0) {
      //Gestion du logo
      tdElements[2][0].appendChild(IDImageInTD[0]);
    }
    else if (i == 3 && (1 + j) % 3 == 0) {
      // Remmettre à la normal tous les Users
      // Améliorer le system pour qu'il puissent prendre une infinité de USER
      counterTemp = 1;
      for (let u = 2; u < tdElements[i].length; u += 3) {
        tdElements[i][u].appendChild(IDImageInTD[counterTemp]);
        counterTemp++;
      }
    }
    else {
      //gestion du texte pour le global
      tdElements[i][j].innerText = tdAllInformationBefore[j];
    }
    if (i == 3) {
      buttonAdd.style.display = "none"; buttonRemove.style.display = "none";
    }

  }
  imageBack[i].src = linkBack;
  imageBack[i].classList.remove("animationBiging");
  imageBack[i].style.cursor = "not-allowed";
  imageSave[i].src = linkSave;
  imageSave[i].classList.remove("animationBiging");
  imageSave[i].style.cursor = "not-allowed";

}

function verificationTabAfterxBefore(index) {
  for (let j = 0; j < tdAllInformationBefore.length; j++) {
    if (tdAllInformationBefore[j] != tdAllInformationAfter[j]) {
      counterDiff++;
    }

  }
  if (counterDiff > 0) {
    imageSave[index].src = linkSaveAfter;
    imageSave[index].classList.add("animationBiging");
    imageSave[index].style.cursor = "pointer";
    YouCanSave[index] = true;
    counterDiff = 0;
  }
  else {
    imageSave[index].src = linkSave;
    imageSave[index].classList.remove("animationBiging");
    imageSave[index].style.cursor = "not-allowed";
    YouCanSave[index] = false;
    counterDiff = 0;
  }
}

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