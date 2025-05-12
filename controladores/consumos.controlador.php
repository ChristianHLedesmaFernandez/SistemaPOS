<?php 

class ControladorConsumos{
	// Mostrar Consumos
	static public function ctrMostrarConsumos($item, $valor){
		$respuesta = ModeloConsumos:: mdlMostrarConsumos($item, $valor);
		return $respuesta;
	}
	// Crear un Consumo
	static public function ctrCrearConsumo(){
		if(isset($_POST["nuevaVenta"])){
			// Recibo las variables
			$codigo = $_POST["nuevaVenta"];
			$cliente = $_POST["seleccionarCliente"];
			$vendedor = $_POST["idVendedor"];
			$productos = $_POST["listaProductos"];
			$descuento = $_POST["nuevoPrecioDescuento"];
			$neto = $_POST["nuevoPrecioNeto"];
			$total = $_POST["totalVenta"];
			$metodoPago = $_POST["nuevoMetodoPago"];
			// Fin Recibir
			if(!empty($productos)){ // Verifico si la lista esta vacia
				// Actualizar las compras del cliente, reducir Stock y aumentar las ventas de los productos
				$listaProductos = json_decode($productos, true);
				$totalProductosComprados =  array(); // Para calcular la cantidad de productos comprados por el cliente.
				foreach ($listaProductos as $key => $value){
					array_push($totalProductosComprados, $value["cantidad"]);				
					$itemProducto = "id";
					$valorProducto = $value["id"];
					$orden = "id";
					$traerProducto = ModeloProductos::mdlMostrarProductos($itemProducto, $valorProducto, $orden);				
					// Actualizar Ventas
					$itemVentas = "ventas";
					$valorVentas = $value["cantidad"] + $traerProducto["ventas"];
					$nuevaVenta = ModeloProductos::mdlActualizarProducto($itemVentas, $valorVentas, $valorProducto);
					// Actualizar Stock
					$itemStock = "stock";
					$valorStock = $value["stock"];
					$nuevaVenta = ModeloProductos::mdlActualizarProducto($itemStock, $valorStock, $valorProducto);
				}			
				$itemCliente = "id_user";
				$valorCliente = $cliente;
				$traerCuentaCliente = ModeloCuentas::mdlMostrarCuentas($itemCliente, $valorCliente);
				// Actualizar cantidad de compras del cliente
				$itemCompras = "compras";
				$valorCompras = $traerCuentaCliente["compras"] + array_sum($totalProductosComprados);
				$comprasCliente = ModeloCuentas::mdlActualizarCuenta($itemCompras, $valorCompras, $valorCliente);
				// Fin Actualizar Compras, reducir Stock y aumentar las ventas			
				// Actualizar saldo de la cuenta del Cliente			
				if($metodoPago == "CuentaCorriente"){
					$itemSaldoActual = "saldo_actual";
					$valorSaldoActual = $traerCuentaCliente["saldo_actual"] + $total;
					$comprasCliente = ModeloCuentas::mdlActualizarCuenta($itemSaldoActual, $valorSaldoActual, $valorCliente);
				}
				// Fin Actualizar Saldo 
				// Actualizar fecha de ultima compra del Cliente			
				date_default_timezone_set('America/Argentina/Buenos_Aires');
				$fecha = date("Y-m-d");
				$hora = date("H:i:s");
				$itemUltimaCompra = "ultima_compra";
				$valorUltimaCompra = $fecha .' '. $hora;
				$comprasCliente = ModeloCuentas::mdlActualizarCuenta($itemUltimaCompra, $valorUltimaCompra, $valorCliente);
				// Fin Actualizar Fecha ultima compra
				// Guardar el Consumo
				$datos = array("id_ven" 		=> $vendedor,
							   "id_cli" 		=> $cliente,
							   "codigo" 		=> $codigo,
							   "productos" 		=> $productos,
							   "total_descuento"=> $descuento,
							   "neto" 			=> $neto,
							   "total" 			=> $total,
							   "metodo_pago" 	=> $metodoPago);
				$respuesta = ModeloConsumos::mdlIngresarConsumo($datos);
				if($respuesta){
					echo'<script>
							swal({
							  type: "success",
							  title: "El consumo ha sido guardado correctamente",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							  }).then(function(result){
									if (result.value) {
										window.location = "adminconsumos";
									}
								})
						</script>';
				}
			}		
		}		
	}
	// Editar un Consumo
	static public function ctrEditarConsumo(){
		if(isset($_POST["editarVenta"])){
			// Recibo las variables
			$codigo = $_POST["editarVenta"];
			$cliente = $_POST["seleccionarCliente"];
			$vendedor = $_POST["idVendedor"];
			$productos = $_POST["listaProductos"];
			$descuento = $_POST["nuevoPrecioDescuento"];
			$neto = $_POST["nuevoPrecioNeto"];
			$total = $_POST["totalVenta"];
			$metodoPago = $_POST["nuevoMetodoPago"];
			// Fin Recibir
			// Banderas
			$cambioProducto = true;
			$cambioCliente = true;
			$cambioMetodoPago = true;
			// Fin Banderas
			$itemConsumo = "codigo";
			$valorConsumo = $codigo;
			$traerConsumo = ModeloConsumos::mdlMostrarConsumos($itemConsumo, $valorConsumo);
			$clienteAnt = $traerConsumo["id_cli"];
			$metodoPagoAnt = $traerConsumo["metodo_pago"];
			$totalAnt = $traerConsumo["total"];
			// Verificar Cambios
			if(empty($productos)){
				$productos = $traerConsumo["productos"];
				$cambioProducto = false;
			}
			if($cliente == $clienteAnt){
				$cambioCliente =  false;
			}
			if($metodoPago == $metodoPagoAnt){
				$cambioMetodoPago = false;
			}
			// Fin Verificar Cambios
			if($cambioProducto){
				// Formatear las tablas de cuenta de cliente y productos  para volver los valores originales
				$listaProductos = json_decode($productos, true);
				$totalProductosCompradosAnt = array();
				// Formatear la tabla de productos
				foreach ($listaProductos as $key => $value) {
					array_push($totalProductosCompradosAnt, $value["cantidad"]);
					$itemProductoAnt = "id";
					$valorProductoAnt = $value["id"];
					$orden = "id";
					$traerProductoAnt = ModeloProductos::mdlMostrarProductos($itemProductoAnt, $valorProductoAnt, $orden);
					// Actualizar Venta
					$itemVentasAnt = "ventas";											
					$valorVentasAnt = $traerProductoAnt["ventas"] - $value["cantidad"];					
					$VentasAnt = ModeloProductos::mdlActualizarProducto($itemVentasAnt, $valorVentasAnt, $valorProductoAnt);
					//Actualizar Stock
					$itemStockAnt = "stock";
					$valorStockAnt = $traerProductoAnt["stock"] + $value["cantidad"];
					$VentasAnt = ModeloProductos::mdlActualizarProducto($itemStockAnt, $valorStockAnt, $valorProductoAnt);
				}
				// Formatear tabla Cuenta de cliente
				$itemClienteAnt = "id_user";
				$valorClienteAnt = $clienteAnt;
				$traerCuentaClienteAnt = ModeloCuentas::mdlMostrarCuentas($itemClienteAnt, $valorClienteAnt);
				// Formatear cantidad de compras del cliente
				$itemCuentaAnt = "compras";
				$valorCuentaAnt = $traerCuentaClienteAnt["compras"] - array_sum($totalProductosCompradosAnt);
				$compraClienteAnt = ModeloCuentas::mdlActualizarCuenta($itemCuentaAnt, $valorCuentaAnt, $valorClienteAnt);
				// Formatear Saldo de la cuenta del Cliente
				if($metodoPagoAnt == "CuentaCorriente"){
					$itemSaldoAnt = "saldo_actual";
					$valorSaldoAnt = $traerCuentaClienteAnt["saldo_actual"] - $totalAnt;
					$compraClienteAnt = ModeloCuentas::mdlActualizarCuenta($itemSaldoAnt, $valorSaldoAnt, $valorClienteAnt);
				} 
				// Fin Formatear 
				// Actualizar nuevamente las compras del cliente y reducir el stock y aumentar las ventas de los productos			
				$totalProductosComprados =  array();
				foreach ($listaProductos as $key => $value){
					array_push($totalProductosComprados, $value["cantidad"]);				
					$itemProducto = "id";
					$valorProducto = $value["id"];
					$orden = "id";
					$traerProducto = ModeloProductos::mdlMostrarProductos($itemProducto, $valorProducto, $orden);				
					// Actualizar Ventas
					$itemVentas = "ventas";
					$valorVentas = $value["cantidad"] + $traerProducto["ventas"];
					$nuevaVentas = ModeloProductos::mdlActualizarProducto($itemVentas, $valorVentas, $valorProducto);
					// Actualizar Stock
					$itemStock = "stock";
					$valorStock = $value["stock"];
					$nuevaVentas = ModeloProductos::mdlActualizarProducto($itemStock, $valorStock, $valorProducto);
				}
				// Actualizar nuevamente la cuenta del Cliente
				$itemCliente = "id_user";
				$valorCliente = $cliente;
				$traerCuentaCliente = ModeloCuentas::mdlMostrarCuentas($itemCliente, $valorCliente);
				// Actualizar cantidad de compras del cliente
				$itemCompras = "compras";
				$valorCompras = $traerCuentaCliente["compras"] + array_sum($totalProductosComprados);
				$comprasCliente = ModeloCuentas::mdlActualizarCuenta($itemCompras, $valorCompras, $valorCliente);
				// Fin Actualizar Compras, reducir Stock y aumentar las ventas			
				// Actualizar saldo de la cuenta del Cliente		
				if($metodoPago == "CuentaCorriente"){
					$itemSaldoActual = "saldo_actual";
					$valorSaldoActual = $traerCuentaCliente["saldo_actual"] + $total;
					$comprasCliente = ModeloCuentas::mdlActualizarCuenta($itemSaldoActual, $valorSaldoActual, $valorCliente);
				}
				// Fin Actualizar Saldo
			} elseif($cambioCliente || $cambioMetodoPago){

				$totalProductosComprados =  array();
				foreach (json_decode($productos, true) as $key => $value){
					array_push($totalProductosComprados, $value["cantidad"]);
				}

//--------------------------------------------------------------//
//                      Salida por Consola                      //
	echo("<script>console.log('cantidad de Articulos de la Compra : ".array_sum($totalProductosComprados)."');</script>");
	echo("<script>console.log('Productos : ".$productos."');</script>");

//--------------------------------------------------------------//


				// Formatear tabla Cuenta de cliente
				$itemClienteAnt = "id_user";
				$valorClienteAnt = $clienteAnt;
				$traerCuentaClienteAnt = ModeloCuentas::mdlMostrarCuentas($itemClienteAnt, $valorClienteAnt);
				if($cambioCliente){
					// Formatear cantidad de compras del cliente
					$itemCuentaAnt = "compras";
					$valorCuentaAnt = $traerCuentaClienteAnt["compras"] - array_sum($totalProductosComprados);
					$compraClienteAnt = ModeloCuentas::mdlActualizarCuenta($itemCuentaAnt, $valorCuentaAnt, $valorClienteAnt);
				}				
				if($metodoPagoAnt == "CuentaCorriente"){					
					// Formatear Saldo de la cuenta del Cliente				
					$itemSaldoAnt = "saldo_actual";
					$valorSaldoAnt = $traerCuentaClienteAnt["saldo_actual"] - $totalAnt;
					$compraClienteAnt = ModeloCuentas::mdlActualizarCuenta($itemSaldoAnt, $valorSaldoAnt, $valorClienteAnt);
					// Fin Formatear
				}
				// Actualizar la tabla cuenta con los datos nuevos
				$itemCliente = "id_user";
				$valorCliente = $cliente;
				$traerCuentaCliente = ModeloCuentas::mdlMostrarCuentas($itemCliente, $valorCliente);
				if($cambioCliente){
					// Actualizar cantidad de compras del cliente
					$itemCompras = "compras";
					$valorCompras = $traerCuentaCliente["compras"] + array_sum($totalProductosComprados);
					$comprasCliente = ModeloCuentas::mdlActualizarCuenta($itemCompras, $valorCompras, $valorCliente);
				}
				if($metodoPago == "CuentaCorriente"){					
					$itemSaldoActual = "saldo_actual";
					$valorSaldoActual = $traerCuentaCliente["saldo_actual"] + $total;
					$comprasCliente = ModeloCuentas::mdlActualizarCuenta($itemSaldoActual, $valorSaldoActual, $valorCliente);
				}
			}				
			// Editar el Consumo
			$datos = array("id_ven" 		=> $vendedor,
						   "id_cli" 		=> $cliente,
						   "codigo" 		=> $codigo,
						   "productos" 		=> $productos,
						   "total_descuento"=> $descuento,
						   "neto" 			=> $neto,
						   "total" 			=> $total,
						   "metodo_pago" 	=> $metodoPago);
			$respuesta = ModeloConsumos::mdlEditarConsumo($datos);
			if($respuesta){
				echo'<script>
						swal({
						  type: "success",
						  title: "El consumo ha sido Editado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
								if (result.value) {
									window.location = "adminconsumos";
								}
							})
					</script>';
			}			

		}		
	}
}