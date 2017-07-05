<nav>
  <ul>
    <li><a href="<?= app_termo() ?>"><img class="logo" src="<?= base_url("assets/img/termotecnica.png") ?>" style="max-width:150px;" /></a></li>
    <li><a href="<?= '' ?>"></a></li>
    <li style="color:#222">Version: 1.55.1001</li>
    <li class="right"><a href="<?= app_termo().'index.php/panel/sesion' ?>" class="padding1ex"> <?= $this->session->userdata('nombre_usuario'); ?> <big data-icon="o"></big> </a></li>
  </ul>
</nav>
