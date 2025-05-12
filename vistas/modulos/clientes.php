<?php
if($_SESSION["perfil"] == "Vendedor"){
  echo '<script>
          window.location = "inicio";
        </script>';
  return;
}
?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Clientes
      <small>Administrar Clientes</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i>Inicio</a></li>        
      <li class="active">Clientes</li>
    </ol>
  </section>
    <section class="content">
    <div class="box">
      <div class="box-header with-border">
        <button class="btn btn-primary btnModal btnNuevoCliente" data-toggle="modal" data-target="#modalAgregarCliente">
          Agregar Clientes
        </button>
      </div>
      <div class="box-body">
        <table class="table table-bordered table-striped dt-responsive tablas" width="100%">          
          <thead>
           <tr>
             <th style="width: 10px">#</th>
             <th>Nombre</th>
             <th>Apellido</th>
             <th>Email</th>
             <th>Teléfono</th>
             <th>estado</th>
             <th>Saldo</th>
             <th>Ultima Compra</th> 
             <th>Ultimo Ingreso</th> 
             <th>Acciones</th>
           </tr>
          </thead> 
          <tbody>
          <?php
            $item = NULL;
            $valor = NULL;
            $clientes = controladorClientes::ctrMostrarUsuarios($item, $valor);
            foreach ($clientes as $key => $value) {
              echo '<tr>            
                        <td style="vertical-align : middle;">'.($key +1).'</td>
                        <td style="vertical-align : middle;">'.$value["nombre"].'</td>
                        <td style="vertical-align : middle;">'.$value["apellido"].'</td>
                        <td style="vertical-align : middle;">'.$value["correo"].'</td>
                        <td style="vertical-align : middle;">'.$value["telefono"].'</td>';
              // Muestros los estados
              // Volver al estado anterior
              $estadoAnterior = 4 + $value["estado"];
              // Fin Estado anterior
              switch($value["estado"]){
                  case -1: 
                  case  0:
                    echo '<td style="vertical-align : middle; text-align:center;"><button class="btn btn-danger btn-xs btnActivar" idUsuario="'. $value["id"] .'" estadoUsuario="'.$estadoAnterior.'" usuarios="clientes">Desactivado</button></td>';
                    break;
                  case 1: 
                      echo '<td style="vertical-align : middle; text-align:center;"><a href="solicitudes" class="btn btn-info btn-xs">Aceptar Solicitud</a></td>';
                      break;
                   case 2:                         
                      echo '<td style="vertical-align : middle; text-align:center;"><button class="btn btn-warning btn-xs">Pendiente de Activacion</button></td>';
                      break;
                  case 3:
                      echo '<td style="vertical-align : middle; text-align:center;"><button class="btn btn-success btn-xs btnActivar" idUsuario="'. $value["id"] .'" estadoUsuario="-1" usuarios="clientes">activado</button></td>';
                      break;
                  case 4:                         
                      echo '<td style="vertical-align : middle; text-align:center;"><button class="btn btn-success btn-xs btnActivar" idUsuario="'. $value["id"] .'" estadoUsuario="0" usuarios="clientes">Activado</button></td>';
                      break;                          
                      }          
              // Fin Estados


              echo     '<td style="vertical-align : middle;">'.$value["saldo"].'</td>
                        <td style="vertical-align : middle;">'.$value["ultima_compra"].'</td>              
                        <td style="vertical-align : middle;">'.$value["last_session"].'</td>
                        <td align="center">
                          <div class="btn-group">                
                            <button class="btn btn-warning btnEditarCliente btnModal" data-toggle="modal" data-target="#modalEditarCliente" idCliente="'.$value["id"].'"><i class="fa fa-pencil"></i></button>';              
              if($_SESSION["perfil"] == "Administrador"){
                echo '        
                            <button class="btn btn-danger"><i class="fa fa-times btnEliminarUsuario" idUsuario="'. $value["id"] .'" fotoUsuario="'. $value["foto"] .'" usuario="'. $value["usuario"] .'" perfil="clientes"></i></button>
                          </div>
                        </td>
                      </tr>';
              }
            }
          ?>
          </tbody>
        </table>
      </div>
    </div>
  </section>
</div>

