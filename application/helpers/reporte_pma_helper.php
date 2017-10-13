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
    if ( $n_eqs > $j ) {
      $r['e'] = $equipos[$j];
    }
    if ( $n_apu > $j ) {
      $r['a'] = $apu[$j];
    }
    array_push($rows, $r);
  }
  return $rows;
}
