<section>

  <h5>Resumen de cantidades a la fecha</h5>

  <a href="<?= site_url('export/resumenOt/'.$idOT) ?>">Exportar a xls</a>
  <?php $this->load->view('ot/table_resumen', array('items'=>$items) ); ?>
</section>
