<?php
include('../includes/config.php');
?>

<!Doctype HTML>
<html lang="fr">
<head>
    <meta charset="UTF-8"/>
    <title>Perfect Concierge - Profile</title>
    <meta name="viewport"
          content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet"
          href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
          integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk"
          crossorigin="anonymous">
</head>
<body>
<?php
if(!$connected){
    header('Location:inscription.php');
}
include('../includes/header.php');
?>

<style>
    a{
        text-decoration: none;
        color: black;
    }
    a:hover{
        text-decoration: none;
        color: black;
    }
</style>

<div class="container">
    <div class="row">
        <div class="col-sm">

            <div class="text-center" style="padding: 2em;">
                <h1>Vos informations</h1>
            </div>

            <?php
            $req = $database->find('SELECT * FROM user where email=?', [$_SESSION['user']]);
            ?>

            <form class="form-signin"
                  action="check/update.php"
                  method="post"
                  enctype="multipart/form-data">

                <div class="form-group row">
                    <label for="inputLastName"
                           class="col-sm-2 col-form-label">
                        Nom
                    </label>
                    <div class="col-sm-10">
                        <input type="text"
                               class="form-control"
                               name="inputLastName"
                               id="inputLastName"
                               value="<?php echo $req['last_name'];?>"
                               required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputFirstName"
                           class="col-sm-2 col-form-label">
                        Prénom
                    </label>
                    <div class="col-sm-10">
                        <input type="text"
                               class="form-control"
                               id="inputFirstName"
                               name="inputFirstName"
                               value="<?php echo $req['first_name'];?>"
                               required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputEmail"
                           class="col-sm-2 col-form-label">
                        Adresse email
                    </label>
                    <div class="col-sm-10">
                        <input type="email"
                               class="form-control"
                               id="inputEmail"
                               name="inputEmail"
                               value="<?php echo $req['email'];?>"
                               required
                               readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPhone"
                           class="col-sm-2 col-form-label">
                        Numéro de téléphone
                    </label>
                    <div class="col-sm-10">
                        <input type="tel"
                               class="form-control"
                               id="inputPhone"
                               name="inputPhone"
                               value="<?php echo $req['phone'];?>"
                               required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputAddress"
                           class="col-sm-2 col-form-label">
                        Adresse
                    </label>
                    <div class="col-sm-10">
                        <input type="text"
                               class="form-control"
                               id="inputAddress"
                               name="inputAddress"
                               value="<?php echo $req['address'];?>"
                               required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputCity"
                           class="col-sm-2 col-form-label">
                        Ville
                    </label>
                    <div class="col-sm-10">
                        <input type="text"
                               class="form-control"
                               id="inputCity"
                               name="inputCity"
                               value="<?php echo $req['city'];?>"
                               required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputZip"
                           class="col-sm-2 col-form-label">
                        Code postal
                    </label>
                    <div class="col-sm-10">
                        <input type="text"
                               class="form-control"
                               id="inputZip"
                               name="inputZip"
                               value="<?php echo $req['zip'];?>"
                               required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPassword"
                           class="col-sm-2 col-form-label">
                        Mot de passe
                    </label>
                    <div class="col-sm-10">
                        <input type="password"
                               class="form-control"
                               id="inputPassword"
                               name="inputPassword"
                               required>
                    </div>
                </div>

                <div class="text-center" style="padding: 1em">Changer le mot de passe</div>

                <div class="form-group row">
                    <label for="inputNewPassword"
                           class="col-sm-2 col-form-label">
                        Nouveau mot de passe
                    </label>
                    <div class="col-sm-10">
                        <input type="password"
                               class="form-control"
                               id="inputNewPassword"
                               name="inputNewPassword">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputReNewPassword"
                           class="col-sm-2 col-form-label">
                        Confirmer le nouveau mot de passe
                    </label>
                    <div class="col-sm-10">
                        <input type="password"
                               class="form-control"
                               id="inputReNewPassword"
                               name="inputReNewPassword">
                    </div>
                </div>

                <br>
                <p class="error text-center">
                    <?php
                    if(isset($_GET['error'])){
                        if($_GET['error'] == "missing"){
                            echo "Vous devez saisir toutes vos informations";
                        }
                        if($_GET['error'] == "nomatch"){
                            echo "Les mots de passes ne correspondent pas";
                        }
                        if($_GET['error'] == "notgood"){
                            echo "Le mot de passe n'est pas le bon";
                        }
                        if($_GET['error'] == "notfound"){
                            echo "Vous devez saisir votre mot de passe";
                        }
                        if($_GET['error'] == "database"){
                            echo "Une erreur est servenue au niveau de la base de données, veuillez contacter le support";
                        }
                        if($_GET['error'] == "illegal"){
                            echo "C'est pas bien de tricher";
                        }
                    }
                    ?>
                </p>
                <p class="success text-center">
                    <?php if(isset($_GET['success'])) echo "Vos informations ont bien été modifiées"; ?>
                </p>
                <button class="btn btn-lg btn-warning btn-block" type="submit">Modifier vos informations</button>
            </form>

            <div class="text-center" style="padding: 2em;">
                <h1>Votre abonnement</h1>

                <?php

                require_once __DIR__ . '/../../utils/database/databasemanager.php';
                $manager = new DatabaseManager();

                $userData = $manager->find('SELECT * FROM user WHERE email = ?', [$_SESSION['user']]);

                $subData = $manager->find('SELECT * FROM subscription WHERE customer_id = ?', [$userData['id']]);

                if($subData === null){?>
                <p>Vous n'avez souscrit à aucun abonnement</p>
                <a class='btn btn-warning'>Souscrivez à un abonnement</a>

                <?php
                }
                else
                ?>

            </div>

            <div class="text-center" style="padding: 2em;">
                <h1>Historique des commandes</h1>
            </div>

        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>
</html>