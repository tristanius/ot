<section>
  <button style="font-size:10px" type="button" ng-click="showCopiar=true">Copiar una tarea</button>
  <div ng-show="showCopiar" >
    <label for="">Tarea a copiar: </label>
    <select ng-model="tarea_copiar"ng-options="tare.nombre_tarea for tare in ot.tareas">
    </select>
    <button type="button" ng-click="copiar_tarea(tarea_copiar)" ><small>Copiar nueva tarea</small></button>
  </div>
</section>
