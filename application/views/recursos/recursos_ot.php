<div ng-controller="recursosOT" style="background: #FAFAFA; padding:3px">

  <h5>Gestión de recursos por OT:</h5>
  <form class="" action="#" method="post">
    <small>Aquí podras gestionar los recursos para reportar por una orden de trabajo</small>
    <fieldset class="row noMaterialStyles">
      <div class="col s12 l6 m6 row" >
        <span class="col l2 m3 s5">No. OT:</span>
        <input type="text" ng-model="consulta.indicio_nombre_ot" class="col l4 m4 s6" style="padding:5px" placeholder="Ejemplo: 354-16">
        <button type="button" class="btn blue mini-btn" style="margin:0" ng-click="getOTs('<?= site_url('ot/getByName/') ?>', '<?= site_url('recurso/getByOT') ?>')" data-icon="," ></button>
      </div>

      <div class="col s12 l6 m6" style="border-left:1px solid #AAA">
        <?php $this->load->view('reportes/lista/otSelection'); ?>
      </div>
    </fieldset>
  </form>

  <br>

  <section  style="background:#FFF; padding:1ex; border: 1px solid #AAA">
    <?php $this->load->view('recursos/vistaRecursosOT'); ?>
  </section>
</div>
