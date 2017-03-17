<div class="" ng-controller="lista_equipos">
  <h4>Listado de equipos cargadas a la aplicación: </h4>

  <!-- Ventana de consulta -->
  <section id="consultaEquipo" class="nodisplay ventanaConsulta"></section>

  <?php if (isset($edit)): ?>
    <button type="button" class="btn" ng-click="getAjaxWindow('<?= site_url('equipo/formUploadByOT') ?>', $event, 'Equipos')" data-icon="&#xe030;"> Cargas de equipos x OT</button>
  <?php else: ?>
    <button type="button" class="btn" ng-click="getAjaxWindow('<?= site_url('equipo/formUpload') ?>', $event, 'Equipos')" data-icon="&#xe030;"> Cargas de equipos</button>
  <?php endif; ?>
  <div ng-if="cargandoConsulta">
    Cargando...
    <img src="<?= base_url('assets/img/loader.gif') ?>" width="100px" />
  </div>

  <?php if (!isset($edit)): ?>
    <button type="button" ng-click="cargaListaEquipos('<?= site_url('equipo/getAll') ?>')">Listar todos los equipos</button>
  <?php else: ?>
    <fieldset class="noMaterialStyles">
      <legend>Buscar por OT</legend>
      <div class="row">
        <b class="col s5 m3 l2">No. OT:</b> <input class="col s6 m3 l2" type="text" ng-model="consulta.indicio_nombre_ot">
      </div>
      <button type="button" ng-click="byOT('<?= site_url('equipo/byOT') ?>')">Buscar</button>
    </fieldset>
  <?php endif; ?>

  <table class="mytabla font12">
    <thead>
      <tr>
         <th>No.</th>
         <?php if (isset($edit)): ?>
          <th>Orden</th>
          <th>item</th>
         <?php endif; ?>
         <th>Codigo siesa</th>
         <th>Referencia</th>
         <th>Descripción</th>
         <th>C. Costo</th>
         <th>Unidad de negocio</th>
         <?php if (isset($edit)): ?>
           <th>borrar</th>
         <?php endif; ?>
         <th>Consulta</th>
      </tr>
    </thead>
    <tbody>
      <tr class="noMaterialStyles">
        <td></td>
        <?php if (isset($edit)): ?>
        <td></td>
        <td><input type="text" ng-model="filtro_lp.itemc_item" placeholder="busca aqui"></td>
        <?php endif; ?>
        <td><input type="text" ng-model="filtro_lp.codigo_siesa" placeholder="busca aqui"></td>
        <td><input type="text" ng-model="filtro_lp.referencia" placeholder="busca aqui"></td>
        <td><input type="text" ng-model="filtro_lp.descripcion" placeholder="busca aqui"></td>
        <td></td>
        <td></td>
        <?php if (isset($edit)): ?>
          <td></td>
        <?php endif; ?>
        <td></td>
      </tr>
      <tr ng-repeat="q in equs | filter: filtro_lp track by $index ">
         <td ng-bind="$index+1"></td>
         <?php if (isset($edit)): ?>
         <td ng-bind="q.nombre_ot"></td>
         <td ng-bind="q.itemc_item"></td>
         <?php endif; ?>
         <td ng-bind="q.codigo_siesa"></td>
         <td ng-bind="q.referencia"></td>
         <td ng-bind="q.descripcion"></td>
         <td ng-bind="q.ccosto"></td>
         <td ng-bind="q.desc_un"></td>
         <?php if (isset($edit)): ?>
         <td>
           <button type="button" ng-click="delRecursoOT('<?= site_url('equipo/delRecursoOT') ?>/', q.idrecurso, q.idrecurso_ot );" class="btn red mini-btn">x</button>
         </td>
         <?php endif; ?>
         <td>
           <button type="button" ng-click="verHistorialCarguesOT('<?= site_url('equipo/historialOTs') ?>/', q.idequipo)" class="btn orange mini-btn"> <span data-icon="B"></span> </button>
         </td>

      </tr>
    </tbody>
  </table>
</div>
