<?php

require_once __DIR__ . '/../../../../utils/database/authmanager.php';

$manager = new authmanager();
session_start();

if (
    isset($_POST['inputLastName']) &&
    isset($_POST['inputFirstName']) &&
    isset($_POST['inputEmail']) &&
    isset($_POST['inputPhone']) &&
    isset($_POST['inputAddress']) &&
    isset($_POST['inputCity']) &&
    isset($_POST['inputZip'])
){
    $newpassword = "";

    if($_SESSION['user'] != 'administration@esgi.fr'){
        header('Location:../modify.php?error=illegal&id='.$_GET['id']);
    }

    if(isset($_POST['inputPassword'])){
        if($_POST['inputPassword'] != $_POST['inputRePassword']){
            header('Location:../modify.php?error=nomatch');
        }

        $newpassword = $_POST['inputNewPassword'];
        $isrepassword = true;
    }

    $user = $manager->update_provider(
        $_POST['inputLastName'],
        $_POST['inputFirstName'],
        $_POST['inputEmail'],
        $_POST['inputPhone'],
        $_POST['inputAddress'],
        $_POST['inputCity'],
        $_POST['inputZip'],
        $_POST['inputPassword']
    );

    if($user == "done"){
        header('Location:../provider_list.php');
    }
    else{
        header('Location:../modify.php?error=' . $user . "&id=" . $_GET['id']);
        exit();
    }
}
else{
    header('Location:../modify.php?error=missing&id=' . $_GET['id']);
    exit();
}