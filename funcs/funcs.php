<?php 
// Contiene funciones auxiliares.

//                                                   Categorias                                                   //

// Verifica que el nombre de Usuario no exista en la base de datos.
function categoriaExiste($categoria){
	$item = "categoria";
	$valor = $categoria;
	$respuesta = ModeloCategorias::mdlMostrarCategorias($item, $valor);		
	if ($respuesta){		
		return true;
	} else{
		return false;
	}
}
//----------------------------------------------------------------------------------------------------------------//
//                                                     Locales                                                    //
// Generar password aleatorio
function generaPassword(){
	$cadena_base =  'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
	$cadena_base .= '0123456789' ;
	//$cadena_base .= '!@#%^&*()_,./<>?;:[]{}\|=+';
	$password = '';
	$limite = strlen($cadena_base) - 1;
	for ($i=0; $i < 14; $i++)
		$password .= $cadena_base[rand(0, $limite)];
	return $password;
}
// Verifica que el nombre del Local no exista en la base de datos.
function localExiste($local){
	$item = "nombre";
	$valor = $local;
	$respuesta = ModeloLocales::mdlMostrarLocales($item, $valor);		
	if ($respuesta){
		return true;
	} else{
		return false;
	}
}
// Verifica que el nombre del Local sugerido no exista en la base de datos.
function localSugeridoExiste($local){
	$item = "nombre";
	$valor = $local;
	$respuesta = ModeloLocales::mdlMostrarLocalesSugerido($item, $valor);		
	if ($respuesta){
		return true;
	} else{
		return false;
	}
}
// Validar Direccion
function isDireccion($direccion){
	if(preg_match('/^[#\.\-a-zA-Z0-9 ]+$/', $direccion)){
		return true;
	} else{
		return false;
	}
}
// Validar Telefono
function isTelefono($telefono){
	if(preg_match('/^[()\-0-9 ]+$/', $telefono)){
		return true;
	} else{
		return false;
	}
}
//----------------------------------------------------------------------------------------------------------------//
//                                                    Usuarios                                                    // 
//----------------------------------------------------------------------------------------------------------------//
// Validacion de Campos
// Validar si un campo es nulo
function isNull($campo){
		if(strlen(trim($campo)) < 1){
			return true;
		} else{
			return false;
		}		
	}
// Validar Nombre
function isNombre($nombre){
	if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $nombre)){
		return true;
	} else{
		return false;
	}
}
// Validar Usuario
function isUsuario($user){
	if(preg_match('/^[a-zA-Z0-9]+$/', $user)){
		return true;
	} else{
		return false;
	}
}
// Validar Email
function isEmail($email){
	if(preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $email) && 
	   filter_var($email, FILTER_VALIDATE_EMAIL)){
		return true;
	} else{
		return false;
	}
}
// Validar Password
function isPassword($pass){
	if(preg_match('/^[a-zA-Z0-9]+$/', $pass)){
		return true;
	} else{
		return false;
	}
}
// Verifica que el nombre de Usuario no exista en la base de datos.
function usuarioExiste($usuario){
	$item = "usuario";
	$valor = $usuario;
	$respuesta = ModeloUsuarios::mdlMostrarUsuarios($item, $valor);		
	if ($respuesta){
		return true;
	} else{
		return false;
	}
}
// Verifica que el correo ingresado no exista en la base de datos.
function emailExiste($email){
	$item = "correo";
	$valor = $email;
	$respuesta = ModeloUsuarios::mdlMostrarUsuarios($item, $valor);	
	if ($respuesta){		
		return true;
	} else{
		return false;	
	}
}
// Verifica que los email sean iguales.
function validarEmail($var1, $var2){
	if (strcmp($var1, $var2) !== 0){
		return false;
	} else{
		return true;
	}
}
// Verifica que los password sean iguales.
function validarPassword($var1, $var2){
	if (strcmp($var1, $var2) !== 0){
		return false;
	} else{
		return true;
	}
}
// Verifica que el usuario ingresado este activo
function isActivo($estado){
	return ($estado == 3 || $estado == 4);
	/*
	if ($estado == 3 || $estado == 4){
		return true;
	} else{
		return false;	
	}
	*/
}
// Verifica si el usuario ingresa por primera vez
function primeraVez($estado){
	return ($estado == 3);
	/*
	if($estado == 3) {	
		return true;
	}			
	return false;
	*/
}
// Envia mail 
function enviarEmail($email, $nombre, $asunto, $cuerpo){
	require_once 'PHPMailer/PHPMailerAutoload.php';	
	$mail = new PHPMailer();
	$mail->isSMTP();
	$mail->SMTPAuth = true;
	$mail->SMTPSecure = 'tls'; 						// Tipo de seguridad
	$mail->Host = 'smtp.gmail.com'; 				// Host
	$mail->Port = '587';							// Puerto		
	$mail->Username = constant('MAIL-USER');		// Correo desde el cual mandaremos los correos						
	$mail->Password = constant('MAIL-PASSWORD');	// Password		
	$mail->setFrom(constant('MAIL-USER'), 'Sistema de Usuarios');
	$mail->addAddress($email, $nombre);				
	$mail->Subject = $asunto;
	$mail->Body    = $cuerpo;
	$mail->IsHTML(true);
	return $mail->send();
	/*		
	if()
	return true;
	else
	return false;
	*/
}
// Cifra el password 
function cifrarPassword($password){
	$hash = password_hash($password, PASSWORD_DEFAULT);
	return $hash;
}
// Genera un Token, un valor a partir de la hora y fecha de sistema. 
function generaToken(){
	$gen = md5(uniqid(mt_rand(), false));	
	return $gen;
}
?>