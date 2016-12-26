app.filter('limitHtml', function($sce) {
    return function(text, limit) {

        var changedString = String(text);
        var length = changedString.length;
        var suffix = ' ...';

        var content = length > limit ? changedString.substr(0, limit - 1) + suffix : changedString;
        
        return  $sce.trustAsHtml(content);
    }
});

app.filter('currency', function() {
    return function(price, limit) {
        var prefix = '$';
        var currency = ' USD';
                
        if(price > 0){
	        price = prefix+price+ currency;
        }else{
	        price = 'Free';
        }

        
        return  price;
    }
});			

app.filter('domaintype', function(){
	return function(domaintype){
		var type = '';
		
		if(domaintype == "domaintransfer"){
			type = 'Domain Transfer';
		}
		
		if(domaintype == "domainregister"){
			type = 'Domain Register';
		}		
		
		return type;
	}
});	

app.filter('defaultTerm', function(){
	return function(title){
		
		var term = '1 Year';
		
		if(title != ''){
			term = title ;
		}		
		
		return term;
	}
});		
					

app.controller('logoutController', function($scope,$location,$route,$rootScope, localStorageService) {
	
	localStorageService.clearAll();
	jQuery(".top-header .login").removeClass('hide');
	jQuery(".top-header .login").addClass('show');
	jQuery(".top-header .account").removeClass('show');
	jQuery(".top-header .account").addClass('hide');
	$route.reload();
	
	$location.path('/');

				
})				

app.controller('transferController', function($scope, $http, $location, localStorageService, WHMCS, $route) {
	
	$scope.project.left  = awhmcs.plugin_url+'pages/left.html';
	
	// Breadcrumbs
	$scope.breadcrumbs = [];
	
	$scope.breadcrumbs = WHMCS.getBreadcrumbs($route, 'Transfer domain');	

	// Check login 
	//$scope.$emit('checklogin', localStorageService.get('data'));

	// Get extensions for search
	WHMCS.getExtensions().then(function(response){
		$scope.extensions = response;

		// Set default tld for search
		$scope.selected = response[0].tld;
	});			
	
	$scope.checkDomain = function(){
		
		$scope.loading = true;
		
		var domainSearch = $scope.project.domain+$scope.selected; 

		WHMCS.domainchecker(domainSearch, 'domaincheckertransfer').then(function(response){
			
			$scope.loading = false;
			
			// Default for search is .com
			$scope.defaultdomain = response;
			
			var time = WHMCS.getDomainTime($scope.defaultdomain.domain, 'domaintransfer');

			// Load price
			$scope.defaultdomain.price = WHMCS.getDomainPrice(domainSearch, 'domaintransfer');
			
			$scope.defaultdomain.data = [{'time':time.billingcycle, 'type': 'domaintransfer'}];
			
			$scope.show = true;
		});
	}	
	
	// Function select .com .net ...
    $scope.updateData = function(data){
      $scope.selected = data;
  	}			
						
})	

app.controller('domainController', function($scope,$rootScope, $location, localStorageService,$route, filterFilter, WHMCS, breadcrumbs ) {

	// Load breadcrumbs	
  	$scope.breadcrumbs = breadcrumbs;
	
	// Check login 
	//$scope.$emit('checklogin', localStorageService.get('data'));

	

	if(WHMCS.data('defaultdomain')){
		
		$scope.defaultdomain = WHMCS.data('defaultdomain');
		
		// Load price
		//$scope.defaultdomain.price = WHMCS.getDomainPrice($scope.defaultdomain.domain, 'domainregister');
		
		//var time = WHMCS.getDomainTime($scope.defaultdomain.domain, 'domainregister');
		
		//$scope.suggestdomain = WHMCS.data('suggestdomain');
		
		//$scope.defaultdomain.data = [{'time':time.billingcycle, 'type': 'domainregister'}];
		
		//$scope.show = true;
		
		$scope.defaultdomain.data = [{'time': 'msetupfee', 'type': 'domainregister'}];
	}
	
	
	$scope.checkDomain = function(){
		
		$scope.loading = true;
		
		var domainSearch = $scope.project.domain+$scope.selected; 
		
		WHMCS.domainchecker(domainSearch, 'domaincheckerone').then(function(response){
			
			$scope.loading = false;
			
			// Default for search is .com
			$scope.defaultdomain = response;
			
			//var time = WHMCS.getDomainTime($scope.defaultdomain.domain, 'domainregister');

			// Load price
			//$scope.defaultdomain.price = WHMCS.getDomainPrice($scope.defaultdomain.domain, 'domainregister');
			
			$scope.defaultdomain.data = [{'time': 'msetupfee', 'type': 'domainregister'}];
			
			$scope.show = true;
		});
	}	

	if (localStorageService.get('domainshortcode')) {
		$scope.project.domain = localStorageService.get('domainshortcode');
	}
	if (localStorageService.get('domainclient')) {
		$scope.project.domain = localStorageService.get('domainclient');
	}

	// Get Extensions 
	WHMCS.getExtensions().then(function(response){
      $scope.extensions = response;
      $scope.selected = $scope.extensions[0].tld;
    })

	// Get TLD Pricing
    WHMCS.getTldpricing().then(function(response){
      $scope.tldpricings = response;
    })

	// Function select .com .net ...
    $scope.updateData = function(data){
      $scope.selected = data;
  	}
    						
})				

