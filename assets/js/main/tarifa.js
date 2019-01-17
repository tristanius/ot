var addTarifa = function($scope, $http, $timeout){
  $scope.data= [];
  $scope.error = false;

  $scope.initAdjunto = function(ruta){
    $scope.adjunto = $("#FileUploader").uploadFile({
      url:ruta,
      fileName:"file",
      autoSubmit: false,
      onSuccess:function(files,data,xhr,pd){
        console.log(data);
        if(data == "success"){
          $("#div-upload").hide();
          $("#btn-validar").removeClass("nodisplay");
        }else{
          alert(JSON.stringify(data));
        }
      },
      onError: function(files,status,errMsg,pd){
        alert(JSON.stringify(data));
      }
    });
  }

  $scope.IniciarUploadAdjunto = function(){
    console.log($scope.ruta);
    $scope.adjunto.startUpload();
  }

  $scope.go = function(link){
    //Inicio de la petición
    $http.get(link)
    .then(
      function(response){
        console.log(response.data);
        $("#btn-validar").addClass("nodisplay");
        $("#confirmar").removeClass("nodisplay");
      },
      function(response){
        console.log(response.data);
        $("#btn-validar").addClass("nodisplay");
      }
    );
    //fin de petición
  }

  $scope.submit = function(link){
    $http.get(link)
      .then(
        function(response){
          console.log(response.data);
          if(response.data == "success"){
            alert('OK');
          }else{
            console.log(response.data);
          }
          $("#confirmar").addClass("nodisplay");
        },
        function(response){
          console.log(response.data);
        }
      );
  }

  $scope.initUploadTarifas = function(ruta) {
    console.log(ruta)
    // Se guarda en una variable el objeto retornado del inicio de la funcion de carga
    $scope.adjunto = $("#cargue_items").uploadFile({
      url:ruta,
      autoSubmit: false,
      allowedTypes:'xlsx',
      fileName:"myfile",
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
  $scope.IniciarUploadTarifas = function(){
    $scope.spinner = true;
    $scope.adjunto.startUpload();
  }
}
