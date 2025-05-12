<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Crear Consumo
      <small>Consumos</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="inicio"><i class="fa fa-dashboard"></i>Inicio</a></li>
      <li>Consumos</li>
      <li class="active">Crear</li>
    </ol>
  </section>

  <section class="content">
    <!-- Formulario  -->
    <div class="row">
      <!-- Tabla de Ventas-->
      <div class="col-lg-5 col-xs-12">        
        <!-- Pinta una linea verde borde  -->
          <div class="box box-success">
            <!--  Dibbuja una franja en blanco  -->
            <div class="box-header with-border">
              <form role="form" method="POST" class="formularioConsumo">  
                <!-- Cuerpo del Modulo -->
                <div class="box-body">                
                  <div class="box">
                    <!-- Entrada Vendedor -->
                    <div class="form-group">
                      <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        <input type="text" class="form-control" id="nuevoVendedor" value="<?php echo($_SESSION["nombre"])?>" readonly>
                        <input type="hidden" name="idVendedor" value="<?php echo($_SESSION["id"])?>">
                      </div>
                    </div>
                    <!-- Entrada Codigo de Venta -->
                    <div class="form-group">
                      <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-barcode"></i></span>
                        <?php
                          $item = null;
                          $valor = null;
                          $consumos = ControladorConsumos::ctrMostrarConsumos($item, $valor);
                          if(!$consumos){
                            $codigo = 10001;
                          }else{
                            foreach ($consumos as $key => $value) {
                              
                            }
                            $codigo = $value["codigo"] + 1;                            
                          }
                          echo '<input type="text" class="form-control" id="nuevaVenta" name="nuevaVenta" value="'. $codigo .'" readonly>';
                        ?>                        
                      </div>
                    </div>
                    <!-- Entrada de Cliente -->
                    <div class="form-group">
                      <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-users"></i></span>
                        <select class="form-control seleccionarCliente" name="seleccionarCliente" id="seleccionarCliente" required>
                          <option value="">Seleccionar Cliente</option>
                          <?php
                          $item = NULL;
                          $valor = NULL;
                          $clientes = controladorClientes::ctrMostrarUsuarios($item, $valor);
                          foreach ($clientes as $key => $value) {
                            echo '<option value="'. $value["id"] .'">'. $value["nombre"] .' ' . $value["apellido"] .'</option>';
                          }
                          ?>
                        </select>                        
                          <span class="input-group-addon"><button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#modalAgregarCliente" data-dismiss="modal">Agregar Cliente</button></span>
                      </div>
                    </div>

                    <!-- Entrada para Agregar Producto --> <!--  hidden-md hidden-sm hidden-xs -->
                    <div class="form-group row nuevoProducto" style="width: 100%; height: 130px; overflow-y: auto; overflow-x: hidden;">                    
                    </div>
                    
                    <input type="hidden" id="listaProductos" name="listaProductos">

                    <!-- Boton para agregar Producto pantallas pequeñas -->
                    <button type="button" class="btn btn-default btnAgregarProducto hidden-lg">Agregar Producto</button>
                    <hr>

                    <!-- Total a Pagar -->
                    <div class="row">
                      <div class="col-xs-8 pull-right">
                        <table class="table">
                          <thead>
                            <tr>
                              <th>Descuento</th>
                              <th>Total</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <!-- Descuento -->
                              <td style="width:50%">
                                <div class="input-group">
                                  <input type="number" class="form-control input-lg" min="0" id="nuevoDescuentoVenta" name="nuevoDescuentoVenta" value="0" readonly>
                                  <input type="hidden" name="nuevoPrecioDescuento" id="nuevoPrecioDescuento" required>
                                  <input type="hidden" name="nuevoPrecioNeto" id="nuevoPrecioNeto" required>
                                  <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                                </div>
                              </td>
                              <!-- Total -->
                              <td style="width:50%">
                                <div class="input-group">
                                  <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>
                                  <input type="text" class="form-control input-lg" min="1" id="nuevoTotalVenta" name="nuevoTotalVenta" placeholder="00000" readonly required>
                                  <input type="hidden" id="totalVenta" name="totalVenta">
                                </div>
                              </td>

                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                    <hr>
                    <!-- Metodo de Pago -->
                    <div class="form-group row">
                      <div class="col-xs-6">
                       <div class="input-group">
                          <select class="form-control" name="nuevoMetodoPago" id="nuevoMetodoPago" required>
                            <option value="">Seleccione Metodo de Pago</option>
                            <option value="CuentaCorriente">Cuenta Corriente</option>
                            <option value="Efectivo">Efectivo</option>
                          <!--
                            <option value="tarjetaCredito">Tarjeta Credito</option>
                            <option value="tarjetaDebito">Tarjeta Debito</option>
                          -->
                          </select>                     
                        </div> 
                      </div>
                      <!-- Codigo de Transaccion
                      <div class="col-xs-6" style="padding-left: 0px">
                        <div class="input-group">                      
                          <input type="text" class="form-control" id="nuevoCodigoTransaccion" name="nuevoCodigoTransaccion" placeholder="Código de Transacción" required>
                          <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                        </div>                        
                      </div>
                       -->

                      <div class="cajasMetodoPago">  

                      </div>
                      

                    </div>
                    <br>
                  </div>
                </div>
                <!-- Pie del formulario -->
                <div class="box-footer">
                  <button type="submit" class="btn btn-primary pull-right">Guardar Consumo</button>                    
                </div>
              </form>
              <?php 
              $guardarConsumo = new ControladorConsumos();
              $guardarConsumo -> ctrCrearConsumo();
              ?>
            </div>
          </div>
        <!-- Fin Tabla Ventas -->
      </div>
      <div class="col-lg-7 hidden-md hidden-sm hidden-xs">
        <!-- Tabla de Productos para pantallas grandes-->
        <!-- Pinta una linea amarilla -->
          <div class="box box-warning">
            <!-- Dibuja una franja en blanco  -->
            <div class="box-header with-border">
              <div class="box-body">
                <table class="table table-bordered table-striped dt-responsive tablaConsumos" > <!-- data-page-length='6'-->
                <thead>
                 <tr>
                   <th style="width: 10px">#</th>                   
                   <th>Codigo</th>
                   <th>Imagen</th>
                   <th>Descripcion</th>
                   <th>Stock</th>
                   <th>Acciones</th>
                 </tr>
                </thead>
              </table>
              </div>
            </div>
          </div>
        <!-- Fin Tabla -->
      </div>
    <!-- Fin Formulario -->
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