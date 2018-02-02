var recursosOT = function($scope, $http, $timeout){
  $scope.myOts = [];
  $scope.ot = {};
  $scope.myitemf_eq={};
  $scope.cambio_un = { show: false, data: undefined };
  $scope.recursosOT = {
      personal:[],
      equipo:[],
      material:[],
      otros:[]
  }
  $scope.findPersonal = false;
  $scope.addPersonaExterno = false;
  $scope.seleccionar_ot = false;

  $scope.addEquipo = {};
  $scope.itemsOT = [];

  $scope.getOTs= function(url, link){
    $http.post(url+"/", $scope.consulta)
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
      function(resp){
          $scope.recursosOT.personal = resp.data.personal;
          $scope.recursosOT.equipo = resp.data.equipo;
          $scope.recursosOT.material = resp.data.material;
          $scope.recursosOT.otros = resp.data.otros;
          $scope.itemsOT = resp.data.itemsOT;
      },
      function(resp){
        alert(resp.data);
      }
    );
  }

  $scope.enableViewRelacion = function(viewModel, status, optionDisable){
    if(viewModel){$scope[viewModel] = status;}
    if(optionDisable){$scope[optionDisable] = !status;}
  }

  $scope.showSection = function(tag){
    $(tag).toggleClass('nodisplay');
  }

  $scope.addPersonalOT =  function(pers, lnk){
    $http.post(lnk, pers).then(
      function(response){
        alert('Agregado con exito. '+response.data);
        $("fieldset #seleccionar-ot").toggleClass('nodisplay');
        //$("#ot-recursos").addClass('nodisplay');
        $scope.getRecursoOT($scope.consulta.ot);
      },
      function(response){
        console.log(response.data);
        alert('Algo ha fallado');
      }
    );
  }

  $scope.addRecursoOT = function(it, url, tp, item){
    $http.post(url,
      {
        recurso_idrecurso: null,
        idOT: $scope.consulta.idOT,
        codigo: item.codigo,
        iditemf: item.iditemf,
        tipo:tp,
        codigo_temporal:it.codigo_temporal,
        descripcion_temporal: it.descripcion_temporal,
        propietario_recurso: it.propietario_recurso,
        propietario_observacion: it.propietario_observacion,
        costo_und: it.costo_und
      }
    ).then(
      function(response){
        alert('Agregado con exito. '+response.data);
        $("fieldset #seleccionar-ot").toggleClass('nodisplay');
        //$("#ot-recursos").addClass('nodisplay');
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

  $scope.relacionarRecursosOT = function(url,mytipo,item,view){
    $http.post(url, {
      idrecurso: item.idrecurso,
      tipo: mytipo,
      iditemf: item.itemf.iditemf,
      codigo: item.itemf.codigo,
      idOT: $scope.consulta.idOT,
      propietario_recurso: item.propietario_recurso,
      propietario_observacion: item.propietario_observacion
    }).then(
      function(response){
        console.log(response.data);
        $scope.getRecursoOT($scope.consulta.ot);
        view = false;
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

  $scope.cambioUN = function(rec){
    $timeout( function(){
      $scope.cambio_un.show = true;
      $scope.cambio_un.data = rec;
    })
  }

  $scope.cambiarUN = function(link, recs, dom_item){
    $http.post(link, recs.data).then(
      function(resp){
        if (resp.data.success) {
          console.log(resp.data);
          $('#modal1').modal('close');
        }else{
          alert("error de actualizacion");
          console.log(resp.data);
        }
      },
      function(resp){
        alert("error de peticion");
        console.log(resp.data);
      }
    );
  }
}
