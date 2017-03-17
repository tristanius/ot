<section id="tabs"  class="contenidos" ng-controller="test" ng-init='log = <?= json_encode($this->session->userdata()) ?> '>
  <div class="tabs_aplier" ng-init="site_url = '<?= site_url('') ?>'">

    <div class="tabContainer" id="tabContainer">

      <ul>

        <li ng-repeat="tab in tabs track by $index" class="pestana {{tab.class}}">
          <a class="clickeableTab" href="#" ng-click="clickedTab($event, tab)" data-tab="{{ tab.linkto }}" ng-bind-html="tab.titulo"></a>
          &nbsp;&nbsp;
          <a href="#" ng-if="tab.linkto != 'options' " ng-click="closeTab(tab, $event)" class="icon-red close-btn" data-icon="&#xe04d;"></a>
        </li>

      </ul>

    </div>

    <div class="tabContents" id="tabContents">
      <div ng-repeat="tab in tabs" id="{{tab.linkto}}" class="vistaPestana {{ tab.class }}" ng-include="tab.include">
      </div>
    </div>

  </div>

  <div id="VentanaContainer" class="VentanaContainer nodisplay row">
    <div class="loader col s12" ng-include="form">

    </div>
  </div>
  <div id="WindowOculta" class="WindowOculta nodisplay">
    <button type="button" class="btn blue" ng-click="toggleWindow();" name="button">
      <small>Mostrar Ventana oculta</small>
    </button>
  </div>

  <div id="dialogPanel" class="dialogPanel nodisplay"
        style="background:#FFF; position: fixed; top:10px; left:10px; box-shadow:0px 0px 6px 3px #444; width:90%; height:90%; overflow:scroll; z-index:1000" >
    <article class="font9"></article>
    <button type="button" class="btn blue mini-btn" ng-click="toggleWindow2('#dialogPanel','.btnDialogPanel')" name="button">
      <small>Aceptar</small>
    </button>
  </div>
</section>



<!-- la directiva ngInclude soluciono el problema de los eventos en inteerfaces asincronas -->
