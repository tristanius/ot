var factura = function($scope, $http, $timeout){
  $scope.consulta = {};
  $scope.contrato = {vigencias:[], facturas:[]};
  $scope.loaders = {};
  $scope.enlaceGetFactura = '';
  $scope.linkDataContrato = '';
  $scope.spinner = false;

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

  // spinner .gif
  $scope.toggleLoader = function(loader){
    return loader?false:true;
  }

  // Carga la información de un formulario para agregar o modificar una factura
  $scope.factura = function(link, ventana, btnMostrar) {
    console.log(link);
    $scope.resetView(link);
    $scope.$parent.getAjaxWindowLocal(link, ventana, btnMostrar);
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

  $scope.deteccionCambios = false;
  $scope.factura = {
    actas:[],
    bases:[],
    recursos:[],
    ordenes:[]
  };
  $scope.currentPage = 0;
  $scope.pageSize = 13;
  $scope.orden = {recursos:[]};
  $scope.panel_visible = false;


  // ---------- Obtener una factura ya exitente ----------------------
  $scope.getFactura = function(lnk, id){
    $scope.$parent.spinner = true;
    $http.post(lnk, {idfactura: id})
    .then(
      function(resp){
        if(resp.data.status){
          $scope.factura = resp.data.factura;
        }
        console.log(resp.data);
        $scope.$parent.spinner = false;
      },
      function(resp){
        alert('algo salio mal');
        console.log(resp.data);
        $scope.$parent.spinner = false;
      }
    );
  }

  // Renderiza las pestañas de JQuery
  $scope.initForm = function(selector){
    $( function() {
      $( selector ).tabs();
      $('.tooltipped').tooltip();
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
      $scope.$parent.spinner = true;
      $http.post(link, $scope.factura)
      .then(
        function(response){
          if(response.data.success){
            $scope.factura.recursos = response.data.recursos;
            $scope.factura.ordenes = response.data.ordenes;
          }
          $scope.deteccionCambios = false;
          console.log(response.data);
          $scope.$parent.spinner = false;
        },
        function(response){
          $scope.deteccionCambios = false;
          $scope.$parent.spinner = false;
          console.log(response.data);
          alert("error al consultar recursos");
        }
      );
  }

  //----------------------------------------------------------------------------
  //Procedimientos para filtrar consultas

  // Obtener ordenes de trabajo
  $scope.getOrdenes = function(lnk){
    $scope.$parent.spinner = true

    $http.post(lnk, $scope.factura).then(
      function(resp){
        if(resp.data.success){
          $scope.factura.ordenes = resp.data.ordenes;
        }else{
          console.log(resp.data);
          alert("Algo ha fallado al consultar Ordenes");
        }
        $scope.deteccionCambios = false;
        $scope.$parent.spinner = false;
      },
      function(resp){
        $scope.deteccionCambios = false;
        $scope.$parent.spinner = false;
        console.log(resp.data);
        alert("Algo ha fallado al consultar Ordenes");
      }
    );
  }

  //-----------------------------------------------------------------------------
  // Seleccion de centros de operacion excluidos
  $scope.selectedCOs = function(){
    var i = 0;
    $scope.factura.centros_operacion_excluidos = [];
    angular.forEach($scope.factura.centros_operacion, function(v,k){
      if (!v.isSelected) {
        i++;
        $scope.factura.centros_operacion_excluidos.push(v.idbase);
      }
    });
    if(i<=0){
      $scope.factura.centros_operacion_excluidos = undefined;
    }
  }
  // Selecccion de ordenes de trabajo excluidas
  $scope.selectedOTs = function(){
    var i = 0;
    $scope.factura.ordenes_excluidas = [];
    angular.forEach($scope.factura.ordenes, function(v,k){
      if (!v.isSelected) {
        i++;
        $scope.factura.ordenes_excluidas.push(v.idOT);
      }
    });
    if(i<=0){
      $scope.factura.ordenes_excluidas = undefined;
    }
  }

  /// ==========================================================================
  // Guardar
  $scope.save = function(link, tipo){
    if( ($scope.factura.fecha_inicio && $scope.factura.fecha_fin) && ($scope.factura.recursos || $scope.factura.recursos.length >= 0) ){
      $scope.$parent.spinner = true;
      $scope.factura.descripcion = tinymce.get('notas').getContent();
      $http.post(link, $scope.factura)
      .then(
        function(response){
          if(response.data.status == true) {
            $scope.factura= response.data.factura;
            alert("Procedimiento realizado conexito.")
          }else{
            alert('Se ha interrumpido el proceso');
          }
          console.log(response.data);
          $scope.$parent.spinner = false;
        },
        function(response){
          $scope.$parent.spinner = false;
          console.log(response.data);
          alert('Algo ha salido mal');
        }
      );
    }else {
      alert("Faltan campos basicos por diligenciar");
    }
  }
  // ===========================================================================

  $scope.togglePanel = function(){
    $scope.panel_visible = $scope.$parent.toggleLoader($scope.panel_visible);
  }
  // Numero de paginas para las paginas de la tabla
  $scope.numberOfPages=function(lista){
    return Math.ceil(lista.length/$scope.pageSize);
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
    if (tipo == 'base') {
      $scope.orden = {recursos:[]};
    }
    $scope.currentPage =  0;
    $scope.pgNum = 1;
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
  // --------------------------------------------------------------------------
  // Upload file
  $scope.isSelectedFile = false;

  $scope.initAdjunto = function(ruta) {
    // Se guarda en una variable el objeto retornado del inicio de la funcion de carga
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
        $scope.$parent.spinner = false;
      }
    });
  }
  // esta funcion es invocada al darle click al botón adjuntar/cargar
  $scope.IniciarUploadAdjunto = function(){
    $scope.$parent.spinner = true;
    $scope.adjunto.startUpload();
  }
  //Vendors
	$scope.tinyMCE = function(selTag){
    // evaluar si es necesario remover tinymce primero
		tinymce.init({
  	   selector: selTag
  	});
	}
  $scope.removeTinyMCE = function(tag){
    tinymce.remove(tag);
  }
}