<!-- Comienzo Modal para Agregar Cliente -->
<div id="modalAgregarCliente" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
    <form role="form" method="POST" id="formAgregarCliente" novalidate>
        <div class="modal-header" style="background: #3c8dbc; color: white">
          <h4 class="modal-title">Agregar Cliente</h4>
        </div>
        <div class="modal-body">          
          <div class="box-body">
            <!-- Ingresar Nombre -->
            <div class="form-group" id = nombre>
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="fa fa-user"></i>
                </span>
                <input class="form-control input-lg" type="text" id="nuevoNombre" name="nuevoNombre" placeholder="Ingresar Nombre" required>              
              </div>

            </div>
            <!-- Ingresar Apellido 
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="fa fa-user"></i>
                </span>
                <input class="form-control input-lg" type="text" id="nuevoApellido" name="nuevoApellido" placeholder="Ingresar Apellido">            
              </div>
            </div> -->
            <!-- Ingresar Usuario -->
            <div class="form-group" id="usuario">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="fa fa-key"></i>
                </span>
                <input class="form-control input-lg" type="text" name="nuevoUsuario" placeholder="Ingresar usuario" id="nuevoUsuario" required>              
              </div>            
            </div>
            <!-- Ingresar Email-->
            <div class="form-group" id="correo">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="fa fa-envelope"></i>
                </span>
                <input class="form-control input-lg" type="email" id="nuevoEmail" name="nuevoEmail" placeholder="Ingresar Correo Electronico">
              </div>
            </div>
            <!-- Ingresar Telefono-->
            <div class="form-group" id="telefono">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="fa fa-phone"></i>
                </span>
                <input class="form-control input-lg" type="text" id="nuevoTelefono" name="nuevoTelefono" placeholder="Ingresar Telefono" data-inputmask="'mask':'(999) 9999-9999'" data-mask>
              </div>
            </div>
            <!-- Seleccionar Local -->
            <div class="form-group" id="local">
              <div class="input-group" id="nuevoAgregarNombre">
                <span class="input-group-addon">
                  <i class="fa fa-building-o"></i>
                </span>
                <select class="form-control input-lg" id="nuevoLocal" name="nuevoLocal" required> 
                  <!-- Llenar el SELECT -->
                    <option value="">Seleccionar un Local</option>
                    <?php
                      $item = NULL;
                      $valor =NULL;
                      $locales = ControladorLocales:: ctrMostrarLocales($item, $valor);
                      foreach ($locales as $key => $value) {
                        echo "<option value = ".$value['id_local'].">";
                        echo utf8_encode($value['nombre']); 
                        echo "</option>";
                      }                                          
                    ?>                   
                    <option value="0">Ninguno</option>
                    <option value="agregarlocal">Agregar Local</option>
                    <!-- Fin llenar -->
                </select> 
              </div>            
            </div>
          </div>
        </div>
        <div class="modal-footer">          
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>          
          <button type="submit" class="btn btn-primary">Guardar Cliente</button>
        </div>
      </form>
      <?php 
      $crearCliente = new ControladorClientes();
      $crearCliente -> ctrCrearCliente();
       ?>
    </div>
  </div>
</div>
<!-- Fin Agregar Cliente --> 

<!-- Comienzo Modal para Editar Cliente -->
<div id="modalEditarCliente" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
    <form role="form" method="POST" id="formEditarCliente" novalidate>
        <!-- Cabeza del Modal -->
        <div class="modal-header" style="background: #3c8dbc; color: white">        
          <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
          <h4 class="modal-title">Editar Cliente</h4>
        </div>
        <!-- Cuerpo del Modal -->
        <div class="modal-body">          
          <div class="box-body">
            <!-- Editar Nombre -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="fa fa-user"></i>
                </span>
                <input class="form-control input-lg" type="text" id="editarNombre" name="editarNombre" required> 
                <input type="hidden" id="idCliente" name="idCliente">             
              </div>
            </div>
            <!-- Ingresar Apellido 
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="fa fa-user"></i>
                </span>
                <input class="form-control input-lg" type="text" id="nuevoApellido" name="nuevoApellido" placeholder="Ingresar Apellido">            
              </div>
            </div> -->
            <!-- Usuario -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="fa fa-key"></i>
                </span>
                <input class="form-control input-lg" type="text" name="editarUsuario" id="editarUsuario" readonly>
                <input type="hidden" id="tokenActual" name="tokenActual" value=""> 
                <input type="hidden" id="passwordActual" name="passwordActual" value="">             
              </div>            
            </div>
            <!-- Editar Email-->
            <div class="form-group" id="correo2">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="fa fa-envelope"></i>
                </span>

                <input class="form-control input-lg" type="email" id="editarEmail" name="editarEmail">

              </div>
            </div>
            <!-- Editar Telefono-->
            <!-- Utilizamos plugin  Input Mask (para formatear entradas) -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="fa fa-phone"></i>
                </span>
                <input class="form-control input-lg" type="text" id="editarTelefono" name="editarTelefono" data-inputmask="'mask':'(999) 9999-9999'" data-mask>
              </div>
            </div>
            <!-- Editar Local -->
            <div class="form-group" id="local">
              <div class="input-group" id="editarAgregarNombre">
                <span class="input-group-addon">
                  <i class="fa fa-building-o"></i>
                </span>
                
                <input type="hidden" id="localActual" name="localActual" value="">

                <select class="form-control input-lg" id="editarLocal" name="editarLocal" required>
                  <!-- Llenar el SELECT -->
                    <option value="" id="idLocal" name="idLocal">Seleccionar un Local</option>
                    <?php
                      $item = NULL;
                      $valor =NULL;
                      $locales = ControladorLocales:: ctrMostrarLocales($item, $valor);
                      foreach ($locales as $key => $value){
                        echo "<option value = ".$value['id_local'].">";
                        echo utf8_encode($value['nombre']); 
                        echo "</option>";
                      }                     
                    ?>                   
                    <option value="0">No Definido</option>
                    <option value="agregarlocal">Agregar Local</option>
                    <!-- Fin llenar -->
                </select> 
              </div>            
            </div>
          </div>
        </div>
        <!-- Pie del Modal -->
        <div class="modal-footer">          
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>          
          <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </div>
      </form>
      <?php 

      $editarCliente = new ControladorClientes();
      $editarCliente -> ctrEditarCliente();

       ?>  

    </div>

  </div>

</div>
<!-- Fin Editar Cliente --> 
<?php 
  $borrarCliente = new ControladorUsuarios();
 $borrarCliente -> ctrBorrarUsuario();
?>