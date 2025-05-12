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
 
    <a href="vistas/index2.html"><img src="vistas/img/plantilla/willycafe-mini.ico">
    <b>Willy</b>CAFE</a>
  <!-- 
    <img src="img/loto.png" class="img-responsive" style="padding: 10px 0px">
-->
  </div>
  <!-- Fin login-logo -->
  <div class="login-box-body">
    
    <p class="login-box-msg">Iniciar Sesion</p>
<!-- Formulario -->
    <form method="POST" class="needs-validation" id="formLogin" novalidate>
      
      <!-- Ingresar Usuario -->
      <div class="form-group has-feedback" id="usuario">
        <div>
          <input type="text" class="form-control" placeholder="Usuario o Correo Electronico" name="ingUsuario" id="ingUsuario" required autofocus>
          
          <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>
        <!-- Mensaje de Error   --> 
        <span class="help-block sr-only" id="msj_usuario">
          <i class="fa fa-warning "></i>
          Ingrese un usuario o un correo valido!
        </span>     
        <!-- Fin de mensaje -->

      </div>


      <!-- Ingresar Password -->
      <div class="form-group  has-feedback" id="password">
        <div>
          <input type="password" class="form-control" autocomplete="noCompletar" placeholder="Contraseña" name="ingPassword" id="ingPassword" required>        
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div> 
        <!-- Mensaje de Error -->
        <span class="help-block sr-only" id="msj_password">
          <i class="fa fa-warning "></i>
          Ingrese un password valido!
        </span>
        <!-- Fin de mensaje -->
      
      </div>

      <div class="row">
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat btnEnviar">Ingresar</button>
        </div>
      </div>

      <?php 
        // Ejecuto el Metodo Ingresar
        $login = new ControladorUsuarios();
        $login -> ctrIngresoUsuario();
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
  
       

    <div style="border-top: 1px solid#888; padding-top:15px; font-size:85%" >
      <a href="recuperarpass">¿Olvid&oacute; su contraseña?</a><br>    
      No tiene una cuenta! <a href="registro" class="text-center">Solicitar Registro aquí</a>
    </div>
   

  </div>
</div>


<!-- 



form class="well form-horizontal" action=" " method="post"  id="contact_form">
<fieldset>


<legend>Contact Us Today!</legend>



<div class="form-group">
  <label class="col-md-4 control-label">First Name</label>  
  <div class="col-md-4 inputGroupContainer">
  <div class="input-group">
  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
  <input  name="first_name" placeholder="First Name" class="form-control"  type="text">
    </div>
  </div>
</div>



<div class="form-group">
  <label class="col-md-4 control-label" >Last Name</label> 
    <div class="col-md-4 inputGroupContainer">
    <div class="input-group">
  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
  <input name="last_name" placeholder="Last Name" class="form-control"  type="text">
    </div>
  </div>
</div>


-->