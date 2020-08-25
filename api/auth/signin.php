<?php
include('../includes/config.php');
if($connected) header('Location:../index.php');
?>

<!Doctype HTML>
<html lang="fr">
<head>
    <meta charset="UTF-8"/>
    <title>Perfect Concierge - Connexion</title>
    <meta name="viewport"
          content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet"
          href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
          integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk"
          crossorigin="anonymous">
</head>
<body class="text-center">
<?php include('../includes/header.php'); ?>

<div class="container">
    <div class="text-center" style="padding: 2em;">
        <h1>Connexion</h1>
    </div>

    <form class="form-signin"
          action="check/signin.php"
          method="post"
          enctype="multipart/form-data">

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
        <button class="btn btn-lg btn-warning btn-block" type="submit" style="margin-top: 2em">Se connecter</button>
    </form>
    <?php include('../includes/footer.php');?>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>
</html>