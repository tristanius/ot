var migracion_recursos = function($scope, $http, $timeout){
  $scope.resultadosTraslado = [];

  $scope.cargaTraslado = false;
  $scope.initAdjunto = function(ruta) {
    $scope.adjunto = $("#fileuploader").uploadFile({
      url:ruta,
      autoSubmit: false,
      fileName:"cargue",
      dynamicFormData: function(){
        var data ={movimiento:'Cargue de traslado de recursos', id:$scope.$parent.log.idusuario, usuario:$scope.$parent.log.nombre_usuario}
        return data;
      },
      onSuccess: function(file, data){
        $scope.resultadosTraslado = JSON.parse(data);
        console.log(data);
        //$scope.cerrarWindow();
        //$scope.refreshTabs();
        $scope.cargaTraslado=false;
        $scope.cerrarWindow();
      },
      onError: function(files,status,errMsg,pd){
        alert(JSON.stringify(errMsg));
        $scope.cargaTraslado = false;
      }
    });
  }
  $scope.IniciarUploadAdjunto = function(){
    $scope.cargaTraslado = true;
    $scope.adjunto.startUpload();
  }

}
