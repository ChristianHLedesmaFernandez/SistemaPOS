<?php 
// Mensaje de erro No se puede verificar los datos.

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
   
   <div class="error-content">
      <h2 style="text-align:center; color:white">
         <i class="fa fa-warning text-red"></i> Oops! No se puedo verificar los datos.
         
         <p style="text-align:center;">
            <br />
            <br />
            <a href='login'>Iniciar Sesion</a> 
         </p>

      </h2>

      

    
   </div>

</div>
