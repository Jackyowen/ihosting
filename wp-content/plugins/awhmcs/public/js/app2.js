
app.controller('updateController', function($rootScope,$scope,$http,WHMCS,$location,$route,localStorageService) {
	
	// Check login 
	$scope.$emit('checklogin', localStorageService.get('data'));

	$scope.project = localStorageService.get('data');

	WHMCS.getClient($scope.project.client.userid,$scope.project.client.email).then(function(response){
		$scope.clients = response.client;
		$scope.client.clientid = $scope.clients.userid;
		$scope.client.firstname = $scope.clients.firstname;
		$scope.client.lastname = $scope.clients.lastname;
		$scope.client.companyname = $scope.clients.companyname;
		$scope.client.email = $scope.clients.email;
		$scope.client.address1 = $scope.clients.address1;
		$scope.client.address2 = $scope.clients.address2;
		$scope.client.city = $scope.clients.city;
		$scope.client.state = $scope.clients.state;
		$scope.client.postcode = $scope.clients.postcode;
		$scope.client.countrycode = $scope.clients.countrycode;
		$scope.client.phonenumber = $scope.clients.phonenumber;
	})   

	$scope.client = {};

	// Breadcrumbs
	$scope.breadcrumbs = [];
	$scope.breadcrumbs = WHMCS.getBreadcrumbs($route, 'My Details');

	$scope.project.left = awhmcs.plugin_url+'pages/left.html';

	
 
	$scope.updateClient = function(){
		//$scope.client.name = 
		$scope.loading = true;
		var dataJson  =  JSON.stringify($scope.client);
		var req = {
				method: 'POST',
				url: awhmcs.plugin_url+'action/updateclient.php',
				headers : {'Content-Type': 'application/json' },
				data: dataJson
		}    

		$http(req).then(function(response){
			$scope.loading = false;
			$scope.success = "Update Client succeeded";
		});
		$scope.click = true;
	}
	$scope.close = function(){
		$scope.click = false;
	}
								
})		

app.controller('resetpasswordController', function($scope, $location,$http, WHMCS,$route ,localStorageService) {

	// Check login 
	$scope.$emit('checklogin', localStorageService.get('data'));

	if(localStorageService.get('data')){
			 $scope.project = localStorageService.get('data');
	}

	$scope.project.left = awhmcs.plugin_url+'pages/left.html'; 

	// Breadcrumbs
	$scope.breadcrumbs = [];
	$scope.breadcrumbs = WHMCS.getBreadcrumbs($route, 'Change Password');

	WHMCS.getClient($scope.project.client.userid,$scope.project.client.email).then(function(response){
		$scope.clients = response.client;
	})

	$scope.existfunction = function(){
		if ($scope.existingpw == $scope.project.password) {
			$scope.errorexist = '';
			jQuery('.newpw').removeAttr("disabled");
		}else{
			$scope.errorexist = 'Wrong password';
			jQuery('.newpw').attr("disabled", true);

		}
	}

	$scope.newpwunction = function(){
		if ($scope.newpw.length > 5 ) {
			$scope.errornewpw = '';
			jQuery('.confirmpw').removeAttr("disabled");
		}else{
			$scope.errornewpw = 'Passwords must be at least 6 characters';
			jQuery('.confirmpw').attr("disabled", true);
		}
	}

	$scope.confirmfunction = function(){
		if ($scope.confirmpw == $scope.newpw) {
			$scope.errorconfir = '';
			jQuery('.submit').removeAttr("disabled");
		}else{
			$scope.errorconfir = 'Passwords do not match';
			jQuery('.submit').attr("disabled", true);

		}
	}

	$scope.resetSubmit = function(){

		$scope.loading = true;
		//$scope.client.name = 
		var pass ={};
		pass.email = $scope.project.client.email;
		pass.existingpw = $scope.existingpw;
		pass.newpw = $scope.newpw;
		pass.confirmpw = $scope.confirmpw;

		var dataJson  =  JSON.stringify(pass);

		var req = {
				method: 'POST',
				url: awhmcs.plugin_url+'action/updatepass.php',
				headers : {'Content-Type': 'application/json' },
				data: dataJson
		}    

		$http(req).then(function(response){
			$scope.loading = false;
			$scope.success = "Change password succeeded";

			localStorageService.clearAll();

			$route.reload();
			
			$location.path('/login');
		});
	}

})	

