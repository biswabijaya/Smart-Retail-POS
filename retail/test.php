<?php
$id='101691';
$redirect='purchases';
$cno='9090374605';

if ($redirect=='sales') {
	$cno='9090374605';

	$url  ='http://message.websoftservices.com/api/sendmultiplesms.php';
	$url .='?username=sandeepanaacademy';
	$url .='&password=makemysms@123';
	$url .='&sender=SFRESH';
	$url .='&mobile='.$cno.'';
	$url .='&type=1&product=1';
	$url .='&message=Thank%20You%20For%20Shopping%20With%20Shanti%20Fresh.%20Track%20Your%20Order:%20https://shantifresh.com/?id='.$id;

	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_URL => $url,
		 CURLOPT_USERAGENT => 'Sending Message'
	));

	 // Send the request & save response to $resp
	$data = curl_exec($curl);
	// Close request to clear up some resources
	curl_close($curl);
}

?>
