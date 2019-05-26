<script src="inscription.js"></script>
<?php

//Page Connexion.php

//Page permetant de verifier qu'un combo nom d'utilisateur + mot de pass existe
//******************************************************************************
function compteExiste($mail, $pass)
{
    logConnexion($mail);
    $retour = false ;
    try {
        $madb = new PDO('sqlite:bdd/bdd.db');
        $mail= $madb->quote($mail);
        $pass = $madb->quote($pass);
        $requete = "SELECT login,password FROM Compte WHERE login LIKE $mail AND password LIKE $pass;" ;
        $resultat = $madb->query($requete);
        $tableau_assoc = $resultat->fetchAll(PDO::FETCH_ASSOC);
        if (sizeof($tableau_assoc)!=0) {
            $retour = true;
        }
    } catch (Exception $e) {
        echo "<p>T'es un bouffon</p>";
        echo $e->getMessage();
        die();
    }
    return $retour;
}


// Fonction permetant l'écrire d'un fichier d elog pour chaque tentative de connexion
//******************************************************************************
function logConnexion($mail)
{
    $ip = $_SERVER['REMOTE_ADDR'];
    $time = date("l, j F Y [h:i a]");
    $log = "IP: $ip du login $mail à  $time";
    error_log("$log \n", 3, "logs/logs.php");
}

// Fonction permetant de verifier si un utilisateur est un simple membre ou un admin
//******************************************************************************
function isAdmin($mail)
{
    $retour = false ;
    // A faire
    try {
        $madb = new PDO('sqlite:bdd/bdd.db');
        $mail= $madb->quote($mail);
        $requete = "SELECT status FROM Compte WHERE  login LIKE $mail";
        $resultat = $madb->query($requete);
        $tab_status = $resultat->fetch(PDO::FETCH_ASSOC);
        if ($tab_status["status"]=='admin') {
            $retour = true ;
        }
    } catch (Exception $e) {
        echo "<p>Site en maintenance</p>";
        echo $e->getMessage();
        die();
    }

    return $retour;
}


// Fonction permétant de rediriger sur un URL l'utilisateur
//******************************************************************************
function redirect($url, $tps)
{
    $temps = $tps * 1000;

    echo "<script type=\"text/javascript\">\n"
    . "<!--\n"
    . "\n"
    . "function redirect() {\n"
    . "window.location='" . $url . "'\n"
    . "}\n"
    . "setTimeout('redirect()','" . $temps ."');\n"
    . "\n"
    . "// -->\n"
    . "</script>\n";
}

// Page index.php


// Fonction permetant d'afficher la liste complète des produits
//********************************************************************************
function listeProduit()
{
    $retour = false ;
    try {
        $madb = new PDO('sqlite:bdd/bdd.db');
        $requete = "SELECT Outils.Image as 'Photo',Outils.Nom as 'Nom',Marque.Nom as 'Marque' FROM Outils INNER JOIN Marque ON Outils.Marque=Marque.NoMarque";
        $resultat = $madb->query($requete);
        $retour=$resultat;
    } catch (Exception $e) {
        echo "<p>Site en maintenance</p>";
        echo $e->getMessage();
        die();
    }
    return $retour;
}


