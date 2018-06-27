	<div>
		<table class="noMaterialStyles mytabla font12 striped">
		    <thead>
		      <tr style="background: #D8DAFF;">
		        <th>C.O.</th>
		        <th>No. orden de trabajo</th>
		        <th>fecha creacion en sistema</th>
		        <th># Tareas</th>
						<th>Especialidad</th>
						<th>Tipo OT</th>
		        <th>Estado</th>
		        <th>Opciones</th>
		      </tr>
					<tr style="background:#D7F1F4">
		    		<td></td>
		    		<td><input type="text" ng-model="filtro.nombre_ot" placeholder="Filtro " =""></td>
		    		<td><input type="text" ng-model="filtro.fecha_creacion"> </td>
		    		<td></td>
		    		<td><input type="text" ng-model="filtro.nombre_especialidad" placeholder="Filtro " =""></td>
		    		<td><input type="text" ng-model="filtro.nombre_tipo_ot" placeholder="Filtro " =""></td>
						<td></td>
		    		<td></td>
		    	</tr>
		    </thead>
		    <tbody>
		        <tr ng-repeat="ot in ots | filter: filtro | orderBy: 'idOT' "> <!--  | orderBy: 'nombre_ot' -->
		          <td> <strong ng-bind="ot.base_idbase"></strong></td>
		          <td style="text-align:center"> <b ng-bind="ot.nombre_ot"></b> </td>
		          <td ng-bind="ot.fecha_creacion"></td>
		          <td ng-bind="ot.num_tareas"></td>
							<td ng-bind="ot.nombre_especialidad"></td>
			    		<td ng-bind="ot.nombre_tipo_ot"></td>
		          <td ng-bind="ot.estado_doc"></td>
		          <td>
		            <button type="button" class="btn btn-small font10" ng-click="getAjaxWindow('<?= site_url('ot/edit') ?>/'+ot.idOT, $event, 'Editar OT');" data-icon="&#xe03e;"> Modificar</button>

								<button type="button" class="btn blue btn-small font10" ng-click="getAjaxWindow('<?= site_url('ot/duplicar') ?>/'+ot.idOT, $event, 'Duplicar OT');" ng-if="validPriv(37)" data-icon="'"> Duplicar</button>

								<button ng-if="validPriv(69)" class="btn btn-small red font10" ng-click="deleteOT('<?= site_url('ot/delete') ?>/', ot.idOT)" > X </button>
		          </td>
		        </tr>
		    </tbody>
		 </table>

	</div>
