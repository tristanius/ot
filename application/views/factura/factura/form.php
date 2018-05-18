<section id="formFactura" class="windowCentered2 row" ng-controller="formFactura" <?php if($isMod): ?> ng-init="getFacturaData('<?= site_url('factura/get/'.$idfactura) ?>')" <?php endif; ?> >
  <h4>Acta de factura - {{ contrato.contratista }}</h4>
  <hr>

  <section class="card">
    <div class="">

    </div>

    <div class="inputs row noMaterialStyles padding1ex">

      <div class="padding1ex col s12 m6 l3">
        <b class="col s5 m4 l4 right-align">No. Factura: </b>
        <input type="text" name="" value="" placeholder="No. de factura">
      </div>

      <div class="padding1ex col s12 m6 l3">
        <b class="col s5 m4 l4 right-align">No. Contrato: </b>
        <input type="text" ng-model="contrato.no_contrato" name="" disabled/>
      </div>

      <div class="padding1ex col s12 m6 l3">
        <b class="col s5 m4 l4 right-align">vigencia de tarifas: </b>
        <select class="" ng-options="v as v.descripcion_vigencia for v in contrato.vigencias" ng-model="factura.vigencia" ng-init="factura.vigencia = contrato.vigencias[0]" disabled>
        </select>
      </div>

      <div class="padding1ex col s12 m6 l3">
        <b class="col s5 m4 l4 right-align">Estado del acta: </b>
        <select class="" name="">
          <option value="CREADO">CREADO</option>
          <option value="APROBADO">APROBADO</option>
          <option value="POR FIRMAR">POR FIRMAR</option>
          <option value="CREADO">CREADO</option>
        </select>
      </div>

    </div>

    <div class="inputs row noMaterialStyles padding1ex" >

      <div class="padding1ex col s12 m6 l3">
        <b class="col s5 m4 l3 right-align">Inicio periodo facturación: </b>
        <input type="text" class="datepicker" ng-init="datepicker_init()" name="" value="" placeholder="No. de fecha">
      </div>

      <div class="padding1ex col s12 m6 l3 end">
        <b class="col s5 m4 l3 right-align">Final periodo facturación: </b>
        <input type="text" class="datepicker" ng-init="datepicker_init()" name="" value="" placeholder="No. de fecha">
      </div>

    </div>

    <br>

    <div id="myTabs" ng-init="initTabs('#myTabs')">
      <ul>
        <li><a href="#tabs-1">Descripción</a></li>
        <li><a href="#tabs-2">Recursos</a></li>
        <li><a href="#tabs-3">Adjuntos</a></li>
      </ul>
      <div id="tabs-1" class="noMaterialStyles">

        <div class="">
          <b> Tipo de acta: </b>
          <select class="" name="">
            <option value=""></option>
          </select>
        </div>

        <div class="">
          <p> Notas:</p>
          <textarea></textarea>
        </div>

      </div>
      <div id="tabs-2">
        <p>Morbi tincidunt, dui sit amet facilisis feugiat, odio metus gravida ante, ut pharetra massa metus id nunc. Duis scelerisque molestie turpis. Sed fringilla, massa eget luctus malesuada, metus eros molestie lectus, ut tempus eros massa ut dolor. Aenean aliquet fringilla sem. Suspendisse sed ligula in ligula suscipit aliquam. Praesent in eros vestibulum mi adipiscing adipiscing. Morbi facilisis. Curabitur ornare consequat nunc. Aenean vel metus. Ut posuere viverra nulla. Aliquam erat volutpat. Pellentesque convallis. Maecenas feugiat, tellus pellentesque pretium posuere, felis lorem euismod felis, eu ornare leo nisi vel felis. Mauris consectetur tortor et purus.</p>
      </div>
      <div id="tabs-3">
        <p>Mauris eleifend est et turpis. Duis id erat. Suspendisse potenti. Aliquam vulputate, pede vel vehicula accumsan, mi neque rutrum erat, eu congue orci lorem eget lorem. Vestibulum non ante. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Fusce sodales. Quisque eu urna vel enim commodo pellentesque. Praesent eu risus hendrerit ligula tempus pretium. Curabitur lorem enim, pretium nec, feugiat nec, luctus a, lacus.</p>
        <p>Duis cursus. Maecenas ligula eros, blandit nec, pharetra at, semper at, magna. Nullam ac lacus. Nulla facilisi. Praesent viverra justo vitae neque. Praesent blandit adipiscing velit. Suspendisse potenti. Donec mattis, pede vel pharetra blandit, magna ligula faucibus eros, id euismod lacus dolor eget odio. Nam scelerisque. Donec non libero sed nulla mattis commodo. Ut sagittis. Donec nisi lectus, feugiat porttitor, tempor ac, tempor vitae, pede. Aenean vehicula velit eu tellus interdum rutrum. Maecenas commodo. Pellentesque nec elit. Fusce in lacus. Vivamus a libero vitae lectus hendrerit hendrerit.</p>
      </div>
    </div>

  </section>

  <hr>

  <div class="btnWindow">
    <?php if ($isMod): ?>
      <button id="guardar_reporte" ng-show="panel_visible" type="button" class="waves-effect waves-light btn mini-btn2" ng-click="save('<?= site_url('factura/mod') ?>','mod')">
        <b data-icon="&#xe015;"></b> Actualizar
      </button>
    <?php else: ?>
      <button id="guardar_reporte" ng-show="panel_visible" type="button" class="waves-effect waves-light btn mini-btn2" ng-click="save('<?= site_url('factura/add') ?>','add')">
        <b data-icon="&#xe015;"></b> Registrar
      </button>
    <?php endif; ?>
    <button type="button" class="waves-effect waves-light btn grey mini-btn2" ng-click="toggleWindow2('#ventanaFactura', '#ventanaFacturaOculta')" data-icon="&#xe036;"> Ocultar</button>
    <button type="button" class="waves-effect waves-light btn red mini-btn2" ng-click="cerrarWindowLocal('#ventanaFactura', enlaceGetFactura)" data-icon="n"> Cerrar</button>
  </div>
</section>

<script>

</script>
