<div ng-controller="recursosOT" style="background: #FAFAFA; padding:3px">

  <h5 class="center-align">Gestión de recursos por OT:</h5>
  <form class="" action="#" method="post">
    <small>Aquí podras gestionar los recursos para reportar por una orden de trabajo</small>
    <fieldset class="row noMaterialStyles">

      <section style="padding:1ex;">
        <h6><b>Consulta:</b></h6>
        <div class="noMaterialStyles row col l3 m4 s12">
          <b class="col l3 m4 s4">No. OT:</b>
          <input class="col l8 m8 s8" type="text" ng-model="consulta.indicio_nombre_ot" style="padding: 5px;" placeholder="Ej: 350-16">
        </div>

        <div class="noMaterialStyles row col l3 m4 s12">
          <b class="col l3 m4 s4">C.O:</b>
          <select ng-model="consulta.base" class="col l8 m8 s8" style="height:4ex;">
            <option value="">No Seleccionado</option>
            <option ng-repeat="b in log.bases" value="{{b.idbase}}"> {{b.idbase + " - " + b.nombre_base }} </option>
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

        <div class="row col l1 m2 s12">
          <button type="button" class="btn blue" data-icon="," ng-click="getOTs('<?= site_url('ot/getBy') ?>', '<?= site_url('recurso/getByOT') ?>' )"></button>
        </div>
      </section>

      <div class="col s12 l6 m6 card-panel">
        <?php $this->load->view('reportes/lista/otSelection'); ?>
      </div>
    </fieldset>
  </form>

  <br>

  <section  style="background:#FFF; padding:1ex; border: 1px solid #AAA">
    <?php $this->load->view('recursos/vista_recursos/vistaRecursosOT'); ?>
  </section>
</div>
