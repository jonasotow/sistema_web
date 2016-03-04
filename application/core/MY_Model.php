<?php if ( ! defined('BASEPATH')) die('No direct script access allowed');

class MY_Model extends CI_Model
{
	private $_table_prefix;
	public $insert_id;
	public $dbUse;
	
	/* Constructor de CI_Model */
	function __construct($dbConfig = null) {
        parent::__construct();
    	if($dbConfig != null)
    		$this->dbUse = $this->load->database($dbConfig, TRUE);
    	else
    		$this->dbUse = $this->db;
        $this->_table_prefix = '';
        $this->load->helper('array');
        $this->insert_id = null;
    }
    
    /**
   	* create a query to de database and return it's results 
   	* @param String $type [all|first|count|list] 
   	* @param Array $params array([conditions|fields|order|limit|join]) 
   	* @return Object or Array
    */
    function find($type,$params=array()) { //result of the query 
    	
		$result = FALSE; //set the name of the table where the query will run 
		$this->dbUse->from($this->_table_prefix.$this->table_name); //creates the where clause if $params['conditions'] is defined 
		if(isset($params['conditions'])) { 
			//where options => array('name !=' => $name, 'id &lt;' => $id, 'date &gt;' => $date, 'field'=>$value); 
			$this->dbUse->where($params['conditions']); 
		} //creates the join clause if $params['join'] is defined 
		if(isset($params['like'])) { 
			$this->dbUse->like($params['like']); 
		}
		if(isset($params['join'])) { 
			foreach($params['join']['clause'] as $join_table => $join_conditions) { 
				if(isset($params['join']['type'])) 
					$this->dbUse->join($join_table, $join_conditions, $params['join']['type']); 
				else 
					$this->dbUse->join($join_table, $join_conditions); 
			}
		} //creates the fields clause if $params['fields'] is defined 
		if(isset($params['fields'])) { 
			if(isset($params['distinct']))
				$this->dbUse->distinct();
			$this->dbUse->select($params['fields']); 
		} //creates the order clause if $params['order'] is defined 
		if(isset($params['order'])) { 
			foreach($params['order'] as $field => $sort) { 
				$this->dbUse->order_by($field,$sort); 
			}
		} //creates the group clause if $params['group'] is defined 
		if(isset($params['group'])) { 
			$this->dbUse->group_by($params['group']); 
		} 
		if($type=='count') 
			$result = $this->dbUse->count_all_results(); 
		else { 
			//creates the limit clause if $params['limit'] is defined and type!=first 
			if($type=='first')
				$this->dbUse->limit(1);
			else if(isset($params['limit']) && !empty($params['limit'])) { 
				if(is_array($params['limit'])) { 
					$cnt_params = count($params['limit']); 
						if($cnt_params) { 
							if($cnt_params==1) 
								$this->dbUse->limit($params['limit'][0]); 
							else {
								/* $this->dbUse->limit($params['limit'][0],((int) $params['limit'][1] - 1) * (int) $params['limit'][0] < 0 ? 0 : ((int) $params['limit'][1] - 1) * (int) $params['limit'][0]);  */
								$this->dbUse->limit($params['limit'][0],(int) $params['limit'][1]); 
							}
						} 
				} 
				else 
					$this->dbUse->limit($params['limit']); 
			} 
			$query = $this->dbUse->get(); 
				switch($type) { 
					case 'list': { 
						$result = array(); //return the result in array format 
						$tmp_result = $query->result_array(); 
						$fields = isset($params['fields']) === FALSE ? $this->dbUse->list_fields($this->table_name) : $params['fields'];
						$keys = array_values($fields);
						foreach($tmp_result as $tmp) {
							foreach($keys as $key){
								$result[$key] = element($key,$tmp,'');
							}
						} 
						break; 
					}
					case 'first': { 
						//return just the first result in object format 
						$result = $query->row(); 
						break;
					}
					case 'result': {
						//return the $query result without format
						$result = $query;
						break;
					}
					default: { 
						//return the results in object format 
						$result = $query->result(); 
					}
				} 
			}
		return $result;
	}
	
	/** 
	* * saves or updates a record in the database 
	* @param Array $params fields to be saved 
	* @return Int the id of the modified record in the database if success, FALSE otherwise 
	*/ 
	function save($params) { 
		$already_exists = FALSE; 
		$params = $this->_object_to_array($params);
		$fields = $this->dbUse->field_data($this->table_name);
		foreach($fields as $field => $valor){
			if ($valor->primary_key == 1)
				$id_name = $valor->name;
		}
		if(is_array($params)) { 
			$id = preg_grep('/'.$id_name.'$/',array_keys($params));
			if(count($id)) { 
				//check if the record already exists in the database 
				$found_record = $this->find('count', array('conditions'=>array( $id_name => $params[$id_name]))); 
				if($found_record) 
					$already_exists = TRUE;
			} 
			//set the fields to save 
			$this->dbUse->set($params); 
			//if the record already exists, just do an update, otherwise, do an insert 
			if($already_exists) { 
				$this->dbUse->where($id_name,$params[$id_name]); 
				if($this->dbUse->update($this->_table_prefix.$this->table_name))
					return $params[$id_name]; 
// 					throw new Excepcion(18,array('Algo'));
// 				else 
// 					throw new Excepcion(18,array('Algo'));
			} else { 
				$this->dbUse->insert($this->_table_prefix.$this->table_name); 
				if($this->dbUse->affected_rows())// { 
					//make a query to find the id of the newly inserted record 
					$this->insert_id = $this->dbUse->insert_id();
					return $this->dbUse->insert_id();
// 					throw new Excepcion(18,array('Algo'));
// 				} else 
// 					throw new Excepcion(18,array('Algo'));
			} 
		} 
		throw new Excepcion(18,array('Algo'));
	}

	/** 
	* * deletes records in the database 
	* @param Array $params conditions to match the record(s) that will be deleted 
	* @return INT the number of deleted rows if success, FALSE otherwise */ 
//	function delete_t($params) { 
		// $this->dbUse->update($this->table_name, array('activo' => 0 ), array('idHoja_tecnica' => $id));
//		if($this->dbUse->update($this->_table_prefix.$this->table_name, $params,)) 
//			return $this->dbUse->affected_rows(); 
//		else return FALSE; 
//	}
	
	/** 
	* * deletes records in the database 
	* @param Array $params conditions to match the record(s) that will be deleted 
	* @return INT the number of deleted rows if success, FALSE otherwise */ 
	function delete($params) { 
		if($this->dbUse->delete($this->_table_prefix.$this->table_name, $params)) 
			return $this->dbUse->affected_rows(); 
		else return FALSE; 
	}
	
	/**
	 * Object to Array
	 *
	 * Takes an object as input and converts the class variables to array key/vals
	 *
	 * @param	object
	 * @return	array
	 */
	public function _object_to_array($object){
		if ( ! is_object($object))
			return $object;

		$array = array();
		foreach (get_object_vars($object) as $key => $val){
			// There are some built in keys we need to ignore for this conversion
			if ( ! is_object($val) && ! is_array($val) && $key != '_parent_name')
				$array[$key] = $val;
		}

		return $array;
	}
	
	public function schema(){
		return array_values($this->dbUse->list_fields($this->table_name));
	}
	
	public function array_schema(){
		$return = array();
		$lista = $this->dbUse->list_fields($this->table_name);
		foreach($lista as $field){
		   $return[$field] = '';
		}
		return $return;
	}
	
	public function field_data(){
		return $this->dbUse->field_data($this->table_name);
	}

}