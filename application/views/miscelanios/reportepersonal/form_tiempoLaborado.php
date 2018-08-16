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
  <h4>Consulta de tiempo laborado: </h4>
  <fieldset style="margin:1ex" class="noMaterialStyles regularForm">
    <div>
      <label for="">Base:</label>
      <select id="consultatiempoBase" name="consultatiempoBase" ng-model="consultatiempo.base" ng-init="consultatiempo.base = (''+log.base_idbase)" required>
        <option value="all">Todos</option>
        <option ng-repeat="b in log.bases" value="{{b.idbase}}"> {{b.idbase + " - " + b.nombre_base }} </option>
      </select>
    </div>
    <p class="">
      (Recuerda, entre más grande sea el rango de fechas más tiempo puede tardar la petición)
    </p>

    <table cellspacing="0" style="width:auto;">
      <tbody>
        <tr>
          <td>
            <label for="">Fecha inicio rango:</label>
          </td>
          <td>
            <input type="text" class="datepicker" ng-init="datepicker_init()" ng-model="consultatiempo.mes_i" name="fecha_tl_ini" readonly="readonly" />
          </td>
        </tr>
        <tr>
          <td>
            <label for="">Fecha fin rango:</label>
          </td>
          <td>
            <input type="text" class="datepicker" ng-init="datepicker_init()" ng-model="consultatiempo.mes_f" name="fecha_tl_fin" readonly="readonly" />
          </td>
        </tr>
      </tbody>
    </table>
    <button style="margin-top:0" type="submit" class="btn mini-btn" data-icon="&#xe031;" ng-if="consultatiempo.mes_i && consultatiempo.mes_f && consultatiempo.base"></button>
  </fieldset>
</form>
