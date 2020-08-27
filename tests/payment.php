<?php
require '../vendor/autoload.php';
use Stripe\Charge;
use Stripe\Customer;
use Stripe\Stripe;
Stripe::setApiKey('sk_test_51HK0YHKpVW5i0Eene7pCmhNLwbSshGEwzsq25vqX111jpp9KuwIJiq8qkNUGsLqgAxksEt2KsH6iRhF3KP7EbFDA00J8F1mMwh');
if($_POST){
    try {
        $token = $_POST['stripeToken'];
        echo $token;
        // Create a Customer
        $customer = Customer::create(array(
            "email" => 'qrouville@gmail.com',
            "source" => $token,
        ));
        $charge = Charge::create(array(
            "amount" => 1000,
            "currency" => "eur",
            "customer" => $customer->id
        ));
        $success = 'Your payment was successful.';
    }
    catch (Exception $e) {
        $error = $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!--<meta http-equiv="Content-type" content="text/html; charset=utf-8" />-->
    <title>Stripe Getting Started Form</title>
    <!-- jQuery is used only for this example; it isn't required to use Stripe -->
    <!--<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>-->

</head>
<body>
<h1>Charge $10 with Stripe</h1>
<!-- to display errors returned by createToken -->
<span class="payment-errors"><?php if(isset($error)) echo $error; ?></span>
<span class="payment-success"><?php if(isset($success)) echo $success; ?></span>
<form action="" method="POST" id="payment-form">
    <div id="card-element"></div>
    <button type="submit" class="submit-button">Submit Payment</button>
</form>
<script src="https://js.stripe.com/v3/"></script>
<script type="text/javascript">
    // Stripe API Key
    var stripe = Stripe('pk_test_51HK0YHKpVW5i0Eena5Y8atVXHhyhdoknAA5XyrR648TeI0EdKUk2XpPiQACxpMe0Vp1mfSYJe1f6o05awvt1nbMQ00o7bGJSFx');
    var elements = stripe.elements();
    // Custom Styling
    var style = {
        base: {
            color: '#32325d',
            lineHeight: '24px',
            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
            fontSmoothing: 'antialiased',
            fontSize: '16px',
            '::placeholder': {
                color: '#aab7c4'
            }
        },
        invalid: {
            color: '#fa755a',
            iconColor: '#fa755a'
        }
    };
    // Create an instance of the card Element
    var card = elements.create('card', {style: style});
    // Add an instance of the card Element into the `card-element` <div>
    card.mount('#card-element');
    // Handle real-time validation errors from the card Element.
    card.addEventListener('change', function(event) {
        var displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });
    // Handle form submission
    var form = document.getElementById('payment-form');
    form.addEventListener('submit', function(event) {
        event.preventDefault();
        stripe.createToken(card).then(function(result) {
            if (result.error) {
                // Inform the user if there was an error
                var errorElement = document.getElementById('card-errors');
                errorElement.textContent = result.error.message;
            } else {
                stripeTokenHandler(result.token);
            }
        });
    });
    // Send Stripe Token to Server
    function stripeTokenHandler(token) {
        // Insert the token ID into the form so it gets submitted to the server
        var form = document.getElementById('payment-form');
// Add Stripe Token to hidden input
        var hiddenInput = document.createElement('input');
        hiddenInput.setAttribute('type', 'hidden');
        hiddenInput.setAttribute('name', 'stripeToken');
        hiddenInput.setAttribute('value', token.id);
        form.appendChild(hiddenInput);
// Submit form
        form.submit();
    }
</script>
</body>
</html>