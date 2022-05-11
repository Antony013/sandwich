<?php
	// Permet d'appeler la fonction de connexion à la BD
    require "../../Authentification_PHP/connexion.php";
	
	// Démarrage d'une session
    session_start();

    // Connexion à la BD
    $co = connexionBdd();

	// php pour inscription
	// on décalre et initialise nos message d'erreur à vide 
    $errorPass = $errorVoid = $errorEmail = $nom_user = $prenom_user = "";

	if (isset($_POST["btn-reg"])) {
		// on récupère l'adresse mail saisie qu'on met dans la var newmail
		$newmail = $_POST['email_user'];
		$nom_user = $_POST['nom_user'];
		$prenom_user = $_POST['prenom_user'];
		// on récupère le mdp saisie qu'on met dans la var newpass
		$newpass = $_POST['password_user'];

		// si le insert devient False alors l'inscription ne se fait pas
		$insert = True;

		// on prerape une requete pour selectionner le mail dans la bd 
		$mexist = $co->prepare('SELECT email_user FROM utilisateur WHERE email_user = ?');
		// on execute la requete
		$mexist->execute(array($newmail));
		// va permettre de parcourir les résultats
		$mailexist = $mexist->fetch();

		// on perare la requete pour inserer un nouveau utilisateur dans la bd
		$insertAccount = $co->prepare("INSERT INTO utilisateur (role_user, email_user, password_user, nom_user, prenom_user, active_user) VALUES ('b', :email_user, :password_user, :nom_user, :prenom_user, 1)");

		// on verifie si le mail existe ou pas
		if(!$mailexist){
			// on verifie si la longueur du mdp saisie fait au moins 8 caractères
			if (strlen($_POST["password_user"]) < '8') {
				$errorPass = "Votre mot de passe doit contenir 8 caractères ou plus, au minimum 1 chiffre et au moins un caractère spécial";
				$insert = False;
			}
			// on verifie qu'il y ai bien un chiffre dans le mdp saisie
			if (!preg_match("#[0-9]+#",$newpass)) {
				$errorPass = "Votre mot de passe doit contenir 8 caractères ou plus, au minimum 1 chiffre et au moins un caractère spécial";
				$insert = False;
			}
			// on verifie si il y a bien un caractère spécial dans le mdp saisie
			if (preg_match("#^[a-z0-9]+$#i", $newpass)) {
				$errorPass = "Votre mot de passe doit contenir 8 caractères ou plus, au minimum 1 chiffre et au moins un caractère spécial";
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
			$insertAccount -> execute(array('email_user' => $_POST['email_user'], 'password_user' => password_hash($_POST['password_user'], PASSWORD_ARGON2I), 'nom_user' => $_POST['nom_user'], 'prenom_user' => $_POST['prenom_user']));
			header("Location: ../login/login.php");
		}
	}   
?>

		<?php require(dirname(__DIR__) . '/header_footer/header.php'); ?>

		<section id="section-register">
			<h2>S'inscrire</h2>
			<div id="hr"></div>
			<div id="container-register">
				<form id="form-regis" method="post">
					<input type="text" name="nom_user" placeholder="Votre nom" value="<?php echo $nom_user; ?>">
					<?php echo $errorVoid; ?>
					<br>
					<input type="text" name="prenom_user" placeholder="Votre prénom" value="<?php echo $prenom_user; ?>">
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