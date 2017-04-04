var reportes = function($scope, $http, $timeout) {
  $scope.CalendarLink = '';
  $scope.slide  = function(tag){
    $(tag).toggleClass('slide');
    $(tag).removeClass('unslide');
  }
  $scope.unslide = function(tag){
    $(tag).toggleClass('slide');
    $(tag).addClass('unslide');
  }
  $scope.verCalendario = function(url, tag){
    console.log(url+" - "+tag);
    $timeout(function(){
      $scope.CalendarLink = url;
      $scope.slide(tag);
    });
  }
  $scope.ocultarCalendario = function(tag){
    $timeout(function(){
      $scope.unslide(tag);
      $scope.CalendarLink = '';
    });
  }
  $scope.changeFilterSelect = function(fil,propiedad){
    console.log(propiedad);
		if(fil[propiedad] == undefined){
			fil[propiedad] = true;
		}else if (fil[propiedad] == true) {
			fil[propiedad] = undefined;
		};
	}
  $scope.selectionAll = function(listObj, prop){
    angular.forEach(listObj, function(val, key){
      val[prop] = val[prop]==undefined?true:undefined;
    });
  }
  $scope.mensaje = function(text){alert(text);}
  $scope.parseNumb = function(i){
    if (isNaN(i)){
      i = 0;
    }
    return parseFloat(i);
  }
  $scope.parseBool = function(i){
    return (i==1)? true: false;
  }
  $scope.setSelecteState = function(add){
		if(!add){
			add = true;
		}else{
			add = false;
		}
	}
  $scope.getStyleByValidacion = function(cell){
    var stylo = '';
    if (cell == 'VALIDO' || cell == 'VALIDO (FACT)'){
      stylo = {color:'#0CC91F', 'font-weight':'bold'};
    }else if (cell == 'CORREGIR'){
      stylo = {color:'red', 'font-weight':'bold'};
    }else if (cell == 'CORREGIDO' || cell == 'CORREGIDO (FACT)'){
      stylo = {color:'#AF9C0A', 'font-weight':'bold'};
    }
    return stylo;
  }

  $scope.getIconStatus = function(cell){
    if(cell == 'PENDIENTE'){
      return '+';
    }else if (cell == 'CORREGIR') {
      return 'f';
    }else if (cell == 'CORREGIDO' || cell == 'CORREGIDO (FACT)') {
      return '&#xe049;';
    }else if (cell == 'VALIDO' || cell == 'VALIDO (FACT)') {
      return '&#xe04c;';
    }else if (cell == 'ELABORADO') {
      return 'R';
    }
    return cell;
  }

  $scope.getStatusLaboral = function(idStatus, listStatus, obj, adicion){
    angular.forEach(listStatus, function(v,k){
      if(v.idestado_labor == idStatus){
         var i = ( (v.horas_ordinarias==8) && adicion)? 9: v.horas_ordinarias;
        $timeout(function() {
          obj.hora_inicio = v.hora_inicio;
          obj.hora_fin = v.hora_fin;
          obj.hora_inicio2 = v.hora_inicio2;
          obj.hora_fin2 = (adicion && v.hora_fin2== '16:00')?'17:00':v.hora_fin2;
          obj.facturable = v.facturable==1?true:false;
          obj.cantidad = parseInt(v.cantidad);
          obj.horas_ordinarias = (i==8 && adicion)?parseInt(v.horas_ordinarias)+1:parseInt(v.horas_ordinarias);
        });
      }
    });
  }
  $scope.getCantidadSum = function(url, fecha, act, idOT){
    var link = url+"/"+fecha+"/"+act.codigo+"/"+act.idsector_item_tarea+"/"+idOT;
    console.log(link);
    $http.get(link).then(
      function(response){
        console.log(response.data);
        act.acumulado = response.data;
      },
      function(response){
        alert(response.data)
      }
    );
  }
}

