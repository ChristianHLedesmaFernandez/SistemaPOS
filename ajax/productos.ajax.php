<?php 

require_once "../config/config.php";

require_once "../controladores/productos.controlador.php";
require_once "../modelos/productos.modelo.php";

class AjaxProductos{
	// Para generar codigo a partir de id categoria
	public function ajaxCrearCodigoProducto(){		
		$item = "id_Categoria";
		$valor = $this -> idCategoria;
		$orden = "id";		
		$respuesta = ControladorProductos::ctrMostrarProductos($item, $valor, $orden);		
    	echo json_encode($respuesta);
	}
	// Editar / Buscar por Nombre / Traer Producto
	public $idProducto;
	public $traerProductos;
	public $nombreProducto;	
	public function ajaxEditarProducto(){
		$orden = "id";	
		if($this-> traerProductos == "ok"){
			$item = NULL;
			$valor = NULL;
		}else if ($this-> nombreProducto != ""){
			$item = "descripcion";
			$valor = $this -> nombreProducto;
		} else{
			$item ="id";
			$valor = $this -> idProducto;
		}
		$respuesta = ControladorProductos::ctrMostrarProductos($item, $valor, $orden);
    	echo json_encode($respuesta);
	}
} 
//                         Objetos                              //

//Generar Codigo
if(isset($_POST["idCategoria"])){
	$codigoProducto = new AjaxProductos();
	$codigoProducto -> idCategoria = $_POST["idCategoria"];
	$codigoProducto -> ajaxCrearCodigoProducto();
}
// Objetos Editar Producto
if(isset($_POST["idProducto"])){
	$editarProducto = new AjaxProductos();
	$editarProducto -> idProducto = $_POST["idProducto"];
	$editarProducto	-> ajaxEditarProducto();
}
// Objetos traer Producto
if(isset($_POST["traerProductos"])){
	$traerProductos = new AjaxProductos();
	$traerProductos -> traerProductos = $_POST["traerProductos"];
	$traerProductos	-> ajaxEditarProducto();
}
// Objetos traer Producto por nombre
if(isset($_POST["nombreProducto"])){
	$nombreProducto = new AjaxProductos();
	$nombreProducto -> nombreProducto = $_POST["nombreProducto"];
	$nombreProducto	-> ajaxEditarProducto();
}
