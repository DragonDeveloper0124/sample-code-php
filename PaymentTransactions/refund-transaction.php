<?php
  require 'vendor/autoload.php';
  use net\authorize\api\contract\v1 as AnetAPI;
  use net\authorize\api\controller as AnetController;
  define("AUTHORIZENET_LOG_FILE", "phplog");

  function refundTransaction($amount, $transactionid){
    // Common setup for API credentials
    $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
    $merchantAuthentication->setName("5KP3u95bQpv");
    $merchantAuthentication->setTransactionKey("4Ktq966gC55GAX7S");

    // Create the payment data for a credit card
    $creditCard = new AnetAPI\CreditCardType();
    $creditCard->setCardNumber( "4111111111111111" );
    $creditCard->setExpirationDate( "2038-12");
    $paymentOne = new AnetAPI\PaymentType();
    $paymentOne->setCreditCard($creditCard);
    //create a transaction
    $transactionRequestType = new AnetAPI\TransactionRequestType();
    $transactionRequestType->setTransactionType( "refundTransaction"); 
    $transactionRequestType->setAmount($amount);
    $transactionRequestType->setPayment($paymentOne);
    $request = new AnetAPI\CreateTransactionRequest();
    $request->setMerchantAuthentication($merchantAuthentication);
    $request->setRefId($transactionid);
    $request->setTransactionRequest( $transactionRequestType);
    $controller = new AnetController\CreateTransactionController($request);
    $response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::SANDBOX);
    if ($response != null)
    {
      $tresponse = $response->getTransactionResponse();
      if (($tresponse != null) && ($tresponse->getResponseCode()=="1") )   
      {
        echo "Refund SUCCESS: " . $tresponse->getTransId() . "\n";
      }
      else
      {
        echo  "Refund ERROR : " . $tresponse->getResponseCode() . "\n";
      }
      
    }
    else
    {
      echo  "Refund Null response returned";
    }
    return $response;
  }
  if(!defined(DONT_RUN_SAMPLES))
    refundTransaction();
?>
