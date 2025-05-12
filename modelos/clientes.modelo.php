<?php 

require_once "conexion.php";

class ModeloClientes extends ModeloUsuarios{
	// Mostrar Cliente junto con los datos de la tabla user_config
	static public function mdlMostrarClientes($item, $valor){
		if (!empty($item)){
			$stmt = Conexion::conectar() -> prepare("SELECT usuarios.*, user_config.*, locales.nombre AS local, cuentas.descuento AS descuento, cuentas.saldo_actual AS saldo, cuentas.ultima_compra FROM user_config INNER JOIN usuarios ON user_config.id_user = usuarios.id INNER JOIN locales ON usuarios.id_local = locales.id_local INNER JOIN cuentas ON usuarios.id = cuentas.id_user WHERE $item = :$item AND user_config.perfil = 'Cliente'");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> execute();
			//return $stmt -> fetchAll();
			return $stmt -> fetch();		
		}else{
			$stmt = Conexion::conectar() -> prepare("SELECT usuarios.*, user_config.*, locales.nombre AS local, cuentas.descuento AS descuento, cuentas.saldo_actual AS saldo, cuentas.ultima_compra FROM user_config INNER JOIN usuarios ON user_config.id_user = usuarios.id INNER JOIN locales ON usuarios.id_local = locales.id_local INNER JOIN cuentas ON usuarios.id = cuentas.id_user WHERE user_config.perfil = 'Cliente'");
					
			$stmt -> execute();
			return $stmt -> fetchAll();
		}
		$stmt -> close();
		$stmt = null;
	}
	// Registrar un Cliente
	static public function mdlCrearCliente($datos){
		$stmt = Conexion::conectar()->prepare("INSERT INTO usuarios (nombre, usuario, correo, telefono, id_local, password) VALUES (:nombre, :usuario, :correo, :telefono, :id_local, :password)");		
		$stmt -> bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt -> bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);
		$stmt -> bindParam(":correo", $datos["correo"], PDO::PARAM_STR);
		$stmt -> bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_local", $datos["local"], PDO::PARAM_STR);
		$stmt -> bindParam(":password", $datos["password"], PDO::PARAM_STR);
		if($stmt -> execute()){			
			// Obtener Id
			$stmt0 = Conexion::conectar()->prepare("SELECT MAX(id) AS ultimoId FROM usuarios");
			$stmt0 -> execute();
			$resultado = $stmt0 -> fetch();
			// Fin Obtener Id
			$id = $resultado["ultimoId"];
			// Inserto en la Tabla user_config si hay un error borro lo insertado en usuario
			$stmt1 = Conexion::conectar()->prepare("INSERT INTO user_config (id_user, estado, token, perfil) VALUES(:id_user, :estado, :token, :perfil)");
			$stmt1 -> bindParam(":id_user", $id, PDO::PARAM_INT);
			$stmt1 -> bindParam(":estado", $datos["estado"], PDO::PARAM_INT);
			$stmt1 -> bindParam(":token", $datos["token"], PDO::PARAM_STR);
			$stmt1 -> bindParam(":perfil", $datos["perfil"], PDO::PARAM_STR);
			if($stmt1 -> execute()){				
				return true;
			}else{
				// Borro lo insertado en usuario.
				$stmt2 = Conexion::conectar()->prepare("DELETE FROM usuarios WHERE id = :id");
				$stmt2->bind_param(':id', $id, PDO::PARAM_INT);
				$stmt2->execute();	
				return false;
			}	
		}else{
			return false;
		}
		$stmt->close();
		$stmt0->close();
		$stmt1->close();
		$stmt2->close();		
		$stmt = NULL;
		$stmt0 = NULL;
		$stmt1 = NULL;
		$stmt2 = NULL;
	}
	// Editar un Cliente
	static public function mdlEditarCliente($datos){
		$stmt1 = Conexion::conectar()->prepare("UPDATE user_config SET token = :token WHERE id_user = (SELECT id FROM usuarios WHERE usuario = :usuario)");
		$stmt1 -> bindParam(":token", $datos["token"], PDO::PARAM_STR);
		$stmt1 -> bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);
		if($stmt1 -> execute()){
			// Modifico la Tabla usuarios
			$stmt = Conexion::conectar()->prepare("UPDATE usuarios SET nombre = :nombre, correo = :correo, telefono = :telefono, id_local = :id_local, password = :password  WHERE usuario = :usuario");
			$stmt -> bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
			$stmt -> bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);
			$stmt -> bindParam(":correo", $datos["correo"], PDO::PARAM_STR);
			$stmt -> bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
			$stmt -> bindParam(":id_local", $datos["local"], PDO::PARAM_STR);
			$stmt -> bindParam(":password", $datos["password"], PDO::PARAM_STR);
			if($stmt -> execute()){
				return true;
			}else{
				return false;
			}	
		}else{				
			// No Modifico retorno error	
			return false;
			}
		$stmt->close();
		$stmt1->close();	
		$stmt = NULL;
		$stmt1 = NULL;

	}
	
}