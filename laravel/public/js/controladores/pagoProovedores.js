var app = angular.module('Mutual', ['ngMaterial', 'ngSanitize', 'chart.js', 'ngTable']).config(function($interpolateProvider){
    $interpolateProvider.startSymbol('{[{').endSymbol('}]}');
});
app.controller('pago_proovedores', function($scope, $http, $compile, $sce, NgTableParams, $filter) {

    $scope.pullProveedores = function (){

        $http({
            url: 'pago_proovedores/datos',
            method: 'post'
        }).then(function successCallback(response)
        {
            console.log(response.data.ventas);
            if(typeof response.data === 'string')
            {
                return [];
            }
            else
            {
                console.log(response);
                $scope.proveedores = response.data;
                $scope.paramsProveedores = new NgTableParams({
                    page: 1,
                    count: 10
                }, {
                    total: $scope.proveedores.length,
                    getData: function (params) {
                        $scope.proveedores = $filter('orderBy')($scope.proveedores, params.orderBy());
                        return $scope.proveedores.slice((params.page() - 1) * params.count(), params.page() * params.count());
                    }
                });
            }

        }, function errorCallback(data)
        {
            console.log(data.data);
        });



    }

    var self = this;
    $scope.pullProveedores();

});

