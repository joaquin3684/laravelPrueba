var app = angular.module('Mutual', ['ngMaterial', 'ngSanitize', 'chart.js']).config(function($interpolateProvider){
    $interpolateProvider.startSymbol('{[{').endSymbol('}]}');
});
app.controller('pago_proovedores', function($scope, $http, $compile, $sce) {
   
// ESTAS FUNCIONES SON PARA DEFINIR LOS PARAMETROS DE BUSQUEDA EN LA FUNCION QUERY
   $scope.buscandoSocios = function(searchText)
   {
      $scope.campoSocio = 'socios.nombre';
      $scope.campoOrganismo = 'organismos.id';
      $scope.campoProovedor = 'proovedores.id';
      $scope.campoProducto = 'movimientos.id_producto';
      $scope.operadorSocio = 'LIKE';
      $scope.operadorOrganismo = '=';
      $scope.operadorProovedor = '=';
      $scope.operadorProducto = '=';
      $scope.valorOrganismo = $scope.organismo == null ? '' : $scope.organismo.id_organismo;
      $scope.valorSocio = '%'+searchText+'%';
      $scope.valorProovedor = $scope.proovedor == null ? '' : $scope.proovedor.id_proovedor;
      $scope.valorProducto = $scope.producto == null ? '' : $scope.producto.id_producto;
      $scope.groupBy = 'socio';
   }

   $scope.buscandoOrganismos = function(searchText)
   {
      $scope.campoOrganismo = 'organismos.nombre';
      $scope.campoSocio = 'movimientos.id_asociado';
      $scope.campoProovedor = 'proovedores.id';
      $scope.campoProducto = 'movimientos.id_producto';
      $scope.operadorOrganismo = 'LIKE';
      $scope.operadorProovedor = '=';
      $scope.operadorProducto = '=';
      $scope.operadorSocio = '=';
      $scope.valorOrganismo = '%'+searchText+'%';
      $scope.valorSocio = $scope.socio == null ? '' : $scope.socio.id_asociado;
      $scope.valorProovedor = $scope.proovedor == null ? '' : $scope.proovedor.id_proovedor;
      $scope.valorProducto = $scope.producto == null ? '' : $scope.producto.id_producto;
      $scope.groupBy = 'organismo';
   }

   $scope.buscandoProovedores = function(searchText)
   {
      $scope.campoSocio = 'movimientos.id_asociado';
      $scope.campoProovedor = 'proovedores.nombre';
      $scope.campoProducto = 'movimientos.id_producto';
      $scope.campoOrganismo = 'organismos.id';
      $scope.operadorProovedor = 'LIKE';
      $scope.operadorOrganismo = '=';
      $scope.operadorProducto = '=';
      $scope.operadorSocio = '=';
      $scope.valorProovedor = '%'+searchText+'%';
      $scope.valorOrganismo = $scope.organismo == null ? '' : $scope.organismo.id_organismo;
      $scope.valorSocio = $scope.socio == null ? '' : $scope.socio.id_asociado;
      $scope.valorProducto = $scope.producto == null ? '' : $scope.producto.id_producto;
      $scope.groupBy = 'proovedor';
   }

   $scope.buscandoProductos = function(searchText)
   {
      $scope.campoSocio = 'movimientos.id_asociado';
      $scope.campoOrganismo = 'organismos.id';
      $scope.campoProovedor = 'proovedores.id';
      $scope.campoProducto = 'productos.nombre';
      $scope.operadorProducto = 'LIKE';
      $scope.operadorSocio = '=';
      $scope.operadorOrganismo = '=';
      $scope.operadorProovedor = '=';
      $scope.valorProoducto = '%'+searchText+'%';
      $scope.valorOrganismo = $scope.organismo == null ? '' : $scope.organismo.id_organismo;
      $scope.valorSocio = $scope.socio == null ? '' : $scope.socio.id_asociado;
      $scope.valorProovedor = $scope.proovedor == null ? '' : $scope.proovedor.id_proovedor;
      $scope.groupBy = 'producto';
   }
// FIN DE FUNCIONES

   // ESTA FUNCION ES LA QUE HACE LA BUSQUEDA PARA EL AUTOCOMPLETE
  $scope.query = function(searchText, ruta)
   {
      var proovedor, socio, producto;
      proovedor = $scope.proovedor == null ? '' : $scope.proovedor.id;
      socio = $scope.socio == null ? '' : $scope.socio.id;
      producto = $scope.producto == null ? '' : $scope.producto.id;

      return $http({
         url: 'movimientos/datosAutocomplete',
         method: 'post',
         data: {'filtros': [{'campo': $scope.campoProovedor, 'valor': $scope.valorProovedor, 'operador': $scope.operadorProovedor}, {'campo': $scope.campoSocio, 'valor': $scope.valorSocio, 'operador': $scope.operadorSocio}, {'campo': $scope.campoProducto, 'valor':$scope.valorProducto, 'operador': $scope.operadorProducto}, {'campo': $scope.campoOrganismo, 'valor':$scope.valorOrganismo, 'operador': $scope.operadorOrganismo} ], 'groupBy': $scope.groupBy}
         }).then(function successCallback(response)
            {
               console.log(response.data.movimientos);
               if(typeof response.data == 'string')
               {
                  return [];
               }
               else
               {
                  return response.data.movimientos;
               }

            }, function errorCallback(data)
            {
               console.log(data.data);
            });
   }

   // DATOS PARA FILTRAR LA DATATABLE 
   $scope.data = [
      {'campo': 'movimientos.id_asociado', 'valor': $scope.valorSocio, 'operador': '='},
      {'campo': 'movimientos.id_producto', 'valor': $scope.valorProducto, 'operador': '='},
      {'campo': 'proovedores.id', 'valor': $scope.valorProovedor, 'operador': '='}, 
      {'campo': 'organismos.id', 'valor': $scope.valorOrganismo, 'operador': '='},
      {'campo': 'importeTotal', 'valor':$scope.minimo_importe, 'operador': '>='},
      {'campo': 'importeTotal', 'valor':$scope.maximo_importe, 'operador': '<='},
      {'campo': 'cuotas.importe', 'valor':$scope.minimo_importe_cuota, 'operador': '>='},
      {'campo': 'cuotas.importe', 'valor':$scope.maximo_importe_cuota, 'operador': '<='},
      {'campo': 'cuotas.nro_cuota', 'valor':$scope.minimo_nro_cuota, 'operador': '>='},
      {'campo': 'cuotas.nro_cuota', 'valor':$scope.maximo_nro_cuota, 'operador': '<='},
      {'campo': 'cuotas.fecha_pago', 'valor':$scope.desde, 'operador': '>='},
      {'campo': 'cuotas.fecha_pago', 'valor':$scope.hasta, 'operador': '<='}
   ];
   
   // TABLA DE LA DATATABLE  
   var tabla =  $("#datatable-responsive").DataTable({
      processing: true,
      serverSide: true,
      ajax:
      {
         url:"pago_proovedores/datos",
         type: "POST",
         headers:
         {
            'X-CSRF-TOKEN': $('#token').val()
         },
         data: function (d)
         {
            d.filtros = $scope.data
         }
      },  
      columns: 
      [
         
         {data: 'socio', name: 'socio'},
         {data: 'proovedor', name: 'proovedor'},
         {data: 'producto', name: 'producto'},
         {data: 'importe', name: 'cuotas.importe'},
         {data: 'nro_cuota', name: 'cuotas.nro_cuota'},
      ],
      footerCallback: function ( row, data, start, end, display )
      {
         var api = this.api(), data;
 
         // Remove the formatting to get integer data for summation
         var intVal = function ( i ) 
         {
            return typeof i === 'string' ?
            i.replace(/[\$,]/g, '')*1 :
            typeof i === 'number' ?
            i : 0;
         };
 
         // Total over all pages
         total = api
            .column( 4 )
            .data()
            .reduce( function (a, b) {
               return intVal(a) + intVal(b);
            }, 0 );
 
         // Total over this page
         pageTotal = api
            .column( 4, { page: 'current'} )
            .data()
            .reduce( function (a, b) {
               return intVal(a) + intVal(b);
            }, 0 );
 
         // Update footer
         $( api.column( 4 ).footer() ).html(
            '$'+pageTotal
         );
      },
      select: true,
      fixedHeader: 
      {
         header:true,
         footer: true,
      },
      language: 
      {
         info: "Mostrando del _PAGE_ al _END_ de _TOTAL_ registros",
         zeroRecords: "No se encontraron resultados",
         infoFiltered: "(filtrado de _MAX_ registros)",
         lengthMenu: "Mostrar _MENU_ registros",
         paginate: 
         {
            next: "Siguiente",
            previous: "Anterior"
         },
         search: "Buscar:"
      },
      dom: 'Blrtip',
      buttons: 
      [
         {
            extend: 'pdf',
            text: 'Generar reporte',
            exportOptions: 
            {
               columns: ':visible',
              
            }
         },
         'print',
      ],
      lengthChange: true,
      aLengthMenu: [
        [25, 50, 100, 200, -1],
        [25, 50, 100, 200, "Todos"]
    ],
   });
   
   // FORMEATEA LA FECHA DE UN FORMATO DD/MM/AAAA  A UN FORMATO AAAA-MM-DD     
   function formatearFecha(fecha)
   {
      var a = fecha.split('/');
      a.reverse();
      var j = a.join('-');
      return j;         
   }

   // ESTA FUNCION ES PARA FILTRAR LA DATATABLE
   $scope.filtro = function()
   {
      var desde = $scope.desde == undefined ? '' : formatearFecha($scope.desde.toLocaleDateString("es-ES"));
      var hasta = $scope.hasta == undefined ? '' : formatearFecha($scope.hasta.toLocaleDateString("es-ES"));

      $scope.valorSocio = $scope.socio == null ? '' : $scope.socio.id_asociado;
      $scope.valorProovedor = $scope.proovedor == null ? '' : $scope.proovedor.id_proovedor;
      $scope.valorProducto = $scope.producto == null ? '' : $scope.producto.id_producto;
      $scope.valorOrganismo = $scope.organismo == null ? '' : $scope.organismo.id_organismo;

      $scope.data = [
         {'campo': 'movimientos.id_asociado', 'valor': $scope.valorSocio, 'operador': '='},
         {'campo': 'movimientos.id_producto', 'valor': $scope.valorProducto, 'operador': '='},
         {'campo': 'proovedores.id', 'valor': $scope.valorProovedor, 'operador': '='},
         {'campo': 'organismos.id', 'valor': $scope.valorOrganismo, 'operador': '='}, 
         {'campo': 'importeTotal', 'valor':$scope.minimo_importe, 'operador': '>='},
         {'campo': 'importeTotal', 'valor':$scope.maximo_importe, 'operador': '<='},
         {'campo': 'cuotas.importe', 'valor':$scope.minimo_importe_cuota, 'operador': '>='},
         {'campo': 'cuotas.importe', 'valor':$scope.maximo_importe_cuota, 'operador': '<='},
         {'campo': 'cuotas.nro_cuota', 'valor':$scope.minimo_nro_cuota, 'operador': '>='},
         {'campo': 'cuotas.nro_cuota', 'valor':$scope.maximo_nro_cuota, 'operador': '<='},
         {'campo': 'cuotas.fecha_pago', 'valor':desde, 'operador': '>='},
         {'campo': 'cuotas.fecha_pago', 'valor':hasta, 'operador': '<='}
        ];
      tabla.draw();
      
   }

     $scope.seleccionarTodo = function()
   {
      $('#datatable-responsive > tbody > tr').each(function (tr){
         //console.log(tabla.row(tr).data());
         $(this).toggleClass('selected');
      })
   }

   $('#datatable-responsive tbody').on( 'click', 'tr', function () {
      $(this).toggleClass('selected');
   });

   $scope.cobrar = function()
   {
      var cuotas_id = [];
      $('#datatable-responsive > tbody > tr.selected').each(function (tr){
         cuotas_id.push(tabla.row(tr).data().id_cuota);
         console.log(tabla.row(tr).data().id_cuota);
      });
         
         $http({
         url: 'pago_proovedores/pagarCuotas',
         method: 'post',
         data: {'cuotas': cuotas_id}
         }).then(function successCallback(response)
            {
               console.log(response.data.movimientos);
               if(typeof response.data == 'string')
               {
                  return [];
               }
               else
               {
                  return response.data.movimientos;
               }

            }, function errorCallback(data)
            {
               console.log(data.data);
            });
   }
});

