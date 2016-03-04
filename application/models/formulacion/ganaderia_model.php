<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * tipo_model.php
 *
 * @package None
 * @subpackage None
 * @category Model
 * @author Daniel Villa
 */

class Ganaderia_Model extends My_Model {
    public $table_name;
    public $schema;
    public $schema_add;
    public $schema_up;

    public function __construct()
    {
        parent::__construct();
        $this->table_name = "Solicitud_engorda";
        $this->schema_add = array(
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
                'id' => 'guardar_solicitud'
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
                'label' => 'Guardar',
                'class' => 'btn btn-primary',
                'id' => 'guardar_solicitud'
            )
        );
        $this->schema = array(
            'Formato' => array(
                'class' => 'Formato',
                'id' => 'Formato',
                'Formato' => array(
                    'name' => 'Selecciona un Formato',
                    'tipo' => 'varchar',
                    'lenght' => 30,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'dropdown',
                    'class' => 'form-control',
                    /* 'data' => array(
                        '3' => 'BOVINO - ENGORDA',
                        '1'=> 'BOVINO - LECHERO',
                        '2' => 'OVINO - ENGORDA'      
                    ), */
                    'js' => 'onChange=obtener_fases()'
                )
            ),
            'Datos' => array(
                'class' => 'Datos',
                'id' => 'Datos',
                'idSolicitud' => array(
                    'name' => 'Id',
                    'tipo' => 'int',
                    'lenght' => 11,
                    'null' => FALSE,
                    'primary' => TRUE,
                    'update' => FALSE,
                    'type' => 'hidden',
                    'class' => 'form-control'
                ),
                'Solicitante' => array(
                    'name' => 'Solicitante',
                    'tipo' => 'varchar',
                    'lenght' => 30,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'text',
                    'class' => 'form-control'
                ),
                'Fecha' => array(
                    'name' => 'Fecha',
                    'tipo' => 'varchar',
                    'lenght' => 30,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => FALSE,
                    'type' => 'text',
                    'class' => 'form-control'
                ),
                'Tipo_Cliente' => array(
                    'name' => 'Tipo Cliente',
                    'tipo' => 'varchar',
                    'lenght' => 30,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'radio',
                    'class' => 'form-control',
                    'data' => array(
                        'Cliente' => 'Cliente',
                        'Prospecto'=> 'Prospecto',
                        'Distribuidor' => 'Distribuidor'
                    )
                ),
                'Nombre_Cliente' => array(
                    'name' => 'Nombre Cliente',
                    'tipo' => 'varchar',
                    'lenght' => 30,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'text',
                    'class' => 'form-control'
                ),
                'Telefono' => array(
                    'name' => 'Télefono/Fax',
                    'tipo' => 'varchar',
                    'lenght' => 30,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'text',
                    'class' => 'form-control'
                ),
                'Correo' => array(
                    'name' => 'Correo',
                    'tipo' => 'varchar',
                    'lenght' => 30,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'email',
                    'class' => 'form-control'
                )
            ),
            'Tipo Ganado' => array(
            'class' => 'Tipo_Ganado',
            'id' => 'Tipo_Ganado',
                'idTipo_Ganado' => array(
                    'name' => 'Tipo de Ganado',
                    'tipo' => 'varchar',
                    'lenght' => 30,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'dropdown',
                    'class' => 'form-control'
                )
            ),
            'Detalles' => array(
                'class' => 'Detalles',
                'id' => 'Detalles',
                'NoCabezas' => array(
                    'name' => 'No. de Cabezas',
                    'tipo' => 'varchar',
                    'lenght' => 10,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'number',
                    'class' => 'form-control'
                ),
                'Produccion' => array(
                    'name' => 'Produccion',
                    'tipo' => 'varchar',
                    'lenght' => 30,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'number',
                    'class' => 'form-control',
                    'js' => 'onChange = calculos()'
                ),
                'Secas' => array(
                    'name' => 'Secas',
                    'tipo' => 'varchar',
                    'lenght' => 10,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'number',
                    'class' => 'form-control',
                    'js' => 'onChange = calculos()'
                ),
                'Reemplazos' => array(
                    'name' => 'Reemplazos',
                    'tipo' => 'varchar',
                    'lenght' => 10,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'number',
                    'class' => 'form-control',
                    'js' => 'onChange = calculos()'
                ),
                'Implante' => array(
                    'name' => 'Implante',
                    'tipo' => 'varchar',
                    'lenght' => 2,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'text',
                    'class' => 'form-control'
                ),
                'Desparasitante' => array(
                    'name' => 'Desparasitante',
                    'tipo' => 'varchar',
                    'lenght' => 2,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'text',
                    'class' => 'form-control'
                ),
                'Vacuna' => array(
                    'name' => 'Vacuna',
                    'tipo' => 'varchar',
                    'lenght' => 2,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'text',
                    'class' => 'form-control'
                ),
                'idTipo_Mezclado' => array(
                    'name' => 'Tipo de Mezclado',
                    'tipo' => 'varchar',
                    'lenght' => 30,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'dropdown',
                    'class' => 'form-control'
                )
            ),
            'Fases' => array(
            'class' => 'Fases',
            'id' => 'Fases',
            ),
            'Alimentacion' => array(
                'class' => 'Alimentacion',
                'id' => 'Alimentacion',
                'Alimentacion' => array(
                    'name' => 'Alimentacion en',
                    'tipo' => 'varchar',
                    'lenght' => 30,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'dropdown',
                    'class' => 'form-control',
                    'data' => array(
                        '0' => 'Seleccione un tipo',
                        'Sala de ordeño' => 'Sala de ordeño',
                        'Corral'=> 'Corral'
                    )
                ),
                'ProduccionLeche' => array(
                    'name' => 'Produccion de leche primedio establo',
                    'tipo' => 'varchar',
                    'lenght' => 10,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'text',
                    'class' => 'form-control'
                ),
                'PorcentajeGrasa' => array(
                    'name' => '% de Grasa',
                    'tipo' => 'varchar',
                    'lenght' => 10,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'text',
                    'class' => 'form-control'
                ),
                'TipoFormulacion' => array(
                'name' => 'Tipo',
                'tipo' => 'varchar',
                'lenght' => 30,
                'null' => FALSE,
                'primary' => FALSE,
                'update' => TRUE,
                'type' => 'radio',
                'class' => 'form-control',
                'data' => array(
                    'CONCENTRADO' => 'CONCENTRADO',
                    'RACIÓN' => 'RACIÓN'
                )
            )
            ),
            'Micros' => array(
            'class' => 'Micros',
            'id' => 'Micros',
            ),
            'Concentrados' => array(
            'class' => 'Concentrados',
            'id' => 'Concentrados',
            'Concentrado' => array(
                'name' => 'Concentrado',
                'tipo' => 'varchar',
                'lenght' => 30,
                'null' => FALSE,
                'primary' => FALSE,
                'update' => TRUE,
                'type' => 'text',
                'class' => 'form-control'
            ),
            'idProductoL' => array(
                'name' => 'Micro',
                'tipo' => 'varchar',
                'lenght' => 30,
                'null' => FALSE,
                'primary' => FALSE,
                'update' => TRUE,
                'type' => 'dropdown',
                'class' => 'form-control'
            ),
            'PrecioProductoL' => array(
                'name' => 'Precio',
                'tipo' => 'varchar',
                'lenght' => 30,
                'null' => FALSE,
                'primary' => FALSE,
                'update' => TRUE,
                'type' => 'text',
                'class' => 'form-control'
            ),
            'Vacas' => array(
                'name' => 'Vacas Adultas',
                'tipo' => 'varchar',
                'lenght' => 30,
                'null' => FALSE,
                'primary' => FALSE,
                'update' => TRUE,
                'type' => 'radio',
                'class' => 'form-control',
                'data' => array(
                    'ALTAS PRODCUTORAS' => 'ALTAS PRODCUTORAS',
                    'MEDIAS PRODUCTORAS' => 'MEDIAS PRODUCTORAS',
                    'SECAS' => 'SECAS'
                )
            ),
            'ReemplazosMicro' => array(
                'name' => 'Reemplazos (Edad en meses)',
                'tipo' => 'varchar',
                'lenght' => 30,
                'null' => FALSE,
                'primary' => FALSE,
                'update' => TRUE,
                'type' => 'radio',
                'class' => 'form-control',
                'data' => array(
                    '2 A 6' => '2 A 6',
                    '7 A 11' => '7 A 11',
                    '12 A 24' => '12 A 24'
                )
            )
            ),
            'Micros Especiales' => array(
            'class' => 'MicrosEspeciales',
            'id' => 'MicrosEspeciales',
            ),
            'Ingrediente' => array(
            'class' => 'Ingrediente',
            'id' => 'Ingrediente',
            ),
            'Forraje' => array(
            'class' => 'Forraje',
            'id' => 'Forraje',
            ),
            'Comentario' => array(
            'class' => 'Comentario',
            'id' => 'Comentario',
            'Analisis' => array(
                'name' => 'Adjuntar Analisis',
                'tipo' => 'varchar',
                'lenght' => 30,
                'null' => FALSE,
                'primary' => FALSE,
                'update' => TRUE,
                'type' => 'file',
                'class' => 'form-control'
            ),
            'Comentario' => array(
                'name' => 'Comentario',
                'tipo' => 'varchar',
                'lenght' => 30,
                'null' => FALSE,
                'primary' => FALSE,
                'update' => TRUE,
                'type' => 'textarea',
                'class' => 'form-control'
            )
            )
        );
    }

    function prepararForm(){
        /* $forms = array();
        $formularios = $this->get('Fase','idFase,Fase,Rango');
        $forms[0] = 'Seleccione una Fase';
        foreach($formularios as $formulario){
            $forms[$formulario->idFase] = $formulario->Fase;
        }
        $this->schema['Fases']['idFase']['data'] = $forms; */
        
        $forms = array();
        $formularios = $this->formatos_disponibles(array("1","2","3"));
        $forms[0] = '';
        foreach($formularios as $key => $formulario){
            $forms[$formulario->idEtapa] = $formulario->Subespecie."->".$formulario->Etapa;
        }
        $this->schema['Formato']['Formato']['data'] = $forms;

        $forms = array();
        $formularios = $this->get('Producto','idProducto,Producto');
        $forms[0] = 'Seleccione un Producto';
        foreach($formularios as $formulario){
            $forms[$formulario->idProducto] = $formulario->Producto;
        }
        $this->schema['Concentrados']['idProductoL']['data'] = $forms;

        $forms = array();
        /* $formularios = $this->get('Tipo_Ganado','idTipo_Ganado,TipoGanado');*/
        $forms[0] = '';
        /*foreach($formularios as $formulario){
            $forms[$formulario->idTipo_Ganado] = $formulario->TipoGanado;
        }*/
        $this->schema['Tipo Ganado']['idTipo_Ganado']['data'] = $forms;

        $forms = array();
        $formularios = $this->get('Tipo_mezclado','idTipo_Mezclado,TipoMezclado');
        $forms[0] = 'Seleccione un tipo';
        foreach($formularios as $formulario){
            $forms[$formulario->idTipo_Mezclado] = $formulario->TipoMezclado;
        }
        $this->schema['Detalles']['idTipo_Mezclado']['data'] = $forms;

        /* $forms = array();
        $formularios = $this->get('Ingrediente','idIngrediente,Ingrediente');
        $forms[0] = 'Seleccione un Ingrediente';
        foreach($formularios as $formulario){
            $forms[$formulario->idIngrediente] = $formulario->Ingrediente;
        }
        $this->schema['Ingrediente']['idIngrediente[]']['data'] = $forms; */

        /* $forms = array();
        $formularios = $this->get('Especificacion','idEspecificacion,Especificacion');
        $forms[0] = 'Seleccione un Especificacion';
        foreach($formularios as $formulario){
            $forms[$formulario->idEspecificacion] = $formulario->Especificacion;
        }
        $this->schema['Ingrediente']['idEspecificacion[]']['data'] = $forms; */
    }

    function buscar_producto($idFase){
        $this->db->select('Producto.idProducto,Producto.Producto');
        $this->db->from('Producto');
        $this->db->join('Etapa', 'Etapa.idSubespecie = Producto.idSubespecie');
        $this->db->join('Detalle_etapa','Etapa.idEtapa = Detalle_etapa.idEtapa');
        $this->db->where('Detalle_etapa.idDetalle_Etapa', $idFase);
        $query = $this->db->get();
        
        if($query->num_rows()>0)
        {
            //retorna o resultado
            return $query->result();
        }
    }

    /* function buscas_tipo_ganado($Formato){
        $this->db->select('tipo_ganado.idTipo_Ganado,tipo_ganado.TipoGanado');
        $this->db->from('tipo_ganado');
        $this->db->join('etapa', 'etapa.idEtapa = ripo.idSubespecie');
        $this->db->join('detalle_etapa','etapa.idEtapa = detalle_etapa.idEtapa');
        $this->db->where('detalle_etapa.idDetalle_Etapa', $idFase);
        $query = $this->db->get();
        
        if($query->num_rows()>0)
        {
            //retorna o resultado
            return $query->result();
        }
    } */

    function detalle_solicitud_engorda($idSolicitud){
        $this->db->select('Producto.Producto,Detalle_solicitud_engorda.PrecioProducto,Detalle_etapa.Descripcion,Detalle_etapa.Rango');
        $this->db->from('Detalle_solicitud_engorda');
        $this->db->join('Producto','Producto.idProducto = Detalle_solicitud_engorda.idProducto');
        $this->db->join('Detalle_etapa','Detalle_etapa.idDetalle_Etapa = Detalle_solicitud_engorda.idDetalle_Etapa');
        $this->db->where('Detalle_solicitud_engorda.idSolicitud_Engorda', $idSolicitud);
        $query = $this->db->get();
        
        if($query->num_rows()>0)
        {
            //retorna o resultado
            return $query->result();
        }
    }

     function detalle_solicitud_gnral($idSolicitud,$Formato){
        $this->db->select('Ingrediente.Ingrediente,Detalle_solicitud_gnral.Precio,Detalle_solicitud_gnral.Especificacion,Detalle_solicitud_gnral.Tipo');
        $this->db->from('Detalle_solicitud_gnral');
        $this->db->join('Ingrediente','Ingrediente.idIngrediente = Detalle_solicitud_gnral.idIngrediente');
        $this->db->where('Detalle_solicitud_gnral.idSolicitud', $idSolicitud);
        $this->db->where('Detalle_solicitud_gnral.Formato', $Formato);
        $query = $this->db->get();
        
        if($query->num_rows()>0)
        {
            //retorna o resultado
            return $query->result();
        }
    }

    function formatos_disponibles($etapas){
        $this->db->select('Etapa.idEtapa,Subespecie.Subespecie,Etapa.Etapa');
        $this->db->from('Etapa');
        $this->db->join('Subespecie','Subespecie.idSubespecie = Etapa.idSubespecie');
        $this->db->where_in('Etapa.idEtapa', $etapas);
        $query = $this->db->get();
        
        if($query->num_rows()>0)
        {
            //retorna o resultado
            return $query->result();
        }
    }

    function GuardarSolicitudEngorda($row){
        //TRABAJANDO ARCHIVO CARGADO
        $archivo = $_FILES["Analisis"]["tmp_name"]; 
        $tamanio = $_FILES["Analisis"]["size"];
        $tipo    = $_FILES["Analisis"]["type"];
        $nombre  = $_FILES["Analisis"]["name"];
        if ( $archivo != "none" ){
            $fp = fopen($archivo, "rb");
            $contenido = fread($fp, $tamanio);
            $contenido = addslashes($contenido);
            fclose($fp); 
        }
        //TRABAJANDO ARCHIVO CARGADO
        //SOLICITUD
        $data = array(
            'Fecha' => date("Y-m-d H:i:s"),
            'Solicitante' => $row['Solicitante'],
            'Tipo_Cliente' => $row['Tipo_Cliente'],
            'Nombre_Cliente' => $row['Nombre_Cliente'],
            'Telefono' => $row['Telefono'],
            'NoCabezas' => $row['NoCabezas'],
            'idTipo_Ganado' => $row['idTipo_Ganado'],
            'Implante' => ($row['Implante'] = NULL ? NULL : $row['Implante']),
            'Desparasitante' => ($row['Desparasitante'] = NULL ? NULL : $row['Desparasitante']),
            'Vacuna' => ($row['Vacuna'] = NULL ? NULL : $row['Vacuna']),
            'idTipo_Mezclado' => $row['idTipo_Mezclado'],
            'Comentario' => $row['Comentario'],
            'idFormulador' => 1,
            'Status' => 1,
            'idUsuario' => $this->session->userdata('logged_user')->usu_id,
            'Formato' => "ENGORDA",
            'StatusSolicitud' => 'RECIBIDA',
            'Correo' => $row['Correo'],
            'Archivo_Analisis' => ($contenido = NULL ? NULL : $contenido),
            'Tipo_Analisis' => ($tipo = NULL ? NULL : $tipo),
            'Nombre_Analisis' => ($nombre = NULL ? NULL : $nombre)
        );
        $this->db->insert('Solicitud_engorda',$data);
        $id = $this->db->insert_id();

        //Status de la solicitud
        $datas = array(
            'Status' => 'RECIBIDA',
            'FechaModificacion' => date("Y-m-d H:i:s"),
            'idSolicitud' => $id,
            'Comentario' => "SE RECIBIO LA SOLICITUD, PENDIENTE A REVISION.",
            'Formato' => "ENGORDA"
        );
        $this->db->insert('Status_solicitud',$datas);
            
        //Detalle de la solicitud engorda
        $Producto = $row['idProducto'];
        $PrecioProducto = $row['Precio'];
        $Detalle_Etapa = $row['idDetalleEtapa'];
        $RangoEtapa = $row['Rango'];
        foreach($Producto as $key => $detalle){
            $data2 = array(
                'idSolicitud_Engorda' => $id,
                'idProducto' => $detalle,
                'PrecioProducto' => $PrecioProducto[$key],
                'idDetalle_Etapa' => $Detalle_Etapa[$key],
                'RangoEtapa' => $RangoEtapa[$key]
            );
        $this->db->insert('Detalle_solicitud_engorda',$data2);
        }

        //Detalle en solicitud general - Ingrediente
        $Ingrediente = $row['idIngrediente'];
        $PrecioIngrediente = $row['PrecioIngrediente'];
        $Especificacion = $row['idEspecificacion'];
        foreach($Ingrediente as $key2 => $detallei){
            $data3 = array(
                'idIngrediente' => $Ingrediente[$key2],
                'Precio' => $PrecioIngrediente[$key2],
                'Especificacion' => $Especificacion[$key2],
                'idSolicitud' => $id,
                'Tipo' => 'IGR',
                'Formato' => "ENGORDA"
            );
            $this->db->insert('Detalle_solicitud_gnral',$data3);
        }

        //Detalle en solicitud general - Ingrediente
        $Forraje = $row['idForraje'];
        $PrecioForraje = $row['PrecioForraje'];
        $EspecificacionF = $row['idEspecificacion'];
        foreach($Forraje as $key3 => $detallef){
            $data4 = array(
                'idIngrediente' => $Forraje[$key3],
                'Precio' => $PrecioForraje[$key3],
                'Especificacion' => $EspecificacionF[$key3],
                'idSolicitud' => $id,
                'Tipo' => 'FOR',
                'Formato' => "ENGORDA"
            );
            $this->db->insert('Detalle_solicitud_gnral',$data4);
        }
        return $id;
    }

    function GuardarSolicitudLechero($row){
        //TRABAJANDO ARCHIVO CARGADO
        $archivo = $_FILES["Analisis"]["tmp_name"]; 
        $tamanio = $_FILES["Analisis"]["size"];
        $tipo    = $_FILES["Analisis"]["type"];
        $nombre  = $_FILES["Analisis"]["name"];
        if ( $archivo != "none" ){
            $fp = fopen($archivo, "rb");
            $contenido = fread($fp, $tamanio);
            $contenido = addslashes($contenido);
            fclose($fp); 
        }
        //TRABAJANDO ARCHIVO CARGADO
        //Solicitud
        $data = array(
            'Fecha' => date("Y-m-d H:i:s"),
            'Solicitante' => $row['Solicitante'],
            'Tipo_Cliente' => $row['Tipo_Cliente'],
            'Nombre_Cliente' => $row['Nombre_Cliente'],
            'Telefono' => $row['Telefono'],
            'NoCabezas' => $row['NoCabezas'],
            'Alimentacion' => ($row['Alimentacion'] = 0 ? NULL : $row['Alimentacion']),
            'Produccion' => ($row['Produccion'] = NULL ? NULL : $row['Produccion']),
            'Secas' => ($row['Secas'] = NULL ? NULL : $row['Secas']),
            'Reemplazos' => ($row['Reemplazos'] = NULL ? NULL : $row['Reemplazos']),
            'ProduccionLeche' => ($row['ProduccionLeche'] = NULL ? NULL : $row['ProduccionLeche']),
            'PorcentajeGrasa' => ($row['PorcentajeGrasa'] = NULL ? NULL : $row['PorcentajeGrasa']),
            'Comentario' => $row['Comentario'],
            'idFormulador' => 1,
            'Status' => 1,
            'Correo' => $row['Correo'],
            'idUsuario' => $this->session->userdata('logged_user')->usu_id,
            'Formato' => "LECHERO",
            'StatusSolicitud' => 'RECIBIDA',
            'idProducto' => $row['idProductoL'],
            'PrecioProducto' => $row['PrecioProductoL'],
            'Vacas' => $row['Vacas'],
            'ReemplazosMicro' => $row['ReemplazosMicro'],
            'Archivo_Analisis' => ($contenido = NULL ? NULL : $contenido),
            'Tipo_Analisis' => ($tipo = NULL ? NULL : $tipo),
            'Nombre_Analisis' => ($nombre = NULL ? NULL : $nombre)
        );
        $this->db->insert('Solicitud_lechero',$data);
        $id = $this->db->insert_id();

        //Status de la solicitud
        $datas = array(
            'Status' => 'RECIBIDA',
            'FechaModificacion' => date("Y-m-d H:i:s"),
            'idSolicitud' => $id,
            'Comentario' => "SE RECIBIO LA SOLICITUD, PENDIENTE A REVISION.",
            'Formato' => "LECHERO"
        );
        $this->db->insert('Status_solicitud',$datas);

        //Detalle en solicitud general - Ingrediente
        $Ingrediente = $row['idIngrediente'];
        $PrecioIngrediente = $row['PrecioIngrediente'];
        $Especificacion = $row['idEspecificacion'];
        foreach($Ingrediente as $key2 => $detallei){
            $data3 = array(
                'idIngrediente' => $Ingrediente[$key2],
                'Precio' => $PrecioIngrediente[$key2],
                'Especificacion' => $Especificacion[$key2],
                'idSolicitud' => $id,
                'Tipo' => 'IGR',
                'Formato' => "LECHERO"
            );
            $this->db->insert('Detalle_solicitud_gnral',$data3);
        }

        //Detalle en solicitud general - Ingrediente
        $Forraje = $row['idForraje'];
        $PrecioForraje = $row['PrecioForraje'];
        $EspecificacionF = $row['idEspecificacion'];
        foreach($Forraje as $key3 => $detallef){
            $data4 = array(
                'idIngrediente' => $Forraje[$key3],
                'Precio' => $PrecioForraje[$key3],
                'Especificacion' => $EspecificacionF[$key3],
                'idSolicitud' => $id,
                'Tipo' => 'FOR',
                'Formato' => "LECHERO"
            );
            $this->db->insert('Detalle_solicitud_gnral',$data4);
        }
        return $id;
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

    public function delete_t($id) {
    $this->db->trans_begin();
    $this->db->update('Solicitud_engorda', array('Status' => 0 ,'StatusSolicitud' => 'ELIMINADA'), array('idSolicitud_Engorda' => $id));
    if ($this->db->trans_status() === FALSE) {
        $this->db->trans_rollback();
        return false;
    }
    $this->db->trans_commit();
    return true;
  }

  public function delete_l($id) {
    $this->db->trans_begin();
    $this->db->update('Solicitud_lechero', array('Status' => 0 ,'StatusSolicitud' => 'ELIMINADA'), array('idSolicitud_Lechero' => $id));
    if ($this->db->trans_status() === FALSE) {
        $this->db->trans_rollback();
        return false;
    }
    $this->db->trans_commit();
    return true;
  }
}