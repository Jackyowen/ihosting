var app = angular.module('MyApp',['ngMaterial', 'ngRoute', 'ngMessages', 'LocalStorageModule', 'bw.paging', 'ngCart']);
app.factory('WHMCS', function($rootScope, $http, localStorageService){
	
	var factory = {};
	var data = localStorageService.get('data');
	$rootScope.checklogin = localStorageService.get('data');
	// Before load
	factory._init = function(idPage){
		
		// Set current page id
		$rootScope.$emit('cpage', idPage);		
	}
	
	// Get default domain price
	factory.getDomainPricing = function(domain, action){
		
		var domain = domain.split('.');
		var extension = '.'+domain[1];

		var pricing = this.data('pricing')[extension][action];		
		
		return pricing;
	}
	
	// Get Renewals
	factory.getRenewals = function(uid){

		var dataJson = {};

		// Data for paging
		dataJson.action = 'getrenewals';
		dataJson.uid = uid;

		var req = {
            method: 'POST',
            url: awhmcs.plugin_url+'action/api.php',
            headers : {'Content-Type': 'application/json' },
            data: dataJson
        }
        	
        return $http(req).then(function(response){
        	return response.data;
        });						
	}	
	
	// Get product pricing
	factory.getProductPricing = function(item){

		var req = {
            method: 'POST',
            url: awhmcs.plugin_url+'action/api.php',
            headers : {'Content-Type': 'application/json' },
            data: { action: 'productpricing', productid: item._data[0].id }
        }
        
        return $http(req).then(function(response){
			return response.data;
        });

	}
	
	// Get product pricing
	factory.resetpwd = function(email, key, password1, password2){

		var req = {
            method: 'POST',
            url: awhmcs.plugin_url+'action/api.php',
            headers : {'Content-Type': 'application/json' },
            data: { action: 'resetpwd', email: email, key: key, password1: password1, password2: password2 }
        }
        
        return $http(req).then(function(response){
			return response.data;
        });

	}		
	
	// Get product pricing
	factory.getTldpricing = function(){

		var req = {
            method: 'POST',
            url: awhmcs.plugin_url+'action/api.php',
            headers : {'Content-Type': 'application/json' },
            data: { action: 'gettldpricing'}
        }
        
        return $http(req).then(function(response){
			return response.data;
        });

	}

	// Get data breadcrums
	factory.getBreadcrumbs = function(router, current){
		
		// Get parent breadcrums
		var breadcrumbs = [];
		var currentRouter = router.current.$$route;
		var parent = {};
		
		if(currentRouter.parent){
			parent.url = currentRouter.parent;
			parent.title = currentRouter.parent.replace('/', '');
			breadcrumbs.push(parent);			
		}

		// Set current 
		breadcrumbs.push({'title': current, 'active': 1 });

		return breadcrumbs;
	}	
	
	// Get storage data
	factory.data = function(key){
		var data = '';
		
		if(localStorageService.get(key)){
			data = localStorageService.get(key);
		}
		
		return data;
	}
	
	// Set storage data
	factory.set = function(key, data){
		return localStorageService.set(key, data);
	}
	
	//add order
	factory.getPayment = function(invoiceid, orderid, clientid){
		
		var order = {};
		
		order.invoiceid = invoiceid;
		order.orderid = orderid;
		order.clientid = clientid;
		order.action = 'getPayment';
		
        var dataJson  =  JSON.stringify(order);

        var req = {
            method: 'POST',
            url: awhmcs.plugin_url+'action/api.php',
            headers : {'Content-Type': 'application/json' },
            data: dataJson,
            cache: false
        }

        return $http(req).then(function(response){
			return response.data;
        });			
	}	
	
	//add order
	factory.addOrder = function(products, data, datalogin, paymentmethod){
		
		var order = {};
		
		order.register = data;
		order.registerd = datalogin;
		order.products = products;
		order.action = 'addOrder';
		order.paymentmethod = paymentmethod;
		
        var dataJson  =  JSON.stringify(order);

        var req = {
            method: 'POST',
            url: awhmcs.plugin_url+'action/api.php',
            headers : {'Content-Type': 'application/json' },
            data: dataJson,
            cache: false
        }

        return $http(req).then(function(response){
			return response.data;
        });			
	}	
	
	// Get default price
	factory.getDomainPrice = function(domain, action){
		var domain = domain.split('.');
		var extension = '.'+domain[1];
		var data = this.data('pricing');
		
		var price = data[extension][action][1]['price'];		

		return price;
	}
	
	// Get domain default billing cycle
	factory.getDomainTime = function(domain, action){
		
		var domain = domain.split('.');
		var extension = '.'+domain[1];

		var time = this.data('pricing')['.com'][action][1];		

		return time;
	}	
	
	// Update invoice
	factory.updateinvoice = function(id){
		var req = {
            method: 'POST',
            url: awhmcs.plugin_url+'action/api.php',
            headers : {'Content-Type': 'application/json' },
            data: { action: 'updateinvoice', invoiceid: id}
        }
        
        return $http(req).then(function(response){
			return response.data;
        });
	}	
	
	// Get products
	factory.getDomainfree = function(id){
		var req = {
            method: 'POST',
            url: awhmcs.plugin_url+'action/api.php',
            headers : {'Content-Type': 'application/json' },
            data: { action: 'getdomainfree', productid: id }
        }
        
        return $http(req).then(function(response){
			return response.data;
        });
	}	
	
	// Get products
	factory.getProducts = function(){
		var req = {
            method: 'POST',
            url: awhmcs.plugin_url+'action/api.php',
            headers : {'Content-Type': 'application/json' },
            data: { action: 'products' }
        }
        
        return $http(req).then(function(response){
			return response.data;
        });
	}

	// Get Client
	factory.getClient = function(userid,email){

		var dataJson = {};
		dataJson.action = 'getclient';
		dataJson.userid = userid;
		dataJson.email = email;

		var req = {
            method: 'POST',
            url: awhmcs.plugin_url+'action/api.php',
            headers : {'Content-Type': 'application/json' },
            data: dataJson
        }
        
        return $http(req).then(function(response){
			return response.data;
        });
	}
		
	// Get contacts
	factory.getContacts = function(emai){
		var req = {
            method: 'POST',
            url: awhmcs.plugin_url+'action/getcontacts.php',
            headers : {'Content-Type': 'application/json' },
            data: {emai: emai}
        }
        
        return $http(req).then(function(response){
			return response.data;
        });
	}
	
	// Get paymentmethods
	factory.getPaymentmethods = function(){
		var req = {
            method: 'POST',
            url: awhmcs.plugin_url+'action/api.php',
            headers : {'Content-Type': 'application/json' },
            data: {action: 'paymentmethods'}
        }
        
        return $http(req).then(function(response){
	        if(response.data.result == 'success'){
		    	return response.data.paymentmethods.paymentmethod;    
	        }else{
		        return response.data;
	        }
			
        });
	}	
	
	// Get extensions
	factory.getExtensions = function(){
		var req = {
            method: 'POST',
            url: awhmcs.plugin_url+'action/api.php',
            headers : {'Content-Type': 'application/json' },
            data: { action: 'extensions' }
        }
        	

        return $http(req).then(function(response){
            return response.data;  
        });					
	}

	factory.getDepartments = function(){
		var req = {
            method: 'POST',
            url: awhmcs.plugin_url+'action/api.php',
            headers : {'Content-Type': 'application/json' },
            data: { action: 'getdepartments' }
        }
        	

        return $http(req).then(function(response){
            return response.data;  
        });					
	}
	
	// Get annoutcements
	factory.getNews = function(){
		var req = {
            method: 'POST',
            url: awhmcs.plugin_url+'action/api.php',
            headers : {'Content-Type': 'application/json' },
            data: { action: 'announcements' }
        }
        	

        return $http(req).then(function(response){
            if(response.data.result == 'success'){
	        	return response.data.announcements.announcement;   				        	
            }else{
	            console.log('ERROR');
            }  
        });						
	}

	// Get Know
	factory.getKnow = function(){
		var req = {
            method: 'POST',
            url: awhmcs.plugin_url+'action/api.php',
            headers : {'Content-Type': 'application/json' },
            data: { action: 'getknow' }
        }
        	
        return $http(req).then(function(response){
            if(response.data.result == 'success'){
	        	return response.data;   				        	
            }else{
	            console.log('ERROR');
            }  
        });						
	}

	// Get Payment
	factory.getPayment = function(){
		var req = {
            method: 'POST',
            url: awhmcs.plugin_url+'action/api.php',
            headers : {'Content-Type': 'application/json' },
            data: { action: 'getpayment' }
        }
        	
        return $http(req).then(function(response){
            if(response.data.result == 'success'){
	        	return response.data;   				        	
            }else{
	            console.log('ERROR');
            }  
        });						
	}

	// Get Config
	factory.getConfig = function(){
		var req = {
            method: 'POST',
            url: awhmcs.plugin_url+'action/api.php',
            headers : {'Content-Type': 'application/json' },
            data: { action: 'getconfig' }
        }
        	
        return $http(req).then(function(response){
            if(response.data.result == 'success'){
	        	return response.data;   				        	
            }else{
	            console.log('ERROR');
            }  
        });						
	}

	// Get Know
	factory.getArknow = function(){
		var req = {
            method: 'POST',
            url: awhmcs.plugin_url+'action/api.php',
            headers : {'Content-Type': 'application/json' },
            data: { action: 'getarknow' }
        }
        	
        return $http(req).then(function(response){
            if(response.data.result == 'success'){
	        	return response.data;   				        	
            }else{
	            console.log('ERROR');
            }  
        });						
	}

	// Get Networks
	factory.getNetworks = function(){
		var req = {
            method: 'POST',
            url: awhmcs.plugin_url+'action/api.php',
            headers : {'Content-Type': 'application/json' },
            data: { action: 'getnetworks' }
        }
        	
        return $http(req).then(function(response){
            if(response.data.result == 'success'){
	        	return response.data;   				        	
            }else{
	            console.log('ERROR');
            }  
        });						
	}

	// Get Downloads
	factory.getDownloads = function(){
		var req = {
            method: 'POST',
            url: awhmcs.plugin_url+'action/api.php',
            headers : {'Content-Type': 'application/json' },
            data: { action: 'getdownloads' }
        }
        	
        return $http(req).then(function(response){
            if(response.data.result == 'success'){
	        	return response.data;   				        	
            }else{
	            console.log('ERROR');
            }  
        });						
	}

	// Get Item download
	factory.getItemdownload = function(){
		var req = {
            method: 'POST',
            url: awhmcs.plugin_url+'action/api.php',
            headers : {'Content-Type': 'application/json' },
            data: { action: 'getitemdownload' }
        }
        	
        return $http(req).then(function(response){
            if(response.data.result == 'success'){
	        	return response.data;   				        	
            }else{
	            console.log('ERROR');
            }  
        });						
	}

	// Get addons
	factory.getAddons = function(clientid){
		var req = {
            method: 'POST',
            url: awhmcs.plugin_url+'action/api.php',
            headers : {'Content-Type': 'application/json' },
            data: { action: 'addons',clientid : clientid }
        }
        	
        return $http(req).then(function(response){
        	return response.data.addons.addon;
        });						
	}

	// Get Producesaddons
	factory.getProducesaddons = function(clientid){
		var req = {
            method: 'POST',
            url: awhmcs.plugin_url+'action/api.php',
            headers : {'Content-Type': 'application/json' },
            data: { action: 'producesaddons',clientid : clientid }
        }
        	
        return $http(req).then(function(response){
        	return response.data;
        });						
	}


	// Get addons
	factory.domainRenew = function(domain, domainid){

		var dataJson = {};

		// Data for paging
		dataJson.action = 'domainrenew';
		dataJson.domain = domain;
		dataJson.domainid = domainid;


		var req = {
            method: 'POST',
            url: awhmcs.plugin_url+'action/api.php',
            headers : {'Content-Type': 'application/json' },
            data: dataJson
        }
        	
        return $http(req).then(function(response){
        	return response.data;
        });						
	}
	
	// Get Products Groups
	factory.getProductGroups = function(){
		var req = {
            method: 'POST',
            url: awhmcs.plugin_url+'action/api.php',
            headers : {'Content-Type': 'application/json' },
            data: { action: 'getproductgroups'}
        }
        	
        return $http(req).then(function(response){
        	return response.data;
        });						
	}	

	// Get getTickets
	factory.getTickets = function(){
		var req = {
            method: 'POST',
            url: awhmcs.plugin_url+'action/api.php',
            headers : {'Content-Type': 'application/json' },
            data: { action: 'gettickets'}
        }
        	
        return $http(req).then(function(response){
        	return response.data;
        });						
	}

	// Get getTicket
	factory.getTicket = function(ticketid){
		var req = {
            method: 'POST',
            url: awhmcs.plugin_url+'action/api.php',
            headers : {'Content-Type': 'application/json' },
            data: { action: 'getticket',ticketid : ticketid}
        }
        	
        return $http(req).then(function(response){
        	return response.data;
        });						
	}

	// get Quotes
	factory.getQuotes = function(clientid){
		var req = {
            method: 'POST',
            url: awhmcs.plugin_url+'action/api.php',
            headers : {'Content-Type': 'application/json' },
            data: { action: 'getquote',clientid : clientid }
        }
        	
        return $http(req).then(function(response){
        	return response.data.quotes.quote;
        });						
	}
	
	// Get Invoices
	factory.getInvoices = function(invoicesid, page, size){

		var dataJson = {};

		// Data for paging
		dataJson.action = 'getinvoices';
		dataJson.userid = invoicesid;
		dataJson.start = (page-1)*size
		dataJson.limit = size;

		var req = {
            method: 'POST',
            url: awhmcs.plugin_url+'action/api.php',
            headers : {'Content-Type': 'application/json' },
            data: dataJson
        }
        	
        return $http(req).then(function(response){
        	return response.data;
        });						
	}

	// Get Invoices
	factory.getInvoicesitem = function(invoicesid){

		var dataJson = {};

		// Data for paging
		dataJson.action = 'getinvoicesitem';
		dataJson.userid = invoicesid;
		
		var req = {
            method: 'POST',
            url: awhmcs.plugin_url+'action/api.php',
            headers : {'Content-Type': 'application/json' },
            data: dataJson
        }
        	
        return $http(req).then(function(response){
        	return response.data;
        });						
	}


	factory.getInvoice = function(invoicesid){

		var dataJson = {};

		// Data for paging

		var req = {
            method: 'POST',
            url: awhmcs.plugin_url+'action/api.php',
            headers : {'Content-Type': 'application/json' },
            data: {action: 'getinvoice', invoicesid : invoicesid}
        }
        	
        return $http(req).then(function(response){
        	return response.data;
        });						
	}

	// Get Domain
	factory.getDomains = function(clientid, page, size){

		var dataJson = {};

		// Data for paging
		dataJson.action = 'getclientsdomains';
		dataJson.clientid = clientid;
		dataJson.start = (page-1)*size
		dataJson.limit = size;

		var req = {
            method: 'POST',
            url: awhmcs.plugin_url+'action/api.php',
            headers : {'Content-Type': 'application/json' },
            data: dataJson
        }
        	
        return $http(req).then(function(response){
        	return response.data;
        });						
	}

	// Get Services
	factory.getServices = function(clientid, page, size){

		var dataJson = {};

		// Data for paging
		dataJson.action = 'getservices';
		dataJson.clientid = clientid;
		dataJson.start = (page-1)*size
		dataJson.limit = size;

		var req = {
            method: 'POST',
            url: awhmcs.plugin_url+'action/api.php',
            headers : {'Content-Type': 'application/json' },
            data: dataJson
        }
        	
        return $http(req).then(function(response){
        	return response.data;
        });						
	}

	// Check transfer
	factory.checktransfer = function(domain,extension, action){
	
		var dataJson = {};
		
		dataJson.domain = domain+extension;
		dataJson.extension = extension;
		dataJson.action = action;
		
		dataJson = JSON.stringify(dataJson);
		
        var req = {
            method: 'POST',
            url: awhmcs.plugin_url+'action/api.php',
            headers : {'Content-Type': 'application/json' },
            data: dataJson
        }	
        
        return $http(req).then(function(response){   
            return response.data;
        });							
	}				
	
	// Check domain
	factory.domainchecker = function(domain, action, tld){
	
		var dataJson = {};
		
		dataJson.domain = domain;
		dataJson.extension = 'domainregister';
		dataJson.action = action;
		dataJson.extensions = tld;
		
		dataJson = JSON.stringify(dataJson);
		
        var req = {
            method: 'POST',
            url: awhmcs.plugin_url+'action/api.php',
            headers : {'Content-Type': 'application/json' },
            data: dataJson
        }	
        
        return $http(req).then(function(response){   
            return response.data;
        });							
	}
	
	// Check domain
	factory.domaintransfer = function(domain, action){
	
		var dataJson = {};
		
		dataJson.domain = domain;
		dataJson.action = action;
		
		dataJson = JSON.stringify(dataJson);
		
        var req = {
            method: 'POST',
            url: awhmcs.plugin_url+'action/api.php',
            headers : {'Content-Type': 'application/json' },
            data: dataJson
        }	
        
        return $http(req).then(function(response){   
            return response.data;
        });							
	}	
	
	// Check domain
	factory.loaddata = function(){
	
		var dataJson = {};
		
		dataJson.action = 'loaddata';
		
		dataJson = JSON.stringify(dataJson);
		
        var req = {
            method: 'POST',
            url: awhmcs.plugin_url+'action/api.php',
            headers : {'Content-Type': 'application/json' },
            data: dataJson
        }	
        
        return $http(req).then(function(response){   
            return response.data;
        });							
	}					
	
	// Get contries
	factory.contries = function(){
		var req ={
			method: 'GET',
  			cache: true,
 			url: awhmcs.plugin_url+'data/contries.json'
  		}		
		return $http(req).success(function(data) {
			return data;
		});					
	}
	
	return factory;	
});