<?php
if($_GET['item'] == "" || !isset($_GET['item'])) header('Location:../index.php');

include('../includes/config.php');
if(!$connected) header('Location:../index.php');
$userData = $database->find('SELECT * FROM user WHERE email = ?', [$_SESSION['user']]);
$subData = $database->find('SELECT * FROM subscription WHERE customer_id = ?', [$userData['id']]);

if($subData !== null) header('Location:../index.php');
?>

<!Doctype HTML>
<html lang="fr">
<head>
    <meta charset="UTF-8"/>
    <title>Perfect Concierge - Abonnement</title>
    <meta name="viewport"
          content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet"
          href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
          integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk"
          crossorigin="anonymous">
</head>
<body>
<?php include('../includes/header.php'); ?>

<div class="container">
    <div class="text-center" style="padding: 2em;">
        <h1>Soucription à un abonnement</h1>
        Votre abonnement ne pourra être remboursé
    </div>

    <p><h3>La commande comprend :</h3></p>

    <?php
    switch ($_GET['item']){
        case 'base' :
            echo '
                <p>1 abonnement de base de 1 an</p>
                <p>2400€ TTC</p>
            ';
            break;
        case 'familly' :
            echo '
                <p>1 abonnement familial de 1 an</p>
                <p>3600€ TTC</p>
            ';
            break;
        case 'premium' :
            echo '
                <p>1 abonnement premium de 1 an</p>
                <p>6000€ TTC</p>
            ';
            break;
    }
    ?>

    <form action="check/add_subscription.php?item=<?php echo $_GET['item']?>" method="POST" id="payment-form">
        <div id="card-element"></div>
        <div class="text-center"><button type="submit" class="btn btn-warning" style="margin: 1em">Payer</button></div>
    </form>

    <script src="https://js.stripe.com/v3/"></script>
    <script src="../../vendor/token.js" type="text/javascript"></script>
    <?php include('../includes/footer.php');?>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>
</html>