<!-- Modal Structure -->
 <section id="<?= $idtag ?>" class="modal modal-fixed-footer" ng-init="initModals('#<?= $idtag ?>');" >
   <div class="modal-content">
     <h4>Selecciona un contrato para continuar:</h4>

     <table class="mytabla striped">
       <thead>
         <tr>
           <th> <input type="text" ng-model="filtroSelectContrato.no_contrato" value=""> </th>
           <th> <input type="text" ng-model="filtroSelectContrato.contratista" value=""> </th>
           <th> <input type="text" ng-model="filtroSelectContrato.cliente" value=""> </th>
           <th> </th>
         </tr>
         <tr>
           <th>No. de contrato</th>
           <th>Contratista</th>
           <th>Cliente</th>
           <th>Selecionar</th>
         </tr>
       </thead>
       <tbody>
         <tr ng-repeat="c in contratos | filter: filtroSelectContrato">
           <td ng-bind="c.no_contrato"></td>
           <td ng-bind="c.contratista"></td>
           <td ng-bind="c.cliente"></td>
           <td>
             <button type="button" class="btn btn-small" ng-click="selecionarContrato(c, '#<?= $idtag ?>');">Seleccionar</button>
           </td>
         </tr>
       </tbody>
     </table>

   </div>
   <div class="modal-footer">
     <button type="button" class="btn btn-small red modal-close"> Salir</button>
   </div>
 </section>
