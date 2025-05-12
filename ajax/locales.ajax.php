<?php

require_once "../config/config.php"; 

require_once "../controladores/locales.controlador.php";
require_once "../modelos/locales.modelo.php";

class AjaxLocales{
	// Evitar Local repetido
	public $validarLocal;
	public function ajaxValidarLocal(){
		$item = "nombre";
		$valor = $this -> validarLocal;
		$respuesta = ControladorLocales::ctrMostrarLocales($item, $valor);		             
		echo json_encode($respuesta);
	}
	// Borra Local
	public $idLocal;
	public function ajaxBorrarLocal(){
		// Solicito al modelo que elimine un Local		
		$datos = $this -> idLocal;
		$respuesta = ModeloLocales::mdlBorrarLocal($datos);			
	}
}
//          Objetos
// Objeto Evitar Local repetido
if (isset($_POST["validarLocal"])) {	
	$valLocal = new AjaxLocales();
	$valLocal -> validarLocal = $_POST["validarLocal"];
	$valLocal -> ajaxValidarLocal();
}
// Objeto Borrar Usuario
if(isset($_POST["idLocal"])){
	$borrar = new AjaxLocales();
	$borrar -> idLocal = $_POST["idLocal"];
	$borrar -> ajaxBorrarLocal();
}