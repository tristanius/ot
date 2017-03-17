var factura = function($scope, $http, $timeout){
  $scope.consulta = {};
  $scope.contrato = {vigencias:[], facturas:[]};
  $scope.loaders = {};
  $scope.enlaceGetFactura = '';
  $scope.linkDataContrato = '';
  $scope.getDataContrato = function(){
    if ($scope.consulta.idcontrato != '' && $scope.consulta.idcontrato != undefined) {
      $scope.loaders.getfacturas = $scope.toggleLoader($scope.loaders.getfacturas);
      $http.post($scope.linkDataContrato, $scope.consulta)
      .then(
        function(response){
          console.log(response.data);
          $scope.contrato = response.data;
          $scope.loaders.getfacturas = $scope.toggleLoader($scope.loaders.getfacturas);
        },
        function(response){
          alert('Opps, algo ha salido mal, revisa la conexión a internet y si persiste el error comunicate al dpto. TIC.');
          console.log(response.data);
          $scope.loaders.getfacturas = $scope.toggleLoader($scope.loaders.getfacturas);
        }
      );
    }else{
      alert('no has selecionado contrato')
    }
  }

  $scope.toggleLoader = function(loader){
    return loader?false:true;
  }
  $scope.factura = function(link, ventana, btnMostrar) {
    console.log(link);
    $scope.resetView(link);
    $scope.$parent.getAjaxWindowLocal(link, ventana, btnMostrar);
  }

  $scope.calcularCantidad = function(rec){
    var cant = 0;
    if (rec.tipo == 3) {
      if (rec.unidad == 'hr') {
        cant = (rec.horas_operacion-4 > 0)? rec.horas_operacion: 4;
      }else if (rec.horas_operacion == 0 && rec.hrdisp > 0) {
        var disp  = (rec.hrdisp / rec.basedisp);
        cant = (rec.horas_disponible > 0)?disp:0;
      }else{
        cant = (rec.horas_disponible > 0)?1:0;
      }
    }else{
      cant = 1;
    }
    return cant.toFixed(6) * rec.cant_und;
  }

  $scope.delAddFromList = function(list, base){
    $scope.$parent.delAddFromList(list, base);
    $scope.filtro_CO = list[0];
  }

  $scope.resetView = function(link){
    $scope.enlaceGetFactura = '';
    $timeout(function(){
      $scope.enlaceGetFactura = link;
    });
  }

  $scope.delFactura = function(idfactura){
    var modal = confirm('¿ Desea elimnar TODA ESTA FACTURA ?? !!!!!');
    if (modal) {
      $http.post($scope.$parent.site_url+'/factura/delFactura/'+idfactura, {}).then(
        function(response) {
          console.log(response.data);
          if(response.data == 'success'){ $scope.getDataContrato(); }else{alert(response.data)}
        },
        function(response) { alert('algo ha fallado'); console.log(response.data); }
      );
    }
  }

  $scope.parseBool = function(i){
    return (i==1)? true: false;
  }

}

