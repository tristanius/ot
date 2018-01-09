  <thead>
    <tr>
      <th colspan="36">PERSONAL</th>
    </tr>
    <tr>
      <th colspan="1" rowspan="2" >No.</th>
      <th colspan="3" rowspan="2" >Codigo</th>
      <th colspan="5" rowspan="2" >Identificacion</th>
      <th colspan="9" rowspan="2" >Nombre Completo</th>
      <th colspan="5" rowspan="2" >Cargo</th>
      <th colspan="2" rowspan="2" >Base</th>
      <th colspan="2" >Personal</th>
      <th colspan="4" >Horario</th>
      <th colspan="1" rowspan="2" >THA  <div>(S/N)</div> </th>
      <th colspan="2" rowspan="2" >Racion</th>
      <th colspan="2" >Viaticos</th>
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
    for ($i=0; $i <= ( 18-sizeof($recursos->actividades) ) ; $i++) {
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
    <tr class="noborder" style="height:0px; padding:0px;">
      <?php
      for ($i=0; $i <= 35; $i++) {
      ?>
      <td style="height:0px; padding:0px;"> </td>
      <?php
      }
      ?>
    </tr>
  </tbody>
