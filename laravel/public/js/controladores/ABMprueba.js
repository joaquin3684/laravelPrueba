var app = angular.module('Mutual', ['ngMaterial', 'ngSanitize', 'ngTable']).config(function($interpolateProvider){
    $interpolateProvider.startSymbol('{[{').endSymbol('}]}');
});
app.controller('ABM', function($scope, $http, $compile, $sce, NgTableParams, $filter) {
   
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
               $scope.traerRelaciones();
            }, function errorCallback(data)
            {
               console.log(data);
               $scope.errores = data.data;
            });
        
   }

   $scope.traerRelaciones = function(relaciones)
   {  
      var metodito = 'get';
      var abm = $("#tipo_tabla").val();
      var urlabm = abm + "/traerElementos";
      
      $http({
            url: urlabm,
            method: metodito
        }).then(function successCallback(response)
        {
            if(typeof response.data === 'string')
            {
                return [];
            }
            else
            {
                console.log(response);
                $scope.datosabm = response.data;
                $scope.paramsABMS = new NgTableParams({
                    page: 1,
                    count: 10
                }, {
                    total: $scope.datosabm.length,
                    getData: function (params) {
                        $scope.datosabm = $filter('orderBy')($scope.datosabm, params.orderBy());
                        return $scope.datosabm.slice((params.page() - 1) * params.count(), params.page() * params.count());
                    }
                });
            }

        }, function errorCallback(data)
        {
            console.log(data.data);
        });
   }

   $scope.agregarPantalla = function()
   {
     
      var codigo = '';
      var array = [];
      for(var i = 0; $scope.numeroDePantallas > i; i++){

      codigo += '<div class="item form-group" >' +
           '<label class="control-label col-md-3 col-sm-3 col-xs-12" for="dni" ng-click="console.log('+'anda'+')">Pantalla <span class="required">*</span></label>'+
         '<div class="col-md-6 col-sm-6 col-xs-12">'+
       '<select id="pantallas'+i+'" name="pantalla'+i+'" class="form-control col-md-7 col-xs-12" ></select>     </div>      </div>'+
         '<div style=" margin-bottom:20px;"><label class="checkbox-inline col-sm-offset-4 col-xs-offset-2"  ><input type="checkbox" value="crear" name="valor'+i+'[]">Crear</label> <label class="checkbox-inline"><input type="checkbox" value="editar" name="valor'+i+'[]">Editar</label> <label class="checkbox-inline"><input type="checkbox" value="borrar" name="valor'+i+'[]">Borrar</label> <label class="checkbox-inline"><input type="checkbox" name="valor'+i+'[]" value="visualizar">Visualizar</label> </div>';

      }
      //$scope.agregarCodigo = $sce.trustAsHtml(codigo);
      $('#agregarCodigo').html(codigo);

         var url = 'roles/traerRelacionroles';
         $http({
            url: url,
            method: 'get',
         }).then(function successCallback(response)
         {
          
          console.log(response);
            $.each(response.data, function(val, text) {
              
               for(var j = 0; $scope.numeroDePantallas > j; j++){
                
               $('#pantallas'+j).append($("<option />").val(text.nombre).text(text.nombre));
              
                 
               }
               
            });
         }, function errorCallback(data)
         {
            console.log(data);
         });
   }

   $scope.traerRelaciones();

   
});

