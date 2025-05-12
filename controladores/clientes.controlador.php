<?php 

class ControladorClientes extends ControladorUsuarios{

	// Mostrar los Usuarios
	static public function ctrMostrarUsuarios($item, $valor){
		$respuesta = ModeloClientes::mdlMostrarClientes($item, $valor);
		return $respuesta;
	}
	// Crear Cliente
	static public function ctrCrearCliente(){
		if(isset($_POST["nuevoUsuario"])){		
			$nombre = ucwords(strtolower($_POST['nuevoNombre']));
			//$apellido = $_POST["nuevoApellido"];
			$usuario = ucwords(strtolower($_POST['nuevoUsuario']));							
			$encriptar = "";
			$correo = strtolower($_POST['nuevoEmail']);
			$telefono =  $_POST["nuevoTelefono"];
			$local = $_POST["nuevoLocal"];
			// Para saber si envio el Correo electronico o no
			$envio = false;
			$correcto = true;
			if(isNombre($nombre) && 
				isUsuario($usuario)){
				// Evitar usuario repetido
				if(!usuarioExiste($usuario)){					
					// Verifico si el telefono viene vacio	
					if(!isNull($telefono)){
						if(!isTelefono($telefono)){
							$correcto = false;
							echo("	<script>
										swal({
											type: 'error',
											title: '¡El telefono no puede llevar caracteres especiales!',
											showConfirmButton: true,						
									  		confirmButtonText: 'Cerrar'
											})
											.then((result) => {
											  if (result.value) {
											    window.location = 'clientes';
											  }
										});						
									</script>");
						}
					}					
					// Fin Telefono
					// Si viene el correo pregunto si es correcto caso contrario continuo
					if(!isNull($correo)){
						if(!isEmail($correo)){
							// Si no es Correcto el Correo
							$correcto = false;
							echo("	<script>
										swal({
											type: 'error',
											title: 'El mail es incorrecto!',
											showConfirmButton: true,						
									  		confirmButtonText: 'Cerrar'
											})
											.then((result) => {
											  if (result.value) {
											    window.location = 'clientes';
											  }
										});						
									</script>");
							if(emailExiste($correo)){
								$correcto = false;
								echo("	<script>
										swal({
											type: 'error',
											title: '¡El correo ".explode("@", $correo, 2)[0]." ya existe en el Sistema!',
											showConfirmButton: true,						
									  		confirmButtonText: 'Cerrar'
											})
											.then((result) => {
											  if (result.value) {
											    window.location = 'clientes';
											  }
										});						
									</script>");
							}else{
								$envio = true;
								$password = generaPassword();					
								$encriptar = cifrarPassword($password);
							}
							// Fin Correo repetido
						}
						// Fin Correo Incorrecto																	
					}				
					// Fin Correo
					if($correcto){
						// Sugerir Local Nuevo					
						if($local == "agregarlocal"){
							$idLocal = 0; // Local no definido.					
							$nombreLocal = $_POST["nuevoNombreLocal"];
							$telefonoLocal = -1; // bandera para saber que es una sugerencia de local.
							//Verifico que el nombre sea correcto
							if(isNombre($nombreLocal)){							
								// Si es correcto verifico que no exista en la tabla locales
								if(!localSugeridoExiste($nombreLocal)){
									/// Si no existe guardo en la tabla locales
									$datosLocal = array("nombre"    => $nombreLocal,
														"telefono"  => $telefonoLocal);
									$idLocal = ModeloLocales::mdlSugerirLocal($datosLocal);
								}else{
									// Busco el Id del local
									$item = "nombre";
						            $valor =$nombreLocal;
						            $local = ControladorLocales:: ctrMostrarLocalesSugerido($item, $valor);
						            $idLocal = $local["id_local"];
								}
							}

						}else{
							$idLocal = $local;
						}
						// Fin Sugerir Local
						// Regristrar				
						$tipo_usuario = "Cliente";					
						$pendiente = 2;
						$token =  generaToken();
						$datos = array("nombre"   => $nombre, 
									   "usuario"  => $usuario,
									   "correo"	  => $correo,
									   "telefono" => $telefono,
									   "local"	  => $idLocal,
									   "password" => $encriptar, 
									   "estado"   => $pendiente,
									   "token"	  => $token,
									   "perfil"   => $tipo_usuario);

						$respuesta = ModeloClientes::mdlCrearCliente($datos);								
						if($respuesta){
							// Si se ingreso Correo enviar notificacion
							if($envio){
								// Envio el mail.
								// Obtener id Usuario
								$item = "usuario";
						        $valor =$usuario;
					            $cliente = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);	
						        $idUsuario = $cliente[0]["id"];	
								// Fin obtener
								$url = 'http://'.$_SERVER["SERVER_NAME"].'/willycafe/index.php?ruta=activar&idUsuario='.$idUsuario.'&token='.$token;
								$asunto = 'Alta de Cliente - Willy Cafe';               
				                $cuerpo = "Estimado $nombre: <br/><br/>Para completar el proceso de registro, haga click en la siguiente enlace <a href='$url'>Activar Cuenta</a><br/><br/>Usuario: ".$usuario."<br/>Password: ".$password;
				                if(!enviarEmail($correo, $nombre, $asunto, $cuerpo)){
				                	echo '<script>
										swal({
											type: "success",
											title: "El Cliente '.$nombre.' se guardo Correctamente!<br />Error al enviar Correo",
											showConfirmButton : true,
											confirmButtonText: "Cerrar",					
											}).then((result)=>{
													if(result.value){
														window.location = "clientes";
													}
												})
								      	</script>';                    
				                }
							}
							echo '<script>
										swal({
											type: "success",
											title: "El Cliente '.$nombre.' se guardo correctamente!!",
											showConfirmButton : true,
											confirmButtonText: "Cerrar",					
											}).then((result)=>{
													if(result.value){
														window.location = "clientes";
													}
												})
								   </script>';	
						}						
						// Fin Registrar
					}
				}else{
					echo '<script>
					swal({
						type: "error",
						title: "¡El nombre de Usuario '.$usuario.' ya se encuentra en uso!",
						showConfirmButton: true,						
						confirmButtonText: "Cerrar"
						}).then(function(result){
							if(result.value){						
								window.location = "clientes";
							}
						});	
					</script>';	
				}
				// Fin usuario repetido
			}else{				
				echo '<script>
				swal({
					type: "error",
					title: "¡Los Nombre y Usuario no pueden ir vacío o llevar caracteres especiales!",
					showConfirmButton: true,						
					confirmButtonText: "Cerrar"
					}).then(function(result){
						if(result.value){						
							window.location = "clientes";
						}
					});	
				</script>';	
			}
		}
	}
	// Editar Cliente
	static public function ctrEditarCliente(){
		if(isset($_POST["editarUsuario"])){		
			$nombre = ucwords(strtolower($_POST['editarNombre']));
			//$apellido = $_POST["editarApellido"];
			$usuario = $_POST['editarUsuario'];
			$encriptar = $_POST['passwordActual'];
			$telefono =  $_POST["editarTelefono"];
			$local = $_POST["editarLocal"];
			$localAnterior = $_POST["localActual"];
			$token = $_POST["tokenActual"];
			// Para saber si envio el Correo electronico o no
			$envio = false;
			$correcto = true;				
			if(isNombre($nombre)){					
				// Si viene el telefono pregunto si es correcto caso contrario continuo	
				if(!isNull($telefono)){
					if(!isTelefono($telefono)){
						$correcto = false;
						echo '	<script>
									swal({
										type: "error",
										title: "¡El Telefono no pueden llevar caracteres especiales!",
										showConfirmButton: true,						
										confirmButtonText: "Cerrar"
										}).then(function(result){
											if(result.value){						
												window.location = "clientes";
											}
										});	
								</script>';	
					}				
				}
				// Fin Telefono
				// Comprobar si viene un Mail nuevo
				if(isset($_POST["nuevoEmail"])){
					$correo = strtolower($_POST['nuevoEmail']);
					// Si viene el correo pregunto si es correcto caso contrario continuo
					if(!isNull($correo)){
						if(!isEmail($correo)){
						$correcto = false;
						echo '	<script>
									swal({
										type: "error",
										title: "¡El Correo no puede llevar caracteres especiales!",
										showConfirmButton: true,						
										confirmButtonText: "Cerrar"
										}).then(function(result){
											if(result.value){						
												window.location = "clientes";
											}
										});											
								</script>';								
						}
						// Si es correcto Verifico que no se repita
						if(emailExiste($correo)){
							$correcto = false;
							echo '<script>
									swal({
										type: "error",
										title: "¡El correo '.explode('@', $correo, 2)[0].' ya existe en el Sistema!",
										showConfirmButton: true,						
										confirmButtonText: "Cerrar"
										}).then(function(result){
											if(result.value){						
												window.location = "clientes";
											}
										});	
									</script>';
							// Fin Correo repetido			
						}else{
							$envio = true;
							$password = generaPassword();
							$encriptar = cifrarPassword($password);
							$token =  generaToken();
						}					
					}				
					// Fin Correo
				}else{
					$correo = $_POST['editarEmail'];
				}
				// Fin nuevoEmail					
				if($correcto){
					// Sugerir Local Nuevo					
					if($local == "agregarlocal"){
						$idLocal = 0; // Local no definido.					
						$nombreLocal = $_POST["editarNombreLocal"];
						$telefonoLocal = -1; // bandera para saber que es una sugerencia de local.
						//Verifico que el nombre sea correcto
						if(isNombre($nombreLocal)){							
							// Si es correcto verifico que no exista en la tabla locales
							if(!localSugeridoExiste($nombreLocal)){
								/// Si no existe guardo en la tabla locales
								$datosLocal = array("nombre"    => $nombreLocal,
													"telefono"  => $telefonoLocal);
								$idLocal = ModeloLocales::mdlSugerirLocal($datosLocal);
							}else{
								// Busco el Id del local
								$item = "nombre";
					            $valor =$nombreLocal;
					            $local = ControladorLocales:: ctrMostrarLocalesSugerido($item, $valor);
					            $idLocal = $local["id_local"];
							}
						}
					}else{
						$idLocal = $local;
					}
					// Fin Sugerir Local
					// Si cambio de local y el anterior es un sugerido lo elimino. Siempre y cuando no halla mas usuarios asignado a ese local
					if($idLocal != $localAnterior){
						// Busco el local y verifico que siga siendo sugerido (telefono = -1)
			            $borrarLocal = ModeloLocales:: mdlBorrarLocalSugerido($localAnterior);
			        }
					// Fin eliminar sugerido
					// Editar
					$datos = array("nombre"   => $nombre, 
								   "usuario"  => $usuario,
								   "correo"	  => $correo,
								   "telefono" => $telefono,
								   "local"	  => $idLocal,
								   "password" => $encriptar,
								   "token"	  => $token);
					$respuesta = ModeloClientes::mdlEditarCliente($datos);					
					if($respuesta){
						// Si se ingreso Correo enviar notificacion
						if($envio){
							// Envio el mail.
							// Obtener id Usuario
							$item = "usuario";
					        $valor =$usuario;
				            $cliente = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);	
					        $idUsuario = $cliente[0]["id"];	
							// Fin obtener
							$url = 'http://'.$_SERVER["SERVER_NAME"].'/willycafe/index.php?ruta=activar&idUsuario='.$idUsuario.'&token='.$token;
							$asunto = 'Alta de Cliente - Willy Cafe';               
			                $cuerpo = "Estimado $nombre: <br/><br/>Para completar el proceso de registro, haga click en la siguiente enlace <a href='$url'>Activar Cuenta</a><br/><br/>Usuario: ".$usuario."<br/>Password: ".$password;
			                if(!enviarEmail($correo, $nombre, $asunto, $cuerpo)){
			                	echo '<script>
									swal({
										type: "success",
										title: "El Cliente '.$nombre.' se guardo Correctamente!<br />Error al enviar Correo",
										showConfirmButton : true,
										confirmButtonText: "Cerrar",					
										}).then((result)=>{
												if(result.value){
													window.location = "clientes";
												}
											})
							      	</script>';                    
			                }
						}
						echo '<script>
									swal({
										type: "success",
										title: "El Cliente '.$nombre.' se guardo correctamente!!",
										showConfirmButton : true,
										confirmButtonText: "Cerrar",					
										}).then((result)=>{
												if(result.value){
													window.location = "clientes";
												}
											})
							   </script>';	
					}					
					// Fin Editar
				}										
			}else{				
				echo '<script>
				swal({
					type: "error",
					title: "¡Los Nombre y Usuario no pueden ir vacío o llevar caracteres especiales!",
					showConfirmButton: true,						
					confirmButtonText: "Cerrar"
					}).then(function(result){
						if(result.value){						
							window.location = "clientes";
						}
					});	
				</script>';	
			}
		}	
	}
}