app.controller('registerController', function($scope, $location, $http, filterFilter, WHMCS) {
	
	// Check login 
	//$scope.$emit('checklogin', localStorageService.get('data'));

	if(WHMCS.data('data')){
		
		$location.path('/client');
	}				
	
	//var contries = require('./data/provinces.json');
	$scope.client = {};
	$scope.text  = true;
	$scope.error = '';
	
	// Check value state is exits
	$scope.stateVal = function(state){
		if(state.short != ''){
			return state.short;
		}
		return state.name;
	}
	
	
	// Update state when select contry
	$scope.updateState = function(contry){
		
		$scope.text = true;
		var req ={
			method: 'GET',
  			cache: true,
 			url: awhmcs.plugin_url+'data/provinces.json'
  		}
  		
		$http(req).success(function(data) {
			$scope.states = filterFilter(data, {country:contry});
			
			if($scope.states.length > 0){
				$scope.text = false;							
			}

		});					
	}
	// Get contry data	
/*
	$http.get('./data/contries.json').success(function(data) {
		$scope.contries = data;
	});	
*/	
	
	//Save
	$scope.registerSubmit = function(){

        var dataJson  =  JSON.stringify($scope.client);

        var req = {
            method: 'POST',
            url: awhmcs.plugin_url+'action/register.php',
            headers : {'Content-Type': 'application/json' },
            data: dataJson
        }
		
        $http(req).then(function(response){

			if(response.data.client){
				$scope.project.client = response.data.client.client;
				$scope.project.stats = response.data.client.stats;
				$scope.project.services = response.data.services.products.product;
				$scope.project.groups = response.data.groups.groups;
				//$scope.project.announcements = response.data.announcements.announcements.announcement;
				//$scope.project.tld = response.data.tld;
				
				WHMCS.set('data',$scope.project);
				
				$location.path('/client');
			}else{
				// Enable error register message
				$scope.error = response.data;
			};
        });						
	}
			
})	

app.controller('pwresetController', function($scope, $location, WHMCS, $routeParams) {
	
	$scope.key = $routeParams.key;
	$scope.status = '';
	
	// Reset password
	$scope.submit = function(){
		WHMCS.resetpwd('', $scope.key, $scope.password1, $scope.password2).then(function(response){
			if(response.status){
				$scope.status = 'done';
				$scope.error = '';
			}
			
			if(response.error){
				$scope.error = response.error;
			}			
		}); 		
	}	
})

app.controller('forgotpasswordController', function($scope, $location, WHMCS, $routeParams) {
	
	$scope.status = '';
	
	// Submit forgot	
	$scope.submit = function(){
		WHMCS.resetpwd($scope.clientEmail).then(function(response){
			//if(response.status == 'null')
			$scope.status = 'done';
		});  		
	}
		
})	


app.controller('callbackController', function($scope, $location, $routeParams, WHMCS) {
	
	// When success	
	if($routeParams.paymentsuccess){
		WHMCS.updateinvoice($routeParams.id).then(function(){
			$location.path('/invoice/id/'+$routeParams.id);	
		});   
	}	
	
	// WHen failed
	if($routeParams.paymentfailed){
		$location.path('/invoice/id/'+$routeParams.id);   
	}			
})			

app.controller('notfoundController', function($scope, WHMCS) {	
	// Check login 
	//$scope.$emit('checklogin', WHMCS.data('data'));
						
})	
app.controller('redirectController', function($scope, WHMCS, $sce) {
	
	var re = new RegExp(awhmcs.whmcs_installed_folder+'/viewinvoice.php','g');
	$scope.text = WHMCS.data('paymentform').replace(re, awhmcs.app_permalink+'/#/callback');
	//$scope.text = awhmcs.whmcs_installed_folder+'/viewinvoice.php';
	$scope.paymentform = $sce.trustAsHtml($scope.text);					
})

			

