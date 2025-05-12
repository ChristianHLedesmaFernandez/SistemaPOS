<?php 
// Para que el fondo sea aleatorio.
$fondosArray = array("vistas/img/plantilla/fondo0.jpg",
                     "vistas/img/plantilla/fondo1.jpg", 
                     "vistas/img/plantilla/fondo2.jpg", 
                     "vistas/img/plantilla/fondo3.jpg", 
                     "vistas/img/plantilla/fondo4.jpg",
                     "vistas/img/plantilla/fondo5.jpg",
                     "vistas/img/plantilla/fondo6.jpg",
                     "vistas/img/plantilla/fondo7.jpg",
                     "vistas/img/plantilla/fondo8.jpg",
                     "vistas/img/plantilla/fondo9.jpg",
                    ); 
$fondo = rand(0, (count($fondosArray)-1));
// Fin Fondo Aleatorio
// Valida el token y el id
$validar = new ControladorUsuarios();
$validar -> ctrValidarTokenPass();
?>
 <!-- Estilo para hacer el Fondo Aleatorio -->
<div style=" 
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 110%;
            background: url('<?php echo $fondosArray[$fondo]; ?>');
            background-size: cover;
            overflow: hidden;
            z-index: -1;"></div>


<div class="register-box">

  <div class="register-logo">
    <img src="vistas/img/plantilla/willycafe.png" class="img-responsive" style="padding: 10px 0px">
  </div>

  <div class="register-box-body">
    <p class="login-box-msg">Cambiar Password</p>

    <form method="POST">

      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Ingrese nuevo Password" name="password" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Repita password" name="rePassword" required>
        <span class="glyphicon glyphicon-repeat form-control-feedback"></span>
      </div>
      <!-- Campos ocultos oculto -->
        <input type="hidden" id="user_id" name="user_id" value ="<?php echo $_GET['user_id']; ?>" />
          
        <input type="hidden" id="token" name="token" value ="<?php echo $_GET['token']; ?>" />
      <!-- Fin cammpos ocultos -->
      <div class="row">

        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Registrar</button>
        </div>
      
      </div>

      <?php 
        // Ejecuto el Metodo Cambiar Password 
        $registrar = new ControladorUsuarios();
        $registrar -> ctrCambiarPassword();
      ?>
   
    </form>

  </div>
  <!-- /.form-box -->
</div>