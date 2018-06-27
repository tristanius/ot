<!DOCTYPE html>
<html>
  <?php
    $this->load->view('inicio/head');
  ?>
  <body>
    <div ng-app="myapp" ng-controller="tabs">
      <?php
      $this->load->view('inicio/nav');
      $this->load->view('inicio/menu/sidenav');

      echo $content;

      $this->load->view('inicio/footer');
      ?>
    </div>
  </body>
</html>
