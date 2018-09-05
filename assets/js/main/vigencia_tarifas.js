var vigencia_tarifas = function($scope, $http, $timeout){
  $scope.contrato = {};
  $scope.vigencias = [];
  $scope.validateItem = false;

  $scope.cargueItems = {
    status: false,
    error:false,
    resultados: []
  }

  $scope.ventanaModal = [];
  $scope.pageSize = 20;

  $scope.loader=false;
  $scope.vg = undefined;

  // ------ formulario de items -------
  $scope.initModals = function(el){
    M.Modal.init( $(el) );
    $scope.ventanaModal.push( M.Modal.getInstance($(el)) );
  }

  $scope.openForm = function(item, el){
    var i = $scope.ventanaModal.indexOf(M.Modal.getInstance($(el)));
    $scope.ventanaModal[i].open();
    if(item){
      $scope.myvigencia = item;
    }
  }

  $scope.closeForm = function(el){
    if(confirm('¿Desea cerrar el formulario?')){
      var i = $scope.ventanaModal.indexOf(M.Modal.getInstance($(el)));
      $scope.ventanaModal[i].close();
      $scope.myvigencia = {};
    }
  }

  // ------ Peticion Asincrona via POST ------
  $scope.peticion = function(lnk, data, myfn){
    $scope.loader = true;
    $http.post(lnk, data).then(
      function(resp){
        myfn(resp);
      },
      function(resp){
        console.log(resp.data);
        $scope.loader = false;
        alert("Ha ocurrido un error en la peticion al servidor");
      }
    );
  }

  // Obtener vigencias de tarifas
  $scope.getVigencias = function(lnk, idcontrato){
    console.log(idcontrato)
    if(idcontrato){
      $scope.peticion(lnk+"/"+idcontrato, {}, function(resp){
        if(resp.data.status){
          $scope.vigencias = resp.data.vigencias;
          if( !$scope.contrato.idcontrato && resp.data.vigencias[0].idcontrato){
            $scope.contrato.idcontrato = resp.data.vigencias[0].idcontrato;
            $scope.contrato.no_contrato = resp.data.vigencias[0].no_contrato;
          }
        }else{
          alert('Algo no ha salido bien en la consulta.');
        }
      });
    }

    $scope.loader = false;
  }

  $scope.setVigencia = function(vigencia){
    $scope.loader = true;
    $scope.vg = vigencia;
    $scope.loader = false;
  }

  // Obtener todos los Contratos para selecionarlos
  $scope.contratos = [];
  $scope.getContratos = function(lnk){
    $scope.loader=true;
    $http.post(lnk,{}).then(
      function(resp){
        if(resp.data.status){
          $scope.contratos = resp.data.contratos;
        }else{
          alert("Error al cargar los contratos");
          console.log(resp.data);
        }
        $scope.loader=false;
      },
      function(resp){
        alert("Error de servidor");
        console.log(resp.data);
        $scope.loader=false;
      }
    );
  }

  $scope.selecionarContrato = function(c, el){
    if(c){
      $scope.contrato = c;
      $scope.loader=true;
      var lnk = $scope.$parent.site_url+'/vigencia/get_by/';
      M.Modal.getInstance($(el)).close();
      $scope.getVigencias(lnk, c.idcontrato);
    }
  }

  $scope.getTarifas = function(lnk, idvg){
    $scope.loader=true;
    $scope.peticion(lnk+"/"+idvg, {idvigencia_tarifas: idvg }, function(resp){
      if(resp.data.status){
        $scope.vg.tarifas = resp.data.tarifas;
      }
      $scope.loader=false;
    });
  }

}
