<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function readExcel($archivo='')
{
	include 'PHPExcel/PHPExcel/IOFactory.php';
	$objReader = PHPExcel_IOFactory::createReader('Excel2007');
	#$objReader->setReadDataOnly(true);
	$objPHPExcel = $objReader->load('./uploads/'.$archivo);
	$sheetData = $objPHPExcel->getActiveSheet();
	#$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
	#var_dump($sheetData);
	return $sheetData; // OJO ->toArray(null,true,true,true);
}

function getDateExcel($fecha){
	//return date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP( $fecha ));
	if( strpos($fecha,'-') != FALSE ){
		return date( 'Y-m-d', strtotime( $fecha ) );
	}elseif ( strpos($fecha,',') != FALSE ) {
		return date( 'Y-m-d', strtotime( $fecha ) );
	}else {
		return ($fecha - 25569) * 86400;
	}
}

function readExcelAlltypes($archivo='', $dataOnly=FALSE)
{
	include 'PHPExcel/PHPExcel/IOFactory.php';
	$reader = PHPExcel_IOFactory::createReaderForFile('./uploads/'.$archivo);
	if($dataOnly){$reader->setReadDataOnly(true);}
	$objPHPExcel = $reader->load('./uploads/'.$archivo);
	return  $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
	#$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
	#var_dump($sheetData);
}

function ubicarCabeceras($row, $cabeceras){	}

function informeFacturacion($datos, $cabeceras ){
	date_default_timezone_set('America/Bogota');
	require_once('PHPExcel/PHPExcel.php');
	$objPHPExcel = new PHPExcel();

	$fil=1;
	$col=0;
	foreach ( $cabeceras as $val) {
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($col, $fil, $val);
		$col++;
	}

	$fil= 2;
	$hoja = $objPHPExcel->getActiveSheet();
	foreach ($datos as $key => $value) {
		$col=0;
		if ($value['facturable'] == 'SI') {
			$value['valor_total'] = $value['tarifa'] * $value['cantidad_total'];
			$value['a'] = $value['valor_total'] * 0.18;
			$value['i'] = $value['valor_total'] * 0.01;
			$value['u'] = $value['valor_total'] * 0.04;
			$value['total'] = $value['a'] + $value['i'] + $value['u'] + $value['valor_total'];
		}else{
			$value['valor_total'] = 0;
			$value['a'] = 0;
			$value['i'] = 0;
			$value['u'] = 0;
			$value['total'] = 0;
		}
		$value['fecha_reporte'] = PHPExcel_Shared_Date::PHPToExcel( strtotime($value['fecha_reporte']) );
		//foreach ($value as $k => $v) {
			//$hoja->setCellValueByColumnAndRow($col, $fil, $v);
			//$col++;
		//}
		$hoja->fromArray($value, null, 'A'.$fil);
		$fil++;
	}

	$hoja->setTitle('Hoja');
	// Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
	$objPHPExcel->setActiveSheetIndex(0);
	// Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
	//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	//header('Content-Disposition: attachment;filename="informeFacturacion.xlsx"');
	//header('Cache-Control: max-age=0');

	$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
	//$objWriter->setPreCalculateFormulas(false);
	//$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
	//$objWriter->save('php://output');
	$objWriter->save('./uploads/informeFacturacion.xlsx');
	//exit;
}
