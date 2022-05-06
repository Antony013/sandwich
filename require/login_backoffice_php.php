<?php
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
					header("Location: backoffice.php");
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