<div class="controles">

	<div class="opciones-menu" style="position:absolute;">
		<div class="opcion-tab row" style="margin-bottom:0">
			<button class="waves-effect waves-light blue btn"  ng-click="slideOtp('#slideOpciones')">
				<small data-icon="o"> Opciones</small>

				<small class="slide-state" data-icon="&#xe026;" ng-show="showSlideState"></small>
				<small class="slide-state" data-icon="&#xe029;" ng-show="!showSlideState"></small>
			</button>
		</div>

		<div class="row" id="slideOpciones" style="padding:3px; background: #FFF; border-radius:5px; border:1px solid #aaa;">
			<ul>
				<li ng-show="validGestion('planeacion_ot')">
					<a href="#" ng-click="getFromMenu('#MenuOT','#slideOpciones')" data-icon="&#xe009;">
						Ordenes de trabajo
					</a>
				</li>
				<li ng-show="validGestion('reporte_diario') || validGestion('validacion_reporte_diario')">
					<a href="#" ng-click="getFromMenu('#MenuReportes','#slideOpciones')" data-icon="3">
						Reportes diarios.
					</a>
				</li>

				<li ng-show="validPriv(55)">
					<a href="#" ng-click="getFromMenu('#MenuFacturacion','#slideOpciones')" data-icon="p">
						Facturación
					</a>
				</li>

				<li ng-show="validGestion('informes_generales')">
					<a href="#" ng-click="getFromMenu('#MenuInforme','#slideOpciones')" data-icon="&#xe02c;"> Informes</a>
				</li>
				<hr>

				<li ng-show="validPriv(66) || validPriv(67) || validPriv(55)">
					<a href="#" ng-click="getFromMenu('#MenuAsociaciones','#slideOpciones')" data-icon="&#xe037;"> Asociaciones</a>
				</li>

				<li ng-show="validGestion('maestros_ot')">
					<a href="#" ng-click="getFromMenu('#MenuMaestros','#slideOpciones')" data-icon="&#xe050;">
					  Maestros
					</a>
				</li>
		    </ul>
		</div>
	</div>

	<div class="opciones-area">
		<br><br>
		<?php $this->load->view("inicio/init_content") ?>
  </div>
</div>
<br>


</div>
