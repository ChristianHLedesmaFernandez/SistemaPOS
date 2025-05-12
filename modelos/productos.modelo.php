<?php
require_once "conexion.php";
class ModeloProductos{
	// Mostrar Productos
	static public function mdlMostrarProductos($item, $valor, $orden){
		if(!empty($item)){
			//$stmt =Conexion::conectar()->prepare("SELECT * FROM productos WHERE $item = :$item ORDER BY id DESC");
			$stmt = Conexion::conectar() -> prepare("SELECT productos.*, categorias.categoria FROM productos INNER JOIN categorias ON productos.id_categoria = categorias.id_cat WHERE $item = :$item ORDER BY $orden DESC");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> execute();
			return $stmt -> fetch();
		}else{
			//$stmt = Conexion::conectar()->prepare("SELECT * FROM productos ORDER BY $orden DESC");
			$stmt = Conexion::conectar()->prepare("SELECT productos.*, categorias.categoria FROM productos INNER JOIN categorias ON productos.id_categoria = categorias.id_cat ORDER BY $orden DESC");
			$stmt -> execute();
			return $stmt -> fetchAll();
		}
		$stmt -> close();
		$stmt = NULL;
	}
	// Ingresar Producto
	static public function mdlCrearProducto($datos){
		$stmt = Conexion::conectar()->prepare("INSERT INTO productos(id_categoria, codigo, descripcion, imagen, stock, precio_venta) VALUES (:id_categoria, :codigo, :descripcion, :imagen, :stock, :precio_venta)");
		$stmt->bindParam(":id_categoria", $datos["id_categoria"], PDO::PARAM_INT);
		$stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_STR);
		$stmt->bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
		$stmt->bindParam(":imagen", $datos["imagen"], PDO::PARAM_STR);
		$stmt->bindParam(":stock", $datos["stock"], PDO::PARAM_STR);
		$stmt->bindParam(":precio_venta", $datos["precio_venta"], PDO::PARAM_STR);
		if($stmt->execute()){
			return TRUE;
		}else{
			return FALSE;		
		}
		$stmt->close();
		$stmt = NULL;
	}
	// Editar Producto
	static public function mdlEditarProducto($datos){
		$stmt = Conexion::conectar()->prepare("UPDATE productos SET descripcion = :descripcion, imagen = :imagen, stock = :stock, precio_venta = :precio_venta WHERE codigo = :codigo");
		//$stmt->bindParam(":id_categoria", $datos["id_categoria"], PDO::PARAM_INT);
		$stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_STR);
		$stmt->bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
		$stmt->bindParam(":imagen", $datos["imagen"], PDO::PARAM_STR);
		$stmt->bindParam(":stock", $datos["stock"], PDO::PARAM_STR);
		$stmt->bindParam(":precio_venta", $datos["precio_venta"], PDO::PARAM_STR);
		if($stmt->execute()){
			return TRUE;
		}else{
			return FALSE;		
		}
		$stmt->close();
		$stmt = NULL;
	}
	// Actualizar un Campo de un Producto
	static public function mdlActualizarProducto($item, $valor1, $valor){
		$stmt = Conexion::conectar()->prepare("UPDATE productos SET $item = :$item WHERE id = :id");
		$stmt -> bindParam(":".$item, $valor1, PDO::PARAM_STR);
		$stmt -> bindParam(":id", $valor, PDO::PARAM_STR);
		if($stmt -> execute()){
			return TRUE;
		}else{			
			return FALSE;
		}
		$stmt -> close();		
		$stmt = null;
	}
	// Eliminar un Producto
	static public function mdlBorrarProducto($datos){
		$stmt = Conexion::conectar()->prepare("DELETE FROM productos WHERE id = :id");
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