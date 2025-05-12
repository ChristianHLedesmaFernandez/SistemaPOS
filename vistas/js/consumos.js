// Agregar Productos al consumo desde la tabla
$(document).on("click", ".agregarProducto",function(){
	var idProducto = $(this).attr("idproducto");
	$(this).removeClass("btn-primary agregarProducto");
	$(this).addClass("btn-default");
	var datos = new FormData();
    datos.append("idProducto", idProducto);
	$.ajax({
	    url:"ajax/productos.ajax.php",
	    method: "POST",
	    data: datos,
	    cache: false,
	    contentType: false,
	    processData: false,
	    dataType:"json",
	    success:function(respuesta){
	    	var descripcion = respuesta["descripcion"];
	    	var stock = respuesta["stock"];
	    	var precio = respuesta["precio_venta"];
	    	// Evitar agregar producto cuando el stock este en cero
			if(stock == 0){
				swal({
					type: "error",
					title: "No hay stock disponible",
					confirmButtonText: "¡Cerrar!"
				});
				$("button[idProducto='"+idProducto+"']").addClass('btn-primary');
				$("button[idProducto='"+idProducto+"']").addClass('btn-primary agregarProducto');
				return;
			}
			// Fin Evitar
	    	$(".nuevoProducto").append(
	    		 '<div class="row" style="padding:5px 15px">' +
	    			'<!-- Entrada Descripcion del Producto -->' +
	    			'<div class="col-xs-6" style="padding-right:0px">' +
                        '<div class="input-group">' +
                          '<span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs quitarProducto" idproducto="'+ idProducto +'"><i class="fa fa-times"></i></button></span>' +
                          '<input type="text" class="form-control nuevaDescripcionProducto" id="agregarProducto" name="agregarProducto" idProducto="'+ idProducto +'" value ="'+ descripcion +'" readonly required>' +
                        '</div>' +
                    '</div>' +
                    '<!-- Entrada Cantidad de Producto -->' +
                    '<div class="col-xs-3">' +                        
                       '<input type="number" class="form-control nuevaCantidadProducto" id="nuevaCantidadProducto" name="nuevaCantidadProducto" min="1" value="1" stock="'+ stock +'" nuevoStock="'+ Number(stock - 1) +'" required>' +
                    '</div>' +
                      '<!-- Entrada Precio del Producto -->' +
                    '<div class="col-xs-3 ingresoPrecio" style="padding-left:0px">' +
                        '<div class="input-group">' +
                          '<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>' +
                          '<input type="text" class="form-control nuevoPrecioProducto" precioUnitario="'+ precio +'" name="nuevoPrecioProducto" value ="'+ precio +'" readonly required>'+  
                        '</div>' +
                    '</div>' +
                  '</div>');
		sumarTotalPrecio(); // Suma los precio de los productos.
		aplicarDescuento(); // Aplicar el Descuento al precio total.
		blanquearEfectivo(); // Blanquar si el pago es en Efectivo
		listarProductos() // Agrupar productos en un JSON
	
		// Agregar Formato al precio de los Productos
		$(".nuevoPrecioProducto").number(true, 2);
	    }
	})
});
// Cuando carge la Tabla cada vez que navegue en ella
$(document).on("draw.dt", function(){ // se ejecuta cada vez que navegue en la tabla productos
	if(localStorage.getItem("quitarProducto") != null){
		var listaIdProductos = JSON.parse(localStorage.getItem("quitarProducto"));
		for (var i = 0; i < listaIdProductos.length; i++){
			$("button.recuperarBoton[idProducto='"+listaIdProductos[i]["idProducto"]+"']").removeClass('btn-default');
			$("button.recuperarBoton[idProducto='"+listaIdProductos[i]["idProducto"]+"']").addClass('btn-primary agregarProducto');
		}
	}
})
// Agregar Productos al consumo desde dispositivos moviles
var numProducto = 0;
$(document).on("click", ".btnAgregarProducto", function(){
	numProducto++;
	var datos = new FormData();
	datos.append("traerProductos", "ok");
	$.ajax({
		url: "ajax/productos.ajax.php",
		method: "POST",
      	data: datos,
      	cache: false,
     	contentType: false,
     	processData: false,
     	dataType:"json",
     	success: function(respuesta){
     		$(".nuevoProducto").append(
     				'<!-- Entrada Descripcion del Producto -->' +
					'<div class="row" style="padding:5px 15px">' +
					    '<div class="col-xs-6" id="descripcion'+ numProducto +'" style="padding-right:0px">' +
						    '<div class="input-group">' +
						      	'<span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs quitarProducto" idProducto><i class="fa fa-times"></i></button></span>' +
						       	'<select class="form-control nuevaDescripcionProducto" id="producto'+ numProducto +'"  idProducto name="nuevaDescripcionProducto" required>' +
									'<option>Seleccione el producto</opcion>' +
						      	'</select>' +   
						    '</div>' +					                        
						'</div>' + 
						'<!-- Entrada de Cantidad -->' +
						'<div class="col-xs-3 ingresoCantidad">' +					                        
							'<input type="number" class="form-control nuevaCantidadProducto" name="nuevaCantidadProducto" min="1" value="1" stock nuevoStock required>' +
						'</div>' + 
						'<!-- Entrada de Precio -->' +
						'<div class="col-xs-3 ingresoPrecio" style="padding-left:0px">' +
						    '<div class="input-group">' +
						    	'<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>' +
						    	'<input type="text" class="form-control nuevoPrecioProducto" precioUnitario name="nuevoPrecioProducto" readonly required>' +  
						    '</div>' +
						'</div>' +
					'</div>');
     		// Agregar Productos al Select     		
     		respuesta.forEach(functionForEach);
     		function functionForEach(item, index){
     			if(item.stock != 0){
     				$("#producto" + numProducto).append(
     					'<option idProducto="'+ item.id +'" value="'+ item.descripcion +'">'+ item.descripcion +'</option>' 
     					)
     			}
     		}     		
     		// Fin Agregar Producto

     		// Agregar Formato al precio de los Productos
			$(".nuevoPrecioProducto").number(true, 2);

     	}
     })
});
// Seleccionar Producto dispositivos moviles
$(document).on("change", "select.nuevaDescripcionProducto",function(){
	var nombreProducto = $(this).val();	
	var nuevoPrecioProducto = $(this).parent().parent().parent().children(".ingresoPrecio").children().children(".nuevoPrecioProducto");
	var nuevaCantidadProducto = $(this).parent().parent().parent().children(".ingresoCantidad").children(".nuevaCantidadProducto");
	var datos = new FormData();
	datos.append("nombreProducto", nombreProducto);
	$.ajax({
		url: "ajax/productos.ajax.php",
		method: "POST",
      	data: datos,
      	cache: false,
     	contentType: false,
     	processData: false,
     	dataType:"json",
     	success: function(respuesta){			
      	    $(nuevaCantidadProducto).attr("stock", respuesta["stock"]);
      	    $(nuevaCantidadProducto).attr("nuevoStock", Number(respuesta["stock"] - 1));      	    
      	    $(nuevoPrecioProducto).val(respuesta["precio_venta"]);      	    
      	    $(nuevoPrecioProducto).attr("precioUnitario", respuesta["precio_venta"]);			
      	    sumarTotalPrecio(); // Suma los precio de los productos.
      	    aplicarDescuento(); // Aplicar el Descuento al precio total.
      	    blanquearEfectivo(); // Blanquar si el pago es en Efectivo
      	    listarProductos() // Agrupar productos en un JSON
      	    /*      	    
      	    $(".nuevoPrecioProducto").number(true, 2); // Formato al precio de los Productos
      	    */

     	}
     })
	//
	

	// Cambiar el select por un Imput
	var numDescripcion = $(this).parent().parent().attr("id");
	$("#" + numDescripcion).children().remove();	
	$("#" + numDescripcion).append(
						'<div class="input-group">' +
                          '<span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs quitarProducto" idproducto><i class="fa fa-times"></i></button></span>' +
                          '<input type="text" class="form-control" id="agregarProducto" name="agregarProducto" value="' + nombreProducto +'" readonly>' +
                        '</div>');
   	// Fin Cambiar
});
// Sacar productos del consumo y Recuperar el Boton
var idQuitarProducto = [];
localStorage.removeItem("quitarProducto");
$(document).on("click", ".quitarProducto",function(){
	$(this).parent().parent().parent().parent().remove();
	var idProducto = $(this).attr("idProducto");
	// Almacenar en el Local Storage el Id del producto a quitar
	if(localStorage.getItem("quitarProducto") == null){
		idQuitarProducto = [];
	}else{
		idQuitarProducto.concat(localStorage.getItem("quitarProducto"));
	}
	idQuitarProducto.push({"idProducto":idProducto});
	localStorage.setItem("quitarProducto", JSON.stringify(idQuitarProducto));
	// Fin almacenar en Local Storage	
	$("button.recuperarBoton[idProducto='"+idProducto+"']").removeClass('btn-default');
	$("button.recuperarBoton[idProducto='"+idProducto+"']").addClass('btn-primary agregarProducto');
	if($(".nuevoProducto").children().length == 0){ // si no hay productos a sumar.
		$("#nuevoTotalVenta").val(0);
		$("#totalVenta").val(0);
		$("#nuevoTotalVenta").attr("total", 0);	
		//$("#nuevoDescuentoVenta").val(0);
	}else{
		sumarTotalPrecio(); // Suma los precio de los productos.
		aplicarDescuento(); // Aplicar Descuento.
		blanquearEfectivo(); // Blanquar si el pago es en Efectivo
		listarProductos() // Agrupar productos en un JSON
	}
});
// Modificar Cantidad de Producto
$(document).on("change", "input.nuevaCantidadProducto",function(){	
	var precio = $(this).parent().parent().children(".ingresoPrecio").children().children(".nuevoPrecioProducto");
	var precioFinal = $(this).val() * precio.attr("precioUnitario");
	precio.val(precioFinal);
	var nuevoStock =  Number($(this).attr("stock")) - Number($(this).val());
	$(this).attr("nuevoStock", nuevoStock);
	if(Number($(this).val()) > Number($(this).attr("stock"))){ // para comparar como numero uso Number().
		// Si la cantidad supera el stock regresa valores iniciales
		$(this).val(1);
		var precioFinal = $(this).val() * precio.attr("precioUnitario");
		precio.val(precioFinal);
		swal({
			type: "error",
			title: "la Cantidad supera el stock disponible",
			text: "¡Sólo hay " + $(this).attr("stock") + " unidades!",
			confirmButtonText: "¡Cerrar!"
			});
	}     	
    sumarTotalPrecio(); // Suma los precio de los productos.
    aplicarDescuento(); // Aplicar el Descuento al precio total.
    blanquearEfectivo(); // Blanquar si el pago es en Efectivo
	
	listarProductos() // Agrupar productos en un JSON
	
})
// Sumar todos los Precios
function sumarTotalPrecio(){
	var precioItem = $(".nuevoPrecioProducto");
	var arraySumaPrecio = [];
	for(var i = 0; i < precioItem.length; i++){ // recorre los productos agregados.
		arraySumaPrecio.push(Number($(precioItem[i]).val())); // agrego el precio.
	}
	function sumarArrayPrecio(total, numero){
		return total + numero;
	}
	var sumaTotalPrecio = arraySumaPrecio.reduce(sumarArrayPrecio);
	$("#nuevoTotalVenta").val(sumaTotalPrecio);
	$("#totalVenta").val(sumaTotalPrecio);
	$("#nuevoTotalVenta").attr("total", sumaTotalPrecio);
}
// Calcular descuento
function aplicarDescuento(){
	var descuento = Number($("#nuevoDescuentoVenta").val());
	var precioTotal = Number($("#nuevoTotalVenta").attr("total"));
	var precioDescuento = precioTotal*descuento/100;
	var totalConDescuento = precioTotal - precioDescuento;
	$("#nuevoTotalVenta").val(totalConDescuento);
	$("#totalVenta").val(totalConDescuento);
	$("#nuevoPrecioDescuento").val(precioDescuento);
	$("#nuevoPrecioNeto").val(precioTotal);
}
// Cuando elijo un cliente cambio el Descuento
$(document).on("change", "select.seleccionarCliente",function(){
	var idCliente = $(this).val();
	var precioTotal = Number($("#nuevoTotalVenta").attr("total"));
	var datos = new FormData();
    datos.append("idCliente", idCliente);
    $.ajax({
        url:"ajax/clientes.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta){
        	$("#nuevoDescuentoVenta").val(respuesta["descuento"]);
        	if (!isNaN(precioTotal)){
				aplicarDescuento(); // Aplicar el Descuento al precio total.
        	}        	
        }
    });
})
// Formato al precio Final
$("#nuevoTotalVenta").number(true, 2);
// Seleccionar Metodo de Pago
$(document).on("change", "#nuevoMetodoPago",function(){
	var metodo = $(this).val();
	if(metodo == "Efectivo"){
		$(this).parent().parent().removeClass("col-xs-6");
		$(this).parent().parent().addClass("col-xs-4");
		$(this).parent().parent().parent().children(".cajasMetodoPago").html(
			'<div class="col-xs-4">'+
				'<div class="input-group">'+
					'<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>'+
					'<input type="text" class="form-control" id="nuevoValorEfectivo" placeholder="0000" required>' +
				'</div>'+
			'</div>' +
			'<div class="col-xs-4" id="capturarCambioEfectivo" style="padding-left:0px">'+
				'<div class="input-group">'+
					'<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>'+
					'<input type="text" class="form-control" id="nuevoCambioEfectivo" name="nuevoCambioEfectivo" placeholder="0000" readonly required>' +
				'</div>'+
			'</div>');
		// Agregar Formato al precio
		$("#nuevoValorEfectivo").number(true, 2);
		$("#nuevoCambioEfectivo").number(true, 2);
	}else{
		$(this).parent().parent().removeClass("col-xs-4");
		$(this).parent().parent().addClass("col-xs-6");		
		$(this).parent().parent().parent().children(".cajasMetodoPago").html(
			'<div class="col-xs-6" style="padding-left: 0px">'+                      
           '</div>');        
	}
})
// Calcular el cambio cuando cambia efectivo recibido
$(document).on("change", "#nuevoValorEfectivo", function(){
	cambioEfectivo(); //Calcula el cambio para el cliente.
})
// Cambio en efectivo
function cambioEfectivo(){
	var efectivo = $("#nuevoValorEfectivo").val();
	var cambio = Number(efectivo) - Number($("#nuevoTotalVenta").val());
	var nuevoCambioEfectivo = $("#nuevoValorEfectivo").parent().parent().parent().children("#capturarCambioEfectivo").children().children("#nuevoCambioEfectivo");
	nuevoCambioEfectivo.val(cambio);
}

