<!DOCTYPE html>
<html>
<head>
	
	<!-- jquery -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<!-- script -->
	<script src="script.js"></script>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="/index.css">
	<!-- Lien pour utiliser la icon (glyphicon mais en bootstrap 5) -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
	 <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" >
	<!-- Option : Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" ></script>
	<meta name="viewport" content="width=device-width", initial-scale="1">
	<title></title>
</head>
<body>
	
<nav id="backoffice-nav">
	<div id="conteneur-nav">
		<div id="titre-nav">
			<a href="/index.php">
				<img src="/img/logo.png" alt="logo du lycée">
			</a>
			<p>
				Lycée Saint-Vincent
				<br>
				ENSEIGNEMENT SECONDAIRE & SUPÉRIEUR
			</p>
		</div>
		<div id="login-nav">
			<p>
				<a href="/require/logout/logout.php">Se déconnecter
					<span class="bi bi-box-arrow-in-right"></span>
				</a>
			</p>
		</div>
		<div id="menu-nav">
			<a href="backoffice.php">Accueil</a>
			<a href="boProduits.php">Produits</a>
			<a href="boEleves.php">Elèves</a>
		</div>
	</div>
</nav>
