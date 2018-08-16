<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once ('spout/src/Spout/Autoloader/autoload.php');
use Box\Spout\Writer\WriterFactory;
use Box\Spout\Common\Type;
use Box\Spout\Writer\Style\StyleBuilder;
use Box\Spout\Writer\Style\Color;
use Box\Spout\Reader\ReaderFactory;

function genHojaCalculo($datos, $cabeceras , $filePath = './uploads/informeFacturacion.xlsx' ){
  $writer = WriterFactory::create(Type::XLSX); // for XLSX files
  //$writer = WriterFactory::create(Type::CSV); // for CSV files
  //$writer = WriterFactory::create(Type::ODS); // for ODS files
  $writer->openToFile($filePath); // write data to a file or to a PHP stream
  //$writer->openToBrowser($fileName); // stream data directly to the browser
  $style = (new StyleBuilder())->setFontBold()->build();
	$writer->addRowWithStyle($cabeceras, $style);
  foreach ($datos as $key => $value ) {
    if ($value['facturable'] == 'SI' && $value['cantidad_total'] != 0) {
			$value['valor_total'] = $value['tarifa'] * $value['cantidad_total'];
      $value['cantidad_total'] = $value['cantidad_total'] *1;
			$value['a'] = $value['valor_total'] * 0.18;
			$value['i'] = $value['valor_total'] * 0.01;
			$value['u'] = $value['valor_total'] * 0.04;
			$value['total'] = $value['a'] + $value['i'] + $value['u'] + $value['valor_total'];
      $value['tarifa'] = $value['tarifa']*1;
		}else{
      $value['cantidad_total'] = $value['cantidad_total']*1;
      $value['tarifa'] = $value['tarifa']*1;
		}
    $value['fecha_reporte'] = 25569 + ( strtotime( $value['fecha_reporte'] ) / 86400 );
    $writer->addRow($value); // add a row at a time
  }
  //$writer->addRows($multipleRows); // add multiple rows at a time
  $writer->close();

}


function readXlsx($path='', $super=NULL, $methodname=NULL)
{
  $reader = ReaderFactory::create(Type::XLSX);
  $reader->open($path);
  if ( isset($super) && isset($methodname)) {
    $sheets = array();
    foreach ($reader->getSheetIterator() as $sheet) {
        $j=0;
        foreach ($sheet->getRowIterator() as $row) {
          $super->$methodname($row);
          if($j > 100000)
            break;
        }
    }
    $reader->close();
    return $sheets;
  }
  return $reader;
}

function genObservaciones($rows){
  $writer = WriterFactory::create(Type::XLSX);
  $writer->openToBrowser('Observaciones.xlsx');
  $style = (new StyleBuilder())->setFontBold()->build();
	$writer->addRowWithStyle( array("Orden de trabajo","Fecha de reporte","Observaciones","tipo"), $style);
  foreach ($rows->result() as $key => $observes) {
    $fila['nombre_ot'] = $observes->nombre_ot;
    $fila['fecha_reporte'] = $observes->fecha_reporte;
    $json_r = json_decode($observes->json_r);
    foreach ($json_r->observaciones as $key => $obs) {
      $fila['observaciones'] = $obs->msj;
      $fila['tipo'] = "observacion";
      $writer->addRow($fila);
    }
    if (isset($json_r->actividades)) {
      foreach ($json_r->actividades as $key => $obs) {
        $fila['observaciones'] = $obs->msj;
        $fila['tipo'] = "actividad";
        $writer->addRow($fila);
      }
    }
  }
  $writer->close();
}

// -------------------------------------
// getting for external construction
function getReader($value='')
{
  return ReaderFactory::create(Type::XLSX);
}
function getWriter(){
  return WriterFactory::create(Type::XLSX);
}
function getStyleBuilder(){
  return new StyleBuilder();
}
function getStyleFont($r, $g, $b){
  return (new StyleBuilder())->setFontColor(Color::rgb($r,$g,$b))->setFontBold()->build();
}
