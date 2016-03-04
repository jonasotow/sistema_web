<!-- <article class="tabs">
<section id="tab1">
<h2><a href="#tab1">Tab 1</a></h2> -->

<!-- <link rel="stylesheet" type="text/css" href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
<nav class="main-menu">
	<div class="scrollbar">
		<ul>
			<li><a href="http://localhost/sistema_web2/index.php/censos"><i class="fa fa-home"></i><span class="nav-text">Inicio</a></span></li>
			<li><a href="http://localhost/sistema_web2/index.php/clientes"><i class="fa fa-user"></i><span class="nav-text">Cliente</a></span></li>
			<li><a href="http://localhost/sistema_web2/index.php/contactos"><i class="fa fa-user"></i><span class="nav-text">Contacto</a></span></li>
			<li><a href="http://localhost/sistema_web2/index.php/granjas"><i class="fa fa-building-o"></i><span class="nav-text">Granjas</a></span></li>
			<li><a href="http://localhost/sistema_web2/index.php/periodos"><i class="fa fa-calendar-o"></i><span class="nav-text">Periodos</a></span></li>
			<li><a href="http://localhost/sistema_web2/index.php/auth/logout"><i class="fa fa-times-circle"></i><span class="nav-text">Cerrar sesi&oacute;n</span></a></li>
		</ul>
	</div>
</nav> -->
<!-- <form action="http://localhost/sistema_web2/index.php/clientes/crear" method="post" accept-charset="utf-8" class="custform">
				<fieldset>
					<legend>Datos Principales</legend>
					<input type="hidden" name="cli_id_cliente" value="" />			
					<input type="hidden" name="cli_id_cliente" value="" id="cli_id_cliente" maxlength="11" size="11" required />
					<label for="cli_cve_cliente">Clave MFG:</label>
					<input type="text" name="cli_cve_cliente" value="" id="cli_cve_cliente" maxlength="12" size="12" required />
					<label for="cli_nombre">Nombre:</label>
					<input type="text" name="cli_nombre" value="" id="cli_nombre" maxlength="40" size="40" required />
					<label for="cli_direccion">Direccion:</label>
					<textarea id="cli_direccion" rows="4" cols="50" required ></textarea>
					<label for="cli_rfc">RFC:</label>
					<input type="text" name="cli_rfc" value="" id="cli_rfc" maxlength="18" size="18" required />
					<label for="cli_ciudad">Ciudad:</label>
					<input type="text" name="cli_ciudad" value="" id="cli_ciudad" maxlength="20" size="20" required />
					<label for="cli_estado">Estado:</label>
					<select name="cli_estado" required>
						<option value="" selected="selected">Seleccione un Estado</option>
						<option value="Aguascalientes">Aguascalientes</option>
						<option value="Baja California">Baja California</option>
						<option value="Baja California Sur">Baja California Sur</option>
						<option value="Campeche">Campeche</option>
						<option value="Chiapas">Chiapas</option>
						<option value="Chihuahua">Chihuahua</option>
						<option value="Coahuila de Zaragoza">Coahuila de Zaragoza</option>
						<option value="Colima">Colima</option>
						<option value="Distrito Federal">Distrito Federal</option>
						<option value="Durango">Durango</option>
						<option value="Guanajuato">Guanajuato</option>
						<option value="Guerrero">Guerrero</option>
						<option value="Hidalgo">Hidalgo</option>
						<option value="Jalisco">Jalisco</option>
						<option value="Mexico">Mexico</option>
						<option value="Michoacan de Ocampo">Michoacan de Ocampo</option>
						<option value="Morelos">Morelos</option>
						<option value="Nayarit">Nayarit</option>
						<option value="Nuevo Leon">Nuevo Leon</option>
						<option value="Oaxaca">Oaxaca</option>
						<option value="Puebla">Puebla</option>
						<option value="Queretaro de Arteaga">Queretaro de Arteaga</option>
						<option value="Quintana Roo">Quintana Roo</option>
						<option value="San Luis Potosi">San Luis Potosi</option>
						<option value="Sinaloa">Sinaloa</option>
						<option value="Sonora">Sonora</option>
						<option value="Tabasco">Tabasco</option>
						<option value="Tamaulipas">Tamaulipas</option>
						<option value="Tlaxcala">Tlaxcala</option>
						<option value="Veracruz-Llave">Veracruz-Llave</option>
						<option value="Yucatan">Yucatan</option>
						<option value="Zacatecas">Zacatecas</option>
					</select>
					<label for="cli_pais">Pais:</label>
					<input type="text" name="cli_pais" value="" id="cli_pais" maxlength="10" size="10" required />
				</fieldset>
				</section>
	<section id="tab2">
<h2><a href="#tab2">Tab 2</a></h2>

				<fieldset>
					<legend>Datos Secundarios</legend>
					<label for="cli_cp">CP:</label>
					<input type="text" name="cli_cp" value="" id="cli_cp" maxlength="10" size="10" required />
					<input type="hidden" name="cli_fechaalta" value="" />			
					<input type="hidden" name="cli_fechaalta" value="" id="cli_fechaalta" maxlength="10" size="10" required />
					<label for="cli_telefono">Telefono:</label>
					<input type="text" name="cli_telefono" value="" id="cli_telefono" maxlength="18" size="18" required />
					<label for="cli_celular">Celular:</label>
					<input type="text" name="cli_celular" value="" id="cli_celular" maxlength="18" size="18" required />
					<label for="cli_fax">Fax:</label>
					<input type="text" name="cli_fax" value="" id="cli_fax" maxlength="18" size="18" required />
					<label for="cli_correo">Correo:</label>
					<input type="text" name="cli_correo" value="" id="cli_correo" maxlength="20" size="20" required />
					<label for="cli_sitio_web">Sitio Web:</label>
					<input type="text" name="cli_sitio_web" value="" id="cli_sitio_web" maxlength="30" size="30" required />
					<label for="cli_facebook">Facebook:</label>
					<input type="text" name="cli_facebook" value="" id="cli_facebook" maxlength="30" size="30" required />
					<label for="cli_twitter">Twitter:</label>
					<input type="text" name="cli_twitter" value="" id="cli_twitter" maxlength="30" size="30" required />
					<input type="hidden" name="cli_estatus" value="" />			
					<input type="hidden" name="cli_estatus" value="" id="cli_estatus" maxlength="1" size="1" required />
				</fieldset>
			
			</section>
			<section>
			<fieldset class='botones' id='botones'>
		   			<button name="Eliminar" id="Eliminar" type="submit" disabled="disabled">Eliminar</button>
					<button name="" id="Enviar" type="submit">Enviar Datos</button>
					<button name="Borrar" id="Borrar" type="reset" value="Reset">Borrar</button>
		   	</fieldset>
		   	</form>
		   	</section>
			</article>
			-->