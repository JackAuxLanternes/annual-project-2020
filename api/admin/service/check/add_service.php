<?php

require_once __DIR__ . '/../../../../utils/database/servicemanager.php';

session_start();

if($_SESSION['user'] != "administration@esgi.fr") header("Location:../../../../index.php");


if(
    !isset($_POST['inputName']) ||
    !isset($_POST['inputPrice']) ||
    !isset($_POST['inputFrequency']) ||
    !isset($_POST['inputMin']) ||
    !isset($_FILES['filePicture']['type'])
) {
    header('Location:../add_service.php?error=missing');
    exit();
}

if($_FILES['filePicture']['size'] == 0){
    header('Location:../add_service.php?erreur=file_size');
    exit();
}

$image_info = @getimagesize($_FILES['filePicture']['tmp_name']);
if ($image_info == false) {
    header('Location:../add_service.php?erreur=file_type');
}

/*$uploadfile = '../../../../ressources/pictures/' . $_FILES['filePicture']['name'];
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
}*/

$frenquency = "";
if($_POST['inputFrequency'] == "other") $frenquency = $_POST['inputOtherFrequence'];
else $frenquency = $_POST['inputFrequency'];


$service = new servicemanager();
echo $frenquency;
$product = $service->add(
    $_POST['inputName'],
    $_POST['inputPrice'],
    $frenquency,
    $_POST['inputMin'],
    $_FILES['filePicture']['name']
);

if($product == "done"){
    //header('Location:../provider_list.php');
    exit();
}
else{
    //header('Location:../add_service.php?error=' . $product);
}
/*if(!isset($_POST['inputProductName'])){
    echo "Missing inputProductName";
}
if(!isset($_POST['inputPrice'])){
    echo "Missing inputPrice";
}
if(!isset($_POST['inputQuantity'])){
    echo "Missing inputQuantity";
}
if(!isset($_POST['radioPriceType'])){
    echo "Missing radioPriceType";
}
if(!isset($_POST['checkPayForm'])){
    echo "Missing checkPayForm";
}
if(!isset($_POST['checkDeliver'])){
    echo "Missing checkDeliver";
}
if(!isset($_POST['inputCategory'])){
    echo "Missing inputCategory";
}*/