<?php
	// Récupération des données de la session
	session_start();

	// Vérifie si l'utilisateur est connecté, sinon redirection vers la page de connexion
	if(!isset($_SESSION["email_user"])){
		header("Location: ../require/login/login.php");
		exit(); 
	}

	require "../Authentification_PHP/connexion.php";
	$database = connexionBdd();
	$select = $database -> query("SELECT * FROM accueil");
	$rowSelect = $select->fetch();

	if (isset($_POST["modifier-texte"])) {
		$texte_accueil = $_POST["texte_accueil"];
		$modifier = $database -> query("UPDATE accueil SET texte_accueil = '$texte_accueil'");	
		header("Location: backoffice.php");
	}

	if (isset($_POST["modifier-pdf"])) {
		$lien_pdf = $_POST["lien_pdf"];
		$modifier = $database -> query("UPDATE accueil SET lien_pdf = '$lien_pdf'");	
		header("Location: backoffice.php");
	}
?>
	<?php require"../require/header_footer/header_backoffice.php" ?>

	<section id="section-backoffice">	
		<!-- <p id="texte-backoffice">Toutes modifications sera irrécupérable et automatiquement appliqué instantanément sur la page d'accueil</p> -->
		<div id="container-backoffice">
			<div id="left-backoffice">
				<h1>La sandwicherie<br>de Saint-Vincent</h1>
				<br>
				<p id="last-txt-backoffice"><?php echo $rowSelect['texte_accueil']; ?></p>
				<!-- btn modal pour modifier -->
				<button type="button" class="btn-modif" data-bs-toggle="modal" data-bs-target="#modal-modif">Modifier</button>

				<!-- Modal pour modifier -->
				<div class="modal fade" id="modal-modif" tabindex="-1" aria-labelledby="label-modal" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="label-modal">Modification du texte d'accueil</h5>
								<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
							</div>
							<div class="modal-body">
								<form role="form" method="post" name="form-modifier">
									<textarea type="text" id="bo_texte_accueil" name="texte_accueil" placeholder="Texte de l'accueil"><?php echo $rowSelect['texte_accueil']; ?></textarea>
									<br><br>
									<input type="submit" name="modifier-texte" value="Enregistrer" class="btn btn-primary">
								</form>
								<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div id="right-backoffice">
				<form role="form" method="post" name="form-modifier-pdf">
					<embed src="doc/<?php echo $rowSelect['lien_pdf']; ?>"/>
					<br><br>
					<input type="file" name="lien_pdf" accept=".pdf">
       				<br><br>
					<input type="submit" name="modifier-pdf" value="Modifier" class="btn-modif">
				</form>
			</div>
		</div>
	</section>

	</body>
</html>