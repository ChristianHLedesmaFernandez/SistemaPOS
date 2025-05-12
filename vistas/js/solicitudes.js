// Aceptar Solicitud
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