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

	if(isset($_POST["insert-sandwich"])){
		#récupération du produit à ajouter puis l'ajouter
		$name = $_POST['newSandwich'];

		$select = $database -> query("SELECT nom_sandwich FROM sandwich");
		$new = True;
		while ($rowSelect = $select -> fetch()){
			if ($name == $rowSelect['nom_sandwich']){
				$new = False;
				$newProductError = "Ce produit existe déjà";
			}
		}

		if ($new){
			$insert = $database -> prepare("INSERT INTO sandwich (nom_sandwich,dispo_sandwich) VALUES (?,?)");
			$insert -> execute(array($name,0));
		}
		else{
			echo '	<script language="Javascript">
						alert ("'.$newProductError.'" )
					</script>';
		}
	}
	else if(isset($_POST["insert-boisson"])){
		#récupération du produit à ajouter puis l'ajouter
		$name = $_POST['newBoisson'];

		$select = $database -> query("SELECT nom_boisson FROM boisson");
		$new = True;
		while ($rowSelect = $select -> fetch()){
			if ($name == $rowSelect['nom_boisson']){
				$new = False;
				$newProductError = "Ce produit existe déjà";
			}
		}

		if ($new){
			$insert = $database -> prepare("INSERT INTO boisson (nom_boisson,dispo_boisson) VALUES (?,?)");
			$insert -> execute(array($name,0));
		}
		else{
			echo '	<script language="Javascript">
						alert ("'.$newProductError.'" )
					</script>';
		}	
	}
	else if(isset($_POST["insert-dessert"])){
		#récupération du produit à ajouter puis l'ajouter
		$name = $_POST['newDessert'];

		$select = $database -> query("SELECT nom_dessert FROM dessert");
		$new = True;
		while ($rowSelect = $select -> fetch()){
			if ($name == $rowSelect['nom_dessert']){
				$new = False;
				$newProductError = "Ce produit existe déjà";
			}
		}

		if ($new){
			$insert = $database -> prepare("INSERT INTO dessert (nom_dessert,dispo_dessert) VALUES (?,?)");
			$insert -> execute(array($name,0));
		}
		else{
			echo '	<script language="Javascript">
						alert ("'.$newProductError.'" )
					</script>';
		}
	}
	else if(isset($_POST["modify-sandwich"])){
		#récupération de l'id du produit à modifier puis modification
		$idModif = $_POST['idModif'];
		$newName = $_POST['newName'];
		$dispo = $_POST['dispo'];

		if ($dispo == "Disponible"){
			$dispo = 1;
		}
		else{
			$dispo = 0;
		}

		$update = $database -> prepare("UPDATE sandwich SET nom_sandwich = ? , dispo_sandwich = ? WHERE id_sandwich=?");
		$update -> execute(array($newName,$dispo,$idModif));
	}
	else if(isset($_POST["modify-boisson"])){
		#récupération de l'id du produit à modifier puis modification
		$idModif = $_POST['idModif'];
		$newName = $_POST['newName'];
		$dispo = $_POST['dispo'];

		if ($dispo == "Disponible"){
			$dispo = 1;
		}
		else{
			$dispo = 0;
		}

		$update = $database -> prepare("UPDATE boisson SET nom_boisson = ? , dispo_boisson = ? WHERE id_boisson=?");
		$update -> execute(array($newName,$dispo,$idModif));
	}
	else if(isset($_POST["modify-dessert"])){
		#récupération de l'id du produit à modifier puis modification
		$idModif = $_POST['idModif'];
		$newName = $_POST['newName'];
		$dispo = $_POST['dispo'];

		if ($dispo == "Disponible"){
			$dispo = 1;
		}
		else{
			$dispo = 0;
		}

		$update = $database -> prepare("UPDATE dessert SET nom_dessert = ? , dispo_dessert = ? WHERE id_dessert=?");
		$update -> execute(array($typeModif,$newName,$dispo,$idModif));
	}
	else if(isset($_POST["delete-sandwich"])){
		#récupération de l'id du produit à supprimer puis suppresion
		$idSup = $_POST['idSup'];
		$delete = $database -> prepare("DELETE FROM sandwich WHERE id_sandwich=?");
		$delete -> execute(array($idSup));
	}
	else if(isset($_POST["delete-boisson"])){
		#récupération de l'id du produit à supprimer puis suppresion
		$idSup = $_POST['idSup'];
		$delete = $database -> prepare("DELETE FROM boisson WHERE id_boisson=?");
		$delete -> execute(array($idSup));
	}
	else if(isset($_POST["delete-dessert"])){
		#récupération de l'id du produit à supprimer puis suppresion
		$idSup = $_POST['idSup'];
		$delete = $database -> prepare("DELETE FROM dessert WHERE id_dessert=?");
		$delete -> execute(array($idSup));
	}
	else if(isset($_POST["disable-sandwich"])){
		#récupération de l'id du produit à supprimer puis suppresion
		$idDisable = $_POST['idDisable'];
		$update = $database -> prepare("UPDATE sandwich SET dispo_sandwich = ? WHERE id_sandwich=?");
		$update -> execute(array(0,$idDisable));
	}
	else if(isset($_POST["disable-boisson"])){
		#récupération de l'id du produit à supprimer puis suppresion
		$idDisable = $_POST['idDisable'];
		$update = $database -> prepare("UPDATE boisson SET dispo_boisson = ? WHERE id_boisson=?");
		$update -> execute(array(0,$idDisable));
	}
	else if(isset($_POST["disable-dessert"])){
		#récupération de l'id du produit à supprimer puis suppresion
		$idDisable = $_POST['idDisable'];
		$update = $database -> prepare("UPDATE dessert SET dispo_dessert = ? WHERE id_dessert=?");
		$update -> execute(array(0,$idDisable));
	}
