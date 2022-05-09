<?php
	// Permet d'appeler la fonction de connexion à la BD
    require('../Authentification_PHP/Authentification_PHP/connexion.php');
	
	// Démarrage d'une session
    session_start();

    // Connexion à la BD
    $co = connexionBdd();

    // php login au backoffice
	require("login_backoffice_php.php");
?>
		<?php require"header.php" ?>

		<section id="section-login-backoffice">
			<div id="conteneur-login-backoffice">
				<div id="form-login-backoffice">
					<h2>Se connecter en tant qu'administrateur</h2>
					<hr>
					<form id="form-connect" method="post">
						<input type="mail" name="email_user" placeholder="Votre adresse mail">
						<br>
						<input type="password" name="password_user" placeholder="Votre mot de passe">
						<?php echo $errorId; ?>
						<br>
						<br>
						<?php echo $errorVoid; ?>
						<input id="btn-log" type="submit" name="btn-login" value="Se sonnecter">
					</form>        		
				</div>
			</div>
		</section>

	</body>
</html>