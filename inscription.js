function verifierPass() { 
  var retour = false;
  //recuperer la mot de pass
  var pass = document.getElementById("pass");

  // On récupere le paragraphe à modifier en cas d'erreur
  var erreurPara = document.getElementById("erreurPass");

  // On récupere l'input pass à afficher en rouge en cas d'erreur
  var ligne = document.getElementsByClassName("pass");
  console.log(ligne);
  retour = /[A-Z]/.test(pass.value);

  if (retour == true) {
    if (/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/.test(pass.value)) {
      retour = true;
    } else {
      retour = false;
    }
  } else {
    retour = false;
  }

  if (retour != true) {
    erreurPara.innerHTML =
      "Votre mot de passe doit contenir au moins une majuscule et un caractère spécial";
    ligne[0].className += " erreur";
  }
  return retour;
}
