  <ul id="slide-out" class="sidenav collapsible font14" ng-class="initMenu()">
    <li>
      <a class="sidenav-close"><b data-icon="&#xe001;"> Ocultar</b> <img src="<?= base_url("assets/img/termotecnica.png") ?>"  style="width:80px; display:inline; float:right" /> </a>
    </li>
    <li>
      <div class="user-view">
        <div class="background blue">
          <!---->
        </div>
        <a> <img class="circle" src="<?= base_url("assets/img/icons/icon-user-by.png") ?>"> </a>
        <a> <b class="white-text">
          <?= $this->session->userdata('nombre_usuario'); ?></b>
        </a>
      </div>
    </li>

    <li><div class="divider"></div></li>

    <li ng-if="validGestion('contrato')"> <small class="groupItems">Contrato</small> </li>
    <li ng-if="validGestion('contrato')"> <!-- Revisar -->
      <div class="collapsible-header">1. Información contratos  &nbsp; <span data-icon="~"></span> </div>
      <div class="collapsible-body">
        <ul class="blue lighten-5">
          <li> <a href="#" class="font12" ng-click="clickeableLink('<?= site_url('contrato/gestion') ?>', $event, 'Maestro de contrato'); closeMenu()">1.2. Maestro de contratos</a> </li>
          <li> <a href="#" class="sidenav-close font12">1.3. Items contratuales</a> </li>
          <li> <a href="#" class="sidenav-close font12">1.4. Vigencias de contrato</a> </li>
          <li> <a href="#" class="sidenav-close font12">1.5 Tarifas por vigencia</a> </li>
          <li> <a href="#" class="sidenav-close font12">1.6. Inf. general contrato</a> </li>
        </ul>
      </div>
    </li>

    <li ng-if="validGestion('contrato')"> <!-- Revisar -->
      <div class="collapsible-header">1.1. Centros de operacion &nbsp; <span data-icon="&#xe000;"></span> </div>
      <div class="collapsible-body">
        <ul class="blue lighten-5">
          <li> <a href="#" class="sidenav-close font12">1.1.1. Maestro de centros operacion</a> </li>
          <li> <a href="#" class="sidenav-close font12">1.1.2. Relacionar C.O. a contratos </a> </li>
        </ul>
      </div>
    </li>

    <li><div class="divider"></div></li>
    <li ng-if="validGestion('planeacion_ot') || validGestion('maestros_ot') || validGestion('reporte_diario') || validGestion('facturacion')">
      <small class="groupItems">Ordenes de trabajo</small>
    </li>

    <li ng-if="validGestion('planeacion_ot')">
      <div class="collapsible-header"> 2. Ordenes de trabajo &nbsp; <span data-icon="&#xe03f;"></span> </div>
      <div class="collapsible-body">
        <ul class="blue lighten-5">
          <li ng-if"validPriv(37) || validPriv(59)">
            <a href="#" class="sidenav-close font12" ng-click="clickeableLink('<?= site_url('ot/listOT') ?>', $event, 'Gestion de OTs'); closeMenu()">2.2. Planeacion de O.T.</a>
          </li>
          <!--<li> <a href="#" class="sidenav-close font12">2.2. Resumen de O.T. </a> </li>-->
        </ul>
      </div>
    </li>

    <li ng-if="validGestion('maestros_ot')">
      <div class="collapsible-header">3. Recursos de O.T. &nbsp; <span data-icon="&#xe050;"></span></div>
      <div class="collapsible-body">
        <ul class="blue lighten-5">
          <li ng-if="validPriv(41)">
            <a href="#" class="sidenav-close font12" ng-click="clickeableLink('<?= site_url('recurso/recursosOT') ?>', $event, 'Recursos de OT'); closeMenu()">3.1. Recursos de O.T. <span data-icon="N"></span> </a>
          </li>
          <li ng-if="validGestion('apps')">
            <a href="#" class="sidenav-close font12">3.2. Costos de Recursos de O.T.  <span data-icon="&#xe010;"></span> </a>
          </li>
          <li ng-show="validPriv(64)">
            <a href="#" class="sidenav-close font12" ng-click="clickeableLink('<?= site_url('persona/byOT') ?>', $event, 'Personal por OT'); closeMenu()">3.3. Personal por O.T. <span  data-icon="&#xe048; "></span> </a>
          </li>
          <li ng-show="validPriv(48) || validPriv(65)">
            <a href="#" class="sidenav-close font12" ng-click="clickeableLink('<?= site_url('equipo/listado/edit') ?>', $event, 'Equipos por OT'); closeMenu()">3.4. Equipo por O.T. <span  data-icon="&#xe042; "></span> </a>
          </li>
          <li ng-if="validGestion('apps')">
            <a href="#" class="sidenav-close font12"> 3.5. Material de O.T. <span data-icon="5 "></span> </a>
          </li>
        </ul>
      </div>
    </li>

    <li ng-if="validGestion('reporte_diario')">
      <div class="collapsible-header"> 4. Reportes diarios. &nbsp; <span style="font-size:14px" data-icon="3"></span> </div>
      <div class="collapsible-body">
        <ul class="blue lighten-5">
          <li>
            <a href="#" class="sidenav-close font12" ng-click="clickeableLink('<?= site_url('reporte/listado') ?>', $event, 'Gestion reportes'); closeMenu()">  4.1. <b>Reportes diarios de O.T.</b> </a>
          </li>

          <li ng-if="validPriv(80)">
            <a href="#" class="sidenav-close font12" ng-click="clickeableLink('<?= site_url('reporte/cargue_reporte') ?>', $event, 'Cargue de reportes'); closeMenu()">4.2. Cargue de reportes</a>
          </li>

          <li ng-if="validPriv(68)">
            <a href="#" class="sidenav-close font12" ng-click="clickeableLink('<?= site_url('consulta/form_estado_reportes') ?>', $event, 'Estados de reportes'); closeMenu()">4.3. Estados de reportes</a>
          </li>
          <li ng-if="validPriv(68)">
            <a href="#" class="sidenav-close font12" ng-click="clickeableLink('<?= site_url('consulta/form_indicadores_ot') ?>', $event, 'Cant. item mes a mes'); closeMenu()">4.4. Cantidades reportadas por mes</a>
          </li>
        </ul>
      </div>
    </li>


    <li ng-if="validGestion('facturacion')">
      <div class="collapsible-header">5. Actas de Factura &nbsp; <span style="font-size:14px" data-icon="p"></span></div>
      <div class="collapsible-body">
        <ul class="blue lighten-5">
          <li ng-if="validPriv(55)">
            <a href="#" class="sidenav-close font12" ng-click="clickeableLink('<?= site_url('factura/gestion') ?>', $event, 'Gestionar facturas'); closeMenu()">5.1. Actas de factura</a>
          </li>
          <li ng-if="validGestion('apps')"> <!-- Revisar -->
            <a href="#" class="sidenav-close font12">5.2. Graficas </a>
          </li>
          <!--<li> <a href="#" class="sidenav-close font12">Historico de facturas</a> </li> -->
        </ul>
      </div>
    </li>

    <li><div class="divider"></div></li>
    <li ng-if="validGestion('informes_generales')"> <small class="groupItems">Informes:</small> </li>
    <li ng-if="validGestion('informes_generales')">
      <div class="collapsible-header">6. Informes generales &nbsp; <span data-icon="&#xe03b;"> </div>
      <div class="collapsible-body">
        <ul class="blue lighten-5">
          <li ng-show="validPriv(51)">
            <a href="#" class="sidenav-close font12" ng-click="clickeableLink('<?= site_url('export/form_informeProduccion') ?>', $event, 'Inf. de Produccion'); closeMenu()">Inf. de control producción</a>
          </li>
          <li ng-if="validPriv(52)">
            <a href="#" class="sidenav-close font12" ng-click="clickeableLink('<?= site_url('ot/getInformes') ?>', $event, 'informes de O.T.'); closeMenu()">Informes de PyCO</a>
          </li>
          <li ng-show="validPriv(61)">
            <a href="#" class="sidenav-close font12" ng-click="clickeableLink('<?= site_url('consulta/form_reporte_pyco') ?>', $event, 'Inf. de equipos'); closeMenu()">Informes equipos mensual</a>
          </li>
          <li ng-show="validPriv(62)">
            <a href="#" class="sidenav-close font12" ng-click="clickeableLink('<?= site_url('reportepersonal/form_tiempoLaboradoGeneral') ?>', $event, 'inf. Tiempo Laborado'); closeMenu()">Informe de tiempo Laborado</a>
          </li>
          <li ng-show="validPriv(62)">
            <a href="#" class="sidenav-close font12" ng-click="clickeableLink('<?= site_url('reportepersonal/form_reporteMes') ?>', $event, 'inf. Días Laborados'); closeMenu()">Informe de dias laborados</a>
          </li>

        </ul>
      </div>
    </li>


    <li><div class="divider"></div></li>

    <li ng-if="validGestion('maestros_generales')"> <small class="groupItems">Maestros:</small> </li>
    <li ng-if="validGestion('maestros_generales')">
      <div class="collapsible-header">7. Maestros personal &nbsp; <span data-icon="&#xe047;"> </div>
      <div class="collapsible-body">
        <ul class="blue lighten-5">
          <li> <a href="#" class="sidenav-close font12" ng-if="validPriv(64)" ng-click="clickeableLink('<?= site_url('persona/listado') ?>', $event, 'Personal'); closeMenu()">7.1. Ver persona</a> </li>
          <li> <a href="#" class="sidenav-close font12" ng-if="validGestion('apps')">7.2. Ver O.T. asociadas</a> </li>
        </ul>
      </div>
    </li>

    <li ng-if="validGestion('maestros_generales')">
      <div class="collapsible-header">8. Maestros equipos &nbsp; <span data-icon="&#xe042;"> </div>
      <div class="collapsible-body">
        <ul class="blue lighten-5">
          <li> <a href="#" class="sidenav-close font12" ng-if="validPriv(48) || validPriv(65)" ng-click="clickeableLink('<?= site_url('equipo/listado') ?>', $event, 'Equipos'); closeMenu()">7.1. Ver Equipo</a> </li>
          <li> <a href="#" class="sidenav-close font12" ng-if="validGestion('apps')">7.2. Ver O.T. asociadas</a> </li>
        </ul>
      </div>
    </li>

    <li><div class="divider"></div></li>
    <li ng-if="validGestion('asociaciones_externas')">
      <div class="collapsible-header">9. Validaciones y asociaciones externas</div>
      <div class="collapsible-body">
        <ul class="blue lighten-5">
          <li> <a href="#" class="sidenav-close font12" ng-if="validPriv(66)" ng-click="clickeableLink('<?= site_url('persona/view_cargue_horas') ?>', $event, 'Personal asociado'); closeMenu()">9.1. Asociación de nomina</a> </li>
        </ul>
      </div>
    </li>

    <li><div class="divider"></div></li>
    <li> <small class="groupItems">Sesion:</small> </li>
    <li>
      <a href="<?= app_termo().'index.php/panel/sesion' ?>" class="collapsible-header font12">10. Panel de sesión </a>
    </li>
  </ul>


<style>
  li small.groupItems{
    font-size: 10px;
    color:gray;
  }
</style>
