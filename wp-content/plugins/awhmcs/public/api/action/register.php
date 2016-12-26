<?php 
	
	include '../whmcs.class.php';
	
	$data = json_decode(file_get_contents("php://input"));
	
	$whmcs = new WHMCS('http://127.0.0.1/whmcs2/includes/api.php', 'admin@mae-theme.com', 'bluwhale', '123123');
	
	$register = $whmcs->addClient($data);

	if($register->result == 'success'){
		$login = $whmcs->authenticate($data->email, $data->password2);
		if($login){
			$data->client = $whmcs->getClient(0, $data->email);
			$data->services = $whmcs->getServices($data->email);
			$data->groups = $whmcs->getGroups();
			$data->products = $whmcs->getProducts();
			//$data->announcements = $whmcs->getAnnouncements();
			//$data->tld = $whmcs->getDomainpricing();
			echo json_encode($data);		
		}		
	}else{
		echo $register;
	}