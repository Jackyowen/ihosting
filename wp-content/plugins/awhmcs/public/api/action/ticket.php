<?php 
	
	include '../whmcs.class.php';
	
	$data = json_decode(file_get_contents("php://input"));
	
	$whmcs = new WHMCS('http://127.0.0.1/whmcs2/includes/api.php', 'admin@mae-theme.com', 'bluwhale', '123123');
	
	$ticket = $whmcs->openNewTicket($data);
	
	echo json_encode($ticket);		
