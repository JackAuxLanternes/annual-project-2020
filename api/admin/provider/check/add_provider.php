<?php

require_once __DIR__ . '/../../../../utils/database/authmanager.php';

session_start();

if($_SESSION['user'] != "administration@esgi.fr") header("Location:../../../../index.php");


if(
    !isset($_POST['inputLastName']) ||
    !isset($_POST['inputFirstName']) ||
    !isset($_POST['inputEmail']) ||
    !isset($_POST['inputPhone']) ||
    !isset($_POST['inputAddress']) ||
    !isset($_POST['inputCity']) ||
    !isset($_POST['inputZip']) ||
    !isset($_POST['inputPassword']) ||
    !isset($_POST['inputRePassword'])
) {
    header('Location:../add_provider.php?error=missing');
    exit();
}

$service = new authmanager();
$result = $service->add_provider(
    $_POST['inputLastName'],
    $_POST['inputFirstName'],
    $_POST['inputEmail'],
    $_POST['inputPhone'],
    $_POST['inputAddress'],
    $_POST['inputCity'],
    $_POST['inputZip'],
    $_POST['inputPassword'],
    $_POST['inputRePassword']
);

if($result == 'done'){
        header('Location:../provider_list.php');
        exit();
}
else {
    header('Location:../add_provider.php?error=' . $result);
    exit();
}
