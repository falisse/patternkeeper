

var app = angular.module("app", ["ngCookies"]);

/** CONTROLLERS **/

// Main Controller
app.controller("main", function($scope) {
  console.log("main.init");
  this.shared = "hello world";
  $scope.main = this;
});

// Products Controller
app.controller("products", function($scope, CategoryService, ProductService, BasketService) {
  	var self = this, 
  		categories = CategoryService.getCategories(), 
  		products = ProductService.getProducts();
  		
  		categories.success(function(data){
  			self.categories = data;	
  		});
  		
  		products.success(function(data){
  			self.products = data;
  		});
  		
  		this.category = null;
  		this.filterByCategory = function(product){
  			if(self.category !== null){
  				return product.category.id === self.category.id;
  			}
  			
  			return true;
  		};
  		
  		this.setCategory = function(category){
  			self.category = category;
  		};
  		
  		this.addToBasket = function(product){
  			BasketService.add(product);
  		};
  		
  	$scope.products = this;
});

// Basket Controller
app.controller("basket", function($scope, BasketService) {
  var self = this, 
  products = BasketService.getProducts();
  self.products = products;
  
  $scope.basket = this;
  //console.log("basket.init:", $scope.basket);
});


/** SERVICES **/

// Category Service
app.factory("CategoryService", function($http) {
  return {
    "getCategories": function() {
      return $http.get("/public/demoapi/v1/category");
    }
  };
});

// Product Service
app.factory("ProductService", function($http) {
  return {
    "getProducts": function() {
      return $http.get("/public/demoapi/v1/product");
    }
  };
});

// Basket Service
app.factory("BasketService", function($cookies){
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
app.factory('AccountService', function($http){
	var account = null;
	
	return {
		'authenticate' : function(email, password){
			var request = $http.post("/public/demoapi/v1/authenticate", {
				'email' : email, 
				'password' : password
			});
			
			request.success(function(data){
				if (data.status !== 'error'){
					account = data.account;
				}
			});
			
			return request;
		}, 
		
		'getAccount' : function(){
			return account;
		}
	}
	
});

// Order Service
app.factory('OrderService', function($http, AccountService, BasketService){
	
	return {
		"pay": function(number, expiry, security) {
	      var account  = AccountService.getAccount();
	      var products = BasketService.getProducts();
	      var items    = [];
	      for (var i = 0; i < products.length; i++) {
	        var product = products[i];
	        items.push({
	          "product_id" : product.id,
	          "quantity"   : product.quantity
	        });
	      }
	      return $http.post("/order/add", {
	        "account"  : account.id,
	        "items"    : JSON.stringify(items),
	        "number"   : number,
	        "expiry"   : expiry,
	        "security" : security
	      });
	    }
  };
});
