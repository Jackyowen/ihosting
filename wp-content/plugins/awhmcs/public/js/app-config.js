app.config(function($routeProvider, $locationProvider){
	$routeProvider
	.when('/', {
		templateUrl: awhmcs.plugin_url+'pages/home.html',
		controller: 'homeController'
	})
	.when('/redirect', {
		templateUrl: awhmcs.plugin_url+'pages/redirect.html',
		controller: 'redirectController'
	})	
	.when('/login', {
		templateUrl: awhmcs.plugin_url+'pages/login.html',
		controller: 'LoginController'
	})	
	.when('/domainchecker', {
		templateUrl: awhmcs.plugin_url+'pages/domainchecker.html',
		controller: 'domainController',
		resolve: {
            init: function(WHMCS){
                WHMCS._init('domain');
            },
            breadcrumbs: function(WHMCS, $route){
				return WHMCS.getBreadcrumbs($route, 'Domain checker');	            
            }
        }
	})	
	.when('/transferdomain', {
		templateUrl: awhmcs.plugin_url+'pages/transferdomain.html',
		controller: 'transferController'
	})	
	.when('/pwreset', {
		templateUrl: awhmcs.plugin_url+'pages/resetpwd.html',
		controller: 'pwresetController'
	})	
	.when('/forgot', {
		templateUrl: awhmcs.plugin_url+'pages/forgotpassword.html',
		controller: 'forgotpasswordController'
	})	
	.when('/services', {
		templateUrl: awhmcs.plugin_url+'pages/myservice.html',
		controller: 'servicesController'
	})	
	.when('/services/id/:id', {
		templateUrl: awhmcs.plugin_url+'pages/service.html',
		controller: 'serviceController'
	})												
	.when('/domains', {
		templateUrl: awhmcs.plugin_url+'pages/mydomains.html',
		controller: 'mydomainsController'
	})	
	.when('/products', {
		templateUrl: awhmcs.plugin_url+'pages/products.html',
		controller: 'productsController',
		resolve: {
            init: function(WHMCS){
                WHMCS._init('products');
            }
        }		
	})	
	.when('/products/domain', {
		templateUrl: awhmcs.plugin_url+'pages/products/domain.html',
		controller: 'productsController'
	})		
	.when('/viewavailableaddons', {
		templateUrl: awhmcs.plugin_url+'pages/viewavailableaddons.html',
		controller: 'viewaddonsController'
	})	
	.when('/myinvoices', {
		templateUrl: awhmcs.plugin_url+'pages/myinvoices.html',
		controller: 'myinvoicesController'					
	})										
	.when('/client', {
		templateUrl: awhmcs.plugin_url+'pages/client.html',
		controller: 'clientController',
		resolve: {
            breadcrumbs: function(WHMCS, $route){
				return WHMCS.getBreadcrumbs($route, 'Client Manager');	            
            }
        }		
	})
	.when('/myquotes', {
		templateUrl: awhmcs.plugin_url+'pages/myquotes.html',
		controller: 'myquotesController'
	})
	.when('/register', {
		templateUrl: awhmcs.plugin_url+'pages/register.html',
		controller: 'registerController'
	})				
	.when('/update', {
		templateUrl: awhmcs.plugin_url+'pages/update.html',
		controller: 'updateController'
	})	
	.when('/logout', {
		templateUrl: awhmcs.plugin_url+'pages/logout.html',
		controller: 'logoutController'					
	})	
	.when('/cart', {
		templateUrl: awhmcs.plugin_url+'pages/cart.html',
		controller: 'cartController',
		resolve: {
            init: function(WHMCS){
                WHMCS._init('cart');
            }
        }							
	})	
	.when('/checkout', {
		templateUrl: awhmcs.plugin_url+'pages/checkout.html',
		controller: 'checkoutController',
		resolve: {
            init: function(WHMCS){
                WHMCS._init('checkout');
            }
        }							
	})	
	.when('/announcements', {
		templateUrl: awhmcs.plugin_url+'pages/announcements.html',
		controller: 'announcementsController',
		label: 'Announcements'					
	})					
	.when('/announcements/id/:id', {
		templateUrl: awhmcs.plugin_url+'pages/announcement.html',
		controller: 'announcementController',
		parent: '/Announcements'					
	})		
	.when('/contact', {
		templateUrl: awhmcs.plugin_url+'pages/contact.html',
		controller: 'contactController'					
	})				
	.when('/contacts/action/:action', {
		templateUrl: awhmcs.plugin_url+'pages/addcontact.html',
		controller: 'addcontactController'					
	})				
	.when('/invoice/id/:id', {
		templateUrl: awhmcs.plugin_url+'pages/invoiced.html',
		controller: 'invoiceController'					
	})
	.when('/renewdomains', {
		templateUrl: awhmcs.plugin_url+'pages/renewdomains.html',
		controller: 'renewdomainsController'					
	})		
	.when('/domains/id/:id', {
		templateUrl: awhmcs.plugin_url+'pages/domaindetails.html',
		controller: 'domainsController'					
	})		
	.when('/404', {
		templateUrl: awhmcs.plugin_url+'pages/404.html',
		controller: 'notfoundController'					
	})															
	.when('/resetpassword', {
		templateUrl: awhmcs.plugin_url+'pages/resetpassword.html',
		controller: 'resetpasswordController'					
	})	
	.when('/knowledgebase', {
		templateUrl: awhmcs.plugin_url+'pages/knowbase.html',
		controller: 'knowbaseController'					
	})	
	.when('/knowledgebase/id/:id', {
		templateUrl: awhmcs.plugin_url+'pages/articlesknow.html',
		controller: 'arknowbaseController'					
	})	
	.when('/submitticket', {
		templateUrl: awhmcs.plugin_url+'pages/submitticket.html',
		controller: 'submitticketController'					
	})	
	.when('/tickets', {
		templateUrl: awhmcs.plugin_url+'pages/tickets.html',
		controller: 'ticketsController'					
	})
	.when('/ticket/id/:id', {
		templateUrl: awhmcs.plugin_url+'pages/ticket.html',
		controller: 'ticketController'					
	})				
	.when('/openticket', {
		templateUrl: awhmcs.plugin_url+'pages/openticket.html',
		controller: 'openticketController'					
	})	
	.when('/masspay', {
		templateUrl: awhmcs.plugin_url+'pages/masspay.html',
		controller: 'masspayController'					
	})	
	.when('/downloads', {
		templateUrl: awhmcs.plugin_url+'pages/downloads.html',
		controller: 'downloadsController'					
	})	
	.when('/callback', {
		templateUrl: awhmcs.plugin_url+'pages/redirect.html',
		controller: 'callbackController'					
	})	
	.when('/networkstatus', {
		templateUrl: awhmcs.plugin_url+'pages/networks.html',
		controller: 'networksController'					
	})									
/*
	.otherwise({
		redirectTo: '404'
	});
*/
// 				$locationProvider.html5Mode(true);
});