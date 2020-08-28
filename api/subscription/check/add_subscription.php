<?php
require '../../../vendor/autoload.php';
require_once '../../../utils/database/subscriptionmanager.php';
require_once '../../../utils/database/databasemanager.php';
include('../../../utils/quote/pdfinvoice/src/InvoicePrinter.php');
$invoice = new \Konekt\PdfInvoice\InvoicePrinter();

use Stripe\Charge;
use Stripe\Customer;
use Stripe\Stripe;
session_start();
Stripe::setApiKey('sk_test_51HK0YHKpVW5i0Eene7pCmhNLwbSshGEwzsq25vqX111jpp9KuwIJiq8qkNUGsLqgAxksEt2KsH6iRhF3KP7EbFDA00J8F1mMwh');
if($_POST){
    try {
        $token = $_POST['stripeToken'];
        $customer = Customer::create(array(
            "email" => $_SESSION['user'],
            "source" => $token,
        ));

        $amount = 0;

        switch ($_GET['item']){
            case 'base' :
                $amount = 240000;
                break;
            case 'familly' :
                $amount = 360000;
                break;
            case 'premium' :
                $amount = 600000;
                break;
            default: header('Location:../../index.php');
        }

        $charge = Charge::create(array(
            "amount" => $amount,
            "currency" => "eur",
            "customer" => $customer->id
        ));
    }
    catch (Exception $e) {
        echo $e->getMessage();
    }
    finally {
        $manager = new subscriptionmanager();
        $result = $manager->add($_SESSION['user'], $_GET['item']);

        $invoice->setLogo("../../../ressources/Logo.png");
        $invoice->setColor("#ffc107");
        $invoice->setType("Facture abonnement");
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

        $item = "";
        $price = "";

        switch ($_GET['item']){
            case 'base' :
                $item = "Abonnement de base";
                $price = 2400;
                break;
            case 'familly' :
                $item = "Abonnement familial";
                $price = 3600;
                break;
            case 'premium' :
                $item = "Abonnement premium";
                $price = 6000;
                break;
        }

        $invoice->addItem($item,"Valable 1 an",1,0,$price,0,$price);
        $invoice->addTotal("Total due",$price,true);
        $invoice->addBadge("Payé");
        $invoice->addTitle("Information important");
        $invoice->addParagraph("Votre abonnement ne peut être remboursé");
        $invoice->setFooternote("Perfect Concierge");

        $filename = "Abonnement_n.".$reference;
        $invoice->render('../../../ressources/invoices/'.$filename.'_'.$_SESSION['user'],'F');
        header('Location:../../account/account.php');
    }
}