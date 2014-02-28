

var SLApp = angular.module("SLApp", ["ngCookies"]);

/** CONTROLLERS **/

// Main Controller
SLApp.controller("main", function($scope) {
  
  $scope.main = this;
});

// Products Controller
SLApp.controller("slProducts", function($scope, $http, ProductService) {
		
		ProductService.getProducts()
  		.success(function(data){
  			$scope.products = data.products; 		
  			$scope.account = data.account;
  			$scope.channels = data.account.channels;	
  			
  		});

// Synch Products ======================================================
	$scope.synchProducts = function(){
		$scope.loading = true;	
		console.log("in synch");	
			ProductService.synch($scope.account)
				.success(function(data) {
					// if successful, we'll need to refresh the product list
					ProductService.getProducts()
						.success(function(getData) {
							$scope.products = getData.products; 		
  							$scope.account = getData.account;
  							$scope.channels = getData.account.channels;		
							//$scope.products = this;
						});
				})
				.error(function(data) {
					console.log(data);
				});
		};		
});


/** SERVICES **/

// Category Service
SLApp.factory("VariantsService", function($http) {
  return {
    "getCategories": function() {
      return $http.get("/public/demoapi/v1/category");
    }
  };
});

// Product Service
SLApp.factory("ProductService", function($http) {
  return {
  	
    "getProducts": function() {
      return $http.get("/public/stitchlite/api/v1/products?email=falisse@test.com&password=test123");
    }, 
    
    "updateProduct": function(product){
    	// need a way to reconcile products
    },
    
    "synch": function(account){
				return $http({
					method: 'POST',
					url: '/public/stitchlite/api/v1/sync',
					headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
					data: $.param({'account_id': account.id})
				});
    }
    
  };
});

// Basket Service
SLApp.factory("BasketService", function($cookies){
	var products = JSON.parse($cookies.products || '[]');
	
	return {
		'getProducts' : function(){
			return products;
		}, 
		
		'add' : function(product){
			products.push({
				'id' : product.id, 
				'name' : product.name, 
				'price' : product.price, 
				'total'	: product.price * 1, 
				'quantity'	: 1
			});
			
			this.store();
		},
		 
		'remove' : function(product){
			for(var i = 0; i < products.length; i++){
				var next = products[i];
				
				if(next.id === product.id){
					products.slice(i, 1);
				}
			}
			
			this.store();
		}, 
		
		'update' : function(){
			for(var i = 0; i < products.length; i++){
				var product = products[i], 
					raw = product.quantity * product.price;
				
				product.total = Math.round(raw * 100) / 100;		
			}
			
			this.store();
		}, 
		
		'store' : function(){
			$cookies.product = JSON.stringify(products);
		}, 
		
		'clear' : function(){
			products.length = 0;
			this.store;
		} 
	}
});

// Account Service
SLApp.factory('AccountService', function($http){
	var account = null;

	
});

SLApp.directive('loginDialog', function() {
   return {
       templateUrl: 'loginDialog.html',
       restrict: 'E',
       replace: true,
       controller: CredentialsController,
       link: function(scope, element, attributes, controller) {
           scope.$on('event:auth-loginRequired', function() {
               element.modal('show');
           });

           scope.$on('event:auth-loginConfirmed', function() {
               element.modal('hide');
               scope.credentials.password = '';
           });
       }
   } 
});
