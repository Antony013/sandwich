<?php
	// on décalre et initialise nos message d'erreur à vide 
    $errorPass = $errorVoid = $errorEmail = "";

	if (isset($_POST["btn-reg"])) {
		// on récupère l'adresse mail saisie qu'on met dans la var newmail
		$newmail = $_POST['email_user'];
		// on récupère le mdp saisie qu'on met dans la var newpass
		$newpass = $_POST['password_user'];

		// si le insert devient False alors l'inscription ne se fait pas
		$insert = False;

		// on prerape une requete pour selectionner le mail dans la bd 
		$mexist = $co->prepare('SELECT email_user FROM utilisateur WHERE email_user = ?');
		// on execute la requete
		$mexist->execute(array($newmail));
		// va permettre de parcourir les résultats
		$mailexist = $mexist->fetch();

		// on perare la requete pour inserer un nouveau utilisateur dans la bd
		$insert = $co->prepare("INSERT INTO utilisateur (role_user, email_user, password_user, nom_user, prenom_user, active_user) VALUES ('b', :email_user, :password_user, :nom_user, :prenom_user, 1)");

		// on verifie si le mail existe ou pas
		if(!$mailexist){
			// on verifie si la longueur du mdp saisie fait au moins 8 caractères
			if (strlen($_POST["password_user"]) < '8') {
				$errorPass = "Votre mot de passe doit contenir 8 caractères ou plus, au minimum 1 chiffre et au moins un caractère spécial";
				$insert = False;
			}
			// on verifie qu'il y ai bien un chiffre dans le mdp saisie
			if (!preg_match("#[0-9]+#",$newpass)) {
				$errorPass;
				$insert = False;
			}
			// on verifie si il y a bien un caractère spécial dans le mdp saisie
			if (preg_match("#^[a-z0-9]+$#i", $newpass)) {
				$errorPass;
				$insert = False;
			}
			// on verifie si le champ est vide
			if (empty($_POST['password_user'])) {
				$errorVoid = "Veuillez remplir le champ du formulaire";
				$insert = False;
			}
			// on verifie si le champ est vide
			if (empty($_POST['email_user'])) {
				$errorVoid = "Veuillez remplir le champ du formulaire";
				$insert = False;
			}
		}
		else {
			// si le mail existe déjà alors on lui fait apparaitre le message d'erreur
			$errorEmail = "Mail déjà utilisé, merci d'en saisir une autre";
			$insert = False;
		}
		// on verifie si le champ est vide
		if (empty($_POST['nom_user'])) {
				$errorVoid = "Veuillez remplir le champ du formulaire";
				$insert = False;
		}
		// on verifie si le champ est vide
		if (empty($_POST['prenom_user'])) {
				$errorVoid = "Veuillez remplir le champ du formulaire";
				$insert = False;
		}
		// on verifie si le insert est True ou False
		if ($insert == True) {
			// si le mail existe pas dans la bd alors on execute la requete
			$insert -> execute(array('email_user' => $_POST['email_user'], 'password_user' => $_POST['password_user'], 'nom_user' => $_POST['nom_user'], 'prenom_user' => $_POST['prenom_user']));
			header("Location: login.php");
		}
	}
?>