<h5>Equipos:
  <!-- <button class="btn mini-btn" style="margin-top:0px;" data-icon="&#xe034;" ng-click="showSection('#tabla-equipos')"></button> -->
</h5>

<div id="tabla-equipos" class="">
  <ul class="col s12 m6 l6">
    <li>
      <button ng-show="validPriv(65)" type="button" class="btn mini-btn blue darken-1 white-text" ng-click="showSection('#addEquipo')"
        data-icon="N" style="margin-top:0; font-size: 2.1ex">
        Crear equipo provisonal
      </button>
    </li>
    <!-- <li><button type="button" class="btn mini-btn light-blue black-text" ng-click="showSection('#findEquipo')" data-icon="C" style="margin-top:0; font-size: 2.1ex"></button> Relacionar equipo siesa.</li> -->
  </ul>

  <div id="addEquipo" class="col s12 m7 l7 nodisplay" style="background:#FAFAFA; padding:4px; border:1px solid #999;">
    <?php $this->load->view('recursos/finders/addEquipoTemp'); ?>
  </div>

  <table id="tablaEquiposRecursosOT" class="mytabla tabla-recursos font10">
    <thead>
      <tr class="blue-grey lighten-4">
        <th>Codigo ERP / Temporal</th>
        <th>Referencia</th>
        <th>Descripción equipo</th>
        <th>Item</th>
        <th>Desc. Item</th>
        <th>Asinado como:</th>
        <th>propio?</th>
        <th>U.N.</th>
        <th>Costo</th>
        <th>Activo</th>
      </tr>
      <tr>
        <th><input type="text" ng-model="filterEq.codigo_siesa"></th>
        <th><input type="text" ng-model="filterEq.referencia"></th>
        <th><input type="text" ng-model="filterEq.descripcion_equipo"></th>
        <th><input type="text" ng-model="filterEq.itemc_item"></th>
        <th><input type="text" ng-model="filterEq.descripcion"></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th><input type="text" ng-model="filterEq.estado_activo"></th>
      </tr>
    </thead>
    <tbody>
      <tr ng-repeat="e in recursosOT.equipo | filter: filterEq | orderBy: 'descripcion_equipo'" style="{{ e.propietario_recurso==true?'':'background: #FCD9A9' }}">
        <td>
            <button
            type="button"
            ng-click="delRecursoOT('<?= site_url('recurso/delRecursoOT') ?>/', e.idrecurso, e.idrecurso_ot );"
            class="btn mini-btn red"
            > x </button>
            <span  ng-bind="e.codigo_siesa"></span>
        </td>
        <td ng-bind="e.referencia"></td>
        <td ng-bind="e.descripcion_equipo"></td>
        <td ng-bind="e.itemc_item"></td>
        <td ng-bind="e.descripcion"></td>
        <td ng-bind="e.propietario_observacion"></td>
        <td ng-bind="e.propietario_recurso==1?'SI':'NO'"></td>
        <td>
          <span ng-if="validPriv(74)">
            <a class="modal-trigger" href="#modal1"  data-icon="&#xe01e;" style="color:#7c310b;" ng-click="cambioUN(e)"></a>
          </span>
          <span ng-bind="e.UN"></span>
        </td>
        <td ng-bind="e.costo_und"></td>

        <td></td> <!-- Estado -->
      </tr>
    </tbody>
  </table>

  <button type="button" class="btn green" ng-click="exportar_tabla('#tablaEquiposRecursosOT')" ng-if="condensado.guardado == true">Exportar</button>
</div>
