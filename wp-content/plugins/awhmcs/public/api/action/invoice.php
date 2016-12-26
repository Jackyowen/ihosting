<?php 
	
	include '../whmcs.class.php';
	$data = json_decode(file_get_contents("php://input"));
	$datacheckout = array();

	$whmcs = new WHMCS('http://127.0.0.1/whmcs2/includes/api.php', 'admin@mae-theme.com', 'bluwhale', '123123');
	
	$invoice = $whmcs->getInvoice($data->id);
	
	$datacheckout['invoiceid'] = $invoice->invoiceid;
	$datacheckout['orderid'] = $data->id;
	$datacheckout['clientid'] = $invoice->userid;

	$checkout = $whmcs->checkout($datacheckout);	
	
	$invoice->payments = $whmcs->getPaymentmethods();
	
	$invoice->paymentform = $checkout;
	
	echo json_encode($invoice);