// Fonction permetant de transformer la tableau de al requêtre SQL en tableau HTML
//*******************************************************************************************
function afficheTableau($tab)
{
    $i=0;
    echo'<div class="row">';
    // le corps de la table
    while ($donnees= $tab->fetch()) {
        $i++; ?>

				<div class="col-12 col-sm-12 col-md-12 col-lg-4 col-xl-4">
            <div class="card shadow">
              <img style="margin:auto" class="" src="images/outils/<?php echo $donnees['Photo']; ?>" alt="image">
              <div class="card-body">
                <h5 class="card-title"><?php echo $donnees['Nom']; ?></h5>
                <p class="card-text"><small class="text-muted"><?php echo $donnees['Marque']; ?></small></p>
								<?php
                                if ($_SESSION["status"]=="admin") {
                                    ?>
									<form method="post" action="modification.php">

									</form>
									<br>
                  <form method="post" action="modification.php">
										<button class="btn btn-info" type="submit" value="<?php echo $donnees["Nom"]?>" name="nom">Modifier</button>
									</form>
                  <br>
									<form method="post" action="insertion.php">
										<button class="btn btn-info" type="submit" value="<?php echo $donnees["Nom"]?>" name="nom">Supprimer</button>
									</form>
									<?php
                                } else {
                                    if (!estLoue($donnees["Nom"], $_SESSION["login"])) {
                                        ?>
									<form method="post" action="<?php echo  $_SERVER["PHP_SELF"]?>">
										<button class="btn btn-info" type="submit" value="<?php echo $donnees["Nom"]?>" name="Louer">Louer</button>
									</form>
									<?php
                                    } else {
                                        ?>
											<button disabled="disabled" class="btn btn-grey" type="submit" value="<?php echo $donnees["Nom"]?>" name="DejaLoue">Produit déjà loué</button>
										<?php
                                    }
                                } ?>
              </div>
        </div>
			<br>
			</div>
        <?php
    }
    echo'</div>';
    return $i;
}


// Fonction permetant d'afficher une liste contenant toutes les marques disponnibles
//*******************************************************************************************
function listeProduitsParMarque($marque)
{
    $retour = false ;
    // A faire
    try {
        $madb = new PDO('sqlite:bdd/bdd.db');

        $marque= $madb->quote($marque);
        $requete = "SELECT Outils.Nom as 'Nom',Marque.Nom as 'Marque',Outils.Image as 'Photo' FROM Outils INNER JOIN Marque ON Outils.Marque=Marque.NoMarque WHERE Marque.NoMarque=$marque";
        $resultat = $madb->query($requete);
        $retour=$resultat;
    } catch (Exception $e) {
        echo "<p>Problème interne, merci de réessayer plus tard</p>";
        echo $e->getMessage();
        die();
    }
    return $retour;
}


// Fonction qui permet d'afficher tous les produits loué par l'utilisateur passé en paramètre
//*******************************************************************************************
function listeProduitLoues($login)
{
    $retour = false ;

    try {
        $madb = new PDO('sqlite:bdd/bdd.db');

        $login= $madb->quote($login);
        $requete = "SELECT Outils.Nom as 'Nom',Marque.Nom as 'Marque',Outils.Image as 'Photo' FROM Outils INNER JOIN Marque ON Outils.Marque=Marque.NoMarque INNER JOIN Location ON Location.NoOutils=Outils.NoOutils WHERE Location.LoginLocataire=$login";
        $resultat = $madb->query($requete);
        $retour=$resultat;
    } catch (Exception $e) {
        echo "<p>Problème interne, merci de réessayer plus tard</p>";
        echo $e->getMessage();
        die();
    }
    return $retour;
}

// Fonction qui permet de louer un produit depuis la liste
//*******************************************************************************************
function louerProduit($nom, $login)
{
    try {
        $madb = new PDO('sqlite:bdd/bdd.db');
        $madb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Filtrer les paramètres
        $nom= $madb->quote($nom);
        $login= $madb->quote($login);

        $requete = "INSERT INTO Location (LoginLocataire,NoOutils,DateLocation)
									VALUES($login,(SELECT Outils.NoOutils FROM Outils WHERE Outils.Nom=$nom),'26/04/2019');";


        $res=$madb->exec($requete);
        if ($res==1) {
            $retour = 1;
        }

        // Si la requête est réussie, on affiche un message et un lien vers la liste des produits loués
        echo '<h2>Produit '.$nom.' correctement loué</h2><br>';
        echo'
				<a href="index.php?action=liste_produits_loue" title="Lister les produits loués" class="nav-link"><button type="submit" class="btn btn-info">
				Liste de mes produits<i class="fas fa-shopping-cart">
			</i></button></a>';
    } catch (Exception $e) {

            // Sinon, on affiche un message d'erreur
        echo "<p>Problème interne, merci de réessayer plus tard</p>";
        echo $e->getMessage();
        die();
    }
    return $retour;
}

