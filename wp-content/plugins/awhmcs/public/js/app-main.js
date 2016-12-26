app.controller('AppCtrl', function($rootScope, $scope, $http,$location, localStorageService, WHMCS) {
	
	// Get number product in cart
	//$scope.number = Object.keys(localStorageService.get('cart')).length + 1;
	// Get contries
	
	// Get app url
	$scope.app_url = awhmcs.app_permalink;

	// Check curren Page Left menu
	$scope.isCurrentPath = function (path) {
      return $location.path() == path;
    };
    
    $scope.isCurrentMenu = function (path) {
      return $location.path() == path;
    };


	WHMCS.contries().then(function(response){
	    $scope.countries = response.data;
    });	

	$rootScope.$on('checklogin', function(event, data) {
		
		if(data){
			$scope.checkLogin = data;
		}else{
			$location.path('/login');
		}
	    	
  	}); 

	$rootScope.$on('cpage', function(event, data) {
    	$scope.currentPage = data;
  	});    
									
	$scope.project = {
	  	domaintype: 'domainregister',
	  	available: false,
	  	countrycode: '',
	  	cartright: 'pages/cart/list.html' // Default content cart page
	};
	  
	$scope.client = {};

	if(WHMCS.data('data')){
	  	$scope.client.id = WHMCS.data('data').clientid;
	  	$scope.client.firstname = WHMCS.data('data').client.firstname;
	}
	  
	// Load basic data
	//if(!localStorageService.get('pricing'))

	WHMCS.loaddata().then(function(response){
		//console.log(response);
		localStorageService.set('pricing', response.pricing)
		localStorageService.set('extensions', response.extensions)
	});

});	

app.directive('mainMenu', function($location, filterFilter, localStorageService, WHMCS){
	return {
		restrict: 'E',
		scope: {},
		templateUrl: function( elem, attrs ) {
			
			var menuTemplate = awhmcs.plugin_url+'pages/menu-client.html';

/*
			if(angular.isObject(WHMCS.data('data'))){
				menuTemplate = awhmcs.plugin_url+'pages/menu-client.html';
			}
*/

           return menuTemplate;
		},
		link: function(scope){
			
			scope.nav = [
				{ name: 'Home', page: '#/', login: 2 },				
				{ name: 'Services', page: 'javascript:void(0)', login: 1, sub:[{ name: 'My Services', page: 'services', divider: 1 }, { name: 'Order New Services', page: 'products' }]},// { name: 'View Available Addons', page: 'viewavailableaddons' }] },
				{ name: 'Domains', page: 'javascript:void(0)', login: 1, sub:[{ name: 'My Domains', page: 'domains' }, { name: 'Renew Domains', page: 'renewdomains' }, { name: 'Transfer domain to Us', page: 'transferdomain' }, { name: 'Domain Search', page: 'domainchecker' }] },
				{ name: 'Billing', page: 'javascript:void(0)', login: 1, sub:[{ name: 'My Invoices', page: 'myinvoices' }, { name: 'My Quotes', page: 'myquotes' }, { name: 'Mass Payment', page: 'masspay' }] },
				{ name: 'Support', page: 'javascript:void(0)', login: 1, sub:[{ name: 'Tickets', page: 'tickets' }, { name: 'Announcements', page: 'announcements' }, { name: 'Knowledgebase', page: 'knowledgebase' }, { name: 'Downloads', page: 'downloads' }, { name: 'Network Status', page: 'networkstatus' }] },
				{ name: 'Open Ticket', page: '#/submitticket', login: 1 },
				{ name: 'Contact Us', page: '#/contact', login: 0 }					
				
			];
		}
	}
})