?>	

		<section id="components-consultation">
			<h2>Produits</h2>
			<div id="hr"></div>
			<!-- création d'un tableau -->
			<h3>Sandwichs   <a href="#" data-bs-toggle="modal" data-bs-target="#modalInsertSandwich">+</a></h3>

			<div class="modal fade" id="modalInsertSandwich" tabindex="-1" aria-hidden="true">
					<div class="modal-dialog">
					<div class="modal-content">
							<div class="modal-header">
							<h4 class="modal-title">Nouveau sandwich</h4>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
							</div>
							<div class="modal-body">
					        <div>
					        	<form name="insert-sandwich" method="post" role="form" >
									<input type="text" name="newSandwich" class="form-control" placeholder="Nom du sandwich">
									<button class="btn btn-default btn-modal btn-modif-product" type="submit" name="insert-sandwich">Ajouter</button>
								</form>
					        </div> 
					    </div>
				    </div>
				</div>
			</div>

			<table class="table table-striped table-bordered">
				<tr>
					<!-- titre des colones -->
					<th>Nom du sandwich</th>
					<th>Disponibilité</th>
					<th>Actions</th>
				</tr>
				<?php 
					#récupération et affichage des données de la table sandwich
					$select = $database -> query("SELECT * from sandwich");

					#compteur de tour de boucle
					$compt = 1;

					while ($rowSelect = $select->fetch()) {
						
						$sandwich = $rowSelect['nom_sandwich'];
						$dispo = $rowSelect['dispo_sandwich'];

						#Remplissage du tableau
						echo '<tr>';
						echo '<td><p>'.$sandwich.'</p></td>';
						if ($dispo == 1){
							echo '<td><p><span class="bi-check-square" style="color: #57a800"></span></p></td>';
						}
						else{
							echo '<td><p><span class="bi-x-square" style="color: #dc3546"></span></p></td>';
						}
						
						echo 	'<td>
									<button class="btn btn-default btn-modif-product btn-table" data-bs-toggle="modal" data-bs-target="#modalModifySandwich'.$rowSelect['id_sandwich'].'">
										Modifier <span class="bi-pencil"></span>				
									</button>
									<div class="modal fade" id="modalModifySandwich'.$rowSelect['id_sandwich'].'" tabindex="-1" aria-hidden="true">
			  							<div class="modal-dialog">
			    							<div class="modal-content">
			      								<div class="modal-header">
				        							<h4 class="modal-title">Modifier un sandwich</h4>
				        							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			      								</div>
			      								<div class="modal-body">
											        <div>
											        	<form name="modify-sandwich" method="post" role="form" > 
											        		<input type="text" name="newName" class="form-control" value="'.$sandwich.'" >
											        		<select name="dispo" class="form-select">';
						if ($dispo == 1){
							echo '
											        			<option selected>Disponible</option>
											        			<option>Indisponible</option>';
						}
						else{
							echo '
																<option selected>Indisponible</option>
											        			<option>Disponible</option>';
						}

						echo '								
															</select>
															<input type="hidden" name="idModif" value='.$rowSelect['id_sandwich'].' >
															<button class="btn btn-default btn-modal btn-modif-product" type="submit" name="modify-sandwich">Modifier</button>
														</form>
											        </div> 
											    </div>
										    </div>
										</div>
									</div>';

						$selectCom = $database-> prepare("SELECT COUNT(*) as compt FROM commande WHERE fk_sandwich_id = ?");
						$selectCom -> execute(array($rowSelect['id_sandwich']));
						$rowSelectCom = $selectCom -> fetch();

						if ($rowSelectCom['compt'] == 0){
							echo '

									<button class="btn btn-default btn-disable-product btn-table" data-bs-toggle="modal" data-bs-target="#modalDeleteSandwich'.$rowSelect['id_sandwich'].'">
										Supprimer <span class="bi-x-circle"></span>				
									</button>
									<div class="modal fade" id="modalDeleteSandwich'.$rowSelect['id_sandwich'].'" tabindex="-1" aria-hidden="true">
			  							<div class="modal-dialog">
			    							<div class="modal-content">
			      								<div class="modal-header">
				        							<h4 class="modal-title">Supprimer un sandwich</h4>
				        							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			      								</div>
			      								<div class="modal-body">
											        <div>
											        	<form name="delete-sandwich" method="post" role="form" > 
											        		Voulez-vous vraiment enlever "'.$sandwich.'" du menu ?
															<input type="hidden" name="idSup" value='.$rowSelect['id_sandwich'].' >
															<button class="btn btn-default btn-modal btn-delete-product" type="submit" name="delete-sandwich">Supprimer</button>
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

									<button class="btn btn-default btn-disable-product btn-table" data-bs-toggle="modal" data-bs-target="#modalDisableSandwich'.$rowSelect['id_sandwich'].'">
										Supprimer <span class="bi-x-circle"></span>				
									</button>
									<div class="modal fade" id="modalDisableSandwich'.$rowSelect['id_sandwich'].'" tabindex="-1" aria-hidden="true">
			  							<div class="modal-dialog">
			    							<div class="modal-content">
			      								<div class="modal-header">
				        							<h4 class="modal-title">Désactiver un sandwich</h4>
				        							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			      								</div>
			      								<div class="modal-body">
											        <div>
											        	<form name="delete-sandwich" method="post" role="form" > 
											        		"'.$sandwich.'" apparait dans au moins une commande, îl est impossible de le supprimer. Voulez-vous le rendre indisponible ?
															<input type="hidden" name="idDisable" value='.$rowSelect['id_sandwich'].' >
															<button class="btn btn-default btn-modal btn-disable-product" type="submit" name="disable-sandwich">Oui</button>
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

			<!-- création d'un tableau -->
			<h3>Boissons   <a href="#" data-bs-toggle="modal" data-bs-target="#modalInsertBoisson">+</a></h3>

			<div class="modal fade" id="modalInsertBoisson" tabindex="-1" aria-hidden="true">
					<div class="modal-dialog">
					<div class="modal-content">
							<div class="modal-header">
							<h4 class="modal-title">Nouvelle boisson</h4>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
							</div>
							<div class="modal-body">
					        <div>
					        	<form name="insert-boisson" method="post" role="form" >
									<input type="text" name="newBoisson" class="form-control" placeholder="Nom de la boisson" >
									<button class="btn btn-default btn-modal btn-modif-product" type="submit" name="insert-boisson">Ajouter</button>
								</form>
					        </div> 
					    </div>
				    </div>
				</div>
			</div>

			<table class="table table-striped table-bordered">
				<tr>
					<!-- titre des colones -->
					<th>Nom de la boisson</th>
					<th>Disponibilité</th>
					<th>Actions</th>
				</tr>
				<?php 
					#récupération et affichage des données de la table sandwich
					$select = $database -> query("SELECT * from boisson");

					#compteur de tour de boucle
					$compt = 1;

					while ($rowSelect = $select->fetch()) {
						
						$boisson = $rowSelect['nom_boisson'];
						$dispo = $rowSelect['dispo_boisson'];

						#Remplissage du tableau
						echo '<tr>';
						echo '<td><p>'.$boisson.'</p></td>';
						if ($dispo == 1){
							echo '<td><p><span class="bi-check-square" style="color: #57a800"></span></p></td>';
						}
						else{
							echo '<td><p><span class="bi-x-square" style="color: #dc3546"></span></p></td>';
						}
						
						echo 	'<td>
									<button class="btn btn-default btn-modif-product btn-table" data-bs-toggle="modal" data-bs-target="#modalModifyboisson'.$rowSelect['id_boisson'].'">
										Modifier <span class="bi-pencil"></span>				
									</button>
									<div class="modal fade" id="modalModifyboisson'.$rowSelect['id_boisson'].'" tabindex="-1" aria-hidden="true">
			  							<div class="modal-dialog">
			    							<div class="modal-content">
			      								<div class="modal-header">
				        							<h4 class="modal-title">Modifier une boisson</h4>
				        							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			      								</div>
			      								<div class="modal-body">
											        <div>
											        	<form name="modify-boisson" method="post" role="form" > 
											        		<input type="text" name="newName" class="form-control" value="'.$boisson.'" >
											        		<select name="dispo" class="form-select">';
						if ($dispo == 1){
							echo '
											        			<option selected>Disponible</option>
											        			<option>Indisponible</option>';
						}
						else{
							echo '
																<option selected>Indisponible</option>
											        			<option>Disponible</option>';
						}

						echo '								
															</select>
															<input type="hidden" name="idModif" value='.$rowSelect['id_boisson'].' >
															<button class="btn btn-default btn-modal btn-modif-product" type="submit" name="modify-boisson">Modifier</button>
														</form>
											        </div> 
											    </div>
										    </div>
										</div>
									</div>';

						$selectCom = $database-> prepare("SELECT COUNT(*) as compt FROM commande WHERE fk_boisson_id = ?");
						$selectCom -> execute(array($rowSelect['id_boisson']));
						$rowSelectCom = $selectCom -> fetch();

						if ($rowSelectCom['compt'] == 0){
							echo '

									<button class="btn btn-default btn-default btn-disable-product btn-table" data-bs-toggle="modal" data-bs-target="#modalDeleteBoisson'.$rowSelect['id_boisson'].'">
										Supprimer <span class="bi-x-circle"></span>				
									</button>
									<div class="modal fade" id="modalDeleteBoisson'.$rowSelect['id_boisson'].'" tabindex="-1" aria-hidden="true">
			  							<div class="modal-dialog">
			    							<div class="modal-content">
			      								<div class="modal-header">
				        							<h4 class="modal-title">Supprimer une boisson</h4>
				        							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			      								</div>
			      								<div class="modal-body">
											        <div>
											        	<form name="delete-boisson" method="post" role="form" > 
											        		Voulez-vous vraiment enlever "'.$boisson.'" du menu ?
															<input type="hidden" name="idSup" value='.$rowSelect['id_boisson'].' >
															<button class="btn btn-default btn-modal btn-delete-product" type="submit" name="delete-boisson">Supprimer</button>
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

									<button class="btn btn-default btn-disable-product btn-table" data-bs-toggle="modal" data-bs-target="#modalDisableboisson'.$rowSelect['id_boisson'].'">
										Supprimer <span class="bi-x-circle"></span>				
									</button>
									<div class="modal fade" id="modalDisableboisson'.$rowSelect['id_boisson'].'" tabindex="-1" aria-hidden="true">
			  							<div class="modal-dialog">
			    							<div class="modal-content">
			      								<div class="modal-header">
				        							<h4 class="modal-title">Désactiver une boisson</h4>
				        							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			      								</div>
			      								<div class="modal-body">
											        <div>
											        	<form name="delete-boisson" method="post" role="form" > 
											        		"'.$boisson.'" apparait dans au moins une commande, îl est impossible de le supprimer. Voulez-vous le rendre indisponible ?
															<input type="hidden" name="idDisable" value='.$rowSelect['id_boisson'].' >
															<button class="btn btn-default btn-modal btn-disable-product" type="submit" name="disable-boisson">Oui</button>
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

			<!-- création d'un tableau -->
			<h3>Desserts   <a href="#" data-bs-toggle="modal" data-bs-target="#modalInsertDessert">+</a></h3>

			<div class="modal fade" id="modalInsertDessert" tabindex="-1" aria-hidden="true">
					<div class="modal-dialog">
					<div class="modal-content">
							<div class="modal-header">
							<h4 class="modal-title">Nouveau dessert</h4>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
							</div>
							<div class="modal-body">
					        <div>
					        	<form name="insert-dessert" method="post" role="form" >
									<input type="text" name="newDessert" class="form-control" placeholder="Nom du dessert" >
									<button class="btn btn-default btn-modal btn-modif-product" type="submit" name="insert-dessert">Ajouter</button>
								</form>
					        </div> 
					    </div>
				    </div>
				</div>
			</div>

			<table class="table table-striped table-bordered">
				<tr>
					<!-- titre des colones -->
					<th>Nom du dessert</th>
					<th>Disponibilité</th>
					<th>Actions</th>
				</tr>
				<?php 
					#récupération et affichage des données de la table sandwich
					$select = $database -> query("SELECT * from dessert");

					#compteur de tour de boucle
					$compt = 1;

					while ($rowSelect = $select->fetch()) {
						
						$dessert = $rowSelect['nom_dessert'];
						$dispo = $rowSelect['dispo_dessert'];

						#Remplissage du tableau
						echo '<tr>';
						echo '<td><p>'.$dessert.'</p></td>';
						if ($dispo == 1){
							echo '<td><p><span class="bi-check-square" style="color: #57a800"></span></p></td>';
						}
						else{
							echo '<td><p><span class="bi-x-square" style="color: #dc3546"></span></p></td>';
						}

						echo 	'<td>
									<button class="btn btn-default btn-modif-product btn-table" data-bs-toggle="modal" data-bs-target="#modalModifydessert'.$rowSelect['id_dessert'].'">
										Modifier <span class="bi-pencil"></span>				
									</button>
									<div class="modal fade" id="modalModifydessert'.$rowSelect['id_dessert'].'" tabindex="-1" aria-hidden="true">
			  							<div class="modal-dialog">
			    							<div class="modal-content">
			      								<div class="modal-header">
				        							<h4 class="modal-title">Modifier un dessert</h4>
				        							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			      								</div>
			      								<div class="modal-body">
											        <div>
											        	<form name="modify-dessert" method="post" role="form" > 
											        		<input type="text" name="newName" class="form-control" value="'.$dessert.'" >
											        		<select name="dispo" class="form-select">';
						if ($dispo == 1){
							echo '
											        			<option selected>Disponible</option>
											        			<option>Indisponible</option>';
						}
						else{
							echo '
																<option selected>Indisponible</option>
											        			<option>Disponible</option>';
						}

						echo '								
															</select>
															<input type="hidden" name="idModif" value='.$rowSelect['id_dessert'].' >
															<button class="btn btn-default btn-modal btn-modif-product" type="submit" name="modify-dessert">Modifier</button>
														</form>
											        </div> 
											    </div>
										    </div>
										</div>
									</div>';

						$selectCom = $database-> prepare("SELECT COUNT(*) as compt FROM commande WHERE fk_dessert_id = ?");
						$selectCom -> execute(array($rowSelect['id_dessert']));
						$rowSelectCom = $selectCom -> fetch();

						if ($rowSelectCom['compt'] == 0){
							echo '

									<button class="btn btn-default btn-disable-product btn-table" data-bs-toggle="modal" data-bs-target="#modalDeleteDessert'.$rowSelect['id_boisson'].'">
										Supprimer <span class="bi-x-circle"></span>				
									</button>
									<div class="modal fade" id="modalDeleteDessert'.$rowSelect['id_dessert'].'" tabindex="-1" aria-hidden="true">
			  							<div class="modal-dialog">
			    							<div class="modal-content">
			      								<div class="modal-header">
				        							<h4 class="modal-title">Supprimer une dessert</h4>
				        							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			      								</div>
			      								<div class="modal-body">
											        <div>
											        	<form name="delete-dessert" method="post" role="form" > 
											        		Voulez-vous vraiment enlever "'.$dessert.'" du menu ?
															<input type="hidden" name="idSup" value='.$rowSelect['id_dessert'].' >
															<button class="btn btn-default btn-modal btn-delete-product" type="submit" name="delete-dessert">Supprimer</button>
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

									<button class="btn btn-default btn-disable-product btn-table" data-bs-toggle="modal" data-bs-target="#modalDisabledessert'.$rowSelect['id_dessert'].'">
										Supprimer <span class="bi-x-circle"></span>				
									</button>
									<div class="modal fade" id="modalDisabledessert'.$rowSelect['id_dessert'].'" tabindex="-1" aria-hidden="true">
			  							<div class="modal-dialog">
			    							<div class="modal-content">
			      								<div class="modal-header">
				        							<h4 class="modal-title">Désactiver un dessert</h4>
				        							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			      								</div>
			      								<div class="modal-body">
											        <div>
											        	<form name="delete-dessert" method="post" role="form" > 
											        		"'.$dessert.'" apparait dans au moins une commande, îl est impossible de le supprimer. Voulez-vous le rendre indisponible ?
															<input type="hidden" name="idDisable" value='.$rowSelect['id_dessert'].' >
															<button class="btn btn-default btn-modal btn-disable-product" type="submit" name="disable-dessert">Oui</button>
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