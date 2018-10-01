<section id="asociarItem" class="ventanaItems nodisplay">

  <table>
    <caption>Asociar un item a {{ asociableItem.itemc_item+" - "+nombre_asociar }}</caption>
    <thead>
      <tr>
        <th>Item</th>
        <th>Descripcion</th>
        <th>Frente</th>
        <th>Asociar al item</th>
      </tr>
    </thead>
    <tbody>
      <tr ng-repeat="it in items_planeados">
        <td ng-bind="it.itemc_item"></td>
        <td ng-bind="it.descripcion"></td>
        <td ng-bind="it.nombre_frente+' '+it.ubicacion_frente"></td>
        <td>
          <button type="button" class="btn mini-btn2 green" ng-click="asociarItem(it, '#asociarItem')">Ok</button>
        </td>
      </tr>
    </tbody>
  </table>

  <button type="button" class="btn mini-btn2 red" ng-click="toggleTag('#asociarItem')">(X) Salir</button>
</section>
