<!-- <div id="back"></div> -->
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
?>
 <!-- Estilo para hacer el Fondo Aleatorio -->
<div style=" 
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('<?php echo $fondosArray[$fondo]; ?>');
            background-size: cover;
            overflow: hidden;
            z-index: -1;"></div>

<div class="login-box" style="margin-top: 25px">

  <div class="login-logo">
  <!--
    <a href="vistas/index2.html"><img src="vistas/img/plantilla/willycafe-mini.ico">
    <b>Willy</b>CAFE</a>
  --> 
    <img src="vistas/img/plantilla/willycafe.png" class="img-responsive" style="padding: 10px 0px">
 
  </div>
  <!-- Fin login-logo -->
  <div class="login-box-body">
    
    <p class="login-box-msg">Recuperar Password</p>

    <form method="POST" class="needs-validation" id="formRecupera" novalidate>
      <!-- Ingresar Email -->
      <div class="form-group has-feedback"  id="correo">
        <div>
          <input type="email" class="form-control" autocomplete="noCompletar" placeholder="Email" name="ingEmail" id="ingEmail" required autofocus>
          <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <!-- Mensaje de Error 
        <span class="help-block sr-only" id="msj_correo">
          <i class="fa fa-warning "></i>
          Ingrese un correo valido!
        </span>-->
        <!-- Fin de mensaje -->
      </div>

      <div class="row">    
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat btnEnviar">Recuperar</button>
        </div>  
      </div>

      <?php 
        // Ejecuto el Metodo Para recuperar la contraseña
        $recuperar = new ControladorUsuarios();
        $recuperar -> ctrRecuperarPassword();
      ?>

    </form>  
    <!-- Registrar con Google o Facebook --> 
      
    <div class="social-auth-links text-center">
<!--   
      <p>- O -</p>
      <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Ingresar usando
        Facebook</a>
      <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google"></i> ingresar usando
        Google+</a>
 -->        
    </div> 
   
    <!--Fin Registrar -->
  
    <div>     

      <div style="border-top: 1px solid#888; padding-top:15px; font-size:85%" >
        <a href="login" class="text-center">Iniciar Sesi&oacute;n</a><br>
        No se ha registrado aun! <a href="registro">Solicitar Registro aquí</a>
      </div>
      
    </div>

  </div>
</div>


