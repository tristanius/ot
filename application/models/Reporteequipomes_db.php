<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reporteequipomes_db extends CI_Model{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }

  # =============================================================================================
  # CONSULTAS
  # =============================================================================================
  # Consultar Reporte por fecha y OT
  public function getBy($fechai=NULL, $fechaf=NULL)
  {
    $this->load->database('ot');
    $temp = 'select * from reporte_diario where fecha_reporte between "'.$fechai.'" and "'.$fechaf.'"';
    return $this->db->query($temp);
  }

  # consulta horas operativas
  public function getHorasOper($fechai=NULL, $fechaf=NULL,$laBase=NULL)
  {
    $tmp_base = !empty($laBase)?"OT.base_idbase=".$laBase:"";
    $this->load->database('ot');
    $this->db->select(
      'OT.base_idbase as base,
      rrd.itemf_codigo as codigo,
      e.codigo_siesa,
      descripcion,
      sum(horas_operacion*(1-abs(sign(day(fecha_reporte)-1))))  as d01,
      sum(horas_operacion*(1-abs(sign(day(fecha_reporte)-2))))  as d02,
      sum(horas_operacion*(1-abs(sign(day(fecha_reporte)-3))))  as d03,
      sum(horas_operacion*(1-abs(sign(day(fecha_reporte)-4))))  as d04,
      sum(horas_operacion*(1-abs(sign(day(fecha_reporte)-5))))  as d05,
      sum(horas_operacion*(1-abs(sign(day(fecha_reporte)-6))))  as d06,
      sum(horas_operacion*(1-abs(sign(day(fecha_reporte)-7))))  as d07,
      sum(horas_operacion*(1-abs(sign(day(fecha_reporte)-8))))  as d08,
      sum(horas_operacion*(1-abs(sign(day(fecha_reporte)-9))))  as d09,
      sum(horas_operacion*(1-abs(sign(day(fecha_reporte)-10)))) as d10,
      sum(horas_operacion*(1-abs(sign(day(fecha_reporte)-11)))) as d11,
      sum(horas_operacion*(1-abs(sign(day(fecha_reporte)-12)))) as d12,
      sum(horas_operacion*(1-abs(sign(day(fecha_reporte)-13)))) as d13,
      sum(horas_operacion*(1-abs(sign(day(fecha_reporte)-14)))) as d14,
      sum(horas_operacion*(1-abs(sign(day(fecha_reporte)-15)))) as d15,
      sum(horas_operacion*(1-abs(sign(day(fecha_reporte)-16)))) as d16,
      sum(horas_operacion*(1-abs(sign(day(fecha_reporte)-17)))) as d17,
      sum(horas_operacion*(1-abs(sign(day(fecha_reporte)-18)))) as d18,
      sum(horas_operacion*(1-abs(sign(day(fecha_reporte)-19)))) as d19,
      sum(horas_operacion*(1-abs(sign(day(fecha_reporte)-20)))) as d20,
      sum(horas_operacion*(1-abs(sign(day(fecha_reporte)-21)))) as d21,
      sum(horas_operacion*(1-abs(sign(day(fecha_reporte)-22)))) as d22,
      sum(horas_operacion*(1-abs(sign(day(fecha_reporte)-23)))) as d23,
      sum(horas_operacion*(1-abs(sign(day(fecha_reporte)-24)))) as d24,
      sum(horas_operacion*(1-abs(sign(day(fecha_reporte)-25)))) as d25,
      sum(horas_operacion*(1-abs(sign(day(fecha_reporte)-26)))) as d26,
      sum(horas_operacion*(1-abs(sign(day(fecha_reporte)-27)))) as d27,
      sum(horas_operacion*(1-abs(sign(day(fecha_reporte)-28)))) as d28,
      sum(horas_operacion*(1-abs(sign(day(fecha_reporte)-29)))) as d29,
      sum(horas_operacion*(1-abs(sign(day(fecha_reporte)-30)))) as d30,
      sum(horas_operacion*(1-abs(sign(day(fecha_reporte)-31)))) as d31,
      rot.propietario_observacion AS asignacion,
      if(rot.propietario_recurso, "SI", "NO") AS propio,
      ft.nombre AS nombre_frente,
      OT.nombre_ot,
      e.responsable,
      sum(horas_disponible*(1-abs(sign(day(fecha_reporte)-1))))  as s01,
      sum(horas_disponible*(1-abs(sign(day(fecha_reporte)-2))))  as s02,
      sum(horas_disponible*(1-abs(sign(day(fecha_reporte)-3))))  as s03,
      sum(horas_disponible*(1-abs(sign(day(fecha_reporte)-4))))  as s04,
      sum(horas_disponible*(1-abs(sign(day(fecha_reporte)-5))))  as s05,
      sum(horas_disponible*(1-abs(sign(day(fecha_reporte)-6))))  as s06,
      sum(horas_disponible*(1-abs(sign(day(fecha_reporte)-7))))  as s07,
      sum(horas_disponible*(1-abs(sign(day(fecha_reporte)-8))))  as s08,
      sum(horas_disponible*(1-abs(sign(day(fecha_reporte)-9))))  as s09,
      sum(horas_disponible*(1-abs(sign(day(fecha_reporte)-10)))) as s10,
      sum(horas_disponible*(1-abs(sign(day(fecha_reporte)-11)))) as s11,
      sum(horas_disponible*(1-abs(sign(day(fecha_reporte)-12)))) as s12,
      sum(horas_disponible*(1-abs(sign(day(fecha_reporte)-13)))) as s13,
      sum(horas_disponible*(1-abs(sign(day(fecha_reporte)-14)))) as s14,
      sum(horas_disponible*(1-abs(sign(day(fecha_reporte)-15)))) as s15,
      sum(horas_disponible*(1-abs(sign(day(fecha_reporte)-16)))) as s16,
      sum(horas_disponible*(1-abs(sign(day(fecha_reporte)-17)))) as s17,
      sum(horas_disponible*(1-abs(sign(day(fecha_reporte)-18)))) as s18,
      sum(horas_disponible*(1-abs(sign(day(fecha_reporte)-19)))) as s19,
      sum(horas_disponible*(1-abs(sign(day(fecha_reporte)-20)))) as s20,
      sum(horas_disponible*(1-abs(sign(day(fecha_reporte)-21)))) as s21,
      sum(horas_disponible*(1-abs(sign(day(fecha_reporte)-22)))) as s22,
      sum(horas_disponible*(1-abs(sign(day(fecha_reporte)-23)))) as s23,
      sum(horas_disponible*(1-abs(sign(day(fecha_reporte)-24)))) as s24,
      sum(horas_disponible*(1-abs(sign(day(fecha_reporte)-25)))) as s25,
      sum(horas_disponible*(1-abs(sign(day(fecha_reporte)-26)))) as s26,
      sum(horas_disponible*(1-abs(sign(day(fecha_reporte)-27)))) as s27,
      sum(horas_disponible*(1-abs(sign(day(fecha_reporte)-28)))) as s28,
      sum(horas_disponible*(1-abs(sign(day(fecha_reporte)-29)))) as s29,
      sum(horas_disponible*(1-abs(sign(day(fecha_reporte)-30)))) as s30,
      sum(horas_disponible*(1-abs(sign(day(fecha_reporte)-31)))) as s31,
      sum(varado*(1-abs(sign(day(fecha_reporte)-1))))  as v01,
      sum(varado*(1-abs(sign(day(fecha_reporte)-2))))  as v02,
      sum(varado*(1-abs(sign(day(fecha_reporte)-3))))  as v03,
      sum(varado*(1-abs(sign(day(fecha_reporte)-4))))  as v04,
      sum(varado*(1-abs(sign(day(fecha_reporte)-5))))  as v05,
      sum(varado*(1-abs(sign(day(fecha_reporte)-6))))  as v06,
      sum(varado*(1-abs(sign(day(fecha_reporte)-7))))  as v07,
      sum(varado*(1-abs(sign(day(fecha_reporte)-8))))  as v08,
      sum(varado*(1-abs(sign(day(fecha_reporte)-9))))  as v09,
      sum(varado*(1-abs(sign(day(fecha_reporte)-10)))) as v10,
      sum(varado*(1-abs(sign(day(fecha_reporte)-11)))) as v11,
      sum(varado*(1-abs(sign(day(fecha_reporte)-12)))) as v12,
      sum(varado*(1-abs(sign(day(fecha_reporte)-13)))) as v13,
      sum(varado*(1-abs(sign(day(fecha_reporte)-14)))) as v14,
      sum(varado*(1-abs(sign(day(fecha_reporte)-15)))) as v15,
      sum(varado*(1-abs(sign(day(fecha_reporte)-16)))) as v16,
      sum(varado*(1-abs(sign(day(fecha_reporte)-17)))) as v17,
      sum(varado*(1-abs(sign(day(fecha_reporte)-18)))) as v18,
      sum(varado*(1-abs(sign(day(fecha_reporte)-19)))) as v19,
      sum(varado*(1-abs(sign(day(fecha_reporte)-20)))) as v20,
      sum(varado*(1-abs(sign(day(fecha_reporte)-21)))) as v21,
      sum(varado*(1-abs(sign(day(fecha_reporte)-22)))) as v22,
      sum(varado*(1-abs(sign(day(fecha_reporte)-23)))) as v23,
      sum(varado*(1-abs(sign(day(fecha_reporte)-24)))) as v24,
      sum(varado*(1-abs(sign(day(fecha_reporte)-25)))) as v25,
      sum(varado*(1-abs(sign(day(fecha_reporte)-26)))) as v26,
      sum(varado*(1-abs(sign(day(fecha_reporte)-27)))) as v27,
      sum(varado*(1-abs(sign(day(fecha_reporte)-28)))) as v28,
      sum(varado*(1-abs(sign(day(fecha_reporte)-29)))) as v29,
      sum(varado*(1-abs(sign(day(fecha_reporte)-30)))) as v30,
      sum(varado*(1-abs(sign(day(fecha_reporte)-31)))) as v31'
    );
    $this->db->from('recurso_reporte_diario AS rrd');
    $this->db->join('reporte_diario AS rd ', 'rd.idreporte_diario = rrd.idreporte_diario');
    $this->db->join('OT', 'OT.idOT = rd.OT_idOT');
    $this->db->join('recurso_ot AS rot ', 'rot.idrecurso_ot = rrd.idrecurso_ot');
    $this->db->join('recurso AS r', 'r.idrecurso = rot.recurso_idrecurso');
    $this->db->join('equipo AS e ', 'e.idequipo = r.equipo_idequipo');
    $this->db->join('frente_ot AS ft', 'ft.idfrente_ot = rrd.idfrente_ot', 'left');
    $this->db->where('fecha_reporte between "'.$fechai.'" and "'.$fechaf.'" ');
    if($tmp_base!=''){
      $this->db->where($tmp_base);
    }
    $this->db->group_by('e.codigo_siesa, OT.nombre_ot, ft.idfrente_ot');
    $this->db->order_by('e.codigo_siesa, OT.nombre_ot, base', 'asc');
    return $this->db->get();
  }
  # consulta horas operativas
  public function getPyco($fechai=NULL, $fechaf=NULL,$laBase=NULL)
  {
    $tmp_base=!empty($laBase)?"OT.base_idbase=".$laBase:"";
    $this->load->database('ot');
    $this->db->select(
      '"" as no,
      IF(locate("ALQ",e.referencia)=0,"TERMOTECNICA","ALQUILADO") as un,
      if(rrd.facturable,"TARIFA","A.P.U") as eltipo,
      fecha_reporte,
      OT.nombre_ot,
      ft.nombre AS nombre_frente,
      itc.item,
      e.codigo_siesa,
      e.descripcion,
      e.referencia,
      OT.base_idbase as co,
      upper(itf.unidad) as unidad,
      if(horas_operacion>0,1,"") as horas,
      "" as valor_horas,
      if(horas_disponible>0 and horas_operacion=0,1,"") as disponible,
      "" as valor_disponible,
      CONCAT(rrd.horometro_ini, "-", rrd.horometro_fin),
      ft.nombre AS frente,
      rot.propietario_observacion AS asignacion,
      if(rot.propietario_recurso, "SI", "NO") AS propio,
      rrd.combustible_cantidad,
      rrd.combustible_valor,
      rrd.combustible_und,'
    );
    $this->db->from('reporte_diario AS rd');
    $this->db->join('OT', 'OT.idOT = rd.OT_idOT');
    $this->db->join('recurso_reporte_diario AS rrd', 'rrd.idreporte_diario = rd.idreporte_diario');
    $this->db->join('itemf AS itf', 'itf.iditemf = rrd.itemf_iditemf');
    $this->db->join('itemc AS itc', 'itc.iditemc = itf.itemc_iditemc');
    $this->db->join('recurso_ot AS rot', 'rot.idrecurso_ot = rrd.idrecurso_ot');
    $this->db->join('recurso AS r', 'r.idrecurso = rot.recurso_idrecurso');
    $this->db->join('equipo AS e', 'e.idequipo = r.equipo_idequipo');
    $this->db->join('frente_ot AS ft', 'ft.idfrente_ot = rrd.idfrente_ot', 'left');
    $this->db->where('fecha_reporte between "'.$fechai.'" and "'.$fechaf.'" ');
    if($tmp_base!=''){$this->db->where($tmp_base);}
    $this->db->where('(rrd.horas_disponible + rrd.horas_operacion + rrd.cantidad) >0');
    $this->db->order_by('e.codigo_siesa,fecha_reporte', 'asc');
    return $this->db->get();
  }
}
