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
            height: 115%;
            background: url('<?php echo $fondosArray[$fondo]; ?>');
            background-size: cover;
            overflow: hidden;
            z-index: -1;"></div>

<div class="register-box" style="margin-top: 5px">
  <div class="register-logo">
    <img src="vistas/img/plantilla/willycafe.png" class="img-responsive" style="padding: 10px 0px">
  </div>
  <div class="register-box-body">
    <p class="login-box-msg">Solicitud de Registro</p>
    <form method="POST" class="needs-validation" id="formRegistro" novalidate> <!-- class="needs-validation" id="formulario" -->
      <!-- Ingrese Nombre -->
      <div class="form-group has-feedback" id="nombre">
        <div>
          <input type="text" class="form-control" placeholder="Nombre" name="ingNombre" id="ingNombre" required autofocus>
          <span class="fa fa-address-card form-control-feedback"></span>
        </div>
      </div>
      <!-- Ingrese Usuario -->
      <div class="form-group has-feedback" id="usuario">
        <div>
          <input type="text" class="form-control" placeholder="Usuario" name="ingUsuario" id="ingUsuario" required>
          <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>
      </div>
      <!-- Ingrese Email -->
      <div class="form-group has-feedback" id="correo">
        <div>
          <input type="email" class="form-control" placeholder="Email" name="ingEmail" id="ingEmail" required>
          <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
      </div>
      <!-- Confirmar Email -->
      <div class="form-group has-feedback" id="correoR">
        <div>
          <input type="email" class="form-control" autocomplete="noCompletar" placeholder="Repita Email" name="reIngEmail" id="reIngEmail" required>
          <span class="glyphicon glyphicon-repeat form-control-feedback"></span>
        </div>
      </div>
       <!-- Ingrese Password -->
      <div class="form-group has-feedback" id="password">
        <div>
          <input type="password" class="form-control" autocomplete="noCompletar" placeholder="Password" name="ingPassword" id="ingPassword" required>
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
      </div>
      <!-- Confirmar Password -->
      <div class="form-group has-feedback" id="passwordR">
        <div>
          <input type="password" class="form-control" autocomplete="noCompletar" placeholder="Repita password" name="reIngPassword" id="reIngPassword" required>
          <span class="glyphicon glyphicon-repeat form-control-feedback"></span>
        </div>
      </div>
      <!-- Comienzo del Captcha -->
      <div class="form-group has-feedback">
       <div class="row">
        <!-- <label for="captcha" class="col-md-3 control-label"></label> -->        
        <div class="g-recaptcha col-md-3" data-sitekey="6LemHsYUAAAAAKTvwjXoYOMt7ZOJUgSDAtD6jejH"></div>
        </div>
      </div>
      <!-- Fin del Captcha -->      
      <div class="row">        
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Registrar</button>
        </div>      
      </div>
      <?php 
        // Ejecuto el Metodo Ingresar
        $registrar = new ControladorUsuarios();
        $registrar -> ctrRegistroUsuario();
      ?>   
    </form>
    <div class="social-auth-links text-center">
  <!--
      <p>- O -</p>
      <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Registrarse usando
        Facebook</a>
      <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Registrarse usando
        Google+</a>
  -->       
    </div>
    <div style="border-top: 1px solid#888; padding-top:15px; font-size:85%" >
      <a href="login" class="text-center">Ya estoy Registrado!</a>
    </div>
  </div>
  <!-- /.form-box -->
</div>