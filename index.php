<!DOCTYPE html>
<html lang="en">
   <head>
      <?php
         // On va utiliser des sessions 
         session_start();

         // On inclue les fontions
         include 'fonctions.php';
         include 'formulaire.php';

         // On vérifie qu'il y a bien un session avant d'accedere à la page
         if (empty($_SESSION)) {
             redirect('connexion.php', 0);
         }
         ?>
      <!-- Titre de la pahe -->
      <title>Location Materiel</title>
      <meta charset="UTF-8">
      <!-- Fichier de style pour le CSS perso -->
      <link rel="stylesheet" type="text/css" href="css/style.css">
      <!-- Fichier de style pour le CSS bootstrap -->
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
      <!-- Link  pour les polices (QuicxkSand)-->
      <link href="https://fonts.googleapis.com/css?family=Quicksand&display=swap" rel="stylesheet">
      <!-- Fichier de style pour les icons -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   </head>
   <body class="bg-light">
      <?php
         // Affichage du menu (header et navbar)
         afficheMenu();
         ?>
      <div class="container">
         <br>
         <br>
         <div class="row">
            <div class="col-sm card bg-transparent text-center border-light">
               <?php
                  if (!empty($_SESSION) && !empty($_GET) && isset($_GET["action"])) {
                      switch ($_GET["action"]) {
                          case "liste_produits_loue":
                                   echo '<h2>Liste des produits que vous louez</h2>';

                                     // On récupère la resultat de la requète SQL dans un tableau
                                      $res=listeProduitLoues($_SESSION["login"]);

                                // On récupère le nombre de produits loués
                                $nbProduits=afficheTableau($res);

                                // Si aucun produit n'est loué, on affiche un message
                                if ($nbProduits==0) {
                                    echo '<h3>Vous ne louez aucun produit</h3';
                                } else {
                                    // Sinon, on affiche ce tableau
                                    afficheTableau($res);
                                }
                                      break;
                      case "liste_produits_par_marque":
                              echo '<h2>Liste des produits par marque</h2>';
                              // Affichage du menu de choix de la marque
                              afficheProduitParMarque();
                              break;
                          }
                  } else {
                          // Cas ou on arrive sur la page la première fois
                          if (empty($_GET) && empty($_POST)) {
                              echo'<h2>Bienvenue sur votre page</h2>';
                              echo'<h4>vous êtes connecté en tant que '.$_SESSION["login"].'</h4>';
                              echo'<br><hr>';

                              // on affiche la liste des produits
                              echo '<h2>Liste des produits</h2>';
                              echo '<br>';
                              $res=listeProduit();
                              if ($res) {
                                  afficheTableau($res);
                              }
                          }

                          // Cas après avoir cliquer sur Louer
                          if (!empty($_SESSION) && !empty($_POST) && isset($_POST["Louer"]) && isset($_SESSION["login"])) {

                            // On vérifie que le produit n'est pas déjà loué
                              if (empty(estLoue($_POST["Louer"], $_SESSION["login"]))) {

                              // Si il ne l'est pas, on l'ajout à la liste des produits loués
                                  louerProduit($_POST["Louer"], $_SESSION["login"]);
                              } else {

                              // Sinon, on affiche un message
                                  echo '<h2>Produit "'.$_POST["Louer"].'" déjà loué</h2>';
                                  echo'
                                <a href="index.php?action=liste_produits_loue" title="Lister les produits loués" class="nav-link"><button type="submit" class="btn btn-info">
                                Liste de mes produits<i class="fas fa-shopping-cart">
                              </i></button></a>';
                              }
                          }
                      }

                        // Cas ou on a choisi une marque à afficher
                      if (!empty($_SESSION) && !empty($_POST) && isset($_POST["marque"])) {

                                // On affiche un message
                          echo '<h2>Liste des produits par marque</h2>';

                          // On affiche la menu deroulant encore
                          afficheProduitParMarque();

                          // On affiche la liste des produits désirés
                          $marque=listeProduitsParMarque($_POST["marque"]);
                          if ($marque) {
                              echo'<br>';
                          }
                          afficheTableau($marque);
                      }


                   ?>
            </div>
         </div>
         <?php
            // Destruction de la session si on clique sur Se deconnecter
            if (!empty($_GET) && isset($_GET['action']) && $_GET['action']=="logout") {
                session_destroy();
                $_SESSION=array();
                // on recharge la page
                redirect("index.php", 0);
            }
            ?>
         <br>
         <br>
         <br>
         <br>
      </div>
      <?php
         afficheFooter();
          ?>
      <script defer src="https://use.fontawesome.com/releases/v5.8.2/js/all.js" integrity="sha384-DJ25uNYET2XCl5ZF++U8eNxPWqcKohUUBUpKGlNLMchM7q4Wjg2CUpjHLaL8yYPH" crossorigin="anonymous"></script>
      <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
   </body>
</html>
