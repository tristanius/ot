<h5>Material: <button class="btn mini-btn" style="margin-top:0px;" data-icon="&#xe034;" ng-click="showSection('#tabla-material')"></button></h5>

<div id="tabla-material" class="nodisplay">
  <ul class="col s12 m6 l6">
    <li>
      <button ng-show="validPriv(65)" type="button" class="btn mini-btn blue black-text" ng-click="showSection('#addMaterial')"
        data-icon="N" style="margin-top:0; font-size: 2.1ex">
      </button> Add. material
    </li>
    <!-- <li><button type="button" class="btn mini-btn light-blue black-text" ng-click="showSection('#findEquipo')" data-icon="C" style="margin-top:0; font-size: 2.1ex"></button> Relacionar equipo siesa.</li> -->
  </ul>

  <div id="addMaterial" class="col s12 m7 l7 nodisplay" style="background:#FAFAFA; padding:4px; border:1px solid #999;">
    <?php $this->load->view('recursos/finders/addMaterial'); ?>
  </div>

  <table class="mytabla tabla-recursos font10">
    <thead>
      <tr>
        <th></th>
        <th>Codigo</th>
        <th>Descripción</th>
        <th>item</th>¿
        <th>Asignacion</th>
        <th>Propietario</th>
        <th>UN</th>
      </tr>
    </thead>
    <tbody>
      <tr ng-repeat="m in recursosOT.material" style="{{ m.propietario_recurso==true?'':'background: #ffc46d' }}">
        <td>
            <button
            type="button"
            ng-click="delRecursoOT('<?= site_url('recurso/delRecursoOT') ?>/', m.idrecurso, m.idrecurso_ot );"
            class="btn mini-btn red"
            > x </button>
            <span  ng-bind="m.codigo_siesa"></span>
        </td>
        <td ng-bind="m.codigo"></td>
        <td ng-bind="m.descripcion"></td>
        <td ng-bind="m.itemc_item"></td>
        <td ng-bind="m.propietario_observacion"></td>
        <td ng-bind="m.propietario_recurso==1?'SI':'NO'"></td>
        <td>
          <span ng-if="validPriv(74)">
            <a class="modal-trigger" href="#modal1"  data-icon="&#xe01e;" style="color:#7c310b;" ng-click="cambioUN(e)"></a>
          </span>
          <span ng-bind="m.UN"></span>
        </td>
      </tr>
    </tbody>
  </table>
</div>
