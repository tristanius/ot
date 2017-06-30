<div ng-controller="OT">

  <section class="list" ng-controller="listaOT">
    <h4>Gestion de ordenes de trabajo:</h4>

    <div class="row botonera" ng-if="validPriv(37)">
      Add. OT: <button type="button" class="btn mini-btn" data-icon="&#xe052;" ng-click="getAjaxWindow('<?= site_url('ot/addNew') ?>', $event, 'Gestion de OTs');"></button>
    </div>

    <div class="row" style="margin:2px; padding:2px; border:1px solid #999;border-radius:7px;">

      <div class="col m3 row noMaterialStyles">
        <label style="color: #332" class="col m5 right-align">Orden:</label>
        <input type="text" ng-model="consulta.indicio_nombre_ot">
      </div>
      <div class="col m4 row noMaterialStyles">
        <label style="color: #332" class="col m5 right-align">C.O. (base):</label>
        <select ng-model="consulta.base" class="col m4" style="height:4ex;">
          <option value="">Sin selección</option>
          <?php foreach ($bases->result() as $b): ?>
            <option value="<?= $b->idbase ?>"><?= $b->idbase." - ".$b->nombre_base ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="noMaterialStyles row col l3 m4 s12">
        <b class="col l3 m4 s4">Estado:</b>
        <select ng-model="consulta.estado" class="col l8 m8 s8" style="height:4ex;">
          <option value="">No Seleccionado</option>
          <option value="POR EJECUTAR">POR EJECUTAR</option>
          <option value="ACTIVA">ACTIVA</option>
          <option value="FINALIZÓ">FINALIZÓ</option>
        </select>
      </div>

      <div class="col m1">
        <button type="button" class="btn mini-btn" data-icon="," style="margin-top:0;"
          ng-click="findOTsByBase('<?= site_url('ot/getBy') ?>')"></button>
      </div>

    </div>

    <div class="row">
      <?php $this->load->view('ot/lista/list') ?>
    </div>
  </section>

</div>
