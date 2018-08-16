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
        if(resp.data.status){
          $scope.contratos = resp.data.contratos;
        }else{
          alert("Error al cargar los contratos");
          console.log(resp.data);
        }
      },
      function(resp){
        alert("Error de servidor");
        console.log(resp.data);
      }
    );
  }

  $scope.eliminar = function(){
    $http.post().then(
      function(resp){
      },
      function(resp){
        alert("Error al eliminar");
        console.log(resp.data);
      }
    );
  }
}

var form_contrato = function($scope, $http, $timeout){
  $scope.cont = {};

  $scope.save = function(lnk, contrato, lnk2){
    $http.post(lnk, contrato).then(
      function(resp){
        if(resp.data.status){
          $scope.$parent.getContratos(lnk2);
          alert("Contrato guardado con exito");
        }else if (resp.data.status == false) {
          alert(resp.data.msj);
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

  $scope.getContrato = function(lnk, id){
    if(id){
      $http.get(lnk+'/'+id).then(
        function(resp){
          if(resp.data.status){
            $scope.cont = resp.data.contrato;
          }else{
            alert('No encontro contrato');
            console.log(resp.data);
          }
        },
        function(resp){
          alert("Error");
          console.log(resp.data);
        }
      );
    }
  }
}
