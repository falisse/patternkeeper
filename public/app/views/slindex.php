<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>Stitch Lite</title>
   <link href="app/css/bootstrap.min.css" rel="stylesheet">
    <link href="app/css/bootstrap-responsive.min.css" rel="stylesheet">
    <link href="app/css/app.css" rel="stylesheet" />
    <link href="app/css/shared.css" rel="stylesheet" />
    
	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>    
	<script src="app/lib/angular/angular.js"></script>
	<script src="app/lib/angular/angular-resource.js"></script>
	<script src="app/lib/angular/angular-route.js"></script>
	<script src="app/lib/angular/angular-sanitize.js"></script>
	<script src="app/lib/angular/angular-cookies.js"></script>
	
  </head>
  <body ng-app="SLApp">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h1>
            Stitch Lite
          </h1>
        </div>
      </div>
      <div class="row">
 
        <div class="col-md-4" ng-controller="slProducts">
        <div>
        	<h2>Account: {{channels[0].shopname}} </h2>
        	<div class="">
        		<a class="remove glyphicon glyphicon-open" href="#" ng-click="synchProducts()">Refresh Product List from Channels</a>
        	</div>
        </div>
       
          <h2>
            Products
          </h2>
          <form class="producttable">
            <table class="table">
            <thead>
            	<tr>
            		<th>Name</th>
            		<th>Description</th>
            		<th>Inventory</th>	
            		
            	</tr>
            </thead>	
            <tbody>
              <tr class="product" ng-repeat="product in products">
                <td class="name">
                  {{product.name}}
                </td>
                <td class="product">
                  {{product.description}}
                </td>
                <td class="variants">
                  <a class="remove glyphicon glyphicon-open" href="#" ng-click="basket.remove(product)">{{product.variants.length}} variant in inventory</a>
                </td>
                <td class="variants">
                	
                	<table class="table">
                		<thead>
		            	<tr>
		            		<th>SKU</th>
		            		<th>Price</th>
		            		<th>Qty</th>	
		            	</tr>
		            </thead>	
		            <tbody>
		            	
		            <tr ng-repeat="variant in product.variants">
			            <td class="variants sku">
		                  {{variant.sku}}
		                </td>
		              
		                <td class="product">
		                  {{variant.price}}
		                </td>
		                <td class="product">
		                  {{variant.quantity}}
		                </td>
	                </tr>
	                </tbody>
                	</table>
                  
                </td>
                
              </tr>
              </tbody>
            </table>
          </form>
        </div>
      </div>
    </div>
    <script src="app/js/sl-shared.js"></script>
  </body>
</html>