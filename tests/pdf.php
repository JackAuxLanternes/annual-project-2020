<?php
include('../api/includes/config.php');
include('../utils/quote/pdfinvoice/src/InvoicePrinter.php');
$invoice = new \Konekt\PdfInvoice\InvoicePrinter();

$invoice->setLogo("Logo.png");
$invoice->setColor("#ffc107");
$invoice->setType("Devis Perfect Concierge");
try {
    $reference = bin2hex(random_bytes(5));
} catch (Exception $e) {
    $reference = "error_random_bytes : " . $e;
}
$invoice->setReference("INV-" . $reference);
$invoice->setDate(date('M dS, Y',time()));
$invoice->setTime(date('h:i:s A',time()));
$invoice->setFrom(array("Vendeur","Perfect Concierge","242 Rue du Faubourg Saint-Antoine","75012 Paris","France"));

$req = $database->find('SELECT * FROM user where email=?', [$_SESSION['user']]);

$customername = $req['last_name'] . " " . $req['first_name'];
$address = $req['address'];
$city = $req['zip'] . " " . $req['city'];
$total = 0;

$invoice->setTo(array("Acheteur",$customername,$address,$city,"France"));
$item = "Abonnement de base";
$price = 2400;

$invoice->addItem($item,"Valable 1 an",1,0,$price,0,$price);
$invoice->addTotal("Total due",$price,true);
$invoice->addBadge("Payé");
$invoice->addTitle("Information important");
$invoice->addParagraph("Votre abonnement ne peut être remboursé");
$invoice->setFooternote("Perfect Concierge");

$filename = "Abonnement_n.".$reference;
$invoice->render('../../../ressources/invoices/'.$filename.'_'.$_SESSION['user'],'I');
