<style media="screen">
  #tr-filter input{
    min-width: 5ex;
    width: 75%;
  }
</style>
<div ng-controller="consulta">
  <h5>Aseguramiento externo de personal reportado</h5>
  <div class="row" ng-controller="consulta_nom">

    <fieldset>
      <legend>Busqueda de personal: </legend>
      <button type="button" class="btn green mini-btn2" ng-click="getAjaxWindow('<?= site_url('reportepersonal/formCargueValidacionHorario'); ?>',$event, '')" data-icon="&#xe030;"> Vía cargue</button>
      <br><br>
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
          <button type="button" class="btn mini-btn green" ng-click="clickeableLink('<?= site_url('reportepersonal/form_tiempoLaboradoGeneral') ?>', $event, 'Tiempo Laborado');" data-icon="&#xe03b;"></button>
        </fieldset>

        <div class="row" ng-if="consulta_nom.fecha_inicio && consulta_nom.fecha_hasta">
          <fieldset class="col m5" ng-if="validPriv(67)">
            <legend>Validación HE:</legend>
            <button type="button" class="btn mini-btn teal darken-1"
                ng-click="bloquearPersonal('<?= site_url('reportepersonal/setValidacion/1'); ?>' ,'<?= site_url('persona/getJsonTiempoLaborado'); ?>')" >
                Validar <span data-icon="&#xe04c;"></span>
            </button>
            <button type="button" class="btn mini-btn red"
                ng-click="bloquearPersonal('<?= site_url('reportepersonal/setValidacion/0'); ?>' ,'<?= site_url('persona/getJsonTiempoLaborado'); ?>')" >
                Invalidar <span data-icon="&#xe04d;"></span>
            </button>
            <p></p>
          </fieldset>

          <fieldset class="col m5" ng-if="validPriv(66)">
              <legend>Nomina:</legend>
              <button type="button" class="btn mini-btn orange darken-2"
                  ng-click="bloquearPersonal('<?= site_url('reportepersonal/toNomina/1'); ?>' ,'<?= site_url('persona/getJsonTiempoLaborado'); ?>')" >
                  Bloquear <span data-icon="O"></span>
              </button>
              <button type="button" class="btn mini-btn teal darken-2"
                  ng-click="bloquearPersonal('<?= site_url('reportepersonal/toNomina/0'); ?>' ,'<?= site_url('persona/getJsonTiempoLaborado'); ?>')" >
                  Devolver <span data-icon="y"></span>
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
            <th></th>
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
            <th>Estado RD</th>
            <th>H.E. Valido</th>
            <th>H.E. Por:</th>
            <th>Nomina</th>
            <th>Nom. por:</th>
          </tr>
          <!--<tr id="tr-filter" class="noMaterialStyles">
            <th> <input type="checkbox" ng-model="per.selected" ng-init="filterper.selected = true"> </th>
            <th> <input type="text" ng-model="filterper.Orden"> </th>
            <th> <input type="text" ng-model="filterper.CO"> </th>
            <th> <input type="text" ng-model="filterper.fecha_reporte"> </th>
            <th> <input type="text" ng-model="filterper.identificacion"> </th>
            <th> <input type="text" ng-model="filterper.nombre_completo"> </th>
            <th> <input type="text" ng-model="filterper.itemc_item"> </th>
            <th> <input type="text" ng-model="filterper.codigo"> </th>
            <th> <input type="text" ng-model="filterper.tipo_item"> </th>
            <th> <input type="text" ng-model="filterper.descripcion"> </th>
            <th> <input type="text" ng-model="filterper.facturable"> </th>
            <th> <input type="text" ng-model="filterper.turno1_inicio"> </th>
            <th> <input type="text" ng-model="filterper.turno1_fin"> </th>
            <th> <input type="text" ng-model="filterper.turno2_inicio"> </th>
            <th> <input type="text" ng-model="filterper.turno2_fin"> </th>
            <th> <input type="text" ng-model="filterper.horas_ordinarias"> </th>
            <th> <input type="text" ng-model="filterper.horas_extra_dia"> </th>
            <th> <input type="text" ng-model="filterper.horas_extra_noc"> </th>
            <th> <input type="text" ng-model="filterper.horas_recargo"> </th>
            <th> <input type="text" ng-model="filterper.festivo"> </th>
            <th> <input type="text" ng-model="filterper.estado_reporte"> </th>
            <th> <input type="text" ng-model="filterper.valido_HE"> </th>
            <th> <input type="text" ng-model="filterper.usuario_validacion_he"> </th>
            <th> <input type="text" ng-model="filterper.en_nomina"> </th>
            <th> <input type="text" ng-model="filterper.usuario_nomina"> </th>
          </tr>-->
        </thead>
        <tbody>
          <tr ng-repeat="per in personal | startFrom:currentPage*pageSize | limitTo:pageSize ">
            <td class="noMaterialStyles"> <input type="checkbox" ng-model="per.selected" ng-init="per.selected = true"> </td>
            <td ng-bind="per.Orden"></td>
            <td ng-bind="per.CO"></td>
            <td ng-bind="per.fecha_reporte"></td>
            <td ng-bind="per.identificacion"></td>
            <td ng-bind="per.nombre_completo"></td>
            <td ng-bind="per.itemc_item"></td>
            <td ng-bind="per.codigo"></td>
            <td ng-bind="per.tipo_item"></td>
            <td ng-bind="per.descripcion"></td>
            <td ng-bind="per.facturable"></td>
            <td ng-bind="per.turno1_inicio"></td>
            <td ng-bind="per.turno1_fin"></td>
            <td ng-bind="per.turno2_inicio"></td>
            <td ng-bind="per.turno2_fin"></td>
            <td ng-bind="per.horas_ordinarias"></td>
            <td ng-bind="per.horas_extra_dia"></td>
            <td ng-bind="per.horas_extra_noc"></td>
            <td ng-bind="per.horas_recargo"></td>
            <td ng-bind="per.festivo"></td>
            <td ng-bind="per.estado_reporte"></td>
            <td ng-bind="per.valido_HE"></td>
            <td ng-bind="per.usuario_validacion_he"></td>
            <td ng-bind="per.en_nomina"></td>
            <td ng-bind="per.usuario_nomina"></td>
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
