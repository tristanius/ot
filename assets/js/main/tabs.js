var app = angular.module("myapp", ['ui.tinymce']);
app.controller("test", function($scope, $sce, $compile, $http, $templateCache, $timeout){
  $scope.site_url = '';
  $scope.estructura = [];
  $scope.myform = '';
  $scope.countertab = 0;
  $scope.tabs = [{ id:$scope.countertab, linkto:"options", titulo:$sce.trustAsHtml("Menu general"), content: '', include:task.url, class: 'active', active: true}];
  $scope.bigHtml = '',
  $scope.estructuras = [];
  $scope.uploader = undefined;
  $scope.showSlideState = true;
  //============================================================================
  //Funcion que carga una vista de pestaña desde un boton de enlace en la vista de inicio
  $scope.clickeableLink = function(myurl, evt, titulo){
    console.log(myurl);
    evt.preventDefault();
    $scope.countertab++;
    $scope.addNewTab($sce.trustAsHtml(titulo+' <small class="grey-text">'+$scope.countertab+'</small>'), myurl, "");
  }
  //funcion (child) que agrega una pestaña al arreglo
  $scope.addNewTab = function(title, link, myContent){
    $scope.tabs.push({ id:$scope.countertab, linkto:"tab"+$scope.countertab, titulo:title, content: '', include:link, class: 'active', active: true});
        angular.forEach($scope.tabs, function($value, $key){
          $timeout(function(){
            if( $value.id != $scope.countertab ) {
              $value.class = '';
              $value.active = false;
            }
          });
        });
  }
  //============================================================================
  //Al dar click sobre una pestaña esta funcion la pone como pestaña activa
  $scope.clickedTab = function(e, tab){
    e.preventDefault();
    angular.forEach($scope.tabs, function($value, $key){
      $value.class = '';
      $value.active = false;
    });
    tab.class = "active";
    tab.active = true;
  }
  //al sar click sobre el boton cerrar pestaña
  $scope.closeTab = function(tab, e){
    e.preventDefault();
    var i = $scope.tabs.indexOf(tab);
    angular.forEach($scope.tabs, function(val, key){
      if(val == tab){
        if($scope.tabs.length <= 1){
          $scope.tabs[0].class="active";
          $scope.tabs[0].active=true;
        }else if($scope.tabs[i].class){
          $scope.tabs[i-1].class="active";
          $scope.tabs[i-1].active=true;
        }
        $scope.tabs.splice(i,1);
        $timeout(function () {
          $templateCache.removeAll();
        });
      }
    });
  }
  //Refrecar las pestañas
  $scope.refreshTabs = function(){
    angular.forEach($scope.tabs,
      function(value, key){
        var link = value.include;
        $scope.$apply(function(){
          if (value.active) {
            value.include = "";
            $templateCache.removeAll();
          }
        });
        value.include = link;
      }
    );
  }
  //============================================================================
  //carga una archivo JSON desde un init para que se genere una vista
  $scope.loadViewJSON = function(route, idtab){
    $.ajax({
      url: route,
      method:"get",
      dataType:'html',
      success: function(data){
        $timeout(function(){
          $scope.estructuraActual = JSON.parse(data);
          console.log($scope.estructuraActual);
        });
      },
      error: function(xhr, data){
        console.log("Error: "+JSON.stringify(data));
      }
    });
  }
  $scope.estActualContent = function(i){
    angular.forEach($scope.estructuraActual, function(v,k){
      v.class=''
    });
    i.class = 'active';
    $scope.estructuraActualContent = i;
  }
  //============================================================================
  // EFECTOS VISUALES DE LA VISTA
  $scope.getFromMenu = function(target, slide){
    $('.opciones-area > div').hide();
    $(target).show(100);
    $scope.slideOtp(slide);
  }
  $scope.slideOtp = function(id){
    $(id).toggle("fast");
    $scope.changeSlideState();
  }
  $scope.changeSlideState = function(){
    if($scope.showSlideState){
      $scope.showSlideState = false;
    }else{
      $scope.showSlideState = true;
    }
  }
  $scope.imprimir = function(text){console.log(text);}
  //============================================================================
  // validaciones de permisos
  $scope.validGestion = function(gestion){
	  var val = false;
	  angular.forEach($scope.log.gestiones, function(v,k){
		  if(v == gestion){
			  val = true;
		  }
	  });
	  return val;
  }
  $scope.validPriv = function(privilegio){
	  var val = false;
	  angular.forEach($scope.log.privilegios, function(v,k){
		if(v == privilegio){
			val = true;
		}
	  });
	  return val;
  }
  //============================================================================
  // VENTANA EMERGENTE PARA AGREGAR
  $scope.getAjaxWindow = function(mylink, e, par1) {
    e.preventDefault();
    $scope.form = mylink;
    console.log(mylink);
    $("#VentanaContainer").removeClass("nodisplay");
    $('body, html').animate({
  			scrollTop: '0px'
  		}, 500
    );
  }
  $scope.getAjaxWindow2 = function(mylink, e, data) {
    e.preventDefault();
    $templateCache.removeAll();
    $scope.form = mylink;
    console.log(mylink);
    $("#VentanaContainer").removeClass("nodisplay");
    $('body, html').animate({
    		scrollTop: '0px'
    	}, 500
    );
  }

  $scope.getAjaxWindowLocal = function( mylink, ventana, btnMostrar ) {
    $(ventana).removeClass("nodisplay");
    $('body, html').animate({
			   scrollTop: '0px'
		  }, 500
    );
  }

  $scope.getAjaxWindowPOST = function(link, mydata, idTag){
    $.ajax({
      url: link,
      data: mydata,
      method: "POST",
      success: function(result){
        $(idTag).html(result);
      },
      error:function(xhr, txtStatus){
        alert(xhr, txtStatus)
      }
    });
  }

  $scope.switchTagClass = function(tag, clase){
    $(tag).toggleClass(clase);
  }

  $scope.cerrarWindow = function(){
    $scope.form = '';
    //$("#VentanaContainer").empty();
    $scope.estructuraActual = [];
    $scope.estructuraActualContent =[];
    $("#VentanaContainer").addClass('nodisplay');
  }

  $scope.cerrarWindowLocal = function(ventana, form){
    form = 'https://google.com';
    $(ventana).addClass('nodisplay');
  }

  $scope.toggleWindow = function(){
    $("#VentanaContainer").toggleClass('nodisplay');
    $("#WindowOculta").toggleClass('nodisplay');
  }
  $scope.toggleWindow2 = function(ventana, btnMostrar){
    $(ventana).toggleClass('nodisplay');
    $(btnMostrar).toggleClass('nodisplay');
  }
  $scope.setTextarea = function(tag, content){
    $(tag).html(content);
  }
  $scope.datepicker_init = function(){
    $('.datepicker').datepicker(
    {
      monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
      monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
      dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
      dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
      dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
      dateFormat: 'yy-mm-dd',
      changeMonth: true,
      changeYear: true
    });
  }

  $scope.delAddFromList = function(lista, item){
    valid = true;
    angular.forEach(lista, function(v,k){
      if(v == item){
        lista.splice( lista.indexOf(item), 1 );
        valid = false;
      }
    });
    if (valid) {
      lista.push(item);
    }
  }

  $scope.hashRandom = function(){
    return Math.floor( ( Math.random() * 10 ) + 1 )
  }

  $scope.getLogMovimientos = function(link, myidreg, mytabla){
    $http.post(
      link, {idregistro: myidreg, tabla: mytabla}
    ).then(
      function(response){
        $('#dialogPanel article').html(response.data);
        $('#dialogPanel').toggleClass('nodisplay');
      },
      function(response){
        alert(response.data);
      }
    )
  }

  $scope.addLog = function(mytabla, myidregistro, mydescripcion, nota=''){
    $http.post(
      $scope.site_url+'/miscelanio/addLog',
      {tabla:mytabla, idregistro: myidregistro, descripcion: mydescripcion, log: $scope.log, referencia:nota}
    ).then(
      function(response){
        console.log(response.data);
      },
      function(response){console.log(response.data);}
    );
  }

	$scope.setValorProp = function(valor, obj, prop){
		obj[prop] = valor;
	}

  $scope.findObjByProp = function(find, prop, list){
    var ret = undefined;
    angular.forEach(list, function(v,k){
      if (v[prop] == find) {
        console.log('ok-')
        ret =  v;
      }
    });
    return ret;
  }

  $scope.dialog = function(msj){
    alert(msj);
    console.log(msj)
  }

  $scope.parseJSON = function(string){
    return JSON.parse(string);
  }

  // funcion general para odd / even TABLAS
  $scope.isOdd = function(valor, odd){
    return (odd!=valor)? true: false;
  }
  $scope.rowOdd = function(b, rowColor){
    if(b && rowColor=='odd'){
        return '';
    }else if (b && rowColor=='') {
      return 'odd';
    }
    return rowColor;
  }

  // inserta un elemento a una lista con la funcion timeout para refrescar la pagina
  $scope.set_el_timeout = function(list, obj){
    $timeout(function(){
      list.push(obj);
    });
  }


});