// Checkout out controller
app.controller('checkoutController', function($scope, $http, $location, $mdDialog, ngCart, $sce, WHMCS) {
	
	$scope.project.menu  = awhmcs.plugin_url+'pages/menu-client.html';
	
	// Hide loading
	$scope.display = 'none';

	$scope.client = WHMCS.data('data').client;
	
	// Get total price
	$scope.totalPrice = ngCart.totalCost();
	
	if(!$scope.client) $scope.client = {};	
	
	$scope.client.notes = "You can enter any additional notes or information you want included with your order here...";				
	
	// Get payment method				
	WHMCS.getPaymentmethods().then(function(response){
		
		// Set default payment method
		$scope.paymentmethod = response[0].module;
		$scope.paymentmethods = response;
	});
	
	// Get contacts
    WHMCS.getContacts().then(function(response){
        $scope.contacts = response;
        		            		        	        
    });
	
	
    
    // Login form 
	$scope.login = function(){
		$mdDialog.show({
			controller: 'LoginController',
			templateUrl: awhmcs.plugin_url+'pages/blocks/login.html',
			parent: angular.element(document.body),
			clickOutsideToClose:true
		}).then(function(response) {
    	})		
	}  		
    
    $scope.addOrder = function(){
        
        var order = {};
        
        // Show loading
        $scope.display = 'block';
        
        order.client = WHMCS.data('data');
               
        WHMCS.addOrder(ngCart.getItems(), $scope.client, order.client, $scope.paymentmethod).then(function(response){

			// Set client data
	        //if(response.data)
	        //WHMCS.set('data',response.data);

	        if(response.order){	
		        
		        // Hide loading
		        		        	        		        
		        // Empty cart
		        ngCart.empty();
		        
		        if(response.order.paymentbutton){
			        
			        // Change callback url
			        
			        WHMCS.set('paymentform', response.order.paymentbutton);			     
			        
			    	$location.path('/redirect');    
		        }else{
			    	$location.path('/invoice/id/'+response.rs.invoiceid);    
		        }
	        }else{
		        alert('Error! Please contact to administrator.');
	        }
	        
	        $scope.display = 'none';
	        
        });				        
    }
})				

app.controller('cartController', function($rootScope, $scope, ngCart) {
	
	// Check login 
	//$scope.$emit('checklogin', localStorageService.get('data'));

	$scope.empty = function(){
		ngCart.empty();
	}
	
})

