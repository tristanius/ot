<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


function combinarEquiposReporte($equipos, $apu)
{
  $n_eqs = sizeof($equipos);
  $n_apu =  sizeof($apu);
  $i = 0;
  $rows = array();
  if ($n_eqs >= $n_apu ) {
    $i = $n_eqs;
  }else{
    $i = $n_apu;
  }
  for ($j=0 ; $j < $i ; $j++ ) {
    $r = array();
    if ( $n_eqs > $j && $equipos[$j]->facturable || $equipos[$j]->print) {
      $r['e'] = $equipos[$j];
    }
    if ( $n_apu > $j ) {
      $r['a'] = $apu[$j];
    }
    array_push($rows, $r);
  }
  return $rows;
}

function getFechaLarga($fecha)
{
  $meses = array(
    1 => 'Enero',
    2 => 'Febrero',
    3 => 'Marzo',
    4 => 'Abril',
    5 => 'Mayo',
    6 => 'Junio',
    7 => 'Julio',
    8 => 'Agosto',
    9 => 'Septiembre',
    10 => 'Octubre',
    11 => 'Noviembre',
    12 => 'Diciembre',
  );
  $diasSem = array(
    0=>'Domingo',
    1=>'Lunes',
    2=>'Martes',
    3=>'Miercoles',
    4=>'Jueves',
    5=>'Viernes',
    6=>'Sabado'
  );
  $time = strtotime($fecha);
  return $diasSem[ date('w', $time) ].', '.date('d', $time).' de '.$meses[ date('n', $time) ].' del año '.date('Y', $time);
}
