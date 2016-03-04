<?php if ( ! defined('BASEPATH')) die('No direct script access allowed');

/**
 * Aplicaciones_model
 *
 * @package None
 * @subpackage None
 * @category Model
 * @author Alfredo Garcia
 * @link http://localhost/sistema_web/usuarios.php/
 */
class Bioeconomico_inicializacion_model extends My_Model {
    public $table_name;
    public $schema;
    public $schema_add;
    public $schema_up;

    /**
     * Carga todo las funciones que tiene disponile CI_Model propia de codeigniter
     */
    function __construct($db = null) {
        // llamma el Modelo constructor
        parent::__construct($db);
    //    $this->load->model('hojastecnicas/modelo_generico_model');
        $this->table_name = 'ini_inicializacion_mstr';
        $this->schema_add = array(
          'Borrar'  => array(
            'tipo'    => 'reset',
            'label'   => 'Limpiar',
            'class'   => 'btn btn-default',
            'id'      => 'limpiar'
          ),
          'Guardar' => array(
            'tipo'    => 'submit',
            'label'   => 'Guardar',
            'class'   => 'btn btn-primary',
            'id'      => 'guardar'
          )
        );
        $this->schema_up = array(
          'Borrar'   => array(
            'tipo'     => 'reset',
            'label'    => 'Limpiar',
            'class'    => 'btn btn-default',
            'id'       => 'limpiar'
          ),
          'Guardar'  => array(
            'tipo'     => 'submit',
            'label'    => 'Guardar',
            'class'    => 'btn btn-primary',
            'id'       => 'guardar'
          ),
          'Nuevo_registro' => array(
            'tipo'     => 'submit',
            'label'    => 'Nuevo',
            'class'    => 'btn btn-primary',
            'id'       => 'nuevo_registro',
            'value'    => 'Nuevo'
          )
        );
        $this->schema = array(
          'Proyeccíon' => array(
            'class'  => 'nombre_proyeccion',
            'id'     => 'nombre_proyeccion',
            'ini_nombre' => array(
              'name'    => 'Nombre',
              'tipo'    => 'int',
              'lenght'  => 255,
              'null'    => FALSE,
              'primary' => TRUE,
              'update'  => TRUE,
              'type'    => 'text',
              'class'   => 'form-control'
            )
          ),  
          'Datos de los vientres' => array(
            'class'  => 'inicializacion',
            'id'     => 'inicializacion',
            'ini_id' => array(
              'name'    => 'Id',
              'tipo'    => 'int',
              'lenght'  => 11,
              'null'    => FALSE,
              'primary' => TRUE,
              'update'  => FALSE,
              'type'    => 'hidden',
              'class'   => 'form-control'
            ),

            'ini_usuario_id' => array(
              'name'    => 'Descripcion',
              'tipo'    => 'varchar',
              'lenght'  => 100,
              'null'    => FALSE,
              'primary' => FALSE,
              'update'  => TRUE,
              'type'    => 'hidden',
              'class'   => 'form-control'
            ),

            'ini_vie_numero_vientres' => array(
              'name'    => '# de vientres',
              'tipo'    => 'varchar',
              'lenght'  => 100,
              'null'    => FALSE,
              'primary' => FALSE,
              'update'  => TRUE,
              'type'    => 'number',
              'class'   => 'form-control',
              'step'    => 'step="any"'
            ),

            'ini_vie_peso_vivo_promedio_kg' => array(
              'name'    => 'peso vivo promedio',
              'tipo'    => 'varchar',
              'lenght'  => 100,
              'null'    => FALSE,
              'primary' => FALSE,
              'update'  => TRUE,
              'type'    => 'number',
              'class'   => 'form-control',
              'step'    => 'step="any"'
            ),

            'ini_vie_precio_vientre' => array(
              'name'    => '$ vientre',
              'tipo'    => 'varchar',
              'lenght'  => 100,
              'null'    => FALSE,
              'primary' => FALSE,
              'update'  => TRUE,
              'type'    => 'number',
              'class'   => 'form-control',
              'step'    => 'step="any"'
            ),

            'ini_vie_porcentaje_destete' => array(
              'name'    => 'Destetes %',
              'tipo'    => 'varchar',
              'lenght'  => 100,
              'null'    => FALSE,
              'primary' => FALSE,
              'update'  => TRUE,
              'type'    => 'number',
              'class'   => 'form-control',
              'step'    => 'step="any"'
            )
          ),
          'Vaquillas de reemplazo' => array(
            'class'  => 'vaquillas_reemplazo',
            'id'     => 'vaquillas_reemplazo',  
            'ini_ree_numero_compradas' => array(
              'name'    => '# compradas',
              'tipo'    => 'varchar',
              'lenght'  => 100,
              'null'    => FALSE,
              'primary' => FALSE,
              'update'  => TRUE,
              'type'    => 'number',
              'class'   => 'form-control',
              'step'    => 'step="any"'
            ),
            'ini_ree_precio' => array(
              'name'    => 'precio $/cabeza',
              'tipo'    => 'varchar',
              'lenght'  => 100,
              'null'    => FALSE,
              'primary' => FALSE,
              'update'  => TRUE,
              'type'    => 'number',
              'class'   => 'form-control',
              'step'    => 'step="any"'
            ),
            'ini_ree_numero_criadas' => array(
              'name'    => '# criadas',
              'tipo'    => 'varchar',
              'lenght'  => 100,
              'null'    => FALSE,
              'primary' => FALSE,
              'update'  => TRUE,
              'type'    => 'number',
              'class'   => 'form-control',
              'step'    => 'step="any"'
            ),
            'ini_ree_valor_becerras_criadas_precio_cab' => array(
              'name'    => 'valor becerras criadas',
              'tipo'    => 'varchar',
              'lenght'  => 100,
              'null'    => FALSE,
              'primary' => FALSE,
              'update'  => FALSE,
              'type'    => 'text',
              'class'   => 'form-control',
              'step'    => 'step="any"'
            )
          ),
          'Datos becerros (as) destetados' => array(
            'class'  => 'becerros_destetados',
            'id'     => 'becerros_destetados',  
            'ini_des_numero_becerros_vendidos' => array(
              'name'    => '# becerros vendidos',
              'tipo'    => 'varchar',
              'lenght'  => 100,
              'null'    => FALSE,
              'primary' => FALSE,
              'update'  => FALSE,
              'type'    => 'text',
              'class'   => 'form-control',
              'step'    => 'step="any"'
            ),
            'ini_des_peso_vivo_venta' => array(
              'name'    => 'Peso vivo a la venta,  kg',
              'tipo'    => 'varchar',
              'lenght'  => 100,
              'null'    => FALSE,
              'primary' => FALSE,
              'update'  => TRUE,
              'type'    => 'number',
              'class'   => 'form-control',
              'step'    => 'step="any"'
            ),
            'ini_des_precio_kg_vendido' => array(
              'name'    => '$/kg vendido',
              'tipo'    => 'varchar',
              'lenght'  => 100,
              'null'    => FALSE,
              'primary' => FALSE,
              'update'  => TRUE,
              'type'    => 'number',
              'class'   => 'form-control',
              'step'    => 'step="any"'
            ),
            'ini_des_ingresos_por_becerros' => array(
              'name'    => 'Ingreso por becerros',
              'tipo'    => 'varchar',
              'lenght'  => 100,
              'null'    => FALSE,
              'primary' => FALSE,
              'update'  => FALSE,
              'type'    => 'text',
              'class'   => 'form-control'
            ),
            'ini_des_numero_becerras_vendidos_a' => array(
              'name'    => '# becerras vendidos',
              'tipo'    => 'varchar',
              'lenght'  => 100,
              'null'    => FALSE,
              'primary' => FALSE,
              'update'  => FALSE,
              'type'    => 'text',
              'class'   => 'form-control'
            ),
            'ini_des_peso_vivo_venta_a' => array(
              'name'    => 'Peso vivo a la venta,  kg',
              'tipo'    => 'varchar',
              'lenght'  => 100,
              'null'    => FALSE,
              'primary' => FALSE,
              'update'  => TRUE,
              'type'    => 'number',
              'class'   => 'form-control',
              'step'    => 'step="any"'
            ),
            'ini_des_precio_kg_vendido_a' => array(
              'name'    => '$/kg vendido',
              'tipo'    => 'varchar',
              'lenght'  => 100,
              'null'    => FALSE,
              'primary' => FALSE,
              'update'  => TRUE,
              'type'    => 'number',
              'class'   => 'form-control',
              'step'    => 'step="any"'
            ),
            'ini_des_ingresos_por_becerras' => array(
              'name'    => 'Ingreso por becerras',
              'tipo'    => 'varchar',
              'lenght'  => 100,
              'null'    => FALSE,
              'primary' => FALSE,
              'update'  => FALSE,
              'type'    => 'text',
              'class'   => 'form-control'
            ),
            'ini_des_ingreso_total_becerros_as' => array(
              'name'    => 'Ingreso total becerros(as)',
              'tipo'    => 'varchar',
              'lenght'  => 100,
              'null'    => FALSE,
              'primary' => FALSE,
              'update'  => FALSE,
              'type'    => 'text',
              'class'   => 'form-control'
            )
          ),
          'Ingreso ganado desecho' => array(
            'class'  => 'ingreso_ganado_desecho',
            'id'     => 'ingreso_ganado_desecho',  
            'ini_dese_numero_vintres_desecho' => array(
              'name'    => '# vientres de desecho',
              'tipo'    => 'varchar',
              'lenght'  => 100,
              'null'    => FALSE,
              'primary' => FALSE,
              'update'  => FALSE,
              'type'    => 'text',
              'class'   => 'form-control'
            ),
            'ini_dese_peso_vivo_venta_kg' => array(
              'name'    => 'Peso vivo a la venta,  kg',
              'tipo'    => 'varchar',
              'lenght'  => 100,
              'null'    => FALSE,
              'primary' => FALSE,
              'update'  => TRUE,
              'type'    => 'number',
              'class'   => 'form-control',
              'step'    => 'step="any"'
            ),
            'ini_dese_precio_kg_desecho' => array(
              'name'    => '$/kg desecho',
              'tipo'    => 'varchar',
              'lenght'  => 100,
              'null'    => FALSE,
              'primary' => FALSE,
              'update'  => TRUE,
              'type'    => 'number',
              'class'   => 'form-control',
              'step'    => 'step="any"'
            ),
            'ini_dese_precio_cab_recuperado' => array(
              'name'    => '$/cab recuperado',
              'tipo'    => 'varchar',
              'lenght'  => 100,
              'null'    => FALSE,
              'primary' => FALSE,
              'update'  => FALSE,
              'type'    => 'text',
              'class'   => 'form-control'
            ),
            'ini_dese_precio_total_recuperacion' => array(
              'name'    => '$ total de recuperación',
              'tipo'    => 'varchar',
              'lenght'  => 100,
              'null'    => FALSE,
              'primary' => FALSE,
              'update'  => FALSE,
              'type'    => 'text',
              'class'   => 'form-control'
            ),
            'ini_dese_recuperacion_sementales_ano' => array(
              'name'    => 'Recuperacion sementales,  $ año',
              'tipo'    => 'varchar',
              'lenght'  => 100,
              'null'    => FALSE,
              'primary' => FALSE,
              'update'  => FALSE,
              'type'    => 'text',
              'class'   => 'form-control'
            ),
            'ini_dese_total_ingreso_ano' => array(
              'name'    => 'Total ingreso / año',
              'tipo'    => 'varchar',
              'lenght'  => 100,
              'null'    => FALSE,
              'primary' => FALSE,
              'update'  => FALSE,
              'type'    => 'text',
              'class'   => 'form-control'
            )
          ),
          'Ingresos' => array(
            'class'  => 'ingresos',
            'id'     => 'ingresos',  
            'ini_ing_vi_becerros_as_vendido' => array(
              'name'    => 'Becerros(as) vendidas',
              'tipo'    => 'varchar',
              'lenght'  => 100,
              'null'    => FALSE,
              'primary' => FALSE,
              'update'  => FALSE,
              'type'    => 'text',
              'class'   => 'form-control'
            ),
            'ini_ing_vi_recuperado_ano_precio' => array(
              'name'    => 'vientre recuperado / año $',
              'tipo'    => 'varchar',
              'lenght'  => 100,
              'null'    => FALSE,
              'primary' => FALSE,
              'update'  => FALSE,
              'type'    => 'text',
              'class'   => 'form-control'
            ),
            'ini_ing_vi_recuperado_vientre_precio' => array(
              'name'    => 'Ingreso recup vientre $',
              'tipo'    => 'varchar',
              'lenght'  => 100,
              'null'    => FALSE,
              'primary' => FALSE,
              'update'  => FALSE,
              'type'    => 'text',
              'class'   => 'form-control'
            ),
            'ini_ing_vi_recuperado_vie_sem_precio' => array(
              'name'    => 'Ingr recup vient+sement $',
              'tipo'    => 'varchar',
              'lenght'  => 100,
              'null'    => FALSE,
              'primary' => FALSE,
              'update'  => FALSE,
              'type'    => 'text',
              'class'   => 'form-control'
            ),
            'ini_ing_ha_becerros_as_vendido' => array(
              'name'    => 'Becerros(as) vendidas',
              'tipo'    => 'varchar',
              'lenght'  => 100,
              'null'    => FALSE,
              'primary' => FALSE,
              'update'  => FALSE,
              'type'    => 'number',
              'class'   => 'form-control',
              'step'    => 'step="any"'
            ),
            'ini_ing_ha_recuperado_ano_precio' => array(
              'name'    => 'vientre recuperado / año $',
              'tipo'    => 'varchar',
              'lenght'  => 100,
              'null'    => FALSE,
              'primary' => FALSE,
              'update'  => FALSE,
              'type'    => 'text',
              'class'   => 'form-control'
            ),
            'ini_ing_ha_recuperado_vientre_precio' => array(
              'name'    => 'Ingreso recup vientre $',
              'tipo'    => 'varchar',
              'lenght'  => 100,
              'null'    => FALSE,
              'primary' => FALSE,
              'update'  => FALSE,
              'type'    => 'text',
              'class'   => 'form-control'
            ),
            'ini_ing_ha_recuperado_vie_sem_precio' => array(
              'name'    => 'Ingr recup vient+sement $',
              'tipo'    => 'varchar',
              'lenght'  => 100,
              'null'    => FALSE,
              'primary' => FALSE,
              'update'  => FALSE,
              'type'    => 'text',
              'class'   => 'form-control'
            )
          ),
          // se llena con js
          'Insumos alimentos/fertilizante' => array(
              'class'  => 'insumos',
              'id'     => 'insumos',
          ),
          'Mano de obra' => array(
              'class'  => 'mano_obra',
              'id'     => 'mano_obra',  
          ),
          'Depreciacíon' => array(
              'class'  => 'depreciacion',
              'id'     => 'depreciacion',  
          ),
          'Inversion' => array(
            'class'  => 'inversion',
            'id'     => 'inversion',
            'ini_inv_numero_sementales' => array(
              'name'    => '# sementales',
              'tipo'    => 'varchar',
              'lenght'  => 100,
              'null'    => FALSE,
              'primary' => FALSE,
              'update'  => TRUE,
              'type'    => 'number',
              'class'   => 'form-control'
            ),
            'ini_inv_precio_semental' => array(
              'name'    => '$ semental',
              'tipo'    => 'varchar',
              'lenght'  => 100,
              'null'    => FALSE,
              'primary' => FALSE,
              'update'  => TRUE,
              'type'    => 'number',
              'class'   => 'form-control'
            ),
            'ini_inv_precio_sementales' => array(
              'name'    => '$ sementales',
              'tipo'    => 'varchar',
              'lenght'  => 100,
              'null'    => FALSE,
              'primary' => FALSE,
              'update'  => FALSE,
              'type'    => 'number',
              'class'   => 'form-control'
            ),
            'ini_inv_numero_ano_servicio' => array(
              'name'    => '# años en servicio',
              'tipo'    => 'varchar',
              'lenght'  => 100,
              'null'    => FALSE,
              'primary' => FALSE,
              'update'  => TRUE,
              'type'    => 'number',
              'class'   => 'form-control'
            ),
            'ini_inv_precio_recuperacion_cap' => array(
              'name'    => '$ recuperación / cab',
              'tipo'    => 'varchar',
              'lenght'  => 100,
              'null'    => FALSE,
              'primary' => FALSE,
              'update'  => TRUE,
              'type'    => 'number',
              'class'   => 'form-control'
            ),
            'ini_inv_precio_recuperacion_total_ano' => array(
              'name'    => '$ recuperación total / año',
              'tipo'    => 'varchar',
              'lenght'  => 100,
              'null'    => FALSE,
              'primary' => FALSE,
              'update'  => FALSE,
              'type'    => 'number',
              'class'   => 'form-control'
            ),
            'ini_inv_precio_empadre_vaca_ano' => array(
              'name'    => '$ empadre/vaca/año',
              'tipo'    => 'varchar',
              'lenght'  => 100,
              'null'    => FALSE,
              'primary' => FALSE,
              'update'  => FALSE,
              'type'    => 'number',
              'class'   => 'form-control'
            ),
            'ini_inv_precio_cab_ano_ensiminacion' => array(
              'name'    => '$/cab/año inseminación',
              'tipo'    => 'varchar',
              'lenght'  => 100,
              'null'    => FALSE,
              'primary' => FALSE,
              'update'  => TRUE,
              'type'    => 'number',
              'class'   => 'form-control'
            ),
            'ini_inv_meds-trats_precio_vientre_ano' => array(
              'name'    => 'Meds-trats, $/vientre/año',
              'tipo'    => 'varchar',
              'lenght'  => 100,
              'null'    => FALSE,
              'primary' => FALSE,
              'update'  => TRUE,
              'type'    => 'number',
              'class'   => 'form-control'
            ),
            'ini_inv_tasa_interes_anual' => array(
              'name'    => 'Tasa de interés anual',
              'tipo'    => 'varchar',
              'lenght'  => 100,
              'null'    => FALSE,
              'primary' => FALSE,
              'update'  => TRUE,
              'type'    => 'number',
              'class'   => 'form-control'
            ),
            'ini_inv_interes_animales_precio_cab' => array(
              'name'    => 'Inter´s en animales, $/cab',
              'tipo'    => 'varchar',
              'lenght'  => 100,
              'null'    => FALSE,
              'primary' => FALSE,
              'update'  => FALSE,
              'type'    => 'number',
              'class'   => 'form-control'
            ),
            'ini_inv_interes_operativo_precio_cab' => array(
              'name'    => 'Inter´s en operativo, $/cab',
              'tipo'    => 'varchar',
              'lenght'  => 100,
              'null'    => FALSE,
              'primary' => FALSE,
              'update'  => FALSE,
              'type'    => 'number',
              'class'   => 'form-control'
            )
          ),
          'Costos Hato' => array(
            'class'  => 'costo_hato',
            'id'     => 'costo_hato',
            'ini_ch_vi_precio_alimento_suplementario' => array(
              'name'    => '$ alimento suplementario',
              'tipo'    => 'varchar',
              'lenght'  => 100,
              'null'    => FALSE,
              'primary' => FALSE,
              'update'  => FALSE,
              'type'    => 'number',
              'class'   => 'form-control'
            ),
            'ini_ch_vi_precio_agostadero' => array(
              'name'    => '$ agostadero',
              'tipo'    => 'varchar',
              'lenght'  => 100,
              'null'    => FALSE,
              'primary' => FALSE,
              'update'  => FALSE,
              'type'    => 'number',
              'class'   => 'form-control'
            ),
            'ini_ch_vi_precio_mano_obra' => array(
              'name'    => '$ mano de obra',
              'tipo'    => 'varchar',
              'lenght'  => 100,
              'null'    => FALSE,
              'primary' => FALSE,
              'update'  => FALSE,
              'type'    => 'number',
              'class'   => 'form-control'
            ),
            'ini_ch_vi_precio_depreciacion' => array(
              'name'    => '$ depreciación',
              'tipo'    => 'varchar',
              'lenght'  => 100,
              'null'    => FALSE,
              'primary' => FALSE,
              'update'  => FALSE,
              'type'    => 'number',
              'class'   => 'form-control'
            ),
            'ini_ch_vi_precio_empadre_vaca_ano' => array(
              'name'    => '$ empadre/vaca/año',
              'tipo'    => 'varchar',
              'lenght'  => 100,
              'null'    => FALSE,
              'primary' => FALSE,
              'update'  => FALSE,
              'type'    => 'number',
              'class'   => 'form-control'
            ),
            'ini_ch_vi_precio_cab_ano_enseminacion' => array(
              'name'    => '$/cab/año inseminación',
              'tipo'    => 'varchar',
              'lenght'  => 100,
              'null'    => FALSE,
              'primary' => FALSE,
              'update'  => FALSE,
              'type'    => 'number',
              'class'   => 'form-control'
            ),
            'ini_ch_vi_meds-trats_precio_vientre_ano' => array(
              'name'    => 'Meds-trats, $/vientre/año',
              'tipo'    => 'varchar',
              'lenght'  => 100,
              'null'    => FALSE,
              'primary' => FALSE,
              'update'  => FALSE,
              'type'    => 'number',
              'class'   => 'form-control'
            ),
            'ini_ch_vi_interes_animales_precio_cab' => array(
              'name'    => 'Inter´s en animales, $/cab',
              'tipo'    => 'varchar',
              'lenght'  => 100,
              'null'    => FALSE,
              'primary' => FALSE,
              'update'  => FALSE,
              'type'    => 'number',
              'class'   => 'form-control'
            ),
            'ini_ch_vi_interes_operativo_precio_cab' => array(
              'name'    => 'Inter´s en operativo, $/cab',
              'tipo'    => 'varchar',
              'lenght'  => 100,
              'null'    => FALSE,
              'primary' => FALSE,
              'update'  => FALSE,
              'type'    => 'number',
              'class'   => 'form-control'
            ),
            'ini_ch_vi_precio_total_vientre' => array(
              'name'    => '$ total / vientre',
              'tipo'    => 'varchar',
              'lenght'  => 100,
              'null'    => FALSE,
              'primary' => FALSE,
              'update'  => FALSE,
              'type'    => 'number',
              'class'   => 'form-control'
            ),
            'ini_ch_ha_precio_alimento_suplementario' => array(
              'name'    => '$ alimento suplementario',
              'tipo'    => 'varchar',
              'lenght'  => 100,
              'null'    => FALSE,
              'primary' => FALSE,
              'update'  => FALSE,
              'type'    => 'number',
              'class'   => 'form-control'
            ),
            'ini_ch_ha_precio_agostadero' => array(
              'name'    => '$ agostadero',
              'tipo'    => 'varchar',
              'lenght'  => 100,
              'null'    => FALSE,
              'primary' => FALSE,
              'update'  => FALSE,
              'type'    => 'number',
              'class'   => 'form-control'
            ),
            'ini_ch_ha_precio_mano_obra' => array(
              'name'    => '$ mano de obra',
              'tipo'    => 'varchar',
              'lenght'  => 100,
              'null'    => FALSE,
              'primary' => FALSE,
              'update'  => FALSE,
              'type'    => 'number',
              'class'   => 'form-control'
            ),
            'ini_ch_ha_precio_depreciacion' => array(
              'name'    => '$ depreciación',
              'tipo'    => 'varchar',
              'lenght'  => 100,
              'null'    => FALSE,
              'primary' => FALSE,
              'update'  => FALSE,
              'type'    => 'number',
              'class'   => 'form-control'
            ),
            'ini_ch_ha_precio_empadre_vaca_ano' => array(
              'name'    => '$ empadre/vaca/año',
              'tipo'    => 'varchar',
              'lenght'  => 100,
              'null'    => FALSE,
              'primary' => FALSE,
              'update'  => FALSE,
              'type'    => 'number',
              'class'   => 'form-control'
            ),
            'ini_ch_ha_precio_cab_ano_enseminacion' => array(
              'name'    => '$/cab/año inseminación',
              'tipo'    => 'varchar',
              'lenght'  => 100,
              'null'    => FALSE,
              'primary' => FALSE,
              'update'  => FALSE,
              'type'    => 'number',
              'class'   => 'form-control'
            ),
            'ini_ch_ha_meds-trats_precio_vientre_ano' => array(
              'name'    => 'Meds-trats, $/vientre/año',
              'tipo'    => 'varchar',
              'lenght'  => 100,
              'null'    => FALSE,
              'primary' => FALSE,
              'update'  => FALSE,
              'type'    => 'number',
              'class'   => 'form-control'
            ),
            'ini_ch_ha_interes_animales_precio_cab' => array(
              'name'    => 'Inter´s en animales, $/cab',
              'tipo'    => 'varchar',
              'lenght'  => 100,
              'null'    => FALSE,
              'primary' => FALSE,
              'update'  => FALSE,
              'type'    => 'number',
              'class'   => 'form-control'
            ),
            'ini_ch_ha_interes_operativo_precio_cab' => array(
              'name'    => 'Inter´s en operativo, $/cab',
              'tipo'    => 'varchar',
              'lenght'  => 100,
              'null'    => FALSE,
              'primary' => FALSE,
              'update'  => FALSE,
              'type'    => 'number',
              'class'   => 'form-control'
            ),
            'ini_ch_ha_precio_total_vientre' => array(
              'name'    => '$ total / vientre',
              'tipo'    => 'varchar',
              'lenght'  => 100,
              'null'    => FALSE,
              'primary' => FALSE,
              'update'  => FALSE,
              'type'    => 'number',
              'class'   => 'form-control'
            )
          ),
         'Utilidad/Pérdida' => array(
            'class'  => 'utilidad_perdida',
            'id'     => 'utilidad_perdida',
            'ini_up_na_kg_destetado' => array(
              'name'    => 'Por kg destetado',
              'tipo'    => 'varchar',
              'lenght'  => 100,
              'null'    => FALSE,
              'primary' => FALSE,
              'update'  => FALSE,
              'type'    => 'number',
              'class'   => 'form-control'
            ),
            'ini_up_na_vientre' => array(
              'name'    => 'Por vientre',
              'tipo'    => 'varchar',
              'lenght'  => 100,
              'null'    => FALSE,
              'primary' => FALSE,
              'update'  => FALSE,
              'type'    => 'number',
              'class'   => 'form-control'
            ),
            'ini_up_na_hato' => array(
              'name'    => 'Utilidad/pérdida por el hato',
              'tipo'    => 'varchar',
              'lenght'  => 100,
              'null'    => FALSE,
              'primary' => FALSE,
              'update'  => FALSE,
              'type'    => 'number',
              'class'   => 'form-control'
            ),
            'ini_up_na_costo_produccion_kg_becerro' => array(
              'name'    => 'Costo producción kg becerro',
              'tipo'    => 'varchar',
              'lenght'  => 100,
              'null'    => FALSE,
              'primary' => FALSE,
              'update'  => FALSE,
              'type'    => 'number',
              'class'   => 'form-control'
            ),
            'ini_up_na_ingreso_kg_destetado' => array(
              'name'    => 'Ingreso por kg destetado',
              'tipo'    => 'varchar',
              'lenght'  => 100,
              'null'    => FALSE,
              'primary' => FALSE,
              'update'  => FALSE,
              'type'    => 'number',
              'class'   => 'form-control'
            ),
            'ini_up_ve_kg_destetado' => array(
              'name'    => 'Por kg destetado',
              'tipo'    => 'varchar',
              'lenght'  => 100,
              'null'    => FALSE,
              'primary' => FALSE,
              'update'  => FALSE,
              'type'    => 'number',
              'class'   => 'form-control'
            ),
            'ini_up_ve_vientre' => array(
              'name'    => 'Por vientre',
              'tipo'    => 'varchar',
              'lenght'  => 100,
              'null'    => FALSE,
              'primary' => FALSE,
              'update'  => FALSE,
              'type'    => 'number',
              'class'   => 'form-control'
            ),
            'ini_up_ve_hato' => array(
              'name'    => 'Utilidad/pérdida por el hato',
              'tipo'    => 'varchar',
              'lenght'  => 100,
              'null'    => FALSE,
              'primary' => FALSE,
              'update'  => FALSE,
              'type'    => 'number',
              'class'   => 'form-control'
            ),
            'ini_up_ve_costo_produccion_kg_becerro' => array(
              'name'    => 'Costo producción kg becerro',
              'tipo'    => 'varchar',
              'lenght'  => 100,
              'null'    => FALSE,
              'primary' => FALSE,
              'update'  => FALSE,
              'type'    => 'number',
              'class'   => 'form-control'
            ),
            'ini_up_ve_ingreso_kg_destetado' => array(
              'name'    => 'Ingreso por kg destetado',
              'tipo'    => 'varchar',
              'lenght'  => 100,
              'null'    => FALSE,
              'primary' => FALSE,
              'update'  => FALSE,
              'type'    => 'number',
              'class'   => 'form-control'
            )
          ),
          'Nota' => array(
            'class'  => 'nota',
            'id'     => 'nota',
            'ini_nota' => array(
              'name'    => 'Comentarios',
              'tipo'    => 'varchar',
              'lenght'  => 200,
              'null'    => FALSE,
              'primary' => FALSE,
              'update'  => TRUE,
              'type'    => 'textarea',
              'class'   => 'form-control'
            )
          )  
        );
    }