app.controller('viewaddonsController', function($rootScope,$scope,$http,$location,$route,WHMCS,localStorageService) {
	
	// Check login 
	$scope.$emit('checklogin', localStorageService.get('data'));

	// Breadcrumbs
	$scope.breadcrumbs = [];
	$scope.breadcrumbs = WHMCS.getBreadcrumbs($route, 'Product Addons');

	if(localStorageService.get('data')){
			 $scope.project = localStorageService.get('data');
	}

	$scope.project.left = awhmcs.plugin_url+'pages/left.html';

	WHMCS.getProducesaddons($scope.project.client.id).then(function(response){
		$scope.addons = response;
	})    

})	

app.controller('myinvoicesController', function($rootScope,$scope,$http,$route,$location,WHMCS,localStorageService,filterFilter) {
	
	// Check login 
	$scope.$emit('checklogin', localStorageService.get('data'));

	// Breadcrumbs
	$scope.breadcrumbs = [];
	$scope.breadcrumbs = WHMCS.getBreadcrumbs($route, 'My Invoices');

	//For paging
	$scope.page = 1 ;
	$scope.pageSize = 10 ;

	if(localStorageService.get('data')){
		$scope.project = localStorageService.get('data');
	}
	// Set top menu layout
	$scope.project.left = awhmcs.plugin_url+'pages/left.html';  

	$scope.paging = function(page){

			// Load invoice with paging
			WHMCS.getInvoices($scope.project.client.id, page , $scope.pageSize).then(function(response){
				$scope.invoices = response.invoices.invoice;
			}) 
	}

	$scope.goPage = function(id){
			$location.path('invoice/id/'+id);
	}

	WHMCS.getInvoices($scope.project.client.id, $scope.page , $scope.pageSize).then(function(response){
		$scope.invoicespl = response.invoices.invoice;
		$scope.invoices = $scope.invoicespl;
		console.log($scope.invoices);
		$scope.total = response.totalresults;
		$scope.countpaid = filterFilter($scope.invoicespl, {status:'Paid'}, true);
		$scope.countunpaid = filterFilter($scope.invoicespl, {status:'Unpaid'}, true);
		$scope.countcancelled = filterFilter($scope.invoicespl, {status:'Cancelled'}, true);
		$scope.countrefunded = filterFilter($scope.invoicespl, {status:'Refunded'}, true);
	})   

	$scope.hasChanged = function() {
		if($scope.selectedstatus == 'Paid'){
			$scope.invoices = $scope.countpaid
		}
		if($scope.selectedstatus == 'Unpaid'){
			$scope.invoices = $scope.countunpaid
		}
		if($scope.selectedstatus == 'Cancelled'){
			$scope.invoices = $scope.countcancelled
		}
		if($scope.selectedstatus == 'Refunded'){
			$scope.invoices = $scope.countrefunded
		}
		if($scope.selectedstatus == ''){
			$scope.invoices = $scope.invoicespl;
		}
	}


})

app.controller('invoiceController', function($scope, $http, $routeParams, WHMCS,localStorageService, $sce) {
	
	// Check login 
	$scope.$emit('checklogin', WHMCS.data('data'));
	$scope.$emit('hide',true);

	$scope.client = WHMCS.data('data').client;
	$scope.id = $routeParams.id;

	var req = {
        method: 'POST',
        url: awhmcs.plugin_url+'action/invoice.php',
        headers : {'Content-Type': 'application/json' },
        data: { id: $routeParams.id }
    }	

    $http(req).then(function(response){
        $scope.invoiced = response.data;
        $scope.invoiced.paymentform = $sce.trustAsHtml($scope.invoiced.paymentform.paymentbutton);
    });	
    
    WHMCS.getPayment().then(function(response){
		$scope.payments = response.payments.payment;
        $scope.email = $scope.payments[0].value;
	}) 
	WHMCS.getConfig().then(function(response){
		$scope.configs = response.configs.config;
        $scope.companyname = $scope.configs[0].value;
        $scope.payto = $scope.configs[2].value;
        $scope.logo = $scope.configs[3].value;
	})  

})	