app.controller('productsController', function($rootScope,$scope,$http,$location,$route,localStorageService, ngCart, WHMCS, $routeParams) {
	
	$scope.project = WHMCS.data('data');	

	// Get product was added for check domain
	var currentProduct = WHMCS.data('quotes');
	
	// Disabled button process
	$scope.process = false;
	
	
	// Breadcrumbs
	$scope.breadcrumbs = [];
	
	$scope.breadcrumbs = WHMCS.getBreadcrumbs($route, 'Our services');

	$scope.domain = {};
	
	// Get tld domains
	$scope.extensions = WHMCS.data('extensions');
	
	// Set default extension
	$scope.defaultExtension = $scope.extensions[0];
	
	// Set for test
	$scope.domain.type = 'domainregister';
	
	$scope.addOrder = function(product){
		
		$scope.project.cartright = 'pages/products/domain.html';
		$scope.project.currentProduct = product;		            				
	}	
	
	// Set group id
	if($routeParams.gid){
		$scope.groupId = $routeParams.gid;
	}	
	
	$scope.instant = function(){
		
		$scope.loading = true;
		$scope.type = 'domainregister';
		$scope.hasdata = '';
		
		$scope.domainSeach = $scope.domain.name;
		
		if ( $scope.domainSeach.indexOf(".") > -1 ) { 
			$scope.domainArray = $scope.domain.split('.'); 
			$scope.tld = $scope.domainArray[1];
			$scope.domainSeach = $scope.domainArray[0];
		} 
		
		var req = {
            method: 'POST',
            url: awhmcs.plugin_url+'action/api.php',
            headers : {'Content-Type': 'application/json' },
            data: { action: 'instant', domain: $scope.domainSeach, tld: $scope.tld },
            cache: false
        }
        	
        return $http(req).then(function(response){
            $scope.data = response.data.data;	            
            $scope.cartdata = [{'time': 'msetupfee', 'type': $scope.type}];
            $scope.loading = false;
			if($scope.data.length > 0){
			    $scope.hasdata = 1;    
		    }
        });						
	}

	$scope.remove_seach = function(){
		$scope.data = '';
		$scope.hasdata = '';
		$scope.domain.name = '';
	}	
	
	// Get domain free
	WHMCS.getDomainfree(currentProduct.pid).then(function(response){
		$scope.checkdomainfree = response;
	});
	
	// Add to cart
	$scope.addCart = function(domain, domainfree, tld){
		
		var currentDomain = {};	
		
		// Price product
		var price = parseInt(currentProduct.pricing.USD.monthly) + parseInt(currentProduct.pricing.USD.msetupfee);	

		// Add product to cart
		ngCart.addItem(currentProduct.pid+$scope.domaindefault, currentProduct.name, price, 1, [{'type': currentProduct.type, 'id': currentProduct.pid, title: 'Monthly', time: 'Monthly', 'setup': currentProduct.pricing.USD.msetupfee, 'domain': [{'name': $scope.domaindefault, 'time': 'msetupfee' }] }] );	
		
		// Check domain is free or not
		if(domainfree.freedomaintlds.indexOf(tld) >= 0){
			domain.price = 0;
		}
		//Add domain to cart
		ngCart.addItem($scope.domaindefault, $scope.domaindefault, $scope.domain.price, 1, $scope.cartdata);	
		
		$location.path("/cart");		
	}
	
	$scope.select = function(domain, tld, price){
		$scope.domaindefault = domain+'.'+tld;
		$scope.domain.price = price;
		$scope.process = true;
		
		$scope.selected = tld;
	}
	
	// Add to cart
	$scope.addProduct = function(){
		
		var currentDomain = {};	
		
		// Price product
		var price = parseInt(currentProduct.pricing.USD.monthly) + parseInt(currentProduct.pricing.USD.msetupfee);	

		// Add product to cart
		ngCart.addItem(currentProduct.pid, currentProduct.name, price, 1, [{'type': currentProduct.type, 'id': currentProduct.pid, title:'Monthly', time: 'Monthly', 'setup': currentProduct.pricing.USD.msetupfee, 'domain': [{'name': '', 'time': ''}] }] );		
		
		$location.path("/cart");		
	}	
	
	$scope.checkDomain = function(){
		
		// Get tlds available
		//var extension = WHMCS.data('extensions');

		// Get domain name
		$scope.domaindefault = $scope.domain.name + $scope.defaultExtension;
		
		// Show loading
		$scope.loading = true;
		
		// Send domain for checking
		WHMCS.domainchecker($scope.domaindefault, 'domaincheckerone').then(function(response){
			
			$scope.loading = false;	
			// Response data
			$scope.rdata = response;	
				
			// Get domain cycle
			var time = WHMCS.getDomainTime($scope.domaindefault, $scope.domain.type);

			// Load price
			$scope.rdata.price = WHMCS.getDomainPrice($scope.domaindefault, $scope.domain.type);
			// Set data for cart
			$scope.rdata.data = [{'time':time.billingcycle, 'type': $scope.domain.type}];
			// Show result
			$scope.show = true;
			// Show process button when domain is available
			if(response.status == 'available')
			$scope.process = true;
			
		});				
	}	
	
	$scope.checkDomainTransfer = function(){
		$scope.tloading = true;
		
		$scope.domainSeach = $scope.domain.name;
		
		if ( $scope.domainSeach.indexOf(".") > -1 ) { 
			$scope.domainArray = $scope.domain.split('.'); 
			$scope.tld = $scope.domainArray[1];
			$scope.domainSeach = $scope.domainArray[0];
		} 
		
		var req = {
            method: 'POST',
            url: awhmcs.plugin_url+'action/api.php',
            headers : {'Content-Type': 'application/json' },
            data: { action: 'instant', domain: $scope.domainSeach, tld: $scope.tld, type: 'transfer' },
            cache: false
        }
        	
        return $http(req).then(function(response){
            $scope.tdata = response.data.data;	            
            $scope.cartdata = [{'time': 'msetupfee', 'type': 'domaintransfer'}];
            $scope.tloading = false;
            $scope.hastdata = 1;
        });			
	}						
								
})		

