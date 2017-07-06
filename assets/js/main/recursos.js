var recursosOT = function($scope, $http, $timeout){
  $scope.myOts = [];
  $scope.ot = {};
  $scope.myitemf_eq={};
  $scope.recursosOT = {
      personal:[],
      equipo:[]
  }
  $scope.seleccionar_ot = false;

  $scope.addEquipo = {};
  $scope.itemsOT = [];

  $scope.getOTs= function(url, link){
    $http.post(url+"/", {indicio_nombre_ot: $scope.consulta.indicio_nombre_ot})
    .then(
      function(response){
        $scope.myOts = response.data;
        console.log(response.data);
        $scope.consulta.linkOT = link;
        if(response.data.length == 0 || response.data[0] == undefined){alert('No hay OT activas para esta parametro de busqueda')}
        else{
          $scope.myOts = response.data;
          $scope.seleccionar_ot = true;
        }
      },
      function(response){alert('nodata')}
    );
  }
  $scope.seleccionarOT = function(ot){
    $scope.consulta.ot = ot;
    $scope.consulta.idOT = ot.idOT;
    $scope.consulta.nombre_ot = ot.nombre_ot;
    $scope.getRecursoOT(ot);
    $("#ot-recursos").removeClass('nodisplay')
    $scope.seleccionar_ot = false;
  }

  $scope.getRecursoOT = function(ot){
    console.log($scope.consulta.linkOT+'/'+ot.idOT);
    $http.post($scope.consulta.linkOT+'/'+ot.idOT, { idOT: $scope.consulta.ot.idOT })
    .then(
      function(response){
          $scope.recursosOT.personal = response.data.personal;
          $scope.recursosOT.equipo = response.data.equipo;
          $scope.itemsOT = response.data.itemsOT;      },
      function(response){
        alert(response.data);
      }
    );
  }

  $scope.showSection = function(tag){
    $(tag).toggleClass('nodisplay');
  }

  $scope.addEquipoTempOT = function(eq, url){
    console.log($scope.myitemf_eq);
    $http.post(url,
      {
        recurso_idrecurso: null,
        idOT: $scope.consulta.idOT,
        codigo: $scope.myitemf_eq.codigo,
        iditemf: $scope.myitemf_eq.iditemf,
        tipo:'equipo',
        codigo_temporal:eq.codigo_temporal,
        descripcion_temporal: eq.descripcion_temporal
      }
    ).then(
      function(response){
        alert('Agregado con exito. '+response.data);
        $("fieldset #seleccionar-ot").toggleClass('nodisplay');
        $("#ot-recursos").addClass('nodisplay');
        $scope.getRecursoOT($scope.consulta.ot);
      },
      function(response){
        console.log(response.data);
        alert('Algo ha fallado');
      }
    );
  }

  $scope.findRecursoOT = function(url, mytipo, myconsulta, lista){
    $http.post(
      url,
      { tipo: mytipo, consulta: myconsulta}
    ).then(
      function(response){
        console.log(response.data);
        alert('Proceso realizado');
        $scope[lista] = response.data;
        $scope.getRecursoOT($scope.consulta.ot);
      },
      function(response){
        alert(response.data);
      }
    );
  }

  $scope.relacionarRecursosOT = function(url,mytipo,item){
    $http.post(url, {
      idrecurso: item.idrecurso,
      tipo: mytipo,
      iditemf: item.itemf.iditemf,
      codigo: item.itemf.codigo,
      idOT: $scope.consulta.idOT
    }).then(
      function(response){
        console.log(response.data);
        $scope.getRecursoOT($scope.consulta.ot);
      },
      function(response){
        console.log(response.data);
      }
    )
  }

  $scope.delRecursoOT = function(link, idr, idrot){
    $http.post(link, {idrecurso: idr, idrecurso_ot: idrot } ).then(
      function(response){
        console.log(response.data);
        if(response.data == 'success'){
          alert('Relación eliminada, Actualiza la consulta.');
        }else{
          alert('Ummmmm... Algo no fue como esperabamos. Por favor revisa la información.')
        }
      },
      function(response){
        console.log(response.data);
        alert("Algo ha salido mal!");
      }
    );
  }

}
