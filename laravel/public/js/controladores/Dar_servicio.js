var app = angular.module('Mutual', ['ngMaterial']).config(function($interpolateProvider){
    $interpolateProvider.startSymbol('{[{').endSymbol('}]}');
});
app.controller('Dar_servicio', function($scope, $http, $compile, $q) {

	// machea a los socios en base al searchText
	$scope.query = function(searchText, ruta)
	{
		return $http({
			url: 'dar_servicio/'+ruta,
			method: 'post',
			data: {'nombre' : searchText}
			}).then(function successCallback(response)
				{
					return response.data;
				}, function errorCallback(data){
					console.log(data);
				});
	}

 	$scope.traerProductos = function(searchText)
 	{
 		console.log($scope.proovedor);
 		return $http({
			url: 'productos/TraerProductos',
			method: 'post',
			data: {'nombre': searchText, 'proovedor': $scope.proovedor.id}
			}).then(function successCallback(response)
				{
					console.log(response);
					return response.data;

				}, function errorCallback(data){
					console.log(data);
				});
 	}

 	$scope.crearMovimiento = function()
 	{
 		$http({
			url: 'movimientos',
			method: 'post',
			data: {'id_asociado': $scope.socio.id, 'id_producto': $scope.producto.id, 'importe': $scope.importe, 'nro_cuotas': $scope.nro_cuotas}
			}).then(function successCallback(response)
				{
					console.log(response);
					return response.data;

				}, function errorCallback(data){
					console.log(data);
				});
 	}
 	$scope.habilitacion = true;
 	$scope.habilitar = function()
 	{	
 		
 		if($scope.proovedor == null)
 		{
 			$scope.habilitacion = true;
 		} else {
 			$scope.habilitacion = false;
 			$scope.producto = '';
 		}
 	}
	
});