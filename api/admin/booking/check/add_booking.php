<?php

require_once __DIR__ . '/../../../../utils/database/bookingmanager.php';
require_once __DIR__ . '/../../../../utils/database/databasemanager.php';

$database = new DatabaseManager();
$booking = new bookingmanager();
session_start();

if($_SESSION['user'] != "administration@esgi.fr") header("Location:../../../../index.php");

switch ($_GET['page']){
    case 1:
        if(isset($_POST['radioCustomer'])){
            $_SESSION['customer_id'] = $_POST['radioCustomer'];
            header('Location:../add_booking.php?page=2');
        }
        else header('Location:../addbooking.php?page=1&error=missing');
        exit();

    case 2:
        if(isset($_POST['radioService'])){
            $_SESSION['service_id'] = $_POST['radioService'];
            header('Location:../add_booking.php?page=3');
        }
        else header('Location:../addbooking.php?page=2&error=missing');
        exit();

    case 3:
        if(isset($_POST['inputDate']) && isset($_POST['inputTime']) && isset($_POST['inputQuantity'])){
            if($_POST['inputAddress'] == "" || !isset($_POST['inputAddress'])){
                $userdata = $database->find('SELECT address, city, zip FROM user WHERE id=?', [$_SESSION['customer_id']]);
                $_SESSION['inputAddress'] = $userdata['address'] . ", " . $userdata['zip'] . " " . $userdata['city'];
            }
            else $_SESSION['inputAddress'] = $_POST['inputAddress'];

            $_SESSION['inputDate'] = $_POST['inputDate'];
            $_SESSION['inputTime'] = $_POST['inputTime'];
            $_SESSION['inputQuantity'] = $_POST['inputQuantity'];
            header('Location:../add_booking.php?page=4');
        }
        else header('Location:../add_booking.php?page=3&error=missing');
        exit();

    case 4:
        if(!isset($_POST['radioProvider'])){
            header('Location:../add_booking.php?page=4&error=missing');
        }


        $result = $booking->add(
            $_SESSION['customer_id'],
            $_POST['radioProvider'],
            $_SESSION['service_id'],
            $_SESSION['inputQuantity'],
            $_SESSION['inputAddress'],
            $_SESSION['inputDate'],
            $_SESSION['inputTime'],
        );

        if($result == 'done') header('Location:../booking_list.php');
        else header('Location:../add_booking.php?page=4&error='.$result);

}
