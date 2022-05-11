<?php
	// Permet d'appeler la fonction de connexion à la BD
    require('../../Authentification_PHP/connexion.php');
	
	// Démarrage d'une session
    session_start();

    // Connexion à la BD
    $co = connexionBdd();

    // php login au backoffice
	// on décalre et initialise nos message d'erreur à vide 
    $errorVoid = $errorId = "";

    // on regarde si les champs du formulaire est vide ou pas
	if (isset($_POST['btn-login'])) {
		if (!empty($_POST['email_user']) && !empty($_POST['password_user'])){ 
			// on recupere la valeur du champ mdp 
			$password_user = $_POST['password_user'];
			// enlève tout les caratères spéciaux
			$email_user = htmlspecialchars($_POST['email_user']);
			// on regarde si email_user est dans la bd et si les droits correspondant à l'identifiant sont administrateur
			$statement = $co->prepare("SELECT COUNT(*) FROM utilisateur WHERE role_user = 'a' AND email_user =?"); 
			// on execute la requete
			$statement->execute(array($email_user)); 
			// rows prend le nombre de ligne ou email_user est égal à la valeur saisie
			$rows = $statement ->fetchColumn(); 
			// on regarde si rows correspond à un utilisateur donc si c'est 1
			if ($rows == 1) { 
				// on select le hash qui correspond à email_user
				$statement = $co->prepare("SELECT password_user FROM utilisateur WHERE email_user = ?"); 
				// on execute la requete
				$statement->execute(array($email_user));
				// on va chercher récuperer les resultats
				$utilisateur = $statement->fetch();
				// on verifie que password_user correspond au hash de l'utilisateur
				if (password_verify($password_user, $utilisateur['password_user'])){ 
					// on démarre une session avec email_user
					$_SESSION['email_user'] = $email_user;
					// on redirige l'utilisateur
					header("Location: ../../backoffice.php");
				}
			}
			// si rows == 0 alors il n'y a pas d'utilisateur donc msg erreur
			else {
				$errorId = "Identifiants incorrects";
			}
		}
		// si les champt sont vide alors msg erreur
		else {
			$errorVoid = "Tous les champs doivent être remplis";
		}
	}
?>
		<?php require"../header_footer/header.php" ?>

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
						<input class="btn-log" type="submit" name="btn-login" value="Se connecter">
					</form>        		
				</div>
			</div>
		</section>

	</body>
</html>