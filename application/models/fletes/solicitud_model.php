<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * tipo_model.php
 *
 * @package None
 * @subpackage None
 * @category Model
 * @author Daniel Villa
 */

    class Solicitud_Model extends My_Model {
        public $table_name;
        public $schema;
        public $schema_add;
        public $schema_up;

    function list_generic($table){
        $array = $this->get($table,'*');
        return $array;
    }

    function unidad($idunidad){
        $unidad = $this->get('unidad','descripcion',"idunidad = $idunidad");
        foreach($unidad as$row){
            return $row->descripcion;
        }
    }

    function ciudad($idciudad){
        $ciudad = $this->get('ciudad','descripcion',"idciudad = $idciudad", NULL);
        foreach($ciudad as$row){
            return $row->descripcion;
        }
    }

    function estado($idestado){
        $estado = $this->get('Estado','descripcion',"idestado = $idestado", NULL);
        foreach($estado as $row){
            return $row->descripcion;
        }
    }

    function guardar_cotizacion(){
        $idorigen = $this->input->post('origen', TRUE);

        //SE OBTIENE EL ESTADO Y CIUDAD DE ORIGEN.
        $array_origen = $this->get("origenes","idestado,idciudad","idorigen = $idorigen");
        foreach ($array_origen as $row){
            $idestado = $row->idestado;
            $idciudad = $row->idciudad;
        }
        
        //SE TOMA EL ESTADO Y CIUDAD DESTINO.
        $idestado1 = $this->input->post('idestado', TRUE);
        $idciudad1 = $this->input->post('idciudadorigen', TRUE);

        $data = array(
            'nombre_solicitante' => $this->input->post('nombre_solicitante', TRUE),     //NOMBRE SOLICITANTE
            'division' => $this->input->post('division', TRUE),                         //DIVISION
            'nombre_cliente' => $this->input->post('nombre_cliente', TRUE),             //NOMBRE DEL CLIENTE
            'nombre_contacto_1' => $this->input->post('nombre_contacto_1', TRUE),       //NOMBRE DEL CONTANTO 1
            'telefono_1' => $this->input->post('telefono_1', TRUE),                     //TELEFONO 1
            'celular_1' => $this->input->post('celular_1', TRUE),                       //CELULAR 1
            'nombre_contacto_2' => $this->input->post('nombre_contacto_2', TRUE),       //NOMBLE DEL CONTACTO 2
            'telefono_2' => $this->input->post('telefono_2', TRUE),                     //TELEFONO 2
            'celular_2' => $this->input->post('celular_2', TRUE),                       //CELULAR 2
            'origen' => $this->input->post('origen', TRUE),                             //IDORIGEN
            'direccion' => $this->input->post('direccion_1', TRUE),                     //DIRECCION DESTINO
            'cp' => $this->input->post('cp_1', TRUE),                                   //CP DESTINO
            'idestado' => $idestado1,                                                   //IDESTADO DESTINO
            'idciudad' => $idciudad1,                                                   //IDCIUDAD DESTINO
            'referencias' => $this->input->post('referencia_1', TRUE),                  //REFERENCIA
            'requerimientos' => $this->input->post('requisitos', TRUE),                 //REQUISITOS ESPECIALES
            'fecha' => $this->input->post('fecha', TRUE),                               //FECHA
            'embalaje' => $this->input->post('embalaje', TRUE),                         //EMBALAJE
            'idusuario' => $this->session->userdata('logged_user')->usu_id              //IDUSUARIO
        );
        //SE GUARDA LA INFORMACION DE LA SOLICITUD.
        $this->db->insert('solicitudes', $data);
        
        //SE BUSCA EL ID DE LA SOLICITUD DADA DE ALTA ANTERIORMENTE.
        $solicitudes = $this->get('solicitudes','*',NULL,"idsolicitud DESC LIMIT 1");
        foreach($solicitudes as $solicitud){
            $idsolicitud = $solicitud->idsolicitud;
        }

        //SE RECORRE EL NUMERO DE GASTOS PARA LA SOLICITUD
        $checkbox = $this->input->post('active',TRUE);
        $observaciones = $this->input->post('observaciones', TRUE);
        for($i = 0; $i <= count($checkbox); $i++){
            if($checkbox[$i] != NULL){
                $data = array(
                    'idsolicitud' => $idsolicitud,
                    'idrequerimiento' => $checkbox[$i],
                    'observaciones' => $observaciones[$i]
                );

                //SE GUARDA EL DETALLE DE LOS REQUERIMIENTOS
                $this->db->insert('detalle_requerimiento',$data);
            }
        }
        
        //SE TOMAN LAS UNIDADES COTIZADAS POR EL CLIENTE.
        $idunidad = $this->input->post('idunidad', TRUE); //UNIDAD
        $viajes = $this->input->post('viajes', TRUE);     //NUMERO DE VIAJE
        $tn_viaje = $this->input->post('tnviaje', TRUE);  //TONELADAS POR VIAJE


        //SE RECORRE EL NUMERO TOTAL DE VIAJES A COTIZAR
        for($i = 0; $i <= count($idunidad); $i++){
            $id = $idunidad[$i];
            if($id<>0){
                //BUSCA SI EXISTE TRAYECTO PARA LA UNIDAD COTIZADA EN EL ORIGEN - DESTINO ASIGNADO POR EL CLIENTE.
                $costo_tonelada =  $this->get('trayecto','costokm',
                                    "idestado = $idestado and 
                                    idciudadorigen = $idciudad and 
                                    idestado2 = $idestado1 and 
                                    idciudaddestino = $idciudad1 and
                                    idunidad = $id");
                foreach($costo_tonelada as $row){
                    $data2 = array(
                        'idunidad' => $idunidad[$i],
                        'viajes_mensuales' => $viajes[$i],
                        'tn_x_viaje' => $tn_viaje[$i],
                        'idsolicitud' => $idsolicitud,
                        'costo_tn' => $row->costokm
                    );
                    //SE GUARDA EL DETALLE DE LA SOLICITUD
                    $this->db->insert('detalle_solicitud',$data2);
                }
            }
        }
        return $solicitudes;
    }

    function detalle($idsolicitud){
        $this->db->select('unidad.descripcion,detalle_solicitud.viajes_mensuales,detalle_solicitud.tn_x_viaje,detalle_solicitud.costo_tn,detalle_solicitud.tn_x_viaje * detalle_solicitud.costo_tn as costo_viaje,((detalle_solicitud.tn_x_viaje * detalle_solicitud.costo_tn) * detalle_solicitud.viajes_mensuales) as costo_total');
        $this->db->from('detalle_solicitud');
        $this->db->join('unidad','unidad.idunidad = detalle_solicitud.idunidad');
        $this->db->where('detalle_solicitud.idsolicitud', $idsolicitud);
        $query = $this->db->get();
        
        if($query->num_rows()>0)
        {
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
}