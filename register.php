<?php
	// Permet d'appeler la fonction de connexion à la BD
    require('Authentification_PHP/Authentification_PHP/connexion.php');
	
	// Démarrage d'une session
    session_start();

    // Connexion à la BD
    $co = connexionBdd();

	// php pour inscription
	require("require/register_php.php");    
?>

		<?php require"require/header.php" ?>

		<section id="section-register">
			<h2>S'inscrire</h2>
			<hr id="hr">
			<div id="container-register">
				<form id="form-regis" method="post">
					<input type="text" name="nom_user" placeholder="Votre nom">
					<?php echo $errorVoid; ?>
					<br>
					<input type="text" name="prenom_user" placeholder="Votre prénom">
					<?php echo $errorVoid; ?>
					<br>
					<input type="mail" name="email_user" placeholder="Votre adresse mail">
					<?php echo $errorVoid; ?>
					<?php echo $errorEmail; ?>
					<br>
					<input type="password" name="password_user" placeholder="Votre mot de passe">
					<?php echo $errorPass; ?>
					<br>
					<input class="btn-reg" type="submit" name="btn-reg" value="S'inscrire">
				</form>
			</div>
		</section>

	</body>
</html>