app.controller('OT', function($scope, $http, $timeout){ OT($scope, $http, $timeout); });
app.controller('agregarOT', function($scope, $http, $timeout){
  agregarOT($scope, $http, $timeout);
});
app.controller('listaOT', function($scope, $http, $timeout){
  listaOT($scope, $http, $timeout);
});
app.controller('editarOT', function($scope, $http, $timeout){
  editarOT($scope, $http, $timeout);
});

app.controller('duplicarOT', function($scope, $http, $timeout){
  duplicarOT($scope, $http, $timeout);
});

app.controller('reportes', function($scope, $http, $timeout){
  reportes($scope, $http, $timeout);
});
app.controller('calendar', function($scope, $http, $timeout){
  calendar($scope, $http, $timeout);
});
app.controller('listOTReportes', function($scope, $http, $timeout){
  listOTReportes($scope, $http, $timeout);
});
app.controller('addReporte', function($scope, $http, $timeout){
  addReporte($scope, $http, $timeout);
});
app.controller('editReporte', function($scope, $http, $timeout){
  editReporte($scope, $http, $timeout);
});
app.controller('personalUp', function($scope, $http, $timeout){
  personalUp($scope, $http, $timeout);
});
app.controller('lista_personal', function($scope, $http, $timeout){
  lista_personal($scope, $http, $timeout);
});
app.controller('lista_equipos', function($scope, $http, $timeout){
  lista_equipos($scope, $http, $timeout);
});
app.controller('equipoUP', function($scope, $http, $timeout){
  equipoUP($scope, $http, $timeout);
});

