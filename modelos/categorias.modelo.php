<?php 

require_once "conexion.php";

class ModeloCategorias{
	// Mostrar Categorias
	static public function mdlMostrarCategorias($item, $valor){
		if(!empty($item)){
			$stmt =Conexion::conectar()->prepare("SELECT * FROM categorias WHERE $item = :$item");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> execute();
			return $stmt -> fetch();
		}else{
			$stmt = Conexion::conectar()->prepare("SELECT * FROM categorias");
			$stmt -> execute();
			return $stmt -> fetchAll();
		}
		$stmt -> close();
		$stmt = NULL;
	}

	// Crear Categoria
	static public function mdlCrearCategoria($datos){
		$stmt = Conexion::conectar()->prepare("INSERT INTO categorias(categoria) VALUES (:categoria)");
		$stmt -> bindParam(":categoria", $datos, PDO::PARAM_STR);
		if($stmt -> execute()){
			return TRUE;	
		}else{
			return FALSE;
		}
		$stmt -> close();
		$stmt = NULL;
	}

	// Editar Categoria
	static public function mdlEditarCategoria($datos){
		$stmt = Conexion::conectar()->prepare("UPDATE categorias SET categoria = :categoria WHERE id_cat = :id");
		$stmt -> bindParam(":categoria", $datos["categoria"], PDO::PARAM_STR);
		$stmt -> bindParam(":id", $datos["id"], PDO::PARAM_INT);
		if($stmt -> execute()){
			return TRUE;
		}else{
			return FALSE;
		}
		$stmt -> close();
		$stmt = NULL;
	}
	// Borrar Categoria
	static public function mdlBorrarCategoria($datos){
		$stmt = Conexion::conectar()->prepare("DELETE FROM categorias WHERE id_cat = :id");
		$stmt -> bindParam(":id", $datos, PDO::PARAM_INT);
		if($stmt -> execute()){
			return TRUE;		
		}else{
			return FALSE;
		}
		$stmt -> close();
		$stmt = NULL;
	}
}