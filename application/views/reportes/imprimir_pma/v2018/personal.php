<table border="1" class="font7 texto-central" >
  <thead style="background: #FEFEFE">
    <tr>
      <th colspan="36">PERSONAL</th>
    </tr>
    <tr>
      <th colspan="1" rowspan="2" >REF.</th>
      <th colspan="3" rowspan="2" >CODIGO</th>
      <th colspan="5" rowspan="2" >CEDULA</th>
      <th colspan="9" rowspan="2" >NOMBRE Y APELLIDO</th>
      <th colspan="5" rowspan="2" >CARGO</th>
      <th colspan="2" rowspan="2" >BASE</th>
      <th colspan="2" >PERSONAL</th>
      <th colspan="4" >HORARIO</th>
      <th colspan="1" rowspan="2" >THA  <div>(S/N)</div> </th>
      <th colspan="2" rowspan="2" >RACION</th>
      <th colspan="2" >VIATICOS</th>
    </tr>
    <tr>
      <th>B/V</th>
      <th>N</th>
      <th nowrap="nowrap" colspan="2">H. Inicio</th>
      <th nowrap="nowrap" colspan="2">H. Final</th>
      <th>P/R</th>
      <th>Lugar</th>
    </tr>
  </thead>
  <tbody>

    <?php
    $x = 1;
    foreach ($recursos->personal as $key => $p): ?>
    <tr>
      <td colspan="1"> <?=  $x++; ?> </td>
      <td colspan="3"> <?= $p->itemc_item ?> </td>
      <td colspan="5"> <?= $p->identificacion ?> </td>
      <td colspan="9"> <?= $p->nombre_completo ?> </td>
      <td colspan="5"> <?= $p->descripcion ?> </td>
      <td colspan="2"> <?= (isset($p->procedencia) && $p->procedencia!='' )?$p->procedencia:$r->nombre_base ?> </td>
      <td colspan="1"> <?= $p->BO=='B'?'B':'V'; ?> </td>
      <td colspan="1"> <?= $p->facturable?'':'N'; ?> </td>
      <td colspan="2" class="table-container">
        <table class="no-border texto-central">
          <tr>
            <td style="border-bottom: 1px solid #555;"><?= $p->hora_inicio ?></td>
          </tr>
          <tr>
            <td><?= $p->hora_inicio2 ?></td>
          </tr>
        </table>
      </td>
      <td colspan="2" class="table-container">
        <table class="no-border texto-central">
          <tr>
            <td style="border-bottom: 1px solid #555;"><?= $p->hora_fin ?></td>
          </tr>
          <tr>
            <td><?= $p->hora_fin2 ?></td>
          </tr>
        </table>
      </td>
      <td colspan="1"> <?= $p->hr_almuerzo?'S':'N' ?> </td>
      <td colspan="2"> <?= $p->racion ?> </td>
      <td colspan="1"> <?= $p->gasto_viaje_pr ?> </td>
      <td colspan="1"> <?= $p->gasto_viaje_lugar ?> </td>
    </tr>
    <?php endforeach; ?>

    <?php
    for ($i=0; $i <= ( 18-sizeof($recursos->personal) ) ; $i++) {
    ?>
    <tr>
      <td colspan="1"> - </td>
      <td colspan="3"></td>
      <td colspan="5"></td>
      <td colspan="9"></td>
      <td colspan="5"></td>
      <td colspan="2"></td>
      <td colspan="1"></td>
      <td colspan="1"></td>
      <td colspan="2"></td>
      <td colspan="2"></td>
      <td colspan="1"></td>
      <td colspan="2"></td>
      <td colspan="1"></td>
      <td colspan="1"></td>
    </tr>
    <?php
    }
    ?>
    <tr>
      <td colspan="36" class="font6">
        Convenciones para novedadesd del personal: B: Basico/ O: Opcional / N: No Facturable/ D: Descanso/ DC: Descanso compensario/ A: Ausente sin permiso/ I: Incapacidad por accidente de trabajo/
        IC: incapacidad por emfermedad común/ S: Sancionado/ ACSP: Ausente con permiso sin pago/ ACCP: Ausente con permiso con pago/ V: Vacaciones/ THA (S/N): Tomo hora de almuerzo (SI/NO) / P: Pernoctó/ R: Retornó
      </td>
    </tr>
  </tbody>
</table>
