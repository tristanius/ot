<br>
<table border="1" id="personal">
  <thead>
    <tr>
      <th colspan="35">DATOS DEL PERSONAL, HORARIO TRABAJADO, RACIONES Y VIATICOS</th>
    </tr>
    <tr>
      <th colspan="2" rowspan="2">CODIGO</th>
      <th colspan="1" rowspan="2">CÉDULA</th>
      <th colspan="9" rowspan="2">NOMBRE</th>
      <th colspan="7" rowspan="2">CARGO</th>
      <th colspan="3" rowspan="2">BASE</th>
      <th colspan="2">Personal</th>
      <th colspan="4" >REPORTE DE TIEMPO LABORADO</th>
      <th colspan="1" rowspan="2">THA <br> (S/N)</th>
      <th colspan="1" rowspan="2">RACIÓN</th>
      <th colspan="5">VIATICOS</th>
    </tr>
    <tr>
      <th>Bas.</th>
      <th>Var.</th>
      <th colspan="2">H. INICIO</th>
      <th colspan="2">H. FINAL</th>
      <th>RETORNO</th>
      <th>PLENO</th>
      <th colspan="3">LUGAR</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($personal as $key => $p): ?>
      <tr>
        <td colspan="2" rowspan="2" ><?= $p->itemc_item ?></td>
  		  <td colspan="1" rowspan="2" ><?= $p->identificacion ?></td>
  		  <td colspan="9" rowspan="2" ><?= $p->nombre_completo ?></td>
        <td colspan="7" rowspan="2" ><?= $p->descripcion ?></td>
        <td colspan="3" rowspan="2" ></td>
        <td colspan="1" rowspan="2" ><?= $p->BO=='B'?'X':''; ?></td>
        <td colspan="1" rowspan="2" ><?= $p->BO=='O'?'X':''; ?></td>
        <td colspan="2" ><?= $p->hora_inicio ?></td>
        <td colspan="2" ><?= $p->hora_fin ?></td>
        <td colspan="1" rowspan="2" ><?= $p->hr_almuerzo?'SI':'NO' ?></td>
        <td colspan="1" rowspan="2" ><?= $p->racion ?></td>
        <td colspan="1" rowspan="2" ><?= $p->gasto_viaje_pr ?></td>
        <td colspan="1" rowspan="2" ></td>
        <td colspan="3" rowspan="2" ><?= $p->gasto_viaje_lugar ?></td>
      </tr>
      <tr>
        <td colspan="2"><?= $p->hora_inicio2 ?></td>
        <td colspan="2"><?= $p->hora_fin2 ?></td>
      </tr>
    <?php endforeach; ?>
    <?php
      for ($i=0; $i <= ( 12-sizeof($personal) ) ; $i++) {
      ?>
      <tr>
        <td colspan="2" rowspan="2" ></td>
  		  <td colspan="1" rowspan="2" ></td>
  		  <td colspan="9" rowspan="2" ></td>
        <td colspan="7" rowspan="2" ></td>
        <td colspan="3" rowspan="2" ></td>
        <td colspan="1" rowspan="2" ></td>
        <td colspan="1" rowspan="2" ></td>
        <td colspan="2" ></td>
        <td colspan="2" ></td>
        <td colspan="1" rowspan="2" ></td>
        <td colspan="1" rowspan="2" ></td>
        <td colspan="1" rowspan="2" ></td>
        <td colspan="1" rowspan="2" ></td>
        <td colspan="3" rowspan="2" ></td>
      </tr>
      <tr>
        <td colspan="2"></td>
        <td colspan="2"></td>
      </tr>
      <?php
      }
    ?>
  </tbody>
  <tfoot>
    <tr>
      <td colspan="4">Bas: Básico</td>
      <td colspan="1"></td>
      <td colspan="6">I: Incapacidad </td>
      <td colspan="4">HI: Hora de inicio</td>
      <td colspan="8">THA (S/N): Tomo Hora de Almuerzo (SI/NO)</td>
      <td colspan="6"></td>
      <td colspan="6"></td>
    </tr>
    <tr>
      <td colspan="4">Var: Variable</td>
      <td colspan="1"></td>
      <td colspan="6">ACCP: Ausente con permiso con pago</td>
      <td colspan="4">HF: Hora final</td>
      <td colspan="8"></td>
      <td colspan="6"></td>
      <td colspan="6"></td>
    </tr>
  </tfoot>
</table>
