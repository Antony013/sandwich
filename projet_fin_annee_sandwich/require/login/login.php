<?php
	// Permet d'appeler la fonction de connexion à la BD
    require "../../Authentification_PHP/connexion.php";
	// require(__DIR__.'/../Authentification_php/connexion.php');

	// Démarrage d'une session
    session_start();

    // Connexion à la BD
    $co = connexionBdd();

    // php pour se connecter
    // on décalre et initialise nos message d'erreur à vide 
    $errorVoid = $errorId = $errorPass = "";

    // on regarde si les champs du formulaire est vide ou pas
    if (isset($_POST['btn-login'])) {
        if (!empty($_POST['email_user']) && !empty($_POST['password_user'])){ 
            // on recupere la valeur du champ mdp 
            $password_user = $_POST['password_user'];
            // enlève tout les caratères spéciaux
            $email_user = $_POST['email_user'];
            // on regarde si email_user est dans la bd et si les droits correspondant à l'identifiant sont administrateur
            $statement = $co->prepare("SELECT COUNT(*) FROM utilisateur WHERE role_user = 'b' AND email_user =? AND active_user = 1"); 
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
                    header("Location: /projet_fin_annee_sandwich/history/history.php");
                }
                else {
                    $errorPass = "Mot de passe incorrects";
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
		<?php require(dirname(__DIR__) . '/header_footer/header.php'); ?>

		<section id="section-login">
			<div id="container-login">
				<div id="box-reg">
					<img src="/projet_fin_annee_sandwich/img/img_login.png" alt="image connexion">
					<p>
						Vous n’avez pas encore de compte ? 
						<br>
						N’attendez plus, inscrivez-vous pour commander votre sandwich !
					</p>
					<a href="/projet_fin_annee_sandwich/require/register/register.php"><button class="btn btn-default btn-register">S'inscrire</button></a>
				</div>
				<!-- form pour se connecter -->
				<div id="form-login">
					<h2>Se connecter</h2>
					<hr>
					<form id="form-connect" method="post">
						<input type="mail" name="email_user" placeholder="Votre adresse mail">
						<br>
						<input type="password" name="password_user" placeholder="Votre mot de passe">
						<?php echo $errorPass; ?>
						<?php echo $errorId; ?>
						<?php echo $errorVoid; ?>
						<br>
						<!-- <p id="mdp">
							<a href="forgetpassword.php">Mot de passe perdu ?</a>
						</p> -->
						<br>
						<p>
							<a href="/projet_fin_annee_sandwich/require/login/login_backoffice.php">En tant qu'administrateur, je me connecte au backoffice.</a>
						</p>
						<br>
						<input class="btn-log" type="submit" name="btn-login" value="Se sonnecter">
					</form>
				</div>
			</div>
		</section>

	</body>
</html>