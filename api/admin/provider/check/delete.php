<?php

session_start();
if($_SESSION['user'] != "administration@esgi.fr"){
    header('Location:/api/index.php');
}

require_once __DIR__ . '/../../../../utils/database/authmanager.php';

$service = new authmanager();

if($service->delete_provider($_GET['email']) != 0) header('Location:../provider_list.php');