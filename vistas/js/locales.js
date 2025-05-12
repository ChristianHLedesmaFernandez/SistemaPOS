
// Para Hacer Foco en el Input dentro del Modal
$('#modalAgregarLocal').on('shown.bs.modal', function() {
  $('#nuevoLocal').focus()
})
$('#modalEditarLocal').on('shown.bs.modal', function() {
  $('#editarTelefono').focus()
})
// Editar Local
// Rechazar Solicitud
$(document).on("click", ".btnEditarLocal",function(){
	idLocal = $(this).attr("idLocal");
	local = $(this).attr("local");
	telefono = $(this).attr("telefono");
	direccion = $(this).attr("direccion");
	$("#editarLocal").val(local);			
	$("#editarTelefono").val(telefono);
	$("#editarDireccion").val(direccion);	
})

// Evitar Local repetido
$('#nuevoLocal').change(function(){	
    var local = $(this).val();
    // Para definir si esta en el formulario editar o nuevo
    //var nombre = $(this).attr('id').slice(0, -5);
	document.getElementById("local").classList.remove('has-error');
	$(".text-danger").remove();
	// Peticion AJAX
	var datos = new FormData();
	datos.append("validarLocal", local);
	$.ajax({
		url: "ajax/locales.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta){
			if(respuesta){
				document.getElementById("local").classList.add('has-error');
				$("#nuevoLocal").parent().after('<div class="help-block">El Local "'+ local +'" ya esta registrado</div>');
				$("#nuevoLocal").val("");
				$('#nuevoLocal').focus();					
			}
		}
	})
	// Fin Peticion
})
// Eiminar Local
$(".tablas").on("click", ".btnEliminarLocal",function(){
	var idLocal = $(this).attr("idLocal");
	var datos = new FormData();
	datos.append("idLocal", idLocal);
	swal({
		title: '¿Está seguro de borrar el Local?',
		text: "¡Si no lo está puede cancelar la acción!",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085D6',
		cancelButtonColor: '#D33',
		cancelButtonText: 'Cancelar',
		confirmButtonText: 'Si, borrar categoría!'
	}).then((result)=>{		
		if(result.value){
			// Uso un peticion Ajax para eliminar el local
			$.ajax({
				url: "ajax/locales.ajax.php",
			    method: "POST",
				data: datos,
				cache: false,
				contentType: false,
				processData: false,
				success: function(respuesta){
					swal({
						type: "success",
						title: "El Local ha sido borrado correctamente",
						showConfirmButton: true,
						confirmButtonText: "Cerrar"
						}).then(function(result){
							if (result.value) {
								window.location = "locales";
							}
					})
				}
			})
			// Fin peticion Ajasx
		}
	})
})

