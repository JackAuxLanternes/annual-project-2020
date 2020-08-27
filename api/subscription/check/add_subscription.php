<?php
require '../../../vendor/autoload.php';
require_once '../../../utils/database/subscriptionmanager.php';

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
        header('Location:../../account/profile.php');
    }
}