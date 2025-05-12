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
      Productos
      <small>Administrar Productos</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i>Inicio</a></li>        
      <li class="active">Productos</li>
    </ol>
  </section>
  <section class="content">
    <div class="box">
      <div class="box-header with-border">
        <button class="btn btn-primary btnModal" data-toggle="modal" data-target="#modalAgregarProducto">
          Agregar Productos
        </button>
      </div>
      <div class="box-body">  
        <table class="table table-bordered table-striped dt-responsive tablaProductos" width="100%">           
          <thead>
           <tr>
             <th style="width: 10px">#</th>
             <th>Codigo</th> 
             <th>Imagen</th> 
             <th>Categoria</th>  
             <th>Descripcion</th>          
             <th>Stock</th>
             <th>Precio de Venta</th>
             <th>Acciones</th>
           </tr>  
          </thead>                 
        </table>
      </div>      
    </div>
  </section>
</div>

<!-- Comienzo Modal para Agregar Producto -->
<!-- la clase fade es la que da la sensacion de desvanecimiento  -->
<div id="modalAgregarProducto" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
    <form role="form" method="POST" enctype="multipart/form-data" id="formAgregarProducto" novalidate> <!-- -->
        <!-- Cabeza del Modal -->
        <div class="modal-header" style="background: #3c8dbc; color: white">        
          <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
          <h4 class="modal-title">Agregar Producto</h4>
        </div>
        <!-- Cuerpo del Modal -->
        <div class="modal-body">          
          <div class="box-body">
            <!-- Ingresar Categoria -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="fa fa-th"></i>
                </span>
                <select class="form-control input-lg" id="nuevaCategoria" name="nuevaCategoria" required>                  
                  <option value="">Seleccionar Categoria</option>
                  <?php 
                    $item = NULL;
                    $valor = NULL;
                    $categorias = ControladorCategorias::ctrMostrarCategorias($item, $valor);
                    foreach ($categorias as $key => $value) {
                      echo '<option value="'.$value["id_cat"].'">'.$value["categoria"].'</option>';
                    }
                   ?>
                </select>              
              </div>            
            </div>
            <!-- Ingresar Codigo -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="fa fa-barcode" style="width: 15px"></i>
                </span>
                <input class="form-control input-lg" type="text" id="nuevoCodigo" name="nuevoCodigo" placeholder="Ingresar codigo" readonly required>              
              </div>            
            </div>
            <!-- Ingresar Descripcion -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="fa fa-product-hunt" style="width: 15px"></i>
                </span>
                <input class="form-control input-lg" type="text" name="nuevaDescripcion" placeholder="Ingresar descripcion" required>
              </div>            
            </div>            
            <!-- Ingresar Stock -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="fa fa-check" style="width: 15px"></i>
                </span>
                <input class="form-control input-lg" type="number" name="nuevoStock" min="0" placeholder="Ingresar Stock" required>
              </div>            
            </div>
            <!-- Ingresar Precios Venta -->
            <div class="form-group row">
              <!-- Compra 
              <div class="col-xs-6">                
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="fa fa-arrow-up"></i>
                  </span>
                  <input class="form-control input-lg" type="number" id="nuevoPrecioCompra" name="nuevoPrecioCompra" min="0" step="any" placeholder="Precio de compra" required>
                </div> 
              </div>
              -->
              <!-- Venta -->
              <div class="col-xs-12 col-sm-6">                            
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="fa fa-arrow-down" style="width: 15px"></i>
                  </span>
                  <input class="form-control input-lg" type="number" id="nuevoPrecioVenta" name="nuevoPrecioVenta" step="any" placeholder="Precio de venta" required>
                </div> 
                <br>
              </div>           
            </div>
            <!-- Subir Foto -->
            <div class="form-group">
              <div class="panel">SUBIR IMAGEN</div>
              <input type="file" class="nuevaImagen" name="nuevaImagen">
              <p class="help-block">Peso maximo de la foto 2Mb.</p>
              <img src="vistas/img/productos/default/anonymous.png" class="img-thumbnail previsualizar" width="100px">            
            </div>
          </div>
        </div>
        <!-- Pie del Modal -->
        <div class="modal-footer">          
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>          
          <button type="submit" class="btn btn-primary">Guardar Producto</button>
        </div>
      </form>
      <?php
        $crearProducto = new ControladorProductos();
        $crearProducto -> ctrCrearProducto();

      ?>
    </div>
  </div>
</div><!-- Fin Agregar Usuario -->

<!-- Comienzo Modal para Editar Producto -->
<div id="modalEditarProducto" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
    <form role="form" method="POST" enctype="multipart/form-data" id="formEditarProducto" novalidate> <!-- class="needs-validation" -->
        <div class="modal-header" style="background: #3c8dbc; color: white"> 
          <h4 class="modal-title">Editar Producto</h4>
        </div>
        <div class="modal-body">          
          <div class="box-body">
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="fa fa-th" style="width: 15px"></i>
                </span>                
                <input class="form-control input-lg" type="text" id="editarCategoria" name="editarCategoria" readonly>
                <input type="hidden" id="idCategoria" name="idCategoria">                
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="fa fa-barcode" style="width: 15px"></i>
                </span>
                <input class="form-control input-lg" type="text" id="editarCodigo" name="editarCodigo" readonly required>
              </div>            
            </div>
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="fa fa-product-hunt" style="width: 15px"></i>
                </span>
                <input class="form-control input-lg" type="text" id="editarDescripcion" name="editarDescripcion" required>
              </div>            
            </div>
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="fa fa-check" style="width: 15px"></i>
                </span>
                <input class="form-control input-lg" type="number" id="editarStock" name="editarStock" min="0" required>
              </div>            
            </div>
            <div class="form-group row">
              <div class="col-xs-12 col-sm-6">                            
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="fa fa-arrow-down" style="width: 15px"></i>
                  </span>
                  <input class="form-control input-lg" type="number" id="editarPrecioVenta" name="editarPrecioVenta" step="any" required>
                </div>
              </div>           
            </div>
            <div class="form-group">
              <div class="panel">SUBIR IMAGEN</div>
              <input type="file" class="nuevaImagen" name="editarImagen">
              <p class="help-block">Peso maximo de la foto 2Mb.</p>
              <img src="vistas/img/productos/default/anonymous.png" class="img-thumbnail previsualizar" width="100px">
              <input type="hidden" id="imagenActual" name="imagenActual">              
            </div>
          </div>
        </div>
        <div class="modal-footer">          
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>          
          <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </div>
      </form>
      <?php
        $editarProducto = new ControladorProductos();
        $editarProducto -> ctrEditarProducto();
      ?> 
    </div>
  </div>
</div>
<?php
  $borrarProducto = new ControladorProductos();
  $borrarProducto -> ctrBorrarProducto();
?>