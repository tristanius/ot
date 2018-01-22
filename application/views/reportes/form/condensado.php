<section class="card-panel">
  <h5 class="center-align">Consilidar cantidades guardadas del reporte</h5>
  <table id="info_rd_condensado">
    <thead>
      <tr>
        <th>#</th>
        <th>Item</th>
        <th>Descripción</th>
        <th>Asociado</th>
        <th>Cantidad</th>
      </tr>
    </thead>
    <tbody ng-repeat="items in info_rd.items">
      <tr ng-repeat="i in items.actividades">
        <td>1</td>
      </tr>
    </tbody>
  </table>

  <div class="">
    <button type="button" class="btn blue">Guardar</button>
    <button type="button" class="btn green">Exportar</button>
  </div>
</section>
