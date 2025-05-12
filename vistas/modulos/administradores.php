<?php 
/*
if($_SESSION["perfil"] == "Vendedor" || $_SESSION["perfil"] == "Cliente" ){
  echo '<script>
          window.location = "inicio";
        </script>';
  return;
}*/
?>
<div class="content-wrapper">
  <!-- Encabezado de contenido (encabezado de página) -->
  <section class="content-header">
    <h1>
      Usuarios
      <small>Administradores</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i>Inicio</a></li>
      <li>Usuarios</li>        
      <li class="active">Administradores</li>
    </ol>
  </section>
  <!-- Fin Encabezado de contenido -->
  <!-- Contenido principal  -->
  <section class="content"> 
    <!-- Caja predeterminada -->
    <div class="box">
    <div class="box-header with-border">
      <button class="btn btn-primary btnNuevoUsuario btnModal" data-toggle="modal" data-target="#modalAgregarUsuario">
        Agregar Administrador
      </button>
    </div>
      <div class="box-body">
               <table class="table table-bordered table-striped dt-responsive tablas" width="100%">             
          <thead>
            <tr>
              <th style="width: 10px">#</th>
              <th>Nombre</th>
              <th>Apellido</th>              
              <th>Usuario</th>
              <th>Imagen</th> 
              <th>Estado</th>
              <th>Ultimo Ingreso</th>
              <th>Acciones</th>
            </tr> 
          </thead> 
          <tbody>    
            <?php 
            $item = "perfil";
            $valor = "Administrador";
            $usuarios = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);  
            foreach ($usuarios as $key => $value) {
              echo '<tr> 
                      <td style="vertical-align : middle;">'. ($key+1) .'</td>
                      <td style="vertical-align : middle;">'. $value["nombre"] .'</td>
                      <td style="vertical-align : middle;">'. $value["apellido"] .'</td>
                      <td style="vertical-align : middle;">'. $value["usuario"] .'</td>';                      
                      if(!empty($value["foto"])){
                        echo '<td><img src="'. $value["foto"] .'" class="img-thumbnail" width="40px"> </td>';
                      }else{
                        echo '<td><img src="vistas/img/usuarios/default/anonymous.jpg" class="img-thumbnail" width="40px"> </td>';   
                      }
                      switch($value["estado"]){
                         case 0:
                              echo '<td style="vertical-align : middle; text-align:center;"><button class="btn btn-danger btn-xs btnActivar" idUsuario="'. $value["id"] .'" estadoUsuario="4" usuarios="administradores">Desactivado</button></td>';
                              break;                       
                         case 4:                         
                              echo '<td style="vertical-align : middle; text-align:center;"><button class="btn btn-success btn-xs btnActivar" idUsuario="'. $value["id"] .'" estadoUsuario="0" usuarios="administradores">Activado</button></td>';
                              break;
                         default:
                              echo '<td style="vertical-align : middle; text-align:center;"><button class="btn btn-warning btn-xs">Pendiente de Activacion</button></td>';
                              break;  
                      }
              echo '                     
                      <td style="vertical-align : middle;">'. $value["last_session"] .'</td>                      
                      <td align="center">
                        <div class="btn-group">

                          <button class="btn btn-warning btnEditarUsuario btnModal" idUsuario="'. $value["id"] .'" data-toggle="modal" data-target="#modalEditarUsuario"><i class="fa fa-pencil"></i></button>
                         
                          <button class="btn btn-info"><i class="fa fa-search-plus btnVerUsuario" idUsuario="'. $value["id"] .'" fotoUsuario="'. $value["foto"] .'" usuario="'. $value["usuario"] .'"></i></button>

                          <button class="btn btn-danger"><i class="fa fa-times btnEliminarUsuario" idUsuario="'. $value["id"] .'" fotoUsuario="'. $value["foto"] .'" usuario="'. $value["usuario"] .'" perfil="administradores"></i></button>
                        </div>
                      </td>
                    </tr>';
            }
            ?>               
          </tbody>
        </table>
      </div> 
    </div>
    <!-- /. Fin Caja predeterminada -->
  </section>
  <!-- Fin Contenido principal -->
