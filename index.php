<?php 
// Declaracion de Constantes
require_once "config/config.php";
// funciones Auxiliares
require_once "funcs/funcs.php";
// Controladores
require_once "controladores/plantilla.controlador.php";
require_once "controladores/usuarios.controlador.php";
require_once "controladores/solicitudes.controlador.php";
require_once "controladores/categorias.controlador.php";
require_once "controladores/productos.controlador.php";
require_once "controladores/clientes.controlador.php";
require_once "controladores/locales.controlador.php";
require_once "controladores/consumos.controlador.php";
require_once "controladores/cuentas.controlador.php";
// Modelos
require_once "modelos/usuarios.modelo.php";
require_once "modelos/solicitudes.modelo.php";
require_once "modelos/categorias.modelo.php";
require_once "modelos/productos.modelo.php";
require_once "modelos/clientes.modelo.php";
require_once "modelos/locales.modelo.php";
require_once "modelos/consumos.modelo.php";
require_once "modelos/cuentas.modelo.php";

$plantilla = new ControladorPlantilla();
$plantilla -> ctrPlantilla();