// Add contact
app.controller('addcontactController', function($scope,$http,$location,localStorageService,filterFilter,$routeParams,WHMCS) {
	
	$scope.project = localStorageService.get('data');

	$scope.project.left  = awhmcs.plugin_url+'pages/left.html';
	$scope.new = true;
	$scope.permissions = [];
	
	
	// Check login 
	$scope.$emit('checklogin', localStorageService.get('data'));

	
	// Get contacts
    WHMCS.getContacts().then(function(response){
        $scope.contacts = response;	
        
        if($routeParams.action != 'new'){
       		var contact = filterFilter($scope.contacts, {id:$routeParams.action});	
	   		$scope.client = contact[0];    
        }
        		            		        	        
    });					
	
	if($routeParams.action == 'new'){
		// Set client id for submit action
		$scope.client.clientid = $scope.project.client.userid;					
	}else{					
		
		$scope.new = false;			
	}
	
	$scope.permission = function(item, list){
		
		var idx = list.indexOf(item);
		
        if (idx > -1) {
          list.splice(idx, 1);
        }
        else {
          list.push(item);
        }	
        
        //$scope.permissions = list;		
	}
	
	// Check value state is exits
	$scope.stateVal = function(state){
		if(state.short != ''){
			return state.short;
		}
		return state.name;
	}						
	
	// Update state when select contry
	$scope.updateState = function(contry){
		
		$scope.text = true;
		
		$http.get(awhmcs.plugin_url+'data/provinces.json').success(function(data) {
			$scope.states = filterFilter(data, {country:contry});
			
			if($scope.states.length > 0){
				$scope.text = false;							
			}

		});					
	}	
	
	// Edit contact
	$scope.editcontactSubmit = function(){
		
		$scope.client.contactid = $routeParams.action;
		
		$scope.client.permissions = $scope.permissions.join();
		
        var dataJson  =  JSON.stringify($scope.client);

        var req = {
            method: 'POST',
            url: 'action/editcontact.php',
            headers : {'Content-Type': 'application/json' },
            data: dataJson
        }

		
        $http(req).then(function(response){
			// Get contacts
        });						
	}
	
	//Save
	$scope.addcontactSubmit = function(){
        var dataJson  =  JSON.stringify($scope.client);

        var req = {
            method: 'POST',
            url: 'action/addcontact.php',
            headers : {'Content-Type': 'application/json' },
            data: dataJson
        }

		
        $http(req).then(function(response){
			// Get contacts
            WHMCS.getContacts().then(function(response){
		        $scope.contacts = response;					        
	        });
        });						
	}				
	
								
})	

// Home controller
app.controller('homeController', function($rootScope, $scope, $location, WHMCS, $sce, $route,localStorageService, $routeParams, filterFilter) {
	
	// Before load
	WHMCS._init('home');

	$scope.news = [];
	$scope.announcement = {};
	$scope.breadcrumbs = [];
	
	// Get announcements
	WHMCS.getNews().then(function(response){
		
		$scope.announcements = response;

    	angular.forEach($scope.announcements, function(value, key){
        	
        	if(value.published == 1){
	        	var announcement = {};
	        	
		        announcement.content = $sce.trustAsHtml(value.announcement);
		        announcement.title = value.title;
		        announcement.id = value.id;
		        announcement.date = new Date(value.date);
		        
		        $scope.news.push(announcement);						        	
        	}	        
        });			
        
        // Get announcement
        var announcement = filterFilter(response, {id:$routeParams.id}); 
		
		// Set breadcrumbs data
		$scope.breadcrumbs = WHMCS.getBreadcrumbs($route, announcement[0].title);
		
        $scope.announcement.title = announcement[0].title;
        $scope.announcement.id = announcement[0].id;
        $scope.announcement.date = new Date(announcement[0].date);		
        $scope.announcement.content = $sce.trustAsHtml(announcement[0].announcement)	        		
	});	
	WHMCS.getTldpricing().then(function(response){
      $scope.tldpricings = response;
    })		
								
})		

	// Home controller
app.controller('announcementsController', function($rootScope, $scope, $location, WHMCS, $sce, $route,localStorageService, $routeParams, filterFilter) {
	
	$scope.news = [];
	$scope.announcement = {};
	$scope.breadcrumbs = [];
	
	// Test code
	$scope.$emit('cpage', 'announcements');

	$scope.project.left = awhmcs.plugin_url+'pages/left.html'; 
	// Set breadcrumbs data
	$scope.breadcrumbs = WHMCS.getBreadcrumbs($route, 'Announcements');
	// Get announcements
	WHMCS.getNews().then(function(response){
		
		$scope.announcements = response;   
    	
    	angular.forEach($scope.announcements, function(value, key){
        	
        	if(value.published == 1){
	        	var announcement = {};
	        	
		        announcement.content = $sce.trustAsHtml(value.announcement);
		        announcement.title = value.title;
		        announcement.id = value.id;
		        announcement.date = new Date(value.date);
		        
		        $scope.news.push(announcement);						        	
        	}	        
        });							        		
	});			
								
})	

