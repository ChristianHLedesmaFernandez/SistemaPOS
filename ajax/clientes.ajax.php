<?php

require_once "../config/config.php"; 

require_once "../controladores/usuarios.controlador.php";
require_once "../controladores/clientes.controlador.php";
require_once "../modelos/usuarios.modelo.php";
require_once "../modelos/clientes.modelo.php";

class AjaxClientes{

	// Editar Clientes
	public $idCliente;
	public function ajaxEditarCliente(){
		$item = "id";
		$valor = $this -> idCliente;
		$respuesta = controladorClientes::ctrMostrarUsuarios($item, $valor);
		echo json_encode($respuesta);
		//echo json_encode($respuesta[0]);
	}

}

//             Objetos

// Objeto Editar Cliente
if(isset($_POST["idCliente"])){
	$cliente = new AjaxClientes();
	$cliente -> idCliente = $_POST["idCliente"];
	$cliente -> ajaxEditarCliente();
}