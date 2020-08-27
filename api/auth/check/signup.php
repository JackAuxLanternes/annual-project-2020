<?php

require_once __DIR__ . '/../../../utils/database/authmanager.php';

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
    header('Location:../signup.php?error=missing');
    exit();
}

$service = new authmanager();
$result = $service->signup(
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
    session_start();
    $_SESSION['user'] = $_POST['inputEmail'];

    if($_POST['subscriptionRadios'] == "empty"){
        header('Location:../../index.php');
        exit();
    }
    else{
        header('Location:../../subscription/add_subscription.php?item=' . $_POST['subscriptionRadios']);
        exit();
    }
}
else{
    header('Location:../signup.php?error=' . $result);
    exit();
}