// ============================================================================================
// Reportes
var listOTReportes = function($scope, $http, $timeout){
  $scope.ot = {};
  $scope.rd = {};
  $scope.consulta = {};
  $scope.myOts = [];
  $scope.listaReportes = [];
  $scope.setloader = false;
  $scope.enlaceGetReporte= '';

  $scope.delReporte = function(url, id){
    $http.post( url+'/'+id, {} ).then(
      function(response){
        if(response.data == "success"){
          alert("proceso exitoso, por favor dale a ver reportes para refrescar la pagina.");
        }else {
          alert("Algo salio mal");
          console.log(response.data);
        }
      },
      function(response){
        alert("Algo salio mal");
        console.log(response.data);
      }
    );
  }

  $scope.initBase = function(url ,base){
    $scope.consulta.base = base;
    $scope.getOTs(url);
  }

  $scope.setDefaultFilter = function(){
    $scope.consulta.ot = '';
    $scope.myOts = [];
  }

  $scope.getOTs= function(url){
    console.log(url+"/"+$scope.consulta.base);
    if ( ($scope.consulta.base != undefined && $scope.consulta.base != '' ) || ( $scope.consulta.indicio_nombre_ot != undefined && $scope.consulta.indicio_nombre_ot != '' ) ) {
      $http.post(url+"/", {indicio_nombre_ot: $scope.consulta.indicio_nombre_ot, base: $scope.consulta.base})
      .then(
        function(response){
          $scope.myOts = response.data;
          console.log(response.data);
          if(response.data.length == 0 || response.data[0] == undefined){alert('No hay OT activas para esta parametro de busqueda')}
          else{
            $scope.myOts = response.data;
            $("#seleccionar-ot").toggleClass('nodisplay');
          }
        },
        function(response){alert('nodata')}
      );
    }else{
      alert('no se ha selecionado parametros de busqueda de orden de trabajo.');
    }
  }
  $scope.seleccionarOT = function(ot, site_url){
    $scope.consulta.ot = ot;
    $scope.consulta.idOT = ot.idOT;
    $scope.consulta.nombre_ot = ot.nombre_ot;
    $scope.setloader = true;
    $("#seleccionar-ot").toggleClass('nodisplay');
    $('#historialByOT').removeClass('nodisplay');
    $scope.getReportesView(site_url);
  }

  $scope.getReportesView = function(site_url){
    if($scope.consulta.ot != undefined && $scope.consulta.idOT != '' && $scope.consulta.nombre_ot != ''  && $scope.consulta.nombre_ot != undefined){
      $scope.ot.selected = false;
      $scope.ocultarCalendario('');
      var fecha = new Date();
      $scope.rd.fecha = fecha;
      $scope.rd.fecha_selected = fecha.getFullYear()+"-"+(fecha.getMonth()+1)+"-"+fecha.getDate();
      $scope.verCalendario(site_url+'/reporte/calendar'+"/"+$scope.consulta.idOT);
      $http.post(
          site_url+'/reporte/getReportesByOT',
          {
            idOT: $scope.consulta.idOT
          }
        ).then(
          function(response) {
            $scope.ot.selected = true;
            $scope.listaReportes = undefined;
            $scope.listaReportes = response.data;
            console.log(response.data)
          },
          function(response) {
            alert(response.data)
          }
        );
    }else{ alert('No hay información seleccionada, por favor busca una OT y seleccionala con el boton de Busqueda por No. o por base (Lupa)') }
  }
  //Calendario
  $scope.verCalendario = function(url){
    $timeout(function(){ $scope.calendarLink = url; });
  }
  $scope.ocultarCalendario = function(){
    $timeout(function(){ $scope.calendarLink = ''; });
  }
  $scope.seleccionarFecha = function(fecha, mes, year, url, $e){
    if( url != undefined ){
      var d = new Date(year, mes, fecha.dia);
      $scope.rd.fecha = d;
      $scope.rd.fecha_label = fecha.dia+'/'+mes+'/'+year
      $scope.rd.fecha_selected = year+'-'+mes+'-'+fecha.dia;
      fecha.clase2 = 'selected';
      $scope.enlazarClick(url, $e);
    }
  }

  $scope.enlazarClick = function(url, $e){
    $e.preventDefault();
    console.log(url+'valid/'+$scope.consulta.idOT+'/'+$scope.rd.fecha_selected);
    $http.get(url+'valid/'+$scope.consulta.idOT+'/'+$scope.rd.fecha_selected)
    .then(
      function(response) {
        console.log(response.data);
        if (response.data == "invalid") {
          alert('El reporte de esta fecha para esta OT ya existe');
        }else if(response.data == "valid") {
          var link = url+'/'+$scope.consulta.idOT+'/'+$scope.rd.fecha_selected;
          $scope.enlaceGetReporte = link;
          $scope.$parent.getAjaxWindowLocal(link, '#ventanaReporte', '#ventanaReporteOCulta');
        }
      },
      function(response) {
        alert(response.data)
      }
    );
  }

  $scope.getReporte = function(link, ventana, btnMostrar){
    $scope.enlaceGetReporte = '';
    $scope.enlaceGetReporte = link+"?v="+Math.random();
    $scope.$parent.getAjaxWindowLocal(link, ventana, btnMostrar);
  }
}
//==================================================================================================================================
//==================================================================================================================================
// controlador de agregar reporte
//==================================================================================================================================
var addReporte = function($scope, $http, $timeout) {
  // estructuras JSON y array
  $scope.rd = {
    info:{
      observaciones:[]
    },
    recursos:{
      personal:[],
      equipos:[],
      actividades:[]
    }
  }
  $scope.personalOT = [];
  $scope.equiposOT = [];
  $scope.actividadesOT = [];
  $scope.listStatus = [];

  //Busque de equipos no relacionados
  $scope.consultaEquiposOT = {};
  $scope.resultEquiposBusqueda = [];

	$scope.isOnPeticion = false;

  $scope.buscarEquiposBy = function(link){
    console.log(link)
    $http.post(link, {
      codigo_siesa: $scope.consultaEquiposOT.codigo_siesa,
      referencia: $scope.consultaEquiposOT.referencia,
      descripcion: $scope.consultaEquiposOT.descripcion,
      un: $scope.consultaEquiposOT.un
    }).then(
      function(response){
        console.log(response.data)
        $scope.resultEquiposBusqueda = response.data;
      },
      function(response){
        alert('Falló la consulta');
      }
    );
  }

  // Utilidades
  $scope.toggleContent = function(tag, clase, section){
    if(section != undefined){
			if ($(tag).hasClass(clase)) {
				$(section).addClass(clase);
			}else{
				$(section).addClass(clase);
				$(tag).removeClass(clase);
			}
		}
		$(tag).toggleClass(clase);
  }
  $scope.showContent = function(tag, section){
    $(section).hide();
    $(tag).show();
  }
  //------------------------------------------------------------------
  // Recursos
  //------------------------------------------------------------------
  // Datos para agregar al reporte
  // Obtener datos para formularios
  $scope.getRecursosByOT = function(url){
    $http.post(url, {})
      .then(
        function(response){
          $scope.personalOT = response.data.personal;
          $scope.equiposOT = response.data.equipo;
          $scope.actividadesOT = response.data.actividad;
          console.log(response.data);
        },
        function(response){
          alert("Problemas a la cargar los datos de los formularios, por favor cierra la ventana y vuelve a ingresar.")
        }
      )
  }
  // mostrar una sección para agregar elementos al reporte
  $scope.showRecursosReporte = function(section, tag){
    $(section).hide(section);
    $(tag).show();
  }
  // seleccionar todo un listado
  $scope.seleccionarTodosLista = function(lista){
    angular.forEach(lista, function(val, key){
      val.add = true;
    });
  }
  // Ocultar una seccion de agregar recursos y ejecutar una funcion de inicio
  $scope.closeRecursoReporte = function(section, method){
    if(method == 1 ){
      $scope.agregarPersonal();
    }else if(method == 2){
      $scope.agregarEquipos();
    }else if(method == 3){
      $scope.agregarActividades();
    }
    $timeout(function(){
      $(section).hide(100);
    });
  }
  // Agregar el personal seleccionado al reporte
  $scope.agregarPersonal = function(){
    angular.forEach($scope.personalOT, function(val, key){
      if(!$scope.existeRegistro($scope.rd.recursos.personal, 'identificacion', val.identificacion) && val.add){
        val.hora_inicio = '7:00';
        val.hora_fin = '12:00';
        val.hora_inicio2 = '13:00';
        if($scope.rd.idbase == 172 || $scope.rd.idbase == 173 || $scope.rd.idbase == 174){
          val.hora_fin2 = '17:00';
          val.horas_ordinarias = 9;
        }else{
          val.hora_fin2 = '16:00';
          val.horas_ordinarias = 8;
        }
        val.idestado_labor = '1';
        val.cantidad = 1;
        val.horas_rn = 0;
        val.horas_hed = 0;
        val.horas_hen = 0;
        val.gasto_viaje_pr = '';
        val.gasto_viaje_lugar = '';
        val.racion = 0;
        val.facturable = true;
        $scope.rd.recursos.personal.push(val);
      }
    });
  }
  // Agregar equipos seleccionados al reporte
  $scope.agregarEquipos = function(){
    angular.forEach($scope.equiposOT, function(val, key){
      if(
        (!$scope.existeRegistro($scope.rd.recursos.equipos, 'codigo_siesa', val.codigo_siesa) && val.add) ||
        ($scope.existeRegistro($scope.rd.recursos.equipos, 'codigo_siesa', val.codigo_siesa) && !$scope.existeRegistro($scope.rd.recursos.equipos, 'itemc_item', val.itemc_item) && val.add )
      )
      {
        val.horas_oper = 0;
        val.horas_disp = 1;
        val.cantidad = 1;
        val.facturable = true;
        $scope.rd.recursos.equipos.push(val);
      }
    });
  }
  // Agregar actividades seleccionadas al reporte
  $scope.agregarActividades = function(){
    angular.forEach($scope.actividadesOT, function(val, key){
      console.log(val);
      if(val.add
        &&
        (
          !$scope.existeRegistro($scope.rd.recursos.actividades, 'itemc_iditemc', val.itemc_iditemc)
          || !$scope.existeRegistro($scope.rd.recursos.actividades, 'idsector_item_tarea', val.idsector_item_tarea)
        )
      ){
        val.facturable = true;
        $scope.rd.recursos.actividades.push(val);
      }
    });
  }

  // Relacionar equipos desde esta vista
  $scope.relacionarEquipoAOt = function(it, url){
    console.log($scope.rd.info)
    $scope.$parent.relacionarEquipoAOt(it, url, $scope);
  }

  $scope.existeRegistro = function(list, prop, valor) {
    var bandera = false;
    angular.forEach(list, function(val, key){
      if(val[prop] == valor){
        bandera = true;
      }
    });
    return bandera;
  }

  $scope.quitarRegistroLista = function( lista, item, url, prop){
    if(false){
      $http.post(url, { prop: item[prop], }
      ).then(
        function(response){
          console.log(response.data)
          lista.splice(lista.indexOf(item),1);
        },
        function(response) {
          console.log(response.data);
          alert('Algo ha salido mal');
        }
      );
    }else{
      lista.splice(lista.indexOf(item),1);
    }
  }

  $scope.validarRecursos = function(url){
    if($scope.rd.recursos.personal.length == 0 && $scope.rd.recursos.equipos.length == 0 && $scope.rd.recursos.actividades.length == 0){
      alert('No hay recurso agregados');
    }else{
        $http.post(
          url,
          {
            idOT: $scope.rd.info.idOT,
            fecha: $scope.rd.info.fecha_reporte,
            recursos: $scope.rd.recursos,
            info: $scope.rd.info
          }
        ).then(
          function(response){
            console.log(response.data);
            $scope.rd.recursos = response.data.recursos;
            if(response.data.succ){
              $('#guardar_reporte').show();
              alert('todo parece correcto...');
            }else{
              $('#guardar_reporte').hide();
              alert('Los recursos agregados a la OT deben ser validados.')
            }
          },
          function(response) {
            console.log(response.data);
          }
        );
    }
  }
  $scope.addObservacion = function(){$scope.rd.info.observaciones.push({msj:''})}

  $scope.getStatusLaboral = function(idstst, per){
    var adicion = false;
    if($scope.rd.idbase == 172 || $scope.rd.idbase == 173 || $scope.rd.idbase == 174){
      adicion = true;
    }
    $scope.$parent.getStatusLaboral(idstst, $scope.listStatus, per, adicion);
  }

  // Guardar reporte
  $scope.guardarRD = function(url){
    if($scope.isOnPeticion){
      alert('Ya se esta realizando un proceso de guardado');
    }else if($scope.rd.recursos.personal.length == 0 && $scope.rd.recursos.equipos.length == 0 && $scope.rd.recursos.actividades.length == 0){
      alert('No hay recurso agregados');
    }else{
      $scope.isOnPeticion = true;
        $http.post(
          url,
          {
            idOT: $scope.rd.info.idOT,
            fecha: $scope.rd.info.fecha_reporte,
            recursos: $scope.rd.recursos,
            info: $scope.rd.info,
            log: $scope.$parent.log
          }
        ).then(
          function(response){
          	$scope.isOnPeticion = false;
            console.log(response.data);
            if(response.data.success == 'success'){
              alert("reporte guardado correctamente");
              $timeout(function(){
                $scope.$parent.cerrarWindowLocal('#ventanaReporte', $scope.enlaceGetReporte);
                $scope.getReportesView($scope.site_url);
                //$scope.$parent.refreshTabs();
              });
            }else{
              alert("¡Oh Nooo! "+response.data.msj);
              $timeout(function() {
                $scope.rd.recursos.personal = response.data.personal;
                $scope.rd.recursos.equipos = response.data.equipos;
                $scope.rd.recursos.actividades = response.data.actividades;
                $scope.booleanCorrection();
              });
            }
          },
          function(response) {
            $scope.isOnPeticion = false;
            console.log(response.data);
          }
        );
    }
  }
}
//==================================================================================================================================
//==================================================================================================================================
// Edit
//==================================================================================================================================
var editReporte = function($scope, $http, $timeout){
  // estructuras JSON y array
  $scope.rd = {
    info:{
      observaciones:[]
    },
    recursos:{
      personal:[],
      equipos:[],
      actividades:[]
    },
    observaciones_pyco:[]
  }
  $scope.personalOT = [];
  $scope.equiposOT = [];
  $scope.actividadesOT = [];
  $scope.estado_doc = [];
  $scope.myestado_doc = undefined;
  $scope.selected_validacion_doc = undefined;
  $scope.fecha_duplicar = '';
  $scope.tipoGuardado = 1;
  $scope.listStatus = [];

  $scope.getEstadoDoc = [];

  $scope.getEstadosDoc = function(data){
    $scope.estados_doc = data;
  }

  $scope.initEstadoDoc = function() {
    angular.forEach($scope.estados_doc, function(v, k){
      if(v.nombre_validacion_doc == $scope.rd.info.validado_pyco && v.estado_doc == $scope.rd.info.estado ){
        $scope.myestado_doc = v;
      }
    });
  	if($scope.rd.info.validado_pyco != 'CORREGIR'){
  		$(".corregirrd").hide();
  	}
  }

  $scope.appyEstadoDoc = function(validacion_selecionada){
  	if($scope.rd.info.validado_pyco == 'CORREGIR'){
  		$(".corregirrd").hide();
  	}
    var value = '';
    angular.forEach($scope.estados_doc, function(v,k){
      if (validacion_selecionada == v.idvalidacion_doc){
        value = v;
      }
    });
    $scope.myestado_doc = value;
    $scope.rd.info.estado = value.estado_doc;
    $scope.rd.info.validado_pyco = value.nombre_validacion_doc;

    $scope.$parent.addLog('reporte_diario', $scope.rd.idreporte_diario, 'Reporte diario: '+$scope.rd.fecha_reporte+' de OT:'+$scope.rd.nombre_ot+' Cambio de estado: '+value.nombre_validacion_doc);
    /* if(value.nombre_validacion_doc == "CORREGIDO"){
      $http.post($scope.$parent.site_url+"/sesion/sendMail2",{msj: " El reporte <b>"+$scope.rd.fecha_reporte+' de OT:'+$scope.rd.nombre_ot+' Cambio de estado: '+value.nombre_validacion_doc+" </b>. "});
    } */
  }

  $scope.getDataInfo = function(link){
    $http.post(link, {})
      .then(
        function(response){
          console.log(response.data);
          $scope.rd.info = response.data.info;
          $scope.rd.info.estado = response.data.estado;
          $scope.rd.info.validado_pyco = response.data.validado_pyco;
          if(response.data.observaciones_pyco != null || response.data.observaciones_pyco != undefined){
            $scope.rd.observaciones_pyco = response.data.observaciones_pyco;
          }else{
            $scope.rd.observaciones_pyco = [];
          }
          $scope.rd.recursos.personal = response.data.personal;
          $scope.rd.recursos.equipos = response.data.equipos;
          $scope.rd.recursos.actividades = response.data.actividades;
          $scope.initEstadoDoc();
        },
        function(response){
          console.log(response.data);
        }
      )
  }
  // ============
  // Duplicar un reporte
  $scope.formDuplicar = function(){
    $('#duplicar').toggleClass('nodisplay');
  }
  $scope.borrarIDs = function(){
    angular.forEach($scope.rd.recursos, function(val, key){
      angular.forEach(val, function(v,k){
        if(v.idrecurso_reporte_diario != undefined && v.idrecurso_reporte_diario != ''){
          v.idrecurso_reporte_diario = undefined;
        }
      });
    });
  }
  // Realiza la actividad de duplicar reporte
  $scope.duplicar = function(url, $e){
      if ($scope.fecha_duplicar == undefined ||  $scope.fecha_duplicar == '') {
        alert('No hay fecha selecionada');
      }else{
        $http.get(url+'/'+$scope.rd.info.idOT+'/'+$scope.fecha_duplicar).then(
          function (response) {
            console.log(response.data+" "+$scope.rd.info.idOT);
            if(response.data == 'invalid'){
              alert('Ya hay un reporte para esa fecha');
            }else if(response.data == 'valid'){
              $scope.rd.idreporte_diario = undefined;
              $scope.tipoGuardado = 0;
              $scope.rd.info.fecha_reporte = $scope.fecha_duplicar;
              $scope.rd.fecha_reporte = $scope.fecha_duplicar;
              $scope.rd.info.validado_pyco = "PENDIENTE";
              $scope.rd.info.estado = "ABIERTO";
              $scope.rd.observaciones_pyco = [];
              $scope.initEstadoDoc();
              $scope.borrarIDs();
              alert('Reporte duplicado listo para guardar en fecha '+$scope.fecha_duplicar);
              $('#duplicar').toggleClass('nodisplay');
            }else{
              alert('Proceso en revisión, intenta más tarde'+response.data)
            }
          },
          function (response) {
            alert('Falla: '+response.data)
          }
        );
      }
  }

  //Busque de equipos no relacionados
  $scope.consultaEquiposOT = {};
  $scope.resultEquiposBusqueda = [];

  $scope.buscarEquiposBy = function(link){
    console.log(link)
    $http.post(link, {
      codigo_siesa: $scope.consultaEquiposOT.codigo_siesa,
      referencia: $scope.consultaEquiposOT.referencia,
      descripcion: $scope.consultaEquiposOT.descripcion,
      un: $scope.consultaEquiposOT.un
    }).then(
      function(response){
        console.log(response.data)
        $scope.resultEquiposBusqueda = response.data;
      },
      function(response){
        alert('Falló la consulta');
      }
    );
  }

  // Utilidades
  $scope.toggleContent = function(tag, clase, section){
    if(section != undefined){
			if ($(tag).hasClass(clase)) {
				$(section).addClass(clase);
			}else{
				$(section).addClass(clase);
				$(tag).removeClass(clase);
			}
		}
		$(tag).toggleClass(clase);
  }
  $scope.showContent = function(tag, section){
    $(section).hide();
    $(tag).show();
  }
  //------------------------------------------------------------------
  // Recursos
  //------------------------------------------------------------------
  // Datos para agregar al reporte
  // Obtener datos para formularios
  $scope.getRecursosByOT = function(url){
    $http.post(url, {})
      .then(
        function(response){
          $scope.personalOT = response.data.personal;
          $scope.equiposOT = response.data.equipo;
          $scope.actividadesOT = response.data.actividad;
          console.log(response.data);
        },
        function(response){
          alert("Problemas a la cargar los datos de los formularios, por favor cierra la ventana y vuelve a ingresar.")
        }
      )
  }
  // mostrar una sección para agregar elementos al reporte
  $scope.showRecursosReporte = function(section, tag){
    $(section).hide(section);
    $(tag).show();
  }
  // seleccionar todo un listado
  $scope.seleccionarTodosLista = function(lista){
    angular.forEach(lista, function(val, key){
      val.add = true;
    });
  }
  // Ocultar una seccion de agregar recursos y ejecutar una funcion de inicio
  $scope.closeRecursoReporte = function(section, method){
    if(method == 1 ){
      $scope.agregarPersonal();
    }else if(method == 2){
      $scope.agregarEquipos();
    }else if(method == 3){
      $scope.agregarActividades();
    }
    $timeout(function(){
      $(section).hide(100);
    });
  }
  // Agregar el personal seleccionado al reporte
  $scope.agregarPersonal = function(){
    angular.forEach($scope.personalOT, function(val, key){
      if(!$scope.existeRegistro($scope.rd.recursos.personal, 'identificacion', val.identificacion) && val.add){
        val.hora_inicio = '7:00';
        val.hora_fin = '12:00';
        val.hora_inicio2 = '13:00';
        if($scope.rd.idbase == 172 || $scope.rd.idbase == 173 || $scope.rd.idbase == 174){
          val.hora_fin2 = '17:00';
          val.horas_ordinarias = 9;
        }else{
          val.hora_fin2 = '16:00';
          val.horas_ordinarias = 8;
        }
        val.idestado_labor = '1';
        val.cantidad = 1;
        val.horas_recargo = 0;
        val.horas_extra_dia = 0;
        val.horas_extra_noc = 0;
        val.facturable = true;
        val.gasto_viaje_pr = '';
        val.gasto_viaje_lugar = '';
		    val.racion = 0;
        $scope.rd.recursos.personal.push(val);
      }
    });
  }
  // Agregar equipos seleccionados al reporte
  $scope.agregarEquipos = function(){
    angular.forEach($scope.equiposOT, function(val, key){
      if(
        (!$scope.existeRegistro($scope.rd.recursos.equipos, 'codigo_siesa', val.codigo_siesa) && val.add) ||
        ($scope.existeRegistro($scope.rd.recursos.equipos, 'codigo_siesa', val.codigo_siesa) && !$scope.existeRegistro($scope.rd.recursos.equipos, 'itemc_item', val.itemc_item) && val.add )
      ){
        val.horas_operacion = 0;
        val.horas_disponible = 1;
        val.cantidad = 1;
        val.facturable = true;
        $scope.rd.recursos.equipos.push(val);
      }
    });
  }
  // Agregar actividades seleccionadas al reporte
  $scope.agregarActividades = function(){
    angular.forEach($scope.actividadesOT, function(val, key){
      console.log(val);
      if(val.add
        &&
        (
          !$scope.existeRegistro($scope.rd.recursos.actividades, 'codigo', val.codigo) ||
          !$scope.existeRegistro($scope.rd.recursos.actividades, 'idsector_item_tarea', val.idsector_item_tarea)
        )
      ){
        val.facturable = true;
        $scope.rd.recursos.actividades.push(val);
      }
    });
  }

  // Relacionar equipos desde esta vista
  $scope.relacionarEquipoAOt = function(it, url){
    console.log($scope.rd.info)
    $scope.$parent.relacionarEquipoAOt(it, url, $scope);
  }

  $scope.existeRegistro = function(list, prop, valor) {
    var bandera = false;
    angular.forEach(list, function(val, key){
      if(val[prop] == valor){
        bandera = true;
      }
    });
    return bandera;
  }

  $scope.quitarRegistroLista = function( lista, item, url, prop){
    if(url!='' && ( item.idrecurso_reporte_diario != undefined && item.idrecurso_reporte_diario != '' ) && $scope.tipoGuardado == 1 ){
      $http.post(url+'/'+item.idrecurso_reporte_diario, { idrecurso_reporte_diario: item.idrecurso_reporte_diario } ).then(
        function(response){
          console.log(response.data)
          if(response.data == "success"){
            alert("proceso realizado");
            lista.splice(lista.indexOf(item),1);
          }else{
            alert("Algo NO fue como esperabamos...")
          }
        },
        function(response) {
          console.log(response.data);
          alert('Algo ha salido mal');
        }
      );
    }else{
      lista.splice(lista.indexOf(item),1);
    }
  }

  $scope.validarRecursos = function(url){
    if($scope.rd.recursos.personal.length == 0 && $scope.rd.recursos.equipos.length == 0 && $scope.rd.recursos.actividades.length == 0){
      alert('No hay recurso agregados');
    }else{
        $http.post(
          url,
          {
            idOT: $scope.rd.info.idOT,
            fecha: $scope.rd.info.fecha_reporte,
            recursos: $scope.rd.recursos,
            info: $scope.rd.info
          }
        ).then(
          function(response){
            console.log(response.data);
            $scope.rd.recursos = response.data.recursos;
            if(response.data.succ){
              $('#guardar_reporte').show();
              alert('todo parece correcto...');
            }else{
              alert('Los recursos agregados a la OT deben ser validados.')
            }
          },
          function(response) {
            console.log(response.data);
          }
        );
    }
  }
  $scope.addObservacion = function(){ $scope.rd.info.observaciones.push({msj:''}) }
  $scope.addObservacion2 = function(obspyco){
    var f = new Date();
    var data = {
        msj:obspyco,
        fecha: f.toLocaleString(),
        usuario: $scope.$parent.log.nombre_usuario
      };
    $scope.rd.observaciones_pyco.push(data);
  }

  $scope.getStatusLaboral = function(idstst, per){
    var adicion = false;
    if($scope.rd.idbase == 172 || $scope.rd.idbase == 173 || $scope.rd.idbase == 174){
      adicion = true;
    }
    $scope.$parent.getStatusLaboral(idstst, $scope.listStatus, per, adicion);
  }

  // Guardar reporte
  $scope.guardarRD = function(link, link2) {
    var data = {
      idOT: $scope.rd.info.idOT,
      fecha: $scope.rd.fecha_reporte,
      recursos: $scope.rd.recursos,
      info: $scope.rd.info,
      observaciones_pyco: $scope.rd.observaciones_pyco,
      log: $scope.$parent.log
    };
    if ($scope.tipoGuardado == 0) {
      $scope.guardarReporte(link, data);
    }else{
      data.idreporte_diario = $scope.rd.idreporte_diario;
      console.log(data);
      $scope.guardarReporte(link2, data);
    }
  }

  $scope.guardarReporte = function(url, data){
    if($scope.isOnPeticion){
      alert('Ya se esta realizando un proceso de guardado');
    }else if($scope.rd.recursos.personal.length == 0 && $scope.rd.recursos.equipos.length == 0 && $scope.rd.recursos.actividades.length == 0){
      alert('No hay recurso agregados');
    }else{
      $scope.isOnPeticion = true;
        $http.post(
          url,
          data
        ).then(
          function(response){
            $scope.isOnPeticion = false;
            $scope.rd.recursos.personal = [];
            $scope.rd.recursos.equipos = [];
            $scope.rd.recursos.actividades = [];
            if(response.data.success == 'success'){
              alert("reporte guardado correctamente");
              if($scope.tipoGuardado == 0){
                $scope.tipoGuardado = 1;
                $scope.rd.idreporte_diario = response.data.idreporte_diario;
              }
            }else{
                alert("¡Oh Nooo! "+response.data.msj);
                console.log(response.data);
            }
            $timeout(function() {
              $scope.rd.recursos.personal = response.data.personal;
              $scope.rd.recursos.equipos = response.data.equipos;
              $scope.rd.recursos.actividades = response.data.actividades;
              $scope.booleanCorrection();
            });
            //$('#guardar_reporte').hide();
            $scope.getReportesView($scope.site_url);
          },
          function(response) {
            $scope.isOnPeticion = false;
          }
        );
    }
  }

  $scope.booleanCorrection = function(){
	  angular.forEach($scope.rd.recursos.personal, function(v,k){
		v.facturable = $scope.$parent.parseBool(v.facturable);
		v.print = $scope.$parent.parseBool(v.print);
	  });
	  angular.forEach($scope.rd.recursos.equipos, function(v,k){
		v.facturable = $scope.$parent.parseBool(v.facturable);
	  });
	  angular.forEach($scope.rd.recursos.equipos, function(v,k){
		  v.facturable = $scope.$parent.parseBool(v.facturable);
	  });
  }
  $scope.resetRecursos = function(lista, recursos){
    angular.forEach(recursos, function(v,k){
      lista.push(v);
    })
  }
}

var imprimirRD = function($scope, $http, $timeout){
  $scope.recursos = {
  };
  $scope.getRecursos = function(link){
    console.log(link);
    $http.get(link).then(
      function(response){
        $scope.recursos = response.data;
        console.log(response.data);
      },
      function(response){
        alert("Algo ha salido mal");
        console.log(response.data);
      }
    )
  }

  $scope.printSelected = function(link){
    
  }
}
