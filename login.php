<?php
	// Permet d'appeler la fonction de connexion à la BD
    require('Authentification_PHP/Authentification_PHP/connexion.php');
	
	// Démarrage d'une session
    session_start();

    // Connexion à la BD
    $co = connexionBdd();

    // php pour se connecter
    require("require/login_php.php");   
?>
	<?php require"require/header.php" ?>

	<section id="section-login">
		<div id="container-login">
			<div id="box-reg">
				<img src="img/img_login.png" alt="image connexion">
				<p>
					Vous n’avez pas encore de compte ? 
					<br>
					N’attendez plus, inscrivez-vous pour commander votre sandwich !
				</p>
				<a href="register.php"><button class="btn btn-default btn-register">S'inscrire</button></a>
			</div>
			<!-- form pour se connecter -->
			<div id="form-login">
				<h2>Se connecter</h2>
				<hr>
				<form id="form-connect" method="post">
					<input type="mail" name="email_user" placeholder="Votre adresse mail">
					<br>
					<input type="password" name="password_user" placeholder="Votre mot de passe">
					<?php echo $errorId; ?>
					<?php echo $errorVoid; ?>
					<br>
					<!-- <p id="mdp">
						<a href="forgetpassword.php">Mot de passe perdu ?</a>
					</p> -->
					<br>
					<p>
						<a href="require/login_backoffice.php">En tant qu'administrateur, je me connecte au backoffice.</a>
					</p>
					<br>
					<input class="btn-log" type="submit" name="btn-login" value="Se sonnecter">
				</form>
			</div>
		</div>
	</section>

</body>
</html>