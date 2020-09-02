<?php
include('../../includes/config.php');
if($_SESSION['user'] != "administration@esgi.fr") header("Location:../../index.php");
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.6">
    <title>Perfect Concierge - Ajouter une réservation</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.4/examples/checkout/">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <meta name="msapplication-config" content="/docs/4.4/assets/img/favicons/browserconfig.xml">
    <meta name="theme-color" content="#563d7c">


    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>
</head>
<body class="bg-light">

<?php include("../../includes/header.php"); ?>

<div class="container">
    <div class="py-5 text-center">
        <h2>Réservation</h2>
        <p class="lead">Ajouter une réservation</p>
    </div>

    <div class="row">
        <div class="col-md-12 order-md-2 mb-4">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
                <form method="post" action="add_booking.php?page=<?php echo $_GET['page']?>">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" aria-describedby="validatedInputGroupPrepend" required>
                    <div class="input-group-append">
                        <button class="btn btn-outline-warning" type="submit">
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-search" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M10.442 10.442a1 1 0 0 1 1.415 0l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1 0-1.415z"/>
                                <path fill-rule="evenodd" d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/>
                            </svg>
                        </button>
                    </div>
                </div>
                </form>
            </h4>

            <form class="form-check"
                  method="post"
                  action="check/add_booking.php?page=<?php echo $_GET['page']?>"
            >
                <ul class="list-group mb-3">

                <?php
                switch ($_GET['page']){
                    case 1:
                        echo "<h5>Sélectionnez le client</h5>";
                        $req = $database->getPdo()->query("SELECT * FROM user where statut='customer'");

                        foreach ($req as $customer){
                            $subscription = $database->find('SELECT * FROM subscription where customer_id=?', [$customer['id']]);
                            if($subscription !== null && $subscription['hours_left'] != 0){
                                $item = '
                                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="radio-'.$customer['id'].'" name="radioCustomer" class="custom-control-input" value="'.$customer['id'].'">
                                                <label class="custom-control-label" for="radio-'.$customer['id'].'">
                                                    <h6 class="my-0">'. $customer['last_name'] . " " . $customer['first_name'] .'</h6>
                                                    <small class="text-muted">'. $customer['address'] . ', ' . $customer['zip'] . ' ' . $customer['city'] .'</small>
                                                </label>
                                            </div>
                                        </li>
                                ';
                                if(isset($_POST['search'])) {
                                    if (strpos($customer['first_name'], $_POST['search']) || strpos($customer['last_name'], $_POST['search'])){
                                        echo $item;
                                    }
                                }
                                else echo $item;
                            }
                        }
                        break;
                    case 2:
                        echo "<h5>Sélectionner le service</h5>";
                        $req = $database->getPdo()->query("SELECT * FROM service");

                        foreach ($req as $service){
                            $item = '
                                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="radio-'.$service['id'].'" name="radioService" class="custom-control-input" value="'.$service['id'].'">
                                            <label class="custom-control-label" for="radio-'.$service['id'].'">
                                                <h6 class="my-0">'. $service['name'] . '</h6>
                                                <small class="text-muted">
                                                '. $service['price'] .' €, format : ' . $service['flow_frequency_shape'] . ', min : ' . $service['min_hours_required'] . '
                                                </small>
                                            </label>
                                        </div>
                                    </li>
                            ';
                            if(isset($_POST['search'])) {
                                if (strpos($service['name'], $_POST['search'])){
                                    echo $item;
                                }
                            }
                            else echo $item;
                        }
                        break;
                    case 3:
                        echo "<h5>Veuillez saisir les informations requises</h5>";
                        $subData = $database->find('SELECT * FROM subscription WHERE customer_id = ?', [$_SESSION['customer_id']]);

                        echo '
                            <div class="text-center" style="padding: 1em">Informations</div>
                            <div class="form-group row">
                                <label for="inputAddress"
                                       class="col-sm-2 col-form-label">
                                    Adresse (laissé vide si identique au domicile du client)
                                </label>
                                <div class="col-sm-10">
                                    <input type="text"
                                           class="form-control"
                                           name="inputAddress"
                                           id="inputAddress">
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
                                    Quantité réservée (max '.$subData['hours_left'].')
                                </label>
                                <div class="col-sm-10">
                                    <input type="text"
                                           class="form-control"
                                           name="inputQuantity"
                                           id="inputQuantity"
                                           max="'.$subData['hours_left'].'"
                                           required>
                                </div>
                            </div>
                        ';
                        break;
                    case 4:
                        echo "<h5>Sélectionnez un prestataire pour ce service</h5>";
                        $req = $database->getPdo()->query("SELECT * FROM user where statut='provider'");

                        foreach ($req as $provider){
                            $item = '
                                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="radio-'.$provider['id'].'" name="radioProvider" class="custom-control-input" value="'.$provider['id'].'">
                                            <label class="custom-control-label" for="radio-'.$provider['id'].'">
                                                <h6 class="my-0">'. $provider['last_name'] . " " . $provider['first_name'] .'</h6>
                                                <small class="text-muted">'. $provider['address'] . ', ' . $provider['zip'] . ' ' . $provider['city'] .'</small>
                                            </label>
                                        </div>
                                    </li>
                                ';
                            if(strpos($_SESSION['inputAddress'], $provider['city']) || strpos($_SESSION['inputAddress'], $provider['zip'])){
                                $query = "SELECT cast(datetime as time), quantity_booked FROM booking WHERE 
                                                                provider_id='".$provider['id']."' AND
                                                                datetime LIKE '%".$_SESSION['inputDate']."%'";
                                $bookdata = $database->getPdo()->query($query);
                                if($bookdata == null) echo $item;
                                else{
                                    foreach ($bookdata as $booking){
                                        if(strtotime($booking['cast(datetime as time)']) < strtotime($_SESSION['inputTime'])) {
                                            if(strtotime('+'.$booking['quantity_booked'].' hour',strtotime($booking['cast(datetime as time)'])) < strtotime($_SESSION['inputTime']))
                                                echo $item;
                                        }
                                        else{
                                            if(strtotime($booking['cast(datetime as time)']) > strtotime('+'.$_SESSION['inputQuantity'].' hour',strtotime($_SESSION['inputTime'])))
                                                echo $item;
                                        }
                                    }
                                }
                            }
                        }
                        break;
                }
                ?>

                </ul>

                <p class="error" style="color: red">
                    <?php

                    if(isset($_GET['error'])){
                        switch ($_GET['error']){
                            case 'missing':
                                echo 'Veuillez saisir toutes les informations';
                                break;
                        }
                    }

                    ?>
                </p>

                <div class="text-center"><input type="submit" class="btn btn-warning" value="Suivant"></div>
            </form>
        </div>
    </div>

    <?php include('../../includes/footer.php'); ?>
</div>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>
</html>