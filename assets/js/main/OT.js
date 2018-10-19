var OT = function($scope, $http, $timeout){

	$scope.enlaceGetOT = '';
	$scope.loader = false;
	$scope.getAjaxWindowLocal = function(lnk, ventana, titulo){
		$scope.enlaceGetOT = '';
		$timeout(function(){
			$scope.enlaceGetOT = lnk;
		});
		$scope.$parent.getAjaxWindowLocal(lnk, ventana, titulo);
	}

	$scope.enlaceResumenOT = '';
	$scope.getResumenGeneral = function(link){
		$timeout(function(){
			$scope.enlaceResumenOT = '';
		})
		$timeout(function(){
			$scope.enlaceResumenOT = link+'/'+Math.floor((Math.random() * 100) + 1);
		});
		/*$.ajax({
			url: link,
			method:'post',
			success: function(data, status, xhr){
				$('#resumenItems').html("<section>"+data+"</section>");
				$scope.toggleContent('#resumenItems', 'nodisplay', '.mypanel > div');
			},
			error: function(){
				console.log(link);
				alert('Ha ocurrido un error')
			}
		});*/
	}

	$scope.getDataITems = function(url, ambito){
		$http.get(url).then(
			function(response) {
				ambito.bases = JSON.parse(response.data.bases);
				ambito.items = JSON.parse(response.data.items);
				ambito.vigencias = JSON.parse(response.data.vigencias);
				ambito.contratos = JSON.parse(response.data.contratos);
				ambito.lista_usuarios = JSON.parse(response.data.usuarios);
			},
			function (response) {
				alert("Algo ha salido mal al cargar esta interfaz, cierra la vista e intenta de nuevo, si el problema persiste comunicate a el area TIC.");
			}
		);
	}
	$scope.getData = function(url, ambito, edit){
		$http.post(url, {}).then(
				function(response){
					ambito.ot = response.data;
					ambito.tr = ambito.ot.tareas[0];
					if(edit){
						ambito.recorrerTareas();
						ambito.obtenerMunicipios(ambito.ot.departamento, $("#depart").data('getmunis'));
					}
					console.log(response.data);
				},
				function(response){		alert('Algo ha salido mal al cargar informacion de la OT');		console.log(response.data);}
			);
	}
	$scope.getIncidencia = function(itv){
		return (itv.incidencia)?itv.incidencia:0;
	}
	$scope.selectTarea = function(ot, ambito, indice){
		ambito.tr = ot.tareas[indice];
		ambito.tr.editable = $scope.toboolean(ambito.tr.editable);
	}
	$scope.setTarea = function(mytr, ambito){
		$timeout(function(){
			ambito.tr = mytr;
		});
	}
	// eliminar un item
	$scope.unset_item = function(lista, item, site_url, tr){
		if(item.iditem_tarea_ot){
			$http.get(site_url+'/ot/del_item_tarea/'+item.iditem_tarea_ot).then(
				function(response){
					if(response.data =="success"){
						console.log('Eliminado con exito de la BD');
						$scope.delete_item(lista, tr, item);
					}else{
						alert('Ha ocurrido un error');
					}
				},
				function(response){
					alert('No hemos podido ralizar la petición al servidor, revisa tu conexión o ponte en contacto con el dpto TIC.');
				}
			)
		}else{
			$scope.delete_item(lista, tr, item);
		}

	}
	$scope.delete_item = function(lista, tr, item){
		var proceder = confirm('¿Esta seguro de eliminar este Item?');
		if(proceder){
			if(lista == tr.personal){
				lista.splice(lista.indexOf(item),1);
				alert('Has modificado personal, debes modificar tambien horas extra y gastos de viaje de la tarea actual de ese item, si los ha calculado previamente');
			}else {
				lista.splice(lista.indexOf(item),1);
			}
		}
	}

	$scope.deleteOT = function(url, id){
		console.log(url+id);
		var proceder = confirm('¿Esta seguro de eliminar esta orden de trabajo?');
		if(proceder){
			$http.get(url+id).then(
				function(response){
					if(response.data == 'success'){
						alert('Borrado exitosamente, recarga la consulta.');
					}else {
						alert('No encontrada')
					}
					console.log(response.data);
				},
				function(response){
					alert('Algo ha fallado');
					console.log(response.data);
				}
			);
		}
	}

	$scope.consola = function(tr){console.log(tr)}
	// ---------------------------------------------------------------------------
	// Add una nueva tarea
	$scope.addTarea = function(ambito){
		var idot = (ambito.ot.idOT != undefined)?ambito.ot.idOT:"";
		var d = new Date();
		ambito.ot.tareas.push(
				{
					"idtarea_ot": "",
					"nombre_tarea": "TAREA "+( (ambito.ot.tareas.length >= 1)?ambito.ot.tareas.length+1:'INICIAL'),
					"valor_recursos": "0",
					"valor_tarea_ot": "0",
					"fecha_inicio": (d.getFullYear()+"-"+(d.getMonth()+1)+"-"+d.getDate()),
					"fecha_fin": (d.getFullYear()+"-"+(d.getMonth()+1)+"-"+d.getDate()),
					"json_indirectos": {
						"administracion": 0,
						"imprevistos": 0,
						"utilidad":0
					},
					"json_recursos": {},
					"json_viaticos": {
						"json_viaticos": [],
						"valor_viaticos": 0,
						"administracion": 0
					},
					"json_horas_extra": {
						"json_horas_extra": [],
						"valor_horas_extra": 0,
						"raciones_cantidad": 0,
						"raciones_valor_und": 0,
						"administracion": 0
					},
					"json_reembolsables": {
						"json_reembolsables": [],
						"valor_reembolsables": 0,
						"administracion": 0
					},
					"editable":true,
					"json_raciones": null,
					"estado_tarea_ot": "",
					"OT_idOT": idot,
					"actividades": [],
					"personal": [],
					"equipos": [],
					'material':[],
					'otros':[],
					'subcontratos':[],
					"responsables":{},
					"requisitos_documentales":{}
				}
			);
		ambito.tr = ambito.ot.tareas[ambito.ot.tareas.length];
		var i = ambito.ot.tareas.length;
		$scope.setTarea(ambito.ot.tareas[i-1], ambito);
		alert('Has añadido una nueva tarea, selecciona en la lista desplegable para modificar valores');
	}

	$scope.delTarea = function(lnk, tarea, ambito){
		if(ambito.ot.tareas.length <= 1){
			alert("No puedes eliminar la unica tarea.");
			return;
		}
		$procc = confirm('Estas seguro de eliminar esta tarea  de a OT?');
		if($procc && tarea.idtarea_ot){
				$http.post(lnk+tarea.idtarea_ot, {idtarea_ot: tarea.idtarea_ot}).then(
					function(resp){
						if(resp.data.status){
							var i = ambito.ot.tareas.indexOf(tarea);
							ambito.ot.tareas.splice(i,1);
							ambito.tr = ambito.ot.tareas[0];
						}else{
							console.log(resp.data);
							alert('No se ha podido borrar la tarea seleccionada. verfica que no tenga informacion realacionada.');
						}
					},
					function(resp){
						console.log(resp.data);
						alert('No se ha podido borrar la tarea seleccionada. verfica que no tenga informacion realacionada.');	}
				);
		}else if ($procc) {
			ambito.ot.tareas.splice(i,1);
			ambito.tr = ambito.ot.tareas[0];
		}
	}
	//==============================================================================
	// Gestion de items de OT
	// selecciona los items de la OT
	$scope.getItemsVg = function(lnk, ambito){
		$scope.loader = true;
		$http.get(lnk).then(
			function(resp){
				ambito.items = resp.data.items;
				ambito.tr.a = ambito.tr.a?ambito.tr.a:resp.data.a; // Asignación de AIU correcto.
				ambito.tr.i = ambito.tr.i?ambito.tr.i:resp.data.i; // Asignación de AIU correcto.
				ambito.tr.u = ambito.tr.u?ambito.tr.u:resp.data.u; // Asignación de AIU correcto.
				$scope.loader = false;
			},
			function(resp){
				alert('algo ha fallado');
				console.log(resp.data);
				$scope.loader = false;
			}
		);
	}
	//Muestra items por agregar de un tipo en la ventana. Debe llamarse desde un controller hijo.
	$scope.selectItemsType =  function(type, ambito){
		try {
			console.log(type);
			console.log(ambito.items);
			ambito.myItems = angular.copy(ambito.items[type]);
		} catch (e) {
			ambito.myItems = [];
			console.log(e)
		}
	}
	//Muestra la ventana para add items. Debe llamarse desde un controller hijo.
	$scope.VwITems = function(tipo, ambito){
		$scope.loader = true;
		$timeout(function(){
			$scope.selectItemsType(tipo, ambito);
		});
		$("#ventana_add_items").removeClass('nodisplay');
		$scope.loader = false;
	}
	$scope.setSelecteState = function(add){
		if(!add){
			add = true;
		}else{
			add = false;
		}
	}
	$scope.addSelectedItems = function(ambito,tr){
		var size = ambito.myItems.length;
		var i = 0;
		ambito.filtro = [];
		angular.forEach(ambito.myItems, function(v,k){
			i++;
			ambito.indexer++;
			if (v.add == true) {
				console.log(v);
				v.id = ambito.indexer;
				v.fecha_agregado = '';
				v.cantidad = v.cantidad==undefined?1:v.cantidad;
				v.duracion = v.duracion==undefined?1:v.duracion;
				v.facturable = true;
				v.idsector_item_tarea = '1';
				if (v.tipo == 1){
					tr.actividades.push(v);
				}else if(v.tipo == 2) {
					tr.personal.push(v);
					//generar listado de items de personal para calc. gastos de viaje.
					tr.json_viaticos.json_viaticos.push(v);
					tr.json_horas_extra.json_horas_extra.push(v);
				}else if(v.tipo == 3){
					tr.equipos.push(v);
				}else if (v.tipo == 'material') {
					if (!tr.material)
						tr.material = [];
					tr.material.push(v);
				}else if(v.tipo == 'otros'){
					if (!tr.otros)
						tr.otros = [];
					tr.otros.push(v);
				}else if(v.tipo == 'subcontrato'){
					if (!tr.subcontratos)
						tr.subcontratos = [];
					tr.subcontratos.push(v);
				}
			};
			if (i == size){
				ambito.myItems = [];
			}
		});
		$scope.calcularSubtotales(ambito, ambito.tr);
		$("#ventana_add_items").addClass('nodisplay');
	}
	$scope.changeFilterSelect = function(fil){
		if(fil.add == undefined){
			fil.add = true;
		}else if (fil.add == true) {
			fil.add = undefined;
		};
	}
	$scope.calcularSubtotales = function(ambito, tr){
		if( tr == undefined) {
		}else{
			var suma = 0;
			tr.valor_recursos = 0;
			tr.actsubtotal = ambito.recorrerSubtotales(tr.actividades);
			tr.persubtotal = ambito.recorrerSubtotales(tr.personal);
			tr.eqsubtotal = ambito.recorrerSubtotales(tr.equipos);
			suma = (tr.actsubtotal*1.00+tr.persubtotal*1.00+tr.eqsubtotal*1.00);
			if(tr.material){
				tr.msubtotal = ambito.recorrerSubtotales(tr.material);
				suma += tr.material*1.00;
			}
			if (tr.otros){
				tr.otrsubtotal = ambito.recorrerSubtotales(tr.otros);
				suma += tr.otros*1.00;
			}
			if(tr.subcontratos){
				tr.subactsubtotal = ambito.recorrerSubtotales(tr.subcontratos);
				suma += tr.subactsubtotal*1.00;
			}
			//Redondeado de totales
			tr.valor_recursos = suma;
			tr.json_indirectos.administracion = Math.round(tr.valor_recursos * tr.a);//desde el contrato
			tr.json_indirectos.imprevistos = Math.round(tr.valor_recursos * tr.i);//desde el contrato
			tr.json_indirectos.utilidad = Math.round(tr.valor_recursos * tr.u);//desde el contrato
		}
	}
	$scope.calcularAIU = function(tr){
		if( tr == undefined) {
			return;
		}else{
			tr.json_indirectos.administracion = Math.round(tr.valor_recursos * tr.a);//desde el contrato
			tr.json_indirectos.imprevistos = Math.round(tr.valor_recursos * tr.i);//desde el contrato
			tr.json_indirectos.utilidad = Math.round(tr.valor_recursos * tr.u);//desde el contrato
		}
	}
	$scope.setTareaAdministracion = function(value, tr){
		if(tr == undefined){ return 0;}
		tr.json_indirectos.administracion = value;
		return value;
	}
	$scope.setTareaImprevistos = function(value, tr){
		if(tr == undefined){ return 0;}
		tr.json_indirectos.imprevistos = value;
		return value;
	}
	$scope.setTareaUtilidad = function(value, tr){
		if(tr == undefined){ return 0;}
		tr.json_indirectos.utilidad = value;
		return value;
	}
	$scope.recorrerSubtotales = function(listado){
		var valor = 0;
		angular.forEach(listado, function(v, k){
			if(v.facturable){
				if(v.tipo == 'subcontrato'){
					valor += v.subtarifa * (v.cantidad * v.duracion);
				}else{
					valor += v.tarifa * (v.cantidad * v.duracion);
				}
			}
		});
		console.log(valor)
		return valor;
	}
	//====================================================================================
	// Viaticos
	$scope.setViaticos = function(tag, tr, ambito){
		$(tag).removeClass("nodisplay");
		ambito.itemsViaticos = tr.json_viaticos.json_viaticos;
	}
	$scope.applyViatico = function(itv, url){
		$http.get(url+"/"+itv.destino)
			.then(
				function(response){
					console.log(response.data);
					datos = response.data;
					itv.incidencia = $scope.getIncidencia(itv);
					itv.cantidad_gv = 1;
					itv.duracion_gv = 1;
					itv.alojamiento = parseFloat(datos.alojamiento);
					itv.transporte = parseFloat(datos.transporte);
					itv.alimentacion = parseFloat(datos.alimentacion);
					itv.miscelanios = parseFloat(datos.miscelanios);
					itv.total_item = ( itv.alojamiento +  itv.transporte +  itv.alimentacion +  itv.miscelanios) * ( itv.cantidad_gv *  itv.duracion_gv) * $scope.strtonum( itv.incidencia);
				},
				function(response){
					alert(JSON.stringify(response.data))
				}
			);
	}
	$scope.calcularViaticos =  function(tr, ambito){
		tr.json_viaticos.valor_viaticos = 0;
		angular.forEach(tr.json_viaticos.json_viaticos, function(v,k){
			if (v.destino == '' ||  v.destino == undefined || v.destino == null || v.destino == 'undefined'){
				v.total_item = 0;
				tr.json_viaticos.valor_viaticos += 0;
			}
			else {
				v.total_item = ( v.alojamiento +  v.transporte +  v.alimentacion +  v.miscelanios) * ( v.cantidad_gv *  v.duracion_gv) * $scope.strtonum( v.incidencia);
				tr.json_viaticos.valor_viaticos += $scope.strtonum(v.total_item);
			}
		});
		if ( tr.json_viaticos.json_viaticos == undefined || tr.json_viaticos.json_viaticos.length == 0 ) {
			tr.json_viaticos.valor_viaticos = 0;
		}
		tr.json_viaticos.valor_viaticos = Math.round( tr.json_viaticos.valor_viaticos );
		tr.json_viaticos.administracion = Math.round( ( tr.json_viaticos.valor_viaticos* ( 4.58 /100) ) );//desde el contrato
		$("#addViaticosOT").addClass('nodisplay');
	}
	$scope.reiniciarViaticos = function(tr){
		tr.json_viaticos.json_viaticos = angular.copy(tr.personal)
		tr.json_viaticos.administracion = 0;
	}
	//===================================================================================================================
	// Reembolsables
	$scope.setReembolsables = function(tag, tr){
		$(tag).toggleClass('nodisplay');
	}
	$scope.calcularReembolsables = function(tr, ambito){
		tr.json_reembolsables.valor_reembolsables = 0;
		tr.json_reembolsables.administracion = 0;
		angular.forEach(tr.json_reembolsables.json_reembolsables, function(v, k){
			tr.json_reembolsables.valor_reembolsables +=(v.cantidad * v.valor_und);
			tr.json_reembolsables.valor_reembolsables = Math.round(tr.json_reembolsables.valor_reembolsables);
			tr.json_reembolsables.administracion += tr.json_reembolsables.valor_reembolsables * 0.01;//desde el contrato
			tr.json_reembolsables.administracion = Math.round( tr.json_reembolsables.administracion );
		});
	}
	$scope.endReembolsables = function(tag, tr, ambito){
		$(tag).toggleClass('nodisplay');
		$scope.calcularReembolsables(tr, ambito);
	}
	$scope.addReemb = function(ambito, tr){
		tr.json_reembolsables.json_reembolsables.push(
			{
				descripcion:ambito.reemb.descripcion,
				unidad: ambito.reemb.unidad,
				cantidad: ambito.reemb.cantidad,
				valor_und: ambito.reemb.valor_und
			}
		);
		ambito.reemb.descripcion='';
		ambito.reemb.unidad ='';
		ambito.reemb.cantidad = 0;
		ambito.reemb.valor_und = 0;
	}
	//===================================================================================================================
	// horas extra
	$scope.setHorasExtra = function(tag , tr, ambito){
		//console.log(tr.horas_extra);
		ambito.horas_extra = tr.json_horas_extra.json_horas_extra;
		$(tag).toggleClass('nodisplay');
	}
	$scope.calcularTotalItem = function(item) {
		item.total = (item.total_hed);
		item.total += (item.total_hen);
		item.total += (item.total_hefd);
		item.total += (item.total_hefn);
		item.total += (item.total_hfr);
		item.incidencia = $scope.getIncidencia(item);
		item.total = Math.round( (item.total * $scope.getIncidencia(item) ) * item.cantidad_he );
	}
	$scope.subtotal_he = function(item, base, porcentaje, cantidad, tipo){
		//cantidad = $scope.strtonum(cantidad);
		if (tipo == 'hed') {
			item.total_hed = (base*porcentaje)*cantidad;
		}else if (tipo=='hen') {
			item.total_hen = (base*porcentaje)*cantidad;
		}else if (tipo=='hefd') {
			item.total_hefd = (base*porcentaje)*cantidad;
		}else if (tipo == 'hefn') {
			item.total_hefn = (base*porcentaje)*cantidad;
		}else if(tipo == 'hfr'){
			item.total_hfr = (base*porcentaje)*cantidad;
		}
		$scope.calcularTotalItem(item);
	}
	$scope.calcularHorasExtra = function(tr, ambito){
		val = 0;
		angular.forEach(tr.json_horas_extra.json_horas_extra, function(v,k){
			val += v.total;
			tr.json_horas_extra.valor_horas_extra = Math.round(val);
			tr.json_horas_extra.administracion = Math.round( (tr.json_horas_extra.valor_horas_extra + (tr.json_horas_extra.raciones_cantidad * tr.json_horas_extra.raciones_valor_und)) * 0.0458 );//desde el contrato
		});
	}
	$scope.endHorasExtra = function(tag, tr, ambito){
		$scope.calcularHorasExtra(tr, ambito);
		$(tag).toggleClass('nodisplay');
	}
	$scope.reiniciarHorasExtra = function(tr){
		tr.json_horas_extra.json_horas_extra = angular.copy(tr.personal)
		tr.json_horas_extra.administracion = Math.round( (tr.json_horas_extra.valor_horas_extra + (tr.json_horas_extra.raciones_cantidad * tr.json_horas_extra.raciones_valor_und)) * 0.0458 );//desde el contrato
	}
	/* ----------------------------------------*/

	//Calculos de OT
	$scope.calcularValorOT = function(ambito){
		ambito.ot.valor_ot = 0;
		angular.forEach(ambito.ot.tareas, function(tarea, key){
			$scope.calcularSubtotales(ambito, tarea);

			$scope.calcularHorasExtra(tarea, ambito);
			$scope.calcularReembolsables(tarea, ambito);
			$scope.calcularViaticos(tarea, ambito);

			var he = tarea.json_horas_extra.valor_horas_extra + tarea.json_horas_extra.administracion;
			var rm = tarea.json_horas_extra.raciones_cantidad * tarea.json_horas_extra.raciones_valor_und;
			var gv = tarea.json_viaticos.valor_viaticos + tarea.json_viaticos.administracion;
			var id = tarea.json_indirectos.administracion + tarea.json_indirectos.utilidad + tarea.json_indirectos.imprevistos;
			var tar = tarea.valor_recursos;
			tarea.valor_tarea_ot = (he + rm + gv + id + tar);
			ambito.ot.valor_ot += tarea.valor_tarea_ot;
			//console.log('>> Valor OT: '+ambito.ot.valor_ot);
		});
		//console.log(ambito.ot.tareas);
	}
	$scope.recalcularOT = function(ambito){
		ambito.ot.valor_ot = 0;
		angular.forEach(ambito.ot.tareas, function(tarea, key){
			var he = tarea.json_horas_extra.valor_horas_extra + tarea.json_horas_extra.administracion;
			var rm = tarea.json_horas_extra.raciones_cantidad * tarea.json_horas_extra.raciones_valor_und;
			var gv = tarea.json_viaticos.valor_viaticos + tarea.json_viaticos.administracion;
			$scope.calcularAIU(tarea);
			var id = tarea.json_indirectos.administracion + tarea.json_indirectos.utilidad + tarea.json_indirectos.imprevistos;
			var tar = tarea.valor_recursos;
			tarea.valor_tarea_ot = (he + rm + gv + id + tar);
			ambito.ot.valor_ot += tarea.valor_tarea_ot;
		});
	}
	//Vendors
	$scope.tinyMCE = function(){
		tinymce.init({
  			selector: "textarea"
  		});
	}
	$scope.strtonum = function(model){
		if(model == undefined || model == ''){
			model == 0;
		}
		return parseFloat(model);
	}
	$scope.toboolean = function(it){
		if(it == undefined || it == '0'){
			it = false;
		}
		return (it == 1 || it == true) ? true: false;
	}
	//--------------------------------------------------------------------------------------
	// Municipios y locaciones
	$scope.obtenerMunicipios = function(depart,url,ambito){
		if(depart != undefined && depart != ''){
			console.log(depart)
			$http.post(url, {departamento: depart}).then(
					function(response){ ambito.munis= response.data; console.log(response.data)	},
					function(response){ alert("Falló comunicación con server");	}
				);
		}
	}
	$scope.obtenerVeredas = function(municip,url, ambito){
		$http.post(url, {municipio: municip}).then(
				function(response){
					ambito.poblados= response.data;
					ambito.poblado = ambito.poblados[0].idpoblado;
					$scope.getMapa(ambito);
				},
				function(response){	alert("Falló comunicación con server");	}
			);
	}
	$scope.getMapa = function(sc){
		if(sc.ot.idpoblado != ''){
			$.ajax({
				url: baseUrl+"/miscelanio/getMaps/"+sc.ot.idpoblado,
				success: function(data){
					$("#mapa").html(data);
				},
				error: function(){
					alert("error");
				}
			});
		}
	}
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
	// Validar Valores
	$scope.validateValues = function(it){
		it.cantidad_he = $scope.validVal(it.cantidad_he);
		it.cantidad_hed = $scope.validVal(it.cantidad_hed);
		it.cantidad_hen = $scope.validVal(it.cantidad_hen);
		it.cantidad_hefd = $scope.validVal(it.cantidad_hefd);
		it.cantidad_hefn = $scope.validVal(it.cantidad_hefn);
		it.cantidad_hfr = $scope.validVal(it.cantidad_hfr);
		it.total = $scope.validVal(it.total);
	}
	$scope.validVal = function(val){
		return (val==undefined || val=='')?parseInt(0):val;
	}

	$scope.existeOT = function(url,  ambito){
		$http.post(url, { nombre_ot: ambito.ot.nombre_ot } ).then(
			function(response){	alert(response.data);	},
			function(response){ alert(response.data); }
		);
	}
	$scope.unset_elemt = function(lista, item){
		lista.splice(lista.indexOf(item),1);
	}
	$scope.initValidations = function(tr){
		if(tr.responsables== undefined || tr.responsables == '{}' || tr.responsables == ''){
			tr.responsables = {
				"pyco":"",
				"ing_residente":"",
				"gestor_tecnico_ecp":"",
				"cargo_gestor_tecnico":"",
				"registro_gestor_tecnico":"",
				"facturador":"",
			};
		}
		if(tr.requisitos_documentales == undefined || tr.requisitos_documentales  == '{}' || tr.requisitos_documentales  == ''){
			tr.requisitos_documentales  = {
					"OT_firmada": '',
					"OT_SAP_liberada": '',
					"acta_aclaratoria": '',
					"acta_inicio": '',
					"matriz_ram": '',
					"ar": '',
					"memorando_reembolsables": '',
					"cronograma": '',
					"pdt": '',
					"disenos": '',
					"permisos_ambientales": '',
					"socializacion": '',
					"vista_preliminar": '',
			 };
		}
	}
	// ACUMULADOR PARA OBJETOS
	$scope.acumularAObj = function(propiedad, obj, val){
		obj[propiedad] = obj[propiedad]*1+val*1;
		return obj;
	}

	$scope.acumularMeses = function(meses){
		meses.total = meses.enero*1+meses.febrero*1+meses.marzo*1+meses.abril*1+meses.mayo*1+meses.junio*1;
		meses.total += meses.julio*1+meses.agosto*1+meses.septiembre*1+meses.octubre*1+meses.noviembre*1+meses.diciembre*1;
	}

	// --------------------------------------------------------------------------------
	// Frentes de trabajo
	$scope.addFrente = function( lnk, lista, frente ){
		$http.post(
			lnk,
			frente
		).then(
			function(resp){
				if(resp.data.success == 'success'){
					frente = resp.data.frente;
					$scope.$parent.set_el_timeout(lista, frente);
					frente = { nombre : 'frente '+( lista.length + 1 )};
					console.log(resp.data);
				}else{
					alert("Error al recibir respuesta del servidor.");
					console.log(resp.data);
				}
			},
			function(resp){
				alert("Error al crear un frente.")
				console.log(resp.data);
			}
		);
	}

}

