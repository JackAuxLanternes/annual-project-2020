<?php

require_once __DIR__ . '/../../../utils/database/authmanager.php';

if(
    !isset($_POST['inputEmail']) ||
    !isset($_POST['inputPassword'])
) {
    header('Location:../signin.php?error=missing');
    exit();
}

$service = new authmanager();
$result = $service->signin(
    $_POST['inputEmail'],
    $_POST['inputPassword']
);

if($result == 'done'){
    session_start();
    $_SESSION['user'] = $_POST['inputEmail'];
    header('Location:../../index.php');
    exit();
}
else{
    header('Location:../signin.php?error=' . $result);
    exit();
}