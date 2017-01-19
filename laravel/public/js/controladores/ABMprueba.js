var app = angular.module('Mutual', []).config(function($interpolateProvider){
    $interpolateProvider.startSymbol('{[{').endSymbol('}]}');
});
app.controller('ABMprueba', function($scope, $http) {
   
   $scope.enviarFormulario = function()
   {
   		var form = $("#formulario").serializeArray();
   		var json = JSON.stringify(form);
   		$http({
            url: 'abm',
            method: 'post',
            data: $.param(form),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function successCallback(response)
            {
               $scope.mensaje = response;
               $('#formulario')[0].reset();
               $scope.errores = '';
               console.log(response);
            }, function errorCallback(data)
            {
               $scope.errores = data.data;
            });
   }

   $scope.buscarRegistros = function()
   {
      $http({
         url: 'abm/mostrarRegistros',
         method: 'get'
      }).then(function successCallback(response)
      {
         $scope.registros = response.data;
         console.log(response);
      },
      function errorCallback(data)
      {
         console.log(response);
      });
   }

   $scope.buscarRegistros();
});