<?php 
if($_SESSION["perfil"] == "Cliente"){
  echo '<script>
          window.location = "inicio";
        </script>';
  return;
}
?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Locales
      <small>Administrar Locales</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="inicio"><i class="fa fa-dashboard"></i>Inicio</a></li>        
      <li class="active">Locales</li>
    </ol>
  </section>
  <section class="content">
    <div class="box">
      <div class="box-header with-border">
        <button class="btn btn-primary btnModal" data-toggle="modal" data-target="#modalAgregarLocal">
          Agregar Local
        </button>
      </div>
      <div class="box-body">
        <table class="table table-bordered table-striped dt-responsive tablas" width="100%">           
          <thead>
           <tr>
             <th style="width: 10px">#</th>
             <th>Local</th>
             <th>Telefono</th>
             <th>Direccion</th>
             <th>Acciones</th>
           </tr>
          </thead> 
          <tbody>
          <?php          
            $item = NULL;
            $valor =NULL;
            $locales = ControladorLocales:: ctrMostrarLocales($item, $valor);
            foreach ($locales as $key => $value) {
              echo '<tr>            
                      <td style="vertical-align : middle;">'.($key+1).'</td>
                      <td style="vertical-align : middle;">'.$value["nombre"].'</td>
                      <td style="vertical-align : middle;">'.$value["telefono"].'</td>
                      <td style="vertical-align : middle;">'.$value["direccion"].'</td>
                      <td align="center">
                        <div class="btn-group" >         
                          <button class="btn btn-warning btnEditarLocal btnModal" idLocal="'.$value["id_local"].'" local="'. $value["nombre"] .'" telefono="'. $value["telefono"] .'" direccion="'. $value["direccion"] .'" data-toggle="modal" data-target="#modalEditarLocal"><i class="fa fa-pencil"></i></button>';
              if($_SESSION["perfil"] == "Administrador"){
                echo '
                          <button class="btn btn-danger btnEliminarLocal" idLocal="'.$value["id_local"].'"><i class="fa fa-times"></i></button>';
              }
              echo'
                        </div>
                      </td>
                    </tr> ';
            }           
           ?>
          </tbody>
        </table>
      </div>
    </div>
  </section>
</div>
<!-- Comienzo Modal para Agregar Local -->
<div id="modalAgregarLocal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
    <form role="form" method="POST" id="formAgregarLocal" novalidate>
        <div class="modal-header" style="background: #3c8dbc; color: white">
          <h4 class="modal-title">Agregar Local</h4>
        </div>
        <div class="modal-body">          
          <div class="box-body">
            <!-- Ingresar Nombre -->
            <div class="form-group" id="local">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="fa fa-building-o"></i>
                </span>
                <input class="form-control input-lg" type="text" id="nuevoLocal" name="nuevoLocal" placeholder="Ingresar Nombre" required autofocus>
              </div>  
            </div>
           <!-- Ingresar Telefono-->
            <div class="form-group" id="telefono">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="fa fa-phone"></i>
                </span>
                <input class="form-control input-lg" type="text" id="nuevoTelefono" name="nuevoTelefono" placeholder="Ingresar Telefono" data-inputmask="'mask':'(999) 9999-9999'" data-mask required>
              </div>
            </div>
            <!-- Ingresar Direccion -->
            <div class="form-group" id="direccion">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="fa fa-map-marker"></i>
                </span>
                <input class="form-control input-lg" type="text" id="nuevaDireccion" name="nuevaDireccion" placeholder="Ingresar Direccion" required autofocus>
              </div>  
            </div>
          </div>
        </div>
        <div class="modal-footer">          
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Guardar Local</button> 
        </div>
        <?php
          $crearLocal = new ControladorLocales();
          $crearLocal -> ctrCrearLocal();
         ?>
      </form> 
    </div>
  </div>
</div>
<!-- Fin Agregar Local --> 
<!-- Comienzo Modal para Editar Local -->
<div id="modalEditarLocal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
    <form role="form" method="POST" id="formEditarLocal" novalidate> 
        <div class="modal-header" style="background: #3c8dbc; color: white">
          <h4 class="modal-title">Editar Local</h4>
        </div>
        <div class="modal-body">          
          <div class="box-body">
            <!-- Editar nombre -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="fa fa-th"></i>
                </span>
                <input class="form-control input-lg" type="text" name="editarLocal" id="editarLocal" readonly> 
                <!--
                <input type="hidden"class="form-control input-lg" name="idLocal" id="idLocal"> 
                -->            
              </div> 
            </div>
            <!-- Editar Telefono-->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="fa fa-phone"></i>
                </span>
                <input class="form-control input-lg" type="text" id="editarTelefono" name="editarTelefono" data-inputmask="'mask':'(999) 9999-9999'" data-mask required>
              </div>
            </div>
            <!-- Editar Direccion-->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="fa fa-map-marker"></i>
                </span>
                <input class="form-control input-lg" type="text" id="editarDireccion" name="editarDireccion"required>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">          
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>          
          <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </div>      
        <?php 
          $editarLocal = new ControladorLocales();
          $editarLocal -> ctrEditarLocal();
         ?>      
      </form> 
    </div>
  </div>
</div>
<!-- Fin Editar Local --> 
<?php   
  //$borrarLocal = new ControladorLocales();
  //$borrarLocal -> ctrBorrarLocal();
?>
