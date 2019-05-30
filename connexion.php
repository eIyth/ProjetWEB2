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
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="icon" type="image/png" href="images/icons/disquette.ico"/>
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
               Connexion
               </span>
               <form id="form1" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="login100-form validate-form p-b-33 p-t-5">
                  <div class="wrap-input100" data-validate = "Entrer votre email">
                     <input class="input100" type="text" name="email" placeholder="Adresse mail">
                  </div>
                  <div class="wrap-input100 validate-input" data-validate="Entrer un mot de passe">
                     <input class="input100" id="pass" type="password" name="pass" placeholder="Mot de passe">
                  </div>
                  <div class="container-login100-form-btn m-t-32">
                     <button class="login100-form-btn">
                     Se connecter
                     </button>
                     <a style="text-decoration:none" href="inscription.php" class="login100-form-btn">
                     S'inscrire
                     </a>
                  </div>
                  <?php
                     if (!empty($_POST)) {
                       // On test la connexion
                         if (compteExiste($_POST["email"], $_POST["pass"])) {

                           // Si oui, on redirige vers la page d'acceuil
                             redirect("index.php", 0);

                             // Et on créer une session avec le login de la personne
                             $_SESSION["login"]=$_POST["email"];

                             // On test ensuite si cette personne est admin
                             if (isAdmin($_SESSION["login"])) {

                               // On indique son status dans la SESSION
                                 $_SESSION["status"]="admin";
                             } else {
                                 $_SESSION["status"]="membre";
                             }

                          // Si non, on affiche un message derreur
                         } else {
                             echo '<p align="center"></br> Connexion échouée, verifier votre email/mot de passe </p>';
                         }
                     }
                     ?>
               </form>
            </div>
         </div>
      </div>
   </body>
</html>