// Blanquear cambio Efectivo
function blanquearEfectivo(){	
	var nuevoCambioEfectivo = $("#nuevoValorEfectivo").parent().parent().parent().children("#capturarCambioEfectivo").children().children("#nuevoCambioEfectivo");
	$("#nuevoValorEfectivo").val(0);
	nuevoCambioEfectivo.val(0);
}
// Agrupar productos en datos Json 
function listarProductos(){
	var listaProductos = [];
	var descripcion = $(".nuevaDescripcionProducto");
	var cantidad = $(".nuevaCantidadProducto");
	var precio = $(".nuevoPrecioProducto");
	for (var i = 0; i < descripcion.length; i++){	 	 
	 	 listaProductos.push({
	 	 					  "id": $(descripcion[i]).attr("idProducto"),
	 	 					  "descripcion": $(descripcion[i]).val(),
	 	 					  "cantidad": $(cantidad[i]).val(),
	 	 					  "stock": $(cantidad[i]).attr("nuevoStock"),
	 	 					  "precio": $(precio[i]).attr("precioUnitario"),
	 	 					  "total": $(precio[i]).val()
	 	 					})
	 }
	 $("#listaProductos").val(JSON.stringify(listaProductos));
}
// Boton Editar Consumo
$(document).on("click", ".btnEditarConsumo",function(){
	var idConsumo = $(this).attr("idConsumo");
	window.location = "index.php?ruta=editar-consumo&idConsumo=" + idConsumo;
})

//--------------------------------------------------------------------------------------------------
// Para la carga Dinamica de la tabla Productos
$('.tablaConsumos').DataTable({
	"ajax": "ajax/datatable-consumos.ajax.php",
	"deferRender": true,
	"retrieve": true,
	"processing": true,
	"language": {
		"sProcessing":     "Procesando...",
		"sLengthMenu":     "Mostrar _MENU_ registros",
		"sZeroRecords":    "No se encontraron resultados",
		"sEmptyTable":     "Ningún dato disponible en esta tabla",
		"sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
		"sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0",
		"sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
		"sInfoPostFix":    "",
		"sSearch":         "Buscar:",
		"sUrl":            "",
		"sInfoThousands":  ",",
		"sLoadingRecords": "Cargando...",
		"oPaginate": {
		"sFirst":    "Primero",
		"sLast":     "Último",
		"sNext":     "Siguiente",
		"sPrevious": "Anterior"
		},
		"oAria": {
			"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
			"sSortDescending": ": Activar para ordenar la columna de manera descendente"
		}
	}
})