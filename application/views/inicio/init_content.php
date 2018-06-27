
	    <div class="row" style="display:block">
	    	<h4>Sistema de Información y Control operativo</h4>
				<h5>S.I.C.O. App</h5>
	      <img src="<?= base_url('assets/img/ot.png') ?>" alt="" style="max-width:500px" />
	    </div>

			<div id="MenuOT">
	      <?= $this->load->view('inicio/Menu_ant/MenuOT', NULL, TRUE); ?>
	    </div>

			<div id="MenuReportes">
	      <?= $this->load->view('inicio/Menu_ant/MenuReportes', NULL, TRUE); ?>
	    </div>

			<div id="MenuInforme">
	      <?= $this->load->view('inicio/Menu_ant/MenuInformes', NULL, TRUE); ?>
	    </div>

			<div id="MenuFacturacion">
	      <?= $this->load->view('inicio/Menu_ant/MenuFacturacion', NULL, TRUE); ?>
	    </div>

			<div id="MenuAsociaciones">
	      <?= $this->load->view('inicio/Menu_ant/MenuAsociaciones', NULL, TRUE); ?>
	    </div>

	    <div id="MenuMaestros">
	    	<?php $this->load->view('inicio/Menu_ant/MenuMaestros') ?>
	    </div>
