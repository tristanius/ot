<h5>Otros:
  <!-- <button class="btn mini-btn" style="margin-top:0px;" data-icon="&#xe034;" ng-click="showSection('#tabla-otros')"></button> -->
</h5>

<div id="tabla-otros" class="">
  <ul class="col s12 m6 l6">
    <li>
      <button ng-show="validPriv(65)" type="button" class="btn mini-btn blue darken-1 white-text" ng-click="showSection('#addOtros')"
        data-icon="&#xe052;" style="margin-top:0; font-size: 2.1ex"> Add. otros elementos
      </button>
    </li>
    <!-- <li><button type="button" class="btn mini-btn light-blue black-text" ng-click="showSection('#findEquipo')" data-icon="C" style="margin-top:0; font-size: 2.1ex"></button> Relacionar equipo siesa.</li> -->
  </ul>

  <div id="addOtros" class="col s12 m7 l7 nodisplay" style="background:#FAFAFA; padding:4px; border:1px solid #999;">
    <?php $this->load->view('recursos/finders/addOtros'); ?>
  </div>

  <table class="mytabla tabla-recursos font10">
    <thead class="blue-grey lighten-4">
      <tr>
        <th></th>
        <th>Item</th>
        <th>Descripción</th>
        <th>item</th>
        <th>Asignacion</th>
        <th>Propietario</th>
        <th>UN</th>
        <th>Costo</th>
      </tr>
    </thead>
    <tbody>
      <tr ng-repeat="o in recursosOT.otros" style="{{ o.propietario_recurso==true?'':'background: #FCD9A9' }}">
        <td>
            <button
            type="button"
            ng-click="delRecursoOT('<?= site_url('recurso/delRecursoOT') ?>/', o.idrecurso, o.idrecurso_ot );"
            class="btn mini-btn red"
            > x </button>
            <span  ng-bind="o.codigo_siesa"></span>
        </td>
        <td ng-bind="o.codigo"></td>
        <td ng-bind="o.descripcion"></td>
        <td ng-bind="o.itemc_item"></td>
        <td ng-bind="o.propietario_observacion"></td>
        <td ng-bind="o.propietario_recurso==1?'SI':'NO'"></td>
        <td>
          <span ng-if="validPriv(74)">
            <a class="modal-trigger" href="#modal1"  data-icon="&#xe01e;" style="color:#7c310b;" ng-click="cambioUN(o)"></a>
          </span>
          <span ng-bind="o.UN"></span>
        </td>
        <td ng-bind="o.costo_und"></td>
      </tr>
    </tbody>
  </table>
</div>