// Fonction pour tester qu'un produit n'est pas déjà loué par un $tab_utilisateur
//*******************************************************************************************
function estLoue($nom, $login)
{
    $retour = false ;

    try {
        $madb = new PDO('sqlite:bdd/bdd.db');

        $login= $madb->quote($login);
        $nom= $madb->quote($nom);

        $requete = "SELECT * FROM Location l INNER JOIN Outils o ON l.NoOutils=o.NoOutils WHERE l.LoginLocataire=$login AND o.Nom=$nom";
        $resultat = $madb->query($requete);
        $tab_locations = $resultat->fetchAll(PDO::FETCH_ASSOC);

        if (sizeof($tab_locations)) {
            $retour = $tab_locations;
        }
    } catch (Exception $e) {
        echo "<p>Problème interne, merci de réessayer plus tard</p>";
        echo $e->getMessage();
        die();
    }
    return $retour;
}



// Afficher le menu de selection en fonction du status
function afficheMenu()
{
    ?>
<nav class="navbar rounded-bottom navbar-expand-lg navbar-light bg-white">
  <a class="navbar-brand" href="#">Location Materiel</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
     <ul class="navbar-nav mr-auto">
       <li class="nav-item">
         <a href="index.php" title="Index" class="nav-link">Index</a>
       </li>
       <li class="nav-item">
           <a href="index.php?action=liste_produits_loue" title="Lister les produits loués" class="nav-link">
             Lister le(s) produits loué(s)</a>
       </li>
       <li class="nav-item">
         <a href="index.php?action=liste_produits_par_marque" title="Lister les produits par marque" class="nav-link">
           Lister les produits par marque</a>
       </li>
       <?php
 //Si la personne est 	admin, on ajoute des lignes au tableau
 if ($_SESSION["status"]=="admin") {
     ?>
       <li class="nav-item">
         <a href="insertion.php?action=inserer_produit" title="Insérer un produit" class="nav-link">
           Insérer un produit</a>
       </li>
       <?php
 } ?>
      </ul>

    </div>
      <a class="btn btn-primary" href="index.php?action=logout" title="Déconnexion">Se déconnecter</a>
  </nav>
      <?php
}

function afficheFooter()
{
    ?>
		<footer class="pied bg-dark text-center">
				<br>
				<span class="text-muted" >Gwenc'hlan / Mathis
				</span>
				<br>
				<br>
		</footer>
<?php
}

// Page inscription d'un membre
//*******************************************************************************************
function inscrire($email, $pass, $nom, $prenom, $ville, $cp)
{
    $retour = false ;

    try {
        $madb = new PDO('sqlite:bdd/bdd.db');
        $madb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $email= $madb->quote($email);
        $pass= $madb->quote($pass);
        $nom= $madb->quote($nom);
        $prenom= $madb->quote($prenom);
        $ville= $madb->quote($ville);
        $ville=strtoupper($ville);
        $cp= $madb->quote($cp);
        $recupInsee=recupInsee($ville, $cp);
        $insee=$recupInsee["insee"];
        if (!empty($insee)) {
            $requete = "INSERT INTO Compte VALUES ($email,$pass,$nom,$prenom,$insee,'membre')";
            $res = $madb->exec($requete);
            if ($res==1) {
                $retour = 1;
            }
        }
    } catch (Exception $e) {
        echo '<p align="center"> Email déjà utilisé, veuillez en choisir un nouveau</p>';
        die();
    }
    return $retour;
}

// Page inscription d'un membre
// Recuperer l'insee grâve au nom de la ville et à son Code postale
//*******************************************************************************************
function recupInsee($ville, $cp)
{
    $retour = false ;

    $madb = new PDO('sqlite:bdd/bdd.db');

    $requete = "SELECT insee FROM villes WHERE cp=$cp AND commune=$ville";
    $resultat = $madb->query($requete);
    $tab_ville = $resultat->fetchAll(PDO::FETCH_ASSOC);
    if (sizeof($tab_ville)) {
        $retour = $tab_ville[0] ;
    }
    return $retour;
}


                            ?>
