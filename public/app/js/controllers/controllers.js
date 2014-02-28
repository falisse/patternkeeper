'use strict';

/* Controllers */

var myAppControllers = angular.module('myApp', []);

    myAppControllers
    	.controller('loginController',function($scope,$sanitize,$location,Authenticate){
        $scope.login = function(){
            Authenticate.save({
                'email': $sanitize($scope.email),
                'password': $sanitize($scope.password)
            },function() {
                $scope.flash = ''
                $location.path('/home');
            },function(response){
                $scope.flash = response.data.flash
            })
        }
	})
    .controller('homeController',function($scope,$location,Authenticate){
        $scope.logout = function (){
            Authenticate.get({},function(){
                $location.path('/');
            })
        }
})