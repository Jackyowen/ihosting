<?php 
	
	include '../whmcs.class.php';
	
	$data = json_decode(file_get_contents("php://input"));
	
	$whmcs = new WHMCS('http://127.0.0.1/whmcs2/includes/api.php', 'admin@mae-theme.com', 'bluwhale', '123123');
	
	$client = array("firstname"=>$data->firstname, "lastname"=>$data->lastname, "companyname"=>$data->companyname,  "address1"=>$data->address1, "address2"=>$data->address2, "city"=>$data->city, "state"=>$data->state, "postcode"=>$data->postcode, "country"=>$data->country, "phonenumber"=>$data->phonenumber);

	$client = $whmcs->updateClient($data->clientid,$client);
	
	echo json_encode($client);		
