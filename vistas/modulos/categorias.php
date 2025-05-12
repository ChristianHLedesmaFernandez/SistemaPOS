<?php 
if($_SESSION["perfil"] == "Vendedor"){
  echo '<script>
          window.location = "inicio";
        </script>';
  return;
}
?>
<div class="content-wrapper">
  <!-- Encabezado de contenido (encabezado de página) -->
  <section class="content-header">
    <h1>
      Categorias
      <small>Administrar Categorias</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="inicio"><i class="fa fa-dashboard"></i>Inicio</a></li>        
      <li class="active">Categorias</li>
    </ol>
  </section>
  <!-- Fin Encabezado de contenido -->
  <!-- Contenido principal  -->
  <section class="content">
    <!-- Caja predeterminada -->
    <div class="box">
      <div class="box-header with-border">
        <button class="btn btn-primary btnModal" data-toggle="modal" data-target="#modalAgregarCategoria">
          Agregar Categoria
        </button>
      </div>
      <!-- Cuerpo de la Pagina -->
      <div class="box-body">
        <table class="table table-bordered table-striped dt-responsive tablas" width="100%">           
          <thead>
           <tr>
             <th style="width: 10px">#</th>
             <th>Categoria</th>
             <th>Acciones</th>
           </tr>
          </thead> 
          <tbody>
          <?php 
            $item = NULL;
            $valor =NULL;
            $categorias = ControladorCategorias:: ctrMostrarCategorias($item, $valor);
            foreach ($categorias as $key => $value) {
              echo '<tr>            
                      <td style="vertical-align : middle;">'.($key+1).'</td>
                      <td style="vertical-align : middle;">'.$value["categoria"].'</td>
                      <td>
                        <div class="btn-group">                
                          <button class="btn btn-warning btnEditarCategoria btnModal" idCategoria="'.$value["id_cat"].'" data-toggle="modal" data-target="#modalEditarCategoria"><i class="fa fa-pencil"></i></button>';
              if($_SESSION["perfil"] == "Administrador"){
                echo '
                          <button class="btn btn-danger btnEliminarCategoria" idCategoria="'.$value["id_cat"].'"><i class="fa fa-times"></i></button>';
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
      <!-- Fin box-body -->
    </div>
    <!-- /. Fin Caja predeterminada -->
  </section>
  <!-- Fin Contenido principal -->
</div>
<!-- Comienzo Modal para Agregar Categoria -->
<div id="modalAgregarCategoria" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
    <form role="form" method="POST" id="formAgregarCategoria" novalidate> <!-- class="needs-validation" -->
        <!-- Cabeza del Modal -->
        <div class="modal-header" style="background: #3c8dbc; color: white">        
          <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
          <h4 class="modal-title">Agregar Categoría</h4>
        </div>
        <!-- Cuerpo del Modal -->
        <div class="modal-body">          
          <div class="box-body">
            <!-- Ingresar Categoria -->
            <div class="form-group has-feedback" id="categoria">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="fa fa-th"></i>
                </span>
                <input class="form-control input-lg" type="text" id="nuevaCategoria" name="nuevaCategoria" placeholder="Ingresar categoria" required autofocus>
              </div>                
            </div>
          </div>
        </div>
        <!-- Pie del Modal -->
        <div class="modal-footer">          
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Guardar Categoría</button> 
        </div>
        <?php
          $crearCategoria = new ControladorCategorias();
          $crearCategoria -> ctrCrearCategoria();
         ?>
      </form> 
    </div>
  </div>
</div>
<!-- Fin Agregar Categoria --> 
<!-- Comienzo Modal para Editar Categoria -->
<div id="modalEditarCategoria" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
    <form role="form" method="POST" id="formEditarCategoria" novalidate> <!-- class="needs-validation" -->
        <!-- Cabeza del Modal -->
        <div class="modal-header" style="background: #3c8dbc; color: white">        
          <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
          <h4 class="modal-title">Editar Categoría</h4>
        </div>
        <!-- Cuerpo del Modal -->
        <div class="modal-body">          
          <div class="box-body">
            <!-- Ingresar Categoria -->
            <div class="form-group" id="categoria2">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="fa fa-th"></i>
                </span>
                <input class="form-control input-lg" type="text" name="editarCategoria" id="editarCategoria" required> 
                <input type="hidden"class="form-control input-lg" name="idCategoria" id="idCategoria">             
              </div> 
            </div>
          </div>
        </div>
        <!-- Pie del Modal -->
        <div class="modal-footer">          
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>          
          <button type="submit" class="btn btn-primary" id="btnEditarCategoria">Guardar Cambios</button>
        </div>      
        <?php 
          $editarCategoria = new ControladorCategorias();
          $editarCategoria -> ctrEditarCategoria();
         ?>      
      </form> 
    </div>
  </div>
</div>
<!-- Fin Editar Categoria --> 
<?php   
  $borrarCategoria = new ControladorCategorias();
  $borrarCategoria -> ctrBorrarCategoria();
?>