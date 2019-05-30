<?php 

session_start();

include 'fonctions.php';
include 'formulaire.php';

if(empty($_SESSION)){
	redirect('connexion.php',0);
}

if( $_SESSION["status"] != "admin" ){
	redirect('index.php',0);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>Location Materiel</title>
	<meta charset="UTF-8">
	<!-- Plus de link car il y a un pop up-->
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/css?family=Quicksand&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<body class="bg-light">
	<?php
       // Affichage du menu
	afficheMenu();

	// si on veux suprimer on fait une suppression sinon on affiche le formulaire
	if( $_POST["action"] == "suprimer"){
		$supression = supression($_POST);
		// si la supression a fonctionné on affiche un message succé sinon un message echec
		if ($supression == 1) {
			?>
			<div class="row">
				<div class="col-4 col-lg-4 col-xl-4"></div>
				<div class="col-12 col-sm-12 col-md-12 col-lg-4 col-xl-4">
					<div class="alert alert-success text-center" role="alert">
						<h4 class="alert-heading">Succés !</h4>
						<p>Le produit à bien été suprimer. Vous aller etre redirigé vers la page d'acceuil dans 5 seconde.</p>
						<hr>
					</div>
				</div>
			</div>
			<?php redirect('index.php',5);
		}
		else{
			?>
			<div class="row">
				<div class="col-4 col-lg-4 col-xl-4"></div>
				<div class="col-12 col-sm-12 col-md-12 col-lg-4 col-xl-4">
					<div class="alert alert-danger text-center" role="alert">
						<h4 class="alert-heading">Echec !</h4>
						<p>Le produit n'à pas pu etre suprimé. Recommencez plus tard. Vous aller etre redirigé vers la page d'acceuil dans 5 seconde.</p>
						<hr>
					</div>
				</div>
			</div>
			<?php redirect('index.php',5);
		}
	}
	else{ afficheFormSuprimer($_POST); }
	?>

</body>

</html>