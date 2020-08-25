<?php
include('../../includes/config.php');
if($_SESSION['user'] != "administration@esgi.fr") header("Location:../../index.php");
?>

<!Doctype HTML>
<html lang="fr">
<head>
    <meta charset="UTF-8"/>
    <title>Perfect Concierge - Modifier un service</title>
    <meta name="viewport"
          content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet"
          href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
          integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk"
          crossorigin="anonymous">
</head>
<body>
<?php include('../../includes/header.php'); ?>

<div class="container">
    <div class="text-center" style="padding: 2em;">
        <h1>Modification</h1>
    </div>

    <?php

    $servicedata = $database->find("SELECT * FROM service WHERE id=?", [$_GET['id']]);

    ?>
    <form class="form-signin"
          action="check/modify.php"
          method="post"
          enctype="multipart/form-data">

        <div class="sr-only">
            <label for="inputId">id</label>
            <input name="inputId" id="inputId" value="<?php echo $servicedata['id'];?>">
        </div>
        <div class="sr-only">
            <label for="inputPictureName">actual picture name</label>
            <input name="inputPictureName" id="inputPictureName" value="<?php echo $servicedata['picture_name'];?>">
        </div>

        <div class="form-group row">
            <label for="inputName"
                   class="col-sm-2 col-form-label">
                Nom
            </label>
            <div class="col-sm-10">
                <input type="text"
                       class="form-control"
                       name="inputName"
                       id="inputName"
                       value="<?php echo $servicedata['name'];?>"
                       required>
            </div>
        </div>
        <div class="form-group row">
            <label for="inputPrice"
                   class="col-sm-2 col-form-label">
                Prix (TTC)
            </label>
            <div class="col-sm-10">
                <input type="number"
                       class="form-control"
                       id="inputPrice"
                       name="inputPrice"
                       placeholder="€"
                       value="<?php echo $servicedata['price'];?>"
                       required>
            </div>
        </div>


        <fieldset class="form-group">
            <div class="row">
                <legend class="col-form-label col-sm-2 pt-0">Fréquence de paiement</legend>
                <div class="col-sm-10">
                    <div class="form-check">
                        <input class="form-check-input"
                               type="radio"
                               name="inputFrequency"
                               id="inputFrequencyHours"
                               value="hours"
                               <?php if ($servicedata['flow_frequency_shape'] == "hours") echo 'checked'?>
                        >
                        <label class="form-check-label" for="inputFrequencyHours">
                            De l'heure
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input"
                               type="radio"
                               name="inputFrequency"
                               id="inputFrequencyDay"
                               value="day"
                               <?php if ($servicedata['flow_frequency_shape'] == "day") echo 'checked'?>>
                        <label class="form-check-label" for="inputFrequencyDay">
                            La journée
                        </label>
                    </div>
                    <div class="form-check disabled">
                        <input class="form-check-input"
                               type="radio"
                               name="inputFrequency"
                               id="inputFrequencyOther"
                               value="other"
                            <?php if ($servicedata['flow_frequency_shape'] != "hours" &&
                                      $servicedata['flow_frequency_shape'] != "day") {
                                echo 'checked';}?>
                        >
                        <label class="form-check-label" for="inputFrequencyOther">
                            Autre : <input type="text" name="inputOtherFrequence" placeholder="ex : la visite"
                                <?php if ($servicedata['flow_frequency_shape'] != "hours" &&
                                    $servicedata['flow_frequency_shape'] != "day") {
                                    echo 'value="' . $servicedata['flow_frequency_shape'] . '"';}?>
                            >
                        </label>
                    </div>
                </div>
            </div>
        </fieldset>

        <div class="form-group row">
            <label for="inputMin"
                   class="col-sm-2 col-form-label">
                Heures minimum à commander (0 si aucune)
            </label>
            <div class="col-sm-10">
                <input type="number"
                       class="form-control"
                       id="inputMin"
                       name="inputMin"
                       value="<?php echo $servicedata['min_hours_required'];?>"
                       required>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-2">Photo d'illustration (si vous ne souhaitez pas la modifier n'insérez pas de photo)</div>
            <div class="col-sm-10">
                <input type="file"
                       class="form-control-file"
                       id="filePicture"
                       name="filePicture">
            </div>
        </div>


        <p class="error text-center" style="color: red; padding: 1em;">
            <b>
                <?php
                if(isset($_GET['error'])){
                    if($_GET['error'] == "missing"){
                        echo "Vous devez saisir toutes vos informations";
                    }
                    if($_GET['error'] == "database"){
                        echo "Une erreur est servenue au niveau de la base de données";
                    }
                }
                ?>
            </b>
        </p>
        <button class="btn btn-lg btn-warning btn-block" type="submit">Modifier le service</button>
    </form>
    <?php include('../../includes/footer.php');?>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>
</html>