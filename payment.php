<?php

// Ref : https://github.com/paypal/PayPal-PHP-SDK/wiki/Samples

// Use below for direct download installation
require __DIR__  . '/PayPal-PHP-SDK/autoload.php';

// After Step 1
$apiContext = new \PayPal\Rest\ApiContext(
    new \PayPal\Auth\OAuthTokenCredential(
        'AUf1PW0ludGEJEeenc8NMoHZpOxabtprkQpmoPOOAkiap5pTvz0sK22flWT8dmMvzmxnFY-B7CUQUegD',     // ClientID
        'EAM9PtXKknDzn3ApOPUVGWEdXveclRf4IjGBglrbGNehdjKbzcMwrs9NNtxx7SDNcvh2wo0VxZoVufHb'      // ClientSecret
    )
);

// After Step 2
$payer = new \PayPal\Api\Payer();
$payer->setPaymentMethod('paypal');

$amount = new \PayPal\Api\Amount();
$amount->setTotal('150.00');
$amount->setCurrency('USD');

$transaction = new \PayPal\Api\Transaction();
$transaction->setAmount($amount);

$redirectUrls = new \PayPal\Api\RedirectUrls();
$redirectUrls->setReturnUrl("http://localhost/php-paypal/success.html")
    ->setCancelUrl("http://localhost/php-paypal/cancel.html");

$payment = new \PayPal\Api\Payment();
$payment->setIntent('sale')
    ->setPayer($payer)
    ->setTransactions(array($transaction))
    ->setRedirectUrls($redirectUrls);


// After Step 3
try {
    $payment->create($apiContext);
    header('Location: '.$payment->getApprovalLink());
}
catch (\PayPal\Exception\PayPalConnectionException $ex) {
    // This will print the detailed information on the exception.
    //REALLY HELPFUL FOR DEBUGGING
    echo $ex->getData();
}

