<!DOCTYPE html>
<html>
  <?php
    $this->load->view('inicio/head');
  ?>
  <body>
    <div ng-app="myapp" ng-controller="tabs">
      <?php
      $this->load->view('inicio/nav');

      echo $content;

      $this->load->view('inicio/footer');
      ?>
    </div>
  </body>
</html>
