<?php

require_once __DIR__ . '/../../../../utils/database/bookingmanager.php';
require_once __DIR__ . '/../../../../utils/database/databasemanager.php';

$database = new DatabaseManager();
$booking = new bookingmanager();
session_start();

if($_SESSION['user'] != "administration@esgi.fr") header("Location:../../../../index.php");

switch ($_GET['page']){
    case 1:
        if(isset($_POST['inputAddress']) && isset($_POST['inputDate']) && isset($_POST['inputTime'])){
            $_SESSION['inputAddress'] = $_POST['inputAddress'];
            $_SESSION['inputDate'] = $_POST['inputDate'];
            $_SESSION['inputTime'] = $_POST['inputTime'];
            $_SESSION['inputQuantity'] = $_POST['inputQuantity'];
            header('Location:../modify.php?page=2&id='.$_GET['id']);
        }
        else header('Location:../modify.php?page=1&'.$_GET['id'].'&error=missing');
        exit();

    case 2:
        if(!isset($_POST['radioProvider'])){
            header('Location:../modify.php?page=2&'.$_GET['id'].'&error=missing');
        }


        $result = $booking->modify(
            $_GET['id'],
            $_POST['radioProvider'],
            $_SESSION['inputAddress'],
            $_SESSION['inputDate'],
            $_SESSION['inputTime'],
        );

        if($result == 'done') header('Location:../booking_list.php');
        else header('Location:../modify.php?page=2&'.$_GET['id'].'&error='.$result);

}
