<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * tipo_model.php
 *
 * @package None
 * @subpackage None
 * @category Model
 * @author Daniel Villa
 */

class Bioeconomico_Desarrollo_Model extends My_Model {
    public $table_name;
    public $schema;
    public $schema_add;
    public $schema_up;

    public function __construct($db = null){
        parent::__construct($db);
        $this->table_name = "des_lotes";
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
                'label' => 'Guardar',
                'class' => 'btn btn-primary',
                'id' => 'guardar_especie'
            )
        );
        $this->schema = array(
            'Descriptivo' => array(
                'class' => 'desarrollo',
                'id' => 'desarrollo',
                'idLotes' => array(
                    'name' => 'Id',
                    'tipo' => 'int',
                    'lenght' => 11,
                    'null' => FALSE,
                    'primary' => TRUE,
                    'update' => FALSE,
                    'type' => 'hidden',
                    'class' => 'form-control'
                ),
                'nombre' => array(
                    'name' => 'Nombre / Lugar',
                    'tipo' => 'varchar',
                    'lenght' => 50,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'text',
                    'class' => 'form-control'
                ),
                'nolote' => array(
                    'name' => 'No. Lote',
                    'tipo' => 'varchar',
                    'lenght' => 5,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'number',
                    'class' => 'form-control'
                ),
                'nocabezas' => array(
                    'name' => 'No. Cabezas',
                    'tipo' => 'varchar',
                    'lenght' => 5,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'number',
                    'class' => 'form-control',
                    'js' => ' onchange = calculos()'
                )
            ),
            'Inicio' => array(
                'class' => 'Inicio',
                'id' => 'Inicio',
                'fechaentrada' => array(
                    'name' => 'Fecha de Entrada',
                    'tipo' => 'varchar',
                    'lenght' => 10,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'date',
                    'class' => 'form-control',
                    'js' => ' onchange = calculos()'
                ),
                'fechasalida' => array(
                    'name' => 'Fecha de Salida',
                    'tipo' => 'varchar',
                    'lenght' => 10,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'date',
                    'class' => 'form-control',
                    'js' => ' onchange = calculos()'
                ),
                'NoDiasFechas' => array(
                    'name' => 'No. Dias Lote',
                    'tipo' => 'varchar',
                    'lenght' => 0,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => FALSE,
                    'type' => 'text',
                    'class' => 'form-control'
                )
            ),
            'Pesos' => array(
                'class' => 'Pesos',
                'id' => 'Pesos',
                'PesoVivoIni' => array(
                    'name' => 'Peso vivo inicial, kg',
                    'tipo' => 'varchar',
                    'lenght' => 5,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'text',
                    'class' => 'form-control',
                    'js' => ' onKeyUp = calculos()'
                ),
                'PesoVivoOri' => array(
                    'name' => 'Peso vivo orígen, kg',
                    'tipo' => 'varchar',
                    'lenght' => 5,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'text',
                    'class' => 'form-control',
                    'js' => ' onKeyUp = calculos()'
                ),
                'Merma' => array(
                    'name' => 'Merma, %',
                    'tipo' => 'varchar',
                    'lenght' => 5,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => FALSE,
                    'type' => 'text',
                    'class' => 'form-control'
                ),
                'PesoVivoSal' => array(
                    'name' => 'Peso vivo salida, kg',
                    'tipo' => 'varchar',
                    'lenght' => 5,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'text',
                    'class' => 'form-control',
                    'js' => ' onKeyUp = calculos()'
                ),
                'DesctoPv' => array(
                    'name' => 'Descuento PV,  %',
                    'tipo' => 'varchar',
                    'lenght' => 5,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'text',
                    'class' => 'form-control',
                    'js' => ' onKeyUp = calculos()'
                ),
                'PesoVidaSalidaReal' => array(
                    'name' => 'Peso vivo salida real, kg',
                    'tipo' => 'varchar',
                    'lenght' => 0,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => FALSE,
                    'type' => 'text',
                    'class' => 'form-control'
                )
            ),
            'Muertes' => array(
                'class' => 'Muertes',
                'id' => 'Muertes',
                /*'FechaMuerte[]' => array(
                    'name' => 'Fecha Muerte',
                    'tipo' => 'varchar',
                    'lenght' => 10,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'date',
                    'class' => 'form-control',
                    'js' => ' onchange = calculos()'
                ),
                'NumeroMuerte[]' => array(
                    'name' => 'Numero de Muertes',
                    'tipo' => 'varchar',
                    'lenght' => 5,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'number',
                    'class' => 'form-control',
                    'js' => ' onchange = calculos()'
                ),
                'MuertosPradera[]' => array(
                    'name' => 'Dias en Pradera',
                    'tipo' => 'varchar',
                    'lenght' => 5,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => FALSE,
                    'type' => 'text',
                    'class' => 'form-control'
                ),
                'DiasInvertidos[]' => array(
                    'name' => 'Dias Invertidos',
                    'tipo' => 'varchar',
                    'lenght' => 5,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => FALSE,
                    'type' => 'text',
                    'class' => 'form-control'
                )*/
            ),
            'Inventarios' => array(
                'class' => 'Inventarios',
                'id' => 'Inventarios',
                'InvFinal' => array(
                    'name' => 'Inventario final, cab',
                    'tipo' => 'varchar',
                    'lenght' => 5,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => FALSE,
                    'type' => 'text',
                    'class' => 'form-control'
                ),
                'DiasCabCiclo' => array(
                    'name' => 'Días / cabs / ciclo',
                    'tipo' => 'varchar',
                    'lenght' => 5,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => FALSE,
                    'type' => 'text',
                    'class' => 'form-control'
                ),
                'GanciaTotalCabKilos' => array(
                    'name' => 'Ganancia total/cab, kg vendidos',
                    'tipo' => 'varchar',
                    'lenght' => 5,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => FALSE,
                    'type' => 'text',
                    'class' => 'form-control'
                ),
                'GananciaTotalLote' => array(
                    'name' => 'Ganancia total/lote, kg',
                    'tipo' => 'varchar',
                    'lenght' => 5,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => FALSE,
                    'type' => 'text',
                    'class' => 'form-control'
                ),
                'Gdp' => array(
                    'name' => 'GDP, kg',
                    'tipo' => 'varchar',
                    'lenght' => 5,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => FALSE,
                    'type' => 'text',
                    'class' => 'form-control'
                )
            ),
            'Ingresos' => array(
                'class' => 'Ingresos',
                'id' => 'Ingresos',
                'VentaKg' => array(
                    'name' => 'Venta, $/kg',
                    'tipo' => 'varchar',
                    'lenght' => 5,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'text',
                    'class' => 'form-control',
                    'js' => ' onKeyUp = calculos()'
                ),
                'IngresoLote' => array(
                    'name' => 'Ingreso lote/$',
                    'tipo' => 'varchar',
                    'lenght' => 5,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => FALSE,
                    'type' => 'text',
                    'class' => 'form-control'
                ),
                'IngresoCab' => array(
                    'name' => 'Ingreso/cab',
                    'tipo' => 'varchar',
                    'lenght' => 5,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => FALSE,
                    'type' => 'text',
                    'class' => 'form-control'
                )
            ),
            'Egresos' => array(
                'class' => 'Egresos',
                'id' => 'Egresos',
                'CompraKg' => array(
                    'name' => 'Compra, $/kg',
                    'tipo' => 'varchar',
                    'lenght' => 5,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'text',
                    'class' => 'form-control',
                    'js' => ' onKeyUp = calculos()'
                ),
                'EgresoLote' => array(
                    'name' => '$/lote ',
                    'tipo' => 'varchar',
                    'lenght' => 5,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => FALSE,
                    'type' => 'text',
                    'class' => 'form-control'
                ),
                'EgresoCab' => array(
                    'name' => '$/cab',
                    'tipo' => 'varchar',
                    'lenght' => 5,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => FALSE,
                    'type' => 'text',
                    'class' => 'form-control'
                )
            ),
            'Rentabilidad' => array(
                'class' => 'Rentabilidad',
                'id' => 'Rentabilidad',
                'RentaPradera' => array(
                    'name' => 'Renta pradera, $/cab/día *',
                    'tipo' => 'varchar',
                    'lenght' => 5,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'text',
                    'class' => 'form-control',
                    'js' => ' onKeyUp = calculos()'
                ),
                'RentaPraderaLote' => array(
                    'name' => 'Renta pradera, $/lote',
                    'tipo' => 'varchar',
                    'lenght' => 5,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => FALSE,
                    'type' => 'text',
                    'class' => 'form-control'
                )
            ),
            'Suplementos' => array(
                'class' => 'Suplementos',
                'id' => 'Suplementos',
                /*'Suplemento' => array(
                    'name' => 'Suplemento',
                    'tipo' => 'varchar',
                    'lenght' => 5,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'dropdown',
                    'class' => 'form-control',
                    'data' => array(
                        '' => 'Seleccione un suplemento',
                        'mineral' => 'Mineral',
                        'concentrado'=> 'Concentrado',
                        'forraje' => 'Forraje',
                        'otro' => 'Otro'
                    )
                ),
                'PrecioKg' => array(
                    'name' => '$/kg',
                    'tipo' => 'varchar',
                    'lenght' => 5,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'text',
                    'class' => 'form-control',
                    'js' => ' onKeyUp = calculos()'
                ),
                'ConsumoKgCabDia' => array(
                    'name' => 'Consumo kg/cab/día',
                    'tipo' => 'varchar',
                    'lenght' => 5,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'text',
                    'class' => 'form-control',
                    'js' => ' onKeyUp = calculos()'
                ),
                'Nodias' => array(
                    'name' => 'No días',
                    'tipo' => 'varchar',
                    'lenght' => 5,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'number',
                    'class' => 'form-control',
                    'js' => ' onchange = calculos()'
                ),
                'PLote0' => array(
                    'name' => '$/lote',
                    'tipo' => 'varchar',
                    'lenght' => 5,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => FALSE,
                    'type' => 'text',
                    'class' => 'form-control'
                )*/
            ),
            'Totales' => array(
                'class' => 'Totales',
                'id' => 'Totales',
                'TotalPastoreoAlimentoLote' => array(
                    'name' => 'Total pastoreo + alimento, $/lote',
                    'tipo' => 'varchar',
                    'lenght' => 5,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => FALSE,
                    'type' => 'text',
                    'class' => 'form-control'
                ),
                'AlimentacionTotal' => array(
                    'name' => 'Alimento/total,  %  **',
                    'tipo' => 'varchar',
                    'lenght' => 5,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'text',
                    'class' => 'form-control',
                    'js' => ' onKeyUp = calculos()'
                ),
                'InvTotalOperativaLote' => array(
                    'name' => 'Inversión total operativa/lote',
                    'tipo' => 'varchar',
                    'lenght' => 5,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => FALSE,
                    'type' => 'text',
                    'class' => 'form-control'
                ),
                'InvGanadoOperativoMuerteLote' => array(
                    'name' => 'Inversión ganado+operativo+muertes/lote',
                    'tipo' => 'varchar',
                    'lenght' => 5,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => FALSE,
                    'type' => 'text',
                    'class' => 'form-control'
                ),
                'UtilidadPerdidaLote' => array(
                    'name' => 'Utilidad o pérdida/lote',
                    'tipo' => 'varchar',
                    'lenght' => 5,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => FALSE,
                    'type' => 'text',
                    'class' => 'form-control'
                ),
                'UtilidadPerdidaCab' => array(
                    'name' => 'Utilidad o pérdida / cab',
                    'tipo' => 'varchar',
                    'lenght' => 5,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => FALSE,
                    'type' => 'text',
                    'class' => 'form-control'
                ),
                'RentabilidadAnual' => array(
                    'name' => 'Rentabilidad, % anual',
                    'tipo' => 'varchar',
                    'lenght' => 5,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => FALSE,
                    'type' => 'text',
                    'class' => 'form-control'
                )
            ),
            'Utilidad' => array(
                'class' => 'Utilidad',
                'id' => 'Utilidad',
                'DiferenciaCompraVentaCab' => array(
                    'name' => 'Diferencia compra - venta, $/cab',
                    'tipo' => 'varchar',
                    'lenght' => 5,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => FALSE,
                    'type' => 'text',
                    'class' => 'form-control'
                ),
                'UtilidadPerdidaKgHechosCab' => array(
                    'name' => 'Utilidad o pérdida en los kgs hechos, $/cab',
                    'tipo' => 'varchar',
                    'lenght' => 5,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => FALSE,
                    'type' => 'text',
                    'class' => 'form-control'
                ),
                'InversionTotalOperativoCabDia' => array(
                    'name' => 'Inversión tot operativo por cab día',
                    'tipo' => 'varchar',
                    'lenght' => 5,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => FALSE,
                    'type' => 'text',
                    'class' => 'form-control'
                ),
                'KgProducido' => array(
                    'name' => '$/kg producido',
                    'tipo' => 'varchar',
                    'lenght' => 5,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => FALSE,
                    'type' => 'text',
                    'class' => 'form-control'
                ),
                'UtilidadPerdidaKgHecho' => array(
                    'name' => 'Utilidad o pérdida / kg hecho',
                    'tipo' => 'varchar',
                    'lenght' => 5,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => FALSE,
                    'type' => 'text',
                    'class' => 'form-control'
                ),
                'UtilidadPerdidaCabDifComVenKgHechos' => array(
                    'name' => 'Utilidad o pérdida / cab, dif com-ven + kg hechos',
                    'tipo' => 'varchar',
                    'lenght' => 5,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => FALSE,
                    'type' => 'text',
                    'class' => 'form-control'
                ),
                'ValorEconomicoMermaInicialKg' => array(
                    'name' => 'Valor económico de la merma inicial, kg',
                    'tipo' => 'varchar',
                    'lenght' => 5,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => FALSE,
                    'type' => 'text',
                    'class' => 'form-control'
                ),
                'UtilidadPerdidaCabT' => array(
                    'name' => 'Utilidad o pérdida $ / cab',
                    'tipo' => 'varchar',
                    'lenght' => 5,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => FALSE,
                    'type' => 'text',
                    'class' => 'form-control'
                ),
                'PerdidaKgHechosNoVendidos' => array(
                    'name' => 'Pérdia por kgs hechos no vendidos',
                    'tipo' => 'varchar',
                    'lenght' => 5,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => FALSE,
                    'type' => 'text',
                    'class' => 'form-control'
                )
            )
        );
    }

    /*public function guardar_modelo($datos){
        $data = array(
            'nolote' => $datos['nolote'],
            'nocabezas' => $datos['nocabezas'],
            'fechaentrada' => date("Y-m-d", strtotime($datos['fechaentrada'])),
            'fechasalida' => date("Y-m-d", strtotime($datos['fechasalida'])),
            'PesoVivoIni' => $datos['PesoVivoIni'],
            'PesoVivoOri' => $datos['PesoVivoOri'],
            'PesoVivoSal' => $datos['PesoVivoSal'],
            'DesctoPv' => $datos['DesctoPv'],
            'VentaKg' => $datos['VentaKg'],
            'CompraKg' => $datos['CompraKg'],
            'RentaPradera' => $datos['RentaPradera'],
            'AlimentacionTotal' => $datos['AlimentacionTotal'],
            'nombre' => $datos['nombre'],
            'status' => 1,
            'NoDiasFechas' => $datos['NoDiasFechas'],
            'Merma' => $datos['Merma'],
            'PesoVidaSalidaReal' => $datos['PesoVidaSalidaReal'],
            'InvFinal' => $datos['InvFinal'],
            'DiasCabCiclo' => $datos['DiasCabCiclo'],
            'GanciaTotalCabKilos' => $datos['GanciaTotalCabKilos'],
            'GananciaTotalLote' => $datos['GananciaTotalLote'],
            'Gdp' => $datos['Gdp'],
            'IngresoLote' => $datos['IngresoLote'],
            'IngresoCab' => $datos['IngresoCab'],
            'EgresoLote' => $datos['EgresoLote'],
            'EgresoCab' => $datos['EgresoCab'],
            'RentaPraderaLote' => $datos['RentaPraderaLote'],
            'TotalPastoreoAlimentoLote' => $datos['TotalPastoreoAlimentoLote'],
            'InvTotalOperativaLote' => $datos['InvTotalOperativaLote'],
            'InvGanadoOperativoMuerteLote' => $datos['InvGanadoOperativoMuerteLote'],
            'UtilidadPerdidaLote' => $datos['UtilidadPerdidaLote'],
            'UtilidadPerdidaCab' => $datos['UtilidadPerdidaCab'],
            'RentabilidadAnual' => $datos['RentabilidadAnual'],
            'DiferenciaCompraVentaCab' => (!$datos['DiferenciaCompraVentaCab'] ? 0 : $datos['DiferenciaCompraVentaCab']),
            'UtilidadPerdidaKgHechosCab' => (!$datos['UtilidadPerdidaKgHechosCab'] ? 0 : $datos['UtilidadPerdidaKgHechosCab']),
            'InversionTotalOperativoCabDia' => (!$datos['InversionTotalOperativoCabDia'] ? 0 : $datos['InversionTotalOperativoCabDia']),
            'KgProducido' => (!$datos['KgProducido'] ? 0 : $datos['KgProducido']),
            'UtilidadPerdidaKgHecho' => (!$datos['UtilidadPerdidaKgHecho'] ? 0 : $datos['UtilidadPerdidaKgHecho']),
            'UtilidadPerdidaCabDifComVenKgHechos' => (!$datos['UtilidadPerdidaCabDifComVenKgHechos'] ? 0 : $datos['UtilidadPerdidaCabDifComVenKgHechos']),
            'ValorEconomicoMermaInicialKg' => (!$datos['ValorEconomicoMermaInicialKg'] ? 0 : $datos['ValorEconomicoMermaInicialKg']),
            'UtilidadPerdidaCabT' => (!$datos['UtilidadPerdidaCabT'] ? 0 : $datos['UtilidadPerdidaCabT']),
            'PerdidaKgHechosNoVendidos' => (!$datos['PerdidaKgHechosNoVendidos'] ? 0 : $datos['PerdidaKgHechosNoVendidos']),
            'idUsuario' => $this->session->userdata('logged_user')->usu_id,
        );
        $this->db->insert('des_lotes',$data);
    } */

    public function guardarMuertes($datos_muertes){
      $this->dbUse->trans_begin();
      $this->dbUse->insert('des_muertes', $datos_muertes);
      if ($this->dbUse->trans_status() === FALSE){
        $this->dbUse->trans_rollback();
        return FALSE;
      }
      $this->dbUse->trans_commit();
      return TRUE;
    }

    public function guardarSuplementos($datos_suplementos){
      $this->dbUse->trans_begin();
      $this->dbUse->insert('des_suplementos', $datos_suplementos);
      if ($this->dbUse->trans_status() === FALSE){
        $this->dbUse->trans_rollback();
        return FALSE;
      }
      $this->dbUse->trans_commit();
      return TRUE;
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
    $this->db->update('des_lotes', array('status' => 0 ), array('idLotes' => $id));
    if ($this->db->trans_status() === FALSE) {
        $this->db->trans_rollback();
        return false;
    }
    $this->db->trans_commit();
    return true;
  }
}