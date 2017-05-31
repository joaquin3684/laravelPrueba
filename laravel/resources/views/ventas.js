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
      $scope.valorOrganismo = $scope.organismo === null ? '' : $scope.organismo.id_organismo;
      $scope.valorSocio = '%'+searchText+'%';
      $scope.valorProovedor = $scope.proovedor === null ? '' : $scope.proovedor.id_proovedor;
      $scope.valorProducto = $scope.producto === null ? '' : $scope.producto.id_producto;
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
      $scope.valorOrganismo = $scope.organismo === null ? '' : $scope.organismo.id_organismo;
      $scope.valorSocio = $scope.socio === null ? '' : $scope.socio.id_asociado;
      $scope.valorProducto = $scope.producto === null ? '' : $scope.producto.id_producto;
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
      proovedor = $scope.proovedor === null ? null : $scope.proovedor.id;
      socio = $scope.socio === null ? null : $scope.socio.id;
      producto = $scope.producto === null ? null : $scope.producto.id;

      return $http({
         url: 'ventas/datosAutocomplete',
         method: 'post',
         data: {'filtros': [{'campo': $scope.campoProovedor, 'valor': $scope.valorProovedor, 'operador': $scope.operadorProovedor}, {'campo': $scope.campoSocio, 'valor': $scope.valorSocio, 'operador': $scope.operadorSocio}, {'campo': $scope.campoProducto, 'valor':$scope.valorProducto, 'operador': $scope.operadorProducto}, {'campo': $scope.campoOrganismo, 'valor':$scope.valorOrganismo, 'operador': $scope.operadorOrganismo} ], 'groupBy': $scope.groupBy}
         }).then(function successCallback(response)
            {
               console.log(response.data.ventas);
               if(typeof response.data === 'string')
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
      {'funcion': 'filtrarPorSocio', 'valor': $scope.valorSocio},
      {'funcion': 'filtrarPorProducto', 'valor': $scope.valorProducto},
      {'campo': 'proovedores.id', 'valor': $scope.valorProovedor, 'operador': '='},
      {'funcion': 'filtrarPorOrganismo', 'valor': $scope.valorOrganismo},
      {'campo': 'importeTotal', 'valor':$scope.minimo_importe, 'operador': '>='},
      {'campo': 'importeTotal', 'valor':$scope.maximo_importe, 'operador': '<='},
      {'campo': 'cuotas.importe', 'valor':$scope.minimo_importe_cuota, 'operador': '>='},
      {'campo': 'cuotas.importe', 'valor':$scope.maximo_importe_cuota, 'operador': '<='},
      {'campo': 'cuotas.nro_cuota', 'valor':$scope.minimo_nro_cuota, 'operador': '>='},
      {'campo': 'cuotas.nro_cuota', 'valor':$scope.maximo_nro_cuota, 'operador': '<='},
      {'campo': 'cuotas.fecha_inicio', 'valor':$scope.desde, 'operador': '>='},
      {'campo': 'cuotas.fecha_inicio', 'valor':$scope.hasta, 'operador': '<='}
   ];
    // TABLA DE LA DATATABLE
    // ESTA FUNCION ES PARA FILTRAR LA DATATABLE


    $scope.ChequearVista = function(vistaactual){

        switch(vistaactual) {

          case "Organismos":
          if($('#tablaOrganismos_wrapper').is(':visible')){  } else {$('#tablaOrganismos_wrapper').show();}
          if($('#tablaOrganismos').is(':visible')){  } else {$('#tablaOrganismos').show();}
          $('#bread-servicios').hide();
          $('#bread-socios').hide();
          $('#bread-cuotas').hide();
          $('#tablaSocios_wrapper').hide();
          $('#tablaVentas_wrapper').hide();
          $('#porCuotas_wrapper').hide();
          $('#tablaSocios').empty();
          $('#tablaVentas').empty();
          $('#porCuotas').empty();

          break;
          case "Socios":
          $('#bread-socios').show();
          $('#bread-servicios').hide();
          $('#bread-cuotas').hide();
          $('#tablaOrganismos_wrapper').hide();
          $('#tablaOrganismos').hide();
          $('#tablaVentas_wrapper').hide();
          $('#tablaVentas').hide();
          $('#porCuotas_wrapper').hide();
          $('#porCuotas').hide();
          $('#tablaSocios_wrapper').show();
          $('#tablaSocios').show();
          break;
          case "Ventas":
          $('#bread-servicios').show();
          $('#bread-cuotas').hide();
          $('#tablaVentas_wrapper').show();
          $('#tablaOrganismos_wrapper').hide();
          $('#porCuotas_wrapper').hide();
          $('#tablaSocios_wrapper').hide();
          break;
          case "Cuotas":
          $('#bread-cuotas').show();
          $('#tablaVentas_wrapper').hide();
          $('#tablaOrganismos_wrapper').hide();
          $('#porCuotas_wrapper').show();
          $('#tablaSocios_wrapper').hide();
          break;

        }

    }

    $scope.ChequearVista('Organismos');

    var tabla =  $("#tablaOrganismos").DataTable({
      processing: true,
      serverSide: true,
      ajax:
      {
         url:'ventas/mostrarPorOrganismo',
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
               console.log(data);
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
    $('#tablaOrganismos tbody').on( 'click', 'tr', function () {
        var id = tabla.row(this).data().id_organismo;
        //aca iria la func
        $('#tablaSocios').empty();
        $("#tablaSocios").DataTable().destroy();
        vista = "Socios";
        $scope.ChequearVista(vista);
        var $div = $("<table>", {"class": "table table-striped table-bordered dt-responsive nowrap order-colum compact", id: "tablaSocios", });
        $('#paraBorrar').append($div);
        var tfoot = $("<tfoot>");
        $('#tablaSocios').append(tfoot);
        var html = '<tr><th style="text-align:right">Total:</th><th></th><th></th><th></th></tr>';
        $('tfoot').innerHTML(html);
        $scope.tabla2 =  $("#tablaSocios").DataTable({
            processing: true,
            serverSide: true,
            ajax:
                {
                    url:"ventas/mostrarPorSocio",
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

                if ( parseFloat(data.diferencia) * 1 > 0 ) {
                    $('td', row).eq(3).addClass('highlight');
                }
            },
            columnDefs:
                [
                    { "title": "Socio", "targets": 0 },
                    { "title": "Total a cobrar", "targets": 1 },
                    { "title": "Total cobrado", "targets": 2 },
                    { "title": "Diferencia", "targets": 3 },
                ],
            columns:
                [
                    {data: 'socio', name: 'socio'},
                    {data: 'totalACobrar', name: 'totalACobrar'},
                    {data: 'totalCobrado', name: 'totalCobrado'},
                    {data: 'diferencia', name: 'diferencia'},


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
                    .column( 1, { page: 'current'} )
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

                diferencia = api
                    .column( 3, { page: 'current'} )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                $( api.column( 1 ).footer() ).html(
                    '$'+totalACobrars
                );
                $( api.column( 2 ).footer() ).html(
                    '$'+totalCobrado
                );
                $( api.column( 3 ).footer() ).html(
                    '$'+diferencia
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

    $scope.filtro = function()
    {
        var desde = $scope.desde === undefined ? null : formatearFecha($scope.desde.toLocaleDateString("es-ES"));
        var hasta = $scope.hasta === undefined ? null : formatearFecha($scope.hasta.toLocaleDateString("es-ES"));

        $scope.valorSocio = $scope.socio === null ? null : $scope.socio.id_asociado;
        $scope.valorProovedor = $scope.proovedor === null ? null : $scope.proovedor.id_proovedor;
        $scope.valorProducto = $scope.producto === null ? null : $scope.producto.id_producto;
        $scope.valorOrganismo = $scope.organismo === null ? null : $scope.organismo.id_organismo;

      $scope.data = [
         {'funcion': 'filtrarPorSocio', 'valor': $scope.valorSocio},
         {'funcion': 'filtrarPorOrganismo', 'valor': $scope.valorProducto},
         {'funcion': 'filtrarPorProovedor', 'valor': $scope.valorProovedor},
         {'funcion': 'filtrarPorOrganismo', 'valor': $scope.valorOrganismo},
         {'funcion': 'filtrarPorMinimoImporte', 'valor':$scope.minimo_importe},
         {'funcion': 'filtrarPorMaximoImporte', 'valor':$scope.maximo_importe},
         {'funcion': 'filtrarPorMinimaFechaDeInicio', 'valor':desde},
         {'funcion': 'filtrarPorMaximaFechaDeInicio', 'valor':hasta}
        ];

      if($scope.tabla2 !== undefined)
      {
         $scope.tabla2.draw();
         
      }else if($scope.tabla3 !== undefined)
      {
         $scope.tabla3.draw();

      } else {
         tabla.draw();
      }
   
     

   }


   $('#paraBorrar').on( 'click', '#tablaSocios tr', function () {

         var id = $scope.tabla2.row(this).data().id_socio;
         //aca iria la func
         $('#tablaVentas').empty();
         $("#tablaVentas").DataTable().destroy();
         vista = "Ventas";
         $scope.ChequearVista(vista);
         $scope.tabla2 = undefined;
         var $div = $("<table>", {"class": "table table-striped table-bordered dt-responsive nowrap order-colum compact", id: "tablaVentas", });
         $('#paraBorrar').append($div);
         var tfoot = $("<tfoot>");
         $('#tablaVentas').append(tfoot);
         var html = '<tr><th colspan="6" style="text-align:right">Total:</th><th></th><th></th></tr>';
         $('tfoot').innerHTML(html);
      $scope.tabla3 =  $("#tablaVentas").DataTable({
         processing: true,
         serverSide: true,
         ajax:
         {
            url:"ventas/mostrarPorVenta",
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
              
            if ( parseFloat(data.diferencia) * 1 > 0 ) {
                $('td', row).eq(6).addClass('highlight');
            }
        },   
         columnDefs: 
         [
            { "title": "Servicio", "targets": 0 },
            { "title": "Socio", "targets": 1 },
            { "title": "Proovedor", "targets": 2 },
            { "title": "Producto", "targets": 3 },
             {"title": "Fecha", "targets": 4},
            { "title": "N° Cuotas", "targets": 5 },
            { "title": "Monto total", "targets": 6 },
            { "title": "Adeuda", "targets": 7 },
         ],
         columns:
         [
            {data: 'id_venta', name:'id_venta'},
            {data: 'socio', name: 'socio'},
            {data: 'proovedor', name: 'proovedor'},
            {data: 'producto', name: 'producto'},
            {data: 'fecha', name: 'fecha'},
            {data: 'nro_cuotas', name: 'nro_cuotas'},
            {data: 'totalACobrar', name: 'totalACobrar'},
            {data: 'diferencia', name: 'diferencia'},
            
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
               .column( 6, { page: 'current'} )
               .data()
               .reduce( function (a, b) {
                  return intVal(a) + intVal(b);
               }, 0 );

            deuda = api
               .column( 7, { page: 'current'} )
               .data()
               .reduce( function (a, b) {
                  return intVal(a) + intVal(b);
               }, 0 );

                 $( api.column( 6 ).footer() ).html(
               '$'+totalACobrars
            );
            $( api.column( 7 ).footer() ).html(
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
   $('#paraBorrar').on( 'click', '#tablaVentas tr', function () {
         
         var id = $scope.tabla3.row(this).data().id_venta;
         $('#porCuotas').empty();
         $("#porCuotas").DataTable().destroy();
         vista = "Cuotas";
         $scope.ChequearVista(vista);
         $scope.tabla3 = undefined;
         var $div = $("<table>", {width:"100%", id: "porCuotas", "class": "table table-striped table-bordered dt-responsive nowrap order-colum compact", });
         $('#paraBorrar').append($div);
         var tfoot = $("<tfoot>");
         $('#porCuotas').append(tfoot);
         var html = '<tr><th colspan="4" style="text-align:right">Total:</th><th></th><th></th></tr>';
         $('tfoot').innerHTML(html);
      $scope.tabla4 =  $("#porCuotas").DataTable({
         processing: true,
         serverSide: true,
         ajax:
         {
            url:"ventas/mostrarPorCuotas",
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
                
            if ( parseFloat(data.totalCobrado) * 1 != data.totalACobrar && moment.max(h, j) == h) {
                $('td', row).eq(5).addClass('highlight');
            }
        },    
         columnDefs: 
         [
            { "title": "N° cuota", "targets": 0 },
            { "title": "Socio", "targets": 1 },
             { "title": "Proovedor", "targets": 2 },
             { "title": "Vto", "targets": 3 },
             { "title": "Importe", "targets": 4 },
             { "title": "Cobrado", "targets": 5 },
         ],
         columns: 
         [
            {data: 'nro_cuota', name:'nro_cuota'},
            {data: 'socio', name: 'socio'},
             {data: 'proovedor', name: 'proovedor'},
             {data: 'fecha_vencimiento', name: 'fecha_vencimiento'},
             {data: 'totalACobrar', name: 'totalACobrar'},
            {data: 'totalCobrado', name: 'totalCobrado'},

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
               .column( 4, { page: 'current'} )
               .data()
               .reduce( function (a, b) {
                  return intVal(a) + intVal(b);
               }, 0 );

            deuda = api
               .column( 5, { page: 'current'} )
               .data()
               .reduce( function (a, b) {
                  return intVal(a) + intVal(b);
               }, 0 );

                 $( api.column( 4 ).footer() ).html(
               '$'+totalACobrars
            );
            $( api.column( 5 ).footer() ).html(
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

