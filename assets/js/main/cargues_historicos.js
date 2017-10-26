var cargue_historico =  function($scope, $http, $timeout){
  $scope.resultado_cargue = [];
  $scope.resultados = [];
  $scope.rows = [];

  $scope.spinner  = false;
  $scope.initAdjunto = function(ruta) {
    $timeout(
      function(){
        $scope.adjunto = $("#fileHistorico").uploadFile({
          url:ruta,
          autoSubmit: false,
          fileName:"file",
          dynamicFormData: function(){
            var data ={
              movimiento:'Cargue de historico de facturacion',
              id:$scope.$parent.log.idusuario,
              usuario:$scope.$parent.log.nombre_usuario,
              nombre_archivo: $scope.nombre_archivo
            }
            return data;
          },
          onSuccess: function(file, data){
            $scope.resultado_cargue = JSON.parse(data);
            console.log(data);
            if ($scope.resultado_cargue.success) {
            }
            //$scope.cerrarWindow();
            //$scope.refreshTabs();
            $scope.spinner = false;
          },
          onError: function(files,status,errMsg,pd){
            alert(JSON.stringify(errMsg));
            $scope.spinner  = false;
          }
        });
      }
    );
  }
  $scope.IniciarUploadAdjunto = function(){
    $scope.spinner  = true;
    $scope.adjunto.startUpload();
  }

  $scope.leerData = function(lnk){
    console.log('cargando...'+ new Date().toUTCString() );
    $http.post(lnk, {
        path:$scope.resultado_cargue.return
      }).then(
        function(response) {
          $scope.rows = response.data;
          console.log(response.data);
          console.log('Cerrando...'+ new Date().toUTCString() );
        },
        function(response) {
          console.log(response.data);
        }
      );
  }

  $scope.asinateResults = function(rows){
    $scope.resultados = rows;
  }
}