app.controller('knowbaseController', function($rootScope,$scope,$http,$location,$route,WHMCS,localStorageService) {

	// Check login 
	$scope.$emit('checklogin', localStorageService.get('data'));

	if(localStorageService.get('data')){
		$scope.project = localStorageService.get('data');
	}

	// Breadcrumbs
	$scope.breadcrumbs = [];
	$scope.breadcrumbs = WHMCS.getBreadcrumbs($route, 'Knowledgebase');

	$scope.goPage = function(id){
			$location.path('knowledgebase/id/'+id);
	}
	
	$scope.project.left = awhmcs.plugin_url+'pages/left.html';


	WHMCS.getKnow().then(function(response){
		$scope.knows = response.knows.know;
		$scope.totalknows = response.knows;
	})  

	WHMCS.getArknow().then(function(response){
		$scope.articlesknows = response.articlesknows.articlesknow;
	})  
})

app.controller('arknowbaseController', function($rootScope,$scope,$http,$location,WHMCS,localStorageService,filterFilter) {

	// Check login 
	$scope.$emit('checklogin', localStorageService.get('data'));


	if(localStorageService.get('data')){
			 $scope.project = localStorageService.get('data');
	}

	var url = $location.path();
	var id = url.substring(18);

	WHMCS.getKnow().then(function(response){
		$scope.knows = filterFilter(response.knows.know, {id:id});
	}) 

	// Set top menu layout
	$scope.project.menu  = awhmcs.plugin_url+'pages/menu-client.html';

	WHMCS.getArknow().then(function(response){
		$scope.articlesknows = response.articlesknows.articlesknow;
	})  
})

app.controller('mydomainsController', function($rootScope,$scope,$http,$location,$route,WHMCS,localStorageService,filterFilter) {

	// Check login 
	$scope.$emit('checklogin', localStorageService.get('data'));

	// Breadcrumbs
	$scope.breadcrumbs = [];
	$scope.breadcrumbs = WHMCS.getBreadcrumbs($route, 'My Domains');

	

	if(localStorageService.get('data')){
		$scope.project = localStorageService.get('data');
	}

	$scope.project.left = awhmcs.plugin_url+'pages/left.html';  

	//For paging
	$scope.page = 1 ;
	$scope.pageSize = 10 ;

	$scope.goPage = function(id){
			$location.path('domains/id/'+id);
	}

	$scope.paging = function(page){
			// Load invoice with paging
			WHMCS.getDomains($scope.project.client.id, page , $scope.pageSize).then(function(response){
				$scope.domains = response.domains.domain;
				$scope.total = response.totalresults;
			})   
	}

	WHMCS.getDomains($scope.project.client.id, $scope.page , $scope.pageSize).then(function(response){
		$scope.domainspl = response.domains.domain;
		$scope.domains = $scope.domainspl;
		$scope.total = response.totalresults;
		$scope.countactive = filterFilter($scope.domainspl, {status:'Active'}, true);
		$scope.countexpired = filterFilter($scope.domainspl, {status:'Expired'}, true);
		$scope.countpending = filterFilter($scope.domainspl, {status:'Pending'}, true);
	})   
	$scope.hasChanged = function(){
		if($scope.selectedstatus == 'Active'){
			$scope.domains = filterFilter($scope.domainspl, {status:'Active'}, true);
		}
		if($scope.selectedstatus == 'Expired'){
			$scope.domains = filterFilter($scope.domainspl, {status:'Expired'}, true);
		}
		if($scope.selectedstatus == 'Pending'){
			$scope.domains = filterFilter($scope.domainspl, {status:'Pending'}, true);
		}
		if($scope.selectedstatus == ''){
			$scope.domains = $scope.domainspl;
		}
	}

	
})


app.controller('domainsController', function($scope, $http, $routeParams, localStorageService) {
	
	// Check login 
	$scope.$emit('checklogin', localStorageService.get('data'));

	if(localStorageService.get('data')){
			 $scope.project = localStorageService.get('data');
	}
	
	$scope.project.left = awhmcs.plugin_url+'pages/left.html';  


	$scope.client = localStorageService.get('data').client;
	
	var req = {
		method: 'POST',
			url: awhmcs.plugin_url+'action/domaindetails.php',
			headers : {'Content-Type': 'application/json' },
			data: { id: $routeParams.id }
		} 

		$http(req).then(function(response){
				$scope.domains = response.data.domains.domain;
		}); 

								
})  