// Home controller
app.controller('announcementController', function($rootScope, $scope, $location, WHMCS, $sce,localStorageService, $route, $routeParams, filterFilter) {
	
	$scope.news = [];
	$scope.announcement = {};
	$scope.breadcrumbs = [];
	
	$scope.project.left = awhmcs.plugin_url+'pages/left.html'; 

	// set page current
	$scope.$emit('cpage', 'announcement');
	
	// Set breadcrumbs data
	$scope.breadcrumbs = WHMCS.getBreadcrumbs($route, 'Announcements');
	
	// Get announcements
	WHMCS.getNews().then(function(response){
		
		$scope.announcements = response;   
    	
    	angular.forEach($scope.announcements, function(value, key){
        	
        	if(value.published == 1){
	        	var announcement = {};
	        	
		        announcement.content = $sce.trustAsHtml(value.announcement);
		        announcement.title = value.title;
		        announcement.id = value.id;
		        announcement.date = new Date(value.date);
		        
		        $scope.news.push(announcement);						        	
        	}	        
        });		
        
        
        // Get announcement
        var announcement = filterFilter(response, {id:$routeParams.id}); 
		
		// Set breadcrumbs data
		$scope.breadcrumbs = WHMCS.getBreadcrumbs($route, announcement[0].title);
		
        $scope.announcement.title = announcement[0].title;
        $scope.announcement.id = announcement[0].id;
        $scope.announcement.date = new Date(announcement[0].date);		
        $scope.announcement.content = $sce.trustAsHtml(announcement[0].announcement)        		        		
	});			
								
})								

	

app.controller('LoginController', function($rootScope,$scope,$http,$location, WHMCS, $mdDialog, $route) {

	$scope.project = {};
	
	// Check login 
	//$scope.$emit('checklogin', WHMCS.data('data'));

	$scope.$emit('cpage', 'login');
	
	if(WHMCS.data('data')){
		
		$location.path('/client');
	}
	// Display error login message
	$scope.project.error = false;
	// Display loading ajax
	$scope.project.loading = '';
	
	$scope.submit = function(){
		
		// Enable loading ajax
		$scope.project.loading = 'loading';
		
        var dataJson  =  JSON.stringify($scope.project);

        var req = {
            method: 'POST',
            url: awhmcs.plugin_url+'action/ajax.php',
            headers : {'Content-Type': 'application/json' },
            data: dataJson
        }

        $http(req).then(function(response){

			if(response.data.client){
				$scope.project.client = response.data.client.client;
				//$scope.project.contact = response.data.contacts.contact;
				$scope.project.stats = response.data.client.stats;
// 				$scope.project.services = response.data.services.products.product;
				//$scope.project.products = response.data.products.products.product;
				//$scope.project.groups = response.data.groups.groups;
				//$scope.project.announcements = response.data.announcements.announcements.announcement;
				//$scope.project.tld = response.data.tld;

				WHMCS.set('data', $scope.project);

				$mdDialog.hide();
				$route.reload();
				jQuery(".top-header .login").removeClass('show');
				jQuery(".top-header .login").addClass('hide');
				jQuery(".top-header .account").removeClass('hide');
				jQuery(".top-header .account").addClass('show');
				//$location.path('/client');
			}else{
				// Enable error login message
				$scope.project.error = true;
			};
			$scope.project.loading = '';
        });					
	};				
})
		

app.controller('clientController', function($rootScope,$scope,$http,$location,localStorageService, WHMCS, filterFilter, breadcrumbs) { 	

	$scope.page = 1 ;
  	$scope.pageSize = 20 ;
    
	// Get breadcrumbs
	$scope.breadcrumbs = breadcrumbs;
	
	// Check login 
	$scope.$emit('checklogin', localStorageService.get('data'));

    $scope.project = localStorageService.get('data');  
    // Get contacts
    WHMCS.getContacts($scope.project.client.email).then(function(response){
        $scope.contacts = response;
    });	    

    
    $scope.subtotal = 0;
	var i = 0;
    
	// Set top menu layout
	$scope.project.left = awhmcs.plugin_url+'pages/left.html';	

	WHMCS.getTickets().then(function(response){
		if(response.tickets)
    	$scope.tickets = filterFilter(response.tickets.ticket, {userid:$scope.project.client.id});
    })

    WHMCS.getServices($scope.project.client.id, 1, 3).then(function(response){
    	$scope.services = response.products.product;
    })	
    WHMCS.getInvoices($scope.project.client.id, 1 , 200).then(function(response){
		$scope.invoicespl = response.invoices.invoice;
		$scope.invoices = filterFilter($scope.invoicespl, {status:'!' +'Paid'}, true);

		angular.forEach($scope.invoices, function(){
			$scope.subtotal = $scope.subtotal + parseInt($scope.invoices[i].subtotal);
			i = i+1;
		});
	}) 
	
})	

