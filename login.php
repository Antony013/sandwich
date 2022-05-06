<?php
	// Permet d'appeler la fonction de connexion à la BD
    require('Authentification_PHP/Authentification_PHP/connexion.php');
	
	// Démarrage d'une session
    session_start();

    // Connexion à la BD
    $co = connexionBdd();

    // php pour se connecter
    require("require/login_php.php");

	// php pour inscription
	require("require/register_php.php");    
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
				<button class="btn btn-default btn-register"><a href="#">S'inscrire</a></button>
			</div>
			<div id="box-co">
				<img src="img/img_login.png" alt="image connexion">
				<p>
					Vous possédez déjà un compte ? 
					<br>
					N’attendez plus, connectez-vous et commander votre sandwhich !
				</p>
				<button class="btn btn-default btn-log"><a href="#">Commander</a></button>
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
						<a href="login_backoffice.php">En tant qu'administrateur, je me connecte au backoffice.</a>
					</p>
					<br>
					<input class="btn-log" type="submit" name="btn-login" value="Se sonnecter">
				</form>
			</div>
			<!-- form pour s'inscrire -->
			<div id="form-register">
				<h2>S'inscrire</h2>
				<hr>
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
		</div>
	</section>

	<?php require"require/footer.php" ?>

</body>
</html>