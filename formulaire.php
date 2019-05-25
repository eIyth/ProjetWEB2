<?php


// Afficher le formulaire de choix de la marque
//******************************************************************************

function afficheProduitParMarque()
{
    echo "<br/>";
    // CNX BDD + REQUETE pour obtenir les marques correspondantes à des produits

    $madb = new PDO('sqlite:bdd/bdd.db');
    $requete = "SELECT DISTINCT Nom, NoMarque FROM Marque";
    $resultat = $madb->query($requete);
    $tableau_marques = $resultat->fetchAll(PDO::FETCH_ASSOC); ?>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <fieldset>
                <label class="id_marque">Marque :</label>
                <select id="id_marque" name="marque" size="1">
  <option value="0"> Selectionner votre marque </option>
	<?php // générer la liste des options à partir de $marque
    foreach ($tableau_marques as $marques) {
        echo '<option value="'.$marques['NoMarque'].'">'.  $marques['Nom'].'</option>';
    } ?>
</select>
                <input class="btn btn-info" type="submit" value="Rechercher" />
            </fieldset>
          </form>
        <?php
echo "<br/>";
}// fin afficheProduitParMarque
?>
