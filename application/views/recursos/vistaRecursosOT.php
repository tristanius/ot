<div id="ot-recursos" class="nodisplay">

  <h4> No. OT: <span ng-bind="consulta.nombre_ot"></span>  </h4>
  <button type="button" ng-click="clickeableLink('<?=  site_url('ot/resumenOT') ?>/'+consulta.idOT, $event, 'Resumen OT '+consulta.nombre_ot);">Ver resumen de cant. de la Orden</button>
  <hr>

  <!-- --------------------------------------------------------------------------------- -->

  <ul>
    <li>Personal: <button class="btn mini-btn" style="margin-top:0px;" data-icon="&#xe034;" ng-click="showSection('#tabla-personal')"></button> </li>
  </ul>

  <section id="tabla-personal" class="nodisplay">
    <div class="row">
      <ul class="col s12 m7 l7">
        <li>
          <button type="button" class="btn mini-btn indigo lighten-2 black-text" data-icon="&#xe045;"
            ng-click="enableViewRelacion('findPersonal', true, 'addPersonaExterno')" style="margin-top:0; font-size: 2.1ex"></button> Agregar personal basico de otra OT.
        </li>
        <li>
          <button type="button" class="btn mini-btn lighten-2 black-text" data-icon="&#xe045;"
            ng-click="enableViewRelacion('addPersonaExterno', true, 'findPersonal')" style="margin-top:0; font-size: 2.1ex"></button> Agregar personal <b>externo</b>.
        </li>
      </ul>
      <div ng-show="findPersonal"  class="col s12 m12 l12 " style="background:#FAFAFA; padding:4px; border:1px solid #999;">
        <?php $this->load->view('recursos/finders/personal'); ?>
      </div>
      <div ng-show="addPersonaExterno" class="col s12 m12 l12 " style="background:#FAFAFA; padding:4px; border:1px solid #999;">
        <?php $this->load->view('recursos/finders/addPersonalExterno'); ?>
      </div>
    </div>

    <table class="mytabla tabla-recursos font10">
      <thead>
        <tr>
          <th></th>
          <th>Identificacion</th>
          <th>Nombre completo</th>
          <th>Cargo</th>
          <th>Descripcion cargo</th>
          <th>Asignacion como: </th>
          <th>Propio? </th>
        </tr>
        <tr>
          <th></th>
          <th><input type="text" ng-model="filterPer.identificacion"></th>
          <th><input type="text" ng-model="filterPer.nombre_completo"></th>
          <th><input type="text" ng-model="filterPer.itemc_item"></th>
          <th><input type="text" ng-model="filterPer.descripcion"></th>
          <th></th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <tr ng-repeat="p in recursosOT.personal | filter: filterPer | orderBy:'nombre_completo'" style="{{ p.propietario_recurso==true?'':'background: #ffc46d' }}">
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
        </tr>
      </tbody>
    </table>
  </section>

  <hr>

  <!------------------------- EQUIPOS ------------------------------------------->
  <ul>
    <li>Equipos: <button class="btn mini-btn" style="margin-top:0px;" data-icon="&#xe034;" ng-click="showSection('#tabla-equipos')"></button></li>
  </ul>

  <section id="tabla-equipos" class="nodisplay">
    <ul class="col s12 m6 l6">
      <li>
        <button ng-show="validPriv(65)" type="button" class="btn mini-btn light-green black-text" ng-click="showSection('#addEquipo')"
          data-icon="N" style="margin-top:0; font-size: 2.1ex">
        </button> Add. equipo NO siesa / herramienta menor.
      </li>
      <!-- <li><button type="button" class="btn mini-btn light-blue black-text" ng-click="showSection('#findEquipo')" data-icon="C" style="margin-top:0; font-size: 2.1ex"></button> Relacionar equipo siesa.</li> -->
    </ul>

    <div id="findEquipo" class="col s12 m7 l7 nodisplay" style="background:#FAFAFA; padding:4px; border:1px solid #999;">
      <?php $this->load->view('recursos/finders/equipos'); ?>
    </div>

    <div id="addEquipo" class="col s12 m7 l7 nodisplay" style="background:#FAFAFA; padding:4px; border:1px solid #999;">
      <?php $this->load->view('recursos/finders/addEquipoTemp'); ?>
    </div>

    <table class="mytabla tabla-recursos font10">
      <thead>
        <tr>
          <th>Codigo siesa / Cod. temp</th>
          <th>Referencia</th>
          <th>Descripción equipo</th>
          <th>Item</th>
          <th>Desc. Item</th>
          <th>Asinado como:</th>
          <th>propio?</th>
        </tr>
        <tr>
          <th><input type="text" ng-model="filterEq.codigo_siesa"></th>
          <th><input type="text" ng-model="filterEq.referencia"></th>
          <th><input type="text" ng-model="filterEq.descripcion_equipo"></th>
          <th><input type="text" ng-model="filterEq.itemc_item"></th>
          <th><input type="text" ng-model="filterEq.descripcion"></th>
          <th></th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <tr ng-repeat="e in recursosOT.equipo | filter: filterEq | orderBy: 'descripcion_equipo'" style="{{ e.propietario_recurso==true?'':'background: #ffc46d' }}">
          <td ng-bind="e.codigo_siesa"></td>
          <td ng-bind="e.referencia"></td>
          <td ng-bind="e.descripcion_equipo"></td>
          <td ng-bind="e.itemc_item"></td>
          <td ng-bind="e.descripcion"></td>
          <td ng-bind="e.propietario_observacion"></td>
          <td ng-bind="e.propietario_recurso?'SI':'NO'"></td>
        </tr>
      </tbody>
    </table>
  </section>

</div>
