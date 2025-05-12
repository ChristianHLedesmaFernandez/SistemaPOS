<?php 

class ControladorSolicitudes extends ControladorUsuarios{
	// Aceptar una Solicitud
	static public function ctrAceptarSolicitud(){
		if(isset($_SESSION["iniciarSesion"]) && !$_SESSION["iniciarSesion"] && $_SESSION["perfil"] != "Administrador"){		
        echo '<script>window.location = "solicitudes";</script>';
    	}
		if(isset($_POST["idUsuarioA"]) && isset($_POST["nombreA"]) && isset($_POST["emailA"]) && isset($_POST["tokenA"])){
			$idUsuario = $_POST['idUsuarioA'];
            $nombre = $_POST['nombreA'];
            $email = $_POST['emailA']; 
            $token = $_POST["tokenA"];  
            // Modifico en tabla user_config el campo estado
            $tabla = "user_config";
            $item1 = "estado";
            $valor1 = 2;
            $item2 = "id_user";
            $valor2 = $idUsuario;
            $respuesta = ModeloSolicitudes::mdlActualizarUsuario($tabla, $item1, $valor1, $item2, $valor2);
			if($respuesta){
				$url = 'http://'.$_SERVER["SERVER_NAME"].'/willycafe/index.php?ruta=activar&idUsuario='.$idUsuario.'&token='.$token;
                $asunto = 'Solicitud Aceptada - Willy Cafe';               
                $cuerpo = "Estimado $nombre: <br/><br />Para completar el proceso de registro, haga click en la siguiente enlace <a href='$url'>Activar Cuenta</a>";
                if(!enviarEmail($email, $nombre, $asunto, $cuerpo)){
                	echo '<script>
						swal({
							type: "success",
							title: "La solicitud de '.$nombre.' a sido Aceptada con exito <br />Error al enviar Email",
							showConfirmButton : true,
							confirmButtonText: "Cerrar",
							closeOnConfirm: false,							
							}).then((result)=>{
									if(result.value){
										window.location = "solicitudes";
									}
								})
				      	</script>';                    
                }else{                	
                    echo '<script>
						swal({
							type: "success",
							title: "La solicitud de '.$nombre.' a sido Aceptada con exito",
							showConfirmButton : true,
							confirmButtonText: "Cerrar",
							closeOnConfirm: false,							
							}).then((result)=>{
									if(result.value){
										window.location = "solicitudes";
									}
								})
				      	</script>';
                    }
			}else{ 
                echo '<script>
				swal({
					type: "error",
					title: "¡No se puedo Aceptar la solicitud!",
					showConfirmButton: true,						
					confirmButtonText: "Cerrar"
					}).then(function(result){
						if(result.value){						
							window.location = "solicitudes";
						}
					});	
				</script>';	
            }
		}
	}
	// Rechazar una Solicitud
	static public function ctrRechazarSolicitud(){
		if(isset($_SESSION["iniciarSesion"]) && !$_SESSION["iniciarSesion"] && $_SESSION["perfil"] != "Administrador"){		
        echo '<script>window.location = "solicitudes";</script>';
    	}
		if(isset($_POST["idUsuarioR"]) && isset($_POST["nombreR"]) && isset($_POST["emailR"])){
			$idUsuario = $_POST['idUsuarioR'];
            $nombre = $_POST['nombreR'];
            $email = $_POST['emailR'];      
            // Elimino el usuario (x relacion deberia de borrar tambien el registro en user_config)
            $respuesta = ModeloSolicitudes::mdlBorrarUsuario($idUsuario);
			if($respuesta){
				// Envio el mail al usuario avisando el rechazo de la Solicitud de Registro                    
                $asunto = 'Solicitud Rechazada - Willy Cafe';
                if($_POST['mensaje'] != ''){
                	$mensaje = $_POST['mensaje'];
                    $cuerpo = "Estimado ".$nombre.": <br/><br />No han aceptado su solicitud de registro. <br />El Administrador adjunto este mensaje: <br/>".$mensaje."<br/><br/> Lo sentimos mucho.";
                } else{
                    $cuerpo = "Estimado ".$nombre.": <br/><br />No han aceptado su solicitud de registro. No se ha indicado los motivos. <br /> Lo sentimos mucho.";  
                }
                if(!enviarEmail($email, $nombre, $asunto, $cuerpo)){
                	echo '<script>
						swal({
							type: "success",
							title: "La solicitud de '.$nombre.' a sido Rechazada con exito <br />Error al enviar Email",
							showConfirmButton : true,
							confirmButtonText: "Cerrar",
							closeOnConfirm: false,							
							}).then((result)=>{
									if(result.value){
										window.location = "solicitudes";
									}
								})
				      	</script>';                    
                }else{                	
                    echo '<script>
						swal({
							type: "success",
							title: "La solicitud de '.$nombre.' a sido Rechazada con exito",
							showConfirmButton : true,
							confirmButtonText: "Cerrar",
							closeOnConfirm: false,							
							}).then((result)=>{
									if(result.value){
										window.location = "solicitudes";
									}
								})
				      	</script>';
                    }
			}else{ 
                echo '<script>
				swal({
					type: "error",
					title: "¡No se puedo rechazar la solicitud!",
					showConfirmButton: true,						
					confirmButtonText: "Cerrar"
					}).then(function(result){
						if(result.value){						
							window.location = "solicitudes";
						}
					});	
				</script>';	
            }
		}
	}
	// Validar Token 
	static public function ctrValidarToken(){	
		if(empty($_GET['idUsuario']) AND empty($_GET['token'])){
			echo '<script>window.location = "login";</script>';		}
		$idUsuario = $_GET['idUsuario'];
		$token = $_GET['token'];
		$verificaToken = ModeloSolicitudes::mdlValidarToken($idUsuario, $token);
		if(!$verificaToken){			
			$msj = "<i class='fa fa-warning text-red'></i> Oops! No se puedo verificar los datos.";	
			echo '<script>window.location = "index.php?ruta=mensaje&msj='.$msj.'";</script>';
			exit;
		}
		$estado = $verificaToken["estado"];
		switch($estado){
		case -1:
	    case 0:
	        $msj = "<i class='fa fa-warning text-red'></i> Oops! No se puedo verificar los datos.";	
	        break;
	    case 1:
			$msj = "<i class='fa fa-warning text-red'></i> Oops! Su Solicitud aun no ha sido Procesada.";
	        break;
	    case 2:
	    	// Modifico en tabla user_config el campo estado
            $tabla = "user_config";
            $item1 = "estado";
            $valor1 = 3;
            $item2 = "id_user";
            $valor2 = $idUsuario;
            $respuesta = ModeloSolicitudes::mdlActualizarUsuario($tabla, $item1, $valor1, $item2, $valor2);
			if($respuesta){
				$msj = "<i class='fa fa-check-circle text-green'></i></i> Su Cuenta ya esta Activa.";
			}else{
				$msj =  "<i class='fa fa-warning text-red'></i> Oops! Hubo un error al activar la Cuenta!. Por favor intentelo nuevamente mas tarde</div>";
			}			
	        break;
		case 3:
		case 4:
			$msj = "<i class='fa fa-warning text-red'></i> Oops! La cuenta ya fue activada.";
	        break;	    
	    }	    
	    echo '<script>window.location = "index.php?ruta=mensaje&msj='.$msj.'";</script>';
		return "ok";		
	}
}