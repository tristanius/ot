  <ul id="slide-out" class="sidenav collapsible font12 " ng-class="initMenu()">
    <li>
      <div class="user-view">
        <div class="background">
          <img src="<?= base_url("assets/img/termotecnica.png") ?>" style="width:100%; opacity: 0.05; padding:1ex">
        </div>
        <a> <img class="circle" src="<?= base_url("assets/img/icons/icon-user-by.png") ?>"> </a>
        <a> <b><?= $this->session->userdata('nombre_usuario'); ?></b> </a>
      </div>
    </li>

    <li><div class="divider"></div></li>
    <li ng-if="validGestion('contrato')"><a class="subheader">Contrato</a></li>
    <li ng-if="validGestion('contrato')"> <!-- Revisar -->
      <div class="collapsible-header">1. Información contratos</div>
      <div class="collapsible-body">
        <ul class="blue lighten-5">
          <li> <a href="#" class="sidenav-close font11">1.1. Contratos creados</a> </li>
          <li> <a href="#" class="sidenav-close font11">1.2. Items contratuales</a> </li>
          <li> <a href="#" class="sidenav-close font11">1.3. Vigencias de contrato</a> </li>
          <li> <a href="#" class="sidenav-close font11">1.4. Tarifas por vigencia</a> </li>
          <li> <a href="#" class="sidenav-close font11">1.5. Inf. general contrato</a> </li>
        </ul>
      </div>
    </li>

    <li><div class="divider"></div></li>
    <li ng-if="validGestion('planeacion_ot') || validGestion('maestros_ot') || validGestion('reporte_diario') || validGestion('facturacion') || validGestion('informes_generales')"><a class="subheader">Producción / Obra</a></li>
    <li ng-if="validGestion('planeacion_ot')">
      <div class="collapsible-header"> 2. Planeación de O.T.</div>
      <div class="collapsible-body">
        <ul class="blue lighten-5">
          <li ng-if"validPriv(37) || validPriv(59)">
            <a href="#" class="sidenav-close font11" ng-click="clickeableLink('<?= site_url('ot/listOT') ?>', $event, 'Gestion de OTs'); closeMenu()">2.1. Ordenes Planeadas</a>
          </li>
          <!--<li> <a href="#" class="sidenav-close font11">2.2. Resumen de O.T. </a> </li>-->
        </ul>
      </div>
    </li>

    <li ng-if="validGestion('maestros_ot')">
      <div class="collapsible-header">3. Recursos de O.T.</div>
      <div class="collapsible-body">
        <ul class="blue lighten-5">
          <li ng-if="validPriv(41)">
            <a href="#" class="sidenav-close font11" ng-click="clickeableLink('<?= site_url('recurso/recursosOT') ?>', $event, 'Recursos de OT'); closeMenu()">3.1. Recursos de O.T.</a>
          </li>
          <li ng-if="validGestion('apps')">
            <a href="#" class="sidenav-close font11">3.2. Costos de Recursos de O.T.</a>
          </li>
          <li ng-show="validPriv(64)">
            <a href="#" class="sidenav-close font11" ng-click="clickeableLink('<?= site_url('persona/byOT') ?>', $event, 'Personal por OT'); closeMenu()">3.3. Personal por O.T.</a>
          </li>
          <li ng-show="validPriv(48) || validPriv(65)">
            <a href="#" class="sidenav-close font11" ng-click="clickeableLink('<?= site_url('equipo/listado/edit') ?>', $event, 'Equipos por OT'); closeMenu()">3.4. Equipo por O.T.</a>
          </li>
          <li ng-if="validGestion('apps')">
            <a href="#" class="sidenav-close font11">3.5. Material de O.T.</a>
          </li>
        </ul>
      </div>
    </li>

    <li ng-if="validGestion('reporte_diario')">
      <div class="collapsible-header">4. Reportes diarios</div>
      <div class="collapsible-body">
        <ul class="blue lighten-5">
          <li>
            <a href="#" class="sidenav-close font11" ng-click="clickeableLink('<?= site_url('reporte/listado') ?>', $event, 'Gestion reportes'); closeMenu()">4.1. Reportes diarios de O.T.</a>
          </li>
          <li ng-if="validPriv(68)">
            <a href="#" class="sidenav-close font11" ng-click="clickeableLink('<?= site_url('consulta/form_estado_reportes') ?>', $event, 'Estados de reportes'); closeMenu()">4.2. Estados de reportes</a>
          </li>
          <li ng-if="validPriv(68)">
            <a href="#" class="sidenav-close font11" ng-click="clickeableLink('<?= site_url('consulta/form_indicadores_ot') ?>', $event, 'Cant. item mes a mes'); closeMenu()">4.3. Cantidades reportadas por mes</a>
          </li>
        </ul>
      </div>
    </li>


    <li ng-if="validGestion('facturacion')">
      <div class="collapsible-header">5. Actas de Factura</div>
      <div class="collapsible-body">
        <ul class="blue lighten-5">
          <li ng-if="validPriv(55)">
            <a href="#" class="sidenav-close font11" ng-click="clickeableLink('<?= site_url('factura/gestion') ?>', $event, 'Gestionar facturas'); closeMenu()">5.1. Actas de factura</a>
          </li>
          <li ng-if="validGestion('apps')"> <!-- Revisar -->
            <a href="#" class="sidenav-close font11">5.2. Graficas </a>
          </li>
          <!--<li> <a href="#" class="sidenav-close font11">Historico de facturas</a> </li> -->
        </ul>
      </div>
    </li>

    <li ng-if="validGestion('informes_generales')">
      <div class="collapsible-header">6. Informes generales</div>
      <div class="collapsible-body">
        <ul class="blue lighten-5">
          <li ng-show="validPriv(51)">
            <a href="#" class="sidenav-close font11" ng-click="clickeableLink('<?= site_url('export/form_informeProduccion') ?>', $event, 'Inf. de Produccion'); closeMenu()">Inf. de control producción</a>
          </li>
          <li ng-if="validPriv(52)">
            <a href="#" class="sidenav-close font11" ng-click="clickeableLink('<?= site_url('ot/getInformes') ?>', $event, 'informes de O.T.'); closeMenu()">Informes de PyCO</a>
          </li>
          <li ng-show="validPriv(61)">
            <a href="#" class="sidenav-close font11" ng-click="clickeableLink('<?= site_url('consulta/form_reporte_pyco') ?>', $event, 'Inf. de equipos'); closeMenu()">Informes equipos mensual</a>
          </li>
          <li ng-show="validPriv(62)">
            <a href="#" class="sidenav-close font11" ng-click="clickeableLink('<?= site_url('reportepersonal/form_tiempoLaboradoGeneral') ?>', $event, 'inf. Tiempo Laborado'); closeMenu()">Informe de tiempo Laborado</a>
          </li>
          <li ng-show="validPriv(62)">
            <a href="#" class="sidenav-close font11" ng-click="clickeableLink('<?= site_url('reportepersonal/form_reporteMes') ?>', $event, 'inf. Días Laborados'); closeMenu()">Informe de dias laborados</a>
          </li>

        </ul>
      </div>
    </li>


    <li><div class="divider"></div></li>
    <li><a class="subheader" ng-if="validGestion('maestros_generales')">Maestros</a></li>

    <li>
      <div class="collapsible-header">7. Personal</div>
      <div class="collapsible-body">
        <ul class="blue lighten-5">
          <li> <a href="#" class="sidenav-close font11" ng-if="validPriv(64)">7.1. Ver persona</a> </li>
          <li> <a href="#" class="sidenav-close font11" ng-if="validGestion('apps')">7.2. Ver O.T. asociadas</a> </li>
        </ul>
      </div>
    </li>

    <li>
      <div class="collapsible-header">8. Equipo</div>
      <div class="collapsible-body">
        <ul class="blue lighten-5">
          <li> <a href="#" class="sidenav-close font11" ng-if="validPriv(48) || validPriv(65)" >7.1. Ver Equipo</a> </li>
          <li> <a href="#" class="sidenav-close font11" ng-if="validGestion('apps')">7.2. Ver O.T. asociadas</a> </li>
        </ul>
      </div>
    </li>

    <li><div class="divider"></div></li>
    <li><a class="subheader">Sesión</a></li>
    <li>
      <a href="<?= app_termo().'index.php/panel/sesion' ?>" class="collapsible-header font11">X. Panel de sesión </a>
    </li>
  </ul>
