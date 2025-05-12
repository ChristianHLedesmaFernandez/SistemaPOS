<?php 

//require_once "funcs/funcs.php";

class ControladorUsuarios{
	// Mostrar los Usuarios
	static public function ctrMostrarUsuarios($item, $valor){
		$respuesta = ModeloUsuarios::mdlMostrarUsuarios($item, $valor);
		return $respuesta;
	}
	// Crear Usuario

	//                    Separar mejor los errores. para una mejor vista 



	static public function ctrCrearUsuario(){
		if(isset($_POST['nuevoUsuario'])){
			// Convierto el nombre a minuscula con la primer letra de cada palabra en mayuscula			
			$nombre = ucwords(strtolower($_POST['nuevoNombre']));
			$usuario = ucwords(strtolower($_POST['nuevoUsuario']));
			// Convierto el mail todo a minuscula
			$email = strtolower($_POST['nuevoEmail']);			
			// Fin Convertir Cadenas
			$password = $_POST['nuevoPassword'];			
			$tipo_usuario = $_POST["nuevoPerfil"];
			//if(camposValidos($nombre, $usuario, $password, $password, $email, $email)){
			if (isNombre($nombre) && 
				isUsuario($usuario) && 
				isPassword($password) && 
				isEmail($email)){
				// Evitar usuarios repetido			
				if(!usuarioExiste($usuario)){
					// Evitar Email repetido
					if(!emailExiste($email)){
						// Validar Imagen
						$ruta = "";				
						if(isset($_FILES["nuevaFoto"]["tmp_name"])){
							// Para redimensionar la foto
							list($ancho, $alto) = getimagesize($_FILES["nuevaFoto"]["tmp_name"]);
							$nuevoAncho = 500;
							$nuevoAlto = 500;
							// Creamos el directorio donde guardaremos la foto
							$directorio = "vistas/img/usuarios/". $_POST["nuevoUsuario"];
							mkdir($directorio, 0755);
							$rand = mt_rand(100, 999);	// nombre del archivo
							// Guardo segun la imagen sea JPG o PNG 
							if($_FILES["nuevaFoto"]["type"] == "image/jpeg"){						
								$ruta = "vistas/img/usuarios/" . $_POST["nuevoUsuario"] . "/".$rand . ".jpg";
								$origen = imagecreatefromjpeg($_FILES["nuevaFoto"]["tmp_name"]);
								$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
								imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
								imagejpeg($destino, $ruta);
								}
							if($_FILES["nuevaFoto"]["type"] == "image/png"){
								$ruta = "vistas/img/usuarios/" . $_POST["nuevoUsuario"] . "/".$rand . ".png";
								$origen = imagecreatefrompng($_FILES["nuevaFoto"]["tmp_name"]);
								$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
								imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
								imagepng($destino, $ruta);						
							}
						}
						// Encriptacion de Contraseña
						$activo = 3;
						$encriptar = cifrarPassword($_POST["nuevoPassword"]);
						$token =  generaToken();
						// Cargar Datos en un array()
						$datos = array("nombre"   => $nombre,
									   "usuario"  => $usuario,
									   "correo"	  => $email,
									   "password" => $encriptar,
									   "perfil"   => $tipo_usuario,
									   "token"	  => $token,
									   "estado"   => $activo,
									   "foto" 	  => $ruta);
						// Fin Cargar Datos
						$respuesta = ModeloUsuarios::mdlRegistrarUsuario($datos);
						// Para redirigirse a la pagina 
						$pagina = strtolower($tipo_usuario)."es";
						if($respuesta){
							echo '<script>
								swal({
									type: "success",
									title: "¡El '.$tipo_usuario.' se guardo correctamente!",
									showConfirmButton: true,						
									confirmButtonText: "Cerrar"
									}).then(function(result){
										if(result.value){						
											window.location = "'.$pagina.'";
										}
									});	
								</script>';						
						}
					}else{
						echo '<script>
						swal({
							type: "error",
							title: "¡El correo '.explode('@', $email, 2)[0].' ya existe en el Sistema!",
							showConfirmButton: true,						
							confirmButtonText: "Cerrar"
							}).then(function(result){
								if(result.value){						
									window.location = "'.$pagina.'";
								}
							});	
						</script>';	
					}
					// Fin email repetido
				}else{
					echo '<script>
					swal({
						type: "error",
						title: "¡El nombre de Usuario '.$usuario.' ya se encuentra en uso!",
						showConfirmButton: true,						
						confirmButtonText: "Cerrar"
						}).then(function(result){
							if(result.value){						
								window.location = "'.$pagina.'";
							}
						});	
					</script>';	
				}
				// Fin usuario repetido
			}else{
				echo '<script>
				swal({
					type: "error",
					title: "¡Los campos no pueden ir vacío o llevar caracteres especiales!",
					showConfirmButton: true,						
					confirmButtonText: "Cerrar"
					}).then(function(result){
						if(result.value){						
							window.location = "'.$pagina.'";
						}
					});	
				</script>';	
			}
			
		} 
	}
	// Editar Usuario
	static public function ctrEditarUsuario(){
		if(isset($_POST["editarUsuario"])){
			$nombre = ucwords(strtolower($_POST["editarNombre"]));
			$usuario = $_POST["editarUsuario"];
			$tipo_usuario = $_POST["editarPerfil"];	
			$pagina = strtolower($_POST["perfilActual"])."es";		
			if(isNombre($nombre)){
				// Validar Imagen
				$ruta = $_POST["fotoActual"];
				if(isset($_FILES["editarFoto"]["tmp_name"]) && !empty($_FILES["editarFoto"]["tmp_name"])){
					// Para redimensionar la foto
					list($ancho, $alto) = getimagesize($_FILES["editarFoto"]["tmp_name"]);
					$nuevoAncho = 500;
					$nuevoAlto = 500;
					// Creamos el directorio donde guardaremos la foto
					$directorio = "vistas/img/usuarios/". $_POST["editarUsuario"];
					// primero preguntamos si existe otra foto en la Base de Datos
					if(!empty($_POST["fotoActual"])){
						unlink($_POST["fotoActual"]);
					}else{
						mkdir($directorio, 0755);
					}
					$rand = mt_rand(100, 999);	// nombre del archivo
					// Guardo segun la imagen sea JPG o PNG 
					if($_FILES["editarFoto"]["type"] == "image/jpeg"){						
						$ruta = "vistas/img/usuarios/" . $_POST["editarUsuario"] . "/".$rand . ".jpg";
						$origen = imagecreatefromjpeg($_FILES["editarFoto"]["tmp_name"]);
						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
						imagejpeg($destino, $ruta);
						}
					if($_FILES["editarFoto"]["type"] == "image/png"){
						$ruta = "vistas/img/usuarios/" . $_POST["editarUsuario"] . "/".$rand . ".png";
						$origen = imagecreatefrompng($_FILES["editarFoto"]["tmp_name"]);
						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
						imagepng($destino, $ruta);						
					}
				}
				$password = $_POST["editarPassword"];			
				if($password != ''){
					if(isPassword($password)){
						// Encriptacion de Contraseña
						$encriptar = cifrarPassword($password);						
					}else{
						echo '<script>
							swal({
								type: "error",
								title: "¡La contraseña no puede ir vacía o llevar caracteres especiales!",
								showConfirmButton: true,						
								confirmButtonText: "Cerrar"
								}).then(function(result){
									if(result.value){						
										window.location = "'.$pagina.'";
									}
								});	
							</script>';
					}
				}else{
					$encriptar = $_POST["passwordActual"];
				}
				$datos = array('nombre'  => $nombre, 
							   'usuario' => $usuario, 
							   'password'=> $encriptar, 
							   'perfil'  => $tipo_usuario,
							   'foto' 	 => $ruta);
				$respuesta = ModeloUsuarios::mdlEditarUsuario($datos);				
				if($respuesta){
					$pagina = strtolower($tipo_usuario)."es";
					echo '<script>
						swal({
							type: "success",
							title: "¡El '.$tipo_usuario.' se guardo correctamente!",
							showConfirmButton: true,						
							confirmButtonText: "Cerrar"
							}).then(function(result){
								if(result.value){						
									window.location = "'.$pagina.'";
								}
							});	
						</script>';
				}
				/*
				 else{
				 	echo '<script>
					swal({
						type: "error",
						title: "¡Error al Modificar Registro!",
						showConfirmButton: true,						
						confirmButtonText: "Cerrar"
						}).then(function(result){
							if(result.value){						
								window.location = "'.$pagina.'";
							}
						});	
					</script>';
				 }
				*/
			}else{
				echo '<script>
				swal({
					type: "error",
					title: "¡El nombre no puede ir vacío o llevar caracteres especiales!",
					showConfirmButton: true,						
					confirmButtonText: "Cerrar"
					}).then(function(result){
						if(result.value){						
							window.location = "'.$pagina.'";
						}
					});	
				</script>';
			}
		}
	}
	// Eliminar Usuario
	static public function ctrBorrarUsuario(){
		if(isset($_GET["idUsuario"])){
			$datos = $_GET["idUsuario"];
			$pagina = $_GET["perfil"];
			// Borramos la foto y la carpeta.
			if(!empty($_GET["fotoUsuario"])){
				unlink($_GET["fotoUsuario"]);
				rmdir('vistas/img/usuarios/'.$_GET["usuario"]);
			}
			$respuesta = ModeloUsuarios::mdlBorrarUsuario($datos);
			if($respuesta){
				echo '<script>
						swal({
							type: "success",
							title: "El Usuario ha sido borrado correctamente",
							showConfirmButton : true,
							confirmButtonText: "Cerrar",
							closeOnConfirm: false,							
							}).then((result)=>{
									if(result.value){
										window.location = "'.$pagina.'";
									}
								})
				      </script>';
			}
		}
	}
	//-------------------------------------------------------------------------------------------------------------//
	//                                         Metodos antes de Logearse
	//-------------------------------------------------------------------------------------------------------------//
	// Controlar el ingreso del usuario al sistema
	static public function ctrIngresoUsuario(){
		if(isset($_POST["ingUsuario"])){
			// Modificacion para que loguee con correo
			/*
			if(preg_match('/^[a-zA-Z0-9]+$/', $_POST["ingUsuario"]) &&
			   	preg_match('/^[a-zA-Z0-9]+$/', $_POST["ingPassword"])){
			*/ 
			if((preg_match('/^[a-zA-Z0-9]+$/', $_POST["ingUsuario"]) || 
				preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["ingUsuario"]) ) &&
			   	preg_match('/^[a-zA-Z0-9]+$/', $_POST["ingPassword"])){
			// Fin modificacion
				$usuario = $_POST["ingUsuario"];
				$password = $_POST["ingPassword"];
				$respuesta = ModeloUsuarios::mdlLogin($usuario);
				// Verificamos que este en la Base de Datos.
				if($respuesta){
					// Verificamos que las contraseñas coincidan. 
					$passwd = $respuesta["password"];
					$validaPassw = password_verify($password, $passwd);
					if($validaPassw){
						// Verifica que el usuario ingresado este activo
						$estado = $respuesta["estado"];						
						if(isActivo($estado)){
							// Variables de Sesion
							$_SESSION["iniciarSesion"] = true;
							$_SESSION["id"] = $respuesta["id"];
							$_SESSION["nombre"] = $respuesta["nombre"];
							$_SESSION["apellido"] = $respuesta["apellido"];
							$_SESSION["usuario"] = $respuesta["usuario"];
							$_SESSION["foto"] = $respuesta["foto"];
							$_SESSION["perfil"] = $respuesta["perfil"];	
							// Actualizo el ultimo Login			
							$ultimoLogin = ModeloUsuarios::mdlUltimoLogin($respuesta["id"]);
							if ($ultimoLogin) {
								//$token = $respuesta["token"];
								if(primeraVez($estado)){									
									echo '<br><div class="alert alert-danger">El usuario aùn no Completo el Registro</div>';
									}else {
										echo '<script>window.location = "inicio";</script>';
									}	
								}			
						} else{
							echo '<br><div class="alert alert-danger">El usuario aùn no esta activado</div>';
						}
					} else{						
						echo '<br><div class="alert alert-danger">La contrase&ntilde;a es incorrecta</div>';					
					}
				} else{
					echo '<br><div class="alert alert-danger">El nombre de usuario o correo electr&oacute;nico no existe</div>';
				}
			}
		}		
	}
	// Solicitar registro 
	static public function ctrRegistroUsuario(){
		$errores = 0; 	// Cuenta los errores del formulario
		if(!empty($_POST)){
			// Convierto el nombre a minuscula con la primer letra de cada palabra en mayuscula
			$nombre = ucwords(strtolower($_POST['ingNombre']));
			$usuario = ucwords(strtolower($_POST['ingUsuario']));
			// Convierto el mail todo a minuscula
			$email = strtolower($_POST['ingEmail']);
			$con_email = strtolower($_POST['reIngEmail']);
			// Fin Convertir Cadenas
			$password = $_POST['ingPassword'];
			$con_password = $_POST['reIngPassword'];
			// Datos para el Capcha de Google
			$captcha = $_POST['g-recaptcha-response'];
			$secret = '6LemHsYUAAAAAArx-aGSF4OraqSWKGZQqH1fY02d';	// Clave secreta del Captcha
			$activo = 1;											// El usuario tendra su estado inactivo al momento de registrarse
			$tipo_usuario = "Cliente";								// Indica el privilegio que tiene el usuario 		
			// Fin Datos Captcha		
			// Verifico errores en el formulario
			if(!isNombre($nombre)){
				$errores++;
				echo '<br><div class="alert alert-danger">El Nombre no puede ir vacío o llevar caracteres especiales</div>';
			}else{
				if(!isUsuario($usuario)){
					$errores++;
					echo '<br><div class="alert alert-danger">El Usuario no puede ir vacío o llevar caracteres especiales!</div>';
				}else{
					if (usuarioExiste($usuario)) {
						$errores++;
						echo '<br><div class="alert alert-danger">El nombre de usuario '.$usuario.' ya existe</div>';
					}else{
						if (!isEmail($email)) {
							$errores++;
							echo '<br><div class="alert alert-danger">Direccion de correo invalida</div>';
						}else{
							// Validaciones sobre la Base de Datos.
							if (emailExiste($email)) {
								$errores++;
								echo '<br><div class="alert alert-danger">El correo electronico '.$email.' ya existe</div>';
							}else{
								if(!validarEmail($email, $con_email)){
									$errores++;
									echo '<br><div class="alert alert-danger">Los email no coinciden</div>';
								}else{
									if(!isPassword($password)){
										$errores++;
										echo '<br><div class="alert alert-danger">El Password no puede llevar caracteres especiales!</div>';
									}else{
										if(!validarPassword($password, $con_password)){
											$errores++;
											echo '<br><div class="alert alert-danger">Las contraseñas no coinciden</div>';	
										}else{
											// Verificar Captcha que se halla presionado el captcha
											if (!$captcha) {
												$errores++;
												echo '<br><div class="alert alert-danger">Por favor verifica el captcha</div>';
											}
											// Fin Verificar Captcha
										}
									}
								}
							}

						}
					}
				}
			}	
			// Fin Verificar Errores
			if ($errores == 0) {
				// Validar captcha directamente en google. regresa un Json
				$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$captcha");
				$arr = json_decode($response, TRUE);
				// Si los datos que regresa google son correctos empesamos a registrar el usuario caso contrario regresamos un msj de error
				if ($arr['success']) {
					// Ciframos la contraseña para guardarla en la Base de datos.
					$pass_hash = cifrarPassword($password);
					//$pass_hash = hashPassword($password);
					$token =  generaToken();
					// Registramos el Usuario
					$ruta = "";
					
					$datos = array("nombre" 	=> $nombre,
								   "usuario"	=> $usuario,
								   "correo"	 	=> $email,
								   "password" 	=> $pass_hash,
								   "perfil" 	=> $tipo_usuario,
								   "token"		=> $token,
								   "estado" 	=> $activo,
							   	   "foto" 		=> $ruta);

					$respuesta = ModeloUsuarios::mdlRegistrarUsuario($datos);
					if($respuesta){
						// Enviar al Administrador un correo con una notificacion con la peticion de Registro.
						$url = 'http://'.$_SERVER["SERVER_NAME"].'/willycafe/index.php';

						$asunto = "Aviso de Registracion - Willy Cafe";
						$cuerpo = "Estimado Administrador: <br /><br /> Se detecto una nueva solicitud de Registro de <strong>$nombre</strong>. Por favor a la Brevedad ingrese a su cuenta para aceptar o rechazar dicha solicitud. <br /> <a href='$url'>Ir</a>";
						if(enviarEmail(constant('MAIL-USER'), "Sistema de Registro", $asunto, $cuerpo)){
							$msj = "Su solicitud de Registro fue enviada con exito. A la Brevedad recibira un email con los pasos a seguir para completar el Registro.";
  							echo '<script>window.location = "index.php?ruta=mensaje&msj='.$msj.'";</script>';
							exit;
						}else{
							echo '<br><div class="alert alert-danger">Error al enviar Email al Administrador</div>';
						}

					}else{
						echo '<br><div class="alert alert-danger">Error al Registrar</div>';
					}
				}
			}
		}		
	}
	// Recuperar la contraseña
	static public function ctrRecuperarPassword(){	
		if (!empty($_POST)) {
			$email = $_POST["ingEmail"];			
			if (!isEmail($email)) {				
				echo '<br><div class="alert alert-danger">Debe ingresar un correo electronico valido</div>';
			}else{
				$item = "correo";
				$valor = $email;
				$respuesta = ModeloUsuarios::mdlMostrarUsuarios($item, $valor);
				// Verificamos que este en la Base de Datos.				
				if($respuesta){
					foreach ($respuesta as $key => $value) {
						$idUsuario = $value["id"];
						$nombre = $value["nombre"];
						$solicitud = $value["password_request"];
						$estado = $value["estado"];
					}
					if(!isActivo($estado)){
						echo '<br><div class="alert alert-danger">Aun no es un usuario Activo</div>';
					}else{		
						if($solicitud == 0){							
							$tokenPass = generaToken();
							// Actualizamos en la base user_config el token_password
							$tabla = "user_config";
							$item1 = "token_password";
							$valor1 = $tokenPass;
							$item2 = "id_user";
							$valor2 = $idUsuario;	 
							$actualizarTokenPass = ModeloUsuarios::mdlActualizarUsuario($tabla, $item1, $valor1, $item2, $valor2);
							if($actualizarTokenPass){
								// Actualizamos en la base user_config el password recuest a 1
								$item1 = "password_request";
								$valor1 = 1;				 
								$actualizarPasswordRequest = ModeloUsuarios::mdlActualizarUsuario($tabla, $item1, $valor1, $item2, $valor2);	
								if($actualizarPasswordRequest){
									// Preparo para enviar el mail
									$url = 'http://'.$_SERVER["SERVER_NAME"].'/willycafe/index.php?ruta=cambiarpass&idUsuario='.$idUsuario.'&token='.$tokenPass;
									$asunto = 'Recuperar Password - Willy Cafe';
									$cuerpo = "Hola $nombre: <br /><br />Se ha solicitado una nueva contrase&ntilde;a. <br /><br />Para restaurar la contrase&ntilde;a, visita la siguiente direcci&oacute;n: <a href='$url'>Nueva Contrase&ntilde;a</a>";
									if(enviarEmail($email, $nombre, $asunto, $cuerpo)){
										$msj = "Se a enviado un correo electronico para restrablecer su contraseña.";
			  							echo '<script>window.location = "index.php?ruta=mensaje&msj='.$msj.'";</script>';
										exit;
									}else{
										echo '<br><div class="alert alert-danger">Error al enviar Email. Intentelo mas tarde</div>';
										// pongo en 0 el password request
										$item1 = "password_request";
										$valor1 = 0;			 
										$actualizarUsuario = ModeloUsuarios::mdlActualizarUsuario($tabla, $item1, $valor1, $item2, $valor2);
									}
								}else{
									echo '<br><div class="alert alert-danger">Hubo un error!. Por favor intentelo nuevamente</div>';
								}
							}else{
								echo '<br><div class="alert alert-danger">Hubo un error!. Por favor intentelo nuevamente</div>';
							}							
						}else{
							echo '<br><div class="alert alert-danger">Tiene una solicituda de password pendiente</div>';
						}					
					}
				}else{
					echo '<br><div class="alert alert-danger">No existe el correo electronico</div>';
				}	
			}	
		}
	}
	// Validar Token Password 
	static public function ctrValidarTokenPass(){	
		if(empty($_GET['idUsuario']) AND empty($_GET['token'])){
			echo '<script>window.location = "login";</script>';
		}
		$idUsuario = $_GET['idUsuario'];
		$token = $_GET['token'];
		$verificaTokenPass = ModeloUsuarios::mdlValidarTokenPass($idUsuario, $token);
		if(!$verificaTokenPass){
			$msj = "<i class='fa fa-warning text-red'></i> Oops! No se puedo verificar los datos.";		
			echo '<script>window.location = "index.php?ruta=mensaje&msj='.$msj.'";</script>';	
			exit;
		}
		$estado = $verificaTokenPass["estado"];
		$passwordRequest = $verificaTokenPass["password_request"];
		if(!isActivo($estado) || $passwordRequest != 1){
			$msj = "<i class='fa fa-warning text-red'></i> Oops! No se puedo verificar los datos.";		
			echo '<script>window.location = "index.php?ruta=mensaje&msj='.$msj.'";</script>';			
			exit;
		}
		return "ok";
	}
	// Cambiar Password
	static public function ctrCambiarPassword(){
		if(isset($_POST["idUsuario"]) && isset($_POST["token"]) && isset($_POST["password"]) && isset($_POST["rePassword"])){
			$idUsuario = $_POST["idUsuario"];
			$token = $_POST["token"];
			$password = $_POST["password"];
			$con_password = $_POST["rePassword"];
			if(!isPassword($password)){
				echo '<br><div class="alert alert-danger">Las contraseñas Debe llevar solo letras y numeros</div>';	
			}else{				
				if(!validarPassword($password, $con_password)){
					echo '<br><div class="alert alert-danger">Las contraseñas no coinciden</div>';
				}else{	
					$pass_hash = cifrarPassword($password);
					$respuesta = ModeloUsuarios::mdlCambiarPassword($pass_hash, $idUsuario, $token);
					if($respuesta){
						$msj = "La contraseña se modifico correctamente.";
			  			echo '<script>window.location = "index.php?ruta=mensaje&msj='.$msj.'";</script>';
					}else {
						echo "<br><div class='alert alert-danger'>Hubo un error al modificar contraseña!. Por favor intentelo nuevamente mas tarde</div>";			
					}
				}
			}
		}	
	}

}