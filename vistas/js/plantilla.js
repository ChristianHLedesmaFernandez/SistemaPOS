// Limpia la Imagen y los campos de los form de los Modales
$('.modal').on('hidden.bs.modal', function() {	
    $(this).find('form')[0].reset();
    $(".alert").remove();  
    // Para limpiar la imagen 
    let id = this.id;  
	if(id.search("Usuario")>0){
		$(".previsualizar").attr("src", "vistas/img/usuarios/default/anonymous.jpg");
	}else{
		if(id.search("Producto")>0){
			$(".previsualizar").attr("src", "vistas/img/productos/default/anonymous.png");
		}
	}
	// Fin Limpiar imagen
})


// Evitar doble Submit 
/*
$(document).ajaxStart(function() { 
	Pace.restart(); 
});
$('.boton').click(function(){
	$.ajax({
		url: '#', 
		success: function(result){
			$('.boton-content').html('<hr>Ajax Request Completed!')
		}
	})
})
*/
//-------------------------------------------------------------//
//                     Evitar Doble Submit                     //
//    $(this).find('button[type=submit]').prop('disabled', true);
//});
//-------------------------------------------------------------//


/*
$('#tu_id_del_form').submit(function(){
    $(this).find('button[type=submit]').prop('disabled', true);
});
////////////////////////////////////////////////////////////////////
$(document).on("click", ".btnEnviar",function () {

	$(this).value = "Registrando...";
	$(this).disabled = true;

	return true;
})
*/		
// SideBar Menu
$('.sidebar-menu').tree()

// Script para iCheck y Radio Input
$('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
	checkboxClass: 'icheckbox_minimal-blue',
	radioClass   : 'iradio_minimal-blue'
})

// Script para Mask (formato de ingreso)
//Datemask dd/mm/yyyy
$('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
//Datemask2 mm/dd/yyyy
$('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
//Money Euro
$('[data-mask]').inputmask()


// Data-table
$('.tablas').DataTable({
	// Presenta la tabla ordenada por la columna nombre en forma ascendente 
	"order":[[1,"asc"]],
	// Configurar el Lenguaje
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

});