<?php
include('../includes/config.php');
if(!$connected) header("Location:../index.php");


include('../../utils/quote/pdfinvoice/src/InvoicePrinter.php');
$invoice = new \Konekt\PdfInvoice\InvoicePrinter();

try {
    $reference = bin2hex(random_bytes(5));
} catch (Exception $e) {
    $reference = "error_random_bytes : " . $e;
}

$invoice->setLogo("../../ressources/Logo.png");
$invoice->setColor("#ffc107");
$invoice->setType("Devis Perfect Concierge");
$invoice->setReference("INV-" . $reference);
$invoice->setDate(date('M dS, Y',time()));
$invoice->setTime(date('h:i:s A',time()));
$invoice->setDue(date('M dS, Y',strtotime('+3 months')));

$invoice->setFrom(array("Vendeur","Perfect Concierge","242 Rue du Faubourg Saint-Antoine","75012 Paris","France"));

$req = $database->find('SELECT * FROM user where email=?', [$_SESSION['user']]);

$customername = $req['last_name'] . " " . $req['first_name'];
$address = $req['address'];
$city = $req['city'];
$total = 0;

$invoice->setTo(array("Acheteur",$customername,$address,$city,"France"));


$req = $database->getPdo()->query('SELECT * FROM service');

foreach($req as $service) {
    if(!isset($_POST[$service['id']])){
        echo "<br> Erreur ID : " . $service['id'] . "<br>";
        exit();
    }
    if($_POST[$service['id']] != 0){
        $item = $service['name'];

        $description = "Fréquence de paiement : ";
        switch($service['flow_frequency_shape']){
            case 'hours' :
                $description .= " par heure";
                break;

            case 'day' :
                $description .= " par jours";
                break;

            default : $description .= $service['flow_frequency_shape'];
        }

        $quantity = $_POST[$service['id']];
        $vat = 0;
        $price = $service['price'];
        $discount = 0;
        $subtotal = $quantity * $price;

        $invoice->addItem($item, $description, $quantity, $vat, $price, $discount, $subtotal);

        $total += $subtotal;
    }
}

$invoice->addTotal("Total",$total,true);

$invoice->addBadge("Devis");

$invoice->addTitle("Information importante");

$invoice->addParagraph("Cette commande ne pourra être remboursée");

$invoice->setFooternote("Perfect Concierge");

$invoice->render('Devis n.' . $reference,'D');

header('Location:select_quote.php');