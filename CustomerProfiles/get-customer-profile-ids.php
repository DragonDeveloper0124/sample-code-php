<?php
  require 'vendor/autoload.php';
  use net\authorize\api\contract\v1 as AnetAPI;
  use net\authorize\api\controller as AnetController;
  function getCustomerProfileIds()
  {
    // Common setup for API credentials
    $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
    $merchantAuthentication->setName("5KP3u95bQpv");
    $merchantAuthentication->setTransactionKey("4Ktq966gC55GAX7S");
    $refId = 'ref' . time();

    // Get all existing customer profile ID's
    $request = new AnetAPI\GetCustomerProfileIdsRequest();
    $request->setMerchantAuthentication($merchantAuthentication);
    $controller = new AnetController\GetCustomerProfileIdsController($request);
    $response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::SANDBOX);
    if (($response != null) && ($response->getMessages()->getResultCode() == "Ok") )
    {
        echo "GetCustomerProfileId's SUCCESS: " . "\n";
        $profileIds[] = $response->getIds();
        echo "There are " . count($profileIds[0]) . " Customer Profile ID's for this Merchant Name and Transaction Key" . "\n";
     }
    else
    {
        echo "GetCustomerProfileId's ERROR :  Invalid response\n";
        echo "Response : " . $response->getMessages()->getMessage()[0]->getCode() . "  " .$response->getMessages()->getMessage()[0]->getText() . "\n";
    }
    return $response;
  }
  if(!defined(DONT_RUN_SAMPLES))
      getCustomerProfileIds();
?>
