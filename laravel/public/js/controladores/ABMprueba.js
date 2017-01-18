var app = angular.module('Mutual', []);
app.controller('ABMprueba', function($scope, $http) {
   $scope.enviarFormulario = function() {
   		var form = $("#formulario").serializeArray();
   		var json = JSON.stringify(form);
   		$http({
            url: 'abm',
            method: 'post',
            
            data: $.param(form),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
           
         }).then(function successCallback(response){
            console.log(response);
         });
   	
   		console.log($.param(form));
   		console.log(json[0]);
   		console.log(json);
   		
   }
});