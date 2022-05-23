<?php
	// RÃ©cupÃ©ration des donnÃ©es de la session
	session_start();

	// VÃ©rifie si l'utilisateur est connectÃ©, sinon redirection vers la page de connexion
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

	$ok = "";

	// modification du pdf d'accueil - upload du fichier pdf
	if (isset($_POST["modifier-pdf"])) {
		//$lien_pdf = $_POST["lien_pdf"];
	    
	    // on déclre un tableau avec les extensions qu'on accepte donc ici que pdf
		// $validExt = array('.pdf');

		// on verifie si il y a une erreur dans le transfert
		if($_FILES['lien_pdf']['error'] > 0) {
			echo "Erreur dans le stranfert";
			// renvoi le numero de l'erreur et donc se referer a la doc
			echo $_FILES['lien_pdf']['error'];
		}

		$fileName = $_FILES['lien_pdf']['name'];
		
		$pathName = '../doc/'.basename($fileName);
		
		// si le resultat est true alors c'est réussi
		if(move_uploaded_file($_FILES['lien_pdf']['tmp_name'], $pathName)) {
			$select = $database -> query("SELECT lien_pdf FROM accueil");
			$row = $select->fetch();
			unlink("../doc/".$row['lien_pdf']);
		}

		// on update le lien dans la base de donnée
		$modifier = $database -> prepare("UPDATE accueil SET lien_pdf = ?");
		$modifier -> execute(array($fileName));	
		header("Location: backoffice.php");
	}?>
	<?php require"../require/header_footer/header_backoffice.php" ?>

	<section id="section-backoffice">	
		<!-- <p id="texte-backoffice">Toutes modifications sera irrÃ©cupÃ©rable et automatiquement appliquÃ© instantanÃ©ment sur la page d'accueil</p> -->
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
				<form role="form" method="post" name="form-modifier-pdf" enctype="multipart/form-data">
					<iframe src="../doc/<?php echo $rowSelect['lien_pdf'] ?>" style="width: 100%; min-height: 270px;" frameborder="0"></iframe>					<br><br>
					<input type="file" name="lien_pdf" accept=".pdf">
				<br>
				<br>
					<input type="submit" name="modifier-pdf" value="Modifier" class="btn-modif">
				</form>
			</div>
		</div>
	</section>

	</body>
</html>
