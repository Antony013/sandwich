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

if(isset($_POST["Non valide"]))
{
  $DT >= "9h30";
}

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

  //Titre de la page
  $titre = "Formulaire de réservation individuelle"
?>
<!doctype html>
<html lang="fr">
  <head>
  <title><?php $titre?></title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="Formulaire_de_reservation_individuelle.css" type="text/css">

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
          <a class="btn btn-default" href="#"><span class="bi-cart-fill"></span><p>Commander</p></a>
        </div>
        <div id="log_out">
          <a class="btn btn-default" href="../require/logout/logout.php"><span class="bi-box-arrow-left"></span><p>Déconnexion</p></a>
        </div>
      </div>
    </div>
  
    <!-- La div qui contiendra ton code-->
    <div id="Body" class="col-md-9 col-sm-8 col-7">

    <!--Body-->
    <!--Div Body-->
    <form id ="formulaire_commande" method="POST" action="Commandersuite.php">
      <div id="Sandwich">
        <label for="Sandwich"><h2>Sandwich</h2></label>
        <br>
        <?php echo $SandwichError; ?>
      </div>

      <!--Div Sandwich1-->
      <div id="Sandwich1">
        <img src="Photo/tortilla.png">
        <br>
        <label for="Sandwich1">Sandwich1</label>
        <br>
        <div class="c"></div>

        <!--icone de commande-->
        <!-- <span class="bi-patch-plus"></span> -->
        <input type="radio" name = "Sandwich" value="1">
        <br>
        <?php $Sandwich?>  
      </div>

      <!--Div Sandwich2-->
      <div id="Sandwich2">
        <img src="Photo/tortilla.png">
        <br>
        <label for="Sandwich2">Sandwich2</label>
        <br>
        <div class="c"></div>

          <!--icone de commande-->
        <!-- <span class="bi-patch-plus"></span> -->
        <input type="radio" name = "Sandwich" value="2">
        <br>
        <?php $Sandwich?>
      </div>

      <!--Div Sandwich3-->
      <div id="Sandwich3">
        <img src="Photo/tortilla.png">
        <br>
        <label for="Sandwich3">Sandwich3</label>
        <br>
        <div class="c"></div>
          
        <!--icone de commande-->
        <!-- <span class="bi-patch-plus"></span> -->
        <input type="radio" name = "Sandwich" value="3">
        <br>
        <?php $Sandwich?>
      </div>

      <!--Div Sandwich4-->
      <div id="Sandwich4">
        <img src="Photo/tortilla.png">
        <br>
        <label for="Sandwich4">Sandwich4</label>
        <br>
        <div class="c"></div>
              
        <!--icone de commande-->
        <!-- <span class="bi-patch-plus"></span> -->
        <input type="radio" name = "Sandwich" value="4">
        <br>
        <?php $Sandwich?>
      </div>

      <!--Div Sandwich5-->
      <div id="Sandwich5">
        <img src="Photo/tortilla.png">
        <br>
        <label for="Sandwich5">Sandwich5</label>
        <br>
        <div class="c"></div>
                  
        <!--icone de commande-->
        <!-- <span class="bi-patch-plus"></span> -->
        <input type="radio" name = "Sandwich" value="5">
        <br>
        <?php $Sandwich?>
      </div>

      <!--Récupération de la variable "Boisson"-->
      <div id="Boisson">
        <label for="Boisson"><h2>Boisson</h2></label>
        <br>
        <span class="help-inline"><?php echo $BoissonError; ?></span>
      </div>

      <!--Div Boisson1-->
      <div id="Boisson1">
        <img src="Photo/can_of_cola.png">
        <br>
        <label for="Boisson1">Boisson1</label>
        <br>
        <div class="c"></div>
                  
        <!--icone de commande-->
        <!-- <span class="bi-patch-plus"></span> -->
        <input type="radio" name = "Boisson" value="1">
        <br>
        <?php $Boisson?>
      </div>

      <!--Div Boisson2-->
      <div id="Boisson2">
        <img src="Photo/can_of_cola.png">
        <br>
        <label for="Boisson2">Boisson2</label>
        <br>
        <div class="c"></div>
                    
        <!--icone de commande-->
        <!-- <span class="bi-patch-plus"></span> -->
        <input type="radio" name = "Boisson" value="2">
        <br>
        <?php $Boisson?>
      </div>

      <!--Div Boisson3-->
      <div id="Boisson3">
        <img src="Photo/can_of_cola.png">
        <br>
        <label for="Boisson3">Boisson3</label>
        <br>
        <div class="c"></div>
                    
        <!--icone de commande-->
        <!-- <span class="bi-patch-plus"></span> -->
        <input type="radio" name = "Boisson" value="3">
        <br>
        <?php $Boisson?>
      </div>

      <!--Div Boisson4-->
      <div id="Boisson4">
        <img src="Photo/can_of_cola.png">
        <br>
        <label for="Boisson4">Boisson4</label>
        <br>
        <div class="c"></div>
                          
        <!--icone de commande-->
        <!-- <span class="bi-patch-plus"></span> -->
        <input type="radio" name = "Boisson" value="4">
        <br>
        <?php $Boisson?>
      </div>

      <!--Div Boisson5-->
      <div id="Boisson5">
        <img src="Photo/can_of_cola.png">
        <br>
        <label for="Boisson5">Boisson5</label>
        <br>
        <div class="c"></div>
                          
        <!--icone de commande-->
        <!-- <span class="bi-patch-plus"></span> -->
        <input type="radio" name = "Boisson" value="5">
        <br>
        <?php $Boisson?>
      </div>

      <?php echo $Boisson2Error; ?>

      <!--Div Boisson 2ème 1-->
      <div id="Boisson6">
        <img src="Photo/drink.png">
        <br>
        <label for="Boisson6">Boisson1</label>
        <br>
        <div class="c"></div>
                          
        <!--icone de commande-->
        <!-- <span class="bi-patch-plus"></span> -->
        <input type="radio" name = "Boisson2" value="1">
        <br>
        <?php $Boisson2?>
      </div>

      <!--Div Boisson 2ème 2-->
      <div id="Boisson7">
        <img src="Photo/drink.png">
        <br>
        <label for="Boisson7">Boisson2</label>
        <br>
        <div class="c"></div>
                          
        <!--icone de commande-->
        <!-- <span class="bi-patch-plus"></span> -->
        <input type="radio" name = "Boisson2" value="2">
        <br>
        <?php $Boisson2?>
      </div>

      <!--Div Boisson 2ème 3-->
      <div id="Boisson8">
        <img src="Photo/drink.png">
        <br>
        <label for="Boisson8">Boisson3</label>
        <br>
        <div class="c"></div>

        <!--icone de commande-->
        <!-- <span class="bi-patch-plus"></span> -->
        <input type="radio" name = "Boisson2" value="3">
        <br>
        <?php $Boisson2?>
      </div>

      <!--Div Boisson 2ème 4-->
      <div id="Boisson9">
        <img src="Photo/drink.png">
        <br>
        <label for="Boisson9">Boisson4</label>
        <br>
        <div class="c"></div>
        
        <!--icone de commande-->
        <!-- <span class="bi-patch-plus"></span> -->
        <input type="radio" name = "Boisson2" value="4">
        <br>
        <?php $Boisson2?>
      </div>

      <!--Div Boisson 2ème 5-->
      <div id="Boisson10">
        <img src="Photo/drink.png">
        <br>
        <label for="Boisson10">Boisson5</label>
        <br>
        <div class="c"></div>
        
        <!--icone de commande-->
        <!-- <span class="bi-patch-plus"></span> -->
        <input type="radio" name = "Boisson2" value="5">
        <br>
        <?php $Boisson2?>
      </div>


      <!--Div Dessert-->
      <!--Récupération de la variable "Dessert"-->
      <div id="Dessert">
        <label for="Dessert"><h2> Quel Dessert ?</h2></label>
        <br>
        <br>
        <span class="help-inline"><?php echo $DessertError; ?></span>
      </div>

      <!--Div Dessert1-->
      <div id="Dessert1">
        <img src="Photo/donut.png">
        <br>
        <label for="Dessert1">Dessert1</label>
        <br>
        <div class="c"></div>
        
        <!--icone de commande-->
        <!-- <span class="bi-patch-plus"></span> -->
        <input type="radio" name = "Dessert" value="1">
        <br>
        <?php $Dessert?>
      </div>

      <!--Div Dessert2-->
      <div id="Dessert2">
        <img src="Photo/donut.png">
        <br>
        <label for="Dessert2">Dessert2</label>
        <br>
        <div class="c"></div>
        
        <!--icone de commande-->
        <!-- <span class="bi-patch-plus"></span> -->
        <input type="radio" name = "Dessert" value="2">
        <br>
        <?php $Dessert?>
      </div>

      <!--Div Dessert3-->
      <div id="Dessert3">
        <img src="Photo/donut.png">
        <br>
        <label for="Dessert3">Dessert3</label>
        <br>
        <div class="c"></div>
        
        <!--icone de commande-->
        <!-- <span class="bi-patch-plus"></span> -->
        <input type="radio" name = "Dessert" value="3">
        <br>
        <?php $Dessert?>
      </div>

      <!--Div Dessert4-->
      <div id="Dessert4">
        <img src="Photo/donut.png">
        <br>
        <label for="Dessert4">Dessert4</label>
        <br>
        <div class="c"></div>
        
        <!--icone de commande-->
        <!-- <span class="bi-patch-plus"></span> -->
        <input type="radio" name = "Dessert" value="4">
        <br>
        <?php $Dessert?>
      </div>

      <!--Div Dessert5-->
      <div id="Dessert5">
        <img src="Photo/donut.png">
        <br>
        <label for="Dessert5">Dessert5</label>
        <br>
        <div class="c"></div>
        
        <!--icone de commande-->
        <!-- <span class="bi-patch-plus"></span> -->
        <input type="radio" name = "Dessert" value="5">
        <br>
        <?php $Dessert?>
      </div>

      <!--Div Dessert6-->
      <div id="Dessert6">
        <img src="Photo/cookie_chocolate.png">
        <br>
        <label for="Dessert6">Dessert6</label>
        <br>
        <div class="c"></div>
        
        <!--icone de commande-->
        <!-- <span class="bi-patch-plus"></span> -->
        <input type="radio" name = "Dessert2" value="1">
        <br>
        <?php $Dessert2?>
      </div>

      <!--Div Dessert7-->
      <div id="Dessert7">
        <img src="Photo/cookie_chocolate.png">
        <br>
        <label for="Dessert7">Dessert7</label>
        <br>
        <div class="c"></div>
        
        <!--icone de commande-->
        <!-- <span class="bi-patch-plus"></span> -->
        <input type="radio" name = "Dessert2" value="2">
        <br>
        <?php $Dessert2?>
      </div>

      <!--Div Dessert8-->
      <div id="Dessert8">
        <img src="Photo/cookie_chocolate.png">
        <br>
        <label for="Dessert8">Dessert8</label>
        <br>
        <div class="c"></div>
        
        <!--icone de commande-->
        <!-- <span class="bi-patch-plus"></span> -->
        <input type="radio" name = "Dessert2" value="3">
        <br>
        <?php $Dessert2?>
      </div>

      <!--Div Dessert9-->
      <div id="Dessert9">
        <img src="Photo/cookie_chocolate.png">
        <br>
        <label for="Dessert9">Dessert9</label>
        <br>
        <div class="c"></div>
        
        <!--icone de commande-->
        <!-- <span class="bi-patch-plus"></span> -->
        <input type="radio" name = "Dessert2" value="4">
        <br>
        <?php $Dessert2?>
      </div>

      <!--Div Dessert10-->
      <div id="Dessert10">
        <img src="Photo/cookie_chocolate.png">
        <br>
        <label for="Dessert10">Dessert10</label>
        <br>
        <div class="c"></div>
        
        <!--icone de commande-->
        <!--<span class="bi-patch-plus"></span>-->
        <input type="radio" name = "Dessert2" value="5">
        <br>
        <?php $Dessert2?>
      </div>
      <?php $Dessert2Error?>

      <!--Div Chips-->
      <!--Récupération de la variable "Chips"-->
      <div id="Chips">
        <label for="choix_chips"><h2> Chips</h2></label>
        <br>
        <img src="Photo/opened_chips_package.png">
        <br>
        
        <!--icone de commande-->
        <!-- <span class="bi-patch-plus"></span> -->
        <input type="radio" name = "Chips" value="1">
        <span class="help-inline"><?php echo $ChipsError; ?></span>
        <br>
      </div>

      <!--Div Date-->
      <!--Récupération de la variable "Date/Heure de livréson"-->
      <div id="DT">
        <label for="DT" type="text"name="DT"> Quel Date/Heure ?</label>
        <br>
        <input type="Datetime-local" class="form-control" id="DT" name="DT" placeholder="DT">
        <span class="help-inline"><?php echo $DTError; ?></span>
      </div>
        <br>
        <p>Commander pour le :</p>
        <input type="submit" id="j" name="valide" value="Voir la commande">
      </div>
    </form>
  </div>
</body>
</html>