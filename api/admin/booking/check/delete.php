<?php

session_start();
if($_SESSION['user'] != "administration@esgi.fr"){
    header('Location:/api/index.php');
}

require_once __DIR__ . '/../../../../utils/database/bookingmanager.php';

$service = new bookingmanager();

if($service->delete($_GET['id']) != 0) header('Location:../booking_list.php');