    public function delete_t($id) {
        $this->dbUse->trans_begin();
        $this->dbUse->update('ini_inicializacion_mstr', array('ini_estatus' => 0 ), array('ini_id' => $id));
        if ($this->dbUse->trans_status() === FALSE) {
            $this->dbUse->trans_rollback();
            return FALSE;
        }
        $this->dbUse->trans_commit();
        return TRUE;
    }

    public function saveInsumos($datos_insumos){
      $this->dbUse->trans_begin();
      $this->dbUse->insert('ins_insumos_det', $datos_insumos);
      if ($this->dbUse->trans_status() === FALSE){
        $this->dbUse->trans_rollback();
        return FALSE;
      }
      $this->dbUse->trans_commit();
      return TRUE;
    }

    public function saveManoObra($datos_mano_obra){
      $this->dbUse->trans_begin();
      $this->dbUse->insert('man_mano_obra_det', $datos_mano_obra);
      if ($this->dbUse->trans_status() === FALSE){
        $this->dbUse->trans_rollback();
        return FALSE;
      }
      $this->dbUse->trans_commit();
      return TRUE;
    }

    public function saveDepreciacion($datos_depreciacion){
      $this->dbUse->trans_begin();
      $this->dbUse->insert('dep_depreciacion_det', $datos_depreciacion);
      if ($this->dbUse->trans_status() === FALSE){
        $this->dbUse->trans_rollback();
        return FALSE;
      }
      $this->dbUse->trans_commit();
      return TRUE;
    }
}

/* End of text plantas_model.php */
/* Location: ./application/models/usuarios/plantas_model.php */