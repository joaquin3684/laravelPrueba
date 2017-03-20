@extends('welcome')

@section('contenido')
  {!! Html::script('js/controladores/Dar_servicio.js') !!}

  <!-- CSS TABLAS -->
  <link href="js/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
  <link href="js/datatables/buttons.bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link href="js/datatables/fixedHeader.bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link href="js/datatables/responsive.bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link href="js/datatables/scroller.bootstrap.min.css" rel="stylesheet" type="text/css" />
  
<div class="nav-md" ng-controller="Dar_servicio" >

  <div class="container body" >


    <div class="main_container" >

      <input type="hidden" id="tipo_tabla" value="asociados">
      <!-- page content -->
      <div class="left-col" role="main" >

        <div class="" >
         
          <div class="clearfix"></div>




          <div class="row" >
            <div class="col-md-12 col-sm-12 col-xs-12" >
              <div class="x_panel"  >
                <div class="x_title">
                  <h2>Otorgar servicio <small></small></h2>
                  <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                      <ul class="dropdown-menu" role="menu">
                        <li><a href="#">Settings 1</a>
                        </li>
                        <li><a href="#">Settings 2</a>
                        </li>
                      </ul>
                    </li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
            
            
            <form class=" form-label-left" ng-submit="crearMovimiento()">
             <md-autocomplete class="" md-selected-item="socio" md-search-text="searchText" md-items="item in query(searchText, 'filtroSocios')" md-item-text="item.nombre" placeholder="Buscar afiliado..."  md-input-name="idafiliado">
  <span md-highlight-text="searchText">{[{item.nombre}]}</span>
</md-autocomplete>
            <hr></hr>
            <md-autocomplete class="" md-selected-item="proovedor" md-selected-item-change="habilitar()"   md-search-text="searchText2" md-items="item in query(searchText2, 'filtroProovedores')" md-item-text="item.nombre" placeholder="Buscar proovedor..."  md-input-name="idafiliado">
  <span md-highlight-text="searchText">{[{item.nombre}]}</span>
</md-autocomplete>

            <hr></hr>
            <md-autocomplete class="" md-selected-item="producto" ng-disabled="habilitacion"  md-search-text="searchText3" md-items="item in traerProductos(searchText3)" md-item-text="item.nombre" placeholder="Buscar producto..."  md-input-name="idafiliado">
  <span md-highlight-text="searchText">{[{item.nombre}]}</span>
</md-autocomplete>

            <hr></hr>
            <div class="row">
            <div class="item form-group">
              <label for="capital" class="control-label col-md-1 col-sm-3 col-xs-12">Capital<span class="required">*</span></label>
              <div class="col-md-4 col-sm-6 col-xs-12">
              <input type="text" name="capital" class="form-control col-md-7 col-xs-12" ng-model="importe">
              </div>
            </div>
            <div class="item form-group">
              <label for="cuotas" class="control-label col-md-offset-1 col-md-1 col-sm-3 col-xs-12">Cuotas<span class="required">*</span></label>
              <div class="col-md-4 col-sm-6 col-xs-12">
              <input type="text" name="cuotas" class="form-control col-md-7 col-xs-12" ng-model="nro_cuotas">
              </div>
            </div>
            </div>
            <div class="row">
            <div class="item form-group" style="margin-top:20px;">

                      <div class="">
                       
                        <button id="send" type="submit" class="btn btn-success">Alta</button>
                      </div>
            </div>
            </div>

              </form>
                </div>
              </div>
            </div>
          </div>
        </div>

       

      </div>
     

 
      <!-- /page content -->
    </div>

  </div>

  <div id="custom_notifications" class="custom-notifications dsp_none">
    <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
    </ul>
    <div class="clearfix"></div>
    <div id="notif-group" class="tabbed_notifications"></div>
  </div>


  <!-- bootstrap progress js -->


  <!-- icheck -->
  
  <!-- pace -->
 

  <!-- form validation -->
 
        <script src="js/datatables/jquery.dataTables.min.js"></script>
        <script src="js/datatables/dataTables.bootstrap.js"></script>
        <script src="js/datatables/dataTables.buttons.min.js"></script>
        <script src="js/datatables/buttons.bootstrap.min.js"></script>
        <script src="js/datatables/jszip.min.js"></script>
        <script src="js/datatables/pdfmake.min.js"></script>
        <script src="js/datatables/vfs_fonts.js"></script>
        <script src="js/datatables/buttons.html5.min.js"></script>
        <script src="js/datatables/buttons.print.min.js"></script>
        <script src="js/datatables/dataTables.fixedHeader.min.js"></script>
        <script src="js/datatables/dataTables.keyTable.min.js"></script>
        <script src="js/datatables/dataTables.responsive.min.js"></script>
        <script src="js/datatables/responsive.bootstrap.min.js"></script>
        <script src="js/datatables/dataTables.scroller.min.js"></script>




         <script>
          
        </script>
        <script type="text/javascript">
          $( document ).ready(function() {
            function puto(){
              console.log('forro');
            }
       $("#datatable-responsive").DataTable({
              

               
              select: true,
              fixedHeader: true,
               language: {
                info: "Mostrando del _PAGE_ al _END_ de _TOTAL_ registros",
                lengthMenu: "Mostrar _MENU_ registros",
                paginate: {
                  next: "Siguiente",
                  previous: "Anterior"
                },
                search: "Buscar:"


               },
              dom: 'Blfrtip',
              buttons: [
                  'copy', 'excel', 'pdf'
               ],
               lengthChange: true,
               

          });
          });
        </script>

</div>


@endsection