<?php
require_once '../../../utils/database/subscriptionmanager.php';

$manager = new subscriptionmanager();
session_start();
if($manager->remove($_SESSION['user'])) header('Location:../account.php');