<?php
include('../utils/quote/pdfinvoice/src/InvoicePrinter.php');
$invoice = new \Konekt\PdfInvoice\InvoicePrinter();
/* Header Settings */
$invoice->setLogo("Logo.png");
$invoice->setColor("#007fff");
$invoice->setType("Sale Invoice");
$invoice->setReference("INV-55033645");
$invoice->setDate(date('M dS ,Y',time()));
$invoice->setTime(date('h:i:s A',time()));
$invoice->setDue(date('M dS ,Y',strtotime('+3 months')));
$invoice->setFrom(array("Seller Name","Perfect Concierge","242 Rue du Faubourg Saint-Antoine","75012 Paris","France"));
$invoice->setTo(array("Purchaser Name","Sample Company Name","128 AA Juanita Ave","Glendora , CA 91740","United States of America"));
/* Adding Items in table */
$invoice->addItem("Ménage","",6,0,580,0,3480);
$invoice->addItem("Papiers administratifs","Au moins 20 papier ",4,0,645,0,2580);
$invoice->addItem('LG 18.5" WLCD',"",10,0,230,0,2300);
$invoice->addItem("HP LaserJet 5200","",1,0,1100,0,1100);
/* Add totals */
$invoice->addTotal("Total",9460);
$invoice->addTotal("VAT 21%",1986.6);
$invoice->addTotal("Total due",11446.6,true);
/* Set badge */
$invoice->addBadge("Devis");
/* Add title */
$invoice->addTitle("Important Notice");
/* Add Paragraph */
$invoice->addParagraph("No item will be replaced or refunded if you don't have the invoice with you. You can refund within 2 days of purchase.");
/* Set footer note */
$invoice->setFooternote("Perfect Concierge");
/* Render */
$invoice->render('Devis n°','I'); /* I => Display on browser, D => Force Download, F => local path save, S => return document path */
?>
