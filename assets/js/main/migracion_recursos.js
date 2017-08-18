var migracion_recursos = function($scope, $http, $timeout){
  $scope.$parent.resultadosTraslado = [];

  $scope.cargaTraslado = false;
  $scope.initAdjunto = function(ruta) {
    $scope.adjunto = $("#fileuploader").uploadFile({
      url:ruta,
      autoSubmit: false,
      fileName:"myfile",
      dynamicFormData: function(){
        var data ={'movimiento':'Cargue de traslado de recursos', usuario:$scope.$parent.log.nombre_usuario}
        return data;
      },
      onSuccess: function(file, data){
        $scope.resultadosTraslado = data;
        //console.log(JSON.stringify(data));
        //$scope.cerrarWindow();
        //$scope.refreshTabs();
        $scope.cargaTraslado = false;
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
