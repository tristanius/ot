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
    if( !add ){
			add = true;
		}else{
			add = false;
		}
	}
  //-----------------------------------------------------------------------------
  // Procesos generales del reporte

  $scope.existeRegistro = function(list, prop, valor) {
    var bandera = false;
    angular.forEach(list, function(val, key){
      if(val[prop] == valor){
        bandera = true;
      }
    });
    return bandera;
  }
  $scope.existeRegistroFull = function(list, item, propiedades){
    var retorno = false;
    angular.forEach(list, function(valor,key){
      bandera = true;
      angular.forEach(propiedades, function(v, k){
        if( valor[v] != item[v] ){
          bandera = false;
        }
      });
      if (bandera) {
        retorno = true; // Si las iteraciones fueron de valores iguales entonce existe
      }
    });
    return retorno;
  }
  // --------------------------------------------------------------------------
  // UTILIDADES
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
  $scope.setHeader = function(selector1){
    //$(selector1+' tbody tr#thead1').clone().appendTo(selector1+' thead#thead2');
    $(selector1).css({ "width": $(selector1+" tbody").outerWidth()+"px" });
    var widths = [];
    $(selector1+' tbody tr:last-child th').each(function(indice){
    	widths[indice] = {w:$(this).outerWidth()};
    });
    $( selector1+' thead#thead2 tr:last-child th').each(function(indice){
    	var cell = widths[indice];
    	$(this).css( { "width": cell.w+"px" } );
    });
    $(selector1+' tbody tr:last-child th').each(function(indice){
      var cell = widths[indice];
    	$(this).css( { "width": cell.w+"px" } );
    });
  }

  $scope.popObservacion = function(list, obs) {
    if( confirm("¿Esta seguro de borrar esta observacion?") ){
      list.splice(list.indexOf(obs),1);
    }
  }

  //--------------------------------------------------------------------------
  // Procesos de los frentes
  $scope.initRecursosFilters =function(){
    $scope.personalFilter={};
    $scope.equipoFilter={};
    $scope.actividadFilter={};
    $scope.materialFilter={};
    $scope.otrosFilter={};
  }

  $scope.changeFrente = function(val, rd, tag){
    $(tag).hide(50);
    var rec = angular.copy(rd.recursos);
    rd.recursos = undefined;
    $timeout(function(){
      $scope.personalFilter.idfrente_ot = val;
      $scope.equipoFilter.idfrente_ot = val;
      $scope.actividadFilter.idfrente_ot = val;
      $scope.materialFilter.idfrente_ot = val;
      $scope.otrosFilter.idfrente_ot = val;
      rd.recursos = rec;
      $(tag).show(50);
    }, 100);
  }

  $scope.initFrentes = function(lista){
    $scope.frentes = lista;
  }
  $scope.getFrente = function(id){
    var dato = 'Sin seleccion.';
    angular.forEach($scope.frentes, function(v,k){
      if(v.idfrente_ot == id)
        dato = v.nombre+" - "+v.ubicacion;
    });
    return dato;
  }

  $scope.initItemsPlaneados = function( lnk ){
    $http.get(lnk).then(
      function(resp){
        if(resp.data.status){
          $scope.items_planeados = resp.data.items_planeados;
        }else{
          $scope.items_planeados = [];
          alert("No ha podido completar el proceso de consulta items planeados");
        }
      },
      function(resp){
        alert('Algo ha fallado al conectar al servidor.');
        console.console.log(resp.data); }
    );
  }

  $scope.viewAsociarItem = function(obj, tag){
    $scope.asociableItem = obj;
    $(tag).show();
  }
  $scope.asociarItem = function(it, tag){
    $scope.asociableItem.item_asociado = it.itemc_item;
    $(tag).hide();
  }
  // Agregar el personal seleccionado al reporte
  $scope.agregarPersonal = function(ambito){
    var msj = '';
    angular.forEach(ambito.personalOT, function(val, key){
      if( !$scope.existeRegistroFull( ambito.rd.recursos.personal, val, ['identificacion', 'itemf_iditemf', 'cc'] ) && val.add ){
        var per = angular.copy(val);
        per.hora_inicio = '7:00'; per.hora_fin = '12:00'; per.hora_inicio2 = '13:00';
        if (ambito.rd.idbase == 172 || ambito.rd.idbase == 173 || ambito.rd.idbase == 174){
          per.hora_fin2 = '17:00';
          per.horas_ordinarias = 9;
        }else if (ambito.rd.idbase == 244 || ambito.rd.idbase == 262) {
          if (ambito.dia_semana == 'sábado') {
            per.hora_fin = '-';
            per.hora_inicio2 = '-';
            per.hora_fin2 = '10:00';
            per.horas_ordinarias = 3;
          }else if (ambito.dia_semana == 'viernes' &&  ambito.rd.idbase == 262) {
            per.hora_inicio2 = '-';
            per.hora_fin2 = '04:00';
            per.horas_ordinarias = 8;
          }else{
            per.hora_fin2 = '17:00';
            per.horas_ordinarias = 9;
          }
        }else{
          per.hora_fin2 = '16:00';
          per.horas_ordinarias = 8;
        }
        per.idestado_labor = '1';
        per.cantidad = 1;
        per.horas_rn = 0;
        per.horas_hed = 0;
        per.horas_hen = 0;
        per.gasto_viaje_pr = '';
        per.gasto_viaje_lugar = '';
        per.racion = 0;
        per.facturable = true;
        // AQUI SE AGREGA EL FRENTE SELECCIONADO
        if(ambito.myfrente){
          var f = ambito.myfrente;
          per.idfrente_ot = f;
        }
        ambito.rd.recursos.personal.push(per);
      }else{
        if(val.add){
          msj += 'La persona: '+val.identificacion+' '+val.nombre_completo+' ya existe con ese CC. \n';
        }
      }
    });
    if(msj){
      alert( msj );
    }
  }
  // Agregar equipos seleccionados al reporte
  $scope.agregarEquipos = function(ambito){
    var msj = ''
    angular.forEach(ambito.equiposOT, function(val, key){
      if( ( !ambito.existeRegistroFull(ambito.rd.recursos.equipos, val, ['codigo_siesa', 'itemf_iditemf', 'cc']) && val.add ) || (val.codigo_siesa == "Temporal" && val.add) )
      {
        val.horas_oper = 0;
        val.horas_disp = 1;
        val.cantidad = 1;
        val.facturable = true;
        // AQUI SE AGREGA EL FRENTE SELECCIONADO
        if(ambito.myfrente){
          var f = ambito.myfrente;
          val.idfrente_ot = f;
        }
        ambito.rd.recursos.equipos.push(val);
      }else{
        console.log("No ha sido agregado "+val.codigo_siesa)
        if(val.add){
          msj += 'El equipo: '+val.codigo_siesa+' ya existe con ese CC. \n';
        }
      }
    });
  }
  // Agregar actividades seleccionadas al reporte
  $scope.agregarActividades = function(ambito){
    angular.forEach(ambito.actividadesOT, function(val, key){
      if(val.add){
        var rec = angular.copy(val);
        rec.facturable = true;
        rec.cantidad = 0;
        // AQUI SE AGREGA EL FRENTE SELECCIONADO
        if(ambito.myfrente){
          var f = ambito.myfrente;
          rec.idfrente_ot = f;
        }
        ambito.rd.recursos.actividades.push(rec);
      }
    });
  }
  // Agregar equipos seleccionados al reporte
  $scope.agregarMaterial = function(ambito){
    angular.forEach(ambito.materialOT, function(val, key){
      if(val.add)
      {
        val.facturable = true;
        val.cantidad = 1;
        // AQUI SE AGREGA EL FRENTE SELECCIONADO
        if(ambito.myfrente){
          var f = ambito.myfrente;
          val.idfrente_ot = f;
        }
        ambito.rd.recursos.material.push(val);
      }
    });
  }
  // Agregar equipos seleccionados al reporte
  $scope.agregarOtros = function(ambito){
    angular.forEach(ambito.otrosOT, function(val, key){
      if(val.add)
      {
        val.facturable = true;
        val.cantidad = 1;
        // AQUI SE AGREGA EL FRENTE SELECCIONADO
        if(ambito.myfrente){
          var f = ambito.myfrente;
          val.idfrente_ot = f;
        }
        ambito.rd.recursos.otros.push(val);
      }
    });
  }
  // Agregar equipos seleccionados al reporte
  $scope.agregarSubcontratos = function(ambito){
    angular.forEach(ambito.subcontratosOT, function(val, key){
      if(val.add)
      {
        var rec = angular.copy(val);
        rec.facturable = true;
        rec.cantidad = 1;
        // AQUI SE AGREGA EL FRENTE SELECCIONADO
        if(ambito.myfrente){
          var f = ambito.myfrente;
          rec.idfrente_ot = f;
        }
        ambito.rd.recursos.subcontratos.push(rec);
      }
    });
  }
  // Validar cantidades de recursos reportados
  $scope.validarRecursoReporte = function(listado, cantidadTope, field, searchBy){
    let items = [];
    let suma = 0;
    let repetidos = 0;
    angular.forEach(listado, function(value, key){
      if ( value[field] == searchBy) {
        suma += value.cantidad;
        items.push(value);
      }
    });
    if(suma > cantidadTope){
      angular.forEach(items, function(it, key){
        it.msj = "Los elementos superan las cantidades maximas de la unidad.";
        it.valid = false;
      });
    }
  }

  // calculo de horas
  $scope.timeOfTheDay = function(timeDate){
    if ( timeDate.includes(':') && moment(timeDate, 'hh:mm').isValid() ) {
      return moment(timeDate, 'hh:mm');
    }
    return false;
  }

  $scope.calcHorasTurno = function(inicio_turno, fin_turno){
    let ini_noche = moment('21:00','hh:mm'); // Inicio noche
    let media_noche = moment('00:00','hh:mm'); // Media noche
    let fin_noche = moment('06:00','hh:mm'); // Inicio de día
    let turno = {};
    // Cal. horas totales
    turno.horas = fin_turno.diff(inicio_turno, "hours", true);
    // Calc. horas recargo madrugada
    let madrugada = fin_noche.diff(inicio_turno, 'hours', true);
    turno.madrugada += (madrugada > 0)?madrugada:0;
    // Calc. horas noche
    let noche = fin_turno.diff(ini_noche, 'hours', true);
    turno.noche = noche > 0 ? noche: 0;
    return turno;
  }

  $scope.calcHoras = function(rec, horas_laborales){
    var turno = {};
    inicio_turno1 = $scope.timeOfTheDay( rec.hora_inicio );
    fin_turno1 = $scope.timeOfTheDay( rec.hora_fin );
    inicio_turno2 = $scope.timeOfTheDay( rec.hora_inicio2 );
    fin_turno2 = $scope.timeOfTheDay( rec.hora_fin2 );
    if( inicio_turno1 && fin_turno2 && !inicio_turno2 && !fin_turno1 ){
      // Cuando es turno integral
      turno = $scope.calcHorasTurno( inicio_turno1, fin_turno2 );
    }else if( inicio_turno1 || inicio_turno2 ){
      // Si existe algun turno 1 o 2 (horas de inicio)
      let t1 = { horas:0, noche:0, madrugada:0 };
      let t2 = { horas:0, noche:0, madrugada:0 };
      if( inicio_turno1 && fin_turno1 ){
        t1 = $scope.calcHorasTurno( inicio_turno1, fin_turno1 ); // turno 1
      }
      if( inicio_turno2 && fin_turno2 ){
        t2 = $scope.calcHorasTurno( inicio_turno2, fin_turno2 ); // turno 2
      }
      turno.horas = t1.horas+t2.horas;
      turno.noche = t1.noche+t2.noche;
      turno.madrugada = t1.madrugada+t2.madrugada;
    }
    console.log(turno);
    // Validacion de turno con valores de horas
    if(turno.horas > horas_laborales){
      let x = (turno.horas - horas_laborales) > 0?(turno.horas - horas_laborales):0;
      rec.horas_extra_dia = (x - turno.noche) > 0?(x - turno.noche):0;
      rec.horas_extra_noc = (turno.noche - x) > 0?(turno.noche - x):0;
      rec.horas_recargo = turno.madrugada;
      rec.horas_ordinarias = turno.horas - x;
    }else if(turno.madrugada > 0 || turno.noche > 0){
      rec.horas_recargo = turno.madrugada+turno.noche;
      rec.horas_ordinarias = turno.horas;
    }
    return rec;
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
  $scope.seleccionar_ot = false;
  $scope.historialByOT = false;

  $scope.delReporte = function(url, id){
    var ok = confirm("Confirma que desea borrar este elemento?");
    if(ok){
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
    if (
      ($scope.consulta.base != undefined && $scope.consulta.base != '' ) ||
      ($scope.consulta.indicio_nombre_ot != undefined && $scope.consulta.indicio_nombre_ot != '' ) ||
      ($scope.consulta.estado != undefined && $scope.consulta.estado != '' )
    ) {
      $http.post(url+"/", $scope.consulta)
      .then(
        function(response){
          $scope.myOts = response.data;
          console.log(response.data);
          if(response.data.length == 0 || response.data[0] == undefined){alert('No hay OT activas para esta parametro de busqueda')}
          else{
            $scope.myOts = response.data;
            $scope.seleccionar_ot = true;
            $scope.historialByOT = false;
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
    $scope.seleccionar_ot = false;
    $scope.historialByOT = true;
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
            console.log(response.data);
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
        if (response.data == "invalid") {
          alert('El reporte de esta fecha para esta OT ya existe');
        }else if(response.data == "valid") {
          var link = url+'/'+$scope.consulta.idOT+'/'+$scope.rd.fecha_selected;
          console.log(link);
          $scope.enlaceGetReporte = link;
          $scope.$parent.getAjaxWindowLocal(link, '#ventanaReporte', '#ventanaReporteOCulta');
        }else if (response.data == 'toolong') {
          alert('Fecha fuera de los rangos permitidos. No se permite afectar los cortes de reportes.');
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
      observaciones:[],
      actividades:[]
    },
    recursos:{
      personal:[],
      equipos:[],
      actividades:[],
      material:[],
      otros:[],
      subcontratos:[]
    }
  }
  $scope.personalOT = [];
  $scope.equiposOT = [];
  $scope.actividadesOT = [];
  $scope.listStatus = [];

  $scope.isOnPeticion = false;

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
          $scope.materialOT = response.data.material;
          $scope.otrosOT = response.data.otros;
          $scope.subcontratosOT = response.data.subcontratos;
        },
        function(response){
          console.log(response.data);
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
      $scope.$parent.agregarPersonal($scope);
    }else if(method == 2){
      $scope.$parent.agregarEquipos($scope);
    }else if(method == 3){
      $scope.$parent.agregarActividades($scope);
    }else if(method==4){
      $scope.$parent.agregarMaterial($scope);
    }else if(method==5){
      $scope.$parent.agregarOtros($scope);
    }else if(method==6){
      $scope.$parent.agregarSubcontratos($scope);
    }
    $timeout(function(){
      $(section).hide(100);
    });
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
        $scope.isOnPeticion = true;
        $http.post(
          url,
          {
            idOT: $scope.rd.info.idOT,
            fecha: $scope.rd.info.fecha_reporte,
            festivo:$scope.rd.info.festivo,
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
            $scope.isOnPeticion = false;
          },
          function(response) {
            console.log(response.data);
          }
        );
    }
  }
  $scope.addObservacion = function(tipo){
    var f = new Date();
    if (tipo=='proveedor') {
      $scope.rd.info.observaciones.push( { msj:'', tipo:'proveedor', fecha: f.toLocaleString() } );
    }else{
      $scope.rd.info.observaciones_cliente.push( { msj:'', tipo:'cliente', fecha: f.toLocaleString() } );
    }
  }

  $scope.addActividad = function(tipo){
    var f = new Date();
    if($scope.rd.info.actividades == undefined){
      $scope.rd.info.actividades = [];
    }
    if (tipo=='proveedor') {
      $scope.rd.info.actividades.push( { msj:'', tipo:'proveedor', fecha: f.toLocaleString() } );
    }else{
      $scope.rd.info.actividades.push( { msj:'', tipo:'cliente', fecha: f.toLocaleString() } );
    }
  }

  $scope.getStatusLaboral = function(idstst, per){
    var adicion = false;
    if($scope.rd.idbase == 172 || $scope.rd.idbase == 173 || $scope.rd.idbase == 174){
      adicion = true;
    }
    $scope.$parent.getStatusLaboral(idstst, $scope.listStatus, per, adicion);
  }

  // Guardar reporte
  $scope.guardarRD = function(url){
    var recursos = $scope.rd.recursos;
    if( recursos.personal.length == 0 && recursos.equipos.length == 0 && recursos.actividades.length == 0 && recursos.material.length == 0 && recursos.otros.length == 0 && recursos.subcontratos.length == 0){
      if( !confirm('No hay recurso agregados, ¿desea continuar con el guardado?') ){
        return;
      }
    }
    if($scope.isOnPeticion){
      alert('Ya se esta realizando un proceso de guardado');
    }else{
      $scope.isOnPeticion = true;
        $http.post(
          url,
          {
            idOT: $scope.rd.info.idOT,
            fecha: $scope.rd.info.fecha_reporte,
            festivo: $scope.rd.info.festivo,
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
              alert("Hemos encontrado un fallo inesperado."+response.data.msj);
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
      actividades:[],
      material:[],
      otros:[]
    },
    observaciones_pyco:[]
  }
  $scope.personalOT = [];
  $scope.equiposOT = [];
  $scope.actividadesOT = [];
  $scope.materialOT = [];
  $scope.otrosOT = [];
  $scope.estado_doc = [];
  $scope.myestado_doc = undefined;
  $scope.selected_validacion_doc = undefined;
  $scope.fecha_duplicar = '';
  $scope.tipoGuardado = 1;
  $scope.listStatus = [];
  $scope.spinner = true;

  $scope.appyEstadoDoc = function(new_estado, new_validacion){
    $scope.myestado_doc = new_estado;
    $scope.myvalidacion_doc = new_validacion;
  }
  $scope.aplicarEstado = function(new_estado, new_validacion){
    var myfecha = new Date();
    $scope.rd.info.estado = new_estado;
    $scope.rd.info.validado_pyco = new_validacion;// REEMPLADO DE VENTANA EMERGENTE
    $scope.mensaje_log = "Estado aplicado "+new_validacion+" - "+myfecha.toLocaleString()+". A la espera de evento de guardado.";
    $scope.mensaje_log_color = 'yellow accent-1';
  }
  $scope.guardarestado = function() {
    new_estado = $scope.rd.info.estado;
    new_validacion = $scope.rd.info.validado_pyco;
    $http.post($scope.site_url+'/reporte/updateEstado',
      { estado: new_estado, validado_pyco: new_validacion, observaciones_pyco: $scope.rd.observaciones_pyco, idreporte_diario: $scope.rd.idreporte_diario }
    ).then(
      function(response){
        if (response.data.success == 'success') {
          $scope.$parent.addLog('reporte_diario', $scope.rd.idreporte_diario, 'Reporte diario: '+$scope.rd.fecha_reporte+' de OT:'+$scope.rd.nombre_ot+' Cambio de estado: '+new_validacion, 'RD ELABORADO');
          $scope.myvalidacion_doc = undefined;
          $scope.myestado_doc = undefined;
          // REEMPLADO DE VENTANA EMERGENTE
          $scope.mensaje_log = response.data.mensaje_log;
          $scope.mensaje_log_color = 'light-green lighten-5';
          $scope.getReportesView($scope.site_url);
        }else{
          alert('algo ha salido mal');
          console.log(response.data);
        }
      },
      function(response) {
        alert('Imposible conectar');
      }
    );
  }

  $scope.getDataInfo = function(link){
    $http.post(link, {})
      .then(
        function(response){
          $scope.rd.info = response.data.info;
          response.data.info.idOT = $scope.rd.idOT;
          response.data.info.fecha_reporte = $scope.rd.fecha_reporte;
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
          $scope.rd.recursos.material = response.data.material;
          $scope.rd.recursos.otros = response.data.otros;
          $scope.rd.recursos.subcontratos = response.data.subcontratos;
          $scope.spinner = false;
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
          if( v.idavance_reporte ){
            v.idavance_reporte = undefined;
          }
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
              $scope.borrarIDs();
              alert('Reporte duplicado listo para guardar en fecha '+$scope.fecha_duplicar);
              $('#duplicar').toggleClass('nodisplay');
              $scope.dupeInNomina($scope.rd.recursos.personal);
            }else if (response.data == 'toolong') {
              alert('Fecha fuera de los rangos permitidos. No se permite afectar los cortes de reportes.');
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
  $scope.dupeInNomina = function(lista){
    angular.forEach(lista, function(v,k){
      v.nomina = false;
      v.validacion_he = false;
    });
  }

  // Utilidades
  $scope.toggleContent = function(tag, clase, section, myfun=undefined){
    if(section != undefined){
			if ($(tag).hasClass(clase)) {
				$(section).addClass(clase);
			}else{
				$(section).addClass(clase);
				$(tag).removeClass(clase);
			}
		}
		$(tag).toggleClass(clase);
    if (myfun) {
      $scope.$parent[myfun]("#personalReporte");
      $scope.$parent[myfun]("#equiposReporte");
    }
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
          $scope.materialOT = response.data.material;
          $scope.otrosOT = response.data.otros;
          $scope.subcontratosOT = response.data.subcontratos;
        },
        function(response){
          console.log(response.data);
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
      $scope.$parent.agregarPersonal($scope);
    }else if(method == 2){
      $scope.$parent.agregarEquipos($scope);
    }else if(method == 3){
      $scope.$parent.agregarActividades($scope);
    }else if(method==4){
      $scope.$parent.agregarMaterial($scope);
    }else if(method==5){
      $scope.agregarOtros();
    }else if(method==6){
      $scope.$parent.agregarSubcontratos($scope);
    }
    $timeout(function(){
      $(section).hide(100);
    });
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
        $scope.isOnPeticion = true;
        $scope.spinner = true;
        $http.post(
          url,
          {
            idOT: $scope.rd.idOT,
            nombre_ot: $scope.rd.nombre_ot,
            festivo: $scope.rd.festivo,
            fecha: $scope.rd.fecha_reporte,
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
            $scope.isOnPeticion = false;
            $scope.spinner = false;
          },
          function(response) {
            console.log(response.data);
          }
        );
    }
  }

  // CORREGIR
  $scope.addObservacion = function(tipo){
    var f = new Date();
    if (tipo=='proveedor') {
      $scope.rd.info.observaciones.push( {msj:'', tipo:'proveedor', fecha: f.toLocaleString()} );
    }else{
      $scope.rd.info.observaciones_cliente.push( {msj:'', tipo:'cliente', fecha: f.toLocaleString()} );
    }
  }
  // CORREGIR
  $scope.addObservacion2 = function(obspyco){
    var f = new Date();
    var data = {
        msj:obspyco,
        fecha: f.toLocaleString(),
        usuario: $scope.$parent.log.nombre_usuario
      };
    $scope.rd.observaciones_pyco.push(data);
  }
  // CORREGIR
  $scope.addActividad = function(tipo){
    var f = new Date();
    if($scope.rd.info.actividades == undefined){
      $scope.rd.info.actividades = [];
    }
    if (tipo=='proveedor') {
      $scope.rd.info.actividades.push( { msj:'', tipo:'proveedor', fecha: f.toLocaleString() } );
    }else{
      $scope.rd.info.actividades.push( { msj:'', tipo:'cliente', fecha: f.toLocaleString() } );
    }
  }
  // CORREGIR
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
      idOT: $scope.rd.idOT,
      nombre_ot: $scope.rd.nombre_ot,
      festivo: $scope.rd.festivo,
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
    var recursos = $scope.rd.recursos;
    if($scope.isOnPeticion){
      alert('Ya se esta realizando un proceso de guardado');
    }else{
      $scope.isOnPeticion = true;
      $scope.spinner = true;
        $http.post(
          url,
          data
        ).then(
          function(response){
            $scope.isOnPeticion = false;
            $scope.spinner = false;
            $scope.rd.recursos.personal = [];
            $scope.rd.recursos.equipos = [];
            $scope.rd.recursos.actividades = [];
            $scope.rd.recursos.material = [];
            $scope.rd.recursos.otros = [];
            $scope.rd.recursos.subcontratos = [];
            if(response.data.success == 'success'){
              // REEMPLADO DE VENTANA EMERGENTE
              $scope.mensaje_log = response.data.msj;
              $scope.mensaje_log_color = 'light-green lighten-5';
              if($scope.tipoGuardado == 0){
                $scope.tipoGuardado = 1;
                $scope.rd.idreporte_diario = response.data.idreporte_diario;
              }
            }else{
                alert("¡Oh Nooo! "+response.data.msj);
                $scope.mensaje_log = response.data.msj;
                $scope.mensaje_log_color = 'red darken-1';
            }
            console.log( response.data );
            $timeout(function() {
              $scope.rd.recursos.personal = response.data.personal;
              $scope.rd.recursos.equipos = response.data.equipos;
              $scope.rd.recursos.actividades = response.data.actividades;
              $scope.rd.recursos.material = response.data.material;
              $scope.rd.recursos.otros = response.data.otros;
              $scope.rd.recursos.subcontratos = response.data.subcontratos;
              $scope.booleanCorrection();
            });
            $scope.getReportesView($scope.site_url);
          },
          function(response) {
            console.log(response.data);
            $scope.spinner = false;
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
	  angular.forEach($scope.rd.recursos.actividades, function(v,k){
		  v.facturable = $scope.$parent.parseBool(v.facturable);
	  });
  }
  $scope.resetRecursos = function(lista, recursos){
    angular.forEach(recursos, function(v,k){
      lista.push(v);
    })
  }
}

// =============================================================================
// Controlador para imprimir por seleccion
var imprimirRD = function($scope, $http, $timeout){
  $scope.recursos = {};
  $scope.retorno = { personal:[], equipos:[], actividades:[], observaciones:[] };

  $scope.getRecursos = function(link){
    $scope.retorno = { personal:[], equipos:[], actividades:[], observaciones:[] };
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

  $scope.filtrarImprimibles = function(recursos){
    angular.forEach(recursos.personal, function(val,key){
      if(val.imprimir)
        $scope.retorno.personal.push(val);
    });
    angular.forEach(recursos.equipos, function(val,key){
      if(val.imprimir)
        $scope.retorno.equipos.push(val);
    });
    angular.forEach(recursos.actividades, function(val,key){
      if(val.imprimir)
        $scope.retorno.actividades.push(val);
    });
    $scope.retorno.observaciones = [];
    angular.forEach(recursos.json_r.observaciones, function(val, key){
      if (val.print) {
        $scope.retorno.observaciones.push(val);
      }
    });

    $scope.retorno.elaborador_nombre = $scope.recursos.json_r.elaborador_nombre;
    $scope.retorno.contratista_nombre = $scope.recursos.json_r.contratista_nombre;
    $scope.retorno.ecopetrol_nombre = $scope.recursos.json_r.ecopetrol_nombre;

    $scope.retorno.elaborador_cargo = $scope.recursos.json_r.elaborador_cargo;
    $scope.retorno.contratista_cargo = $scope.recursos.json_r.contratista_cargo;
    $scope.retorno.ecopetrol_cargo = $scope.recursos.json_r.ecopetrol_cargo;
  }

  $scope.printSelected = function(){
    $scope.retorno = { personal:[], equipos:[], actividades:[] };
    $scope.filtrarImprimibles($scope.recursos);
    $("#jsonSelection").val( JSON.stringify($scope.retorno) );
    $("#formPrintSelected").submit();
  }
}

// =============================================================================
// Informe del reporte diario para cuantificar cuantos recursos incidieron en cada frente y actividad de frentes.
var condensado_rd = function($scope, $http, $timeout){
  $scope.condensado=[];
  $scope.tabla = undefined;

  $scope.get_condensado = function(lnk, myid){
    console.log(lnk+"/"+myid)
    $http.post(
      lnk+"/"+myid,
      {idreporte_diario: myid}
    ).then(
      function(resp){
        console.log(resp.data);
        $timeout(function(){ $scope.condensado = resp.data; });
      },
      function(resp){ console.log(resp.data); }
    );
  }

  $scope.save_condensado = function(lnk, data, idreporte){
    console.log(lnk)
    $http.post(
      lnk,
      {condensado: data, idreporte_diario: idreporte}
    ).then(
      function(resp){
        if(resp.data.success)
          $timeout(function(){ $scope.condensado = resp.data.condensado; });
        console.log(resp.data)
      },
      function(resp){ console.log(resp.data); }
    );
  }

  $scope.validar_cantidad_frente = function(prop, search, lista, item){
    sum = 0;
    acum = 0;
    angular.forEach(lista, function(v,k){
      if(v[prop] == search && v.valor == item.valor){
        sum = v.total;
        acum += v.cantidad_asociada;
      }
    });
    $timeout(function(){
      if(sum < acum){ item.alerta = true; }else{ item.alerta = false; }
    });
  }
}

// ================================================================================
// frentes
var frentes = function($scope, $http, $timeout){
  $scope.frentes_dupe = [];
  $scope.duplicar_frente = false;

  $scope.getFrentes = function(lnk, idot, idfrente){
    $http.post( lnk+"/"+idot+"/"+idfrente, {} )
      .then(
        function(resp){
          if(resp.data.success){
            $scope.frentes_dupe = resp.data.reportes;
             $scope.duplicar_frente = true;
          }
          console.log(resp.data)
        },
        function(resp){
          alert("error");
          console.log(resp.data);
        }
      );
  }

  $scope.get_recursos_frente = function(lnk, idot, idfrente, idreporte_dupe){
    $http.post( lnk+"/"+idot+"/"+idfrente+"/"+idreporte_dupe, {})
      .then(
        function(resp){
          if(resp.data.success){
            console.log(resp.data)
            $scope.dupe_frente(resp.data.recursos);
          }
          console.log(resp.data)
        },
        function(resp){
          alert("error");
          console.log(resp.data);
        }
      );
  }
  // -------------------------------------------------------------
  // Procedimiento de duplicado de frentes de un reporte a otro
  $scope.dupe_frente = function(recursos){
    $scope.agregarPersonal(recursos.personal);
    $scope.agregarEquipos(recursos.equipos);
    $scope.agregarActividades(recursos.actividades);
    $scope.agregarMaterial(recursos.material);
    $scope.agregarOtros(recursos.otros);
    $scope.duplicar_frente = false;
  }

  $scope.agregarPersonal = function(personal){
    angular.forEach( personal, function(val, key){
      if(!$scope.existeRegistroFull( ambito.rd.recursos.personal, val, ['identificacion', 'cc']) ){
        val.idrecurso_reporte_diario = undefined;
        val.idreporte_diario = undefined;
        if ( val.idavance_reporte )
          val.idavance_reporte = undefined;
        $scope.$parent.rd.recursos.personal.push(val);
      }
    });
  }
  // Agregar equipos seleccionados al reporte
  $scope.agregarEquipos = function(equipos){
    angular.forEach( equipos, function(val, key){
      if(!$scope.existeRegistro($scope.$parent.rd.recursos.equipos, 'codigo_siesa', val.codigo_siesa) ||
        ($scope.existeRegistro($scope.$parent.rd.recursos.equipos, 'codigo_siesa', val.codigo_siesa) && !$scope.existeRegistro($scope.$parent.rd.recursos.equipos, 'itemc_item', val.itemc_item) )
      ){
        val.idrecurso_reporte_diario = undefined;
        val.idreporte_diario = undefined;
        if ( val.idavance_reporte )
          val.idavance_reporte = undefined;
        $scope.$parent.rd.recursos.equipos.push(val);
      }
    });
  }
  // Agregar actividades seleccionadas al reporte
  $scope.agregarActividades = function(actividades){
    angular.forEach( actividades , function(val, key){
      if( !$scope.$parent.existeRegistro($scope.$parent.rd.recursos.actividades, 'itemc_iditemc', val.itemc_iditemc) ){
        val.idrecurso_reporte_diario = undefined;
        val.idreporte_diario = undefined;
        if ( val.idavance_reporte )
          val.idavance_reporte = undefined;
        $scope.$parent.rd.recursos.actividades.push(val);
      }
    });
  }
  // Agregar equipos seleccionados al reporte
  $scope.agregarMaterial = function(material){
    angular.forEach( material , function(val, key){
      val.idrecurso_reporte_diario = undefined;
      val.idreporte_diario = undefined;
      $scope.$parent.rd.recursos.material.push(val);
    });
  }
  // Agregar equipos seleccionados al reporte
  $scope.agregarOtros = function(otros){
    angular.forEach( otros, function(val, key){
      val.idrecurso_reporte_diario = undefined;
      val.idreporte_diario = undefined;
      if ( val.idavance_reporte )
        val.idavance_reporte = undefined;
      $scope.$parent.rd.recursos.otros.push(val);
    });
  }
  // Fin de duplicado de frente -----------------------------------------
}