app.controller('myquotesController', function($rootScope,$scope,$http,$location,$route,WHMCS,localStorageService, filterFilter) {

	// Check login 
	$scope.$emit('checklogin', localStorageService.get('data'));

	// Breadcrumbs
	$scope.breadcrumbs = [];
	$scope.breadcrumbs = WHMCS.getBreadcrumbs($route, 'My Quotes');

	if(localStorageService.get('data')){
		$scope.project = localStorageService.get('data');
	}
	
	$scope.project.left = awhmcs.plugin_url+'pages/left.html';  

	$scope.goPage = function(id){
		$location.path('invoice/id/'+id);
	}

	WHMCS.getQuotes($scope.project.client.id).then(function(response){
		$scope.quotespl = response;
		$scope.quotes = $scope.quotespl;
		$scope.countdelivered = filterFilter($scope.quotespl, {status:'Delivered'}, true);
		$scope.countaccepted = filterFilter($scope.quotespl, {status:'Accepted'}, true);
	})  
	$scope.hasChanged = function() {
		if($scope.selectedstatus == 'Delivered'){
			$scope.quotes = $scope.countdelivered
		}
		if($scope.selectedstatus == 'Accepted'){
			$scope.quotes = $scope.countaccepted
		}
		if($scope.selectedstatus == ''){
			$scope.quotes = $scope.quotespl;
		}
	}
})

// View list tickets
app.controller('ticketsController', function($rootScope,$scope,$http,$location,$route,WHMCS,localStorageService, filterFilter) {

	// Check login 
	$scope.$emit('checklogin', localStorageService.get('data'));

	// Breadcrumbs
	$scope.breadcrumbs = [];
	$scope.breadcrumbs = WHMCS.getBreadcrumbs($route, 'Support Tickets');

	if(localStorageService.get('data')){
		$scope.project = localStorageService.get('data');
	}

	$scope.project.left = awhmcs.plugin_url+'pages/left.html';  

	WHMCS.getTickets().then(function(response){
		$scope.ticketspl = filterFilter(response.tickets.ticket, {userid:$scope.project.client.id});
		$scope.tickets = $scope.ticketspl

		$scope.countopen = filterFilter($scope.ticketspl, {status:'Open'}, true);
		$scope.countanswered = filterFilter($scope.ticketspl, {status:'Answered'}, true);
		$scope.countcustomer = filterFilter($scope.ticketspl, {status:'Customer-Reply'}, true);
		$scope.countclosed = filterFilter($scope.ticketspl, {status:'Closed'}, true);
		$scope.open = function(){
			$scope.tickets = $scope.countopen;
		}
		$scope.answered = function(){
			$scope.tickets = $scope.countanswered;
		}
		$scope.customer = function(){
			$scope.tickets = $scope.countcustomer;
		}
		$scope.closed = function(){
			$scope.tickets = $scope.countclosed;
		}
	})   
	$scope.hasChanged = function(){
		if($scope.selectedstatus == 'Open'){
			$scope.tickets = filterFilter($scope.ticketspl, {status:'Open'}, true);
		}
		if($scope.selectedstatus == 'Answered'){
			$scope.tickets = filterFilter($scope.ticketspl, {status:'Answered'}, true);
		}
		if($scope.selectedstatus == 'Customer-Reply'){
			$scope.tickets = filterFilter($scope.ticketspl, {status:'Customer-Reply'}, true);
		}
		if($scope.selectedstatus == 'Closed'){
			$scope.tickets = filterFilter($scope.ticketspl, {status:'Closed'}, true);
		}
		if($scope.selectedstatus == ''){
			$scope.tickets = $scope.ticketspl;
		}
	}

	$scope.goPage = function(id){
		$rootScope.tictid = id;
		$location.path('ticket/id/'+id);
	}

	// Get Departments Name by DepartmentsID
	WHMCS.getDepartments().then(function(response){
		$scope.departments = response.departments.department;
		$scope.departnames = function(id){
			var departname = filterFilter($scope.departments, {id:id});
			return departname[0].name;
		}
	})  

})

