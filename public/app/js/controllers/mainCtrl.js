'use strict';

/* Controllers */

var mainCtrl = angular.module('mainCtrl', []);
	// inject the VintagePattern service into our controller
	mainCtrl.controller('mainController', function($scope, $http, VintagePattern) {
		// object to hold all the data for the new VintagePattern form
		$scope.patternData = {};

		// loading variable to show the spinning loading icon
		$scope.loading = true;

		// get all the VintagePatterns first and bind it to the $scope.VintagePatterns object
		// use the function we created in our service
		// GET ALL VintagePatternS ====================================================
		VintagePattern.get()
			.success(function(data) {
				$scope.patterns = data;
				$scope.loading = false;
			});

		// function to handle submitting the form
		// SAVE A VintagePattern ======================================================
		$scope.submitPattern = function() {
			$scope.loading = true;
			//console.log('$scope.patternData /n' + $scope.patternData);
			// save the VintagePattern. pass in VintagePattern data from the form
			// use the function we created in our service
			VintagePattern.save($scope.patternData)
				.success(function(data) {

					// if successful, we'll need to refresh the VintagePattern list
					VintagePattern.get()
						.success(function(getData) {
							$scope.patterns = getData;
							$scope.loading = false;
						});

				})
				.error(function(data) {
					console.log(data);
				});
		};

		// function to handle deleting a VintagePattern
		// DELETE A VintagePattern ====================================================
		$scope.deletePattern = function(id) {
			$scope.loading = true; 

			// use the function we created in our service
			VintagePattern.destroy(id)
				.success(function(data) {

					// if successful, we'll need to refresh the VintagePattern list
					VintagePattern.get()
						.success(function(getData) {
							$scope.patterns = getData;
							$scope.loading = false;
						});

				});
		};

	});
	