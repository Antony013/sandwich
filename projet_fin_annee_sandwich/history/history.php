<?php
	// Récupération des données de la session
	session_start();

	// Vérifie si l'utilisateur est connecté, sinon redirection vers la page de connexion
	if(!isset($_SESSION["email_user"])){
		header("Location: ../require/login/login.php");
		exit(); 
	}

	#demande de l'acces à la BDD
	require "../Authentification_PHP/connexion.php";
	#Connexion à la BDD et la mettre dans une variable
	$database = connexionBdd();

	#récupérer l'id de l'utilisateur concerné
	$select = $database -> prepare("SELECT id_user FROM utilisateur WHERE email_user=?");
	$select -> execute(array($_SESSION['email_user']));
	$rowSelect = $select -> fetch();
	$idUser = $rowSelect['id_user'];

	#définir le décalage horaire par défaut de toutes les fonctions date sur celui fr
	date_default_timezone_set('Europe/Paris');

	#variable qui stockera l'erreur de saisie de la nouvelle date de livraison s'il y a
	$newDateError = "";

	#variable qui stockera l'erreur de saisie du nouveau filtre s'il y a
	$newFilterError = "";

	#mettre l'etat du filtre a faux
	$statusFilterMin = $statusFilterMax = False;

	#si bouton filtre cliquer
	if (isset($_POST["submit_filter"])){
		#regarder s'il y a une commande enregistrée pour cet utilisateur
		$select = $database -> prepare("SELECT COUNT(*) as compt FROM commande WHERE fk_user_id=?");
		$select -> execute(array($idUser));
		$rowSelect = $select -> fetch();

		if ($rowSelect['compt'] != 0){

			#regarder s'il y a un filtre enregistré pour cet utilisateur
			$select = $database -> prepare("SELECT COUNT(*) as compt FROM historique WHERE fk_user_id=?");
			$select -> execute(array($idUser));
			$rowSelect = $select -> fetch();

			#variable qui gère si on insert un filtre s'il n'y en a pas et sinon le update
			$filterInsert = False;

			if ($rowSelect['compt'] == 0){
				$filterInsert = True;
			}

			#récupérer le nouveau filtre
			$newDateFilterMin = $_POST['dateMin'];
			$newDateFilterMax = $_POST['dateMax'];

			if (empty($newDateFilterMin)){
				$select = $database -> prepare("SELECT date_heure_livraison_com FROM commande WHERE fk_user_id = ? ORDER BY date_heure_livraison_com ASC");
				$select -> execute(array($idUser));
				$rowSelect = $select -> fetch();
				$newDateFilterMin = $rowSelect['date_heure_livraison_com'];
			}
			#changer le status du filtre si le champ n'était pas vide
			else{
				$statusFilterMin = True;
			}
			if (empty($newDateFilterMax)){
				$select = $database -> prepare("SELECT date_heure_livraison_com FROM commande WHERE fk_user_id = ? ORDER BY date_heure_livraison_com DESC");
				$select -> execute(array($idUser));
				$rowSelect = $select -> fetch();
				$newDateFilterMax = $rowSelect['date_heure_livraison_com'];
			}
			#changer le status du filtre si le champ n'était pas vide
			else{
				$statusFilterMax = True;
			}

			if ( ( ($statusFilterMin == False) and ($statusFilterMax == True) ) or ( ($statusFilterMax == False) and ($statusFilterMin == True) ) or ($newDateFilterMax >= $newDateFilterMin) ){

				if ($filterInsert){
					$insert = $database -> prepare("INSERT INTO historique (dateDebut_hist,dateFin_hist,fk_user_id) VALUES (?,?,?)");
					$insert -> execute(array($newDateFilterMin,$newDateFilterMax,$idUser));
				}
				else{
					$update = $database -> prepare("UPDATE historique set dateDebut_hist=?, dateFin_hist=? WHERE fk_user_id=?");
					$update -> execute(array($newDateFilterMin,$newDateFilterMax,$idUser));
				}
			}
			else{
				$newFilterError = "Filtre invalide";
			}
		}
	}

	#si bouton trie cliquer
	if (isset($_GET['trie'])){
		#récupérer le trie à effectuer et celui à faire au prochain clic
		$trie = $_GET['trie'];
		if ($trie == "ASC"){
			$trieMessage = "Trier de la plus récente à la plus ancienne";
			$nextTrie = "DESC";
		}
		else{
			$trieMessage = "Trier de la plus ancienne à la plus récente";
			$nextTrie = "ASC";
		}
	}
	#sinon mettre le trie actuel à DESC et ASC au prochain clic
	else{
		$trie = "DESC";
		$nextTrie = "ASC";
		$trieMessage = "Trier de la plus ancienne à la plus récente";
	}

	#Si la suppression est confirmé alors
	if (isset($_POST["submit-sup"])){
		#Récupérer l'id de la commande à annuler
		$idSup = $_POST['idsup'];
		#déclarer la commande annuler dans la table
		$update = $database -> prepare("UPDATE commande SET annule_com = 1 WHERE id_com = ?;");
		$update -> execute(array($idSup));
	}

	if (isset($_POST["submit-modif"])){
		#Récupérer l'id et la nouvelle date de la commande à modifier
		$idModif = $_POST['idmodif'];
		$newDate = $_POST['dateModif'];

		#récupérer la date et l'heure actuelle
		$dateTimeNow = date_create(date('y-m-d G:i:s'));
		#transformer la saisie en un objet 'date'
		$newDateCheck = date_create($newDate);
		#recupérer le jour de Pâque de l'année séléctionnée
		$easter = date_create(date('y-m-d', easter_date(date_format($newDateCheck, 'Y'))));	

		#si l'année saisie est plus petite ou égale à celle actuelle
		if (date_format($newDateCheck, 'Y') <= date_format($dateTimeNow, 'Y')){
			#si l'année saisie est égale à celle actuelle
			if (date_format($newDateCheck, 'Y') == date_format($dateTimeNow, 'Y')){
				#si le mois saisie est plus petit ou égal à celui actuel
				if (date_format($newDateCheck, 'n') <= date_format($dateTimeNow, 'n')){
					#si le mois saisie est égal à celui actuel
					if (date_format($newDateCheck, 'n') == date_format($dateTimeNow, 'n')){
						#si le jour saisie est plus petit ou égal à celui actuel
						if (date_format($newDateCheck, 'j') <= date_format($dateTimeNow, 'j')){
							#si le jour saisie est égal à celui actuel
							if (date_format($newDateCheck, 'j') == date_format($dateTimeNow, 'j')){
								#si l'heure indiquée est à moins de 60 minutes après celle actuelle ou antérieur à celle-ci OU qu'il est actuellement 9h30 passé
								if ( ( (intval(date_format($newDateCheck, 'G')) * 60 + intval(date_format($newDateCheck, 'i')) - 60) < (intval(date_format($dateTimeNow, 'G')) * 60 + intval(date_format($dateTimeNow, 'i')) ) ) || ( (intval(date_format($dateTimeNow, 'G')) * 60 + intval(date_format($dateTimeNow, 'i')) ) > (9 * 60 + 30) ) ){
									#alors erreur dans l'heure saisie
									$newDateError = "Une commande doit être passée au moins 1h à l'avance et avant 9h30 pour le jour même";
								}
							}
							#sinon erreur dans le jour saisie
							else{
								$newDateError = "Une commande ne peut être passée pour un jour antérieur";
							}
						}
					}
					#sinon erreur dans le mois saisie
					else{
						$newDateError = "Une commande ne peut être passée pour un mois antérieur";
					}
				}
			}
			#sinon erreur dans l'année saisie
			else{
				$newDateError = "Une commande ne peut être passée pour une année antérieure";
			}

		}

		#si le jour saisie est postérieur à celui actuel (d'une année postérieure à celle séléctionnée) mais qu'il correspond à un samedi OU à un dimanche
		if (date_format($newDateCheck, 'w') == 0 || date_format($newDateCheck, 'w') == 6){
			$newDateError = "Une commande ne peut être passée pour un samedi ou un dimanche";
		}
		#si le jour saisie est postérieur à celui actuel mais qu'il correspond à un jour férié
		else if ( ( (date_format($newDateCheck, 'j') == 1) and (date_format($newDateCheck, 'n') == 1) ) or ( (date_format($newDateCheck, 'j') == 1) and (date_format($newDateCheck, 'n') == 5) ) or ( (date_format($newDateCheck, 'j') == 8) and (date_format($newDateCheck, 'n') == 5) ) or ( (date_format($newDateCheck, 'j') == 14) and (date_format($newDateCheck, 'n') == 7) ) or ( (date_format($newDateCheck, 'j') == 15) and (date_format($newDateCheck, 'n') == 8) ) or ( (date_format($newDateCheck, 'j') == 1) and (date_format($newDateCheck, 'n') == 11) ) or ( (date_format($newDateCheck, 'j') == 11) and (date_format($newDateCheck, 'n') == 11) ) or ( (date_format($newDateCheck, 'j') == 25) and (date_format($newDateCheck, 'n') == 12) ) or ( (date_format($newDateCheck, 'j') == date_format(date_add($easter, date_interval_create_from_date_string('1 day')), 'j')) and (date_format($newDateCheck, 'n') == (date_format($easter, 'n'))) ) or ( (date_format($newDateCheck, 'j') == date_format(date_add($easter, date_interval_create_from_date_string('38 day')), 'j')) and (date_format($newDateCheck, 'n') == (date_format($easter, 'n'))) ) or ( (date_format($newDateCheck, 'j') == date_format(date_add($easter, date_interval_create_from_date_string('11 day')), 'j')) and (date_format($newDateCheck, 'n') == (date_format($easter, 'n'))) ) ){
			$newDateError = "Une commande ne peut être passée pour un jour férié";
		}
		#si l'heure de livraison ne se situe pas entre 11H et 13h (ouverture de la cantine)
		else if ( (intval(date_format($newDateCheck, 'G')) > 13) or (intval(date_format($newDateCheck, 'G')) < 11) ){
			$newDateError = "Vous ne pouvez commander seulement sur le crénau 11h - 13h";
		}

		#si il n'y a pas eu d'erreur, alors modifier la date de la commande dans la table
		if (empty($newDateError)){
			$update = $database -> prepare("UPDATE commande SET date_heure_livraison_com = ? WHERE id_com = ?;");
			$update -> execute(array($newDate,$idModif));
		}
		#sinon afficher l'erreur dans un pop-up
		else{
			echo '	<script language="Javascript">
						alert ("'.$newDateError.'" )
					</script>';
		}
	}

	#récupérer les nom et prénom de l'utilisateur
	$select = $database -> prepare("SELECT nom_user, prenom_user FROM utilisateur WHERE id_user = ?");
	$select -> execute(array($idUser));
	$rowSelect = $select -> fetch();
	$firstNameUser = $rowSelect['prenom_user'];
	$lastNameUser = $rowSelect['nom_user'];
