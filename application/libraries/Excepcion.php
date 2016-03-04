<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//     protected $message = 'Unknown exception';   // mensaje de excepción
//     private   $string;                          // caché de __toString
//     protected $code = 0;                        // código de excepción definido por el usuario
//     protected $file;                            // nombre de archivo fuente de la excepción
//     protected $line;                            // línea fuente de la excepción
//     private   $trace;                           // determinación del origen
//     private   $previous;                        // excepción previa si la excepción está anidada
// 
//     public function __construct($message = null, $code = 0, Exception $previous = null);
// 
//     final private function __clone();           // Inhibe la clonación de excepciones.
// 
//     final public  function getMessage();        // mensaje de excepción
//     final public  function getCode();           // código de excepción
//     final public  function getFile();           // nombre de archivo fuente
//     final public  function getLine();           // línea fuente
//     final public  function getTrace();          // un array de backtrace()
//     final public  function getPrevious();       // excepción anterior
//     final public  function getTraceAsString();  // string formateado del seguimiento del origen
// 
//     /* Sobrescribible */
//     public function __toString();               // string formateado para mostrar


class Excepcion extends Exception {
	protected $_errores_msg = array(
		//Errores Entradas
		1 => "ERROR: Al momento de agregar el registro de entrada.",
		2 => "ERROR: Al agregar la requisici&oacute;n",
		3 => "ERROR: El periodo no existe, A&ntilde;o: %s, Periodo: %s",
		4 => "ERROR: Inventario insuficiente para el articulo %s",
		5 => "ERROR: Cantidad en lote %s es cero.",
		6 => "ERROR: Cantidad a consumir es mayor al inventario para el lote %s.",
		7 => "ERROR: El periodo ha sido cerrado, A&ntilde;o: %s, Periodo: %s, Almac&eacute;n: %s",
		8 => "ERROR: Al momento de agregar el registro de salida.",
		9 => "ERROR: Al momento de agregar el registro de %s",
		10 => "Los datos de %s estan vacios",
		11 => "Los datos han sido actualizados con &eacute;xito",
		12 => "ERROR: Al momento de actualizar el registro",
		13 => "ERROR: No existe el articulo %s",
		14 => "ERROR: No existe la requisicion %s",
		15 => "ERROR: No existe el almac&eacute;n %s",
		16 => "ERROR: No existe el proveedor %s",
		17 => "ERROR: No existe el cliente %s",
		18 => "ERROR: Al agregar el status %s",
		19 => "ERROR: Al agregar el periodo %s del a&ntilde;o %s.",
		20 => "ERROR: Deben de existir Almacenes antes de agregar un articulo. favor de reintentar.",
		21 => "ERROR: Al momento de agregar el an&aacute;lisis %s, favor de reintentar.",
		22 => "ERROR: No existe el status %s",
		23 => "ERROR: El articulo %s tiene status %s no es posible agregarlo a %s, favor de reintentar.",
		24 => "ERROR: El status %s tiene restringidas las operaciones tipo %s",
		//Compras
		96  => "Orden de compra %s actualizada correctamente.",
		97  => "Orden de compra %s agregada correctamente.",
		98  => "ERROR: La compra debe de llevar detalle, favor de reintentar",
		99  => "Recepci&oacute;n de la orden %s con exito",
		100 => "Error al agregar la Compra %s, favor de reintentar.",
		101 => "Error al agregar el detalle de la Compra %s, favor de reintentar.",
		102 => "La orden %s se encuentra cerrada, favor de reintentar.",
		103 => "Error al actualizar la orden de compra %s, favor de reintentar.",
		104 => "La orden %s no se puede eliminar, tiene cantidad recibida.",
		105 => "ERROR: No existe la orden de compra %s, favor de reintentar.",
		106 => "ERROR: No existe detalle de la orden de compra %s, favor de reintentar.",
		107 => "ERROR: La L&iacute;nea %s de la orden %s ah cambiado, favor de reintentar.",
		108 => "ERROR: La orden %s se encuentra cerrada, favor de reintentar.",
		109 => "La orden %s se ha eliminado correctamente.",
		//Requisiciones
		110 => "La requisicion %s ya se encuentra aprobada y no se puede eliminar.",
		111 => "La requisicion %s ya se encuentra aprobada y no se puede actualizar.",
		//Inventarios
		200 => "Ajuste realizado con exito.",
		//Solicitudes
		300 => "ERROR: La solicitud debe de llevar por lo menos un an&aacute;lisis, favor de reintentar.",
		301 => "ERROR: No existe un primer consumo, se tiene que consumir antes de reportart.",
		302 => "Solicitud reportada con &eacute;xito.",
		//Status
		400 => "ERROR: El Status %s no existe, favor de reintentar.",
		401 => "ERROR: Movimiento %s no permitido para status %s, favor de reintentar.",
		402 => "ERROR: el status %s no tiene cantidad disponible, favor de reintentar.",
		403 => "ERROR: el status %s no se puede eliminar porque existen registro de productos que lo contienen, favor de reintentar."
	);
	protected $_parametros;
	
	 public function __construct($code = 0, $params = null) {
		$this->_parametros = $params;
        parent::__construct('', $code, null);
    }
    
    public function __toString() {
        return "<div id='msgError' align='center'>". vsprintf($this->_errores_msg[$this->code],$this->_parametros) ."</div>";
    }
    
    public function __toStringNoFormat(){
	    return vsprintf($this->_errores_msg[$this->code],$this->_parametros);
    }
}


// END Excepciones class

/* End of file Excepciones.php */
/* Location: ./libraries/Excepciones.php */