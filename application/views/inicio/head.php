  <head>
    <meta charset="utf-8">
    <!-- CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/fontastic/styles.css') ?>" />
    <!-- Materialize -->
    <link rel="stylesheet" href="<?= base_url('assets/materialize/css/materialize.min.css') ?>" />
    <link rel="shortcut icon" href="<?= base_url( 'favico.ico' ) ?>" />

    <!-- uploadfile CSS -->
    <link href="<?= base_url('assets/js/uploader/uploadfile.css') ?>" rel="stylesheet">

    <!-- Estilos propios -->
    <link rel="stylesheet" href="<?= base_url('assets/css/principal.css') ?>?v=<?php echo rand(); ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/css/menu_opciones.css') ?>?v=<?php echo rand(); ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/css/tablas.css') ?>?v=<?php echo rand(); ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/css/calendario.css') ?>?v=<?php echo rand(); ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/css/forms.css') ?>?v=<?php echo rand(); ?>" />

    <!-- librerias JS -->
    <script type="text/javascript" src="<?= base_url('assets/js/jquery-3.3.1.min.js') ?>"></script>
    <script type="text/javascript" src="<?= base_url('assets/js/vendor/angular.min.js') ?>"></script>

    <!-- Materialize -->
    <script type="text/javascript" src="<?= base_url('assets/materialize/js/materialize.min.js') ?>"></script>

    <!-- JQuery UI -->
    <script type="text/javascript" src="<?= base_url('assets/js/vendor/jquery-ui/jquery-ui.min.js') ?>"></script>
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/js/vendor/jquery-ui/jquery-ui.css') ?>" />

    <!-- uploadfile JS -->
    <script src="<?= base_url('assets/js/vendor/jquery.form.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url('assets/js/uploader/jquery.uploadfile.js') ?>" type="text/javascript"></script>

    <!-- datatables -->
    <script src="<?= base_url('assets/js/datatables/spanish.json') ?>" charset="utf-8"></script>
    <script type="text/javascript" src="<?= base_url('assets/js/datatables/datatables.min.js') ?>"></script>
    <link rel="stylesheet" href="<?= base_url('assets/js/datatables/datatables.min.css') ?>" media="screen" charset="utf-8">

    <!-- tinyMCE -->
    <script src="<?= base_url('assets/js/vendor/tableExport/js/xlsx.core.min.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url('assets/js/vendor/tableExport/js/FileSaver.min.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url('assets/js/vendor/tableExport/js/tableexport.min.js') ?>" type="text/javascript"></script>

    <!-- TableExport -->
    <link rel="stylesheet" href="<?= base_url('assets/js/vendor/tableExport/css/tableexport.min.css') ?>" />
    <script src="<?= base_url('assets/js/vendor/tinymce-angular.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url('assets/js/vendor/tinymce-angular.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url('assets/js/vendor/tinymce-angular.js') ?>" type="text/javascript"></script>

    <!-- Charts JS -->
    <script src="<?= base_url('assets/js/vendor/Chart.min.js') ?>" type="text/javascript"></script>
    <!-- FileSaverAs -->
    <script src="<?= base_url('assets/js/vendor/FileSaver.min.js') ?>" type="text/javascript"></script>
    <!-- Mainer JS -->
    <script type="text/javascript">
    var task = {url:'<?= site_url('welcome/loadOptions') ?>'}
    var baseUrl = '<?= site_url() ?>';
    </script>
    <script src="<?= base_url('assets/js/main/OT.js') ?>?v=<?php echo rand(); ?>" type="text/javascript"></script>
    <script src="<?= base_url('assets/js/main/consulta.js') ?>?v=<?php echo rand(); ?>" type="text/javascript"></script>
    <script src="<?= base_url('assets/js/main/reportes.js') ?>?v=<?php echo rand(); ?>" type="text/javascript"></script>
    <script src="<?= base_url('assets/js/main/calendario.js') ?>?v=<?php echo rand(); ?>" type="text/javascript"></script>
    <script src="<?= base_url('assets/js/main/persona.js') ?>?v=<?php echo rand(); ?>" type="text/javascript"></script>
    <script src="<?= base_url('assets/js/main/equipo.js') ?>?v=<?php echo rand(); ?>" type="text/javascript"></script>
    <script src="<?= base_url('assets/js/main/recursos.js') ?>?v=<?php echo rand(); ?>" type="text/javascript"></script>
    <script src="<?= base_url('assets/js/main/tarifa.js') ?>?v=<?php echo rand(); ?>" type="text/javascript"></script>
    <script src="<?= base_url('assets/js/main/factura.js') ?>?v=<?php echo rand(); ?>" type="text/javascript"></script>
    <script src="<?= base_url('assets/js/main/migracion_recursos.js') ?>?v=<?php echo rand(); ?>" type="text/javascript"></script>
    <script src="<?= base_url('assets/js/main/cargues_historicos.js') ?>?v=<?php echo rand(); ?>" type="text/javascript"></script>
    <script src="<?= base_url('assets/js/main/tabs.js') ?>?v=<?php echo rand(); ?>" type="text/javascript"></script>

    <meta charset="utf-8">
    <title> WebApp</title>

    <style media="screen">
      .mce-item-table, .mce-item-table td, .mce-item-table th, .mce-item-table caption{
          border: 0 solid #111;
         cellspacing:0;
      }
    </style>
  </head>