app.directive('paymentMethods', function(WHMCS){
	return {
		restrict: 'E',
		scope: { },
		templateUrl: function( elem, attrs ) {
           return attrs.templateUrl;
		},
		link: function(scope){
			WHMCS.getPaymentmethods().then(function(response){
				
				// Set default payment method
				scope.paymentmethod = response[0].module;
				scope.paymentmethods = response;
			});
		}
	}
})	

app.directive('productList', function($location, filterFilter,$route, localStorageService, WHMCS){
	return {
		restrict: 'E',
		scope: {
			title:"@",
			group:"="
		},
		templateUrl: function( elem, attrs ) {
           return awhmcs.plugin_url+attrs.templateUrl;
		},
		link: function(scope){
			// Breadcrumbs
			scope.breadcrumbs = [];
			scope.breadcrumbs = WHMCS.getBreadcrumbs($route, 'Our services');
			// Set quote to empty
			WHMCS.set('quotes', '');
			
			// Get products
			WHMCS.getProducts().then(function(response){
				scope.products = response.products.product;
			});
			
			scope.addOrder = function(product){
				
				WHMCS.set('quotes', product);	
				
				$location.path('/products/domain');            				
			}
			
			
			// Get product groups
			WHMCS.getProductGroups().then(function(response){
				if(response.result == 'success'){
					
					scope.groups = response.groups;
					
					if(scope.group){
						var group = filterFilter(scope.groups, {gid:scope.group});
						scope.defaultGroup = group[0];
					}else{
						scope.defaultGroup = response.groups[0]
					}					
					
				}else{
				}
		
			});	
		
		}
	}
})		

app.directive('domainChecker', function($location, filterFilter, localStorageService, WHMCS, $http, $sce){
	return {
		restrict: 'E',
		scope: { },
		templateUrl: function( elem, attrs ) {
           return awhmcs.plugin_url+ attrs.templateUrl;
		},
		link: function(scope){
			
			scope.display = 'none';
			scope.app_url = awhmcs.app_permalink;
			
/*
			WHMCS.getTldpricing().then(function(response){
				
		      scope.tldpricings = response;
		      
		    })	
*/
			scope.domainChecker = function(domain){
				
				scope.display = 'block';

				WHMCS.domainchecker(domain, 'domaincheckerone').then(function(response){
					// Default for search is .com
					localStorageService.set('defaultdomain', response);
					
					scope.display = 'none';

					localStorageService.set('domainclient', scope.domain );
					localStorageService.remove('domainshortcode');

					
					$location.path('/domainchecker');

				});							
			}
			
			scope.instant = function(transfer){
				
				scope.display = 'block';
				
				scope.hasdata = '';
				
				scope.domainSeach = scope.domain;
				
				scope.type = 'domainregister';
				
				if(transfer){
					scope.type = 'domaintransfer';
				}				
				
				if ( scope.domain.indexOf(".") > -1 ) { 
					scope.domainArray = scope.domain.split('.'); 
					scope.tld = scope.domainArray[1];
					scope.domainSeach = scope.domainArray[0];
				} 
				
				var req = {
		            method: 'POST',
		            url: awhmcs.plugin_url+'action/api.php',
		            headers : {'Content-Type': 'application/json' },
		            data: { action: 'instant', domain: scope.domainSeach, tld: scope.tld },
		            cache: false
		        }
		        	
		        return $http(req).then(function(response){
		            scope.data = response.data.data;	            
		            scope.cartdata = [{'time': 'msetupfee', 'type': scope.type }];
		            scope.display = 'none';
		            
		            if(response.data.data.length > 0){
			        	scope.hasdata = 1;    
		            }
		            
		        });						
			}

			scope.remove_seach = function(){
				scope.data = '';
				scope.hasdata = '';
				scope.domain = '';
			}
			
			scope.transferDomain = function(domain){
				
				WHMCS.checktransfer(domain, '', 'transferdomain').then(function(response){
					
					localStorageService.set('transferdomain', response);
					
					$location.path('/transfer');

				});							
			}
			// Get Extensions 
			WHMCS.getExtensions().then(function(response){
		      scope.extensions = response;
		      scope.selected = scope.extensions[0].tld;
		    })
		    scope.updateData = function(data){
		      scope.selected = data;
		  	}
		}
	}
})

