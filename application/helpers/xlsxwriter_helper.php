<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once('XLSXWriter/xlsxwriter.class.php');

function getWriter(){
  return new XLSXWriter();
}

function write_xlsx($data=NULL, $headers=NULL, $file)
{
  $writer = new XLSXWriter();
  $writer->writeSheetRow('informeProducción', $headers);
  foreach($data as $row){
    if( isset($row['cantidad_total']) ){
      $row['cantidad_total'] = $row['cantidad_total']*1;
    }
    if( isset($row['cantidad']) ){
      $row['cantidad'] = $row['cantidad']*1;  
    }
    if( $row['fecha_reporte'] ){
      $row['fecha_reporte'] = 25569 + ( strtotime( $row['fecha_reporte'] ) / 86400 );
    }
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

function xlsx($data, $headers, $file, $sheet="sabanaFactura", $num_validations=NULL)
{
  $writer = new XLSXWriter();
  //$writer->writeSheet($data);
  $writer->writeSheetRow($sheet, $headers, array('fill'=>'#00BCD4', 'border'=>'left,right,top,bottom', 'font-style'=>'bold'));
  foreach($data as $row){
    if ($num_validations!=NULL) {
      foreach ($num_validations as $key => $val) {
        if ( isset($row[$val]) ) {
          $row[$val] = $row[$val]*1;
        }
      }
    }
    $writer->writeSheetRow($sheet, $row);
  }
  $writer->writeToFile($file);
}
