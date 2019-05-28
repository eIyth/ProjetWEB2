<?php


// Afficher le formulaire de choix de la marque
//******************************************************************************

function afficheProduitParMarque(){
    echo "<br/>";
 // CNX BDD + REQUETE pour obtenir les marques correspondantes à des produits

    $madb = new PDO('sqlite:bdd/bdd.db');
    $requete = "SELECT DISTINCT Nom, NoMarque FROM Marque";
    $resultat = $madb->query($requete);
    $tableau_marques = $resultat->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <fieldset>
            <select name="marque" size="1">
              <option value="0"> Selectionner votre marque </option>
	<?php // générer la liste des options à partir de $marque
	foreach ($tableau_marques as $marques){
		echo '<option value="'.$marques['NoMarque'].'">'.  $marques['Nom'].'</option>';
	}
	?>
</select>
<input type="submit" value="Rechercher" />
</fieldset>
</form>
<?php
echo "<br/>";
}// fin afficheProduitParMarque





// Afficher le formulaire de choix de la marque
//******************************************************************************

function afficheProduitParMarqueInserer(){
 // CNX BDD + REQUETE pour obtenir les marques correspondantes à des produits
    $madb = new PDO('sqlite:bdd/bdd.db');
    $requete = "SELECT DISTINCT Nom, NoMarque FROM Marque";
    $resultat = $madb->query($requete);
    $tableau_marques = $resultat->fetchAll(PDO::FETCH_ASSOC);
    ?>
            <label  for="exampleFormControlSelect1">Marque :</label>
            <select class="form-control" id="exampleFormControlSelect1" name="marque" size="1">
              <option value="0"> Selectionner votre marque </option>
	<?php // générer la liste des options à partir de $marque
    foreach ($tableau_marques as $marques){
		echo '<option  selecter value="'.$marques['NoMarque'].'">'.  $marques['Nom'].'</option>';
	}
	?>
</select>
<?php
}// fin afficheProduitParMarque




