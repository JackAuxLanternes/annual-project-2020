<?php

session_start();
if($_SESSION['user'] != "administration@esgi.fr"){
    header('Location:/api/index.php');
}

require_once __DIR__ . '/../../../../utils/database/servicemanager.php';

$service = new servicemanager();

if($service->remove($_GET['id']) != 0) header('Location:../provider_list.php');