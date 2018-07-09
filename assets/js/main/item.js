var itemc = function($scope, $http, $timeout){

  $scope.items = [];

  $scope.getItemsByContrato = function(lnk, idcontrato){
    console.log(lnk+"/"+idcontrato);
    if(idcontrato){
      $http.get(lnk+"/"+idcontrato).then(
        function(resp){
          if(resp.data.status){
            $scope.items = resp.data.items;
            console.log($scope.items.length);
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

}
