<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Laravel4 AngularJS Authentication and security in public</title>
    <link href="app/css/bootstrap.min.css" rel="stylesheet">
    <link href="app/css/bootstrap-responsive.min.css" rel="stylesheet">
    <link href="app/css/app.css" rel="stylesheet" />
    
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>    
<script src="app/lib/angular/angular.js"></script>
<script src="app/lib/angular/angular-resource.js"></script>
<script src="app/lib/angular/angular-route.js"></script>
<script src="app/lib/angular/angular-sanitize.js"></script>

<script src="app/js/controllers/mainCtrl.js"></script> <!-- load our controller -->
<script src="app/js/services/vintagepatternService.js"></script> <!-- load our service -->
<script src="app/js/app.js"></script>
</head>
<body ng-app="vintagePatternApp" ng-controller="mainController">

<div class="col-md-8 col-md-offset-2">

	<!-- PAGE TITLE =============================================== -->
	<div class="page-header">
		<h2>Laravel and Angular Single Page Application</h2>
		<h4>Commenting System</h4>
	</div>

	<!-- NEW Pattern FORM =============================================== -->
	<form ng-submit="submitPattern()"> <!-- ng-submit will disable the default form action and use our function -->

		<!-- MAKER -->
		<div class="form-group">
			<input type="text" class="form-control input-sm" name="maker" ng-model="patternData.maker" placeholder="Maker">
		</div>
		
		<!-- STYLE NUMBER -->
		<div class="form-group">
			<input type="text" class="form-control input-sm" name="stylenumber" ng-model="patternData.stylenumber" placeholder="Style Number">
		</div>
		
		<!-- CAPTION -->
		<div class="form-group">
			<input type="text" class="form-control input-sm" name="caption" ng-model="patternData.caption" placeholder="caption">
		</div>
		
		<!-- PRINT YEAR -->
		<div class="form-group">
			<input type="text" class="form-control input-sm" name="printyear" ng-model="patternData.printyear" placeholder="printyear">
		</div>
		
		<!-- DESCRIPTION -->
		<div class="form-group">
			<input type="text" class="form-control input-sm" name="description" ng-model="patternData.description" placeholder="description">
		</div>
		
		<!-- SIZE -->
		<div class="form-group">
			<input type="text" class="form-control input-sm" name="size" ng-model="patternData.size" placeholder="size">
		</div>
		
		<!-- TYPE -->
		<div class="form-group">
			<input type="text" class="form-control input-sm" name="type" ng-model="patternData.type" placeholder="type">
		</div>
		
		<!-- NUM OF PIECES -->
		<div class="form-group">
			<input type="text" class="form-control input-sm" name="numofpieces" ng-model="patternData.numofpieces" placeholder="numofpieces">
		</div>
		
		<!-- SUBMIT BUTTON -->
		<div class="form-group text-right">	
			<button type="submit" class="btn btn-primary btn-lg">Submit</button>
		</div>
	</form>

	<!-- LOADING ICON =============================================== -->
	<!-- show loading icon if the loading variable is set to true -->
	<p class="text-center" ng-show="loading"><span class="fa fa-meh-o fa-5x fa-spin"></span></p>

	<!-- THE COMMENTS =============================================== -->
	<!-- hide these comments if the loading variable is true -->
	<div class="comment" ng-hide="loading" ng-repeat="pattern in patterns">
		<h3>Pattern #{{ pattern.id }} <small>by {{ pattern.maker }}</h3>
		<p>{{ pattern.stylenumber }}</p>

		<p><a href="#" ng-click="deletePattern(pattern.id)" class="text-muted">Delete</a></p>
	</div>

</div>


</body>
</html>