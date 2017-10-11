<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utp-8" />
		<style>
			body{
				font-family:Arial;
			}
			th,td{
			    font-size: 9px;
			    min-height: 25px;
				 height:20px;
			}
			tr{
				height:20px;
			}
			table, th, td {
			    border-collapse: collapse;
			}
			.sinborde{
			    border: 0px solid black;
			}
			table {
				width: 100%;
				table-layout: fixed;
			}

			tfoot td{
				border: 0px solid black;
			}

			#centrar {
			  text-align: center;
			}

			.trLimpia{
				border: 0px solid black;
				height:10px;
			}

			.thCentro {
			  text-align: center;
			}
			.f12{
			  font-size: 12px;
			}
			.f16{
			  font-size: 16px;
			}
		</style>
	</head>
	<body>
		<table border="1">
		  	<thead>
				<tr>
					<th rowspan="3" colspan="6"></th>
					<th colspan="29" class="f16">REPORTE DIARIO OT</th>
				</tr>
				<tr>
					<th colspan="29" class="f16">&nbsp;</th>
				</tr>
				<tr>
					<th colspan="2">CODIGO</th>
					<th colspan="6">P135-PYC-ADM-16-13-007</th>
					<th>&nbsp;</th>
					<th colspan="15">version: 1.0</th>
					<th colspan="2">Hoja</th>
					<th>&nbsp;</th>
					<th>de</th>
					<th>&nbsp;</th>
				</tr>
				<tr>
					<th colspan="4">FECHA:</th><th colspan="10"></th>
					<th>&nbsp;</th>
					<th colspan="4">FESTIVO:</th><th colspan="7"></th>
					<th>&nbsp;</th>
					<th colspan="2">ESPECIALIDAD:</th><th colspan="6"></th>
				</tr>
				<tr>
					<th colspan="4">No. OT SAP:</th><th colspan="10"></th>
					<th>&nbsp;</th>
					<th colspan="4"></th><th colspan="7"></th>
					<th>&nbsp;</th>
					<th colspan="2">BASE:</th><th colspan="6"></th>
				</tr>

				<tr>
					<th colspan="4">LUGAR DE LOS TRABAJOS :</th><th colspan="10">&nbsp;</th>
					<th>&nbsp;</th>
					<th colspan="4">COORDENADA:</th><th colspan="7"></th>
					<th>&nbsp;</th>
					<th colspan="2">TIPO DE MTTO:</th><th colspan="6"></th>
				</tr>
				<tr class="trLimpia"></tr>
				<tr>
					<th colspan="35">DATOS DEL PERSONAL, HORARIO TRABAJADO, RACIONES Y VIATICOS</th>
				</tr>
				<tr>
					<th colspan="2" rowspan="2">CODIGO</th>
					<th colspan="1" rowspan="2">C�DULA</th>
					<th colspan="6" rowspan="2">NOMBRE</th>
					<th colspan="3" rowspan="2">CARGO</th>
					<th colspan="1" rowspan="2">BASE</th>
					<th colspan="2">Personal</th>
					<th colspan="4" >REPORTE DE TIEMPO LABORADO</th>
					<th colspan="1" rowspan="2">THA (S/N)</th>
					<th colspan="1" rowspan="2">RACI�N</th>
					<th colspan="5">VIATICOS</th>
					<th colspan="1" rowspan="2">&nbsp;</th>
					<th colspan="8" rowspan="2">FIRMA DEL TRABAJADOR</th>
				</tr>
				<tr>
					<th>Bas.</th>
					<th>Var.</th>
					<th colspan="2">H. INICIO</th>
					<th colspan="2">H. FINAL</th>
					<th>RETORNO</th>
					<th>PLENO</th>
					<th colspan="3">LUGAR</th>
				</tr>
		  	</thead>
		  	<tbody>
			<script>
			for (i = 0; i < 16; i++) {
			    document.write("<tr><td colspan='2'></td><td colspan='1'></td><td colspan='6'></td><td colspan='3'></td><td colspan='1'></td><td></td><td></td><td colspan='2'></td>				<td colspan='2'></td><td colspan='1'></td><td colspan='1'></td><td></td>	<td></td>	<td colspan='3'></td><td colspan='1'>&nbsp;</td><td colspan='8'></td></tr>	");
			}
			</script>
		 	</tbody>
				<tfoot>
				<tr>
					<td colspan="3">Bas: B�sico</td>
					<td colspan="1"></td>
					<td colspan="6">I: Incapacidad </td>
					<td colspan="3">HI: Hora de inicio</td>
					<td colspan="8">THA (S/N): Tomo Hora de Almuerzo (SI/NO)</td>
					<td colspan="14"></td>
				</tr>
				<tr>
					<td colspan="3">Var: Variable</td>
					<td colspan="1"></td>
					<td colspan="6">ACCP: Ausente con permiso con pago</td>
					<td colspan="3">HF: Hora final</td>
					<td colspan="8"></td>
					<td colspan="14"></td>
				</tr>
				</tfoot>
		</table>

		<table border="1">
			<thead>
				<tr class="trLimpia"></tr>
				<tr>
					<th colspan="19">EQUIPO</th>
					<th colspan="16">ACTIVIDAD DE MANTENIMIENTO</th>
				</tr>
				<tr>
					<th colspan="2">CODIGO</th>
					<th colspan="6">DESCRIPCION</th>
					<th colspan="1">BAS.</th>
					<th colspan="1">VAR.</th>
					<th colspan="1">BASE</th>
					<th colspan="1">UND.</th>
					<th colspan="1">CANT.</th>
					<th colspan="2">ESTADO</th>
					<th colspan="2">PLACA</th>
					<th colspan="2">No. HORAS</th>
					<th colspan="2">CODIGO</th>
					<th colspan="8">ACTIVIDAD DE MANTENIMIENTO</th>
					<th colspan="2">UNIDAD</th>
					<th colspan="2">CANT.</th>
					<th colspan="2">ACUM.</th>
				</tr>
			</thead>
			<tbody>
				<script>
				for (i = 0; i < 13; i++) {
				    document.write("<tr><td colspan='2'></td><td colspan='6'></td><td colspan='1'></td><td colspan='1'></td><td colspan='1'></td><td colspan='1'></td><td colspan='1'></td><td colspan='2'></td><td colspan='2'></td><td colspan='2'></td><td colspan='2'></td><td colspan='8'></td><td colspan='2'></td><td colspan='2'></td><td colspan='2'></td></tr>");
				}
				</script>
			</tbody>
		</table>

		<br>


		<table border="1">
			<thead>
				<tr>
					<th rowspan="3" colspan="7"></th>
					<th colspan="29" class="f16">REPORTE DIARIO OT</th>
				</tr>
				<tr>
					<th colspan="29">&nbsp;</th>
				</tr>
				<tr>
					<th colspan="2">CODIGO</th>
					<th colspan="6">P135-PYC-ADM-16-13-007</th>
					<th>&nbsp;</th>
					<th colspan="15">version: 1.0</th>
					<th colspan="2">Hoja</th>
					<th>&nbsp;</th>
					<th>de</th>
					<th>&nbsp;</th>
				</tr>
				<tr class="trLimpia"></tr>
			</thead>
			<tbody>
				<tr>
					<td colspan="4" id="centrar"><b>No. O.T.PMA:</b></td>
					<td colspan="2"></td>
					<td colspan="1"></td>
					<td colspan="2" id="centrar"><b>OT SAP:</b></td>
					<td colspan="3"></td>
					<td colspan="1"></td>
					<td colspan="3" id="centrar"><b>TIPO DE MANTENIMIENTO:</b></td>
					<td colspan="4"></td>
					<td colspan="3" id="centrar"><b>ESPECIALIDAD :</b></td>
					<td colspan="4"></td>
					<td colspan="1"></td>
					<td colspan="8"><b>FECHA:</b></td>
				</tr>
				<tr><td colspan="36">ACTIVIDAD 1</td></tr>
				<tr><td colspan="36"></td></tr>
				<tr><td colspan="36"></td></tr>
				<tr><td colspan="36"></td></tr>
				<tr><td colspan="36"></td></tr>
				<tr><td colspan="36"></td></tr>
				<tr>
					<td colspan="13" id="centrar"><b>ILICITOS</b></td>
					<td colspan="23" id="centrar"><b>CANTIDADES DE OBRAS EJECUTADAS</b></td>
				</tr>
				<tr>
					<td colspan="13">
						<table class="sinborde">
						<tr>
							<td class="sinborde">EXTENSION:</td>
							<td></td>
							<td class="sinborde">DIAMETRO</td>
							<td></td>
							<td class="sinborde">LONGITUD</td>
							<td></td>
							<td class="sinborde">MATERIAL</td>
							<td></td>
						</tr>
						</table>
					</td>
					<td colspan="2" id="centrar">ITEM</td>
					<td colspan="13" id="centrar">DESCRIPCION ACTIVIDAD DE MANTENIMIENTO</td>
					<td colspan="2" id="centrar">UNIDAD</td>
					<td colspan="3" id="centrar">CANTIDAD DIA</td>
					<td colspan="3" id="centrar">CANTIDAD ACUMULADA</td>
				</tr>
				<tr>
					<td colspan="13">REPARACI�N</td>
					<td colspan="2"></td>
					<td colspan="13"></td>
					<td colspan="2"></td>
					<td colspan="3"></td>
					<td colspan="3"></td>
				</tr>
				<tr>
					<td colspan="6">COORDENADAS GPS</td>
					<td colspan="5">ANILLO CIRCUNFERENCIAL</td><td colspan="2"></td>
					<td colspan="2"></td>
					<td colspan="13"></td>
					<td colspan="2"></td>
					<td colspan="3"></td>
					<td colspan="3"></td>
				</tr>
				<tr>
					<td colspan="6">NORTE (N):</td>
					<td colspan="5">CAMBIO TRAMO</td><td colspan="2"></td>
					<td colspan="2"></td>
					<td colspan="13"></td>
					<td colspan="2"></td>
					<td colspan="3"></td>
					<td colspan="3"></td>
				</tr>
				<tr>
					<td colspan="6">ESTE (W):</td>
					<td colspan="5">RETIRO DE GRAPA</td><td colspan="2"></td>
					<td colspan="2"></td>
					<td colspan="13"></td>
					<td colspan="2"></td>
					<td colspan="3"></td>
					<td colspan="3"></td>
				</tr>
				<tr class="trLimpia"><td colspan="36"></td></tr>
				<tr class="trLimpia"><td colspan="36"></td></tr>
				<tr><td colspan="36">OBSERVACIONES: </td></tr>
				<tr><td colspan="36"></td></tr>
				<tr><td colspan="36"></td></tr>
				<tr><td colspan="36"></td></tr>
				<tr>
					<td colspan="23"  id="centrar"><b>CONTRATISTA</b></td>
					<td colspan="13"  id="centrar"><b>ECOPETROL</b></td>
				</tr>
				<tr>
					<td colspan="12">
						<table  class="sinborde">
						<tr>
							<td colspan="2" rowspan="3" class="sinborde">ELABORADO</td>
							<td colspan="4" class="sinborde">NOMBRE</td>
							<td colspan="6" class="sinborde"></td>
						</tr>
						<tr>
							<td colspan="4" class="sinborde">CARGO</td>
							<td colspan="6" class="sinborde"></td>
						</tr>
						<tr>
							<td colspan="4" class="sinborde">FIRMA</td>
							<td colspan="6" class="sinborde"></td>
						</tr>
						</table>
					</td>
					<td colspan="12">
						<table class="sinborde">
						<tr>
							<td colspan="2" rowspan="3" class="sinborde">REVISADO</td>
							<td colspan="4" class="sinborde">NOMBRE</td>
							<td colspan="6" class="sinborde"></td>
						</tr>
						<tr>
							<td colspan="4" class="sinborde">CARGO</td>
							<td colspan="6" class="sinborde"></td>
						</tr>
						<tr>
							<td colspan="4" class="sinborde">FIRMA</td>
							<td colspan="6" class="sinborde"></td>
						</tr>
						</table>
					</td>
					<td colspan="12">
						<table class="sinborde">
						<tr>
							<td colspan="2" rowspan="3" class="sinborde">APROBO</td>
							<td colspan="4" class="sinborde">NOMBRE</td>
							<td colspan="6" class="sinborde"></td>
						</tr>
						<tr>
							<td colspan="4" class="sinborde">CARGO</td>
							<td colspan="6" class="sinborde"></td>
						</tr>
						<tr>
							<td colspan="4" class="sinborde">FIRMA</td>
							<td colspan="6" class="sinborde"></td>
						</tr>
						</table>
					</td>
				</tr>

			</tbody>
			<tfoot>
			<tr>
				<td colspan="36" id="centrar">Con la firma del presente formato el trabajador reconoce haber sido notificado previamente  en los t�rminos de ley de las horas ordinarias  y horas extras (cuando se aplique) ac� reportadas.</td>
			</tr>
			<tr>
				<td colspan="36" id="centrar">Nota de propiedad: Los derechos de propiedad intelectual sobre este documento y su contenido le pertenecen exclusivamente al CONSORCIO PIPELINE MAINTENANCE ALLIANCE (PMA). Por lo tanto, queda estrictamente prohibido el uso, divulgaci�n, distribuci�n, reproducci�n, modificaci�n y/o alteraci�n de los mencionados derechos, con fines distintos a los previstos en este documento, sin la autorizaci�n previa y escrita del consorcio. 		</td>
			</tr>
			</tfoot>
		</table>
	</body>
</html>
