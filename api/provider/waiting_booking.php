<?php
include('../includes/config.php');
if(!$connected) header('Location:../index.php');
$userData = $database->find('SELECT * FROM user WHERE email = ?', [$_SESSION['user']]);

if($userData['statut'] !== 'provider') header('Location:../index.php');
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.6">
    <title>Perfect Concierge - Liste des réservations</title>

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
        <h2>Réservation</h2>
        <p class="lead">Voir et ajouter des réservations</p>
    </div>

    <div class="row">
        <div class="col-md-12 order-md-2 mb-4">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted">Dernières réservations en attente</span>
            </h4>
            <ul class="list-group mb-3">
                <?php
                $bookdata = $database->getPdo()->query("SELECT * FROM booking WHERE provider_id='5c589a7f-2ee0-4497-b7b9-b75caaaac461'");
                foreach ($bookdata as $booking) {
                    $service = $database->find('SELECT * FROM service WHERE id=?', [$booking['service_id']]);
                    $userData = $database->find('SELECT * FROM user WHERE id=?', [$booking['customer_id']]);
                    ?>

                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                        <div>
                            <h6 class="my-0"><?php echo $service['name']. " par " . $userData['first_name'] . " " . $userData['last_name'];?></h6>
                            <small class="text-muted">
                                <?php echo $booking['datetime'] . " à " . $booking['address'];?>
                            </small>
                        </div>
                        <span class="text-muted">
                                <a href="check/waiting_booking.php?id=<?php echo $booking['id'];?>" class="btn btn-warning">
                                    Devenir prestataire de ce service
                                </a>
                            </span>
                    </li>
                    <?php
                }
                ?>
            </ul>
        </div>
    </div>

    <?php include('../includes/footer.php'); ?>
</div>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>
</html>