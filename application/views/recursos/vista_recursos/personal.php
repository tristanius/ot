<h5>Personal:
  <!-- <button class="btn mini-btn" style="margin-top:0px;" data-icon="&#xe034;" ng-click="showSection('#tabla-personal')"></button> -->
</h5>

<div id="tabla-personal" class="">
  <div class="row">
    <ul class="col s12 m7 l7">
      <li>
        <button type="button" class="btn mini-btn blue darken-1 white-text" data-icon="&#xe045;"
          ng-click="enableViewRelacion('findPersonal', true, 'addPersonaExterno')" style="margin-top:0;"> Agregar personal basico de otra O.T.</button>
      </li>
    </ul>
    <div ng-show="findPersonal"  class="col s12 m12 l12" style="background:#FAFAFA; padding:4px; border:1px solid #999;">
      <?php $this->load->view('recursos/finders/personal'); ?>
    </div>
  </div>

  <table class="mytabla tabla-recursos font10">
    <thead>
      <tr class="blue-grey lighten-4">
        <th></th>
        <th>Identificacion</th>
        <th>Nombre completo</th>
        <th>Cargo</th>
        <th>Descripcion cargo</th>
        <th>Asignacion como: </th>
        <th>Propio? </th>
        <th>U.N.</th>
        <th>Estado</th>
      </tr>
      <tr>
        <th></th>
        <th><input type="text" ng-model="filterPer.identificacion"></th>
        <th><input type="text" ng-model="filterPer.nombre_completo"></th>
        <th><input type="text" ng-model="filterPer.itemc_item"></th>
        <th><input type="text" ng-model="filterPer.descripcion"></th>
        <th></th>
        <th></th>
        <th></th>
        <th><input type="text" ng-model="filterPer.estado_activo"></th>
      </tr>
    </thead>
    <tbody>
      <tr ng-repeat="p in recursosOT.personal | filter: filterPer | orderBy:'nombre_completo'" style="{{ p.propietario_recurso==true?'':'background: #FCD9A9' }}">
        <td>
          <button
          type="button"
          ng-click="delRecursoOT('<?= site_url('persona/delRecursoOT') ?>/', p.idrecurso, p.idrecurso_ot );"
          class="btn mini-btn red"
          > x </button>
        </td>
        <td ng-bind="p.identificacion"></td>
        <td ng-bind="p.nombre_completo"></td>
        <td ng-bind="p.itemc_item"></td>
        <td ng-bind="p.descripcion"></td>
        <td ng-bind="p.propietario_observacion"></td>
        <td ng-bind="p.propietario_recurso==1?'SI':'NO'"></td>
        <td>
          <span ng-if="validPriv(74)">
            <a class="modal-trigger" href="#modal1"  data-icon="&#xe01e;" style="color:#7c310b;" ng-click="cambioUN(p)"></a>
          </span>
          <span ng-bind="p.item_asociado"></span> - <span ng-bind="p.UN"></span>
        </td>
        <td></td> <!-- Estado -->
      </tr>
    </tbody>
  </table>
</div>
