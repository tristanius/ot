<?php
$meses = array(
  'enero',
  'febrero',
  'marzo',
  'abril',
  'mayo',
  'junio',
  'julio',
  'agosto',
  'septiembre',
  'octubre',
  'noviembre',
  'diciembre'
);
?>

<section ng-controller="consulta">
  <div class=" noMaterialStyles">
    <fieldset>
      <h5><?= $titulo_consulta ?></h5>
      <br>
      <div class="row" style="max-width: 800px">

        <div class="col m6 l6 s12 row" style="border: 1px solid #eee">
          <h6>Bases/ C.O. :</h6>

          <div class="col s6 l6 m6 row" ng-repeat="b in log.bases">
            <input class="col s2 m1 l1"
              type="checkbox"
              ng-init="b.horizontalQuery = false"
              ng-model="b.horizontalQuery"
              ng-change="delAddFromList( consulta.bases , b.idbase )"
              name="{{ b.idbase }}"
              value="{{ b.idbase }}"
            >
            <span class="col s10 m11 l11 black-text">{{ b.idbase + ' - ' + b.nombre_base }}</span>
          </div>


        </div>

        <div class="col m6 l6 s12 row" style="border: 1px solid #eee">
          <div class="col s12 m12 l12">
            <label class="col m3 l3 s12">Mes:</label>
            <select class="col m5 l6 s12" ng-model="consulta.mes" ng-init="consulta.mes = '1'">
              <?php for ($i=0; $i < 12 ; $i++) {
                ?>
                <option value="<?= $i+1 ?>"> <?= $meses[$i] ?> </option>
                <?php
              } ?>
            </select>
          </div>

          <div class="col s12 m12 l12">
            <label class="col m3 l3 s12">Año:</label>
            <input type="number" class="col m5 l6 s12" ng-model="consulta.year" ng-init="consulta.year = <?= date('Y') ?>">
          </div>

          <div class="col s12 m12 l12">
            <label class="col m3 l3 s12">No. OT (Opcional):</label>
            <input type="text" class="col m5 l6 s12" ng-model="consulta.nombre_ot">
          </div>
        </div>

        <div class="col l6 m6 s12 right-align">
          Consultar:
          <button type="button" class="btn light-green accent-4 text-black mini-btn" style="border-radius: 100%" data-icon=","
            ng-click="getConsulta('<?= $link ?>', consulta)">
          </button>
        </div>

      </div>
    </fieldset>
  </div>

  <!-- RESULTADOS DE LA CONSULTA -->
  <?= $vista_consulta ?>

</section>
