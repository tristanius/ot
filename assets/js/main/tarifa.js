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
}
