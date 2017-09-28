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


function readXlsx($path='', $method=NULL)
{
  $init = date("Y-m-d H:i:s");
  $reader = ReaderFactory::create(Type::XLSX);
  $reader->open($path);
  $sheets = array();
  $i=0;
  $opened = date("Y-m-d H:i:s");
  foreach ($reader->getSheetIterator() as $sheet) {
      $i++;
      $j=0;
      foreach ($sheet->getRowIterator() as $row) {
        $j++;
        echo $j."<br>";
        if($j > 100000)
          break;
      }
  }
  array_push($sheets, array( 'sheet' =>$i , 'rows'=>$j, 'ini'=>$init, 'opened'=>$opened, 'end'=>date('Y-m-d H:i:s') ) );
  $reader->close();
  return $sheets;
}
