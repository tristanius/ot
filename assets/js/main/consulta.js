var consulta = function($scope, $http, $timeout){
	$scope.consulta = {
		bases: [],
		year:undefined,
		mes: undefined,
	};
	$scope.ots = [];
	$scope.getConsulta = function(link, arg){
		console.log(arg);
		$http.post(
			link, arg
		).then(
			function(response){
				console.log(response.data);
				$scope.current_consulta = angular.copy($scope.consulta);
				console.log($scope.current_consulta);
				$scope.ots = response.data;
			},
			function(response){
				console.log(response.data)
			}
		);
	}

	$scope.delAddFromList = function(list, item){
		valid = true;
		angular.forEach(list, function(v,k){
			if(v == item){
				list.splice( list.indexOf(item), 1 );
				valid = false;
			}
		});
		if (valid) {
			list.push(item);
		}
	}

	$scope.initBoolean = function(bool){
		if (bool == undefined || bool == 0) { bool = false;}
		else if (bool == 1) { bool = true; }
		return bool;
	}

	$scope.toggleBoolean = function(bool){
		if (bool == undefined || bool == '' || bool == 0) { bool = false;}
		return bool?false:true;
	}


	/// Utilidades del controller
	$scope.getCabeceras = function(list){
		var cabeceras = [];
		angular.forEach(list, function(v,k){
			if (k != "$$hashKey") {
				cabeceras.push(k);
			}
		});
		return cabeceras;
	}
}
//===============================================================================
// Consulta de cantidades
var vistaCantidadesMesRD = function($scope, $http, $timeout){
	$scope.infoCantidadesRd = undefined;

	$scope.verCantidadesDia = function(link, myot){
		if (myot.show) {
			myot.show = $scope.mostrarResultado(myot.show);
		} else {
			$scope.current_consulta.idOT = myot.idOT;
			$http.post(link, $scope.current_consulta)
			.then(
				function(response){
					console.log(response.data);
					myot.infoCantidadesRd = response.data;
					myot.show = $scope.mostrarResultado(myot.show);
				},
				function(response){
					console.log(response.data);
				}
			);
		}
	}

	$scope.mostrarResultado = function(elemento){
		if(elemento == undefined){elemento = false;}
		return elemento?false:true;
	}

	$scope.validarCeldaNum = function(n, row){
		if (!isNaN(n)) { return (row.cant_max_dia < n)?'font-weight: bold; color: red':'';	}
		return '';
	}

	$scope.getStyleByHeader = function(header){
		if(header == 'descripcion'){
			return {'min-width':'100px'}
		}
	}
}

var consulta_nom = function($scope, $http, $timeout){
	
}
