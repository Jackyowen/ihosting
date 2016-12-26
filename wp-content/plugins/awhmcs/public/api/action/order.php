<?php
	include '../whmcs.class.php';
	$data = json_decode(file_get_contents("php://input"));

	$whmcs = new WHMCS('http://127.0.0.1/whmcs2/includes/api.php', 'admin@mae-theme.com', 'bluwhale', '123123');
	
	$values["pid"] = array();
	$values["domain"] = array();
	$values["domaintype"] = array();
	// Get products 
	foreach($data->cart as $product){
		$values["pid"][] = $product->_id;
		if($product->domain){
			$values["domain"][] = $product->domain;
			$values["billingcycle"][] = $product->billingcycle;
			$values["domaintype"][] = 'register';			
		}

	}
	
	$values["clientid"] = $data->clientid;

	//$values["dnsmanagement"] = array("on");
	//$values["idprotection"] = array("on");
	//$values["billingcycle"] = array("msetupfee");
	$values["paymentmethod"] = "paypal";	
	
	//print_r($values);
	$order = $whmcs->addOrder($values);
	
	echo json_encode($order);