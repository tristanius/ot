var migracion_recursos = function($scope, $http, $timeout){
  $scope.ot_origen = {idOT:undefined, nombre_ot:'', base_idbase:''}
  $scope.ot_destino = {idOT:undefined, nombre_ot:'', base_idbase:''}
  $scope.ot_seleccionada = undefined;

  $scope.ventanaMigrarSeleccionOT = function(model, ventana){
    $scope.ot_seleccionada = model;
    $('#'+ventana).removeClass('nodisplay');
  }

  $scope.searchOT = function(link){
    $http.post(link, { nombre_ot_buscado: $scope.nombre_ot_buscado })
    .then(
      function(response){
        $scope.listado_busqueda = response.data;
      },
      function(response){
        alert("Algo ha salido mal");
        console.log(response.data);
      }
    );
  }

}
