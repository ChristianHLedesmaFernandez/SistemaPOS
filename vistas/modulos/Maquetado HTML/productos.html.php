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
      Productos
      <small>Administrar Productos</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i>Inicio</a></li>        
      <li class="active">Productos</li>
    </ol>
  </section>
  <!-- Fin Encabezado de contenido -->
  <!-- Contenido principal  -->
  <section class="content">
    <!-- Caja predeterminada -->
    <div class="box">

      <div class="box-header with-border">

        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarProducto">
          Agregar Productos
        </button>

      </div>
      <!-- Cuerpo de la Pagina -->
      <div class="box-body">
        

        <table class="table table-bordered table-striped dt-responsive tablaProductos" width="100%"> 
          
          <thead>

           <tr>
             <th style="width: 10px">#</th>
             <th>Codigo</th> 
             <th>Imagen</th>             
             <th>nombre</th>
             <th>Descripcion</th>             
             <th>Stock</th>
             <th>Precio de Venta</th>
             <th>Acciones</th>
           </tr>            

          </thead> 

                    <tbody>
    
            <?php 
 

            $item = NULL;
            $valor = NULL;
            $orden = "id";

            $productos = ControladorProductos::ctrMostrarProductos($item, $valor, $orden);

            //var_dump($productos);
//<td> <img src="'.$value["foto"].'" width='80px'>  </td> 

            foreach ($productos as $key => $value) {

              echo '<tr>  

                      <td style="vertical-align : middle;">'. $value["id"] .'</td>

                      <td style="vertical-align : middle;">'. $value["codigo"] .'</td>';
                    
              if(!empty($value["imagen"])){
                echo '<td><img src="'. $value["imagen"] .'" class="img-thumbnail" width="40px"> </td>';
              }else{
                echo '<td><img src="vistas/img/productos/default.png" class="img-thumbnail" width="40px"> </td>';
              }

              echo '  <td style="vertical-align : middle;">'. $value["nombre_corto"] .'</td>
                      <td style="vertical-align : middle;">'. $value["nombre"] .'</td>
                      <td style="vertical-align : middle;">'. $value["stock"] .'</td>
                      <td style="vertical-align : middle;">'. $value["precio"] .'</td>
                      <td>
                        <div class="btn-group">

                          <button class="btn btn-warning btnEditarUsuario" idUsuario="'. $value["id"] .'" data-toggle="modal" data-target="#aceptarSolicitud">
                              <i class="glyphicon glyphicon-ok"></i>
                          </button>

                          <button class="btn btn-danger btnEditarUsuario" idUsuario="'. $value["id"] .'" data-toggle="modal" data-target="#rechazarSolicitud">
                              <i class="glyphicon glyphicon-remove"></i>
                          </button>

                        </div>
                      </td>

                    </tr>';

          
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

<!-- Comienzo Modal para Agregar Producto -->
<!-- la clase fade es la que da la sensacion de desvanecimiento  -->
<div id="modalAgregarProducto" class="modal fade" role="dialog">

  <div class="modal-dialog">

    <div class="modal-content">

    <form role="form" method="POST" enctype="multipart/form-data"> 
        <!-- Cabeza del Modal -->
        <div class="modal-header" style="background: #3c8dbc; color: white">        
          <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
          <h4 class="modal-title">Agregar Producto</h4>
        </div>
        <!-- Cuerpo del Modal -->
        <div class="modal-body">
          
          <div class="box-body">

            <!-- Ingresar Codigo -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="fa fa-barcode"></i>
                </span>
                <input class="form-control input-lg" type="text" id="nuevoCodigo" name="nuevoCodigo" placeholder="Ingresar codigo" readonly required>              
              </div>            
            </div>

            <!-- Ingresar Descripcion -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="fa fa-product-hunt"></i>
                </span>
                <input class="form-control input-lg" type="text" name="nuevaDescripcion" placeholder="Ingresar descripcion" required>              
              </div>            
            </div>            
            <!-- Ingresar Stock -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="fa fa-check"></i>
                </span>
                <input class="form-control input-lg" type="number" name="nuevoStock" min="0" placeholder="Ingresar Stock" required>              
              </div>            
            </div>
            <!-- Ingresar Preciossw Venta -->
            <div class="form-group row">
              <div class="col-xs-6">
                <!-- Compra -->
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="fa fa-arrow-up"></i>
                  </span>
                  <input class="form-control input-lg" type="number" id="nuevoPrecioCompra" name="nuevoPrecioCompra" min="0" step="any" placeholder="Precio de compra" required>
                </div> 
              </div>
              <div class="col-xs-6">
                <!-- Venta -->            
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="fa fa-arrow-down"></i>
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

          // $crearProducto = new ControladorProductos();
          // $crearProducto -> ctrCrearProducto();

        ?> 

    </div>

  </div>

</div>
<!-- Fin Agregar Usuario --> 