// View ticket
app.controller('ticketController', function($rootScope,$scope,$http,$location,WHMCS,$route,$routeParams,localStorageService,$log, filterFilter) {

	// Check login 
	$scope.$emit('checklogin', localStorageService.get('data'));

	if(localStorageService.get('data')){
		$scope.project = localStorageService.get('data');
	}

	var id = $routeParams.id;

	$scope.project.left = awhmcs.plugin_url+'pages/left.html'; 

	$scope.breadcrumbs = [];
	$scope.breadcrumbs = WHMCS.getBreadcrumbs($route, 'View Ticket');

	$scope.ticketreplySubmit = function(){
		//$scope.client.name = 
		$scope.client.clientid = $scope.project.client.userid;
		$scope.client.ticketid = id;
		$scope.loading = true;
		var dataJson  =  JSON.stringify($scope.client);

		var req = {
				method: 'POST',
				url: awhmcs.plugin_url+'action/ticketreply.php',
				headers : {'Content-Type': 'application/json' },
				data: dataJson
		}    

		$http(req).then(function(response){
				$scope.loading = false;
				WHMCS.getTicket(id).then(function(response){
					$scope.tickets = response.replies.reply;
				}); 
				$scope.client.message = '';
		});
	}

	WHMCS.getTicket(id).then(function(response){
		$scope.tickets = response.replies.reply;
	}) 
	

})

app.filter('capitalize', function() {
		return function(x) {
				var i, c, txt = "";
				for (i = 0; i < x.length; i++) {
						c = x[i];
						//if (i.isUpperCase) {
								txt += c;
						//}
				}
				return x[0];
		};
});

app.controller('submitticketController', function($rootScope,$scope,$http,$location,WHMCS,$route,localStorageService, filterFilter) {

	// Check login 
	$scope.$emit('checklogin', localStorageService.get('data'));

	if(localStorageService.get('data')){
		$scope.project = localStorageService.get('data');
	}

	$scope.project.left = awhmcs.plugin_url+'pages/left.html'; 

	$scope.breadcrumbs = [];
	$scope.breadcrumbs = WHMCS.getBreadcrumbs($route, 'Submitticket');

	$scope.clients = $scope.project.client;
	$scope.services = $scope.project.services;
	$scope.prioritys = ['High', 'Medium', 'Low'];

	WHMCS.getDepartments().then(function(response){
		$scope.departments = response.departments.department;
	})  

	$scope.ticketSubmit = function(){

		//$scope.client.name = 
		$scope.client.clientid = $scope.project.client.userid;
		$scope.client.email = $scope.clients.email;

		$scope.loading = true;
		var dataJson  =  JSON.stringify($scope.client);
		var req = {
				method: 'POST',
				url: awhmcs.plugin_url+'action/ticket.php',
				headers : {'Content-Type': 'application/json' },
				data: dataJson
		}    

		$http(req).then(function(response){
				$scope.loading = false;
				$rootScope.ticketid = response.data.tid;
				$location.path('/openticket');
		});
	}

})

app.controller('openticketController', function($rootScope,$scope,$http,$location,WHMCS,localStorageService, filterFilter) {

	// Check login 
	$scope.$emit('checklogin', localStorageService.get('data'));

	if(localStorageService.get('data')){
		$scope.project = localStorageService.get('data');
	}

})


app.controller('masspayController', function($rootScope,$scope,$http,$location,$route,$routeParams,WHMCS,localStorageService, filterFilter) {
	
	// Check login 
	$scope.$emit('checklogin', localStorageService.get('data'));

	// Breadcrumbs
	$scope.breadcrumbs = [];
	$scope.breadcrumbs = WHMCS.getBreadcrumbs($route, 'Mass Payment');

	$scope.client = localStorageService.get('data').client;

	if(localStorageService.get('data')){
		$scope.project = localStorageService.get('data');
	}

	$scope.project.left = awhmcs.plugin_url+'pages/left.html'; 

	WHMCS.getInvoices($scope.project.client.id, 1 , 200).then(function(response){
		$scope.invoicespl = response.invoices.invoice;
		$scope.invoices = filterFilter($scope.invoicespl, {status:'!' +'Paid'}, true);
		$scope.subtotal = 0;
		var i = 0;
		angular.forEach($scope.invoices, function(){
			$scope.subtotal += parseFloat($scope.invoices[i].subtotal);
			i = i+1;
		});
	}) 

	WHMCS.getInvoicesitem($scope.project.client.id).then(function(response){
		$scope.invoicesitems = response.invoicesitems.invoicesitem;
	}) 

})

