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
<section>

	<h5>Reporte de días laborados de personal</h5>

	<div class="noMaterialStyles regularForm">
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

	    <a style="margin-top:0"  ng-if="consultatiempo.mes && consultatiempo.year && consultatiempo.base"
	    	ng-href="<?= site_url('reportepersonal/reporteMes') ?>/{{ consultatiempo.mes+'/'+consultatiempo.year+'/'+consultatiempo.base }}"
	    	class="btn mini-btn" data-icon="&#xe031;" >
	    </a>
	</div>
</section>
