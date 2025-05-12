<?php 

require_once "conexion.php";


class ModeloCuentas{
	// Mostrar Cuentas
	static public function mdlMostrarCuentas($item, $valor){
		if(!empty($item)){
			$stmt =Conexion::conectar()->prepare("SELECT * FROM cuentas WHERE $item = :$item");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> execute();
			return $stmt -> fetch();
		}else{
			$stmt = Conexion::conectar()->prepare("SELECT * FROM cuentas");
			$stmt -> execute();
			return $stmt -> fetchAll();
		}
		$stmt -> close();
		$stmt = NULL;
	}
	// Actualizar un Campo de una Cuenta
	static public function mdlActualizarCuenta($item, $valor1, $valor){
		$stmt = Conexion::conectar()->prepare("UPDATE cuentas SET $item = :$item WHERE id_user = :id_user");
		$stmt -> bindParam(":".$item, $valor1, PDO::PARAM_STR);
		$stmt -> bindParam(":id_user", $valor, PDO::PARAM_STR);
		if($stmt -> execute()){
			return TRUE;
		}else{			
			return FALSE;
		}
		$stmt -> close();		
		$stmt = null;
	}

}