<?php

require_once "../config/config.php"; 

require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";

class AjaxUsuarios{
	//
	// Editar usuario
	public $idUsuario;
	public function ajaxEditarUsuario(){
		// Solicito al modelo que muestre el usuario
		$item = "id";
		$valor = $this -> idUsuario;
		$respuesta = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);
		echo json_encode($respuesta[0]);
	}
	// Activar/Desactivar Usuario
	public $activarId;
	public $activarUsuario;
	public function ajaxActivarUsuario(){
		$tabla = "user_config";
		$item1 = "estado";
		$valor1 = $this -> activarUsuario;
		$item2 = "id_user";
		$valor2 = $this -> activarId;
		$respuesta = ModeloUsuarios::mdlActualizarUsuario($tabla, $item1, $valor1, $item2, $valor2);
	}
	// Evitar Usuario repetido
	public $validarUsuario;
	public function ajaxValidarUsuario(){
		$item = "usuario";
		$valor = $this -> validarUsuario;
		$respuesta = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);
		echo json_encode($respuesta);
	}
	// Evitar Email repetido
	public $validarEmail;
	public function ajaxValidarEmail(){
		$item = "correo";
		$valor = $this -> validarEmail;
		$respuesta = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);
		echo json_encode($respuesta);
	}
}

//          Objetos

// Objeto Editar Usuario
if(isset($_POST["idUsuario"])){
	$editar = new AjaxUsuarios();
	$editar -> idUsuario = $_POST["idUsuario"];
	$editar -> ajaxEditarUsuario();
}
// Objeto Activar/Desactivar Usuario
if(isset($_POST["activarUsuario"])){
	$activarUsuario = new AjaxUsuarios();
	$activarUsuario -> activarUsuario = $_POST["activarUsuario"];
	$activarUsuario -> activarId = $_POST["activarId"];
	$activarUsuario -> ajaxActivarUsuario();
}
// Objeto Evitar Usuario repetido
if (isset($_POST["validarUsuario"])) {	
	$valUsuario = new AjaxUsuarios();
	$valUsuario -> validarUsuario = $_POST["validarUsuario"];
	$valUsuario -> ajaxValidarUsuario();
}
// Objeto Evitar Email repetido
if (isset($_POST["validarEmail"])) {	
	$valEmail = new AjaxUsuarios();
	$valEmail -> validarEmail = $_POST["validarEmail"];
	$valEmail -> ajaxValidarEmail();
}