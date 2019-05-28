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
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/css?family=Quicksand&display=swap" rel="stylesheet">

</head>
<body class="bg-light">
	<?php
       // Affichage du menu
	afficheMenu();
	if(!empty($_POST)){
	$insertion = insertion($_POST);
		if ($insertion== 1) {
			?>
			<div class="row">
				<div class="col-4 col-lg-4 col-xl-4"></div>
				<div class="col-12 col-sm-12 col-md-12 col-lg-4 col-xl-4">
					<div class="alert alert-success text-center" role="alert">
						<h4 class="alert-heading">Succés !</h4>
						<p>Votre insertion à bien été prise en compte. Vous allez etre redirigé vers la page d'acceuil dans 5 secondes.</p>
						<hr>
					</div>
				</div>
			</div>
			<?php //redirect('index.php',5);
		}
		else{
			?>
			<div class="row">
				<div class="col-4 col-lg-4 col-xl-4"></div>
				<div class="col-12 col-sm-12 col-md-12 col-lg-4 col-xl-4">
					<div class="alert alert-danger text-center" role="alert">
						<h4 class="alert-heading">Echec !</h4>
						<p>Votre insertion n'a pas bien été prise en compte suite à une erreur. Recommencez plus tard. Vous allez être redirigé vers la page d'acceuil dans 5 seconde.</p>
						<hr>
					</div>
				</div>
			</div>
			<?php //redirect('index.php',5);
		}
	}
	else {
afficheFormInserer($_POST);
}
?>







</body>

</html>
