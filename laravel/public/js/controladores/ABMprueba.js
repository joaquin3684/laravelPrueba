var app = angular.module('Mutual', ['ngMaterial']).config(function($interpolateProvider){
    $interpolateProvider.startSymbol('{[{').endSymbol('}]}');
});
app.controller('ABM', function($scope, $http, $compile) {
   
  // manda las solicitud http necesarias para manejar los requerimientos de un abm
   $scope.enviarFormulario = function(tipoSolicitud, id = '')
   {
         var form = '';
         var abm = $("#tipo_tabla").val();
         switch(tipoSolicitud)
         {
            case 'Editar':
               var metodo = 'put';
               var form = $("#formularioEditar").serializeArray();
               var id = $('input[name=id]').val();
               break;
            case 'Alta':
               var metodo = 'post';
               var form = $("#formulario").serializeArray();
               break;
            case 'Borrar':
               var metodo = 'delete';
               break;
            case 'Mostrar':
               var metodo = 'get';
               break;
            default:
               console.log("el tipo de solicitud no existe");
               break;
         }
         
         var url = id == '' ? abm : abm+'/'+id;
         
         $http({
            url: url,
            method: metodo,
            data: $.param(form),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function successCallback(response)
            {
               if(tipoSolicitud == 'Mostrar')
                  {
                     console.log(response);
                     llenarFormulario('formularioEditar',response.data);
                  } 
               $scope.mensaje = response;
               $('#formulario')[0].reset();
               $scope.errores = '';
               console.log(response.data);
            }, function errorCallback(data)
            {
               console.log(data);
               $scope.errores = data.data;
            });

   }

   $scope.traerRelaciones = function(relaciones)
   {  
     
      for(x in relaciones)
      {
       
         var url = relaciones[x].tabla + '/traerRelacion'+relaciones[x].tabla;
         $http({
            url: url,
            method: 'get',
         }).then(function successCallback(response)
         {
          
            $.each(response.data, function(val, text) {
               
               $(relaciones[x].select).append($("<option />").val(text.id).text(text.nombre));
               $(relaciones[x].select+'_Editar').append($("<option />").val(text.id).text(text.nombre));
            });
         }, function errorCallback(data)
         {
            console.log(data);
         });
      }
   }

   $scope.puto = function()
   {
      alert('forro');
   }
});

