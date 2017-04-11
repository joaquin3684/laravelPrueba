var app = angular.module('Mutual', ['ngMaterial', 'ngSanitize', 'chart.js']).config(function($interpolateProvider){
    $interpolateProvider.startSymbol('{[{').endSymbol('}]}');
});
app.controller('ventas', function($scope, $http, $compile, $sce, $window) {
   
// ESTAS FUNCIONES SON PARA DEFINIR LOS PARAMETROS DE BUSQUEDA EN LA FUNCION QUERY
   $scope.buscandoSocios = function(searchText)
   {
      $scope.campoSocio = 'socios.nombre';
      $scope.campoOrganismo = 'organismos.id';
      $scope.campoProovedor = 'proovedores.id';
      $scope.campoProducto = 'ventas.id_producto';
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
      $scope.campoSocio = 'ventas.id_asociado';
      $scope.campoProovedor = 'proovedores.id';
      $scope.campoProducto = 'ventas.id_producto';
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
      $scope.campoSocio = 'ventas.id_asociado';
      $scope.campoProovedor = 'proovedores.nombre';
      $scope.campoProducto = 'ventas.id_producto';
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
      $scope.campoSocio = 'ventas.id_asociado';
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
         url: 'ventas/datosAutocomplete',
         method: 'post',
         data: {'filtros': [{'campo': $scope.campoProovedor, 'valor': $scope.valorProovedor, 'operador': $scope.operadorProovedor}, {'campo': $scope.campoSocio, 'valor': $scope.valorSocio, 'operador': $scope.operadorSocio}, {'campo': $scope.campoProducto, 'valor':$scope.valorProducto, 'operador': $scope.operadorProducto}, {'campo': $scope.campoOrganismo, 'valor':$scope.valorOrganismo, 'operador': $scope.operadorOrganismo} ], 'groupBy': $scope.groupBy}
         }).then(function successCallback(response)
            {
               console.log(response.data.ventas);
               if(typeof response.data == 'string')
               {
                  return [];
               }
               else
               {
                  return response.data.ventas;
               }

            }, function errorCallback(data)
            {
               console.log(data.data);
            });
   }

   // DATOS PARA FILTRAR LA DATATABLE 
   $scope.data = [
      {'campo': 'ventas.id_asociado', 'valor': $scope.valorSocio, 'operador': '='},
      {'campo': 'ventas.id_producto', 'valor': $scope.valorProducto, 'operador': '='},
      {'campo': 'proovedores.id', 'valor': $scope.valorProovedor, 'operador': '='}, 
      {'campo': 'organismos.id', 'valor': $scope.valorOrganismo, 'operador': '='},
      {'campo': 'importeTotal', 'valor':$scope.minimo_importe, 'operador': '>='},
      {'campo': 'importeTotal', 'valor':$scope.maximo_importe, 'operador': '<='},
      {'campo': 'cuotas.importe', 'valor':$scope.minimo_importe_cuota, 'operador': '>='},
      {'campo': 'cuotas.importe', 'valor':$scope.maximo_importe_cuota, 'operador': '<='},
      {'campo': 'cuotas.nro_cuota', 'valor':$scope.minimo_nro_cuota, 'operador': '>='},
      {'campo': 'cuotas.nro_cuota', 'valor':$scope.maximo_nro_cuota, 'operador': '<='},
      {'campo': 'cuotas.fecha_inicio', 'valor':$scope.desde, 'operador': '>='},
      {'campo': 'cuotas.fecha_inicio', 'valor':$scope.hasta, 'operador': '<='}
   ];
   

   var tabla =  $("#datatable-responsive").DataTable({
      processing: true,
      serverSide: true,
      ajax:
      {
         url:"ventas/mostrarPorOrganismo",
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
      createdRow: function ( row, data, index ) {
               
            if ( parseFloat(data.diferencia) * 1 > 0 ) {
                $('td', row).eq(3).addClass('highlight');
            }
        },  
      columns: 
      [
 
         {data: 'organismo', name: 'organismo'},
         {data: 'totalACobrar', name: 'total'},
         {data: 'totalCobrado', name: 'totalCobrado'},
         {data: 'diferencia', name:'diferencia'},
      ],
      columnDefs: 
      [

         { "title": "Organismo", "targets": 0 },
         { "title": "Total a cobrar", "targets": 1 },
         { "title": "Total cobrado", "targets": 2 },
         { "title": "Diferencia", "targets": 3 },
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
         var size = 0;
         data.forEach(function(x) {
            size += (x['size']);
          });
         $('.footer').html(size);
           // Total over this page
         totalACobrars = api
            .column(1, { page: 'current'} )
            .data()
            .reduce( function (a, b) {
               return intVal(a) + intVal(b);
            }, 0 );

         totalCobrado = api
            .column( 2, { page: 'current'} )
            .data()
            .reduce( function (a, b) {
               return intVal(a) + intVal(b);
            }, 0 );

         Totaldiferencia = api
            .column( 3, { page: 'current'} )
            .data()
            .reduce( function (a, b) {
               return intVal(a) + intVal(b);
            }, 0 );

         // Update footer
         $( api.column( 1 ).footer() ).html(
            '$'+totalACobrars
         );
         $( api.column( 2 ).footer() ).html(
            '$'+totalCobrado
         );
         $( api.column( 3 ).footer() ).html(
            '$'+Totaldiferencia
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
                  modifier:
                  {
                    page: 'current'
                  }
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
   // TABLA DE LA DATATABLE  
  /* var tabla =  $("#datatable-responsive").DataTable({
      processing: true,
      serverSide: true,
      ajax:
      {
         url:"ventas/mostrarPorOrganismo",
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
      createdRow: function ( row, data, index ) {
               
            if ( parseFloat(data.diferencia) * 1 > 0 ) {
                $('td', row).eq(4).addClass('highlight');
            }
        },  
      columns: 
      [
         {data: 'socio', name: 'socio'},
         {data: 'organismo', name: 'organismo'},
         {data: 'total', name: 'total'},
         {data: 'totalCobrado', name: 'totalCobrado'},
         {data: 'diferencia', name:'diferencia'},
      ],
      columnDefs: 
      [
         { "title": "Socio", "targets": 0 },
         { "title": "Organismo", "targets": 1 },
         { "title": "Total a cobrar", "targets": 2 },
         { "title": "Total cobrado", "targets": 3 },
         { "title": "Diferencia", "targets": 4 },
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
         var size = 0;
         data.forEach(function(x) {
            size += (x['size']);
          });
         $('.footer').html(size);
           // Total over this page
         totalACobrars = api
            .column( 2, { page: 'current'} )
            .data()
            .reduce( function (a, b) {
               return intVal(a) + intVal(b);
            }, 0 );

         totalCobrado = api
            .column( 3, { page: 'current'} )
            .data()
            .reduce( function (a, b) {
               return intVal(a) + intVal(b);
            }, 0 );

         Totaldiferencia = api
            .column( 4, { page: 'current'} )
            .data()
            .reduce( function (a, b) {
               return intVal(a) + intVal(b);
            }, 0 );

         // Update footer
         $( api.column( 2 ).footer() ).html(
            '$'+totalACobrars
         );
         $( api.column( 3 ).footer() ).html(
            '$'+totalCobrado
         );
         $( api.column( 4 ).footer() ).html(
            '$'+Totaldiferencia
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
                  modifier:
                  {
                    page: 'current'
                  }
               }
            },
            'print',
         ],
      lengthChange: true,
      aLengthMenu: [
        [25, 50, 100, 200, -1],
        [25, 50, 100, 200, "Todos"]
      ],
   });*/

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
         {'campo': 'ventas.id_asociado', 'valor': $scope.valorSocio, 'operador': '='},
         {'campo': 'ventas.id_producto', 'valor': $scope.valorProducto, 'operador': '='},
         {'campo': 'proovedores.id', 'valor': $scope.valorProovedor, 'operador': '='},
         {'campo': 'organismos.id', 'valor': $scope.valorOrganismo, 'operador': '='}, 
         {'campo': 'importeTotal', 'valor':$scope.minimo_importe, 'operador': '>='},
         {'campo': 'importeTotal', 'valor':$scope.maximo_importe, 'operador': '<='},
         {'campo': 'cuotas.importe', 'valor':$scope.minimo_importe_cuota, 'operador': '>='},
         {'campo': 'cuotas.importe', 'valor':$scope.maximo_importe_cuota, 'operador': '<='},
         {'campo': 'cuotas.nro_cuota', 'valor':$scope.minimo_nro_cuota, 'operador': '>='},
         {'campo': 'cuotas.nro_cuota', 'valor':$scope.maximo_nro_cuota, 'operador': '<='},
         {'campo': 'cuotas.fecha_inicio', 'valor':desde, 'operador': '>='},
         {'campo': 'cuotas.fecha_inicio', 'valor':hasta, 'operador': '<='}
        ];
         console.log($scope.tabla2);
      if($scope.tabla2 != undefined)
      {
         $scope.tabla2.draw();
         
      }else if($scope.tabla3 != undefined)
      {
         $scope.tabla3.draw();

      } else {
         tabla.draw();
      }
   
     

   }
   

   $('#datatable-responsive tbody').on( 'click', 'tr', function () {
         var id = tabla.row(this).data().id_asociado;
         $('#datatable-responsive').dataTable().fnDestroy();
         $('#datatable-responsive').remove();
         var $div = $("<table>", {"class": "table table-striped table-bordered dt-responsive nowrap order-colum compact", id: "otro", });
         $('#paraBorrar').append($div);
         var tfoot = $("<tfoot>");
         $('#otro').append(tfoot);
         var html = '<tr><th colspan="5" style="text-align:right">Total:</th><th></th><th></th></tr>';
         $('tfoot').append(html);
      $scope.tabla2 =  $("#otro").DataTable({
         processing: true,
         serverSide: true,
         ajax:
         {
            url:"ventas/porVenta",
            type: "POST",
            headers:
            {
               'X-CSRF-TOKEN': $('#token').val()
            },
            data: function (d)
            {
               d.filtros = $scope.data;
               d.id = id;
            }
         },
         createdRow: function ( row, data, index ) {
              
            if ( parseFloat(data.deuda) * 1 > 0 ) {
                $('td', row).eq(6).addClass('highlight');
            }
        },   
         columnDefs: 
         [
            { "title": "Servicio", "targets": 0 },
            { "title": "Socio", "targets": 1 },
            { "title": "Proovedor", "targets": 2 },
            { "title": "Producto", "targets": 3 },
            { "title": "N° Cuotas", "targets": 4 },
            { "title": "Monto total", "targets": 5 },
            { "title": "Adeuda", "targets": 6 },
         ],
         columns: 
         [
            {data: 'id_servicio', name:'id_servicio'},
            {data: 'socio', name: 'socio'},
            {data: 'proovedor', name: 'proovedor'},
            {data: 'producto', name: 'producto'},
            {data: 'cuotas', name: 'cuotas'},
            {data: 'total', name: 'total'},
            {data: 'deuda', name: 'deuda'},
            
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
    
            // Total over this page
              totalACobrars = api
               .column( 5, { page: 'current'} )
               .data()
               .reduce( function (a, b) {
                  return intVal(a) + intVal(b);
               }, 0 );

            deuda = api
               .column( 6, { page: 'current'} )
               .data()
               .reduce( function (a, b) {
                  return intVal(a) + intVal(b);
               }, 0 );

                 $( api.column( 5 ).footer() ).html(
               '$'+totalACobrars
            );
            $( api.column( 6 ).footer() ).html(
               '$'+deuda
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
                     modifier:
                     {
                       page: 'current'
                     }
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

   });
   $('#paraBorrar').on( 'click', '#otro tr', function () {
         
         var id = $scope.tabla2.row(this).data().id_servicio;
         $('#otro').dataTable().fnDestroy();
         $('#otro').remove();
         $scope.tabla2 = undefined;
         var $div = $("<table>", {width:"100%", id: "porProducto", "class": "table table-striped table-bordered dt-responsive nowrap order-colum compact", });
         $('#paraBorrar').append($div);
         var tfoot = $("<tfoot>");
         $('#porProducto').append(tfoot);
         var html = '<tr><th colspan="5" style="text-align:right">Total:</th><th></th><th></th></tr>';
         $('tfoot').append(html);
      $scope.tabla3 =  $("#porProducto").DataTable({
         processing: true,
         serverSide: true,
         ajax:
         {
            url:"ventas/porProducto",
            type: "POST",
            headers:
            {
               'X-CSRF-TOKEN': $('#token').val()
            },
            data: function (d)
            {
               d.filtros = $scope.data;
               d.id = id;
            }
         },
         createdRow: function ( row, data, index ) {
                  var h = moment();
                  var j = moment(data.fecha_vencimiento);
                
            if ( parseFloat(data.cobro) * 1 != data.importe && moment.max(h, j) == h) {
                $('td', row).eq(6).addClass('highlight');
            }
        },    
         columnDefs: 
         [
            { "title": "N° cuota", "targets": 0 },
            { "title": "Socio", "targets": 1 },
            { "title": "Proovedor", "targets": 2 },
            { "title": "Importe", "targets": 5 },
            { "title": "Cobrado", "targets": 6 },
            { "title": "Fecha inicio", "targets": 3 },
            { "title": "Vto", "targets": 4 },
         ],
         columns: 
         [
            {data: 'nro_cuota', name:'nro_cuota'},
            {data: 'socio', name: 'socio'},
            {data: 'proovedor', name: 'proovedor'},
            {data: 'fecha_inicio', name: 'fecha_inicio'},
            {data: 'fecha_vencimiento', name: 'fecha_vencimiento'},
            {data: 'importe', name: 'importe'},
            {data: 'cobro', name: 'cobro'},
            
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
    
            // Total over this page
              totalACobrars = api
               .column( 5, { page: 'current'} )
               .data()
               .reduce( function (a, b) {
                  return intVal(a) + intVal(b);
               }, 0 );

            deuda = api
               .column( 6, { page: 'current'} )
               .data()
               .reduce( function (a, b) {
                  return intVal(a) + intVal(b);
               }, 0 );

                 $( api.column( 5 ).footer() ).html(
               '$'+totalACobrars
            );
            $( api.column( 6 ).footer() ).html(
               '$'+deuda
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
                     modifier:
                     {
                       page: 'current'
                     }
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

   });

});

