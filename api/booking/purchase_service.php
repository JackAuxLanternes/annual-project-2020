<?php
include('../includes/config.php');

$userdata = $database->find('SELECT statut FROM user where email=?', [$_SESSION['user']]);
if($userdata['statut'] != "customer") header("Location:../index.php");
?>
<!Doctype HTML>
<html lang="fr">
<head>
    <meta charset="UTF-8"/>
    <title>Perfect Concierge - Payement</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet"
          href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
          integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk"
          crossorigin="anonymous">
</head>
<body>

<?php
include('../includes/header.php');

$service = $database->find('SELECT * FROM service where id=?', [$_GET['item']]);
$subdata = $database->find('SELECT hours_left FROM subscription where customer_id=?', [$userdata['id']]);
?>

<div class="container">

    <div class="text-center" id="speach"><h1>Commander un service</h1></div>

    <div class="row">
        <div class="col-sm">

            <form class="form-check"
                  action="check/purchase_service.php?item=<?php echo $_GET['item']?>"
                  method="post"
                  id="payment-form">

                <ul class="list-group mb-3">

                    <div class="text-center" style="padding: 1em"><?php echo $service['name']?></div>
                    <div class="form-group row">
                        <label for="inputAddress"
                               class="col-sm-2 col-form-label">
                            Adresse détaillée (vous pouvez laisser vide si vous souhaiter utiliser votre adresse)
                        </label>
                        <div class="col-sm-10">
                            <input type="text"
                                   class="form-control"
                                   name="inputAddress"
                                   id="inputAddress"
                                   placeholder="ex : 242 Rue du Faubourg Saint-Antoine, 75012 Paris">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="inputDate"
                               class="col-sm-2 col-form-label">
                            Date
                        </label>
                        <div class="col-sm-10">
                            <input type="date"
                                   class="form-control"
                                   name="inputDate"
                                   id="inputDate"
                                   required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputTime"
                               class="col-sm-2 col-form-label">
                            Heure
                        </label>
                        <div class="col-sm-10">
                            <input type="time"
                                   class="form-control"
                                   name="inputTime"
                                   id="inputTime"
                                   required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputQuantity"
                               class="col-sm-2 col-form-label">
                            Quantité réservée
                            <?php
                            echo " ". $service['price'] ."€ ";
                            switch ($service['flow_frequency_shape']){
                                case 'hours' :
                                    echo 'de l\'heure. ';
                                    break;
                                case 'day' :
                                    echo 'la journée. ';
                                    break;
                                default:
                                    echo 'par ' . $service['flow_frequency_shape'] . ". ";
                            }
                            if($subdata !== null){
                                echo "Votre abonnement vous permet de réserver encore ". $subdata['hours_left'] ." heures";
                            ?>
                        </label>
                        <div class="col-sm-10">
                            <input type="text"
                                   class="form-control"
                                   name="inputQuantity"
                                   id="inputQuantity"
                                   required
                                   <?php echo 'max="'. $subdata['hours_left'] .'"';}?>>
                        </div>
                    </div>

                    <div class="text-center">Si vous êtes abonnée vous payez à l'Heure</div>

                <?php
                if($subdata === null){
                    ?>
                    <div><div id="card-element"></div></div>
                    <div class="text-center"><button type="submit" class="btn btn-warning" style="margin: 1em">Payer</button></div>

                    <script src="https://js.stripe.com/v3/"></script>
                    <script src="../../vendor/token.js" type="text/javascript"></script>
                    <?php
                }

                $req = $database->getPdo()->query('SELECT * FROM service');

                foreach($req as $service) {

                }
                ?>
                </ul>
            </form>
        </div>
    </div>
</div>

<?php include('../includes/footer.php'); ?>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
        integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI"
        crossorigin="anonymous"></script>
</body>
</html>