app.controller('servicesController', function($rootScope,$scope,$http,$location,$route,WHMCS,localStorageService,filterFilter) {
		
		// Check login 
		$scope.$emit('checklogin', localStorageService.get('data'));
								
		if(localStorageService.get('data')){
				$scope.project = localStorageService.get('data');
		}

		$scope.breadcrumbs = [];
		$scope.breadcrumbs = WHMCS.getBreadcrumbs($route, 'Services');

		$scope.goPage = function(id){
			$rootScope.tictid = id;
			$location.path('services/id/'+id);
		}

		$scope.project.left = awhmcs.plugin_url+'pages/left.html';  

		$scope.servicespl = $scope.project.services;
		$scope.services = $scope.servicespl;

		//For paging
		$scope.page = 1 ;
		$scope.pageSize = 10 ;

		$scope.paging = function(page){
			// Load invoice with paging
			WHMCS.getServices($scope.project.client.id, page , $scope.pageSize).then(function(response){
				$scope.services = response.products.product;
			})   
		}
		
		WHMCS.getServices($scope.project.client.id).then(function(response){
			if(response.products !=''){
				$scope.servicespl = response.products.product;
			}else{
				$scope.servicespl = response.products;
			}
			$scope.services = $scope.servicespl;
			$scope.countactive = filterFilter($scope.servicespl, {status:'Active'}, true);
			$scope.countpending = filterFilter($scope.servicespl, {status:'Pending'}, true);
			$scope.countsuspended = filterFilter($scope.servicespl, {status:'Suspended'}, true);
			$scope.countterminated = filterFilter($scope.servicespl, {status:'Terminated'}, true);
			$scope.countcancelled = filterFilter($scope.servicespl, {status:'Cancelled'}, true);
		})  

		$scope.hasChanged = function() {
			if($scope.selectedstatus == 'Active'){
				$scope.services = $scope.countactive
			}
			if($scope.selectedstatus == 'Pending'){
				$scope.services = $scope.countpending
			}
			if($scope.selectedstatus == 'Suspended'){
				$scope.services = $scope.countsuspended
			}
			if($scope.selectedstatus == 'Terminated'){
				$scope.services = $scope.countterminated
			}
			if($scope.selectedstatus == 'Cancelled'){
				$scope.services = $scope.countcancelled
			}
			if($scope.selectedstatus == ''){
				$scope.services = $scope.invoicespl;
			}
		}

		

})    

app.controller('serviceController', function($rootScope,$scope,$http,$location,$route,$routeParams,WHMCS,localStorageService,filterFilter) {

	// Check login 
	$scope.$emit('checklogin', localStorageService.get('data'));

	if(localStorageService.get('data')){
			 $scope.project = localStorageService.get('data');
	}

	$scope.project.left = awhmcs.plugin_url+'pages/left.html'; 

	// Breadcrumbs
	$scope.breadcrumbs = [];
	$scope.breadcrumbs = WHMCS.getBreadcrumbs($route, 'Product Details');

	var url = $location.path();
	var id = url.substring(13);
	$scope.ids = parseInt(id);

	WHMCS.getServices($scope.project.client.id,1,200).then(function(response){
		$scope.services = filterFilter(response.products.product, {id:id}, true);;
	}) 
	
	
})