app.directive('domainShortcode', function($location, filterFilter, localStorageService, WHMCS){
	return {
		restrict: 'E',
		scope: { },
		templateUrl: function( elem, attrs ) {
           return awhmcs.plugin_url+ attrs.templateUrl;
		},
		link: function(scope){
			
			scope.display = 'none';
			
			WHMCS.getTldpricing().then(function(response){
				
		      scope.tldpricings = response;
		      
		    })	
			scope.domainChecker = function(domain){
				
				scope.display = 'block';

				WHMCS.domainchecker(domain, 'domaincheckerone').then(function(response){
					// Default for search is .com
					localStorageService.set('defaultdomain', response);
					
					scope.display = 'none';

					localStorageService.set('domainshortcode', scope.domain );
					localStorageService.remove('domainclient');
					
					location.href = ('http://alaskatheme.com/whmcs-app/#/domainchecker') ;
					
					$location.path(awhmcs.app_permalink+'/#/domainchecker');

				});							
			}
			
			scope.transferDomain = function(domain){
				
				WHMCS.checktransfer(domain, '', 'transferdomain').then(function(response){
					
					localStorageService.set('transferdomain', response);
					
					$location.path('/transfer');

				});							
			}
			// Get Extensions 
			WHMCS.getExtensions().then(function(response){
		      scope.extensions = response;
		      scope.selected = scope.extensions[0].tld;
		    })
		    scope.updateData = function(data){
		      scope.selected = data;
		  	}	
		}
	}
})

app.directive('productPricing', function(localStorageService, ngCart, WHMCS, filterFilter){
	return {
		restrict: 'E',
		scope: {
			time:"=",
			item:"="	
		},
		templateUrl: awhmcs.plugin_url+'pages/blocks/productpricing.html',
		link: function(scope){		
			
			//if(scope.time[0].type != 'hostingaccount'){
			// Load pricing
			scope.pricing = WHMCS.getProductPricing(scope.item).then(function(response){
				scope.pricing = response;
			});

		}	
	}
})

app.directive('productPricing', function(localStorageService, ngCart, WHMCS, filterFilter){
	return {
		restrict: 'E',
		scope: {
			time:"=",
			item:"="	
		},
		templateUrl: awhmcs.plugin_url+'pages/blocks/productpricing.html',
		link: function(scope){		
			
			//if(scope.time[0].type != 'hostingaccount'){
			// Load pricing
			scope.pricing = WHMCS.getProductPricing(scope.item).then(function(response){
				scope.pricing = response;
			});

		}	
	}
})


app.directive('breadcrumbs', function(WHMCS){
	return {
		restrict: 'E',
		scope: {
			breadcrumbs:"="	
		},
		templateUrl: awhmcs.plugin_url+'pages/blocks/breadcrumbs.html',
		link: function(scope){
			//scope.breadcrumbs = WHMCS.getBreadcrumbs($route, 'Client Manager');
		}
	}
})

app.directive('awhmcsHeader', function(){
	return {
		restrict: 'E',
		templateUrl: awhmcs.plugin_url+'pages/header.html'
	}
})

app.directive('domainPricing', function(localStorageService, ngCart, WHMCS, filterFilter){
	return {
		restrict: 'E',
		template: '<ng-include src="getTemplateUrl()"/>',
		scope: {
			domain:"@",
			time:"=",
			item:"="	
		},		
		link: function(scope){	
			
			var templateUrl = awhmcs.plugin_url+'pages/blocks/domainpricing.html';
				
			if(scope.time[0].id){
				scope.pricing = WHMCS.getProductPricing(scope.item).then(function(response){
					scope.pricing = response;
				});			
				
				templateUrl = 	awhmcs.plugin_url+'pages/blocks/productpricing.html';
			}else{
				scope.pricing = WHMCS.getDomainPricing(scope.domain, scope.time[0].type);
				
				scope.getTitle = function(cycle){
					var title = '';
					angular.forEach(scope.pricing, function(value, key){
						if(value.regperiod == cycle){
							title = value.title;
						}
					})
	
					return title;
				}				
			}
			
			scope.getTemplateUrl = function(){
				return templateUrl;
			}			

		}	
	}
})