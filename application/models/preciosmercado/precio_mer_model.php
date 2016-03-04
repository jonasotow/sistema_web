<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Precio_Mer_Model extends My_Model {
    
    public function __construct()
    {
        parent::__construct();
    }
    
    public function tipo()
    {
        $this->db->order_by('tipo','asc');
        $tipo = $this->db->get('tipo');
        if($tipo->num_rows()>0)
        {
            return $tipo->result();
        }
    }
    
    public function clase($tipo)
    {
        $this->db->select('clase.idclase,clase.clase');
        $this->db->from('clase');
        $this->db->join('tipo_x_clase', 'tipo_x_clase.idclase = clase.idclase');
        $this->db->where('tipo_x_clase.idtipo',$tipo);
        $query = $this->db->get();
        
        if($query->num_rows()>0)
        {
            //retorna o resultado
    		return $query->result();
        }
    }
    
    public function region($clase)
    {
        $this->db->select('region.idregion,region.region');
        $this->db->from('region');
        $this->db->join('clase_x_region_fuente','clase_x_region_fuente.idregion = region.idregion');
        $this->db->join('tipo_x_clase','tipo_x_clase.idclase = clase_x_region_fuente.idtipo_clase');
        $this->db->where('tipo_x_clase.idclase', $clase);
        $this->db->group_by('region.idregion');
        $query = $this->db->get();
        
		if($query->num_rows()>0)
        {
            //retorna o resultado
    		return $query->result();
        }
    }
    
    public function fuente($region,$clase)
    {
        $this->db->select('fuente.idfuente,fuente.fuente');
        $this->db->from('fuente');
        $this->db->join('clase_x_region_fuente','clase_x_region_fuente.idfuente = fuente.idfuente');
        $this->db->join('tipo_x_clase','tipo_x_clase.idtipo_clase = clase_x_region_fuente.idtipo_clase');
        $this->db->where("clase_x_region_fuente.idregion = '$region' and tipo_x_clase.idclase = '$clase'");
        $query = $this->db->get();
        
		if($query->num_rows()>0)
        {
            //retorna o resultado
    		return $query->result();
        }
    }

    public function obtener_registros_capturados($tipo,$clase,$region,$fuente){
        $this->db->select('tipo_x_clase.idtipo_clase,clase_x_region_fuente.idclase_region_fuente,tipo.tipo,clase.clase,region.region,fuente.fuente');
        $this->db->from('clase');
        $this->db->join('tipo_x_clase','tipo_x_clase.idclase = clase.idclase');
        $this->db->join('clase_x_region_fuente','clase_x_region_fuente.idtipo_clase = tipo_x_clase.idtipo_clase');
        $this->db->join('tipo','tipo.idtipo = tipo_x_clase.idtipo');
        $this->db->join('region','region.idregion = clase_x_region_fuente.idregion');
        $this->db->join('fuente','fuente.idfuente = clase_x_region_fuente.idfuente');
        $this->db->where("tipo.idtipo = '$tipo' and region.idregion = '$region' and fuente.idfuente = '$fuente' and clase.idclase = '$clase'");
        $query = $this->db->get();

        if($query->num_rows() > 0 )
        {
            //veamos que sólo retornamos una fila con row(), no result()
            return $query->row();
        }
    }

    public function obtener_compras($idtipo_clase,$idclase_region_fuente){
        $this->db->select('precio,tipo_cambio,fecha');
        $this->db->from('registros_compras');
        $this->db->where("idclase_region_fuente = '$idclase_region_fuente'");
        $query = $this->db->get();
        
        if($query->num_rows()>0)
        {
            //retorna o resultado
            return $query->result();
        }
    }

    public function insertar_compra($idtipo_clase,$idclase_region_fuente,$tipo_cambio,$precio,$fecha){
        list($dia, $mes, $anio) = explode("/",$fecha);
        $fecha_formateada = $anio."/".$mes."/".$dia;

        $this->db->select('idregistro');
        $this->db->from('registros_compras');
        $this->db->where("idclase_region_fuente = '$idclase_region_fuente' and fecha = '$fecha_formateada'");
        $query = $this->db->get();

        if($query->num_rows() == 0){

            $data = array(
                'idclase_region_fuente' => $idclase_region_fuente,
                'tipo_cambio' => $tipo_cambio,
                'precio' => $precio,
                'fecha' => $anio."/".$mes."/".$dia);

            $this->db->insert('registros_compras',$data);
        } else {
            $data = array(
                'tipo_cambio' => $tipo_cambio,
                'precio' => $precio);
            $this->db->where('fecha', $anio."/".$mes."/".$dia);

            $this->db->where('idclase_region_fuente' , $idclase_region_fuente);
            $this->db->update('registros_compras',$data);
        }
    }

    public function validar_registro($idclase_region_fuente,$fecha){
        list($dia, $mes, $anio) = explode("/",$fecha);

        $this->db->select("COUNT(*)");
        $this->db->from("registros_compras");
        $this->db->where("idclase_region_fuente",$idclase_region_fuente);
        $this->db->where("fecha", $anio."/".$mes."/".$dia);
        $query = $this->db->get(); 

        return $query->result();
    }
}