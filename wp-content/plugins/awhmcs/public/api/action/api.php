<?php	
	include '../whmcs.class.php';		
	
	$data = json_decode(file_get_contents("php://input"));

	$whmcs = new WHMCS('http://127.0.0.1/whmcs2/includes/api.php', 'admin@mae-theme.com', 'bluwhale', '123123');
	
	if($data->action == 'announcements'){
		$result = $whmcs->getAnnouncements();	
	}
	
	if($data->action == 'loaddata'){
		
		// Get pricing	
		$extensions = $whmcs->getDomainpricing();

		foreach($extensions as $item){
			$result['extensions'][] = $item->tld;
			$result['pricing'][$item->tld]['domainregister'] = $whmcs->getPricing($item->tld,'domainregister')[0];
			$result['pricing'][$item->tld]['domaintransfer'] = $whmcs->getPricing($item->tld,'domaintransfer')[0];
		}
	}
	
	if($data->action == 'getproductgroups'){
	
		$payments = $whmcs->getGroups();	
		$result = $payments;		
	}			
	
	if($data->action == 'paymentmethods'){
	
		$payments = $whmcs->getPaymentmethods();	
		$result = $payments;		
	}	
	
	if($data->action == 'productpricing'){
	
		$pricing = $whmcs->getProductPricing($data->productid);	
		
		$result = $pricing;		
	}
	
	if($data->action == 'getrenewals'){
	
		$domains = $whmcs->getRenewals($data->uid);	
		
		$result = $domains;		
	}
		
	
	if($data->action == 'getdomainfree'){
	
		$domains = $whmcs->getDomainfree($data->productid);	
		
		$result = $domains;		
	}
	
	if($data->action == 'products'){
		
		// Get pricing	
		$products = $whmcs->getProducts();

		$result = $products;
	}	

	if($data->action == 'gettldpricing'){
		
		// Get pricing	
		$tldpricings = $whmcs->getTldpricing();

		$result = $tldpricings;
	}	

	if($data->action == 'getknow'){
		
		// Get Know	
		$result = $whmcs->getKnow();

	}	
	
	if($data->action == 'getpayment'){
		
		// Get Payment	
		$result = $whmcs->getPayment();

	}

	if($data->action == 'getconfig'){
		
		// Get Config	
		$result = $whmcs->getConfig();

	}

	if($data->action == 'getarknow'){
		
		// Get Know	
		$result = $whmcs->getArknow();

	}	

	if($data->action == 'getnetworks'){
		
		// Get Downloads	
		$result = $whmcs->getNetworks();

	}	

	if($data->action == 'getdownloads'){
		
		// Get Downloads	
		$result = $whmcs->getDownloads();

	}	
	
	if($data->action == 'getitemdownload'){
		
		// Get Item download	
		$result = $whmcs->getItemdownload();

	}	
	
	if($data->action == 'domaincheckertransfer'){
		
		$domain = $data->domain;
		
		$check  = $whmcs->checkDomain($domain);
		
		$check->domain = $domain;
		
		$result = $check;
	}	
	
	if($data->action == 'domaincheckerone'){
		
		$domain = $data->domain;
		
		//$check  = $whmcs->checkDomain($domain);
		

		
		$check->domain = $domain;
		
		$suggest = explode('.', $domain);
		
		$check->domain = $suggest[0];

		foreach($whmcs->getTldpricing() as $extension => $value){
			
			//if($suggest[1] != $extension){
				$suggest_domain = $suggest[0].$extension;
				
				$suggest_check[$extension]['status']  = $whmcs->checkDomain($suggest_domain);	
				$suggest_check[$extension]['price']	= $value->domainregister;
			//}	
					
		}

		
		$check->suggest = $suggest_check;			
		
		$result = $check;
	}	

	if($data->action == 'domainchecker'){
		
		$extensions = $data->extensions;

		foreach($extensions as $extension){
			
			// If is domain has not tld
			if (strrpos($data->domain, $extension) === false){
				
				$domain = $data->domain.$extension;
				$check->extension = $extension;
				
			}else{				
				$domain = $data->domain;
			}
			
			$check  = $whmcs->checkDomain($domain);
			$check->domain = $domain;
			$check->extension = $extension;			
			
			$result[] = $check;
			
			break;			
		}
	}
	
	if($data->action == 'domaintransfer'){
		
		$domain = $data->domain;

		$check  = $whmcs->transferDomain($domain);	
		
		$check->domain = $domain;
		
			
/*
		if($check->result == "success"){
			$check->pricing = $whmcs->getPricing($data->extension,'domaintransfer')[0];
		}	
*/
		
		$result = $check;			
	}
	
	if($data->action == 'addons'){
		$check  = $whmcs->getClientaddons($data->clientid);	
		
		$result = $check;			
	}

	if($data->action == 'producesaddons'){
		$check  = $whmcs->getProducesaddons($data->clientid);	
		
		$result = $check;			
	}

	if($data->action == 'domainrenew'){

		$check  = $whmcs->domainRenew($data->domain, $data->$domainid);	
		
		$result = $check;			
	}

	if($data->action == 'getquote'){
		$check  = $whmcs->getQuotes($data->clientid);	
		
		$result = $check;			
	}

	if($data->action == 'gettickets'){
		$check  = $whmcs->getTickets($data->clientid);	
		
		$result = $check;			
	}

	if($data->action == 'getticket'){
		$check  = $whmcs->getTicket($data->ticketid);	
		
		$result = $check;			
	}

	if($data->action == 'getclientsdomains'){
		$check  = $whmcs->getDomains($data->clientid, $data->domainid, '', $data->start, $data->limit);	
		$result = $check;			
	}

	if($data->action == 'getservices'){
		$check  = $whmcs->getServices($data->clientid, 0, '', 0, '', $data->start, $data->limit);	 
		$result = $check;			
	}

	if($data->action == 'getinvoices'){
		$check  = $whmcs->getInvoices($data->userid, '', $data->start, $data->limit);	
		$result = $check;			
	}

	if($data->action == 'getclient'){
		$check  = $whmcs->getClient($data->userid,$data->email);	
		$result = $check;			
	}

	if($data->action == 'getinvoicesitem'){
		$check  = $whmcs->getInvoicesitem($data->userid, '', $data->start, $data->limit);	
		$result = $check;			
	}
	
	if($data->action == 'updateinvoice'){
		$check  = $whmcs->updateInvoice($data->invoiceid);	
		$result = $check;			
	}
	
	if($data->action == 'resetpwd'){
		$check  = $whmcs->resetpwd($data->email, $data->key, $data->password1, $data->password2);	
		$result = $check;			
	}		

	if($data->action == 'getinvoice'){
		$check  = $whmcs->getInvoice($data->invoicesid);	
		$result = $check;			
	}

	if($data->action == 'domaincheckerblock'){		

		$domain = $data->domain;
		
		$tld = explode('.', $domain);
		
		$extension = '.'.$tld[1];
		
		$check  = $whmcs->checkDomain($domain);
		
		$check->domain = $domain;
		
		$result = $check;
	}	
	
	if($data->action == 'domaintransfer'){		

		$domain = $data->domain;
		
		$check  = $whmcs->transferDomain($domain);
		
		$check->domain = $domain;
		
		$result = $check;
	}	
	if($data->action == 'getdepartments'){
		$result = $whmcs->getDepartments();
	}	

	if($data->action == 'extensions'){
		$result = $whmcs->getDomainpricing();
	}
	
	if($data->action == 'instant'){		
	  
	  if(isset($data->domain)){ 
		  
		$domain = $data->domain; 
	    $location = 'https://instantdomainsearch.com/services/all/'.$data->domain.'?tldTags=popular&partTld='.$data->tld.'&country=&city=';   
	    
	    $extensions = array();
	    $priceTld = $whmcs->getTldpricing();
	    foreach($whmcs->getDomainpricing() as $row){
		    $extensions[] = str_replace('.','',$row->tld);
	    } 
	       
	    $session = curl_init($location);  
	    curl_setopt($session, CURLOPT_RETURNTRANSFER, 1);  
	    $json = curl_exec($session);  
	    
	    $json_content = preg_split("/\\r\\n|\\r|\\n/",$json);
	    
	    //$json_text = '{';
	    $dataJson = array();
	    $i = 0;
	    foreach($json_content as $data){
		    
			if (strpos($data, $domain) !== false ) {
			    $jsonD = json_decode($data);
				
			    foreach($jsonD as $key => $value){

				   $dataJson[$i][$key] = $value;

				   if($key == 'tld' && in_array($value, $extensions)){
					   $dataJson[$i]['enable'] = 1;
					   $tld = '.'.$value;
					   foreach($priceTld as $pkey => $pvalue){
						   if($pkey == $tld){
							   $dataJson[$i]['rprice'] = $pvalue->domainregister;
							   $dataJson[$i]['tprice'] = $pvalue->domaintransfer;
						   }
					   }
				   }
			    }
	
			    $i++;
			}
			
	    } 
	    $result['data'] = $dataJson;
	    

	  } 
	  		
	}	
	
	if($data->action == 'addOrder'){
		
		$domain = array();
		
		if($data->registerd){
			$values["clientid"] = $data->registerd->client->id;
		}else{
			$register = $whmcs->addClient($data->register);	

			if($register->result == 'success'){
				
				$login = $whmcs->authenticate($data->register->email, $data->register->password2);	
				
				$client = $whmcs->getClient(0, $data->register->email);
				
				if($client->result == 'success')
					$result['data']['client'] = $client->client;
				
				//if($login){
					$values["clientid"] = $register->clientid;
				//}
			}else{
				$result['error'] = $register;
			}
		}
		
		// Add order
		$values["pid"] = array();
		$values["domain"] = array();
		$values["domaintype"] = array();
		
		// Get products 
		foreach($data->products as $product){

			// Get product id
			if($product->_data[0]->id){
				$values["pid"][] = $product->_data[0]->id;
				
				$values["billingcycle"][] = $product->_data[0]->time;
				
				if($product->_data[0]->domain->name != ''){
					$values["domain"][] = $product->_data[0]->domain[0]->name;
					
					$values["domaintype"][] = str_replace('domain','',$product->_data[0]->type);
					$values['regperiod'][] = $product->_data[0]->time;
				}				
			}else{
				$values['domain'][] = $product->_id;
				$values['domaintype'][] = str_replace('domain','',$product->_data[0]->type);
				$values['regperiod'][] = $product->_data[0]->time;
			}
			
		};		
	
		$values["paymentmethod"] = $data->paymentmethod;	
		
		// Add product
		$order = $whmcs->addOrder($values);
		
		// Add domains
		
		$result['rs'] = $order;
		
		if($order->invoiceid){ 
			
			$datacheckout['invoiceid'] = $order->invoiceid;
			$datacheckout['orderid'] = $order->orderid;
			$datacheckout['clientid'] = $values["clientid"];

			$checkout = $whmcs->checkout($datacheckout);
			
		}
		
		$result['data'] = $values;
		$result['order'] = $checkout;	
				
	}
	
	echo json_encode($result);