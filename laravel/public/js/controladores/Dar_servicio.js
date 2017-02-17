var app = angular.module('Mutual', ['ngMaterial']).config(function($interpolateProvider){
    $interpolateProvider.startSymbol('{[{').endSymbol('}]}');
});
app.controller('Dar_servicio', function($scope, $http, $compile, $q) {

	// machea a los socios en base al searchText
	$scope.querySocios = function(searchText)
	{
		return $http({
			url: 'dar_servicio/filtroSocios',
			method: 'post',
			data: {'nombre' : searchText}
			}).then(function successCallback(response)
				{
					return response.data;
				}, function errorCallback(data){
					console.log(data);
				});
	}
 
	$scope.queryProovedores = function(searchText)
	{
		return $http({
			url: 'dar_servicio/filtroProovedores',
			method: 'post',
			data: {'nombre' : searchText}
			}).then(function successCallback(response)
				{
					return response.data;
				}, function errorCallback(data){
					console.log(data);
				});
	}
});