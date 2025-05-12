<?php 
// Mensaje de confirmacion solicitar nueva contraseña

// Para que el fondo sea aleatorio.
$fondosArray = array("vistas/img/plantilla/fondo0.jpg",
                     "vistas/img/plantilla/fondo1.jpg", 
                     "vistas/img/plantilla/fondo2.jpg", 
                     "vistas/img/plantilla/fondo3.jpg", 
                     "vistas/img/plantilla/fondo4.jpg",
                     "vistas/img/plantilla/fondo8.jpg",
                     "vistas/img/plantilla/fondo9.jpg",
                    ); 
$fondo = rand(0, (count($fondosArray)-1));
// Fin Fondo Aleatorio

// Capturar el  msj y quemarlo en el HTML
if (isset($_GET["msj"])){
   $mensaje = $_GET["msj"];
}else{
   echo '<script>window.location = "login";</script>';
}
// Fin capturar

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
            z-index: -1;">
<!-- Fin Estilo  -->
      <h2 style="text-align:center; color:white">

         <?php 
            echo $mensaje;
          ?>
         
         <p style="text-align:center;">
            <br />
            <br />
            <a href='login'>Iniciar Sesion</a> 
         </p>

      <h2>
</div>
