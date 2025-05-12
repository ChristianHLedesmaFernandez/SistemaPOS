<?php 
class ControladorProductos{
	// Mostrar los Productos
	static public function ctrMostrarProductos($item, $valor, $orden){ 		
 		$respuesta = ModeloProductos::mdlMostrarProductos($item, $valor, $orden);
		return $respuesta;
	}
	// Crear Producto
	static public function ctrCrearProducto(){
		if(isset($_POST["nuevaDescripcion"])){
			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevaDescripcion"]) &&
			   preg_match('/^[0-9]+$/', $_POST["nuevoStock"]) &&			   
			   preg_match('/^[0-9.]+$/', $_POST["nuevoPrecioVenta"])){
			   	// Validar Imagen			   	
			   	$ruta = "vistas/img/productos/default/anonymous.png";				
				if(isset($_FILES["nuevaImagen"]["tmp_name"])){
					// Para redimensionar la foto
					list($ancho, $alto) = getimagesize($_FILES["nuevaImagen"]["tmp_name"]);
					$nuevoAncho = 500;
					$nuevoAlto = 500;
					// Creamos el directorio donde guardaremos la foto
					$directorio = "vistas/img/productos/". $_POST["nuevoCodigo"];
					mkdir($directorio, 0755);
					$rand = mt_rand(100, 999);	// nombre del archivo
					// Guardo segun la imagen sea JPG o PNG 
					if($_FILES["nuevaImagen"]["type"] == "image/jpeg"){						
						$ruta = "vistas/img/productos/" . $_POST["nuevoCodigo"] . "/".$rand . ".jpg";
						$origen = imagecreatefromjpeg($_FILES["nuevaImagen"]["tmp_name"]);
						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
						imagejpeg($destino, $ruta);
						}
					if($_FILES["nuevaImagen"]["type"] == "image/png"){
						$ruta = "vistas/img/productos/" . $_POST["nuevoCodigo"] . "/".$rand . ".png";
						$origen = imagecreatefrompng($_FILES["nuevaImagen"]["tmp_name"]);
						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
						imagepng($destino, $ruta);						
					}
				}				
			   	// Fin Validar
			   	$datos = array("id_categoria" => $_POST["nuevaCategoria"],
							   "codigo" 	  => $_POST["nuevoCodigo"],
							   "descripcion"  => $_POST["nuevaDescripcion"],
							   "stock" 		  => $_POST["nuevoStock"],
							   "precio_venta" => $_POST["nuevoPrecioVenta"],
							   "imagen" 	  => $ruta);
				$respuesta = ModeloProductos::mdlCrearProducto($datos);
				if($respuesta){
					echo'<script>
						swal({
							  type: "success",
							  title: "El producto ha sido guardado correctamente",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							  }).then(function(result){
										if (result.value) {
										window.location = "productos";
										}
									})
						</script>';
				}
			}else{
				echo'<script>
					swal({
						  type: "error",
						  title: "¡El producto no puede ir con los campos vacíos o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {
							window.location = "productos";
							}
						})
			  	</script>';
			}			
		}
	}
	// Editar Producto
	static public function ctrEditarProducto(){
		if(isset($_POST["editarDescripcion"])){
			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarDescripcion"]) &&
			   preg_match('/^[0-9]+$/', $_POST["editarStock"]) &&
			   preg_match('/^[0-9.]+$/', $_POST["editarPrecioVenta"])){
			   	// Validar Imagen
			   	$ruta = $_POST["imagenActual"];
				if(isset($_FILES["editarImagen"]["tmp_name"]) && !empty($_FILES["editarImagen"]["tmp_name"])){
					// Para redimensionar la foto
					list($ancho, $alto) = getimagesize($_FILES["editarImagen"]["tmp_name"]);					
					$nuevoAncho = 500;
					$nuevoAlto = 500;
					// Creamos el directorio donde guardaremos la foto
					$directorio = "vistas/img/productos/". $_POST["editarCodigo"];
					// Primero preguntamos si existe otra imagen en la BD
					// Si la ruta de la foto no viene vacia y la ruta es distinta que la ruta por defecto
					if(!empty($_POST["imagenActual"]) && $_POST["imagenActual"] != "vistas/img/productos/default/anonymous.png"){
						unlink($_POST["imagenActual"]);
					}else{
						mkdir($directorio, 0755);
					}
					$rand = mt_rand(100, 999);	// Nombre del archivo
					// Guardo segun la imagen sea JPG o PNG 
					if($_FILES["editarImagen"]["type"] == "image/jpeg"){						
						$ruta = "vistas/img/productos/" . $_POST["editarCodigo"] . "/".$rand . ".jpg";
						$origen = imagecreatefromjpeg($_FILES["editarImagen"]["tmp_name"]);
						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
						imagejpeg($destino, $ruta);
						}
					if($_FILES["editarImagen"]["type"] == "image/png"){
						$ruta = "vistas/img/productos/" . $_POST["editarCodigo"] . "/".$rand . ".png";
						$origen = imagecreatefrompng($_FILES["editarImagen"]["tmp_name"]);
						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
						imagepng($destino, $ruta);						
					}
				}
			   	// Fin Validar	
			   	//"id_categoria" => $_POST["editarCategoria"],	   
			   	$datos = array("codigo" 	   => $_POST["editarCodigo"],
							   "descripcion"   => $_POST["editarDescripcion"],
							   "stock" 		   => $_POST["editarStock"],
							   "precio_compra" => $_POST["editarPrecioCompra"],
							   "precio_venta"  => $_POST["editarPrecioVenta"],
							   "imagen"  	   => $ruta);
				$respuesta = ModeloProductos::mdlEditarProducto($datos);
				if($respuesta){
					echo'<script>
						swal({
							  type: "success",
							  title: "El producto ha sido modificado correctamente",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							  }).then(function(result){
										if (result.value) {
										window.location = "productos";
										}
									})
						</script>';
				}
			}else{
				echo'<script>
					swal({
						  type: "error",
						  title: "¡El producto no puede ir con los campos vacíos o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {
							window.location = "productos";
							}
						})
			  	</script>';
			}			
		}
	}
	// Eliminar Producto
	static public function ctrBorrarProducto(){
		if(isset($_GET["idProducto"])){			
			$datos = $_GET["idProducto"];
			// Borramos la foto y la carpeta.
			if(!empty($_GET["imagen"]) && $_GET["imagen"] != "vistas/img/productos/default/anonymous.png"){
				unlink($_GET["imagen"]);
				rmdir('vistas/img/productos/'.$_GET["codigo"]);
			}
			$respuesta = ModeloProductos::mdlBorrarProducto($datos);
			if($respuesta){
				echo '<script>
						swal({
							type: "success",
							title: "El Producto ha sido borrado correctamente",
							showConfirmButton : true,
							confirmButtonText: "Cerrar",
							closeOnConfirm: false,						
							}).then((result)=>{
									if(result.value){
										window.location = "productos";
									}
								})
				      </script>';
			}
		}
	}

}

