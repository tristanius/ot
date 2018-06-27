  <ul id="slide-out" class="sidenav collapsible font12" ng-class="initMenu()">
    <li>
      <div class="user-view">
        <div class="background">
          <img src="<?= base_url("assets/img/termotecnica.png") ?>" style="width:80%; padding:1ex; opacity: 0.1">
        </div>
        <a href="#user">
          <img src="<?= base_url("assets/img/icons/icon-user-by.png") ?>" style="border-radius: 100%; max-width: 50px;">
        </a>
        <span class="name"><?= $this->session->userdata('nombre_usuario'); ?></span>
      </div>
    </li>

    <li><div class="divider"></div></li>
    <li><a class="subheader">Contrato</a></li>
    <li>
      <div class="collapsible-header">1. Información contratos</div>
      <div class="collapsible-body">
        <ul class="">
          <li> <a href="#" class="sidenav-close font11">1.1. Contratos creados</a> </li>
          <li> <a href="#" class="sidenav-close font11">1.2. Items contratuales</a> </li>
          <li> <a href="#" class="sidenav-close font11">1.3. Vigencias de contrato</a> </li>
          <li> <a href="#" class="sidenav-close font11">1.4. Tarifas por vigencia</a> </li>
          <li> <a href="#" class="sidenav-close font11">1.5. Inf. general contrato</a> </li>
        </ul>
      </div>
    </li>

    <li><div class="divider"></div></li>
    <li><a class="subheader">Producción / Obra</a></li>
    <li>
      <div class="collapsible-header">2. Planeación de O.T.</div>
      <div class="collapsible-body">
        <ul class="">
          <li> <a href="#" class="sidenav-close font11">2.1. Ordenes Planeadas</a> </li>
          <li> <a href="#" class="sidenav-close font11">2.2. Resumen de O.T. </a> </li>
        </ul>
      </div>
    </li>

    <li>
      <div class="collapsible-header">3. Recursos de O.T.</div>
      <div class="collapsible-body">
        <ul class="">
          <li> <a href="#" class="sidenav-close font11">3.1. Consultar Recursos O.T.</a> </li>
          <li> <a href="#" class="sidenav-close font11">3.2. Costos de Recursos de O.T.</a> </li>
          <li> <a href="#" class="sidenav-close font11">3.3. Personal de O.T.</a> </li>
          <li> <a href="#" class="sidenav-close font11">3.4. Equipo de O.T.</a> </li>
          <li> <a href="#" class="sidenav-close font11">3.5. Material de O.T.</a> </li>
        </ul>
      </div>
    </li>

    <li>
      <div class="collapsible-header">4. Reportes diarios</div>
      <div class="collapsible-body">
        <ul class="">
          <li> <a href="#" class="sidenav-close font11">Reportes diarios de O.T.</a> </li>
          <li> <a href="#" class="sidenav-close font11">Estados de Reportes</a> </li>
          <li> <a href="#" class="sidenav-close font11">Informe de cantidades reportadas</a> </li>
        </ul>
      </div>
    </li>


    <li>
      <div class="collapsible-header">5. Actas de Factura</div>
      <div class="collapsible-body">
        <ul class="">
          <li> <a href="#" class="sidenav-close font11">Planear Orden de trabajo</a> </li>
          <li> <a href="#" class="sidenav-close font11">Ver Ordenes de trabajo</a> </li>
          <li> <a href="#" class="sidenav-close font11">Ver graficas estado</a> </li>
        </ul>
      </div>
    </li>

    <li>
      <div class="collapsible-header">6. Informes generales</div>
      <div class="collapsible-body">
        <ul class="">
          <li> <a href="#" class="sidenav-close font11">Planear Orden de trabajo</a> </li>
          <li> <a href="#" class="sidenav-close font11">Ver Ordenes de trabajo</a> </li>
          <li> <a href="#" class="sidenav-close font11">Ver graficas estado</a> </li>
        </ul>
      </div>
    </li>


    <li><div class="divider"></div></li>
    <li><a class="subheader">Maestros</a></li>

    <li>
      <div class="collapsible-header">7. Personal</div>
      <div class="collapsible-body">
        <ul class="">
          <li> <a href="#" class="sidenav-close font11">7.1. Ver persona</a> </li>
          <li> <a href="#" class="sidenav-close font11">7.2. Ver O.T. asociadas</a> </li>
          <li> <a href="#" class="sidenav-close font11">7.3. </a> </li>
        </ul>
      </div>
    </li>

    <li><div class="divider"></div></li>
    <li><a class="subheader">Sesión</a></li>
    <li><a href="<?= app_termo().'index.php/panel/sesion' ?>" class="sidenav-close font11">X. Panel de sesión </a></li>
  </ul>
