<?php
	require "Authentification_PHP/connexion.php";
	$database = connexionBdd();
	$select = $database -> query("SELECT * FROM accueil");
	$rowSelect = $select->fetch();
?>
		<?php require"require/header_footer/header.php" ?>

		<section id="section-index">	
			<div id="container-index">
				<!-- partie gauche de la page -->
				<div id="left-index">
					<p id="first-txt-index">
						C’est le bon moment pour commander votre sandwich préféré
					</p>
					<h1>
						La sandwicherie<br>de Saint-Vincent
					</h1>
					<p id="last-txt-index">
						<?php echo $rowSelect['texte_accueil']; ?>
					</p>
					<!-- Button pour le modal -->
					<button type="button" class="btn-menu" data-bs-toggle="modal" data-bs-target="#modal">
						Menu de la cantine
					</button>
					<!-- Modal pour afficher le menu de la cantine -->
					<div class="modal fade" id="modal" tabindex="-1" aria-labelledby="madal-label" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="madal-label">
										Menu de la cantine
									</h5>
									<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
								</div>
								<div class="modal-body">
									<iframe src="doc/<?php echo $rowSelect['lien_pdf'] ?>" style="width: 100%; min-height: 385px;" frameborder="0"></iframe>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
										Fermer
									</button>
								</div>
							</div>
						</div>
					</div>
					<!-- btn pour rediriger à la page de connexion -->
					<a href="require/login/login.php" >
						<button type="button" class="btn-log">
							Mon espace
						</button>
					</a>
				</div>
				<!-- partie droite de la page -->
				<div id="right-index">
					<img src="img/img_home.png" alt="image">
				</div>
			</div>
		</section>

	</body>
</html>