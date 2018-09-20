var historico_fact =  function($scope, $http, $timeout){
  $scope.resultado_cargue = [];
  $scope.resultados = [];
  $scope.rows = [];
  $scope.uploadView = true;
  $scope.validacionView = false;
  $scope.resultsView = false;
  $scope.proceso = '';
  $scope.spinner  = false;
  $scope.initAdjunto = function(ruta) {
    $timeout(
      function(){
        $scope.adjunto = $("#fileHistorico").uploadFile({
          url:ruta,
          autoSubmit: false,
          fileName:"file",
          dynamicFormData: function(){
            var data ={
              movimiento:'Cargue de historico de facturacion',
              id:$scope.$parent.log.idusuario,
              usuario:$scope.$parent.log.nombre_usuario,
              nombre_archivo: $scope.nombre_archivo
            }
            return data;
          },
          onSuccess: function(file, data){
            $scope.resultado_cargue = JSON.parse(data);
            console.log($scope.resultado_cargue);
            //$scope.cerrarWindow();
            //$scope.refreshTabs();
            $timeout(function(){
              $scope.uploadView = false;
              $scope.validacionView = true;
            });
          },
          onError: function(files,status,errMsg,pd){
            alert(JSON.stringify(errMsg));
          }
        });
      }
    );
  }
  $scope.IniciarUploadAdjunto = function(){
    $scope.adjunto.startUpload();
  }

  $scope.leerData = function(lnk, tipo){
    $scope.spinner  = true;
    $scope.proceso = tipo;
    console.log('cargando...'+ new Date().toUTCString() );
    $http.post(lnk, {
        path:$scope.resultado_cargue.return
      }).then(
        function(response) {
          $scope.rows = response.data;
          console.log(response.data);
          console.log('Cerrando...'+ new Date().toUTCString() );
          $scope.$parent.setValorProp(false, $scope, 'validacionView');
          $scope.$parent.setValorProp(true, $scope, 'resultsView');
          $scope.spinner = false;
        },
        function(response) {
          $scope.spinner = false;
          console.log(response.data);
        }
      );
  }

  $scope.asinateResults = function(rows, vw){
    $scope.resultados = rows;
    $scope.view = vw;
  }

  $scope.genDownloadFile = function(link, mdata){
    $http.post(link, mdata).then(
      function(response) {
        $scope.downloadFile = response.data;
        if($scope.downloadFile.success){
          window.open($scope.downloadFile.download);
        }else{
          console.log(response.data)
        }
      },
      function(err) {
        console.log(err.data);
      }
    );
  }

  $scope.restartValues = function(){
    $scope.resultado_cargue = [];
    $scope.resultados = [];
    $scope.rows = [];
    $scope.uploadView = true;
    $scope.validacionView = false;
    $scope.resultsView = false;
    $scope.proceso = '';
    $scope.spinner  = false;
  }
}

var cargues_historicos =  function($scope, $http, $timeout){
  $scope.respuesta_upload = undefined;
  $scope.respuesta_cargue = {};
  $scope.resultados = [];
  $scope.file_path = undefined;

  $scope.loader = false;
  $scope.selected_file = true;
  /*
  - Se desea realizar un cargue masivo mas generico para este tipo de gestiones, se desea un procedimiento estandard,
  el procedimiento seria el siguiente:
  1. Sequiere primero inicializar el uploader.
  2. Los cargues primero deben selecionar un contrato.
  3.1 Descargar plantilla.
  3.2 Seleccionar la plantilla seleccionada.
  4. Realizar la carga del archivo.
  5. Confirmar la lectura del archivo.
  */
  $scope.initAdjunto = function(ruta, tag) {
    $timeout(
      function(){
        $scope.adjunto = $(tag).uploadFile({
          url:ruta,
          autoSubmit: false,
          fileName:"file",
          dynamicFormData: function(){
            var data ={
              id:$scope.$parent.log.idusuario,
              usuario:$scope.$parent.log.nombre_usuario
            }
            return data;
          },
          onSelect:function(files){
              //files[0].name; files[0].size; return true;
              $timeout(function(){
                $scope.selected_file = false;
              });
              return true;
          },
          onCancel: function(files, pd){
            $scope.loader = false;
            $timeout(function(){
              $scope.selected_file = true;
            });
            return true;
          },
          onSuccess: function(file, data){
            $scope.loader = false;
            console.log(data);
            // ----------------------------------------------
            if ( $scope.isJSON(data) ) {
              $timeout(function(){
                $scope.respuesta_upload = JSON.parse(data);
                alert($scope.respuesta_upload.msj);
                if ($scope.respuesta_upload.status) {
                  $scope.file_path = $scope.respuesta_upload.file_path;
                }
              });
            }else{
              alert('No se puede procesar el mensaje de respuesta.')
            }
          },
          onError: function(files,status,errMsg,pd){
            $scope.loader = false;
            alert(JSON.stringify(errMsg));
          }
        });
      }
    );
  }

  $scope.IniciarUploadAdjunto = function(){
    $scope.loader = true;
    $scope.adjunto.startUpload();
  }

  $scope.leerArchivo = function(lnk, path){
    $scope.loader = true;
    var post = {file_path: path};
    // Enviamos id de contrato si existe
    if( $scope.$parent.contrato.idcontrato ){
      post.idcontrato = $scope.$parent.contrato.idcontrato;
      // enviamos solo si tenemos un contrato al que cargar un historico
      $http.post( lnk, post ).then(
        function(resp){
          console.log(resp.data);
          if(resp.data.status == true){
            $scope.respuesta_cargue = resp.data;
          }else if(resp.data.status == false){
            $scope.respuesta_cargue = resp.data;
            alert("Error en el proceso de lectura: "+resp.data.msj)
          }else{
            alert("Respuesta del servidor inesperada");
          }
          $scope.loader = false;
        },
        function(resp){
          console.log(resp.data);
          alert('Error al consultar el servidor.');
          $scope.loader = false;
        }
      );
    }
  }
}
