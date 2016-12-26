<?php 
	
	include '../whmcs.class.php';
	$data = json_decode(file_get_contents("php://input"));

	$whmcs = new WHMCS('http://127.0.0.1/whmcs2/includes/api.php', 'admin@mae-theme.com', 'bluwhale', '123123');
	
	$login = $whmcs->authenticate($data->clientEmail, $data->password);

	if($login){
		$data->client = $whmcs->getClient(0, $data->clientEmail);
		$data->services = $whmcs->getServices($data->clientEmail);
		//$data->contacts = $whmcs->getContacts($data->clientEmail);
		//$data->groups = $whmcs->getGroups();
		//$data->products = $whmcs->getProducts();
		//$data->announcements = $whmcs->getAnnouncements();
		//$data->tld = $whmcs->getDomainpricing();
		
		echo json_encode($data);		
	}
