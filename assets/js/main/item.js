var itemc = function($scope, $http, $timeout){
  $scope.contrato = {};
  $scope.items = [];
  $scope.validateItem = false;

  $scope.cargueItems = {
    status: false,
    error:false,
    resultados: []
  }

  $scope.ventanaModal = [];
  $scope.pageSize = 20;

  // ------ formulario de items -------
  $scope.initModals = function(el){
    M.Modal.init( $(el) );
    $scope.ventanaModal.push( M.Modal.getInstance($(el)) );
  }

  $scope.openForm = function(item, el){
    var i = $scope.ventanaModal.indexOf(M.Modal.getInstance($(el)));
    $scope.ventanaModal[i].open();
    if(item){
      $scope.myitem = item;
    }
  }

  $scope.closeForm = function(el){
    if(confirm('¿Desea cerrar el formulario?')){
      var i = $scope.ventanaModal.indexOf(M.Modal.getInstance($(el)));
      $scope.ventanaModal[i].close();
      $scope.myitem = {};
    }
  }

  // Guardar item
  $scope.save = function(lnk, it, lnk2){
    $http.post(lnk, {item: it, idcontrato: $scope.contrato.idcontrato}).then(
      function(resp) {
        if( resp.status ){
          $scope.getItemsByContrato(lnk2, $scope.contrato.idcontrato);
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

  // Obtener todos los Contratos para selecionarlos
  $scope.contratos = [];
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

  $scope.selecionarContrato = function(c, el){
    if(c){
      var lnk = $scope.$parent.site_url+'/item/get_itemc/';
      M.Modal.getInstance($(el)).close();
      $scope.getItemsByContrato(lnk, c.idcontrato);
    }
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

  // ---------------------------- UPLOAD FILE -----------------------------------
  $scope.isSelectedFile = false;
  $scope.spinner = false;

  $scope.initAdjunto = function(ruta) {
    console.log(ruta)
    // Se guarda en una variable el objeto retornado del inicio de la funcion de carga
    $scope.adjunto = $("#cargue_items").uploadFile({
      url:ruta,
      autoSubmit: false,
      allowedTypes:'xlsx',
      fileName:"myfile",
      dragDrop:false,
      dynamicFormData: function(){
        var data = {
          idcontrato : $scope.contrato.idcontrato
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
        $timeout(function(){
          var resp = $scope.parseJSON(data);
          console.log(resp);
          if(resp.status == true){
            $scope.cargueItems = resp;
            $scope.cargueItems.error = false;
          }else if (resp.status == false) {
            $scope.cargueItems = resp;
            $scope.cargueItems.error = true;
          }else{
            alert('No se ha completado el cargue');
          }
        })
        $scope.isSelectedFile = false;
        $scope.spinner = false;
      },
      onError: function(files,status,errMsg,pd){
        alert("Erro de cargue de archivo");
        console.log(errMsg);
        $scope.isSelectedFile = false;
        $scope.spinner = false;
      },
      onCancel: function(files,pd){
        $scope.isSelectedFile = false;
        $scope.spinner = false;
      }
    });
  }
  // esta funcion es invocada al darle click al botón adjuntar/cargar
  $scope.IniciarUploadAdjunto = function(){
    $scope.spinner = true;
    $scope.adjunto.startUpload();
  }

}
