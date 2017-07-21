angular.module('Mutual.services', [])


.service('UserSrv', function($http,$mdDialog){

    this.MostrarMensaje = function(titulo,mensaje,tipo){
        if(tipo != 'Error'){
            $('#mensaje').html('<div class="alert alert-success" role="alert"><strong>¡'+titulo+'!</strong> '+mensaje+'</div>');
            setTimeout(function(){ $('#mensaje').html(''); }, 2000);
        } else {
            $('#mensaje').html('<div class="alert alert-danger" role="alert"><strong>¡ERROR!</strong> Disculpe, ha ocurrido un error.</div>');
            setTimeout(function(){ $('#mensaje').html(''); }, 2000);
        }
    }
    this.ExportPDF = function(pantalla) {
        jQuery(function ($) {
        
            // parse the HTML table element having an id=exportTable
            var dataSource = shield.DataSource.create({
                data: "#exportTable",
                schema: {
                    type: "table",
                    fields: {
                        Nombre: { type: String},
                        Cuit: { type: Number },
                        Cuota_Social: { type: Number }
                    }
                }
            });

            // when parsing is done, export the data to PDF
            dataSource.read().then(function (data) {
                var pdf = new shield.exp.PDFDocument({
                    author: "Mutual",
                    created: new Date()
                });

                pdf.addPage("a4", "portrait");

                pdf.table(
                    10,
                    10,
                    data,
                    [
                        { field: "Nombre", title: "Nombre", width: 70 },
                        { field: "Cuit", title: "Cuit", width: 50 },
                        { field: "Cuota_Social", title: "Cuota Social", width: 100 }
                    ],
                    {
                        margins: {
                            top: 50,
                            left: 1
                        }
                    }
                );

                pdf.saveAs({
                    fileName: "Reporte PDF"
                });
            });
        
    });
    }
    this.GetEspecialidades = function(){

    }
    this.ShowLoading = function(){
       var path = '';
       return path;
    }

});