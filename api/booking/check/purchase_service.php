<?php

require '../../../vendor/autoload.php';
include('../../../utils/quote/pdfinvoice/src/InvoicePrinter.php');
require_once __DIR__ . '/../../../utils/database/bookingmanager.php';
require_once __DIR__ . '/../../../utils/database/databasemanager.php';

$invoice = new \Konekt\PdfInvoice\InvoicePrinter();
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

if($result == 'done') {

    $invoice->setLogo("../../../ressources/Logo.png");
    $invoice->setColor("#ffc107");
    $invoice->setType("Facture service");
    try {
        $reference = bin2hex(random_bytes(5));
    } catch (Exception $e) {
        $reference = "error_random_bytes : " . $e;
    }
    $invoice->setReference("INV-" . $reference);
    $invoice->setDate(date('M dS, Y',time()));
    $invoice->setTime(date('h:i:s A',time()));
    $invoice->setFrom(array("Vendeur","Perfect Concierge","242 Rue du Faubourg Saint-Antoine","75012 Paris","France"));

    $database = new DatabaseManager();

    $req = $database->find('SELECT * FROM user where email=?', [$_SESSION['user']]);

    $customername = $req['last_name'] . " " . $req['first_name'];
    $address = $req['address'];
    $city = $req['zip'] . " " . $req['city'];
    $total = 0;

    $invoice->setTo(array("Acheteur",$customername,$address,$city,"France"));

    $service = $database->find('SELECT name,price FROM service WHERE id=?', [$_GET['item']]);

    $price = $service['price']*$_POST['inputQuantity'];

    $invoice->addItem($service['name'],$address,$_POST['inputQuantity'],0,$service['price'],0,$price);
    $invoice->addTotal("Total due",$price,true);
    $invoice->addBadge("Payé");
    $invoice->addTitle("Information importante");
    $invoice->addParagraph("Cet achat ne peut être remboursé");
    $invoice->setFooternote("Perfect Concierge");

    $filename = "Service_n.".$reference;
    $invoice->render('../../../ressources/invoices/'.$filename.'_'.$req['id'],'F');
    header('Location:../../account/account.php');
}
else header('Location:../purchase_service.php?&error='.$result);