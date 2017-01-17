var app = angular.module('Mutual', []);
app.controller('ABMprueba', function($scope, $http) {
   $scope.enviarFormulario = function() {
   		var form = $("#formulario").serializeArray();
   		console.log(form);
   		console.log(JSON.stringify(form));
   		
   }
});