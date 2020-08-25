<?php

require_once __DIR__ . '/../../../../utils/database/servicemanager.php';

session_start();
if($_SESSION['user'] != "administration@esgi.fr") header("Location:../../../../index.php");

if($_FILES['filePicture']['name'] != "" && $_FILES['filePicture']['name'] != $_POST['inputPictureName']){
    if($_FILES['filePicture']['size'] == 0){
        header('Location:../modify.php?erreur=file_size');
        exit();
    }

    $image_info = @getimagesize($_FILES['filePicture']['tmp_name']);
    if ($image_info == false) {
        header('Location:../modify.php?erreur=file_type');
    }

    $uploadfile = '../../../../ressources/pictures/' . $_FILES['filePicture']['name'];
    if (move_uploaded_file($_FILES['filePicture']['tmp_name'], $uploadfile)) {
        echo "File is valid, and was successfully uploaded.\n";
    } else {
        echo "Upload failed";
        echo "</p>";
        echo '<pre>';
        echo 'Here is some more debugging info:';
        print_r($_FILES);
        print "</pre>";
        exit;
    }
}

$frenquency = "";
if($_POST['inputFrequency'] == "other") $frenquency = $_POST['inputOtherFrequence'];
else $frenquency = $_POST['inputFrequency'];

$service = new servicemanager();
$product = $service->modify(
    $_POST['inputId'],
    $_POST['inputName'],
    $_POST['inputPrice'],
    $frenquency,
    $_POST['inputMin'],
    $_FILES['filePicture']['name'],
    $_POST['inputPictureName']
);

if($product == "done"){
    header('Location:../provider_list.php');
    exit();
}
echo "<br>" . $product;
/*else{
    header('Location:../modify.php?error=' . $product . '&id=' . $_POST['inputId']);
}*/