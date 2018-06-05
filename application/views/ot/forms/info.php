  <hr style="border:1px solid #33c633">
  <br>

  <div class="col l12 row noMaterialStyles regularForm">
    <div class="col l12 row">
      <div class="col s12 l6">
        <input type="checkbox" id="p1" ng-model="ot.json.p1" />
        <label for="p1">PERMISO DE PREDIO</label>
      </div>

      <div class="col s12 l6">
        <input type="checkbox" id="p2" ng-model="ot.json.p2" />
        <label for="p2">PERMISO DE OCUPACION DE CAUSE</label>
      </div>

      <div class="col s12 l6">
        <input type="checkbox" id="p3" ng-model="ot.json.p3" />
        <label for="p3">CURSO F.T.S</label>
      </div>

      <div class="col s12 l6">
        <input type="checkbox" id="p4" ng-model="ot.json.p4" />
        <label for="p4">PERMISO APROVECHAMIENTO FORESTAL</label>
      </div>

      <div class="col s12 l6">
        <input type="checkbox" id="p5" ng-model="ot.json.p5" />
        <label for="p5">DIVULGACION A COMUNIDAD</label>
      </div>
  </div>

  <div class="col l12 s12 row">
    <label for=""><b>Actividad:</b></label>
    <textarea  id="actividad" ng-model="ot.actividad" ng-init="setTextarea('#actividad', ot.actividad)"></textarea>
  </div>

  <div class="col l12 s12 row">
    <label for=""><b>Justificación:</b></label>
    <textarea id="justificacion"  ng-model="ot.justificacion" ng-init="setTextarea('#justificacion', ot.justificacion)"></textarea>
  </div>

  </div>



  <br class="clear-left">
  <hr style="border:1px solid #33c633">
  <br>

  <div class="col l3 row">
    <label class="col m3" ><b>Locacion:</b></label>
    <select class="col m7" ng-model="ot.locacion">
      <optgroup label="General">
        <option value="OTRO">OTRO</option>
      </optgroup>
      <optgroup label="AYACUCHO">
        <option value='OLEODUCTO DE 8" AYACUCHO-GALAN'>OLEODUCTO DE 8" AYACUCHO-GALAN</option>
        <option value='OLEODUCTO DE 14" AYACUHO-CIB'>OLEODUCTO DE 14" AYACUHO-CIB</option>
        <option value='COMBUSTOLEODUCTO 18" GALAN-AYACUCHO'>COMBUSTOLEODUCTO 18" GALAN-AYACUCHO</option>
        <option value='OLEODUCTO DE 18 " ISLA VI-COMUNEROS'>OLEODUCTO DE 18 " ISLA VI-COMUNEROS</option>
        <option value='PLANTA AYACUCHO'>PLANTA AYACUCHO</option>
        <option value='LINEAS DE 8"AYA-GAL,14" AYA-CIB, 18" GAL-AYA'>LINEAS DE 8"AYA-GAL,14" AYA-CIB, 18" GAL-AYA</option>
        <option value='TODAS'>TODAS</option>
        <option value='LÍNEA DE 14" AYACUCHO-GALÁN'>LÍNEA DE 14" AYACUCHO-GALÁN</option>
        <option value='LINEA DE 8" AYA-GAL - LINEA DE 18" GAL-AYA'>LINEA DE 8" AYA-GAL - LINEA DE 18" GAL-AYA</option>
        <option value='ROSARIO-CIB'>ROSARIO-CIB</option>
        <option value='OLEODUCTO DE 8" GALAN-AYACUCHO'>OLEODUCTO DE 8" GALAN-AYACUCHO</option>
        <option value='POLIDUCTO PPG AYACUCHO - GALAN 14"'>POLIDUCTO PPG AYACUCHO - GALAN 14"</option>
      </optgroup>
      <optgroup label="GALAN">
        <option value='SISTEMA GALAN CHIMITA'>SISTEMA GALAN CHIMITA</option>
        <option value='SISTEMA GALAN CHIMITA; LINEA GALAN - LIZAMA 12"'>SISTEMA GALAN CHIMITA; LINEA GALAN - LIZAMA 12"</option>
        <option value='SISTEMA GALAN CHIMITA; LINEA LIZAMA - TIENDA NUEVA 6"'>SISTEMA GALAN CHIMITA; LINEA LIZAMA - TIENDA NUEVA 6"</option>
        <option value='SISTEMA GALAN CHIMITA; LINEA TIENDA NUEVA - GUAYACAN 12"'>SISTEMA GALAN CHIMITA; LINEA TIENDA NUEVA - GUAYACAN 12"</option>
        <option value='SISTEMA GALAN CHIMITA; LINEA GUAYACAN - CHIMITA 6"'>SISTEMA GALAN CHIMITA; LINEA GUAYACAN - CHIMITA 6"</option>
        <option value='SISTEMA GALAN - SEBATOPOL 8"'>SISTEMA GALAN - SEBATOPOL 8"</option>
        <option value='SISTEMA GALAN - SEBATOPOL 12"'>SISTEMA GALAN - SEBATOPOL 12"</option>
        <option value='SISTEMA GALAN - SEBATOPOL 16"'>SISTEMA GALAN - SEBATOPOL 16"</option>
        <option value='POLIDUCTO PPG AYACUCHO - GALAN 14"'>POLIDUCTO PPG AYACUCHO - GALAN 14"</option>
        <option value='PLANTA GALAN'>PLANTA GALAN</option>
        <option value='PLANTA CHIMITA'>PLANTA CHIMITA</option>
        <option value='PLANTA AYACUCHO'>PLANTA AYACUCHO</option>
        <option value='PLANTA COPEY'>PLANTA COPEY</option>
        <option value='TERMINAL TERPEL LA FORTUNA'>TERMINAL TERPEL LA FORTUNA</option>
        <option value='INSTALACIONES REFINERIA - GRB'>INSTALACIONES REFINERIA - GRB</option>
        <option value='LINEAS DE TRASPORTE, PLANTAS Y TANQUES DPTO MANTENIMIENTO -NORTE'>LINEAS DE TRASPORTE, PLANTAS Y TANQUES DPTO MANTENIMIENTO -NORTE</option>
      </optgroup>
      <optgroup label="CAÑO LIMON">
        <option value='SISTEMA 18" CAÑO LIMON - BANADIA' >SISTEMA 18" CAÑO LIMON - BANADIA</option>
        <option value='SISTEMA 18" BANADIA - SAMORE' >SISTEMA 18" BANADIA - SAMORE</option>
        <option value='SISTEMA 20" SAMORE - TOLEDO' >SISTEMA 20" SAMORE - TOLEDO</option>
        <option value='SISTEMA 18" TOLEDO - RIO ZULIA' >SISTEMA 18" TOLEDO - RIO ZULIA</option>
        <option value='SISTEMA 24" RIO ZULIA - ORU' >SISTEMA 24" RIO ZULIA - ORU</option>
        <option value='SISTEMA 24" ORU - AYACUCHO' >SISTEMA 24" ORU - AYACUCHO</option>
        <option value='PLANTA BANADIA' >PLANTA BANADIA</option>
        <option value='PLANTA SAMORE' >PLANTA SAMORE</option>
        <option value='PLANTA TOLEDO' >PLANTA TOLEDO</option>
        <option value='PLANTA RIO ZULIA' >PLANTA RIO ZULIA</option>
        <option value='PLANTA ORU' >PLANTA ORU</option>
      </optgroup>
    </select>

  </div>
  <div class="col l3 row">
    <label class="col m3" ><b>Abscisa:</b></label>
    <input class="col m7" type="text" ng-model="ot.abscisa" />
  </div>

  <div class="col l12">
    <br>
  </div>

  <div class="col l12 s12 row">
    <label><b>Departamento:</b></label>
    <span ng-bind="ot.departamento" ng-init="obtenerMunicipios(ot.departamento, '<?= site_url('miscelanio/getMunicipios') ?>')"></span>
    <select id="depart" ng-model="ot.departamento" data-getmunis="<?= site_url('miscelanio/getMunicipios') ?>"
        ng-change="obtenerMunicipios(ot.departamento, '<?= site_url('miscelanio/getMunicipios') ?>')">
      <option value="">Seleccione nuevo departamento del país</option>
      <?php foreach ($depars->result() as $depar) {
      ?>
      <option value="<?= $depar->departamento ?>"><?= $depar->departamento ?></option>
      <?php
      } ?>
    </select>
  </div>
  <div class="col l6 s12 row">
    <label><b>Municipio:</b></label>
    <span ng-bind="ot.municipio"></span>
    <select id="munic" ng-model="ot.municipio">
      <option value="">seleccione nuevo municipio</option>
      <option ng-repeat="m in munis track by $index" value="{{ m.municipio }}">{{ m.municipio }}</option>
    </select>
  </div>
  <div class="col l6 s12 row">
    <label><b> Poblado/Vereda </b></label>
    <input type="text" ng-model="ot.vereda">
  </div>

  <hr>
  <br class="clear-left">
  <hr style="border:1px solid #33c633">
  <br>
