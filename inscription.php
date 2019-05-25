<!DOCTYPE html>
<html lang="en">
   <head>
      <?php session_start();?>
      <?php
         include 'fonctions.php';
         ?>
      <script>
         function valider(){
         	var login=document.forms["form1"].elements["2"];
         }
      </script>
      <title>Location Materiel</title>
      <style>
         .erreur input{
         border : 1px solid red;
         }
      </style>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
      <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
      <link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
      <link rel="stylesheet" type="text/css" href="css/util.css">
      <link rel="stylesheet" type="text/css" href="css/main.css">
   </head>
   <body style="background: url('https://mdbootstrap.com/img/Photos/Others/architecture.jpg') no-repeat center center fixed">
      <div class="limiter">
         <div class="container-login100">
            <div class="wrap-login100 p-t-30 p-b-50">
               <span class="login100-form-title p-b-41">
               Inscription
               </span>
               <form id="form1" action="<?php echo $_SERVER['PHP_SELF']; ?>" onsubmit="return verifierPass();" method="post" class="login100-form validate-form p-b-33 p-t-5" >
                  <div class="wrap-input100" data-validate = "Entrer votre nom">
                     <input class="input100" type="text" name="nom" placeholder="Nom" required>
                  </div>
                  <div class="wrap-input100" data-validate = "Entrer votre Prenom">
                     <input class="input100" type="text" name="prenom" placeholder="Prenom" required>
                  </div>
                  <div class="wrap-input100" data-validate = "Entrer votre email">
                     <input class="input100" type="text" name="email" placeholder="Adresse mail" required>
                  </div>
                  <div class="wrap-input100 validate-input pass" data-validate="Entrer un mot de passe">
                     <input class="input100" id="pass" type="password" name="pass" placeholder="Mot de passe">
                  </div>
                  <div class="wrap-input100 validate-input" data-validate="Entrer votre ville">
                     <input class="input100" type="text" name="ville" placeholder="Ville" required>
                  </div>
                  <div class="wrap-input100 validate-input" data-validate="Entrer votre code poste">
                     <input class="input100" type="number" name="cp" placeholder="Code postale" required>
                  </div>
                  <div class="container-login100-form-btn m-t-32">
                     <button class="login100-form-btn">
                     S'inscrire
                     </button>
                  </div>
                  <p align="center" id="erreurPass"></p>
                  <?php
                     if (!empty($_POST)) {
                         if (!compteExiste($_POST["email"], $_POST["pass"])) {
                             if (inscrire($_POST["email"], $_POST["pass"], $_POST["nom"], $_POST["prenom"], $_POST["ville"], $_POST["cp"])==1) {
                                 echo '<p align="center"> Inscription réussie, vous allez être redirigé vers la page de connexion</p>';
                                 redirect("index.php", 5);
                             } else {
                                 echo '<p align="center">Verifier votre Ville/Code Postale</p>';
                             }
                         } else {
                             echo '<p align="center"></br> Votre email existe déjà, veuillez en choisir un autre </p>';
                         }
                     }
                     ?>
               </form>
            </div>
         </div>
      </div>
      <!-- On inclu le fichier JavaScript pour verifier la validiter du mot de passe -->
      <!--===============================================================================================-->
      <script src="inscription.js"></script>
   </body>
</html>
