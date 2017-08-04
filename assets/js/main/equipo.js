var lista_equipos = function($scope, $http, $timeout)
{
  $scope.consulta = {};
  $scope.equs = [];
  $scope.cargandoConsulta = false;
  $scope.filtro_lp = [];
  $scope.cargaListaEquipos = function(ruta, key=null){
    console.log(ruta)
    $scope.cargandoConsulta = true;
    $http.post(
      ruta,
      {
        llave : key
      }
    ).then(
      function(response) {
        $scope.equs=response.data;
        $scope.cargandoConsulta = false;
      },
      function(response) {
        alert('Algo ha salido mal, verifica tu conexion a intenet y ponte en contacto con tu departamento TIC. '+response.data);
        console.log(response);
        $scope.cargandoConsulta = false;
      }
    );
  }

  $scope.byOT = function(url) {
    $scope.cargandoConsulta = true;
    $http.post(url, { indicio_nombre_ot: $scope.consulta.indicio_nombre_ot })
    .then(
      function(response){
          $scope.equs = response.data;
          $scope.cargandoConsulta = false;
          //console.log(response.data);
      },
      function(response){
        alert(response.data);
      }
    );
  }

  $scope.delRecursoOT = function(link, idr, idrot){
    $http.post(link, {idrecurso: idr, idrecurso_ot: idrot } ).then(
      function(response){
        if(response.data == 'success'){
          alert('Relación eliminada');
        }else{
          alert('Ummmmm... Algo no fue como esperabamos. Por favor revisa la información.')
        }
      },
      function(response){alert("Algo ha salido mal!")}
    );
  }

  $scope.verHistorialCarguesOT = function(link, myidequ){
    $scope.$parent.switchTagClass('#consultaEquipo','nodisplay');
    if (link != '') {
      $scope.$parent.getAjaxWindowPOST(link, {idequipo: myidequ}, '#consultaEquipo');
    }
  }
}

var equipoUP = function($scope, $http, $timeout) {
  	// upload de archivos
    $scope.cargandoConsulta = false;
    $scope.initAdjunto = function(ruta) {
      $scope.adjunto = $("#fileuploader").uploadFile({
        url:ruta,
        autoSubmit: false,
        fileName:"myfile",
        /*dynamicFormData: function(){
          var data ={'test':'test'}
          return data;
        },*/
        onSuccess: function(file, data){
          $("#resultado").html(data);
          $("#inputhtml").val(data)
          //console.log(JSON.stringify(data));
          //$scope.cerrarWindow();
          //$scope.refreshTabs();
          $scope.cargandoConsulta = false;
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
}
