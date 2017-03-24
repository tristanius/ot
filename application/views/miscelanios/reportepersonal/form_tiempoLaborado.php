<?php
$meses = array(
  1=>'enero',
  2=>'febrero',
  3=>'marzo',
  4=>'abril',
  5=>'mayo',
  6=>'junio',
  7=>'julio',
  8=>'agosto',
  9=>'septiembre',
  10=>'octubre',
  11=>'noviembre',
  12=>'diciembre'
);
?>
<form id="inftiempolaboradogeneral" action="<?= site_url("reportepersonal/tiempoLaboradoGeneral") ?>" method="post">
  <h4>Consulta de tiempo laborado por bases y mes</h4>
  <fieldset style="margin:1ex" class="noMaterialStyles regularForm">
    <span>
      <label for="">Base:</label>
      <select id="consultatiempoBase" name="consultatiempoBase" ng-model="consultatiempo.base" ng-init="consultatiempo.base = (''+log.base_idbase)" required>
        <option value="all">Todos</option>
        <?php foreach ($bases->result() as $val): ?>
        <option value="<?= $val->idbase ?>"><?= $val->idbase." ".$val->nombre_base ?></option>
        <?php endforeach; ?>
      </select>
    </span>

    <span>
      <label for="">Mes: </label>
      <select id="consultatiempoMes" name="consultatiempoMes" ng-model="consultatiempo.mes" ng-init="consultatiempo.mes = '<?= date('m')*1 ?>' " required>
        <?php foreach ($meses as $key => $value): ?>
        <option value="<?= $key?>"><?= $value ?></option>
        <?php endforeach; ?>
      </select>
    </span>

    <span>
      <label for="">Año</label> <input id="consultatiempoYear" name="consultatiempoYear" type="text" ng-model="consultatiempo.year" ng-init="consultatiempo.year = <?= date("Y") ?>" required>
    </span>

    <button style="margin-top:0" type="submit" class="btn mini-btn" data-icon="&#xe031;" ng-if="consultatiempo.mes && consultatiempo.year && consultatiempo.base"></button>
  </fieldset>
</form>
