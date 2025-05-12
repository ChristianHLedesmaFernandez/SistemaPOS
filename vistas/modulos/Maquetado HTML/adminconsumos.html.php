<div class="content-wrapper">
  <!-- Encabezado de contenido (encabezado de página) -->
  <section class="content-header">
    <h1>
      Ventas
      <small>Administrar Ventas</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="inicio"><i class="fa fa-dashboard"></i>Inicio</a></li>
      <li>Ventas</li>            
      <li class="active">Administrar</li>
    </ol>
  </section>
  <!-- Fin Encabezado de contenido -->
  <!-- Contenido principal  -->
  <section class="content">

    <!-- Caja predeterminada -->
    <div class="box">

      <div class="box-header with-border">
        <a href="crear-consumo">
          <button class="btn btn-primary">
              Agregar Ventas
          </button>
        </a>
        <!-- Comienzo Boton de Rango de Fecha -->
        <button type="button" class="btn btn-default pull-right" id="daterange-btn">          
          <span>
            <i class="fa fa-calendar"></i> Rango de Fecha
          </span> 
            <i class="fa fa-caret-down"></i>
        </button>
        <!-- Fin Boton de Rango -->
      </div>
      <!-- Cuerpo de la Pagina -->
      <div class="box-body">
        <table class="table table-bordered table-striped dt-responsive tablas" width="100%"> 
          
          <thead>
            <!-- Ver como quedan los titulos centrados. -->
           <tr>
             <th style="width: 10px">#</th>
             <th>Codigo Factura</th>
             <th>Cliente</th>
             <th>Vendedor</th>
             <!-- <th>Forma de Pago</th> -->
             <th>Neto</th>
             <th>Total</th>
             <th>Fecha</th>
             <th style="text-align: center;">Acciones</th>

           </tr>            

          </thead> 

          <tbody>


        <!-- Ejemplo de llenado  -->   
          <tr>            
            <td style="vertical-align : middle;">1</td>
            <td style="vertical-align : middle;">02458</td>
            <td style="vertical-align : middle;">Juan Villegas</td>
            <td style="vertical-align : middle;">Julio Gomez</td>
            <!-- <td style="vertical-align : middle;">Efectivo</td> -->
            <td style="vertical-align : middle;">1000</td>
            <td style="vertical-align : middle;">1190</td>
            <td style="vertical-align : middle;">02-10-2019</td>
            <td style="text-align: center;">
              <div class="btn-group">                
                <button class="btn btn-info"><i class="fa fa-print"></i></button>
                <button class="btn btn-danger"><i class="fa fa-times"></i></button>
              </div>
            </td>
          </tr>            

        <!-- Fin Ejemplo -->
            <?php 
/*
              if(isset($_GET["fechaInicial"])){

                $fechaInicial = $_GET["fechaInicial"];
                $fechaFinal =$_GET["fechaFinal"];

              }else{

                $fechaInicial = null;
                $fechaFinal = null;

              }

              //$respuesta = ControladorVentas:: ctrMostrarVentas($item, $valor);
              $respuesta = ControladorVentas:: ctrMostrarRangoFechasVentas($fechaInicial, $fechaFinal);
              
              foreach ($respuesta as $key => $value) {
                
                echo '<tr>            
                        <td style="vertical-align : middle;">'. ($key + 1) .'</td>
                        <td style="vertical-align : middle;">'. $value["codigo"] .'</td>';

                $itemCliente = "id";
                $valorCliente = $value["id_cliente"];

                $respuestaCliente = ControladorClientes:: ctrMostrarClientes($itemCliente, $valorCliente);

                echo '  <td style="vertical-align : middle;">'.$respuestaCliente["nombre"] .'</td>';

                $itemUsuario = "id";
                $valorUsuario = $value["id_vendedor"];

                $respuestaUsuario = ControladorUsuarios:: ctrMostrarUsuarios($itemUsuario, $valorUsuario);

                echo '  <td style="vertical-align : middle;">'. $respuestaUsuario["nombre"] .'</td>
                        <td style="vertical-align : middle;">'. $value["metodo_pago"] .'</td>
                        <td style="vertical-align : middle;">'. number_format($value["neto"], 2) .'</td>
                        <td style="vertical-align : middle;">'. number_format($value["total"], 2) .'</td>
                        <td style="vertical-align : middle;">'. $value["fecha"] .'</td>
                        <td style="text-align: center;">
                          <div class="btn-group">                
                            <button class="btn btn-info btnImprimirFactura" codigoVenta="'. $value["codigo"] .'">
                              <i class="fa fa-print"></i>
                            </button>';
                            
                if($_SESSION["perfil"] == "Administrador"){
                  echo '
                            <button class="btn btn-warning btnEditarVenta" idVenta="'. $value["id"] .'"><i class="fa fa-pencil"></i></button>
               
                            <button class="btn btn-danger btnEliminarVenta" idVenta="'. $value["id"] .'"><i class="fa fa-times"></i></button>
                          </div>
                        </td>
                      </tr>';
                }
              }
*/
            ?> 
       
          </tbody>       

        </table>
        <!-- Ejecutar eliminar Venta -->
         <?php

        //$eliminarVenta = new ControladorVentas();
        //$eliminarVenta -> ctrEliminarVenta();

        ?>
        
      </div>
      <!-- Fin box-body -->

    </div>
    <!-- /. Fin Caja predeterminada -->

  </section>
  <!-- Fin Contenido principal -->

</div>



