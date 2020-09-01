<?php

require '../../../vendor/autoload.php';
require_once __DIR__ . '/../../../utils/database/bookingmanager.php';
require_once __DIR__ . '/../../../utils/database/databasemanager.php';

$database = new DatabaseManager();
$booking = new bookingmanager();
session_start();

use Stripe\Charge;
use Stripe\Customer;
use Stripe\Stripe;
Stripe::setApiKey('sk_test_51HK0YHKpVW5i0Eene7pCmhNLwbSshGEwzsq25vqX111jpp9KuwIJiq8qkNUGsLqgAxksEt2KsH6iRhF3KP7EbFDA00J8F1mMwh');

try {
    $token = $_POST['stripeToken'];
    $customer = Customer::create(array(
        "email" => $_SESSION['user'],
        "source" => $token,
    ));

    $service = $database->find('SELECT price FROM service WHERE id=?', [$_GET['item']]);

    $amount = $service['price'] * 100;

    $charge = Charge::create(array(
        "amount" => $amount,
        "currency" => "eur",
        "customer" => $customer->id
    ));
}
catch (Exception $e) {
    echo $e->getMessage();
}

$userdata = $database->find('SELECT * FROM user where email=?', [$_SESSION['user']]);
if($userdata['statut'] != "customer") header("Location:../../../index.php");

if(
    !isset($_POST['inputDate']) ||
    !isset($_POST['inputTime']) ||
    !isset($_POST['inputQuantity'])
)
    header('Location:../purchase_service.php?error=missing');

if($_POST['inputAddress'] == "" || !isset($_POST['inputAddress'])){
    $address = $userdata['address'] . ", " . $userdata['zip'] . " " . $userdata['city'];
}
else $address = $_POST['inputAddress'];

$result = $booking->add(
    $userdata['id'],
    "empty",
    $_GET['item'],
    $_POST['inputQuantity'],
    $address,
    $_POST['inputDate'],
    $_POST['inputTime']
);

if($result == 'done') header('Location:../../account/account.php');
else header('Location:../purchase_service.php?&error='.$result);