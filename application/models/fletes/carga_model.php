<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * carga_model.php
 *
 * @package None
 * @subpackage None
 * @category Model
 * @author Daniel Villa
 */

class Carga_Model extends My_Model {
    public $table_name;
    public $schema;
    public $schema_add;
    public $schema_up;

    public function __construct()
    {
        parent::__construct();
        $this->table_name = "requerimiento";
        $this->schema_add = array(
            'Borrar' => array(
                'tipo' => 'reset',
                'label' => 'Borrar',
                'class' => 'btn btn-primary',
                'id' => 'borrar'
            ),
            'Guardar' => array(
                'tipo' => 'submit',
                'label' => 'Guardar',
                'class' => 'btn btn-primary',
                'id' => 'guardar_especie'
            )
        );
        $this->schema_up = array(
            'Borrar' => array(
                'tipo' => 'reset',
                'label' => 'Borrar',
                'class' => 'btn btn-primary',
                'id' => 'borrar'
            ),
            'Guardar' => array(
                'tipo' => 'submit',
                'label' => 'Siguiente',
                'class' => 'btn btn-primary',
                'id' => 'guardar_especie'
            )
        );
        $this->schema = array(
            'Archivo Tarifario' => array(
                'class' => 'ejemplo',
                'id' => 'ejemplo',
                'idrequerimiento' => array(
                    'name' => 'Id',
                    'tipo' => 'int',
                    'lenght' => 11,
                    'null' => FALSE,
                    'primary' => TRUE,
                    'update' => FALSE,
                    'type' => 'hidden',
                    'class' => 'form-control'
                ),
                'tarifario' => array(
                    'name' => 'Archivo CSV',
                    'tipo' => 'varchar',
                    'lenght' => 40,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'file',
                    'class' => 'form-control',
                    'js' => 'onchange = control(this)'
                )
            )
        );
    }

    public function contenido(){
        $data   =   array(
                'trayecto.descripcion as trayecto', 
                '(select descripcion from ciudad where idciudad = origenes.idciudad) as ciudadorigen', 
                'Estado.descripcion as estado_destino', 
                'ciudad.descripcion as ciudad_destino',
                'CONCAT(unidad.descripcion," - ",CONVERT(unidad.capacidad,CHAR(2))," TONELADA(S)") as unidad', 
                'unidad.idunidad',
                'trayecto.kms as Kms', 
                'trayecto.costokm as costoviaje', 
                '(trayecto.costokm / unidad.capacidad) as costotn'
        );
        $this->db->select($data);
        $this->db->from('trayecto');
        $this->db->join('Estado','Estado.idestado = trayecto.idEstado2');
        $this->db->join('ciudad','ciudad.idciudad = trayecto.idciudaddestino');
        $this->db->join('origenes','origenes.idciudad = trayecto.idciudadorigen');
        $this->db->join('unidad','unidad.idunidad = trayecto.idunidad'); 
        $query = $this->db->get();
        if($query->num_rows()>0){
            //retorna o resultado
            return $query->result();
        }
    }

    function get($tabla,$campos = null,$where = null,$order = null){
        if (!is_null($campos))
            $this->db->select($campos); 
        if (!is_null($where))
            $this->db->where($where);
        if (!is_null($order))
            $this->db->order_by($order);
        $query = $this->db->get($tabla);
        return $query->result();
    }

    public function cargar_csv($descripcion,$idorigen,$estado,$ciudad,$kms,$costo,$unidad,$proveedor,$status){
        $ciudad = $this->get('ciudad','idciudad',"descripcion = '$ciudad'");
        $unidad = $this->get('unidad','idunidad',"descripcion = '$unidad'");
        $estado = $this->get('Estado','idestado',"descripcion = '$estado'");
        $origen = $this->get('origenes','idestado',"idciudad = '$idorigen'");
        if($ciudad && $unidad && $estado && $origen){
            if(!$this->get('trayecto','idtrayecto',"idciudadorigen = $idorigen and idciudaddestino = '".$ciudad[0]->idciudad."' and idunidad = '".$unidad[0]->idunidad."'")){
                $data = array(
                    'descripcion' => $descripcion,                  //DESCRIPCION
                    'idciudadorigen' => $idorigen,                  //IDCIUDADORIGEN
                    'idciudaddestino' => $ciudad[0]->idciudad,      //IDCIUDADDESTINO
                    'kms' => $kms,                                  //KMS
                    'costokm' => $costo,                            //COSTO
                    'idunidad' => $unidad[0]->idunidad,             //IDUNIDAD
                    'status' => $status,                            //STATUS
                    'idestado' => $origen[0]->idestado,             //TELEFONO 2
                    'idestado2' => $estado[0]->idestado,            //CELULAR 2
                    'idproveedor' => $proveedor,                    //IDORIGEN
                    'status' => ($status = "ACTIVO" ? "1" : "0"),                            //DIRECCION DESTINO
                );
                //SE GUARDA EL TRAYECTO.
                $this->db->insert('trayecto', $data);
                return "AGREGADO";
            } else {
                $data = array(
                    'descripcion' => $descripcion,                  //DESCRIPCION
                    'kms' => $kms,                                  //KMS
                    'costokm' => $costo,                            //COSTO
                    'status' => $status,                            //STATUS
                    'idproveedor' => $proveedor,                    //IDORIGEN
                    'status' => ($status = "ACTIVO" ? "1" : "0"),                            //DIRECCION DESTINO
                );
                //SE ACTUALIZA EL TRAYECTO.
                $this->db->where('idciudadorigen', $idorigen);
                $this->db->where('idciudaddestino', $ciudad[0]->idciudad);
                $this->db->where('idunidad', $unidad[0]->idunidad);
                $this->db->update('trayecto', $data); 
                return "MODIFICADO";
            }
        } else {
            return "ERROR";
        }
    }
}