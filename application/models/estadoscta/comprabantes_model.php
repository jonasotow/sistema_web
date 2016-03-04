<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Comprabantes_Model extends My_Model {
    public $table;

    /**
     * Carga todo las funciones que tiene disponible CI_Model propia de codeigniter
     */
    function __construct($db = null) {
        // llamma el Modelo constructor
        parent::__construct($db);
        $this->load->model('usuarios/usuarios_model','oCliente',FALSE,'usuarios');
    }

    public function factura_pdfxml($idcomprobante) {
        $db2 = $this->load->database('facturas', TRUE); 
        $db2->select("id_archivo,id_comprobante,xxml,pdf");
        $db2->from('dbo.Archivo');
        $db2->where("id_comprobante = '$idcomprobante'"); 
        $query = $db2->get(); 
        if ($query->num_rows() > 0)  
            return $query->row(0); 
        else  
            return false; 
    }

    public function facturas_antiguas($clienterfc,$idcomprobante){
        $db = $this->load->database('business', TRUE); 
        $db->select("co.estatus,co.serie,co.folio,co.fecha"); 
        $db->from('dbo.Comprobante as co'); 
        $db->join('dbo.Receptor as re','co.id_Receptor = re.id_Receptor');
        $db->where("re.rfc = '$clienterfc' and co.id_Comprobante = '$idcomprobante'");
        $query = $db->get(); 
        if($query->num_rows()>0)
            return $query->row(0);
        else
            return false;
    }

    public function facturas_nuevas($clienterfc,$idcomprobante){
        $db = $this->load->database('facturas', TRUE); 
        $db->select("co.estatus,co.serie,co.folio,co.fecha"); 
        $db->from('dbo.Comprobante as co'); 
        $db->join('dbo.Receptor as re','co.id_Receptor = re.id_Receptor');
        $db->where("re.rfc = '$clienterfc' and co.id_Comprobante = '$idcomprobante'");
        $query = $db->get(); 
        if($query->num_rows()>0)
            return $query->row(0);
        else
            return false;
    }

    public function Encabezado($cliente) {
        $db2 = $this->load->database('panel_vimifos', TRUE); 
        $db2->select("*"); 
        $db2->from('edocta'); 
        $db2->where("idcliente = '$cliente'"); 
        $query = $db2->get(); 
        if ($query->num_rows() > 0)  
            return $query->row(0); 
        else  
            return false; 
    }

    public function obtenerrfc($cliente){
        $db = $this->load->database('panel_vimifos', TRUE); 
        $db->select("cliente_rfc");
        $db->from("pkg_cliente_rfc");
        $db->where("id_cliente = '$cliente'");
        $query = $db->get(); 
        if ($query->num_rows() > 0)  
            return $query->row(0); 
        else  
            return false; 
    }

    public function Contenido($por_pagina,$segmento,$clienterfc,$param) {
        if(!$segmento){
            $var1 = 0;
            $var2 = 10;
        }else{
            $var1 = $segmento;
            $var2 = $segmento+9;
        }

        $db = $this->load->database('business', TRUE); 
        $db2 = $this->load->database('facturas', TRUE); 
        $sql = "SELECT * FROM (SELECT a.*,row_number() OVER (ORDER BY a.fecha DESC) AS row
            FROM (SELECT co.serie,co.folio,co.fecha,co.subTotal,co.total,co.id_Comprobante 
            FROM $db->database.dbo.Comprobante AS co INNER JOIN $db->database.dbo.Receptor AS re ON (co.id_Receptor = re.id_Receptor) 
            WHERE re.rfc = ? AND year(co.fecha) >= ? AND month(co.fecha) >= ? AND co.folio like '%$param%' 
            UNION 
            SELECT co.serie,co.folio,co.fecha,co.subTotal,co.total,co.id_Comprobante
            FROM $db2->database.dbo.Comprobante AS co INNER JOIN $db2->database.dbo.Receptor AS re ON (co.id_Receptor = re.id_Receptor)
            INNER JOIN $db2->database.dbo.Emisor AS em ON (co.id_Emisor = em.id_Emisor) 
            WHERE re.rfc = ? AND (em.rfc = ?) AND year(co.fecha) >= ? AND co.folio like '%$param%') AS a) AS b WHERE b.row >= $var1 and b.row <= $var2 ORDER BY b.fecha DESC";
        $query = $db->query($sql, array($clienterfc,'2012','6',$clienterfc,'VIM970403775','2012'));
        if($query->num_rows()>0)
            $array = $query->result();
        else
            $array = "";

        return $array;
    }

   public function filas($clienterfc,$param){
        $db = $this->load->database('business', TRUE); 
        $db->select("*"); 
        $db->from('dbo.Comprobante as co'); 
        $db->join('dbo.Receptor as re','co.id_Receptor = re.id_Receptor');
        $db->where("re.rfc = '$clienterfc' and year(co.fecha) >= '2012' and month(co.fecha) >= '6'");
        $db->like('co.folio',$param);
        $query = $db->get(); 
        if($query->num_rows()>0)
            $array1 = $query->num_rows();
        else
            $array1 = "";

        $db2 = $this->load->database('facturas', TRUE); 
        $db2->select("*"); 
        $db2->from('dbo.Comprobante as co');
        $db2->join('dbo.Receptor as re','co.id_Receptor = re.id_Receptor');
        $db2->join('Emisor as em','co.id_Emisor = em.id_Emisor');
        $db2->where("re.rfc = '$clienterfc' and (em.rfc = 'VIM970403775') and year(co.fecha) >= '2012'");
        $db2->like('co.folio',$param);
        $query2 = $db2->get(); 
        if($query2->num_rows()>0)
            $array2 = $query2->num_rows();
        else
            $array2 = "";

        return $array1 + $array2;
    }

    public function cliente($id_relacion) {
        return $this->oCliente->find('first',array(
                'field' => array('usu_usuario,usu_id'),
                'conditions' => array('usu_id' => $id_relacion, 'usu_estatus' => 1)
            )); 
    }
}