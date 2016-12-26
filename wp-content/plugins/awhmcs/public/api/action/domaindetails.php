<?php 
	
	include '../whmcs.class.php';
	$data = json_decode(file_get_contents("php://input"));

	$whmcs = new WHMCS('http://127.0.0.1/whmcs2/includes/api.php', 'admin@mae-theme.com', 'bluwhale', '123123');
	
	$domain = $whmcs->getDomains($data->userid,$data->id);
	
	$domain->payments = $whmcs->getPaymentmethods();
	
	echo json_encode($domain);