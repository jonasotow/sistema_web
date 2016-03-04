<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Estados_Model extends My_Model {
    public $table;

    /**
     * Carga todo las funciones que tiene disponible CI_Model propia de codeigniter
     */
    function __construct($db = null) {
        // llamma el Modelo constructor
        parent::__construct($db);
        $this->load->model('usuarios/usuarios_model','oCliente',FALSE,'usuarios');
    }

    public function Encabezado($cliente) {
        $db2 = $this->load->database('panel_vimifos', TRUE); 
        if(substr($cliente,0,1) == "G"){
            $db2->select("fechacorte, SUM(montocredito) AS montocredito, SUM(diascredito) AS diascredito, domicilio, ciudad, municipio, pais, cp, SUM(saldoamovs) AS saldoamovs, SUM(creditos) AS creditos, SUM(saldoactual) AS saldoactual, SUM(nuevoscargos) AS nuevoscargos, SUM(facturasdlls) AS facturasdlls, SUM(saldodlls) AS saldodlls, SUM(facturaspesos) AS facturaspesos, SUM(saldopesos) AS saldopesos"); 
            $db2->from('edocta');
            $db2->where("grupo = '$cliente'"); 
        } else{
            $db2->select("*"); 
            $db2->from('edocta');
            $db2->where("idcliente = '$cliente'"); 
        }
        $query = $db2->get(); 
        if ($query->num_rows() > 0)  
            return $query->row(0); 
        else  
            return false; 
    }

     public function TipoCambio() {
        $db2 = $this->load->database('panel_vimifos', TRUE); 
        $db2->select("*"); 
        $db2->from('edocta'); 
        $query = $db2->get(); 
        if ($query->num_rows() > 0)  
            return $query->row(0); 
        else  
            return false; 
    }

    public function Contenido($por_pagina,$segmento,$cliente,$moneda) {
        $db2 = $this->load->database('panel_vimifos', TRUE); 
        $db2->select("*"); 
        $db2->from('edoctadesc'); 
        if(substr($cliente,0,1) == "G"){
            $db2->join('edocta','edocta.idcliente = edoctadesc.idcliente');
            $db2->where("edocta.grupo = '$cliente' and edoctadesc.moneda like '%$moneda%'");
        }else{
            $db2->where("idcliente = '$cliente' and moneda like '%$moneda%'");
        }
        $db2->order_by('emision','ASC');
        $db2->limit($por_pagina,$segmento);
        $query = $db2->get(); 
         if($query->num_rows()>0)
        {
            //retorna o resultado
            return $query->result();
        }
    }

   public function filas($cliente,$moneda){
        $db2 = $this->load->database('panel_vimifos', TRUE); 
        $db2->select("*"); 
        $db2->from('edoctadesc'); 
        if(substr($cliente,0,1) == "G"){
            $db2->join('edocta','edocta.idcliente = edoctadesc.idcliente');
            $db2->where("edocta.grupo = '$cliente' and edoctadesc.moneda like '%$moneda%'");
        }else{
            $db2->where("idcliente = '$cliente' and moneda like '%$moneda%'");
        }
        $query = $db2->get(); 
         if($query->num_rows()>0)
        {
            //retorna o resultado
            return $query->num_rows();
        }
    }

    public function cliente($id_relacion) {
        return $this->oCliente->find('first',array(
                'field' => array('usu_usuario,usu_email,usu_id'),
                'conditions' => array('usu_id' => $id_relacion, 'usu_estatus' => 1)
            )); 
    }
}