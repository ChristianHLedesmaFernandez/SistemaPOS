<?php 

//require_once "config/config.php"; 

class Conexion{

	public function conectar(){

		try {
		    $link = new PDO("mysql:host=localhost;dbname=".DB, 
						USER, 
						PASSWORD);
		    // Fin Base de Datos
		$link ->exec("set names utf8");

		return $link;

		} catch (PDOException $e) {
		    //print "¡Error!: " . $e->getMessage() . "<br/>";
		    print "<h1>¡Error!: Algo anda mal. Intente conectarse mas tarde</h1> <br/>";
		    die();
		}
		/*	 
		$link = new PDO("mysql:host=localhost;dbname=willycafe", 
						"christian", 
						"ledesma");
		*/
		// Datos de mi Base de Datos
/*
		$link = new PDO("mysql:host=localhost;dbname=".DB, 
						USER, 
						PASSWORD);

		// Fin Base de Datos
		$link ->exec("set names utf8");

		return $link;
*/
	}

}