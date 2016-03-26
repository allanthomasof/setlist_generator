var app = angular.module("SetlistGenerator", []);
var host = "localhost";

app.controller("SetlistGeneratorController", function($scope, $http) {
    window.scrollTo(0,1);
    
    

	$scope.message = "Gerador de Setlist!";
});