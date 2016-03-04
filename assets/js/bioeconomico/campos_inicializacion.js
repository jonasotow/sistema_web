$(document).ready(function(){
  alert('nada');
  //crear los campos para insumos
  $("#insumos").append(
    // input para guadar el total de los calculos
    '<input id="ini_ins_suplemento_vientre_ano" class="form-control" type="hidden" name="ini_ins_suplemento_vientre_ano" >' +
    // secrean los campos para agostadero
    '<div class="form-group">' +
      '<label for="ins_nombre_agostadero">Nombre:</label>' +
      '<div>' +
        '<input id="ins_nombre_agostadero" type="text" class="form-control" name="ins_nombre_agostadero" value="Agostadero" readonly="" >' +
      '</div>' +
    '</div>' +
    '<div class="form-group">' +
      '<label for="ins_precio_dia_agostadero">$ / dia:</label>' +
      '<div>' +
        '<input id="ins_precio_dia_agostadero" class="form-control" type="number" name="ins_precio_dia_agostadero" >' +
      '</div>' +
    '</div>' +
    '<div class="form-group">' +
      '<label for="ins_numero_dias_agostadero"># dias:</label>' +
      '<div>' +
        '<input id="ins_numero_dias_agostadero" class="form-control" type="number" name="ins_numero_dias_agostadero" step="any">' +
      '</div>' +
    '</div>' +
    '<div class="form-group">' +
      '<label for="ins_numero_dias_otro">.</label>' +
      '<div>' +
        '<input id="ins_numero_dias_otro" class="form-control" type="number" name="ins_numero_dias_otro" readonly="">' +
      '</div>' +
    '</div>' +
    '<div class="form-group">' +
      '<label for="ins_calculo_agostadero">.</label>' +
      '<div>' +
        '<input id="ins_calculo_agostadero" class="form-control" type="number" name="ins_calculo_agostadero" readonly="">' +
      '</div>' +
    '</div>' +
    // Se crea los campos para insumos
    '<div class="form-group">' +
      '<label for="ins_nombre1">Nombre:</label>' +
      '<div>' +
        '<select id="ins_nombre1" class="form-control" name="ins_nombre1">' +
        '<option>Heno</option><option>Ensilaje</option><option>Concentrado</option><option>Sal mineralizada</option><option>Otros</option>' +
        '</select>' +
      '</div>' +
    '</div>' +
    '<div class="form-group">' +
      '<label for="ins_precio_tonelada1">$ / ton:</label>' +
      '<div>' +
        '<input id="ins_precio_tonelada1" class="form-control" type="number" name="ins_precio_tonelada1" step="any">' +
      '</div>' +
    '</div>' +
    '<div class="form-group">' +
      '<label for="ins_numero_dias1"># dias:</label>' +
      '<div>' +
        '<input id="ins_numero_dias1" class="form-control" type="number" name="ins_numero_dias1" step="any">' +
      '</div>' +
    '</div>' +
    '<div class="form-group">' +
      '<label for="ins_kg_vientre_dia1">kg / vientre / dia :</label>' +
      '<div>' +
        '<input id="ins_kg_vientre_dia1" class="form-control" type="number" name="ins_kg_vientre_dia1" step="any">' +
      '</div>' +
    '</div>' +
    '<div class="form-group">' +
      '<label for="ins_calculo1">.</label>' +
      '<div>' +
        '<input id="ins_calculo1" class="form-control" type="number" name="ins_calculo1" readonly="">' +
      '</div>' +
    '</div>' +
    // Boton para ir creando campos para insumos
    '<a id="anadir_insumos"><i class="fa fa-plus-circle"></i></a>'
  )

  //añade los campos se se van necesitando para insumos
  $("#anadir_insumos").click(function(event) {
    $("#insumos").append(
      '<div class="form-group div_insumos'+contador_insumos+'">' +
        '<label class="sr-only" for="ins_nombre'+contador_insumos+'">Nombre:</label>' +
        '<div>' +
          '<select id="ins_nombre'+contador_insumos+'" class="form-control" name="ins_nombre'+contador_insumos+'">' +
          '<option>Heno</option><option>Ensilaje</option><option>Concentrado</option><option>Sal mineralizada</option><option>Otros</option>' +
          '</select>' +
        '</div>' +
      '</div>' +
      '<div class="form-group div_insumos'+contador_insumos+'">' +
        '<label class="sr-only" for="ins_precio_tonelada'+contador_insumos+'">$ / ton:</label>' +
        '<div>' +
          '<input id="ins_precio_tonelada'+contador_insumos+'" class="form-control" type="number" name="ins_precio_tonelada'+contador_insumos+'" step="any">' +
        '</div>' +
      '</div>' +
      '<div class="form-group div_insumos'+contador_insumos+'">' +
        '<label class="sr-only" for="ins_numero_dias'+contador_insumos+'"># dias:</label>' +
        '<div>' +
          '<input id="ins_numero_dias'+contador_insumos+'" class="form-control" type="number" name="ins_numero_dias'+contador_insumos+'" step="any">' +
        '</div>' +
      '</div>' +
      '<div class="form-group div_insumos'+contador_insumos+'">' +
        '<label class="sr-only" for="ins_kg_vientre_dia'+contador_insumos+'">kg / vientre / dia :</label>' +
        '<div>' +
          '<input id="ins_kg_vientre_dia'+contador_insumos+'" class="form-control" type="number" name="ins_kg_vientre_dia'+contador_insumos+'" step="any">' +
        '</div>' +
      '</div>' +
      '<div class="form-group div_insumos'+contador_insumos+'">' +
        '<label class="sr-only" for="ins_calculo'+contador_insumos+'">.</label>' +
        '<div>' +
          '<input id="ins_calculo'+contador_insumos+'" class="form-control" type="number" name="ins_calculo'+contador_insumos+'" readonly="">' +
        '</div>' +
      '</div>' +
      '<a class="div_insumos'+contador_insumos+'"><i class="fa fa-minus-circle"></i></a>'
    )
    contador_insumos++
  })

  //elimina los insumos que no necesitas
  $("#insumos").delegate("a","click", function(event) {
    if ($(this).attr('id') != 'anadir_insumos' ) {
      $('.' + $(this).attr('class')).remove()
    }
  })
  //crear los campos para mano de obra
  $("#mano_obra").append(
    // input para guaqar el total de los calculos 
    '<input id="ini_man_total_precio_ano_hato" class="form-control" type="hidden" name="ini_man_total_precio_ano_hato" >' +
    '<input id="ini_man_total_precio_ano_vientre" class="form-control" type="hidden" name="ini_man_total_precio_ano_vientre" >' +
    // Se crea los campos para mano de obra
    '<div class="form-group">' +
      '<label for="man_nombre1">Nombre:</label>' +
      '<div>' +
        '<select id="man_nombre1" class="form-control" name="man_nombre1" >' +
          '<option>Vaqueros</option><option>Maquinistas</option><option>Peones</option><option>Otros</option>' +
        '</select>' +
      '</div>' +
    '</div>' +
    '<div class="form-group">' +
      '<label for="man_precio_semana1">$ / semana:</label>' +
      '<div>' +
        '<input id="man_precio_semana1" class="form-control" type="number" name="man_precio_semana1" step="any">' +
      '</div>' +
    '</div>' +
    '<div class="form-group">' +
      '<label for="man_numero1">Núm:</label>' +
      '<div>' +
        '<input id="man_numero1" class="form-control" type="number" name="man_numero1" step="any">' +
      '</div>' +
    '</div>' +
    '<div class="form-group">' +
      '<label for="man_numero_semanas_ano1"># semanas / año:</label>' +
      '<div>' +
        '<input id="man_numero_semanas_ano1" class="form-control" type="number" name="man_numero_semanas_ano1" step="any">' +
      '</div>' +
    '</div>' +
    '<div class="form-group">' +
      '<label for="man_total_hato1">Total hato</label>' +
      '<div>' +
        '<input id="man_total_hato1" class="form-control" type="number" name="man_total_hato1" readonly="">' +
      '</div>' +
    '</div>' +
    '<div class="form-group">' +
      '<label for="man_total_vientre1">Total vientre</label>' +
      '<div>' +
        '<input id="man_total_vientre1" class="form-control" type="number" name="man_total_vientre1" step="any" readonly="">' +
      '</div>' +
    '</div>' +
    // Boton para ir creando campos para mano de obra
    '<a id="anadir_mano_obra"><i class="fa fa-plus-circle"></i></a>'
  )
  
  //añade los campos se se van necesitando para mano de obra
  $("#anadir_mano_obra").click(function(event) {
    $("#mano_obra").append(
      '<div class="form-group div_insumos'+contador_mano_obra+'">' +
        '<label class="sr-only" for="man_nombre'+contador_mano_obra+'">Nombre:</label>' +
        '<div>' +
          '<select id="man_nombre'+contador_mano_obra+'" class="form-control" name="man_nombre'+contador_mano_obra+'" >' +
            '<option>Vaqueros</option><option>Maquinistas</option><option>Peones</option><option>Otros</option>' +
          '</select>' +
        '</div>' +
      '</div>' +
      '<div class="form-group div_insumos'+contador_mano_obra+'">' +
        '<label class="sr-only" for="man_precio_semana'+contador_mano_obra+'">$ / ton:</label>' +
        '<div>' +
          '<input id="man_precio_semana'+contador_mano_obra+'" class="form-control" type="number" name="man_precio_semana'+contador_mano_obra+'" step="any">' +
        '</div>' +
      '</div>' +
      '<div class="form-group div_insumos'+contador_mano_obra+'">' +
        '<label class="sr-only" for="man_numero'+contador_mano_obra+'"># dias:</label>' +
        '<div>' +
          '<input id="man_numero'+contador_mano_obra+'" class="form-control" type="number" name="man_numero'+contador_mano_obra+'" step="any">' +
        '</div>' +
      '</div>' +
      '<div class="form-group div_insumos'+contador_mano_obra+'">' +
        '<label class="sr-only" for="man_numero_semanas_ano'+contador_mano_obra+'">kg / vientre / dia :</label>' +
        '<div>' +
          '<input id="man_numero_semanas_ano'+contador_mano_obra+'" class="form-control" type="number" name="man_numero_semanas_ano'+contador_mano_obra+'" step="any">' +
        '</div>' +
      '</div>' +
      '<div class="form-group div_insumos'+contador_mano_obra+'">' +
        '<label class="sr-only" for="man_total_hato'+contador_mano_obra+'">.</label>' +
        '<div>' +
          '<input id="man_total_hato'+contador_mano_obra+'" class="form-control" type="number" name="man_total_hato'+contador_mano_obra+'" readonly="">' +
        '</div>' +
      '</div>' +
      '<div class="form-group div_insumos'+contador_mano_obra+'">' +
        '<label class="sr-only" for="man_total_vientre'+contador_mano_obra+'">% ms</label>' +
        '<div>' +
          '<input id="man_total_vientre'+contador_mano_obra+'" class="form-control" type="number" name="man_total_vientre'+contador_mano_obra+'" step="any" readonly="">' +
        '</div>' +
      '</div>' +
      '<a class="div_insumos'+contador_mano_obra+'"><i class="fa fa-minus-circle"></i></a>'
    )
    contador_mano_obra++
  })
  //elimina la mano de obra que no necesitas
  $("#mano_obra").delegate("a","click", function(event) {
    if ($(this).attr('id') != 'anadir_mano_obra' ) {
      $('.' + $(this).attr('class')).remove()
    }
  })
  //crear los campos para depreciacion
  $("#depreciacion").append(
    // input para guadar el total de los calculos 
    '<input id="ini_dep_total_precio_ano_hato" class="form-control" type="hidden" name="ini_dep_total_precio_ano_hato" >' +
    '<input id="ini_dep_total_precio_ano_vientre" class="form-control" type="hidden" name="ini_dep_total_precio_ano_vientre" >' +
    // Se crea los campos para depreaciacion
    '<div class="form-group">' +
      '<label for="dep_nombre1">Nombre:</label>' +
      '<div>' +
        '<select id="dep_nombre1" class="form-control" name="dep_nombre1">' +
          '<option>Corrales</option><option>Vehículo</option><option>Maquinaria</option><option>Equipo</option><option>Otros</option>' +
        '</select>' +
      '</div>' +
    '</div>' +
    '<div class="form-group">' +
      '<label for="dep_precio_unitario1">$ unitario:</label>' +
      '<div>' +
        '<input id="dep_precio_unitario1" class="form-control" type="number" name="dep_precio_unitario1" step="any">' +
      '</div>' +
    '</div>' +
    '<div class="form-group">' +
      '<label for="dep_anos1">Años:</label>' +
      '<div>' +
        '<input id="dep_anos1" class="form-control" type="number" name="dep_anos1" step="any">' +
      '</div>' +
    '</div>' +
    '<div class="form-group">' +
      '<label for="dep_total_hato1">.</label>' +
      '<div>' +
        '<input id="dep_total_hato1" class="form-control" type="number" name="dep_total_hato1" step="any" readonly="">' +
      '</div>' +
    '</div>' +
    '<div class="form-group">' +
      '<label for="dep_total_vinentre1">Total hato :</label>' +
      '<div>' +
        '<input id="dep_total_vinentre1" class="form-control" type="number" name="dep_total_vinentre1" step="any" readonly="">' +
      '</div>' +
    '</div>' +
    // Boton para ir creando campos para depreciacion
    '<a id="anadir_depreciacion"><i class="fa fa-plus-circle"></i></a>'
  )

  //añade los campos se se van necesitando para depreciacion
  $("#anadir_depreciacion").click(function(event) {
    $("#depreciacion").append(
      '<div class="form-group div_insumos'+contador_depreciacion+'">' +
        '<label class="sr-only" for="dep_nombre'+contador_depreciacion+'">Nombre:</label>' +
        '<div>' +
          '<select id="dep_nombre'+contador_depreciacion+'" class="form-control" name="dep_nombre'+contador_depreciacion+'">' +
            '<option>Corrales</option><option>Vehículo</option><option>Maquinaria</option><option>Equipo</option><option>Otros</option>' +
          '</select>' +
        '</div>' +
      '</div>' +
      '<div class="form-group div_insumos'+contador_depreciacion+'">' +
        '<label class="sr-only" for="dep_precio_unitario'+contador_depreciacion+'">$ / ton:</label>' +
        '<div>' +
          '<input id="dep_precio_unitario'+contador_depreciacion+'" class="form-control" type="number" name="dep_precio_unitario'+contador_depreciacion+'" step="any">' +
        '</div>' +
      '</div>' +
      '<div class="form-group div_insumos'+contador_depreciacion+'">' +
        '<label class="sr-only" for="dep_anos'+contador_depreciacion+'"># dias:</label>' +
        '<div>' +
          '<input id="dep_anos'+contador_depreciacion+'" class="form-control" type="number" name="dep_anos'+contador_depreciacion+'" step="any">' +
        '</div>' +
      '</div>' +
      '<div class="form-group div_insumos'+contador_depreciacion+'">' +
        '<label class="sr-only" for="dep_total_hato'+contador_depreciacion+'">kg / vientre / dia :</label>' +
        '<div>' +
          '<input id="dep_total_hato'+contador_depreciacion+'" class="form-control" type="number" name="dep_total_hato'+contador_depreciacion+'" step="any" readonly="">' +
        '</div>' +
      '</div>' +
      '<div class="form-group div_insumos'+contador_depreciacion+'">' +
        '<label class="sr-only" for="dep_total_vinentre'+contador_depreciacion+'">.</label>' +
        '<div>' +
          '<input id="dep_total_vinentre'+contador_depreciacion+'" class="form-control" type="number" name="dep_total_vinentre'+contador_depreciacion+'" step="any" readonly="">' +
        '</div>' +
      '</div>' +
      '<a class="div_insumos'+contador_depreciacion+'"><i class="fa fa-minus-circle"></i></a>'
    )
    contador_depreciacion++
  })
  //elimina la deprecicion que no necesitas
  $("#depreciacion").delegate("a","click", function(event) {
    if ($(this).attr('id') != 'anadir_depreciacion' ) {
      $('.' + $(this).attr('class')).remove();
    }
  })
}); 