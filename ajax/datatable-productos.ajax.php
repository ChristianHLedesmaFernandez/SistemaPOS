<?php

require_once "../config/config.php";

require_once "../controladores/productos.controlador.php";
require_once "../modelos/productos.modelo.php";

class TablaProductos{
	// Mostrar tabla Dinamica Productos
	public function mostrarTablaProductos(){		
		$item = NULL;
		$valor = NULL;
		$orden = "id";
		$productos = ControladorProductos::ctrMostrarProductos($item, $valor, $orden);		
		$datosJson = '{
		  				"data": [';		  				
		for($i=0; $i < count($productos); $i++){
			// Inserto la imagen
			if(!empty($productos[$i]["imagen"])){
            	$imagen = "<img src='".$productos[$i]["imagen"]."' width='50px'>";     
            }else{
                $imagen = "<img src='vistas/img/productos/default/anonymous.png' width='50px'>";
            }
			// Inserto los botones con su respectivo ID			
			if (isset($_GET["perfilOculto"]) && $_GET["perfilOculto"] == "Especial"){				
				$botones = "<div class='btn-group'><button class='btn btn-warning btnEditarProducto btnModal' idProducto='".$productos[$i]["id"]."' data-toggle='modal' data-target='#modalEditarProducto'><i class='fa fa-pencil'></i></button></div>";
			}else {
				$botones = "<div class='btn-group'><button class='btn btn-warning btnEditarProducto btnModal' idProducto='".$productos[$i]["id"]."' data-toggle='modal' data-target='#modalEditarProducto'><i class='fa fa-pencil'></i></button><button class='btn btn-danger btnEliminarProducto' idProducto='".$productos[$i]["id"]."' codigo='".$productos[$i]["codigo"]."' imagen='".$productos[$i]["imagen"]."'><i class='fa fa-times'></i></button></div>";
			}			
			// Para el Stock            
			if($productos[$i]["stock"] <= 10){
				$stock = "<button class='btn btn-danger'>".$productos[$i]["stock"]."</button>";	
			}else if($productos[$i]["stock"] > 11 && $productos[$i]["stock"] <= 15){
				$stock = "<button class='btn btn-warning'>".$productos[$i]["stock"]."</button>";	
			}else{
				$stock = "<button class='btn btn-success'>".$productos[$i]["stock"]."</button>";	
			}
			$datosJson .= '[
							"'.($i+1).'",
							"'.$productos[$i]["codigo"].'",
							"'.$imagen.'",
							"'.$productos[$i]["categoria"].'",						  	
						  	"'.$productos[$i]["descripcion"].'",														
							"'.$stock.'",
							"'.$productos[$i]["precio_venta"].'",
							"'.$botones.'"
						   ],';
		}	
		$datosJson = substr($datosJson, 0, -1);		
		$datosJson .= ']
				   }';
		echo $datosJson;		
	}
}
// Activar tabla de Productos (Objetos)
$activarProducto = new TablaProductos();
$activarProducto -> mostrarTablaProductos();