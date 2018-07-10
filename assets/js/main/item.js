var itemc = function($scope, $http, $timeout){
  $scope.contrato = {};
  $scope.items = [];

  $scope.ventanaModal = undefined;

  // ------ formulario de items -------
  $scope.initModals = function(el){
    $scope.ventanaModal = M.Modal.init( $(el) );
  }

  // ------ Consulta de items por contrato -------
  $scope.getItemsByContrato = function(lnk, idcontrato){
    console.log(lnk+"/"+idcontrato);
    if(idcontrato){
      $http.get(lnk+"/"+idcontrato).then(
        function(resp){
          if(resp.data.status){
            $scope.contrato = resp.data.contrato;
            $scope.items = resp.data.items;
            console.log($scope.items.length);
          }else{
            alert('No se ha podido completar la consulta de items');
            console.log(resp.data);
          }
        },
        function(resp){
          alert('Error de consulta al servidor');
          console.log(resp.data);
        }
      );
    }
  }


  $scope.itemCounter = 0;
  $scope.validCell = function(total){
    $scope.itemCounter++;
    if($scope.itemCounter==1){
      if (total == 1) {
        $scope.itemCounter = 0;
      }
      return true;
    }
    if ($scope.itemCounter >= total) {
      $scope.itemCounter = 0;
    }
    return false;
  }

}
