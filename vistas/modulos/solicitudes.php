<?php 
if($_SESSION["perfil"] == "Cliente" || $_SESSION["perfil"] == "Vendedor" ){
  echo '<script>
          window.location = "inicio";
        </script>';
  return;
}
?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Solicitudes
      <small>Administrar Solicitudes de Registro</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="inicio"><i class="fa fa-dashboard"></i>Inicio</a></li>        
      <li class="active">Solicitudes</li>
    </ol>
  </section>
  <section class="content">
    <div class="box">
      <div class="box-body">
        <table class="table table-bordered table-striped dt-responsive tablas" width="100%">             
          <thead>
            <tr>
              <th style="width: 10px">#</th>
              <th>Nombre</th>
              <th>Usuario</th>
              <th>Correo</th>
              <th>Acciones</th>
            </tr> 
          </thead> 
          <tbody>    
            <?php             
            $item = "estado";
            $valor = 1;
            //$usuarios = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);
            $solicitudes = ControladorSolicitudes::ctrMostrarUsuarios($item, $valor);
            foreach ($solicitudes as $key => $value){
              echo '<tr>  
                      <td style="vertical-align : middle;">'. ($key+1) .'</td>
                      <td style="vertical-align : middle;">'. $value["nombre"] .'</td>
                      <td style="vertical-align : middle;">'. $value["usuario"] .'</td>
                      <td style="vertical-align : middle;">'. $value["correo"] .'</td>
                      <td>
                        <div class="btn-group">
                          <button class="btn btn-warning btnAceptarSolicitud" idUsuarioA="'. $value["id"] .'" usuario="'. $value["usuario"] .'" nombreA="'. $value["nombre"] .'" emailA="'. $value["correo"] .'" tokenA="'. $value["token"] .'" data-toggle="modal" data-target="#aceptarSolicitud">
                              <i class="glyphicon glyphicon-ok"></i>
                          </button>
                          <button class="btn btn-danger btnRechazarSolicitud" idUsuarioR="'. $value["id"] .'" usuario="'. $value["usuario"] .'" nombreR="'. $value["nombre"] .'" emailR="'. $value["correo"] .'" data-toggle="modal" data-toggle="modal" data-target="#rechazarSolicitud">
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
    </div>
  </section>
</div>
<!-- Comienzo de Modal Aceptar Solicitud -->
<div id="aceptarSolicitud" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
    <form role="form" method="POST" enctype="multipart/form-data"> 
        <div class="modal-header" style="background: #3c8dbc; color: white">        
          <h4 class="modal-title">Aceptar Solicitud</h4>
        </div>
        <div class="modal-body">          
          <div class="box-body">
            <div class="form-group">
              <div class="input-group">
                ¿Esta seguro que desea Aceptar la Solicitud?
                <!-- Campos invisibles -->                             
                <input type="hidden" class="form-control" id="idUsuarioA" name="idUsuarioA"> 
                <input type="hidden" class="form-control" id="nombreA" name="nombreA">                            
                <input type="hidden" class="form-control" id="emailA" name="emailA">
                <input type="hidden" class="form-control" id="tokenA" name="tokenA">
                <!-- Fin campos invisibles -->
              </div>            
            </div>
          </div>
        </div>
        <div class="modal-footer">          
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>          
          <button type="submit" class="btn btn-success">Aceptar</button>        
        </div>        
        <?php         
        $aceptarSolicitud = new ControladorSolicitudes();
        $aceptarSolicitud -> ctrAceptarSolicitud();        
        ?>        
      </form>  
    </div>
  </div>
</div>
<!-- Fin de Modal Aceptar -->
<!-- Comienzo de Modal Rechazar Solicitud -->   
<div id="rechazarSolicitud" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
    <form role="form" method="POST" enctype="multipart/form-data">
        <div class="modal-header" style="background: #3c8dbc; color: white">  
          <h4 class="modal-title">Rechazar Solicitud</h4>
        </div>
        <div class="modal-body">          
          <div class="box-body">
             <div class="form-group">
              <div class="input-group">
                <!-- Campos invisibles -->                              
                <input type="hidden" class="form-control" id="idUsuarioR" name="idUsuarioR"> 
                <input type="hidden" class="form-control" id="nombreR" name="nombreR">                           
                <input type="hidden" class="form-control" id="emailR" name="emailR">
                <!-- Fin campos invisibles -->              
                <label for= "message-text" class= "col-form-label" >¿Desea adjuntar un mensaje?</label> 
                <textarea style="margin: 0px; width: 550px; height: 60px; resize:none" class="form-control" name="mensaje" placeholder="Escriba un Mensaje..." ></textarea>                
              </div>            
            </div>
          </div>
        </div>
        <div class="modal-footer">          
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>          
          <button type="submit" class="btn btn-danger">Rechazar</button>        
        </div>        
        <?php         
        $rechazarSolicitud = new ControladorSolicitudes();
        $rechazarSolicitud -> ctrRechazarSolicitud();       
        ?>        
      </form>  
    </div>
  </div>
</div>
<!-- Fin Agregar Usuario --> 