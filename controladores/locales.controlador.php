<?php 

class ControladorLocales{
	// Mostrar Locales
	static public function ctrMostrarLocales($item, $valor){		
		$respuesta = ModeloLocales::mdlMostrarLocales($item, $valor);
		return $respuesta;	
	}
	static public function ctrMostrarLocalesSugerido($item, $valor){		
		$respuesta = ModeloLocales::mdlMostrarLocalesSugerido($item, $valor);
		return $respuesta;	
	}
	
	// Crear Local
	static public function ctrCrearLocal(){
		if(isset($_POST["nuevoLocal"])){
			$local = ucwords(strtolower($_POST['nuevoLocal']));
			$telefono = $_POST["nuevoTelefono"];
			$direccion = ucwords(strtolower($_POST['nuevaDireccion']));
			if(isNombre($local) &&					   
			   isTelefono($telefono) &&
			   isDireccion($direccion)){					
				// Verifico que el Local no exista
				if(!localExiste($local)){
					$datos = array("nombre" 	=> $local,
							   	   "telefono" 	=> $telefono,
							   	   "direccion" 	=> $direccion);
					$respuesta = ModeloLocales::mdlCrearLocal($datos);
					if($respuesta){
						echo '<script>
								swal({
									type: "success",
									title: "El local ha sido guardado correctamente",
									showConfirmButton: true,				
									confirmButtonText: "Cerrar"
									}).then(function(result){
										if(result.value) {						
											window.location = "locales";
										}
									})	
								</script>';
					}
				}else{
					echo '<script>
					swal({
						type: "error",
						title: "¡El Local '.$datos.' ya Existe!",
						showConfirmButton: true,				
						confirmButtonText: "Cerrar"
						}).then(function(result) {
							if(result.value){						
								window.location = "locales";
							}
						})	
					</script>';
				}
			}else{
				echo '<script>
				swal({
					type: "error",
					title: "¡Los campos no pueden ir vacíos o llevar caracteres especiales!",
					showConfirmButton: true,				
					confirmButtonText: "Cerrar"
					}).then(function(result) {
						if(result.value){						
							window.location = "locales";
						}
					})	
				</script>';
			}
		}
	}
	// Editar Local
	static public function ctrEditarLocal(){
		if(isset($_POST["editarTelefono"])){
			//$idLocal = $_POST["idLocal"];
			$local = $_POST["editarLocal"];
			$telefono = $_POST["editarTelefono"];
			$direccion = ucwords(strtolower($_POST['editarDireccion']));
			if(isTelefono($telefono) &&
			   isDireccion($direccion)){

				$datos = array("nombre" 	=> $local,
						   	   "telefono" 	=> $telefono,
						   	   "direccion" 	=> $direccion);
				$respuesta = ModeloLocales::mdlEditarLocal($datos);
				if($respuesta){
					echo '<script>
							swal({
								type: "success",
								title: "El local ha sido modificado correctamente",
								showConfirmButton: true,				
								confirmButtonText: "Cerrar"
								}).then(function(result){
									if(result.value) {						
										window.location = "locales";
									}
								})	
							</script>';
				}
				
			}else{
				echo '<script>
				swal({
					type: "error",
					title: "¡Los campos no pueden ir vacíos o llevar caracteres especiales!",
					showConfirmButton: true,				
					confirmButtonText: "Cerrar"
					}).then(function(result) {
						if(result.value){						
							window.location = "locales";
						}
					})	
				</script>';
			}
		}
	}


	// Eliminar Locales
	static public function ctrBorrarLocal(){
		if(isset($_GET["idLocal"])){
			$datos = $_GET["idLocal"];
			$respuesta = ModeloLocales::mdlBorrarLocal($datos);
			if($respuesta){
				echo'<script>
						swal({
						  type: "success",
						  title: "El Local ha sido borrado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
								if (result.value) {
									window.location = "locales";
								}
							})
					</script>';
			}
		}
	}
	
}