<?php 
	// Permet d'appeler la fonction de connexion à la BD
    require('Authentification_PHP/Authentification_PHP/connexion.php');

	// Récupération des données de la session
	session_start();

	// Connexion à la BD
    $co = connexionBdd();

	// Vérifie si l'utilisateur est connecté, sinon redirection vers la page de connexion
	if(!isset($_SESSION["email_user"])){
		header("Location: login.php");
		exit(); 
	}

	//$co -> query("SELECT * FROM utilisateur WHERE email_user=". $_SESSION['email_user']);
	$mail = $_SESSION["email_user"];
?>

<h1>HISTORIQUE de <?php echo $mail ?></h1>


<a href="require/logout.php">Se déconnecter
	<span class="bi bi-box-arrow-in-right"></span>
</a>