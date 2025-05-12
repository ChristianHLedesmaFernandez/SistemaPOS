<?php 

//--------------------------------------------------------------//
//                      Salida por Consola                      //
//	echo("<script>console.log('PHP: ".$valor."');</script>");
//--------------------------------------------------------------//

require_once "conexion.php";

class ModeloUsuarios{
	// Mostrar Usuarios junto con los datos de la tabla user_config
	static public function mdlMostrarUsuarios($item, $valor){
		if (!empty($item)){
			$stmt = Conexion::conectar() -> prepare("SELECT * FROM usuarios INNER JOIN user_config ON usuarios.id = user_config.id_user WHERE $item = :$item");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> execute();
			return $stmt -> fetchAll();
			//return $stmt -> fetch();		
		}else{
			//$stmt = Conexion::conectar() -> prepare("SELECT * FROM $tabla");	
			$stmt = Conexion::conectar() -> prepare("SELECT * FROM usuarios INNER JOIN user_config ON usuarios.id = user_config.id_user");
					
			$stmt -> execute();
			return $stmt -> fetchAll();
		}
		$stmt -> close();
		$stmt = null;
	}	
	// Registrar un Usuario
	static public function mdlRegistrarUsuario($datos){
		$stmt = Conexion::conectar()->prepare("INSERT INTO usuarios (nombre, usuario, correo, password, foto) VALUES (:nombre, :usuario, :correo, :password, :foto)");
		$stmt -> bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt -> bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);
		$stmt -> bindParam(":correo", $datos["correo"], PDO::PARAM_STR);
		$stmt -> bindParam(":password", $datos["password"], PDO::PARAM_STR);
		$stmt -> bindParam(":foto", $datos["foto"], PDO::PARAM_STR);
		if($stmt -> execute()){
			// Obtener Id
			//$stmt0 = Conexion::conectar()->prepare("SELECT MAX(id) AS ultimoId FROM usuarios");
			$stmt0 = Conexion::conectar()->prepare("SELECT id AS ultimoId FROM usuarios WHERE usuario = :usuario");
			$stmt0 -> bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);
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
	// Editar un Usuario
	static public function mdlEditarUsuario($datos){
		$stmt1 = Conexion::conectar()->prepare("UPDATE user_config SET perfil = :perfil WHERE id_user = (SELECT id FROM usuarios WHERE usuario = :usuario)");
		$stmt1 -> bindParam(":perfil", $datos["perfil"], PDO::PARAM_STR);
		$stmt1 -> bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);
		if($stmt1 -> execute()){
			// Modifico la Tabla usuarios
			$stmt = Conexion::conectar()->prepare("UPDATE usuarios SET nombre = :nombre, password = :password, foto = :foto WHERE usuario = :usuario");
			$stmt -> bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
			$stmt -> bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);
			$stmt -> bindParam(":password", $datos["password"], PDO::PARAM_STR);
			$stmt -> bindParam(":foto", $datos["foto"], PDO::PARAM_STR);
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
	// Eliminar un Usuario
	static public function mdlBorrarUsuario($datos){
		$stmt = Conexion::conectar()->prepare("DELETE FROM usuarios WHERE id = :id");
		$stmt -> bindParam(":id", $datos, PDO::PARAM_INT);
		if($stmt -> execute()){	
			return true;
		}else{
			return false;		
		}
		$stmt -> close();
		$stmt = null;
	}
	//------------------------------------------------------------------------------------------------------------------------//
	//                                                Metodos antes de Logearse --------------------------------------------------------------------------------------------------------------------------//
	// Buscar el usuario en la base de datos para el Login (Busca por el usuario o por el correo electronico)
	static public function mdlLogin($usuario){
		$stmt = Conexion::conectar() -> prepare("SELECT * FROM usuarios INNER JOIN user_config ON usuarios.id = user_config.id_user WHERE usuarios.usuario = ? || usuarios.correo = ? LIMIT 1");	
		$stmt -> bindParam(1, $usuario, PDO::PARAM_STR);
		$stmt -> bindParam(2, $usuario, PDO::PARAM_STR);
		$stmt -> execute();
		return $stmt -> fetch();
		$stmt -> close();
		$stmt = null;
	}
	// Actualizar Ultimo ingreso del Usuario (Modifica la tabla usuarios y user_config)
	static public function mdlUltimoLogin($id){;
		$stmt = Conexion::conectar()->prepare("UPDATE usuarios INNER JOIN user_config ON usuarios.id = user_config.id_user SET usuarios.last_session = NOW(), user_config.token_password = '', user_config.password_request = 0 WHERE usuarios.id = ?");
		$stmt -> bindParam(1, $id, PDO::PARAM_STR);
		if($stmt -> execute()){
			return true;	
		}else{
			return false;		
		}
		$stmt -> close();		
		$stmt = null;
	}	
	// Actualizar un Campo de un Usuario
	static public function mdlActualizarUsuario($tabla, $item1, $valor1, $item2, $valor2){
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE $item2 = :$item2");
		$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_STR);
		$stmt -> bindParam(":".$item2, $valor2, PDO::PARAM_STR);
		if($stmt -> execute()){
			return true;
		}else{
			
			return false;
		}
		$stmt -> close();		
		$stmt = null;
	}
	// Validar Token Password
	static public function mdlValidarTokenPass($id, $token){
		$stmt = Conexion::conectar() -> prepare("SELECT estado, password_request FROM user_config WHERE id_user = ? AND token_password = ? LIMIT 1");
		$stmt -> bindParam(1, $id, PDO::PARAM_STR);
		$stmt -> bindParam(2, $token, PDO::PARAM_STR);
		$stmt -> execute();
		return $stmt -> fetch();
		$stmt -> close();
		$stmt = null;		
	}
	// Cambiar contraseña
	static public function mdlCambiarPassword($password, $id, $token){ 
		$stmt0 = Conexion::conectar() -> prepare("UPDATE user_config SET token_password='', password_request= 0 WHERE id_user = ? AND token_password = ?");	
		$stmt0 -> bindParam(1, $id, PDO::PARAM_STR);
		$stmt0 -> bindParam(2, $token, PDO::PARAM_STR);
		//$stmt0 -> execute();
		if($stmt0 -> execute()){
			$stmt = Conexion::conectar() -> prepare("UPDATE usuarios SET password = ? WHERE id = ?");
			$stmt -> bindParam(1, $password, PDO::PARAM_STR);
			$stmt -> bindParam(2, $id, PDO::PARAM_STR);
			if($stmt->execute()){
				return true;
			}else{
				return false;
			}			
		}else{
			return false;
		}
		// cerramos la conexion	
		$stmt->close();
		$stmt0->close();
		// vaciamos la conexion		
		$stmt = NULL;
		$stmt0 = NULL;
	}
}