var formFactura = function($scope, $http, $timeout){
  $scope.fac = {
    actas:[],
    bases:[],
    recursos:[],
    ordenes:[]
  };
  $scope.currentPage = 0;
  $scope.pageSize = 13;
  $scope.orden = {recursos:[]};
  $scope.panel_visible = false;

  $scope.getRecursos = function(link) {
    if ($scope.fac.no_doc == undefined || $scope.fac.no_doc == '' || $scope.fac.fecha_fin_factura == undefined || $scope.fac.fecha_fin_factura == undefined || $scope.fac.bases.length == 0) {
      alert('Debes selecionar los campos necesarios para realizar el ata de factura')
    }else{
      $scope.$parent.loaders.formLoad = true;
      $http.post(link, $scope.fac)
      .then(
        function(response){
          $scope.$parent.loaders.formLoad = false;
          $scope.panel_visible = true;
          $scope.fac.ordenes = response.data;
        },
        function(response){
          $scope.$parent.loaders.formLoad = false;
          alert('algo ha salido Mal');
          console.log(response.data);
        }
      );
    }
  }

  /// ==========================================================================
  // INSERTAR
  $scope.save = function(link, tipo){
    if ($scope.fac.ordenes.length > 0) {
      $scope.$parent.loaders.formLoad = true;
      $scope.panel_visible = false;
      $http.post(link, $scope.fac)
      .then(
        function(response){
          $scope.panel_visible = true;
          $scope.$parent.loaders.formLoad = false;
          console.log(response.data);
          if (response.data == 'success') {
            alert('Proceso realizado');
            $scope.$parent.getDataContrato();
            if (tipo=='add'){
              $scope.cerrarWindowLocal('#ventanaFactura', $scope.$parent.enlaceGetFactura);
            }
          }else{
            alert('Se ha interrumpido el proceso');
          }
        },
        function(response){
          console.log(response.data);
          alert('Algo ha salido mal');
        }
      );
    }else{
      alert('No existen registros por agregar');
    }
  }


  /// ==========================================================================
  // EDICION
  $scope.getFacturaData = function(link) {
    $scope.$parent.loaders.formLoad = true;
    $http.post(
      link, {}
    ).then(
      function(response){
        $scope.$parent.loaders.formLoad = false;
        if(response.data.success == 'success' ) {
          $scope.panel_visible = true;
          console.log( response.data.fac );
          $scope.fac = response.data.fac;
        }else{
          console.log(response.data);
          alert('Se ha interrumpido el proceso');
        }
      },
      function(response){
        console.log(response.data);
          alert('Algo ha salido mal');
      }
    );
  }
  // ===========================================================================

  $scope.togglePanel = function(){
    $scope.panel_visible = $scope.$parent.toggleLoader($scope.panel_visible);
  }

  $scope.numberOfPages=function(){
    return Math.ceil($scope.orden.recursos.length/$scope.pageSize);
  }

  $scope.deleteElementFactura = function(listaPadre, elemento, tipo){
    if (elemento) {
      var i = listaPadre.indexOf(elemento);
      if (tipo == 'orden') {
        listaPadre.splice( i, 1 );
        var x = listaPadre.length;
        if(x==i){ i = 0; }
        $scope.orden = listaPadre[i];
      }else if (tipo =='recurso'){
        if ( elemento.idfactura_recurso_reporte ) {
            $http.post( $scope.$parent.site_url+'/factura/delItemFactura/',   {idfactura_recurso_reporte: elemento.idfactura_recurso_reporte})
            .then(
              function(response) {
                if (response.data == "success") {
                    listaPadre.splice( i, 1 );
                }else{
                  console.log(response.data);
                  alert('Elemento NO eliminado');
                }
              },function(response) { alert(response.data) }
            );
        }else{
          listaPadre.splice( i, 1 );
        }
      }
    }
  }

  $scope.changeSelectFac = function(tipo){
    if (tipo=='orden') {
      $scope.currentPage =  0;
      $scope.pgNum = 1;
    }else if (tipo == 'base') {
      $scope.orden = {recursos:[]};
      $scope.currentPage =  0;
      $scope.pgNum = 1;
    }else if (tipo == 'filtroItems') {
      $scope.currentPage =  0;
      $scope.pgNum = 1;
    }
  }

  $scope.setValRange = function(valmodel, prop, lista){
    if(valmodel){
      angular.forEach(lista, function(v, k){
        if(v.isSelected){
          v[prop] = valmodel;
          v.isSelected = false;
        }
      });
      valmodel='';
    }
  }

  $scope.modSeletionState = function(lista, estado){
    angular.forEach(lista, function(v,k){
      v.isSelected = estado;
    });
  }

  $scope.addActa = function(myacta){
    $scope.fac.actas.push(myacta);
  }

}