app.controller('recursosOT', function($scope, $http, $timeout){
  recursosOT($scope, $http, $timeout);
});

app.controller("addTarifa",function($scope, $http, $timeout){
  addTarifa($scope, $http, $timeout);
});

app.controller("consulta",function($scope, $http, $timeout){
  consulta($scope, $http, $timeout);
});

app.controller("vistaCantidadesMesRD",function($scope, $http, $timeout){
  vistaCantidadesMesRD($scope, $http, $timeout);
});

app.controller("consulta_nom",function($scope, $http, $timeout){
  consulta_nom($scope, $http, $timeout);
});

app.controller("migracion_recursos",function($scope, $http, $timeout){
  migracion_recursos($scope, $http, $timeout);
});

app.controller("factura",function($scope, $http, $timeout){
  factura($scope, $http, $timeout);
});

app.controller("formFactura",function($scope, $http, $timeout){
  formFactura($scope, $http, $timeout);
});

app.controller("imprimirRD", function($scope, $http, $timeout){
  imprimirRD($scope, $http, $timeout);
});

app.controller("historico_fact", function($scope, $http, $timeout){
  historico_fact($scope, $http, $timeout);
});
app.controller("condensado_rd", function($scope, $http, $timeout){
  condensado_rd($scope, $http, $timeout);
});
app.controller("frentes", function($scope, $http, $timeout){
  frentes($scope, $http, $timeout);
});


//let's make a startFrom filter
app.filter('startFrom', function() {
  return function(input, start) {
    start = +start; //parse to int
    return input.slice(start);
  }
});
