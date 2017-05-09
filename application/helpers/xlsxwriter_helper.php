<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once('XLSXWriter/xlsxwriter.class.php');
function write_xlsx($data=NULL, $headers=NULL, $file)
{
  $writer = new XLSXWriter();
  $writer->writeSheetRow('informeProducción', $headers);
  foreach($data as $row){
    $row['cantidad_total'] = $row['cantidad_total']*1;
    $row['fecha_reporte'] = 25569 + ( strtotime( $row['fecha_reporte'] ) / 86400 );
    $writer->writeSheetRow('informeProducción', $row);
  }
  $writer->writeToFile($file);
}

function xlsx_export($data, $headers, $file)
{
  $writer = new XLSXWriter();
  //$writer->writeSheet($data);
  $writer->writeSheetRow('sabanaFactura', $headers);
  foreach($data as $row){
    $row['fecha_reporte'] = 25569 + ( strtotime( $row['fecha_reporte'] ) / 86400 );
    $writer->writeSheetRow('sabanaFactura', $row);
  }
  $writer->writeToFile($file);
}

function xlsx($data, $headers, $file, $sheet="sabanaFactura")
{
  $writer = new XLSXWriter();
  //$writer->writeSheet($data);
  $writer->writeSheetRow($sheet, $headers, array('fill'=>'#00BCD4', 'border'=>'left,right,top,bottom', 'font-style'=>'bold'));
  foreach($data as $row){
    $writer->writeSheetRow($sheet, $row);
  }
  $writer->writeToFile($file);
}
