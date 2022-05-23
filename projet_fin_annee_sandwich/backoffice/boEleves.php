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

	require "../require/header_footer/header_backoffice.php" ;

	if(isset($_POST["modify-eleve"])){
		#récupération de l'id du produit à modifier puis modification
		$idModif = $_POST['idModif'];
		$newName = $_POST['newName'];
		$newSurname = $_POST['newSurname'];
		$newEmail = $_POST['newEmail'];
		$active = $_POST['active'];

		$ok = True;

		if (empty($newName)){
			$ok = False;
			$newProductError = "Un champ n'est pas rempli";
		}
		else if (empty($newSurname)){
			$ok = False;
			$newProductError = "Un champ n'est pas rempli";
		}
		else if (empty($newEmail)){
			$ok = False;
			$newProductError = "Un champ n'est pas rempli";
		}

		if ($active == "Actif"){
			$active = 1;
		}
		else{
			$active = 0;
		}

		$select = $database -> prepare("SELECT email_user FROM utilisateur WHERE id_user != ?");
		$select -> execute(array($idModif));
		$new = True;
		while ($rowSelect = $select -> fetch()){
			if ($newEmail == $rowSelect['email_user']){
				$new = False;
				$newProductError = "Cette adresse E-mail est déjà attribué";
			}
		}

		if ($new and $ok){
			$update = $database -> prepare("UPDATE utilisateur SET nom_user = ? , prenom_user = ? , email_user = ? , active_user = ? WHERE id_user=?");
			$update -> execute(array($newSurname,$newName,$newEmail,$active,$idModif));
		}
		else{
			echo '	<script language="Javascript">
						alert ("'.$newProductError.'" )
					</script>';
		}

	}
	else if(isset($_POST["delete-eleve"])){
		#récupération de l'id du produit à supprimer puis suppresion
		$idSup = $_POST['idSup'];
		$delete = $database -> prepare("DELETE FROM utilisateur WHERE id_user=?");
		$delete -> execute(array($idSup));
	}
	else if(isset($_POST["disable-eleve"])){
		#récupération de l'id du produit à supprimer puis suppresion
		$idDisable = $_POST['idDisable'];
		$update = $database -> prepare("UPDATE utilisateur SET active_user = ? WHERE id_user=?");
		$update -> execute(array(0,$idDisable));
	}
