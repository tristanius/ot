var itemc = function($scope, $http, $timeout){
  $scope.contrato = {};
  $scope.items = [];
  $scope.validateItem = false;

  $scope.ventanaModal = undefined;
  $scope.pageSize = 20;

  // ------ formulario de items -------
  $scope.initModals = function(el){
    M.Modal.init( $(el) );
    $scope.ventanaModal = M.Modal.getInstance($(el));
  }

  $scope.openForm = function(item){
    $scope.ventanaModal.open();
    if(item){
      $scope.myitem = item;
    }
  }

  $scope.closeForm = function(){
    if(confirm('¿Desea cerrar el formulario?')){
      $scope.ventanaModal.close();
      $scope.myitem = {};
    }
  }

  // Guardar item
  $scope.save = function(lnk, it, lnk2){
    $http.post(lnk, {item: it, idcontrato: $scope.contrato.idcontrato}).then(
      function(resp) {
        if( resp.status ){
          $scope.getItemsByContrato(lnk2, $scope.contrato.idcontrato);
          $scope.closeForm();
        }else if ( resp.status == false ) {
          alert( resp.msj );
        }else{
          alert( 'Error inesperado' );
          console.log(resp.data)
        }
      },
      function(resp) {
        alert("Error al consultar el servidor");
        console.log(resp.data)
      }
    );
  }

  // Validar itemc
  $scope.validacionItem = function(iditc){
    $http.post($scope.$parent.site_url+'/item/exist', {iditemc: iditc}).then(
      function(resp){
        
        console.log(resp.data);
      },
      function(resp){
        console.log(resp.data);
      }
    );
  }

  // ------ Consulta de items por contrato -------
  $scope.getItemsByContrato = function(lnk, idcontrato){
    if(idcontrato){
      $http.get(lnk+"/"+idcontrato).then(
        function(resp){
          if(resp.data.status){
            $scope.contrato = resp.data.contrato;
            $scope.items = resp.data.items;
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
