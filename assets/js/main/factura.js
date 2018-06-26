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
  $scope.doc_status = 'sin cambios';
  $scope.deteccionCambios = false;
  $scope.factura = {
    actas:[],
    bases:[],
    recursos:[],
    ordenes:[],
    conceptos_factura:[],
    factura_adjuntos:[]
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
            $scope.calcularRecursos();
            $scope.doc_status = 'modificado';
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
          $scope.doc_status = 'modificado';
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
  // ---- form recursos ----
  $scope.calcularRecursos = function(){
    var subtotal = 0;
    var i = 0;
    angular.forEach($scope.factura.recursos, function(v,k){
      i++;
      v.subtotal = v.tarifa * v.disponibilidad;
      v.a = v.a_vigencia*(v.subtotal);
      v.i = v.i_vigencia*(v.subtotal);
      v.u = v.u_vigencia*(v.subtotal);
      v.total = ( v.subtotal + v.a + v.i + v.u );
      subtotal += v.total;
    });
  }

  $scope.deleteRecurso = function(elemento, lnk){
    $scope.$parent.spinner = true;
    var i = $scope.factura.recursos.indexOf(elemento);
    var conf = confirm("Desea continuar borrando este concepto de la factura "+$scope.factura.no_factura+"?");
    if(conf){
      if( elemento.idfactura_recurso_reporte ){
        $http.post(lnk, elemento).then(
          function(resp){
            if(resp.data.status){
              $scope.factura.recursos.splice(i, 1);
              $scope.doc_status = 'modificado';
            }else{
              console.log(resp.data);
              alert('Algo ha salido mal al eliminar un recurso.');
            }
            $scope.$parent.spinner = false;
          },
          function(resp){
            alert("Error de servidor");
            $scope.$parent.spinner = false;
            console.log(resp.data)
          }
        );
      }else{
        $scope.factura.recursos.splice(i, 1);
      }
    }
    $scope.$parent.spinner = false;
  }

  // ---- form otros ----
  $scope.calcularOtros = function(){
    var otros = 0;
    var i = 0;
    angular.forEach($scope.factura.conceptos_factura, function(v,k){
      otros += v.valor;
    });
    $scope.factura.otros = otros;
  }

  $scope.addConceptoFactura = function(obj){
    $scope.$parent.spinner = true;
    if(obj.item && obj.concepto && obj.valor){
      $scope.factura.conceptos_factura.push(obj);
      $scope.doc_status = 'modificado';
    }else{
      alert("Hay campos necesarios por llenar");
    }
    $scope.calcularOtros();
    $scope.$parent.spinner = false;
  }

  $scope.removeConceptoFactura = function(otr, lnk){
    $scope.$parent.spinner = true;
    var i = $scope.factura.conceptos_factura.indexOf(otr);
    var conf = confirm("Desea continuar borrando este concepto de la factura "+$scope.factura.no_factura+"?");
    if (conf) {
      if(otr.idconcepto_factura && conf ){
        $http.post(lnk, otr).then(
          function(resp){
            if(resp.data.status){
              $scope.factura.conceptos_factura.splice(i, 1);
              $scope.calcularOtros();
              $scope.doc_status = 'modificado';
            }else{
              alert("Fallo al eliminar");
              console.log(resp.data);
            }
          },
          function(resp){
            alert("Fallo al eliminar");
            console.log(resp.data);
          }
        );
      }else{
        $scope.factura.conceptos_factura.splice(i, 1);
      }
    }
    $scope.$parent.spinner = false;
  }

  /// ==========================================================================
  // Guardar
  $scope.save = function(link, tipo){
    if( ($scope.factura.fecha_inicio && $scope.factura.fecha_fin) && ($scope.factura.recursos || $scope.factura.recursos.length >= 0) ){
      $scope.$parent.spinner = true;
      $http.post(link, $scope.factura)
      .then(
        function(response){
          if(response.data.status == true) {
            $scope.factura= response.data.factura;
            $scope.doc_status = 'guardado';
            alert("Procedimiento realizado con exito.");
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

  // ------------------------ Adjuntos ---------------------------------------
  // Upload file
  $scope.isSelectedFile = false;

  $scope.initAdjunto = function(ruta) {
    // Se guarda en una variable el objeto retornado del inicio de la funcion de carga
    $scope.adjunto = $("#fileuploader").uploadFile({
      url:ruta,
      autoSubmit: false,
      fileName:"myfile",
      dynamicFormData: function(){
        var data ={
          usuario: $scope.$parent.log.nombre_usuario,
          path: 'factura/adjunto/',
          gestion: '',
          referencia: ''
        }
        return data;
      },
      onSelect: function(files){
        $timeout(function(){
          $scope.isSelectedFile = true;
        });
        return true;
      },
      onSuccess: function(file, data, xhr){
        console.log(data);
        data = JSON.parse(data);
        $timeout(function(){
          if(data.status == true){
            $scope.factura.factura_adjuntos.push(data.adjunto);
            $scope.doc_status = 'modificado';
          }
        });
        $scope.isSelectedFile = false;
        $scope.$parent.spinner = false;
      },
      onError: function(files,status,errMsg,pd){
        alert("Erro de cargue de archivo");
        console.log(status);
        console.log(errMsg);
        $scope.isSelectedFile = false;
        $scope.$parent.spinner = false;
      },
      onCancel: function(files,pd){
        $scope.isSelectedFile = false;
        $scope.$parent.spinner = false;
      }
    });
  }
  // esta funcion es invocada al darle click al botón adjuntar/cargar
  $scope.IniciarUploadAdjunto = function(){
    $scope.$parent.spinner = true;
    $scope.adjunto.startUpload();
  }
  // borrar un adjunto
  $scope.deleteAdjunto = function(lnk, adj){
    $scope.$parent.spinner = true;
    $http.post(lnk,
      {
        id: adj.idadjunto,
        nombre_adjunto: adj.nombre_adjunto
      }
    ).then(
      function(resp){
        if(resp.data.status==true){
          var i = $scope.factura.factura_adjuntos.indexOf(adj);
          $scope.factura.factura_adjuntos.splice(i, 1);
          $scope.doc_status = 'modificado';
        }
        $scope.$parent.spinner = false;
        console.log(resp.data)
      },
      function(resp){
        $scope.$parent.spinner = false;
        alert("Error al borrar adjunto");
        console.log(resp.data);
      }
    );
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
