<?php if (!defined('BASEPATH')) die('No direct script access allowed');
/**
 * Super Class
 *
 * @package None
 * @subpackage None
 * @category Model
 * @author Alfredo Garcia
 * @link http://localhost/sistema_web/censos.php/
 */
class Pasos_model extends MY_Model {
	public $table;

	/**
	 * Carga todo las funciones que tiene disponible CI_Model propia de codeigniter
	 */
	function __construct($db = null) {
		// llamma el Modelo constructor
		parent::__construct($db);
		$this->load->model('usuarios/usuarios_model','oCliente',FALSE,'usuarios');
		$this->load->model('pedidos/solicitudes_model','oSol',FALSE,'pedidos');
		$this->load->model('pedidos/productos_model','oProd',FALSE,'pedidos');
		$this->load->model('pedidos/productos_detalles_model','oDet',FALSE,'pedidos');
		$this->load->model('pedidos/campos_model','oCampos',FALSE,'pedidos');
		$this->load->model('pedidos/ejecutivos_model','oEjec',FALSE,'pedidos');
		$this->load->model('pedidos/ubicaciones_model','oUbic',FALSE,'pedidos');
		$this->load->model('pedidos/transportes_model','oTrans',FALSE,'pedidos');
		$this->load->model('pedidos/plantas_model','oPlanta',FALSE,'pedidos');
	}
	/**
	 * Obtiene al cliente de lusuario que se logeo
	 * @param  [type] $id_relacion [description]
	 * @return [type]              [description]
	 */
	public function cliente($id_relacion) {
		return $this->oCliente->find('first',array(
				'field' => array('usu_usuario,usu_id'),
				'conditions' => array('usu_id' => $id_relacion, 'usu_estatus' => 1)
			));	
	}
	/**
	 * [asignado description]
	 * @param  [type] $id_usuario_asignado [description]
	 * @return [type]                      [description]
	 */
	public function asignado($id_usuario_asignado) {
		return $this->oCliente->find('first',array(
				'field' => array('usu_usuario,usu_id'),
				'join' => array(
						'clause' => array('usuasi_usuarios_asignados_det' => 'usu_id = usuasi_id_asignado'),
						'type' => 'INNER'
					),
				'conditions' => array('usuasi_id_usuario' => $id_usuario_asignado, 'usu_estatus' => 1)
			));	
	}
	/**
	 * [insert_status description]
	 * @param  [type] $cliente [description]
	 * @return [type]          [description]
	 */
	public function insert_status($cliente) {
		return $this->oSol->find('',array(
				'join' => array(
						'clause' => array('tra_transportes_mstr' => 'sol_id_transporte = tra_id_transporte'),
						'type' => 'INNER'
					),
				'conditions' => array('sol_id_cliente' => $cliente, 'sol_estatus !=' => 4)
			));	
	}
	/**
	 * [paso description]
	 * @param  [type] $cliente     [description]
	 * @param  [type] $sol_estatus [description]
	 * @return [type]              [description]
	 */
	public function paso($cliente, $sol_estatus) {
		return $this->oSol->find('',array(
				'join' => array(
						'clause' => array('tra_transportes_mstr' => 'sol_id_transporte = tra_id_transporte', 'pla_plantas_mstr' => 'sol_id_planta = pla_id_planta'),
						'type' => 'INNER'
					),
				'conditions' => array('sol_id_cliente' => $cliente, 'sol_estatus' => $sol_estatus)
			));	
	}
	/**
	 * [factura_pdfxml description]
	 * @param  [type] $serie_folio [description]
	 * @return [type]              [description]
	 */
	public function factura_pdfxml($serie_folio) {
		$db2 = $this->load->database('facturas', TRUE); 
		$db2->select("arc.id_Comprobante,arc.xxml,arc.pdf,com.id_Comprobante,com.serie,com.folio"); 
        $db2->from('Archivo as arc'); 
        $db2->join('Comprobante as com', 'arc.id_Comprobante = com.id_Comprobante', 'INNER'); 
        $db2->where('(com.serie + convert(varchar,com.folio)) =', $serie_folio); 
        $query = $db2->get(); 
		if ($query->num_rows() > 0)  
			return $query->row(0); 
		else  
			return false; 
	}
	/**
	 * [detalles_solicitud description]
	 * @param  [type] $solicitud_id [description]
	 * @return [type]               [description]
	 */
	public function detalles_solicitud($solicitud_id) {
		$query = $this->oSol->find('result',array(
				'join' => array(
						'clause' => array('soldet_solicitud_detalle_det' => 'sol_id_solicitud = soldet_id_solicitud', 'usuarios.usu_usuarios_mstr' => 'usuarios.usu_usuarios_mstr.usu_id = sol_id_cliente' ),
						'type' => 'INNER'
					),
				'conditions' => array('sol_id_solicitud' => $solicitud_id)
			));	
		if ($query->num_rows() > 0) 
			return $query->result();
		else 
			return false;
	}
	/**
	 * [solicitud description]
	 * @param  [type] $sol_id [description]
	 * @return [type]         [description]
	 */
	public function solicitud($sol_id) {
		$query = $this->oSol->find('',array(
			'conditions' => array('sol_estatus' => '1','sol_id_solicitud' => $sol_id)
			));
		if ($query->num_rows() > 0) {
			return $query->row_array();
		} else {
			return false;
		}
	}	
	/**
	 * [paso1 description]
	 * @return [type] [description]
	 */
	public function paso1() {
		$query = $this->oPlanta->find('',array(
			'conditions' => array('pla_estatus' => '1')
			));
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	/**
	 * [paso2 description]
	 * @return [type] [description]
	 */
	public function paso2() {
		$query = $this->oTrans->find('',array(
			'conditions' => array('tra_estatus' => '1')
			));
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	/**
	 * [paso3 description]
	 * @param  [type] $especie     [description]
	 * @param  [type] $id_producto [description]
	 * @return [type]              [description]
	 */
	public function paso3($especie, $id_producto = NULL) {
		if (!is_null($especie)) {
			if ($id_producto){
				$codicion = array('pro_id_producto' => $id_producto, 'profiedet_producto_id' => $id_producto, 'pro_estatus' => 1, 'pro_especie' => $especie);
				$join = array(
							'clause' => array('profiedet_profie_detalles_det' => 'pro_id_producto = profiedet_producto_id'),
							'type' => 'INNER'
						);
			}
			else{
				$codicion = array('pro_estatus' => 1, 'pro_especie' => $especie);
				$join = null;
			}
				
			$especie =  $this->oProd->find('result',array(
					'join' => $join,
					'conditions' => $codicion
				));	
			if ($especie->num_rows() > 0) {
				$especie = $especie->result_array();
			} else {
				$especie = 'no se ha seleccionado ninguna especie';
				return $especie;
			}

			if ($id_producto) {
				$especie['campos'] = $this->oDet->find('result',array(
						'conditions' => array('profie_id_producto' => $id_producto)
					))->result_array();
			}

			return $especie;

		}
	}
	/**
	 * [show_formulario description]
	 * @param  [type] $id_formulario [description]
	 * @return [type]                [description]
	 */
	function show_formulario($id_formulario) {
		$query =  $this->oCampos->find('result',array(
					'conditions' => array('cam_estatus' => 1, 'cam_id_formulario' => $id_formulario),
					'order' => array('cam_posicion' => 'ASC')
				));	
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	/**
	 * [ejecutivos description]
	 * @param  [type] $id_cliente [description]
	 * @return [type]             [description]
	 */
	function ejecutivos($id_cliente) {		
		$query = $this->oEjec->find('result',array(
			'conditions' => array('eje_cliente' => $id_cliente,'eje_estatus' => 1)
			));
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	/**
	 * [ejecutivos_correo description]
	 * @param  [type] $nombre_ejecutivo [description]
	 * @return [type]                   [description]
	 */
	function ejecutivos_correo($nombre_ejecutivo) {
		$query = $this->oEjec->find('result',array(
			'fields' => array('eje_correo','eje_extension'),
			'like' => array("CONCAT(eje_nombre, ' ', eje_apellido_paterno)" => $nombre_ejecutivo)
			));
		if ($query->num_rows() > 0) {
			return $query->row();
		} else {
			return false;
		}
	}
	/**
	 * [ubicaciones description]
	 * @param  [type] $id_cliente  [description]
	 * @param  [type] $id_asignado [description]
	 * @return [type]              [description]
	 */
	function ubicaciones($id_cliente,$id_asignado) {		
		$query = $this->oUbic->find('result',array(
			'conditions' => array('ubi_clave_cliente' => $id_cliente, 'ubi_cliente' => $id_asignado, 'ubi_estatus' => 1)
			));
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}
	/**
	 * [grupo_empresarial description]
	 * @param  [type] $id_cliente [description]
	 * @return [type]             [description]
	 */
	function grupo_empresarial($id_cliente) {	
		return $this->oCliente->find('',array(
				'join' => array(
						'clause' => array('gruemp_grupo_empresarial' => 'gruemp_id_usuario = usu_id'),
						'type' => 'INNER'
					),
				'conditions' => array('usu_id' => $id_cliente)
			));
		if ($query->num_rows() > 0) 
			return $query->result();
		else 
			return false;
	}
	/**
	 * [insert_solicitud description]
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	function insert_solicitud($data) {
		$this->dbUse->trans_begin();
		$this->dbUse->insert('sol_solicitud_mstr', $data);
		if ($this->dbUse->trans_status() === FALSE) {
			$this->dbUse->trans_rollback();
			return false;
		}
		return $this->dbUse->insert_id();
	}
	/**
	 * [insert_solicitud_detalle description]
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	function insert_solicitud_detalle($data) {
	//	$this->db->trans_begin();
		$this->dbUse->insert('soldet_solicitud_detalle_det', $data);
		if ($this->dbUse->trans_status() === FALSE) {
			$this->dbUse->trans_rollback();
			return false;
		}
		$this->dbUse->trans_commit();
		return true;
	}
	/**
	 * [update_solicitud description]
	 * @param  [type] $estatus [description]
	 * @param  [type] $id      [description]
	 * @return [type]          [description]
	 */
	function update_solicitud($estatus,$id){
		$this->dbUse->trans_begin();
		$this->dbUse->update('sol_solicitud_mstr', array('sol_estatus' => $estatus), array('sol_id_solicitud' => $id));
		if ($this->dbUse->trans_status() === FALSE) {
			$this->dbUse->trans_rollback();
			return false;
		}
		$this->dbUse->trans_commit();
		return true;
	}

	function solicitud_correos($id_solicitud_correo){
		return $this->oSol->find('first',array(
				'field' => array('sol_id_solicitud','sol_correos','sol_empresa'),
				'conditions' => array('sol_id_solicitud' => $id_solicitud_correo)
			));	
	}

}

/* End of file pasos_model.php */
/* Location: ./application/pasos/models/pasos_model.php */