//#############################################################################################################
// permet d'afficher le formulaire de mofication:
function afficheFormModifier($donne){
    // on recupere les info que lon va utiliser par suite:
    $tab_info = recupInfoOutil($donne["nom"]);
    $tab_marque = recupMarqueOutils();
    ?>

    <div class="row">
        <div class="col-2 col-lg-2 col-xl-2"></div>
        <div class="col-12 col-sm-12 col-md-12 col-lg-8">
            <div class="card mt-4">
                <img style="margin:auto" class="" src="images/outils/<?php echo $tab_info["Image"]; ?>" alt="image">
                <div class="card-body">
                    <h3 class="card-title"><?php echo $donne["nom"];  ?></h3>
                    <h4><?php echo $tab_info["PrixHoraire"]; ?> €/Jour</h4>
                </div>
            </div>
            <div class="card card-outline-secondary my-4">
                <div class="card-header">
                    Mofication
                </div>
                <div class="card-body">
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" >

                        <div class="row">
                            <div class="col">
                                <label for="newNom">nom :</label>
                                <input class="form-control" required id="newNom" name="newNom" value="<?php echo $donne["nom"];  ?>"  />
                            </div>
                            <div class="col">
                                <label for="prix">prix : </label>
                                <input class="form-control" id="prix" name="prix"  value="<?php echo $tab_info["PrixHoraire"]; ?>" />
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col">
                                <label for="exampleFormControlSelect1">Marque :</label>
                                <select class="form-control" id="exampleFormControlSelect1" name="noMarque" size="1">
                                    <?php
                                    // on fait en sorte que la marque selectioné par defaut soit la marque actuelle de l'outils
                                    foreach ($tab_marque as $Marque ){

                                        if($tab_info["Marque"]==$Marque["NoMarque"]) {
                                            echo '<option selected  value="'.$Marque["NoMarque"].'">'.$Marque["Nom"].'</option>';
                                        }
                                        else {
                                            echo '<option value="'.$Marque["NoMarque"].'">'.$Marque["Nom"].'</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col">
                                <label for="prix">nom image : </label>
                                <input class="form-control" id="image" name="image"  value="<?php echo $tab_info["Image"]; ?>" />
                            </div>
                        </div>
                        <hr>
                        <input type="hidden" name="nom" value="<?php echo $donne["nom"];  ?>" />
                        <button type="submit" name="action" value="modifier" class="btn btn-primary">Modifier</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php }

//#############################################################################################################
// permet d'afficher le formulaire de mofication:
function afficheFormInserer($donne){
    // on recupere les info que lon va utiliser par suite:
    ?>

    <div class="row">
        <div class="col-2 col-lg-2 col-xl-2"></div>
        <div class="col-12 col-sm-12 col-md-12 col-lg-8">
            <div class="card card-outline-secondary my-4">
                <div class="card-header text-center">
                    Inserer
                </div>
                <div class="card-body">
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" >

                        <div class="row">
                            <div class="col">
                                <label for="newNom">Nom :</label>
                                <input class="form-control" required id="Nom" name="Nom" value=""  />
                            </div>
                            <div class="col">
                                <label for="prix">Prix : </label>
                                <input class="form-control" id="prix" name="prix"  value="" />
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col">
                              <?php
                              // On affiche la selection de la marque
                                afficheProduitParMarqueInserer();
                                ?>
                            </div>
                            <div class="col">
                                <label for="prix">Nom de mon image (elle doit être présente dans le dossier image) : </label>
                                <input class="form-control" id="image" name="image"  value="" />
                            </div>
                        </div>
                        <hr>
                            <button type="submit" name="action" value="inserer" class="btn btn-primary">Inserer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php }

//######################################################################################################################################################
// permet d'afficher le formulaire de supression:
function  afficheFormSuprimer($donne){
 // on recupere les info que lon va utiliser par suite:
 $tab_info = recupInfoOutil($donne["nom"]);
 $tab_marque = recupMarqueOutils();
 ?>

 <div class="row">
    <div class="col-2 col-lg-2 col-xl-2"></div>
    <div class="col-12 col-sm-12 col-md-12 col-lg-8">
        <div class="card mt-4">
            <img style="margin:auto" class="" src="images/outils/<?php echo $tab_info["Image"]; ?>" alt="image">
            <div class="card-body">
                <h3 class="card-title"><?php echo $donne["nom"];  ?></h3>
                <h4><?php echo $tab_info["PrixHoraire"]; ?> €/Jour</h4>
            </div>
        </div>
        <div class="card card-outline-secondary my-4">
            <div class="card-header">
                Information produit
            </div>
            <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <!--  On utilise des label et imput ici mais simplement pour leur style et l'atribut readonly qui est pratique-->
                            <label for="marque">Marque :</label>
                            <?php
                            // permet de sélectionner marque produit
                            foreach ($tab_marque as $Marque ){

                                if($tab_info["Marque"]==$Marque["NoMarque"]) {
                                    $marque = $Marque["Nom"];
                                }

                            }
                            ?>
                            <input class="form-control" readonly id="marque" name="marque"  value="<?php echo $marque; ?>" /
                        </select>
                    </div>
                    <div class="col">
                        <label for="image">Nom image : </label>
                        <input class="form-control" readonly id="image" name="image"  value="<?php echo $tab_info["Image"]; ?>" />
                    </div>
                </div>
                <hr>

            <!-- bouton pop up -->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
              Suprimer
          </button>

          <!-- pop up -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                     <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Etes-vous sur ?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        La supression d'un produit est définitive, aucun retour en arrière possible. Assurez vous de votre choix !
                    </div>
                    <div class="modal-footer">
                        <!-- Ici on va s envoyer les info utile par la suite-->
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" >
                            <input type="hidden" name="nom" value="<?php echo $donne["nom"];  ?>" />
                            <button type="submit" name="action" value="suprimer" class="btn btn-primary">Suprimer</button>
                        </form>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annulé</button>
                    </div>
                </div>
            </div>
        </div>
</div>
</div>
</div>
</div>



<?php
}
?>
