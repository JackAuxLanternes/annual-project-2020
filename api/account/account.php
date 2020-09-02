<?php
include('../includes/config.php');
if(!$connected) header('Location:../../index.php');
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
                <form class="form-signin"
                      action="check/add_subscription.php"
                      method="post"
                      enctype="multipart/form-data">
                    <div class="row text-center">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="subscriptionRadios" id="subscriptionRadiosBase" value="base">
                            <label class="form-check-label" for="subscriptionRadiosBase">

                                <div class="col d-flex justify-content-center">
                                    <div class="card" style="width: 18rem;">
                                        <div class="card-body">
                                            <h5 class="card-title">Abonnement de base</h5>
                                            <p class="card-text">Bénéficiez d'un accès privilégié en illimité 5j/7 de 9h à 20h</p>
                                            <p class="card-text">Demandes illimitées de renseignement</p>
                                            <p class="card-text">12h de service/mois</p>
                                            <p class="card-text">2 400€ TTC /an</p>
                                        </div>
                                    </div>
                                </div>

                            </label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="subscriptionRadios" id="subscriptionRadiosFamilly" value="familly">
                            <label class="form-check-label" for="subscriptionRadiosFamilly">

                                <div class="col d-flex justify-content-center">
                                    <div class="card" style="width: 18rem;">
                                        <div class="card-body">
                                            <h5 class="card-title">Abonnement Famillial</h5>
                                            <p class="card-text">Bénéficiez d'un accès privilégié en illimité 6j/7 de 9h à 20h</p>
                                            <p class="card-text">Demandes illimitées de renseignement</p>
                                            <p class="card-text">25h de service/mois</p>
                                            <p class="card-text">3 600€ TTC /an</p>
                                        </div>
                                    </div>
                                </div>

                            </label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="subscriptionRadios" id="subscriptionRadiosPremium" value="premium" >
                            <label class="form-check-label" for="subscriptionRadiosPremium">

                                <div class="col d-flex justify-content-center">
                                    <div class="card" style="width: 18rem;">
                                        <div class="card-body">
                                            <h5 class="card-title">Abonnement Premium</h5>
                                            <p class="card-text">Bénéficiez d'un accès privilégié en illimité 7j/7 24h/24</p>
                                            <p class="card-text">Demandes illimitées de renseignement</p>
                                            <p class="card-text">50h de service/mois</p>
                                            <p class="card-text">6 000€ TTC /an</p>
                                        </div>
                                    </div>
                                </div>

                            </label>
                        </div>
                    </div>
                    <input type="submit" class='btn btn-warning' value="Souscrivez à un abonnement" style="margin-top: 1em">
                </form>

                <?php
                }
                else{
                    echo "<p>Vous avez un abonnement : " . $subData['type'] . "</p>";
                    echo "<p>Il vous reste " . $subData['hours_left'] . " heures</p>";
                    echo "<div class=\"text-center\"><a href='check/remove_subscription.php' class='btn btn-warning'>Se désabonner</a></div>";
                }?>

            </div>

            <div style="padding: 2em;">
                <div class="text-center"><h1>Historique des commandes</h1></div>
                <div class="col-md-12 order-md-2 mb-4">
                    <ul class="list-group mb-3">
                        <?php
                        $userData = $database->find('SELECT id FROM user WHERE email=?', [$_SESSION['user']]);
                        $bookdata = $database->getPdo()->query("SELECT * FROM booking WHERE customer_id='".$userData['id']."'");

                        foreach ($bookdata as $booking) {
                            $service = $database->find('SELECT * FROM service WHERE id=?', [$booking['service_id']]);?>
                                <li class="list-group-item d-flex justify-content-between lh-condensed">
                                    <div>
                                        <h6 class="my-0"><?php echo $service['name'];?></h6>
                                        <small class="text-muted">
                                            <?php
                                            echo $booking['datetime'];

                                            if($booking['provider_id'] === '5c589a7f-2ee0-4497-b7b9-b75caaaac461') echo ", statut : En attente de prise en charge";
                                            else echo ", statut : Acceptée";
                                            ?>
                                        </small>
                                    </div>
                                    <span class="text-muted"><?php echo $booking['quantity_booked']*$service['price']?> €</span>
                                </li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>

            <div class="text-center" style="padding: 2em;">
                <h1>Factures</h1>
                <ul class="list-group mb-3">
                    <?php
                    $files = scandir("../../ressources/invoices");

                    $userData = $database->find('SELECT id FROM user WHERE email=?', [$_SESSION['user']]);

                    foreach ($files as $item) {
                        if(strpos($item, $userData['id'])) {
                            echo '
                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                <div class="media">
                                    <div class="media-body">
                                        <h5>'. $item .'</h5>
                                        </div>
                                </div>
                                <span>
                                    <a href="../../ressources/invoices/'.$item.'" class="btn btn-warning" download>
                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-download" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                      <path fill-rule="evenodd" d="M.5 8a.5.5 0 0 1 .5.5V12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V8.5a.5.5 0 0 1 1 0V12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V8.5A.5.5 0 0 1 .5 8z"/>
                                      <path fill-rule="evenodd" d="M5 7.5a.5.5 0 0 1 .707 0L8 9.793 10.293 7.5a.5.5 0 1 1 .707.707l-2.646 2.647a.5.5 0 0 1-.708 0L5 8.207A.5.5 0 0 1 5 7.5z"/>
                                      <path fill-rule="evenodd" d="M8 1a.5.5 0 0 1 .5.5v8a.5.5 0 0 1-1 0v-8A.5.5 0 0 1 8 1z"/>
                                    </svg>
                                    </a>
                                </span>
                            </li>
                            ';
                        }
                    }
                    ?>
                </ul>
            </div>

        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>
</html>