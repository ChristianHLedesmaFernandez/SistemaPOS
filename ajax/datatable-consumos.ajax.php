<?php

require_once "../config/config.php";

require_once "../controladores/productos.controlador.php";
require_once "../modelos/productos.modelo.php";

class TablaProductosConsumos{
	// Mostrar tabla Dinamica Productos
	public function mostrarTablaProductosConsumos(){		
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
			// Para el Stock            
			if($productos[$i]["stock"] <= 10){
				$stock = "<button class='btn btn-danger'>".$productos[$i]["stock"]."</button>";	
			}else if($productos[$i]["stock"] > 11 && $productos[$i]["stock"] <= 15){
				$stock = "<button class='btn btn-warning'>".$productos[$i]["stock"]."</button>";	
			}else{
				$stock = "<button class='btn btn-success'>".$productos[$i]["stock"]."</button>";	
			}
			// Inserto el boton con su respectivo ID				
			$boton = "<div class='btn-group'><button type='button' class='btn btn-primary agregarProducto recuperarBoton' idProducto='". $productos[$i]["id"] ."'>Agregar</button></div>";

			$datosJson .= '[
							"'.($i+1).'",
							"'.$productos[$i]["codigo"].'",
							"'.$imagen.'",						  	
						  	"'.$productos[$i]["descripcion"].'",
							"'.$stock.'",
							"'.$boton.'"
						   ],';
		}	
		$datosJson = substr($datosJson, 0, -1);		
		$datosJson .= ']
				   }';
		echo $datosJson;		
	}
}
// Activar tabla de Productos (Objetos)
$activarProductoConsumos = new TablaProductosConsumos();
$activarProductoConsumos -> mostrarTablaProductosConsumos();