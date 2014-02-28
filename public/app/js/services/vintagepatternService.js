/**
 var vintagepatternService = angular.module('vintagepatternService', ['ngResource']);

vintagepatternService.factory('VintagePattern', ['$resource', function($resource){
	var VintPatternCollection = $resource('/api/patterns/');
	var VintPatternResource = $resource('/api/patterns/:id', {id: '@id'}, {update: {method: 'PUT'}});
	return $resource('/api/patterns/:id', {id: '@id'}, {
		query: {method: 'GET', isArray: true},
		save: {method: 'PUT'}, 
		destroy: {method: 'DELETE'}
	});
}]);
*/

var vintagepatternService = angular.module('vintagepatternService', []);
	vintagepatternService.factory('VintagePattern', function($http) {
		return {
			// get all the patterns
			get : function() {
				console.log("In the get");
				return $http.get('/public/api/v1/patterns');
			},

			// save a pattern (pass in pattern data)
			save : function(patternData) {
				//console.log(patternData);
				return $http({
					method: 'POST',
					url: '/public/api/v1/patterns',
					headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
					data: $.param(patternData)
				});
			}, 

			// destroy a pattern
			destroy : function(id) {
				return $http.delete('/public/api/v1/patterns/' + id);
			}
		}
	});