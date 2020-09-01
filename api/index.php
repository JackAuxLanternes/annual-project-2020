<?php include('includes/config.php'); ?>
<!Doctype HTML>
<html lang="fr">
<head>
    <meta charset="UTF-8"/>
    <title>Perfect Concierge - Accueil</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet"
          href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
          integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk"
          crossorigin="anonymous">
</head>
<body>

<?php include('includes/header.php');?>

<style>
    #speach{
        padding: 40px;
    }
    #title>h1{
        margin-bottom: 0;
    }
</style>

<div class="container">

    <div class="text-center" id="speach"><h1>A votre service</h1></div>

    <div class="row">

            <?php

            $req = $database->getPdo()->query('SELECT * FROM service');

            foreach($req as $service) {

                echo '<div class="card col-4 min-vh-50" style="width: 18rem;">
                                <img src="../ressources/pictures/'. $service['picture_name'] . '" 
                                        alt="'. $service['picture_name'] . '" 
                                        class="card-img-top"
                                        width="100px">
                                        
                                    <h5 class="card-title" style="padding: 1em">'. $service['name'] .'</h5>
                                    <p class="card-text" style="padding-left: 1em; padding-right: 1em">'. $service['price'] .' € ';
                switch ($service['flow_frequency_shape']){
                    case 'hours' :
                        echo 'de l\'heure. ';
                        break;
                    case 'day' :
                        echo 'la journée. ';
                        break;
                    default:
                        echo $service['flow_frequency_shape'] . ". ";
                }

                if($service['min_hours_required'] == 1) echo "Il faut réserver au moins " . $service['min_hours_required'] . " heure";
                elseif($service['min_hours_required'] > 1) echo "Il faut réserver au moins " . $service['min_hours_required'] . " heures";

                echo '            </p>
                    <a href="booking/purchase_service.php?item='. $service['id'] .'" class="btn btn-warning" style="margin-bottom: 1em;">Réserver</a>
                             </div>
                        </li>
                    </ul>
                ';

            }
            ?>

        </div>
    </div>

<?php include('includes/footer.php'); ?>

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