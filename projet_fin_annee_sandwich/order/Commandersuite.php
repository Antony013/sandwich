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

  $Sandwich = $Boisson = $Boisson2 = $Dessert = $Dessert2 = $Chips = $DT = "";
  $SandwichError = $BoissonError = $Boisson2Error = $DessertError = $Dessert2Error = $ChipsError = $DTError = "";
  $Sandwich =$_POST["Sandwich"];
  $Boisson  =$_POST["Boisson"];
  $Boisson2 =$_POST["Boisson2"];
  $Dessert =$_POST["Dessert"];
  $Dessert2 =$_POST["Dessert2"];
  $Chips =$_POST["Chips"];
  $DT =$_POST["DT"];

if (isset($_POST["valide"]))
{

  // Sandwich Error permet d'afficher un message en cas de non validation 
  $SandwichError = "Merci de selectionner votre Sandwitch";

  // Boisson Error permet d'afficher un message en cas de non validation 
  $BoissonError = "Merci de selectionner votre Boisson";

  // Boisson2 Error permet d'afficher un message en cas de non validation 
  $Boisson2Error = "Merci de selectionner votre 2 ème Boisson";

  // Dessert Error permet d'afficher un message en cas de non validation 
  $DessertError = "Merci de selectionner votre Dessert";

  // Chips Error permet d'afficher un message en cas de non validation 
  $ChipsError = "Merci de selectionner si vous souhaiter avoir des chips";

  // Date Error permet d'afficher un message en cas de non validation 
  $DTError = "Merci de nous donner une date pour avoir votre menu";
}

$titre = "Formulaire de réservation individuelle"
?>
<!doctype html>
<html lang="fr">
  <head>
  <title><?php $titre?></title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="Commandersuite.css" type="text/css">

    <!--MetaName-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" 
    integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
  </head>
<!-- pour diviser la page en 2 -->
<body>
  <div class="row">
  <!--navbar avec les liens à ajouter-->
    <div id="nav" class="col-md-3 col-sm-4 col-5">
      <div class="row">
        <div id="brand" class="col-12">
          <img src="Photo/lycee.png">
        </div>
        <?php
        #récupérer les nom et prénom de l'utilisateur
            $select = $database -> prepare("SELECT nom_user, prenom_user FROM utilisateur WHERE id_user = ?");
            $select -> execute(array($idUser));
            $rowSelect = $select -> fetch();
            $firstNameUser = $rowSelect['prenom_user'];
            $lastNameUser = $rowSelect['nom_user'];
        ?>
        <div class="col-12 name-user">
            <p><?php echo $lastNameUser.' '.$firstNameUser;?></p>
          </div>
        <div class="col-12 nav_choice">
          <a class="btn btn-default" href="../history/history.php"><span class="bi-hourglass-split"></span><p>Historique</p></a>
        </div>
        <div class="col-12 nav_choice">
          <a class="btn btn-default" href="Formulaire_de_reservation_individuelle.php"><span class="bi-cart-fill"></span><p>Commander</p></a>
        </div>
        <div id="log_out">
          <a class="btn btn-default" href="../require/logout/logout.php"><span class="bi-box-arrow-left"></span><p>Déconnexion</p></a>
        </div>
      </div>
    </div>
  
    <!-- La div qui contiendra ton code-->
    <!--Body-->
    <div id="Body" class="col-md-9 col-sm-8 col-7">
        <p>Votre commande en date du j mois annee contient :</p>
      <!--Section Sandwich-->
      <div id ="tortilla">
          <img src="Photo/tortilla.png">
          <p>Nom du sandwich</p>
          
          <!--icone de commande-->
          <span class="bi-trash-fill"></span>
          <br>
      </div>

      <!--Section Boisson-->
      <div id ="drink">
          <img src="Photo/drink.png">
          <p>Nom de la boisson</p>
          
          <!--icone de commande-->
          <span class="bi-trash-fill"></span>
          <br>
      </div>

      <!--Section packet Chips-->
      <div id ="chips">
          <img src="Photo/opened_chips_package.png">
          <p>Chip</p>

          <!--icone de commande-->
          <span class="bi-trash-fill"></span>
          <br>
      </div>

      <!--Section Cookie-->
      <div id ="cookie">
          <img src="Photo/cookie_chocolate.png">
          <p>Dessert</p>

          <!--icone de commande-->
          <span class="bi-trash-fill"></span>
          <br>
      </div>
      <br>
        <input type="submit" id="j" name="valide" value="Commander">
      </div>
    </div>
  </div>
</body>
</html>