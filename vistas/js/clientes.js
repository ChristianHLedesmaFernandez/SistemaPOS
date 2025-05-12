
// Para Hacer Foco en el Input dentro del Modal
$('#modalAgregarCliente').on('shown.bs.modal', function() {
  $('#nuevoNombre').focus()
})
$('#modalEditarCliente').on('shown.bs.modal', function() {
  $('#editarNombre').focus()
})
// Inserta un Input para agregar el nombre del Local	
$('#nuevoLocal, #editarLocal').change(function(){    
    var opcion = $(this).val();
    // Para definir si esta en el formulario editar o nuevo
    var nombre = $(this).attr('id').slice(0, -5);
    var padre = document.getElementById(nombre + "AgregarNombre");	
    if(opcion == "agregarlocal"){
        var input = document.createElement("INPUT");
        input.setAttribute("class", "form-control input-lg");         
        input.setAttribute("type", "text");
        input.setAttribute("id", nombre + "NombreLocal");
        input.setAttribute("name", nombre + "NombreLocal");
		input.setAttribute("placeholder", "Ingresar Nombre del Local");
        padre.appendChild(input);        
	}else{
		hijo = document.getElementById(nombre + "NombreLocal");		
		if(hijo != null){			
			padre.removeChild(hijo);	
		}		
	}
});
// Para borrar el input text de agregar local
$(document).on("click", ".btnNuevoCliente",function(){
    var padre = document.getElementById("nuevoAgregarNombre");
    hijo = document.getElementById("nuevoNombreLocal");      
    if(hijo != null){           
        padre.removeChild(hijo);    
    }
});
// Para borrar el input text de editar local
$(document).on("click", ".btnEditarCliente",function(){
    var padre = document.getElementById("editarAgregarNombre");
    hijo = document.getElementById("editarNombreLocal");      
    if(hijo != null){           
        padre.removeChild(hijo);    
    }
});
// Editar Cliente
$(document).on("click", ".btnEditarCliente",function(){
    // Capturo el numero de id
    var idCliente = $(this).attr("idCliente");
    // Traer los datos desde la Base de datos   
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
            $("#editarNombre").val(respuesta["nombre"]);            
            $("#editarUsuario").val(respuesta["usuario"]);
            $("#passwordActual").val(respuesta["password"]);
            $("#tokenActual").val(respuesta["token"]);
            // Verifico si el correo y el telefono esta vacio
            if(respuesta["correo"] == ""){
                document.getElementById('editarEmail').readOnly = false;
                document.getElementById('editarEmail').name = "nuevoEmail";
                document.getElementById('editarEmail').placeholder = "Ingresar Correo Electronico";
            }else{
                document.getElementById('editarEmail').name = "editarEmail";
                document.getElementById('editarEmail').readOnly = true;
                $("#editarEmail").val(respuesta["correo"]);    
            }
            if(respuesta["telefono"] == "" || respuesta["telefono"] == null){
                document.getElementById('editarTelefono').placeholder = "Ingresar Telefono";
            }else{
                $("#editarTelefono").val(respuesta["telefono"]);   
            }
            // Fin verificar vacio
            $("#idLocal").val(respuesta["id_local"]).html(respuesta['local']);
            $("#localActual").val(respuesta['id_local']);
        }
    });
})

