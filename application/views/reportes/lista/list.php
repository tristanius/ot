<div style="border:1px solid #AAA; padding:1ex;">
  <h5>Listado de reportes de la orden de trabajo {{ ot.nombre_ot }} </h5>
  <div class="noMaterialStyles regularForm">
    <span>Año: <input type="number" style="width:8ex" ng-model="filtroReportes.year" ng-init="filtroReportes.year = <?= date('Y') ?> "></span>
    <span>
      Mes:
      <select class="" ng-model="filtroReportes.mes" ng-init="filtroReportes.mes = '-<?= date('m') ?>-'">
        <option value="">Todo</option>
        <?php for ($i=1; $i<=12; $i++): ?>
          <option value="-<?= ($i<10?0:'').$i ?>-"><?= $i ?></option>
        <?php endfor; ?>
      </select>
    </span>
    <span> Día: <input type="text" ng-if="filtroReportes.mes" style="width:8ex" ng-model="filtroReportes.dia"></span>
    <span ng-if="!validPriv(68)"> <span ng-init="filtroReportes.validado_pyco = (!validPriv(68)?'VALIDO':'')"></span> Usuario de validación externa</span>
  </div>
  <table class="mytabla font11 striped">
    <thead>
      <tr style="background:#D7F1F4">
        <th></th>
        <th>Fecha</th>
        <th>O.T.</th>
        <th>Estado doc.</th>
        <th>Validación</th>
        <th>Gestionar</th>
        <th colspan="2">PDF reporte</th>
        <th><small>T.L.</small></th>
        <th><small>F. creación</small></th>
      </tr>
    </thead>
    <tbody>
      <tr ng-repeat="rd in listaReportes | filter:{ 'fecha_reporte': ( filtroReportes.year+filtroReportes.mes+filtroReportes.dia ), 'validado_pyco':filtroReportes.validado_pyco } | orderBy: 'fecha_reporte' ">
        <td>
          <button
            ng-show=" ( validPriv(53) && (  rd.estado == 'ABIERTO' && rd.validado_pyco == 'PENDIENTE' ) ) || validPriv(70) "
            class="btn mini-btn2 red"
            ng-click=" delReporte('<?= site_url('reporte/deleteReporte')?>', rd.idreporte_diario )"
            target="_blank">
            X
          </button>
        </td>
        <td ng-bind="rd.fecha_reporte"></td>
        <td ng-bind="rd.nombre_ot"></td>
        <td ng-bind="rd.estado"></td>
        <td ng-bind="rd.validado_pyco"></td>
        <td>
          <button type="button" class="btn mini-btn2" data-icon="," ng-click="getReporte('<?= site_url('reporte/get/') ?>/'+rd.idreporte_diario, '#ventanaReporte', '#ventanaReporteOCulta')"> </button>
        </td>
        <td>
          <a class="btn light-blue darken-3 mini-btn2" ng-href="<?= site_url('export/rd_pma')?>/{{rd.OT_idOT}}/{{rd.idreporte_diario}}"
            target="_blank" data-icon="h">
          </a>
        </td>
        <td>
          <button class="btn light-blue mini-btn2"
              ng-if="validPriv(68)"
              ng-click="getReporte('<?= site_url('export/vwPrintSelection')?>/'+rd.OT_idOT+'/'+rd.idreporte_diario,  '#ventanaReporte', '#ventanaReporteOCulta');"
              data-icon="&#xe036;">
          </button>
        </td>
        <td>
          <a class="btn cyan mini-btn2" ng-if="validPriv(68)" ng-href="<?= site_url('reportepersonal/tl_pma')?>/{{rd.OT_idOT}}/{{rd.idreporte_diario}}" target="_blank" data-icon="&#xe048;">  </a>
        </td>
        <td> <small class="font10" ng-bind="rd.fecha_registro"></small> </td>
      </tr>
    </tbody>
  </table>
</div>