?>


<!DOCTYPE html>

<html>	

	<head>
		<!-- Pouvoir utiliser les caractères spéciaux de la langue française -->
		<meta charset="utf-8">	
		<!-- Initialiser la taille de l'écran par défaut pour pouvoir faire du responsive -->
		<meta name="viewport" content="width=device-width, initial-scale=1">	

		<!-- lien pour relier la version 5 de Bootstrap et les bibliothèques nécéssaires à son fonctionnement; de même pour jQuery-->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">

		<!-- lien pour relier le css -->
		<link rel="stylesheet" href="history.css">

		<title>Historique des Commandes</title>		

	</head>

	<body>
		<div class="row">

			<div id="nav" class="col-md-3 col-sm-4 col-5">
				<div class="row">
					<div id="brand" class="col-12">
						<img src="/img/lycee.png">
					</div>
					<div class="col-12 name-user">
						<p><?php echo $lastNameUser.' '.$firstNameUser;?></p>
					</div>
					<div class="col-12 nav-choice">
						<a class="btn btn-default" href="#"><span class="bi-hourglass-split"></span><p>Historique</p></a>
					</div>
					<div class="col-12 nav-choice">
						<a class="btn btn-default" href="../order"><span class="bi-cart-fill"></span><p>Commander</p></a>
					</div>
					<div id="log_out">
						<a class="btn btn-default" href="../require/logout/logout.php"><span class="bi-box-arrow-left"></span><p>Déconnexion</p></a>
					</div>
				</div>
			</div>
			
			<div id="page" class="col-md-9 col-sm-8 col-7">
				<div class="row">
					
					<div class="col-12">

						<?php 

							$selectHist = $database -> prepare("SELECT * FROM historique WHERE fk_user_id = ?");
							$selectHist -> execute(array($idUser));
							$rowSelectHist = $selectHist -> fetch();

							#s'il n'y a pas d'historique enregistré
							$histEmpty = True;

							if (isset($rowSelectHist['dateDebut_hist']) and isset($rowSelectHist['dateFin_hist'])){
								$histEmpty = False;

								$dateFilterMin = date_create($rowSelectHist['dateDebut_hist']);
								$dateFilterMax = date_create($rowSelectHist['dateFin_hist']);

								#augmenter d'un jour le filtre max pour qu'il soit pris en compte (à cause des heures qui dépassent)
								date_add($dateFilterMax, date_interval_create_from_date_string('1 day'));
							}

						?>

						<form id="filter" method="POST" action="" role=form>
							<p>Filtrer de : </p>
							<input type="date" name="dateMin" class="form-control" value="<?php echo $rowSelectHist['dateDebut_hist'] ?>">
							<p id="filterA">à :</p>
							<input type="date" name="dateMax" class="form-control" value="<?php echo $rowSelectHist['dateFin_hist'] ?>">
							<h4 class="help-inline"><?php echo $newFilterError ?></h4>

							<input id="submit_filter" type="submit" name="submit_filter" value="Appliquer le filtre">
							<a id="filter_order" href="history.php?trie=<?php echo $nextTrie ?>" class="btn btn-default">
								<p><?php echo $trieMessage ?></p><span class="bi-sort-numeric-down-alt"></span>
							</a>
						</form>

					</div>

					<?php

						#récupérer les informations des commandes de l'utilisateur trié
						if ($trie == "ASC"){
							$select = $database -> prepare("SELECT * FROM commande WHERE fk_user_id = ? ORDER BY date_heure_livraison_com ASC");
						}
						else{
							$select = $database -> prepare("SELECT * FROM commande WHERE fk_user_id = ? ORDER BY date_heure_livraison_com DESC");
						}
						$select -> execute(array($idUser));

						#si il n'y a pas de commande enregistrée
						$printCom = False;

						#si il n'y a pas de commande dans le filtre
						$printComFiltred = False;

						#récupérer les données de toutes les commandes de la table une à une
						while ($rowSelect = $select -> fetch()){

							$printCom = True;

							$numCommande = $rowSelect['id_com'];

							#récupérer le nom du sandwich correspondant à la clé étrangère dans la table commande
							$selectSandwich = $database -> query("SELECT nom_sandwich FROM sandwich WHERE id_sandwich = ".$rowSelect['fk_sandwich_id'].";");
							$rowSelectSandwich = $selectSandwich -> fetch();
							$sandwich = $rowSelectSandwich['nom_sandwich'];

							#récupérer le nom de la boisson correspondant à la clé étrangère dans la table commande
							$selectdrink = $database -> query("SELECT nom_boisson FROM boisson WHERE id_boisson = ".$rowSelect['fk_boisson_id'].";");
							$rowSelectdrink = $selectdrink -> fetch();
							$drink = $rowSelectdrink['nom_boisson'];

							#récupérer le nom du dessert correspondant à la clé étrangère dans la table commande
							$selectDessert = $database -> query("SELECT nom_dessert FROM dessert WHERE id_dessert = ".$rowSelect['fk_dessert_id'].";");
							$rowSelectDessert = $selectDessert -> fetch();
							$dessert = $rowSelectDessert['nom_dessert'];

							#récupérer le booléen designant le choix de chips ou non
							$chips = $rowSelect['chips_com'];
							if ($chips == 1){
								$chips = "Avec";
							}
							else{
								$chips = "Sans";
							}

							#transformer la date de livraison en un objet 'date'
							$deliveryDate = date_create($rowSelect['date_heure_livraison_com']);

							#conversion du jour
							$day = date_format($deliveryDate, 'w');
							switch ($day) {
							    case 0:
							        $day = "dimanche";
							        break;
							    case 1:
							        $day = "lundi";
							        break;
							    case 2:
							        $day = "mardi";
							        break;
							    case 3:
							        $day = "mecredi";
							        break;
							    case 4:
							        $day = "jeudi";
							        break;
							    case 5:
							        $day = "vendredi";
							        break;
							    case 6:
							        $day = "samedi";
							        break;
							}
														
							$numDay = date_format($deliveryDate, 'j');

							#conversion du mois
							$month = date_format($deliveryDate, 'n');
							switch ($month) {
							    case 1:
							        $month = "janvier";
							        break;
							    case 2:
							        $month = "février";
							        break;
							    case 3:
							        $month = "mars";
							        break;
							    case 4:
							        $month = "avril";
							        break;
							    case 5:
							        $month = "mai";
							        break;
							    case 6:
							        $month = "juin";
							        break;
							    case 7:
							        $month = "juillet";
							        break;
							    case 8:
							        $month = "août";
							        break;
							    case 9:
							        $month = "septembre";
							        break;
							    case 10:
							        $month = "octobre";
							        break;
							    case 11:
							        $month = "novembre";
							        break;
							    case 12:
							        $month = "décembre";
							        break;
							}
							
							$year = date_format($deliveryDate, 'Y');
							$hour = date_format($deliveryDate, 'G');
							$minute = date_format($deliveryDate, 'i');

							if ( ($histEmpty == True) or ( ($deliveryDate >= $dateFilterMin) and ($deliveryDate <= $dateFilterMax) ) ){

								#il y a au moins 1 commande dans le filtre
								$printComFiltred = True;

								#afficher la commande détaillées
								echo '	<div class="col-lg-4 col-sm-6 col-12 order">
											<div class="row">
												<p class="num_order">Commande n°'.$numCommande.'</p>
												<p class="date_order">Du '.$day.' '.$numDay.' '.$month.' '.$year.' à '.$hour.'h'.$minute.'</p>
												<div class="circle_img">
													<img src="/img/tortilla.png">
												</div>
												<div class="order_content">
													<p>'.$sandwich.'</p>
													<p>'.$drink.'</p>
													<p>'.$chips.' chips</p>
													<p>'.$dessert.'</p>
												</div>';

								#récupérer la date/heure actuelle
								$dateTimeNow = date_create(date('y-m-d G:i:s'));

								#actions possible sur une commande
								$dateOk = '		<div class="actions">
													
													<a href="" class="modif_order" data-bs-toggle="modal" data-bs-target="#modify-modal'.$rowSelect['id_com'].'">Modifier</a>

													<div class="modal fade" id="modify-modal'.$rowSelect['id_com'].'" tabindex="-1" aria-hidden="true">
							  							<div class="modal-dialog">
							    							<div class="modal-content">
							      								<div class="modal-header">
									        						<h2 class="modal-title heading_actions_modal">Commande n°'.$rowSelect['id_com'].'</h2>
									        						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
							      								</div>
							      								<div class="modal-body">
															        <div>
															        	<p>Modifier la date de la commande</p>
															        	<form method="POST" action="" role="form">
															        		<input type="hidden" name="idmodif" value="'.$rowSelect['id_com'].'">
															        		<input type="datetime-local"  name="dateModif" class="form-control input_date_modif">
															        		<input class="buttonMofif" type="submit" name="submit-modif" value="Modifier">
															        	</form>
															        </div> 
															    </div>
														    </div>
														</div>
													</div>
													
													<a href="" class="delete_order" data-bs-toggle="modal" data-bs-target="#delete-modal'.$rowSelect['id_com'].'">Annuler</a>

											    	<div class="modal fade" id="delete-modal'.$rowSelect['id_com'].'" tabindex="-1" aria-hidden="true">
							  							<div class="modal-dialog">
							    							<div class="modal-content">
							      								<div class="modal-header">
									        						<h2 class="modal-title heading_actions_modal">Commande n°'.$rowSelect['id_com'].'</h2>
									        						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
							      								</div>
							      								<div class="modal-body">
															        <div>
															        	<p>Voulez-vous vraiment annuler cette commande ?</p>
															        	<input class="supChoice" type="button" data-bs-dismiss="modal" value="Non">
															        	<form method="POST" action="" role="form">
															        		<input type="hidden" name="idsup" value="'.$rowSelect['id_com'].'">
															        		<input id="supButton" class="supChoice" type="submit" name="submit-sup" value="Oui">
															        	</form>
															        </div> 
															    </div>
														    </div>
														</div>
													</div>
												</div>
											</div>
										</div>';

								#affichage par défaut : Commande expirée
								$print = '		<div class="actions">
													<p><i>Commande expirée</i></p>
												</div>
											</div>
										</div>';

							    $comPrep = '	<div class="actions">
													<p><i>En préparation ...</i></p>
												</div>
											</div>
										</div>';

								$comCancel = '	<div class="actions">
													<p><i>Commande annulée</i></p>
												</div>
											</div>
										</div>';

								#booléen indiquant si l'affichage des actions sur la commande a été fait
								$display = False;

								if ($rowSelect['annule_com'] == 1){
									echo $comCancel;
									$display = True;
								}
								#si la date de la commande est expirée ou que celle-ci est à moins d'une heure, alors laisser l'affichage par défaut
								#sinon afficher les actions possibles sur la commande
								else if ($year >= date_format($dateTimeNow, 'Y')){

									if ($year == date_format($dateTimeNow, 'Y')){
										if (date_format($deliveryDate, 'n') >= date_format($dateTimeNow, 'n')) {

											if (date_format($deliveryDate, 'n') == date_format($dateTimeNow, 'n')) {
												if ($numDay >= date_format($dateTimeNow, 'j')) {
													
													if ($numDay == date_format($dateTimeNow, 'j')){
														if ( (intval($hour) * 60 + intval($minute) - 60) >= (intval(date_format($dateTimeNow, 'G')) * 60 + intval(date_format($dateTimeNow, 'i')) ) ) {

															$print = $dateOk;
															echo $print;
															$display = True;
														}
														else if ( (intval($hour) * 60 + intval($minute) ) > (intval(date_format($dateTimeNow, 'G')) * 60 + intval(date_format($dateTimeNow, 'i')) ) ) {

															$print = $comPrep;
															echo $print;
															$display = True;
														}
													}
													else{
														$print = $dateOk;
														echo $print;
														$display = True;
													}
												}
											}
											else{
												$print = $dateOk;
												echo $print;
												$display = True;
											}
										}
									}
									else{
										$print = $dateOk;
										echo $print;
										$display = True;
									}
								}

								if ($display == False){
									echo $print;
								}

							}
						}

						if ($printCom == False){
							echo "	<div class='col-12 col-md-6 orderNone'>
										<p>Vous n'avez pas encore passé de commande, voulez-vous y remédier !?</p>
										<p>Ne manquer pas nos sandwichs incontournables, <a href='../order'>commander</a> !</p>
										<img src='/img/empty.png'>
									</div>";
						}
						else if ($printComFiltred == False){
							#rétablir le jour initial du filtre max
							date_add($dateFilterMax, date_interval_create_from_date_string('-1 day'));

							#si un des filtre n'est pas remplie, alors modifier le message afficher
							if (($statusFilterMin == False) and ($statusFilterMax == False) ){
								echo '	<div class="col-12 col-md-6 orderNone">
											<p>Veuillez renseigner un filtre, ou cliquer sur "Appliquer le filtre" pour afficher toutes les commandes</p>
											<img src="/img/empty.png">
										</div>';
							}
							else if ($statusFilterMin == False){
								echo "	<div class='col-12 col-md-6 orderNone'>
											<p>Vous n'avez pas passé de commande avant le ".date_format($dateFilterMin, 'j')."/".date_format($dateFilterMin, 'n')."/".date_format($dateFilterMin, 'Y')."</p>
											<img src='/img/empty.png'>
										</div>";
							}
							else if ($statusFilterMax == False){
								echo "	<div class='col-12 col-md-6 orderNone'>
											<p>Vous n'avez pas passé de commande après le ".date_format($dateFilterMax, 'j')."/".date_format($dateFilterMax, 'n')."/".date_format($dateFilterMax, 'Y')."</p>
											<img src='/img/empty.png'>
										</div>";
							}
							else{
								echo "	<div class='col-12 col-md-6 orderNone'>
											<p>Vous n'avez pas passé de commande entre le ".date_format($dateFilterMin, 'j')."/".date_format($dateFilterMin, 'n')."/".date_format($dateFilterMin, 'Y')." et le ".date_format($dateFilterMax, 'j')."/".date_format($dateFilterMax, 'n')."/".date_format($dateFilterMax, 'Y')."</p>
											<img src='/img/empty.png'>
										</div>";
							}
						}
					?>
				
				</div>
			</div>
		</div>
	</body>
</html>
