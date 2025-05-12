<?php 

//require_once "funcs/funcs.php";

class ControladorCategorias{
	// Mostrar Categorias
	static public function ctrMostrarCategorias($item, $valor){		
		$respuesta = ModeloCategorias::mdlMostrarCategorias($item, $valor);
		return $respuesta;	
	}

	// Crear Categoria
	static public function ctrCrearCategoria(){
		if(isset($_POST["nuevaCategoria"])){
			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevaCategoria"])){
				// Paso el dato convertido en Mayuscula
				$datos = strtoupper($_POST["nuevaCategoria"]);
				// Verifico que la Categoria no exista
				if(!categoriaExiste($datos)){				
					// Paso el dato convertido en Mayuscula
					$datos = strtoupper($_POST["nuevaCategoria"]);
					$respuesta = ModeloCategorias::mdlCrearCategoria($datos);
					if($respuesta){
						echo '<script>
								swal({
									type: "success",
									title: "La categoria ha sido guardada correctamente",
									showConfirmButton: true,				
									confirmButtonText: "Cerrar"
									}).then(function(result){
										if(result.value) {						
											window.location = "categorias";
										}
									})	
								</script>';
					}
				} else{
					echo '<script>
					swal({
						type: "error",
						title: "¡La categoria '.$datos.' ya Existe!",
						showConfirmButton: true,				
						confirmButtonText: "Cerrar"
						}).then(function(result) {
							if(result.value){						
								window.location = "categorias";
							}
						})	
					</script>';
				}
			}else{
				echo '<script>
				swal({
					type: "error",
					title: "¡La categoria no puede ir vacía o llevar caracteres especiales!",
					showConfirmButton: true,				
					confirmButtonText: "Cerrar"
					}).then(function(result) {
						if(result.value){						
							window.location = "categorias";
						}
					})	
				</script>';
			}
		}
	}
	// Editar Categoria
	static public function ctrEditarCategoria(){
		if(isset($_POST["editarCategoria"])){
			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarCategoria"])){
				$datos = array("categoria"=>strtoupper($_POST["editarCategoria"]), 
								      "id"=>$_POST["idCategoria"]);
				$respuesta = ModeloCategorias::mdlEditarCategoria($datos);
				if($respuesta){
					echo'<script>
						swal({
						  type: "success",
						  title: "La categoría ha sido cambiada correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {
									window.location = "categorias";
									}
								})
						</script>';
				}
			}else{
				echo'<script>
						swal({
							  type: "error",
							  title: "¡La categoría no puede ir vacía o llevar caracteres especiales!",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							  }).then(function(result){
								if (result.value) {
								window.location = "categorias";
								}
							})

				  	</script>';
			}
		}
	}
	// Eliminar Categoria
	static public function ctrBorrarCategoria(){
		if(isset($_GET["idCategoria"])){
			$datos = $_GET["idCategoria"];
			$respuesta = ModeloCategorias::mdlBorrarCategoria($datos);
			if($respuesta){
				echo'<script>
						swal({
						  type: "success",
						  title: "La categoría ha sido borrada correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
								if (result.value) {
									window.location = "categorias";
								}
							})
					</script>';
			}
		}
	}
}
