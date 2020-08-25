<?php
include('../includes/config.php');
if(!$connected) header("Location:../index.php");
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.6">
    <title>Perfect Concierge - Devis</title>

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

<?php include("../includes/header.php"); ?>

<div class="container">
    <div class="py-5 text-center">
        <h2>Devis</h2>
    </div>

    <div class="row">
        <div class="col-md-12 order-md-2 mb-4">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted">Liste des services proposés</span>
            </h4>

            <form action="generate_pdf.php" method="post">

            <?php

            $req = $database->getPdo()->query('SELECT * FROM service');

            foreach($req as $service) {

                echo '
                    <ul class="list-group mb-3">
                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                            <div class="media">
                                <img src="../../ressources/pictures/'. $service['picture_name'] . '" 
                                        alt="mengage" 
                                        width="100px"
                                        style="margin-right: 10px">
                                <div class="media-body">
                                
                                    <h5>'. $service['name'] .'</h5>
                                    '. $service['price'] .' € ';
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

                if($service['min_hours_required'] == 0) echo "Aucune heure minimum requise";
                elseif($service['min_hours_required'] == 1) echo "Il faut réserver au moins " . $service['min_hours_required'] . " heure";
                else echo "Il faut réserver au moins " . $service['min_hours_required'] . " heures";

                echo '</div>
                            </div>
                            <span>
                                <input type="number" value="0" name="'.$service['id'].'">
                            </span>
                        </li>
                    </ul>
                ';

            }
            ?>
                <input type="submit"
                       class="btn btn-warning"
                       value="Obtenir le devis"
                       style="position: center"
                >
            </form>

        </div>
    </div>

    <?php include('../includes/footer.php'); ?>
</div>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>
</html>