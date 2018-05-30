var factura = function($scope, $http, $timeout){
  $scope.consulta = {};
  $scope.contrato = {vigencias:[], facturas:[]};
  $scope.loaders = {};
  $scope.enlaceGetFactura = '';
  $scope.linkDataContrato = '';

  // Obtiene la informacion de un contrato macro
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
  // spiner .gif
  $scope.toggleLoader = function(loader){
    return loader?false:true;
  }

  // Carga la información de un formulario para agregar o modificar una factura
  $scope.factura = function(link, ventana, btnMostrar) {
    console.log(link);
    $scope.resetView(link);
    $scope.$parent.getAjaxWindowLocal(link, ventana, btnMostrar);
  }
  // REEPLANTEAR
  // Metodo para carcular una cantidad... con disponibilidad
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
  $scope.factura = {
    actas:[],
    bases:[],
    recursos:[],
    ordenes:[],
    ordenes_excluidas: []
  };
  $scope.currentPage = 0;
  $scope.pageSize = 13;
  $scope.orden = {recursos:[]};
  $scope.panel_visible = false;

  // Renderiza las pestañas de JQuery
  $scope.initTabs = function(selector){
    $( function() {
      $( selector ).tabs();
    } );
  }

  //Inicial ventanas modales del formulario
  $scope.initModals = function(){
    $( function(){
      $('.modal').modal();
    } );
  }
  // Ajax http request
  // Obtiene los recursos de un periodo dado
  $scope.getRecursos = function(link) {

      $scope.$parent.loaders.formLoad = true;

      $http.post(link, $scope.factura)
      .then(
        function(response){
          if(response.data.success){
            $scope.factura.recursos = response.data.recursos;
          }else{
            console.log(response.data);
          }
        },
        function(response){
          console.log(response.data);
          alert("error al consultar recursos");
        }
      );

  }

  $scope.getOrdenes = function(lnk){
    if (true) {
      $http.post(lnk, { centros_operacion: $scope.factura.centros_operacion } ).then(
        function(resp){
          if(resp.data.success){
            $scope.factura.ordenes = resp.data.ordenes;
          }else{
            console.log(resp.data);
            alert("Algo ha fallado al consultar Ordenes");
          }
        },
        function(resp){
          console.log(resp.data);
          alert("Algo ha fallado al consultar Ordenes");
        }
      );
    }
  }

  /// ==========================================================================
  // Guardar
  $scope.save = function(link, tipo){
    if ($scope.factura.ordenes.length > 0) {
      $http.post(link, $scope.factura)
      .then(
        function(response){
          //$scope.cerrarWindowLocal('#ventanaFactura', $scope.$parent.enlaceGetFactura);
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
          $scope.factura = response.data.fac;
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
  // Numero de paginas para las paginas de la tabla
  $scope.numberOfPages=function(lista){
    return Math.ceil(lista.recursos.length/$scope.pageSize);
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
    if (tipo == 'orden') {
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
    $scope.factura.actas.push(myacta);
  }

  $scope.isSelectedFile = false;
  $scope.cargandoConsulta = false;
  $scope.initAdjunto = function(ruta) {
    $scope.adjunto = $("#fileuploader").uploadFile({
      url:ruta,
      autoSubmit: false,
      fileName:"myfile",
      dynamicFormData: function(){
        var data ={usuario:$scope.$parent.log.nombre_usuario}
        return data;
      },
      onSelect: function(files){
        $timeout(function(){
          $scope.isSelectedFile = true;
        });
        return true;
      },
      onSuccess: function(file, data){
        // actualizar listado de adjuntos
        $timeout(function(){
          $scope.isSelectedFile = false;
        });
      },
      onError: function(files,status,errMsg,pd){
        alert(JSON.stringify(errMsg));
        $scope.cargandoConsulta = false;
      }
    });
  }
  $scope.IniciarUploadAdjunto = function(){
    $scope.cargandoConsulta = true;
    $scope.adjunto.startUpload();
  }

  //Vendors
	$scope.tinyMCE = function(selTag){
		tinymce.init({
  	   selector: selTag
  	});
	}
}
