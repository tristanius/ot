<div class="page_break"></div>
<table border="1">
  <tbody>
    <tr>
      <td colspan="4" class="centrar"><b>No. OT SAP:</b></td>
      <td colspan="5"><?= $r->sap_tarea ?></td>
      <td colspan="26"></td>
    </tr>
    <?php $this->load->view('reportes/imprimir_pma/rd/info_actividad', array('title'=>'ACTIVIDAD 1', 'data'=>NULL ) ); ?>
    <tr>
      <td colspan="13" class="centrar"><b>ILICITOS</b></td>
      <td colspan="22" class="centrar"><b>CANTIDADES DE OBRAS EJECUTADAS</b></td>
    </tr>
    <tr style="font-size: 7px">
      <td colspan="13">
        <table class="sinborde">
        <tr>
          <td class="sinborde">EXTENSION:</td>
          <td colspan="2"> &nbsp;&nbsp; </td>
          <td class="sinborde"></td>
          <td class="sinborde"> DIAMETRO</td>
          <td colspan="2"> &nbsp;&nbsp; </td>
          <td class="sinborde"></td>
          <td class="sinborde"> LONGITUD</td>
          <td colspan="2"> &nbsp;&nbsp; </td>
          <td class="sinborde"></td>
          <td class="sinborde"> MATERIAL</td>
          <td colspan="2"> &nbsp;&nbsp; </td>
          <td class="sinborde"></td>
        </tr>
        </table>
      </td>
      <td colspan="2" class="centrar">ITEM</td>
      <td colspan="12" class="centrar">DESCRIPCIÓN ACTIVIDAD DE MANTENIMIENTO</td>
      <td colspan="2" class="centrar">UNIDAD</td>
      <td colspan="3" class="centrar">CANTIDAD DIA</td>
      <td colspan="3" class="centrar">CANTIDAD ACUMULADA</td>
    </tr>
    <tr style="font-size: 7px">
      <th colspan="13">REPARACIÓN</th>
      <td colspan="2"></td>
      <td colspan="12"></td>
      <td colspan="2"></td>
      <td colspan="3"></td>
      <td colspan="3"></td>
    </tr>
    <tr style="font-size: 7px">
      <td colspan="6">COORDENADAS GPS</td>
      <td colspan="5">ANILLO CIRCUNFERENCIAL</td><td colspan="2"></td>
      <td colspan="2"></td>
      <td colspan="12"></td>
      <td colspan="2"></td>
      <td colspan="3"></td>
      <td colspan="3"></td>
    </tr>
    <tr style="font-size: 7px">
      <td colspan="6">NORTE (N):</td>
      <td colspan="5">CAMBIO TRAMO</td><td colspan="2"></td>
      <td colspan="2"></td>
      <td colspan="12"></td>
      <td colspan="2"></td>
      <td colspan="3"></td>
      <td colspan="3"></td>
    </tr>
    <tr style="font-size: 7px">
      <td colspan="6">ESTE (W):</td>
      <td colspan="5">RETIRO DE GRAPA</td><td colspan="2"></td>
      <td colspan="2"></td>
      <td colspan="12"></td>
      <td colspan="2"></td>
      <td colspan="3"></td>
      <td colspan="3"></td>
    </tr>

    <?php $this->load->view('reportes/imprimir_pma/rd/info_actividad', array('title'=>'ACTIVIDAD 2', 'data'=>NULL ) ); ?>

    <tr>
      <td colspan="13" class="centrar"><b>ILICITOS</b></td>
      <td colspan="22" class="centrar"><b>CANTIDADES DE OBRAS EJECUTADAS</b></td>
    </tr>
    <tr style="font-size: 7px">
      <td colspan="13">
        <table class="sinborde">
        <tr>
          <td class="sinborde">EXTENSION:</td>
          <td colspan="2"> &nbsp;&nbsp; </td>
          <td class="sinborde"></td>
          <td class="sinborde"> DIAMETRO</td>
          <td colspan="2"> &nbsp;&nbsp; </td>
          <td class="sinborde"></td>
          <td class="sinborde"> LONGITUD</td>
          <td colspan="2"> &nbsp;&nbsp; </td>
          <td class="sinborde"></td>
          <td class="sinborde"> MATERIAL</td>
          <td colspan="2"> &nbsp;&nbsp; </td>
          <td class="sinborde"></td>
        </tr>
        </table>
      </td>
      <td colspan="2" class="centrar">ITEM</td>
      <td colspan="12" class="centrar">DESCRIPCIÓN ACTIVIDAD DE MANTENIMIENTO</td>
      <td colspan="2" class="centrar">UNIDAD</td>
      <td colspan="3" class="centrar">CANTIDAD DIA</td>
      <td colspan="3" class="centrar">CANTIDAD ACUMULADA</td>
    </tr>
    <tr style="font-size: 7px">
      <th colspan="13">REPARACIÓN</th>
      <td colspan="2"></td>
      <td colspan="12"></td>
      <td colspan="2"></td>
      <td colspan="3"></td>
      <td colspan="3"></td>
    </tr>
    <tr style="font-size: 7px">
      <td colspan="6">COORDENADAS GPS</td>
      <td colspan="5">ANILLO CIRCUNFERENCIAL</td><td colspan="2"></td>
      <td colspan="2"></td>
      <td colspan="12"></td>
      <td colspan="2"></td>
      <td colspan="3"></td>
      <td colspan="3"></td>
    </tr>
    <tr style="font-size: 7px">
      <td colspan="6">NORTE (N):</td>
      <td colspan="5">CAMBIO TRAMO</td><td colspan="2"></td>
      <td colspan="2"></td>
      <td colspan="12"></td>
      <td colspan="2"></td>
      <td colspan="3"></td>
      <td colspan="3"></td>
    </tr>
    <tr style="font-size: 7px">
      <td colspan="6">ESTE (W):</td>
      <td colspan="5">RETIRO DE GRAPA</td><td colspan="2"></td>
      <td colspan="2"></td>
      <td colspan="12"></td>
      <td colspan="2"></td>
      <td colspan="3"></td>
      <td colspan="3"></td>
    </tr>

    <tr class="trLimpia"><td colspan="35"></td></tr>
    <tr class="trLimpia"><td colspan="35"></td></tr>
    <tr><td colspan="35">OBSERVACIONES: </td></tr>

    <?php foreach ($json_r->observaciones as $key => $obs): ?>
    <tr><td colspan="35"> <?= $obs->msj ?> </td></tr>
    <?php endforeach; ?>

    <tr><td colspan="35"></td></tr>
    <tr>
      <td colspan="23"  class="centrar"><b>CONTRATISTA</b></td>
      <td colspan="12"  class="centrar"><b>ECOPETROL</b></td>
    </tr>
    <tr>
      <td colspan="12">
        <table  class="sinborde">
        <tr>
          <td colspan="2" rowspan="3" class="sinborde">ELABORADO</td>
          <td colspan="4" class="sinborde"><p>NOMBRE</p></td>
          <td colspan="6" class="sinborde">______________________________________________</td>
        </tr>
        <tr>
          <td colspan="4" class="sinborde"><p>CARGO</p></td>
          <td colspan="6" class="sinborde">______________________________________________</td>
        </tr>
        <tr>
          <td colspan="4" class="sinborde"><p>FIRMA</p></td>
          <td colspan="6" class="sinborde">______________________________________________</td>
        </tr>
        </table>
      </td>
      <td colspan="11">
        <table class="sinborde">
        <tr>
          <td colspan="2" rowspan="3" class="sinborde">REVISADO</td>
          <td colspan="4" class="sinborde"><p>NOMBRE</p></td>
          <td colspan="5" class="sinborde">______________________________________________</td>
        </tr>
        <tr>
          <td colspan="4" class="sinborde"><p>CARGO</p></td>
          <td colspan="5" class="sinborde">______________________________________________</td>
        </tr>
        <tr>
          <td colspan="4" class="sinborde"><p>FIRMA</p></td>
          <td colspan="5" class="sinborde">______________________________________________</td>
        </tr>
        </table>
      </td>
      <td colspan="12">
        <table class="sinborde">
        <tr>
          <td colspan="2" rowspan="3" class="sinborde">APROBO</td>
          <td colspan="4" class="sinborde"><p>NOMBRE</p></td>
          <td colspan="6" class="sinborde">______________________________________________</td>
        </tr>
        <tr>
          <td colspan="4" class="sinborde"><p>CARGO</p></td>
          <td colspan="6" class="sinborde">______________________________________________</td>
        </tr>
        <tr>
          <td colspan="4" class="sinborde"><p>FIRMA</p></td>
          <td colspan="6" class="sinborde">______________________________________________</td>
        </tr>
        </table>
      </td>
    </tr>

  </tbody>
  <tfoot>
  <tr>
    <td colspan="35" class="centrar">
      Con la firma del presente formato el trabajador reconoce haber sido notificado previamente  en los términos de ley de las horas ordinarias  y horas extras
      (cuando se aplique) acá reportadas.
    </td>
  </tr>
  <tr>
    <td colspan="35" class="centrar">
      Nota de propiedad: Los derechos de propiedad intelectual sobre este documento y su contenido le pertenecen exclusivamente al CONSORCIO PIPELINE MAINTENANCE ALLIANCE (PMA).
      Por lo tanto, queda estrictamente prohibido el uso, divulgación, distribución, reproducción, modificación y/o alteración de los mencionados derechos,
      con fines distintos a los previstos en este documento, sin la autorización previa y escrita del consorcio.
    </td>
  </tr>
  </tfoot>
</table>