// ====================================================================================================
// Listado de OTs
// ====================================================================================================
var listaOT = function($scope, $http, $timeout){
	$scope.linkLista = '';
	$scope.consulta = {};
	$scope.findOTsBy = function(url){
		if($scope.consulta.indicio_nombre_ot || $scope.consulta.base || $scope.consulta.estado){
			$http.post(url, $scope.consulta ).then(
					function(response) {
						$scope.ots = response.data;
					},
					function(response){ console.log(response.data) }
				);
		}else {
			alert('No se han agregado parametros de busqueda')
		}
	}
}
// ====================================================================================================
// FUNCIONES PROPIAS DE AGREGAR UNA OT
// ====================================================================================================
var agregarOT = function($scope, $http, $timeout){
	$scope.ot = {};
	$scope.ot.tareas = [];
	$scope.ot.departamento = '';
	$scope.ot.municipio = '';
	$scope.ot.vereda = '';
	$scope.myItems;
	$scope.items = {};
	$scope.itemsEliminados = [];
	$scope.eqsubtotal=0;
	$scope.actsubtotal=0;
	$scope.persubtotal=0;
	$scope.subactsubtotal=0;
	$scope.reembs=[];
	$scope.viaticos = 0;
	$scope.filtroItems = {};
	$scope.isOnPeticion = false;
	$scope.ot.estado_doc = 'POR EJECUTAR';
	$scope.myestado_doc = 'POR EJECUTAR';
	$scope.ot.allMeses = [ ];
	$scope.ot.frentes = [];
	$scope.tr = {};
	////$scope.$parent.tinyMCE();

	$scope.getFormData = function(url){ $scope.$parent.getDataITems(url, $scope); }
	$scope.getData = function(url){ $scope.$parent.getData(url, $scope, false); }

	$scope.addTarea = function(){$scope.$parent.addTarea($scope);}
	$scope.setTarea = function(mytr){
		$scope.$parent.setTarea(mytr, $scope);
	}
	$scope.delTarea = function(lnk, tarea){
		$scope.$parent.delTarea(lnk, tarea, $scope);
	}

	$scope.unset_item = function(lista, item, site_url){
		$scope.$parent.unset_item(lista, item, site_url, $scope.tr);
		$scope.itemsEliminados.push(item);
		$scope.calcularSubtotales();
	}
	// procesos para items added a la OT
	// Obtener items de una vigencia seleccionada
	$scope.getItemsVg = function(lnk){
		$scope.$parent.getItemsVg(lnk, $scope);
	}
	//items planeación
	$scope.VwITems = function(tipo){
		if($scope.ot.tareas != undefined && $scope.ot.tareas.length > 0){ $scope.$parent.VwITems(tipo, $scope); }
		else{ alert('No se han agregado tareas');}
	}
	$scope.addSelectedItems = function(){
		$scope.$parent.addSelectedItems($scope,$scope.tr); $scope.calcularSubtotales();
	}
	$scope.calcularSubtotales = function(){
		$scope.$parent.calcularSubtotales($scope, $scope.tr);
		$scope.$parent.calcularValorOT($scope);
	}
	//viaticos
	$scope.setViaticos= function(tag, tr){ $scope.$parent.setViaticos(tag, tr, $scope); }
	$scope.calcularViaticos= function(tr){ $scope.$parent.calcularViaticos(tr, $scope); $scope.$parent.calcularValorOT($scope); }
	$scope.recalcularOT = function(){$scope.$parent.recalcularOT( $scope );}
	//reembolsables
	$scope.endReembolsables = function(tag, tr){ $scope.$parent.endReembolsables(tag, tr, $scope); $scope.$parent.calcularValorOT($scope); }
	$scope.addReemb = function(tr){ $scope.$parent.addReemb($scope, tr); }
	//horas extra
	$scope.setHorasExtra = function(tag , tr){ $scope.$parent.setHorasExtra(tag , tr, $scope); }
	$scope.endHorasExtra = function(tag, tr){ $scope.$parent.endHorasExtra(tag, tr, $scope); $scope.$parent.calcularValorOT($scope); }
	//Utils
	$scope.obtenerMunicipios = function(depart,url){	$scope.$parent.obtenerMunicipios(depart,url,$scope);	}
	$scope.obtenerVeredas =function(municip,url){	$scope.$parent.obtenerVeredas(municip,url, $scope);	};
	$scope.getMapa = function(){
		//$scope.$parent.getMapa($scope);
	}
	//===================================================================================================================
	$scope.guardarOT = function(url, lnkConsulta){
		$scope.calcularSubtotales();
		$scope.ot.justificacion = $('#justificacion').val();
		$scope.ot.actividad = $('#actividad').val();
		console.log($scope.ot);
		if($scope.isOnPeticion){
			alert('Ya has presiondo guardar previamente, debes ir a editar para agregar cambios');
		}else if ($scope.ot.nombre_ot == '' || $scope.ot.nombre_ot == undefined
						|| $scope.ot.tipo_ot == undefined || $scope.ot.tipo_ot == ''
						|| $scope.ot.especialidad == undefined || $scope.ot.especialidad == '' || $scope.ot.idcontrato == undefined) {
			alert("No has seleccionado Todos los datos necesarios");
		}else{
			$scope.isOnPeticion = true;
			$http.post(	  url, { ot: $scope.ot, log: $scope.$parent.log }   ).then(
				function(response) {
					if(response.data == 'Orden de trabajo guardada correctamente'){
						alert('Orden de trabajo guardada correctamente, C.O.: '+$scope.ot.base_idbase);
						$timeout(function(){
							$scope.$parent.cerrarWindowLocal('#ventanaOT', $scope.$parent.enlaceGetOT);
							//$scope.$parent.refreshTabs();
							$scope.$parent.findOTsBy(lnkConsulta);
							$scope.isOnPeticion = false;
						});
					}else{
						alert(response.data);
						$scope.isOnPeticion = false;
					}
				},
				function(response) {
					console.log(response.data);
					$scope.isOnPeticion = false;
				}
			);
		}
	}
}
// ====================================================================================================
// FUNCIONES PROPIAS DE EDICION DE OT
// ====================================================================================================
var editarOT = function($scope, $http, $timeout) {
	$scope.ot = {};
	$scope.myItems;
	$scope.items = {};
	$scope.itemsEliminados = [];
	$scope.eqsubtotal=0;
	$scope.actsubtotal=0;
	$scope.persubtotal=0;
	$scope.subactsubtotal=0;
	$scope.reembs=[];
	$scope.viaticos = 0;
	$scope.filtroItems = {};
	$scope.munis = [];
	$scope.isOnPeticion = false;
	$scope.ot.allMeses = [];
	$scope.tr = {};

	$scope.recorrerTareas = function(){
		if ( $scope.ot.estado_doc == undefined || $scope.ot.estado_doc == ''){
			$scope.ot.estado_doc = 'POR EJECUTAR';
		}
		$scope.myestado_doc = $scope.ot.estado_doc;
		angular.forEach($scope.ot.tareas, function(tr, key){
			$scope.$parent.calcularSubtotales($scope, tr);
		});
	}

	$scope.getFormData = function(url){ $scope.$parent.getDataITems(url, $scope);}
	$scope.getData = function(url){	$scope.$parent.getData(url, $scope, true); }

	$scope.addTarea = function(){$scope.$parent.addTarea($scope);}
	$scope.setTarea = function(mytr){
		$scope.$parent.setTarea(mytr, $scope);
	}
	$scope.delTarea = function(lnk, tarea){
		$scope.$parent.delTarea(lnk, tarea, $scope);
	}

	$scope.unset_item = function(lista, item, site_url){
		$scope.$parent.unset_item(lista, item, site_url, $scope.tr);
		$scope.itemsEliminados.push(item);
		$scope.calcularSubtotales();
	}
	// procesos para items added a la OT
	$scope.getItemsVg = function(lnk){
		$scope.$parent.getItemsVg(lnk, $scope);
	}
	//items planeación
	$scope.VwITems = function(tipo){
		if($scope.ot.tareas != undefined && $scope.ot.tareas.length > 0){ $scope.$parent.VwITems(tipo, $scope); }
		else{ alert('No se han agregado tareas');}
	}
	$scope.addSelectedItems = function(){ $scope.$parent.addSelectedItems($scope,$scope.tr); $scope.calcularSubtotales(); }
	$scope.calcularSubtotales = function(){	$scope.$parent.calcularSubtotales($scope, $scope.tr); $scope.$parent.calcularValorOT($scope);}
	$scope.recalcularOT = function(){$scope.$parent.recalcularOT( $scope );}
	//viaticos
	$scope.setViaticos= function(tag, tr){ $scope.$parent.setViaticos(tag, tr, $scope); }
	$scope.calcularViaticos= function(tr){ $scope.$parent.calcularViaticos(tr, $scope); $scope.$parent.calcularValorOT($scope); }
	//reembolsables
	$scope.endReembolsables = function(tag, tr){ $scope.$parent.endReembolsables(tag, tr, $scope); $scope.$parent.calcularValorOT($scope); }
	$scope.addReemb = function(tr){ $scope.$parent.addReemb($scope, tr); }
	//horas extra
	$scope.setHorasExtra = function(tag , tr){ $scope.$parent.setHorasExtra(tag , tr, $scope); }
	$scope.endHorasExtra = function(tag, tr){ $scope.$parent.endHorasExtra(tag, tr, $scope); $scope.$parent.calcularValorOT($scope); }
	$scope.calcularHorasExtra = function(tr){ $scope.$parent.calcularValorOT($scope); }
	$scope.validateValues = function(it){$scope.$parent.validateValues(it);}
	//Utils
	$scope.obtenerMunicipios = function(depart,url){ $scope.$parent.obtenerMunicipios(depart,url,$scope); }
	$scope.obtenerVeredas =function(municip,url){ $scope.$parent.obtenerVeredas(municip, url, $scope); }
	$scope.getMapa = function(){
		//$scope.$parent.getMapa($scope);
	}
	// -------------------------------------------------
	// COPIAR TAREA
	$scope.copiar_tarea = function(tarea_cp){
		var tr = angular.copy(tarea_cp);
		tr.idtarea_ot = undefined;
		tr.idvigencia_tarifas = undefined;
		tr.editable = true;
		tr.nombre_tarea = "TAREA "+($scope.ot.tareas.length+1);
		/*tr.editable = true;*/
		angular.forEach(tr.personal, function(v, k){
			v.iditem_tarea_ot = undefined;
			v.fecha_agregado = undefined;
		});
		angular.forEach(tr.equipos, function(v, k){
			v.iditem_tarea_ot = undefined;
			v.fecha_agregado = undefined;
		});
		angular.forEach(tr.actividades, function(v, k){
			v.iditem_tarea_ot = undefined;
			v.fecha_agregado = undefined;
		});
		$scope.showCopiar = false;
		$scope.ot.tareas.push(tr);
		//$scope.tr = $scope.ot.tareas[$scope.ot.tareas.length];
	}
	$scope.guardarOT = function(url){
		//tinyMCE.triggerSave();
		var ind = $scope.ot.tareas.indexOf($scope.tr);
		if($scope.isOnPeticion){
			alert('Ya se esta ejecutando un proceso de guardado, espera a que muestre su finalización');
		}else {
			$scope.isOnPeticion = true;
			$scope.calcularSubtotales();
			$http.post(	  url, { ot: $scope.ot, log: $scope.$parent.log }   ).then(
				function(response) {
					if(response.data.success == 'Orden de trabajo guardada correctamente'){
						alert(response.data.success);
						console.log(response.data.ot);
						$scope.ot=response.data.ot;
						$scope.tr = $scope.ot.tareas[ind];
						$scope.isOnPeticion = false;
						$scope.$parent.calcularValorOT($scope);
					}else if (response.data == 'La Orden de trabajo ya existe.') {
						alert('No. de Orden de trabajo ya registrado');
						$scope.isOnPeticion = false;
					}else if (response.data == 'Orden de trabajo duplicada y guardada con exito') {
						alert('Orden de trabajo duplicada y guardada con exito');
						$scope.isOnPeticion = false;
					}else{	alert('Algo ha salido mal!'); console.log(response.data); $scope.isOnPeticion = false;	}
				},
				function(response) {
					$scope.isOnPeticion = false;
					console.log(response.data);
				}
			);
		}
	}

	$scope.delete_tarea = function(url, tr){
		if (tr.idtarea_ot == undefined || tr.idtarea_ot == '') {
			$scope.ot.tareas.splice($scope.ot.tareas.indexOf(tr),1);
		}else{
			$http.get(url+'/'+tr.idtarea_ot).then(
				function(response){
					if(response.data == 'success'){
						$scope.ot.tareas.splice($scope.ot.tareas.indexOf(tr),1);
					}
				},
				function(response){}
			);
		}
	}
}
// ====================================================================================================
// FUNCIONES PROPIAS DE COPIADO DE OT
// ====================================================================================================
var duplicarOT = function($scope, $http, $timeout){
	$scope.myot = {
		tareas:[]
	};

	$scope.getDuplicateOT = function(link,data){
		$http.post(link, data)
		.then(
			function(response){
				if(response.data.success != undefined && response.data.success == 'exito'){
					$scope.$parent.ot = response.data.ot;
					$scope.myot.show = false;
				}else{
					alert('Algo ha salido mal');
					console.log(response.data);
				}
			},
			function(response){
			}
		);
	}
}
