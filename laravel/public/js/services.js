angular.module('Mutual.services', [])


.service('UserSrv', function($http,$mdDialog){

    this.MostrarMensaje = function(color,mensaje){
        $mdDialog.show(
            $mdDialog.alert()
                .clickOutsideToClose(true)
                .title(color)
                .textContent(mensaje)
                .ariaLabel('')
                .ok('Aceptar')
                // You can specify either sting with query selector
                .openFrom('#left')
                // or an element
                .closeTo(angular.element(document.querySelector('#right')))
        );
    }
    this.GetEspecialidades = function(){

    }
    this.ShowLoading = function(){
       var path = '';
       return path;
    }

});