</div>
<!-- Comienzo Modal para Agregar Usuario -->
<div id="modalAgregarUsuario" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
    <form role="form" method="POST" enctype="multipart/form-data" id="formAgregarUsuario" novalidate> 
        <!-- Cabeza del Modal -->
        <div class="modal-header" style="background: #3c8dbc; color: white">     
          <h4 class="modal-title">Agregar Administrador</h4>
        </div>
        <!-- Cuerpo del Modal -->
        <div class="modal-body">          
          <div class="box-body">
            <!-- Ingresar nombre -->
            <div class="form-group" id="nombre">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="fa fa-user" style="width: 15px"></i>
                </span>
                <input class="form-control input-lg" type="text" id="nuevoNombre" name="nuevoNombre" placeholder="Ingresar nombre" required>
              </div>
            </div>
            <!-- Ingresar Usuario -->
            <div class="form-group" id="usuario"> 
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="fa fa-key" style="width: 15px"></i>
                </span>
                <input class="form-control input-lg" type="text" name="nuevoUsuario" placeholder="Ingresar usuario" id="nuevoUsuario" required>
              </div>
            </div>
            <!-- Ingresar Email-->
            <div class="form-group" id="correo">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="fa fa-envelope" style="width: 15px"></i>
                </span>
                <input class="form-control input-lg" type="email" id="nuevoEmail" name="nuevoEmail" placeholder="Ingresar Correo Electronico" required>
              </div>
            </div>
            <!-- Ingresar Contraseña -->
            <div class="form-group" id="password">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="fa fa-lock" style="width: 15px"></i>
                </span>
                <input class="form-control input-lg" type="password" id="nuevoPassword" name="nuevoPassword" placeholder="Ingresar contraseña" autocomplete="noCompletar" required>        
              </div>            
            </div>
            <!-- Seleccionar Perfil (tipo de usuario) -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="fa fa-users" style="width: 15px"></i>
                </span>
                <select class="form-control input-lg" name="nuevoPerfil" required>                  
                  <!-- <option value="">Seleccionar Perfil</option> -->
                  <option value="Administrador">Administrador</option>                  
                  <option value="Vendedor">Vendedor</option>
                </select>              
              </div>            
            </div>
            <!-- Subir Foto -->            
            <div class="form-group">
              <div class="panel">SUBIR FOTO</div>
              <input type="file" class="nuevaFoto" name="nuevaFoto">
              <p class="help-block">Peso maximo de la foto 2 Mb.</p>
              <img src="vistas/img/usuarios/default.jpg" class="img-thumbnail previsualizar" width="100px">  
            </div>
          </div>
        </div>
        <!-- Pie del Modal -->
        <div class="modal-footer">          
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>          
          <button type="submit" class="btn btn-primary">Guardar Usuario</button>
        </div>
        <?php 
        $crearUsuario = new ControladorUsuarios();
        $crearUsuario -> ctrCrearUsuario();
        ?>
      </form> 
    </div>
  </div>
</div>
<!-- Fin Agregar Usuario --> 

<!-- Comienzo Modal para Editar Usuario -->
<!-- la clase fade es la que da la sensacion de desvanecimiento  -->
<div id="modalEditarUsuario" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
    <form role="form" method="POST" enctype="multipart/form-data" id="formEditarUsuario" novalidate> 
        <!-- Cabeza del Modal -->
        <div class="modal-header" style="background: #3c8dbc; color: white">        
          <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
          <h4 class="modal-title">Editar Administrador</h4>
        </div>
        <!-- Cuerpo del Modal -->
        <div class="modal-body">          
          <div class="box-body">
            <!-- Editar nombre -->
            <div class="form-group" id="nombreE">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="fa fa-user" style="width: 15px"></i>
                </span>
                <input class="form-control input-lg" type="text" id="editarNombre" name="editarNombre" value="">              
              </div>            
            </div>
            <!-- Leer Usuario -->
            <div class="form-group" id="usuarioE">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="fa fa-key" style="width: 15px"></i>
                </span>
                <input class="form-control input-lg" type="text" id="editarUsuario" name="editarUsuario" value="" readonly>             
              </div>            
            </div>
            <!-- Ingresar Email-->
            <div class="form-group" id="correoE">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="fa fa-envelope" style="width: 15px"></i>
                </span>
                <input class="form-control input-lg" type="email" id="editarEmail" name="editarEmail" value="" readonly>
              </div>
            </div>
            <!-- Editar Contraseña -->
            <div class="form-group" id="passwordE">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="fa fa-lock" style="width: 15px"></i>
                </span>
                <input class="form-control input-lg" type="password" name="editarPassword" placeholder="Ingresar la nueva contraseña" autocomplete="noCompletar">
                <input type="hidden" id="passwordActual" name="passwordActual">
              </div>            
            </div>
            <!-- Editar Perfil (tipo de usuario) -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="fa fa-users" style="width: 15px"></i>
                </span> 
                <input type="hidden" id="perfilActual" name="perfilActual" value="Administrador"> 
                <select class="form-control input-lg" name="editarPerfil" required> 
                  <option value="Administrador">Administrador</option>
                  <option value="Administrador">Administrador</option>                  
                  <option value="Vendedor">Vendedor</option>
                </select>             
              </div>            
            </div>
            <!-- Editar Foto -->
            <div class="form-group">
              <div class="panel">SUBIR FOTO</div>
              <input type="file" class="nuevaFoto" name="editarFoto">
              <p class="help-block">Peso maximo de la foto 2 Mb.</p>
              <img src="vistas/img/usuarios/default.jpg" class="img-thumbnail previsualizar" width="100px">
              <input type="hidden" id="fotoActual" name="fotoActual">
            </div>
          </div>
        </div>
        <!-- Pie del Modal -->
        <div class="modal-footer">          
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>          
          <button type="submit" class="btn btn-primary">Modificar Usuario</button>        
        </div>        
        <?php         
        $editarUsuario = new ControladorUsuarios();
        $editarUsuario -> ctrEditarUsuario();        
        ?>        
      </form>  
    </div>
  </div>
</div>
<!-- Fin Agregar Usuario --> 
<?php  
 $borrarAdministrador = new ControladorUsuarios();
 $borrarAdministrador -> ctrBorrarUsuario();  
?>