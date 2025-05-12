// Para Hacer Foco en el Input dentro del Modal
$('#modalAgregarUsuario').on('shown.bs.modal', function() {
  $('#nuevoNombre').focus()
})
$('#modalEditarUsuario').on('shown.bs.modal', function() {
  $('#editarNombre').focus()
})
// Subir la foto del usuario
$(".nuevaFoto").change(function(){
	var imagen = this.files[0]; // Para ver las propiedades de la foto que elijo
	// Validacion formato de imagen
	if(imagen["type"] != "image/jpeg" && imagen["type"] != "image/png"){
		$(".nuevaFoto").val("");
		swal({
			type: "error",
			title: "Error al subir la imagen",
			text: "¡La imagen debe estar en formato JPG o PNG!",			
			confirmButtonText: "Cerrar"
		});
	}else if(imagen["size"] > 2000000){
		$(".nuevaFoto").val("");
		swal({
			type: "error",
			title: "Error al subir la imagen",
			text: "¡La imagen no debe exceder los 2 MB.!",			
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
// Editar Usuario
$(document).on("click", ".btnEditarUsuario",function(){
	// Capturo el numero de id
	var idUsuario = $(this).attr("idUsuario");
	// Traer los datos desde la Base de datos	
	var datos = new FormData();
	datos.append("idUsuario", idUsuario);
	$.ajax({
		url:"ajax/usuarios.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta){
			$("#editarNombre").val(respuesta["nombre"]);			
			$("#editarUsuario").val(respuesta["usuario"]);
			$("#editarEmail").val(respuesta["correo"]);		
			$("#fotoActual").val(respuesta["foto"]);
			$("#passwordActual").val(respuesta["password"]);
			if(respuesta["foto"] != ""){
				$(".previsualizar").attr("src", respuesta["foto"]);
			}
		}
	});
})
// Activar/Desactivar Usuario
$(document).on("click", ".btnActivar",function(){
	var idUsuario = $(this).attr("idUsuario");
	var estadoUsuario = $(this).attr("estadoUsuario");
	var pagina = $(this).attr("usuarios");	
	var datos = new FormData();
	datos.append("activarId", idUsuario);
	datos.append("activarUsuario", estadoUsuario);	
	if(estadoUsuario <= 0){
		actualizar = "Desactivado";
	}else{
		actualizar = "Activado";
	}
	$.ajax({
		url: "ajax/usuarios.ajax.php",
	    method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		success: function(respuesta){
			if(window.matchMedia("(max-width:767px)").matches){				
				swal({	
					title: "El usuario ha sido " + actualizar,
					type: "success",
					confirmButtonText: "Cerrar",
				}).then(function(result){
					if(result.value){
						window.location = pagina;
					}
				});
			}
		}
	})	
	if(estadoUsuario <= 0){
		estadoAnterior = 4 + parseInt(estadoUsuario);
		$(this).removeClass('btn-success');
		$(this).addClass('btn-danger');
		$(this).html('Desactivado');		
	}else{
		estadoAnterior = parseInt(estadoUsuario) - 4;
		$(this).removeClass('btn-danger');
		$(this).addClass('btn-success');
		$(this).html('Activado');
	}
	$(this).attr('estadoUsuario', estadoAnterior);
})
// Evitar Usuario repetido
$("#nuevoUsuario").change(function(){
	document.getElementById("usuario").classList.remove('has-error');
	$(".help-block").remove();
	//$(".text-danger").remove();
	var usuario = $(this).val();	
	var datos = new FormData();
	datos.append("validarUsuario", usuario);
	$.ajax({
		url: "ajax/usuarios.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta){
			if(respuesta && respuesta.length > 0){
				document.getElementById("usuario").classList.add('has-error');
				
				$("#nuevoUsuario").parent().after('<div class="help-block">El nombre de Usuario "'+ usuario +'" ya existe</div>');
				//$("#nuevoUsuario").parent().after('<div class="text-danger">El nombre de Usuario "'+ usuario +'" ya existe</div>');
				
				$("#nuevoUsuario").val("");
				$('#nuevoUsuario').focus();
			}
		}
	})
})
// Evitar Email repetido
$("#nuevoEmail, #editarEmail").change(function(){	
	var nombre =  "#" + $(this).attr('id');
	if(nombre == "#nuevoEmail"){
		var nombreEmail = "correo";
	}else{
		var nombreEmail = "correoE";
	}
	document.getElementById(nombreEmail).classList.remove('has-error');
	//$(".text-danger").remove();
	$("#msj_email_repetido").remove();
	var email = $(this).val();
	var datos = new FormData();
	datos.append("validarEmail", email);
	$.ajax({
		url: "ajax/usuarios.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta){
			if(respuesta && respuesta.length > 0){
				document.getElementById(nombreEmail).classList.add('has-error');
				//$(nombre).parent().after('<div class="text-danger" id="msj_correo_repetido"><i class="fa fa-warning "></i> El correo electronico "'+ email +'" ya existe</div>');

				//

				$(nombre).parent().after('<span class="help-block" id="msj_correo_repetido"><i class="fa fa-warning "></i> El correo electronico "'+ email +'" ya existe!</span>'); 
				//

				$(nombre).val("");				
				$(nombre).focus();
			}
		}
	})
})
// Eliminar Usuario
$(document).on("click", ".btnEliminarUsuario",function(){
	idUsuario = $(this).attr("idUsuario");
	usuario = $(this).attr("usuario");
	perfil = $(this).attr("perfil");
	fotoUsuario = $(this).attr("fotoUsuario");
	swal({
		title: '¿Está seguro de borrar a '+usuario+'?',
		text: "¡Si no lo está puede cancelar la acción!",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085D6',
		cancelButtonColor: '#D33',
		cancelButtonText: 'Cancelar',
		confirmButtonText: 'Si, borrar usuario!'
	}).then((result)=>{
		if(result.value){
			window.location = "index.php?ruta="+perfil+"&idUsuario="+idUsuario+"&usuario="+usuario+"&fotoUsuario="+fotoUsuario+"&perfil="+perfil;
		}
	})
})

// Limpiar errores en los imputs
$(document).on("click", ".btnNuevoUsuario, .btnEditarUsuario, .btnNuevoCliente, .btnEditarCliente",function(){
	document.getElementById("usuario").classList.remove('has-error');
	//$(".text-danger").remove();
	$(".help-block").remove();
	
	//document.getElementById("correo").classList.remove('has-error');
	//document.getElementById("correoE").classList.remove('has-error');
	//$(".text-danger").remove();
})
//---------------------------------------------------------------//
//                          Solicitudes                          //
//---------------------------------------------------------------//
// Aceptar Solicitud
/*
$(document).on("click", ".btnAceptarSolicitud",function(){
	idUsuario = $(this).attr("idUsuarioA");
	usuario = $(this).attr("usuario");
	nombre = $(this).attr("nombreA");
	email = $(this).attr("emailA");
	token = $(this).attr("tokenA");
	$(document).find('.modal-title').text('Aceptar la Solicitud de: ' + usuario);
	$("#idUsuarioA").val(idUsuario);			
	$("#nombreA").val(nombre);
	$("#emailA").val(email);
	$("#tokenA").val(token);
})
// Rechazar Solicitud
$(document).on("click", ".btnRechazarSolicitud",function(){
	idUsuario = $(this).attr("idUsuarioR");
	usuario = $(this).attr("usuario");
	nombre = $(this).attr("nombreR");
	email = $(this).attr("emailR");
	$(document).find('.modal-title').text('Rechazar la Solicitud de:: ' + usuario);
	$("#idUsuarioR").val(idUsuario);			
	$("#nombreR").val(nombre);
	$("#emailR").val(email);	
})
*/