?>	

		<section id="students-consultation">
			<h2>Elèves</h2>
			<div id="hr"></div>
			<!-- création d'un tableau -->
			<table class="table table-striped table-bordered">
				<tr>
					<!-- titre des colones -->
					<th style="width: 100px">Nom</th>
					<th style="width: 100px">Prénom</th>
					<th>Actif</th>
					<th>Actions</th>
				</tr>
				<?php 
					#récupération et affichage des données de la table eleve
					$select = $database -> query("SELECT * from utilisateur WHERE role_user = 'b'");

					#compteur de tour de boucle
					$compt = 1;

					while ($rowSelect = $select->fetch()) {
						
						$nameEleve = $rowSelect['prenom_user'];
						$surnameEleve = $rowSelect['nom_user'];
						$emailEleve = $rowSelect['email_user'];
						$active = $rowSelect['active_user'];

						#Remplissage du tableau
						echo '<tr>';
						echo '<td><p>'.$surnameEleve.'</p></td>';
						echo '<td><p>'.$nameEleve.'</p></td>';
						if ($active == 1){
							echo '<td><p><span class="bi-check-square" style="color: #57a800"></span></p></td>';
						}
						else{
							echo '<td><p><span class="bi-x-square" style="color: #dc3546"></span></p></td>';
						}
						
						echo 	'<td>
									<button class="btn btn-default btn-modif-eleve btn-table" data-bs-toggle="modal" data-bs-target="#modalModifyEleve'.$rowSelect['id_user'].'">
										Modifier <span class="bi-pencil"></span>				
									</button>
									<div class="modal fade" id="modalModifyEleve'.$rowSelect['id_user'].'" tabindex="-1" aria-hidden="true">
			  							<div class="modal-dialog">
			    							<div class="modal-content">
			      								<div class="modal-header">
				        							<h4 class="modal-title">Modifier un(e) eleve</h4>
				        							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			      								</div>
			      								<div class="modal-body">
											        <div>
											        	<form name="modify-eleve" method="post" role="form" >
											        		<input type="text" name="newSurname" class="form-control" value="'.$surnameEleve.'" >
											        		<input type="text" name="newName" class="form-control" value="'.$nameEleve.'" >
											        		<input type="text" name="newEmail" class="form-control" value="'.$emailEleve.'" >
											        		<select name="active" class="form-select">';
						if ($active == 1){
							echo '
											        			<option selected>Actif</option>
											        			<option>Désactivé</option>';
						}
						else{
							echo '
																<option selected>Désactivé</option>
											        			<option>Actif</option>';
						}

						echo '								
															</select>
															<input type="hidden" name="idModif" value='.$rowSelect['id_user'].' >
															<button class="btn btn-default btn-modal btn-modif-eleve" type="submit" name="modify-eleve">Modifier</button>
														</form>
											        </div> 
											    </div>
										    </div>
										</div>
									</div>';

						$selectCom = $database-> prepare("SELECT COUNT(*) as compt FROM commande WHERE fk_user_id = ?");
						$selectCom -> execute(array($rowSelect['id_user']));
						$rowSelectCom = $selectCom -> fetch();

						if ($rowSelectCom['compt'] == 0){
							echo '

									<button class="btn btn-default btn-disable-eleve btn-table" data-bs-toggle="modal" data-bs-target="#modalDeleteEleve'.$rowSelect['id_user'].'">
										Supprimer <span class="bi-x-circle"></span>				
									</button>
									<div class="modal fade" id="modalDeleteEleve'.$rowSelect['id_user'].'" tabindex="-1" aria-hidden="true">
			  							<div class="modal-dialog">
			    							<div class="modal-content">
			      								<div class="modal-header">
				        							<h4 class="modal-title">Supprimer un(e) élève</h4>
				        							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			      								</div>
			      								<div class="modal-body">
											        <div>
											        	<form name="delete-eleve" method="post" role="form" > 
											        		Voulez-vous vraiment supprimer "'.$surnameEleve.' '.$nameEleve.'" ?
															<input type="hidden" name="idSup" value='.$rowSelect['id_user'].' >
															<button class="btn btn-default btn-modal btn-delete-eleve" type="submit" name="delete-eleve">Supprimer</button>
														</form>
											        </div> 
											    </div>
										    </div>
										</div>
									</div>
								</td>';
						}
						else{
							echo '

									<button class="btn btn-default btn-disable-eleve btn-table" data-bs-toggle="modal" data-bs-target="#modalDisableEleve'.$rowSelect['id_user'].'">
										Supprimer <span class="bi-x-circle"></span>				
									</button>
									<div class="modal fade" id="modalDisableEleve'.$rowSelect['id_user'].'" tabindex="-1" aria-hidden="true">
			  							<div class="modal-dialog">
			    							<div class="modal-content">
			      								<div class="modal-header">
				        							<h4 class="modal-title">Désactiver un(e) élève</h4>
				        							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			      								</div>
			      								<div class="modal-body">
											        <div>
											        	<form name="delete-sandwich" method="post" role="form" > 
											        		"'.$surnameEleve.$nameEleve.'" a effectué '.$rowSelectCom['compt'].' commande(s), il est impossible de le supprimer. Voulez-vous désactivé cet(te) élève ?
															<input type="hidden" name="idDisable" value='.$rowSelect['id_user'].' >
															<button class="btn btn-default btn-modal btn-disable-eleve" type="submit" name="disable-eleve">Oui</button>
														</form>
											        </div> 
											    </div>
										    </div>
										</div>
									</div>
								</td>';
						}

					}
				?>
			</table>

		</section>
		
	</body>
</html>
