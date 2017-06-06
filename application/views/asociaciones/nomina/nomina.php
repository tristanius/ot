<div ng-controller="consulta">
  <h5>Aseguramiento externo de personal reportado</h5>
  <div class="row" ng-controller="consulta_nom">

    <fieldset>
      <legend>Busqueda de personal: </legend>
      <div class="noMaterialStyles regularForm">
        <fieldset>
          <legend style="color: #BBB; font-size:12px">filtros Obligatorios</legend>
          <span for="">Desde:</span> <input placeholder="0000-00-00" type="text" class="datepicker" ng-init="datepicker_init()" name="fecha_inicio" ng-model="consulta_nom.fecha_inicio">
          <span for="">Hasta:</span> <input placeholder="0000-00-00" type="text" class="datepicker" ng-init="datepicker_init()" name="fecha_hasta" ng-model="consulta_nom.fecha_hasta">
        </fieldset>
        <fieldset>
          <legend style="color: #BBB; font-size:12px">Filtros opcionales</legend>
            <span for="">Orden:</span> <input type="text" ng-model="consulta_nom.orden" name="orden" placeholder="Ejemplo: OTATMTPA555-17-18"> &nbsp;
            <span for="">C.O.:</span> <input type="text" ng-model="consulta_nom.base" name="base" placeholder="Ejemplo: 168">&nbsp;
            <span for="">Cédula:</span> <input type="text" ng-model="consulta_nom.identificacion" name="identificacion" placeholder="Ejemplo: 10904455236">&nbsp;
            <span for="">Estado excluido:</span> <input type="text" ng-model="consulta_nom.estado_exl" ng-init="consulta_nom.estado_exl = 'EN ELABORACION, CORREGIR'" ng-readonly="true" name="orden">&nbsp;
            <div class="">
              <br />
              <span for="">Usuario que aplica:</span> <input type="text" ng-model="consulta_nom.idusuario" ng-init="consulta_nom.idusuario = log.nombre_usuario+'-'+log.idusuario" ng-readonly="true">&nbsp;
            </div>
        </fieldset>
        <fieldset ng-if="consulta_nom.fecha_inicio && consulta_nom.fecha_hasta">
          <legend style="color: #BBB; font-size:12px">Opciones</legend>
          <button type="button" class="btn mini-btn" ng-click="obtenerPersonal('<?= site_url('persona/getJsonTiempoLaborado'); ?>')" data-icon=","></button>
          <button type="button" class="btn mini-btn green" ng-click="descargarPersonal()" data-icon="&#xe03b;"></button>
        </fieldset>

        <div class="row" ng-if="consulta_nom.fecha_inicio && consulta_nom.fecha_hasta">
          <fieldset class="col m5" ng-if="validPriv(67)">
            <legend>Validación HE:</legend>
            <button type="button" class="btn mini-btn teal darken-1"
                ng-click="bloquearPersonal('<?= site_url('reportepersonal/setValidacion/1'); ?>' ,'<?= site_url('persona/getJsonTiempoLaborado'); ?>')" data-icon="&#xe04c;">
            </button>
            <button type="button" class="btn mini-btn red"
                ng-click="bloquearPersonal('<?= site_url('reportepersonal/setValidacion/0'); ?>' ,'<?= site_url('persona/getJsonTiempoLaborado'); ?>')" data-icon="&#xe04d;">
            </button>
            <p></p>
          </fieldset>

          <fieldset class="col m5" ng-if="validPriv(66)">
              <legend>Nomina:</legend>
              <button type="button" class="btn mini-btn orange darken-2"
                  ng-click="bloquearPersonal('<?= site_url('reportepersonal/toNomina/1'); ?>' ,'<?= site_url('persona/getJsonTiempoLaborado'); ?>')" data-icon="O">
              </button>
              <button type="button" class="btn mini-btn teal darken-2"
                  ng-click="bloquearPersonal('<?= site_url('reportepersonal/toNomina/0'); ?>' ,'<?= site_url('persona/getJsonTiempoLaborado'); ?>')" data-icon="y">
              </button>
              <p></p>
          </fieldset>

        </div>
      </div>
    </fieldset>

    <form method="post" action="<?= site_url('personal/descargar'); ?>"></form>

    <br><br>

    <div class="font9" style="overflow:auto">
      <table class="mytabla">
        <thead>
          <tr>
            <th>Orden</th>
            <th>CO</th>
            <th>Fecha reporte</th>
            <th>Identificación</th>
            <th>Nombre completo</th>
            <th>Cargo</th>
            <th>Codigo</th>
            <th>Tipo cargo</th>
            <th>Desc. cargo</th>
            <th>Fact.</th>
            <th>T1 inicio</th>
            <th>T1 fin</th>
            <th>T2 inicio</th>
            <th>T2 fin</th>
            <th>HO</th>
            <th>HED.</th>
            <th>HEN</th>
            <th>RN</th>
            <th>FESTIVO?</th>
            <th>Ración</th>
            <th>Pernocto</th>
            <th>Lugar</th>
            <th>Estado RD</th>
            <th>H.E. Valido</th>
            <th>H.E. Por:</th>
            <th>Nomina?</th>
            <th>Nom. por:</th>
          </tr>
        </thead>
        <tbody>
          <tr ng-repeat="per in personal | startFrom:currentPage*pageSize | limitTo:pageSize">
            <td ng-repeat="field in per"> <span  ng-bind="field"></span> </td>
          </tr>
        </tbody>
      </table>

      <div class="noMaterialStyles regularForm">
        <button ng-disabled="currentPage == 0" ng-click="currentPage=currentPage-1">
          Anterior
        </button>
        {{currentPage+1}}/{{numberOfPages()}}
        <button ng-disabled="currentPage >= personal.length/pageSize - 1" ng-click="currentPage=currentPage+1">
          Siguiente
        </button>
        &nbsp;
        Ir a: <input type="number" max="numberOfPages" ng-model="pgNum" ng-change="currentPage = (pgNum-1 > 0)?(pgNum-1):0">
      </div>
    </div>

  </div>
</div>
