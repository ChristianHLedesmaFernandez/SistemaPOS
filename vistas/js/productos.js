// Cargar la tabla dinamica de Productos
/* Para detectar Errores (imprime el Datos Json en la consola)
$.ajax({
	
	url:"ajax/datatable-productos.ajax.php",
	success:function(respuesta){

		console.log("respuesta", respuesta);

	}

})
*/
// Para Hacer Foco en el Input dentro del Modal
$('#modalAgregarProducto').on('shown.bs.modal', function() {
  $('#nuevaCategoria').focus()
})
$('#modalEditarProducto').on('shown.bs.modal', function() {
  $('#editarDescripcion').focus()
})
// Capturar la categoria para asignar codigo
$("#nuevaCategoria").change(function(){
	var idCategoria = $(this).val();
	var datos = new FormData();
  	datos.append("idCategoria", idCategoria);
  	$.ajax({
      url:"ajax/productos.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType:"json",
      success:function(respuesta){
	      	if(!respuesta){
	      		var nuevoCodigo = idCategoria + "01";
	      	}else{
	      		var nuevoCodigo = Number(respuesta["codigo"]) + 1;
	      	}
      		$("#nuevoCodigo").val(nuevoCodigo);
		} 
	})
})
// Subir Imagen de Producto
$(".nuevaImagen").change(function(){
	var imagen = this.files[0]; // para ver las propiedades de la foto que elijo	
	// Validacion formato de imagen
	if(imagen["type"] != "image/jpeg" && imagen["type"] != "image/png"){
		$(".nuevaImagen").val("");
		swal({
			type: "error",
			title: "Error al subir la imagen",
			text: "¡La imagen debe estar en formato JPG o PNG!",			
			confirmButtonText: "Cerrar"
		});
	}else if(imagen["size"] > 2000000){
		$(".nuevaImagen").val("");
		swal({
			type: "error",
			title: "Error al subir la imagen",
			text: "¡La imagen no debe excederlos 2 MB.!",			
			confirmButtonText: "Cerrar"
		});
	}else{
		var datosImagen = new FileReader;
		datosImagen.readAsDataURL(imagen);
		$(datosImagen).on("load", function(event){
			var rutaImagen = event.target.result;
			$(".previsualizar").attr("src", rutaImagen);
		})
	}
})
// Editar Productos
$(document).on("click", ".btnEditarProducto",function(){
	var idProducto = $(this).attr("idProducto");
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
			$("#editarCategoria").val(respuesta["categoria"]);
	        $("#idCategoria").val(respuesta["id_categoria"]);
	        $("#editarCodigo").val(respuesta["codigo"]);
	        $("#editarDescripcion").val(respuesta["descripcion"]);
	        $("#editarStock").val(respuesta["stock"]);
	        $("#editarPrecioVenta").val(respuesta["precio_venta"]);
	        if(respuesta["imagen"] != ""){
	        	$("#imagenActual").val(respuesta["imagen"]);
           		$(".previsualizar").attr("src",  respuesta["imagen"]);
           	}
      	}
  	})
})
// Borra Producto
$(document).on("click", ".btnEliminarProducto",function(){
	var idProducto = $(this).attr("idProducto");
	codigo = $(this).attr("codigo");
	imagen = $(this).attr("imagen");
	swal({
		title: '¿Está seguro de borrar este Producto?',
		text: "¡Si no lo está puede cancelar la acción!",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085D6',
		cancelButtonColor: '#D33',
		cancelButtonText: 'Cancelar',
		confirmButtonText: 'Si, borrar producto!'
		}).then((result)=>{
		if(result.value){
			window.location = "index.php?ruta=productos&idProducto="+idProducto+"&imagen="+imagen+"&codigo="+codigo;
		}
	})
})
// Para la carga Dinamica de Productos
$('.tablaProductos').DataTable({
	"ajax": "ajax/datatable-productos.ajax.php",
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



