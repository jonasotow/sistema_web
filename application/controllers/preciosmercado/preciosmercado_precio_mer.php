<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Preciosmercado_Precio_Mer extends MY_Controller {

	public function __construct(){
        parent::__construct();
        $dbBase = $this->load->database('precios',TRUE);
    	$this->template['module'] = 'local';
        $this->load->model('preciosmercado/precio_mer_model');
        $this->load->model('preciosmercado/registro_compras_model');
    }
	
	public function index()
	{
		$rows = $this->precio_mer_model->tipo();
		$select = "<select class='form-control' name='tipo' type='select' id='tipo'>";
		$select .= "<option value=''>Seleccione un Tipo</option>";
		foreach($rows as $row){
			$select .= "<option value=".$row->idtipo.">".$row->tipo."</option>";
		}
		$select .= "</select>";
		$this->template['tipos'] = $select;
        $this->template['titulo'] = 'Tabla Precios de Mercado';
        $this->_run('precios_view');
		
	}
	
	public function llenar_select(){
		$option = "";
        if($this->input->post('tipo'))
        {
	        $id = $this->input->post('select');
	        switch($id){
	            case 'tipo':
	            	$option = 'clase';
	            	break;
	            case 'clase':
	            	$option = 'region';
	            	break;
	            case 'region':
	            	$option  = 'fuente';
	            	break;
            }
            $tipo = $this->input->post('tipo');
            $clases = $this->input->post('clase');
            if($option != 'fuente')
            	$clase = $this->precio_mer_model->{$option}($tipo);
            else
            	$clase = $this->precio_mer_model->fuente($tipo,$clases);
            $clase['tipo'] = $option;
            echo json_encode($clase);
        }
	}
	
	public function guardar_compra(){
        $idtipo_clase = $this->input->post('idtipo_clase');
        $idclase_region_fuente = $this->input->post('idclase_region_fuente'); 
        $tipo_cambio = $this->input->post('tipo_de_cambio'); 
        $precio = $this->input->post('precio');
        $fecha = $this->input->post('fecha');

        $precio_general = $this->input->post('precio_gen');
        $tipo_general = $this->input->post('tipo_gen');

        //$registro_existente = $this->precio_mer_model->validar_registro($idclase_region_fuente,$fecha);

        //if($registro_existente == '0'){
        for($i = 0; $i <= count($precio); $i++){
            if($precio[$i] != "" and $tipo_cambio[$i] != "" and $fecha[$i] != ""){
                $this->precio_mer_model->insertar_compra($idtipo_clase,$idclase_region_fuente,$tipo_cambio[$i],$precio[$i],$fecha[$i]);
            } 
        }
        /* }else{

        } */
    }

    public function buscar_capturas(){
        $tipo = $this->input->post('tipo');
        $clase = $this->input->post('clase');
        $region = $this->input->post('region');
        $fuente = $this->input->post('fuente');

        $datos = $this->precio_mer_model->obtener_registros_capturados($tipo,$clase,$region,$fuente);

        ?>
           <!-- &nbsp;<span><b>:::::::: <?=$datos->tipo?> / <?=$datos->clase?> / <?=$datos->region?> / <?=$datos->descripcion?> ::::::::</b></span> -->
        <thead>
                <tr>
                    <td colspan="5" align="center">
                        <button type="submit" class="btn btn-default">Guardar Registros</button>
                    </td>
                </tr>
                <tr>
                    <td colspan="5">&nbsp;</td>
                </tr>
                <tr>
                    <th>Id</th>
                    <th>Selecci&oacute;n</th>
                    <th>Precio</th>
                    <th>Tipo de cambio</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
        <?php
        if(count($datos)>0){

            //Recogemos de una galleta el valor escrito por javascript
            $fechas = $_COOKIE["array"];
            
            $array_fechas = explode(","  , $fechas);

            $compras = $this->precio_mer_model->obtener_compras($datos-> idtipo_clase,$datos-> idclase_region_fuente);
            if(count($compras)>0){
                $z = 1;
		        for($i = count($array_fechas)-2; $i >= 0; $i--){
                    foreach($compras as $fila){
                        if(date("d/m/Y", strtotime($fila->fecha)) == $array_fechas[$i]){
        ?>
                            <tbody>
                                <tr class="success">
                                    <td>Id</td>
                                    <td>&nbsp;</td>
                                    <td><input type="text" class="form-control" name="precio[]" id="precio" value="<?php /* echo '$'.number_format($fila-> precio, 2, '.', ''); */ echo $fila->precio; ?>"></td>
                                    <td><input type="text" class="form-control" name="tipo_de_cambio[]"  id="tipo_de_cambio" value="<?php /* echo '$'.number_format($fila-> tipo_cambio, 2, '.', ''); */ echo $fila->tipo_cambio; ?>"></td>
                                    <td colspan="2"><input type="text" class="form-control" name="fecha_2" id="fecha" disabled value="<?php echo date("d/m/Y", strtotime($fila->fecha)) ?>"></td>
                                    <input type="hidden" name="fecha[]" value="<?php echo $array_fechas[$i]; ?>">
                                </tr>
                            </tbody>
                            <input type="hidden" name="idtipo_clase" value="<?=$datos-> idtipo_clase?>">
                                <input type="hidden" name="idclase_region_fuente" value="<?=$datos-> idclase_region_fuente?>">
        <?php
                        } else {
						    if($z==count($compras)){
		?>
        				        <tbody>
                    		        <tr class="warning">
                                      <td>Id</td>
                                      <td align="center"><input type="checkbox" name="seleccion[]" value="<?php echo $i; ?>"></td>
                                      <td><input type="text" class="form-control" name="precio[]" id="<?php echo "precio".$i; ?>" onkeypress="return RevisarFormato(event)"></td>
                        		      <td><input type="text" class="form-control" name="tipo_de_cambio[]" id="<?php echo "tipo".$i; ?>" onkeypress="return RevisarFormato(event)"></td>
                        		      <td><input type="text" class="form-control" name="fecha_2" id="fecha" disabled value="<?php echo $array_fechas[$i]; ?>"></td>
                                      <input type="hidden" name="fecha[]" value="<?php echo $array_fechas[$i]; ?>">
                                    </tr>
                                </tbody>
                                <input type="hidden" name="idtipo_clase" value="<?=$datos-> idtipo_clase?>">
                                <input type="hidden" name="idclase_region_fuente" value="<?=$datos-> idclase_region_fuente?>">
        <?php
					   }
					   $z = $z + 1;
				    }
                }
				$z = 1;
            }
        ?>
            <!--<tbody>
                <tr>
                    <td>Id</td>
                    <td colspan="3" align="center"><button type="submit" class="btn btn-default">Guardar</button></td>
                </tr>
            </tbody>-->
        <?php
        }else{
            for($i = count($array_fechas)-2; $i >= 0; $i--){
        ?>
                <tbody>
                    <tr class="warning">
                        <td>Id</td>
                        <td><input type="checkbox" name="seleccion[]" value="<?php echo $i; ?>"></td>
                        <td><input type="text" class="form-control" name="precio[]" id="<?php echo "precio".$i; ?>" onkeypress="return RevisarFormato(event)"></td>
                        <td><input type="text" class="form-control" name="tipo_de_cambio[]" id="<?php echo "tipo".$i; ?>" onkeypress="return RevisarFormato(event)"></td>
                        <td><input type="text" class="form-control" name="fecha_2" id="fecha" disabled value="<?php echo $array_fechas[$i]; ?>"></td>
                        <input type="hidden" name="fecha[]" value="<?php echo $array_fechas[$i]; ?>">
                    </tr>
                </tbody>
                <input type="hidden" name="idtipo_clase" value="<?=$datos-> idtipo_clase?>">
                <input type="hidden" name="idclase_region_fuente" value="<?=$datos-> idclase_region_fuente?>">
        <?php
        }
        ?>
           <!-- <tbody><tr><td>Id</td><td colspan="4" align="center"><button type="submit" class="btn btn-default">Guardar</button></td></tr></tbody> -->
        <?php
    }
        } else{
        ?>
            <tbody><tr><td>Id</td><td colspan="4" align="center">::::::: No se encontro ningun registro :::::::</td></tr></tbody>
        <?php
        }
    }
}