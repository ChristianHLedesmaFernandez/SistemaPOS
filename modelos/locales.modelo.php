<?php 

require_once "conexion.php";

class ModeloLocales{
	// Mostrar Locales
	static public function mdlMostrarLocales($item, $valor){
		if(!empty($item)){
			$stmt =Conexion::conectar()->prepare("SELECT * FROM locales WHERE $item = :$item AND id_local != 0 AND telefono != -1");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> execute();
			return $stmt -> fetch();
		}else{
			$stmt = Conexion::conectar()->prepare("SELECT * FROM locales WHERE id_local != 0 AND telefono != -1");
			$stmt -> execute();
			return $stmt -> fetchAll();
		}
		$stmt -> close();
		$stmt = NULL;
	}

	static public function mdlMostrarLocalesSugerido($item, $valor){		
		$stmt =Conexion::conectar()->prepare("SELECT * FROM locales WHERE $item = :$item AND id_local != 0");
		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
		$stmt -> execute();
		return $stmt -> fetch();		
		$stmt -> close();
		$stmt = NULL;
	}

	// Crear Local
	static public function mdlCrearLocal($datos){		
		$stmt = Conexion::conectar()->prepare("INSERT INTO locales(nombre, telefono, direccion) VALUES (:nombre, :telefono, :direccion)");		
		$stmt -> bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt -> bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
		$stmt -> bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);
		if($stmt -> execute()){
			return true;
		}else{
			return false;
		}
		$stmt -> close();
		$stmt = NULL;
	}
	// Sugerir Local (Devuelve el id del local sugerido o 0 si no lo agrego)
	static public function mdlSugerirLocal($datos){
		$stmt = Conexion::conectar()->prepare("INSERT INTO locales(nombre, telefono) VALUES (:nombre, :telefono)");		
		$stmt -> bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt -> bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
		if($stmt -> execute()){
			// Obtener Id
			$stmt0 = Conexion::conectar()->prepare("SELECT id_local AS ultimoId FROM locales WHERE nombre = :nombre");
			$stmt0 -> bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
			$stmt0 -> execute();
			$resultado = $stmt0 -> fetch();			
			// Fin Obtener Id
			$id = $resultado["ultimoId"];			
			return $id;				
		}else{
			return 0;
		}
		$stmt-> close();
		$stmt0-> close();
		$stmt = NULL;
		$stmt0 = NULL;
	}
	// Borrar Local
	static public function mdlBorrarLocalSugerido($dato){
		//$stmt = Conexion::conectar()->prepare("DELETE FROM locales WHERE id_local = :id AND telefono = -1");
		$stmt = Conexion::conectar()->prepare("DELETE FROM locales WHERE id_local = :id AND telefono = -1 AND (SELECT COUNT(*) total FROM usuarios WHERE id_local = :id) = 1");
		$stmt -> bindParam(":id", $dato, PDO::PARAM_INT);
		if($stmt -> execute()){
			return true;		
		}else{
			return false;
		}
		$stmt -> close();
		$stmt = NULL;
	}
	// Editar Local
	static public function mdlEditarLocal($datos){
		$stmt = Conexion::conectar()->prepare("UPDATE locales SET telefono = :telefono, direccion = :direccion WHERE nombre = :nombre");
		$stmt -> bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt -> bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
		$stmt -> bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);		
		if($stmt->execute()){
			return true;
		}else{
			return false;		
		}
		$stmt->close();
		$stmt = NULL;
	}
	// Borrar Local
	static public function mdlBorrarLocal($dato){
		$stmt = Conexion::conectar()->prepare("DELETE FROM locales WHERE id_local = :id");
		$stmt -> bindParam(":id", $dato, PDO::PARAM_INT);
		if($stmt -> execute()){
			return true;		
		}else{
			return false;
		}
		$stmt -> close();
		$stmt = NULL;
	}
	
}