app.controller('renewdomainsController', function($rootScope,$scope,$http,$location,$route,WHMCS,localStorageService,filterFilter) {

	if(localStorageService.get('data')){
			 $scope.project = localStorageService.get('data');
	}

	// Check login 
	$scope.$emit('checklogin', localStorageService.get('data'));

	$scope.project.left = awhmcs.plugin_url+'pages/left.html'; 

	// Breadcrumbs
	$scope.breadcrumbs = [];
	$scope.breadcrumbs = WHMCS.getBreadcrumbs($route, 'Domain Renewals');

	WHMCS.getRenewals($scope.project.client.id).then(function(response){
		$scope.domains = response.domains;
	})  

})

app.controller('downloadsController', function($rootScope,$scope,$http,$location,$route,WHMCS,localStorageService,filterFilter,$anchorScroll) {
	
	
	$scope.$emit('checklogin', localStorageService.get('data'));
	if(localStorageService.get('data')){
		$scope.project = localStorageService.get('data');
	}

	// Breadcrumbs
	$scope.breadcrumbs = [];
	$scope.breadcrumbs = WHMCS.getBreadcrumbs($route, 'Downloads');

	// Check login 
	$scope.$emit('checklogin', localStorageService.get('data'));

	$scope.project.left = awhmcs.plugin_url+'pages/left.html';

	WHMCS.getDownloads().then(function(response){
		$scope.downloads = response.downloads.download;
	})  

	WHMCS.getItemdownload().then(function(response){
		$scope.itemdownloads = response.itemdownloads.itemdownload;
	})  
	$scope.items=[1];
	$scope.goPage = function(id){
		WHMCS.getItemdownload().then(function(response){
			$scope.items = filterFilter(response.itemdownloads.itemdownload, {category:id});
		});
		$scope.data1 = {
			show: true,
			hide: false
		};
	}
	$scope.countitem = function(id){
		WHMCS.getItemdownload().then(function(response){
			$scope.items = filterFilter(response.itemdownloads.itemdownload, {category:id});
			
		});
	}

})

app.controller('networksController', function($rootScope,$scope,$http,$location,$route,WHMCS,localStorageService,filterFilter,$anchorScroll) {

	// Check login 
	$scope.$emit('checklogin', localStorageService.get('data'));

	// Breadcrumbs
	$scope.breadcrumbs = [];
	$scope.breadcrumbs = WHMCS.getBreadcrumbs($route, 'Server Status');

	// Get Left sidebar
	$scope.project.left = awhmcs.plugin_url+'pages/left.html';
	
	// Get Networks
	WHMCS.getNetworks().then(function(response){
		$scope.networkspl = response.networks.network;
		$scope.networks = $scope.networkspl;
		$scope.openarray = ["Reported", "Investigating", "In Progress", "Outage"];
		$scope.countopen = filterFilter($scope.networkspl, {status: $scope.openarray});
		$scope.countscheduled = filterFilter($scope.networkspl, {status:'Scheduled'}, true);
		$scope.countresolved = filterFilter($scope.networkspl, {status:'Resolved'}, true);
	}) 

})

app.controller('contactController', function($rootScope,$scope,$http,$location,$route,WHMCS,localStorageService) {

	// Check login 
	//$scope.$emit('checklogin', localStorageService.get('data'));

	// Breadcrumbs
	$scope.breadcrumbs = [];
	$scope.breadcrumbs = WHMCS.getBreadcrumbs($route, 'Contact Us');

	$scope.result = false;
    $scope.resultMessage;
    $scope.formData; //formData is an object holding the name, email, subject, and message
    $scope.submitButtonDisabled = false;
    $scope.submitted = false; //used so that form errors are shown only after the form has been submitted

    $scope.submit = function(contactform) {
    
        var dataJson  =  $scope.formData;

		var req = {
				method: 'POST',
				url     : awhmcs.plugin_url+'action/sendmail.php',
				headers : {'Content-Type': 'application/json' },
				data: dataJson
		}    

		$http(req).then(function(response){
				$scope.result = true;
		});
    }
    WHMCS.getConfig().then(function(response){
		$scope.configs = response.configs.config;
        $scope.companyname = $scope.configs[0].value;
        $scope.email = $scope.configs[1].value;
        $scope.payto = $scope.configs[2].value;
        $scope.logo = $scope.configs[3].value;
	})  
	
})

app.directive('domainstep', function(){
	return {
		templateUrl: awhmcs.plugin_url+'pages/blocks/domainstep.html'
	}
})

