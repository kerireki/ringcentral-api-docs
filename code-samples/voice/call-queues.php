<?php
/* You get the environment parameters from your 
   application dashbord in your developer account 
   https://developers.ringcentral.com */
   
require('vendor/autoload.php');
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$rcsdk = new RingCentral\SDK\SDK( $_ENV['RC_CLIENT_ID'],
                                  $_ENV['RC_CLIENT_SECRET'],
                                  $_ENV['RC_SERVER_URL'] );
$platform = $rcsdk->platform();
$platform->login( [ "jwt" => $_ENV['RC_JWT'] ] );

$resp = $platform->get('/account/~/call-queues');
foreach ($resp->json()->records as $group){
    if ($group->name == "Support Department"){
	$params = array(
	  'addedExtensionIds' => array("888888888", "999999999")
	  );
	$resp = $platform->post('/account/~/call-queues/'.$group->id.'/bulk-assign', $params);
	print_r($resp->response());
	break;
    }
}
?>