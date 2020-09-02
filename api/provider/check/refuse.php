<?php

require_once __DIR__ . '/../../../utils/database/bookingmanager.php';
require_once __DIR__ . '/../../../utils/database/databasemanager.php';

$database = new DatabaseManager();
$booking = new bookingmanager();
session_start();

$userData = $database->find('SELECT * FROM user WHERE email = ?', [$_SESSION['user']]);

if($userData['statut'] !== 'provider') header('Location:../../index.php');

$result = $booking->remove_provider($userData['id']);

if($result == 'done') header('Location:../intervention.php');
else header('Location:../intervention.php?error='.$result);
