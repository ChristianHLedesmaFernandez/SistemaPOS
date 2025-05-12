<?php 
class ControladorCuentas{
	// Mostrar Categorias
	static public function ctrMostrarCuentas($item, $valor){		
		$respuesta = ModeloCuentas::mdlMostrarCuentas($item, $valor);
		return $respuesta;	
	}
}