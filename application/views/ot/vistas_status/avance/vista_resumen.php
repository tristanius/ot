<section>

  <h5>Resumen de avance de obra</h5>

  <?php
  $id = rand();
  ?>

  <div id="myTabsResumenOT<?= $id ?>" ng-init="initForm('#myTabsResumenOT<?= $id ?>')">
    <ul>
      <li><a href="#tabs-1">Resumen general items</a></li>
      <li><a href="#tabs-2">Resumen por frentes</a></li>
      <li><a href="#tabs-3">Graficos</a></li>
    </ul>
    <div id="tabs-1">
      <?php $this->load->view("ot/vistas_status/avance/general"); ?>
    </div>
    <div id="tabs-2">
      <?php $this->load->view("ot/vistas_status/avance/frentes"); ?>
    </div>
    <div id="tabs-3">
      No disponible
    </div>
  </div>

</section>
