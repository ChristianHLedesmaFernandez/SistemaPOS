<?php 

require_once "conexion.php";

class ModeloSolicitudes extends ModeloUsuarios{
	// Validar Token
	static public function mdlValidarToken($id, $token){
		$stmt = Conexion::conectar() -> prepare("SELECT estado FROM user_config WHERE id_user = :id_user AND token = :token LIMIT 1");
		$stmt -> bindParam(":id_user", $id, PDO::PARAM_STR);
		$stmt -> bindParam(":token", $token, PDO::PARAM_STR);
		$stmt -> execute();
		return $stmt -> fetch();		
		$stmt -> close();
		$stmt = null;		
	}

}