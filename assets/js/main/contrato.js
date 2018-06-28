var contrato = function($scope, $http, $timeout){
  $scope.contratos = [];
  $scope.enlaceVentana = '';

  $scope.form = function(link, ventana, btnMostrar) {
    console.log(link);
    $scope.resetView(link);
    $scope.$parent.getAjaxWindowLocal(link, ventana, btnMostrar);
  }

  $scope.resetView = function(link){
    $scope.enlaceVentana = '';
    $timeout(function(){
      $scope.enlaceVentana = link;
    });
  }

  $scope.getContratos = function(lnk){
    $http.post(lnk,{}).then(
      function(resp){

      },
      function(resp){

      }
    );
  }

  $scope.eliminar = function(){
    $http.post().then(
      function(resp){

      },
      function(resp){

      }
    );
  }
}

var form_contrato = function($scope, $http, $timeout){
  $scope.contrato = {};

  $scope.save = function(){
    $http.post().then(
      function(resp){
        if(resp.data.status){
          $scope.contrato = resp.data.contrato;
          alert("Contrato guardado con exito");
        }else{
          alert("Error al guardar");
          console.log(resp.data);
        }
      },
      function(resp){
        alert("Error al guardar");
        console.log(resp.data);
      }
    );
  }

  $scope.getContrato = function(){
    $http.post().then(
      function(resp){

      },
      function(resp){

      }
    );
  }
}
