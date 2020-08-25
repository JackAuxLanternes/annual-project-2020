<?php

require_once __DIR__ . '/../../../utils/database/authmanager.php';

$manager = new authmanager();
session_start();

if (
    isset($_POST['inputLastName']) &&
    isset($_POST['inputFirstName']) &&
    isset($_POST['inputEmail']) &&
    isset($_POST['inputPhone']) &&
    isset($_POST['inputAddress']) &&
    isset($_POST['inputCity']) &&
    isset($_POST['inputZip']) &&
    isset($_POST['inputPassword'])
){
    $newpassword = "";
    $isrepassword = false;

    if($_SESSION['user'] != $_POST['inputEmail']){
        header('Location:../profile.php?error=illegal');
    }

    if($isrepassword = (isset($_POST['inputNewPassword']) && $_POST['inputNewPassword'] != "")){
        if($_POST['inputNewPassword'] != $_POST['inputReNewPassword']){
            header('Location:../profile.php?error=nomatch');
        }

        $newpassword = $_POST['inputNewPassword'];
        $isrepassword = true;
    }

    $user = $manager->update(
        $_POST['inputLastName'],
        $_POST['inputFirstName'],
        $_POST['inputEmail'],
        $_POST['inputPhone'],
        $_POST['inputAddress'],
        $_POST['inputCity'],
        $_POST['inputZip'],
        $_POST['inputPassword'],
        $newpassword,
        $isrepassword
    );

    if($user == "done"){
        header('Location:../account.php?success=1');
    }
    else{
        header('Location:../account.php?error=' . $user);
        exit();
    }
}
else{
    header('Location:../account.php?error=missing&type=info');
    exit();
}
