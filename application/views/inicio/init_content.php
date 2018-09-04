  <div class="row" style="display:block">
  	<h4>Sistema de Información para Control Operativo</h4>
		<h5>S.I.C.O. App</h5>

		<div class="row">

			<div class="col s12 m4 l4 padding1ex card-panel">

				<div class="row padding1ex">

					<div class="row">
						<div class="col s1 m1 l2"> </div>
				    <div class="col s11 m10 l8">
				      <div class="card">
				        <div class="card-image">
				          <img src="<?= base_url("assets/img/icons/icon-user-by.png") ?>">
				          <span class="card-title text-shadow" ng-bind="log.nombre_usuario"></span>
				        </div>
								<div>
									<ul class="left-align browser-default">
										<li>Rol: <span ng-bind="log.nombre_rol"></span> </li>
                    <li>C.O. asociado: <span ng-bind="log.base"></span> </li>
                    <li>Tipo visualizacion: <span ng-bind="log.tipo_visualizacion"></span> </li>
										<li>Estado: Activo</li>
									</ul>
								</div>
				        <div class="card-action">
				          <a href="#">Ir al panel de sesion</a>
				        </div>
				      </div>
				    </div>
				  </div>

				</div>

			</div>

			<div class="col s12 m4 l4 padding1ex">

			  <div class="row">
			    <div class="col s12 m12">
			      <div class="card">
			        <div class="card-image">
			          <img src="<?= base_url('assets/img/ot.png') ?>">
			          <span class="card-title"> <!-- --> </span>
			        </div>
			        <div class="card-content">
			          <p>
									SICO es un sistema de información para el control de obra.
									<br>Bienvenido.
								</p>
			        </div>
			        <div class="card-action">
			          <a href="#">Instructivos</a>
			        </div>
			      </div>
			    </div>
			  </div>

			</div>

			<div class="col s12 m8 l8 padding1ex card-panel" ng-if="false">
				<h5>Registros en SICO</h5>

				<div class="row padding1ex">

					<div class="col s12 m6 l3">
						<div class="card light-blue darken-4">
							<div class="card-content white-text">
								<div class="card-title">
									<small>Contratos:</small>
								</div>
								<div class="white black-text">
									<h4> - </h4>
								</div>
							</div>
						</div>
				  </div>

					<div class="col s12 m6 l3">
						<div class="card red accent-3">
							<div class="card-content white-text">
								<div class="card-title">
									<small>Ordenes de trabajo:</small>
								</div>
								<div class="white black-text">
									<h4> - </h4>
								</div>
							</div>
						</div>
				  </div>

					<div class="col s12 m6 l3">
						<div class="card teal accent-3">
							<div class="card-content white-text">
								<div class="card-title">
									<small>Reportes diarios:</small>
								</div>
								<div class="white black-text">
									<h4> - </h4>
								</div>
							</div>
						</div>
				  </div>

					<div class="col s12 m6 l3">
						<div class="card orange darken-4">
							<div class="card-content white-text">
								<div class="card-title">
									<small>Actas de factura:</small>
								</div>
								<div class="white black-text">
									<h4> - </h4>
								</div>
							</div>
						</div>
				  </div>

				</div>


			</div>

		</div>

  </div>
