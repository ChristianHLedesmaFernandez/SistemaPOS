<?php 

session_start();

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Willy Cafe</title>

   <!-- Icono de la barra del Navegador -->
  <link rel="shortcut icon" type="image/x-icon" href="vistas/img/plantilla/favicon.ico">
  <!-- Para que el navegador responda al ancho de la pantalla -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  
  <!-- Comienzo de Plugin CSS -->
  <!-- Mi CSS
  <link rel="stylesheet" href="vistas/css/validar.css">
   -->
   
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="vistas/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome (Fuente impresionante) -->
  <link rel="stylesheet" href="vistas/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="vistas/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="vistas/bower_components/datatables.net-bs/css/responsive.bootstrap.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="vistas/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="vistas/dist/css/AdminLTE.css">
  <!-- AdminLTE Skins. Elija un skin de la carpeta css / skins 
       en lugar de descargarlos todos para reducir la carga. -->
  <link rel="stylesheet" href="vistas/dist/css/skins/_all-skins.min.css">
  <!-- iCheck para checkboxes y radio inputs -->
  <link rel="stylesheet" href="vistas/plugins/iCheck/all.css">
  <!-- Daterange Picker -->
  <link rel="stylesheet" href="vistas/bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- Fuente de Google -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <!-- Morris.js charts -->
  <link rel="stylesheet" href="vistas/bower_components/morris.js/morris.css">
  <!-- Fin Plugin CSS -->
  
  <!-- Comienzo de Plugin JavaScript -->
  <!-- recaptcha -->
  <script src='https://www.google.com/recaptcha/api.js'></script>
  <!-- jQuery 3 -->
  <script src="vistas/bower_components/jquery/dist/jquery.min.js"></script>
  <!-- Bootstrap 3.3.7 -->
  <script src="vistas/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <!-- FastClick (Mejora la interaccion en los distintos dispositivos) -->
  <script src="vistas/bower_components/fastclick/lib/fastclick.js"></script>
  <!-- AdminLTE App -->
  <script src="vistas/dist/js/adminlte.min.js"></script>
  <!-- DataTables -->
  <script src="vistas/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="vistas/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
  <script src="vistas/bower_components/datatables.net-bs/js/dataTables.responsive.min.js"></script>
  <script src="vistas/bower_components/datatables.net-bs/js/responsive.bootstrap.min.js"></script>
  <!-- Sweet Alert 2 -->
  <script src="vistas/plugins/sweetalert2/sweetalert2.all.js"></script> 
  <!-- iCheck 1.0.1 -->
  <script src="vistas/plugins/iCheck/icheck.min.js"></script>
  <!-- Daterange Picker -->
  <script src="vistas/bower_components/moment/min/moment.min.js"></script>
  <script src="vistas/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
  <!-- InputMask -->
  <script src="vistas/plugins/input-mask/jquery.inputmask.js"></script>
  <script src="vistas/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
  <script src="vistas/plugins/input-mask/jquery.inputmask.extensions.js"></script>
  <!-- jQuery Number -->
  <script src="vistas/plugins/jqueryNumber/jquerynumber.min.js"></script>
  <!-- Morris.js charts -->
  <script src="vistas/bower_components/raphael/raphael.min.js"></script>
  <script src="vistas/bower_components/morris.js/morris.min.js"></script>
  <!-- ChartJS -->
<script src="vistas/bower_components/chart.js/Chart.js"></script>
  <!-- Fin Plugin JavaScript --> 

</head>
<!-- Comienzo del Cuerpo del Documento -->
<!-- sidebar-collapse sirve para que el menu comienze oculto -->
<body class="hold-transition skin-blue sidebar-collapse sidebar-mini login-page">  
<!-- Contenedor del Sitio -->
  <?php 

  if (isset($_SESSION["iniciarSesion"]) && $_SESSION["iniciarSesion"]) {
  
      echo '<div class="wrapper">';
      /* Cabecera */
      include "modulos/cabecera.php";
      /* Menu lateral desplegable */
      include "modulos/menu.php";
      /* Contenido */
      if (isset($_GET["ruta"])) {
        if ($_GET["ruta"] == "inicio" || 
            $_GET["ruta"] == "solicitudes" ||
            $_GET["ruta"] == "administradores" || 
            $_GET["ruta"] == "vendedores" ||
            $_GET["ruta"] == "categorias" ||
            $_GET["ruta"] == "productos" ||
            $_GET["ruta"] == "clientes" ||
            $_GET["ruta"] == "locales"||
            $_GET["ruta"] == "adminconsumos"||
            $_GET["ruta"] == "crear-consumo" ||
            $_GET["ruta"] == "editar-consumo" ||
            $_GET["ruta"] == "reportes"||
            $_GET["ruta"] == "salir")
             {
          include "modulos/".$_GET["ruta"].".php";
        }else{
          include "modulos/404.php";
        }
      }else{
        include "modulos/inicio.php";
      }  
      /* Pie de Pagina */
      include "modulos/pie.php";
      echo '</div>';
  }else{
  
    if (isset($_GET["ruta"])) {

        if($_GET["ruta"] == "registro" ||
            $_GET["ruta"] == "recuperarpass" ||              
            $_GET["ruta"] == "cambiarpass" ||            
            $_GET["ruta"] == "activar" ||            
            $_GET["ruta"] == "mensaje" 
            /*
            ||            
            $_GET["ruta"] == "mensaje01" ||             
            $_GET["ruta"] == "mensaje01" || 
            $_GET["ruta"] == "mensaje01" ||            
            $_GET["ruta"] == "mensaje02" ||            
            $_GET["ruta"] == "mensaje03" ||            
            $_GET["ruta"] == "mensaje04" 
            */
            ){

        //include "modulos/registro.php";
        include "modulos/".$_GET["ruta"].".php";
      }else{
        include "modulos/login.php";
      }
    }else {
      include "modulos/login.php"; 
    }   

  }

  ?>
<!-- Aca estaria la Cabezera principal -->
<!-- Fin Cabezera Principal -->

<!-- Aca estaria la Barra Lateral izquierda -->
<!-- Fin Barra Lateral izquierda -->

<!-- Aca estaria la Contenedor de Contenidos -->
<!-- Fin Contenedor de Contenidos -->

<!-- Aca estaria el Pie de Pagina -->
<!-- Fin Pie de Pagina -->

<!-- Aca estaria la Barra lateral de control derecho -->
<!-- Fin Pie de Pagina derecho -->

<!--Aca estaria el div que añade el fondo a la barra lateral -->
<!-- Fin div -->


<!-- Fin Contenedor del Sitio -->
<!-- Script Personalizados -->

<script src="vistas/js/plantilla.js"></script>
<script src="vistas/js/solicitudes.js"></script>
<script src="vistas/js/usuarios.js"></script>
<script src="vistas/js/categorias.js"></script>
<script src="vistas/js/productos.js"></script>
<script src="vistas/js/clientes.js"></script>
<script src="vistas/js/locales.js"></script>
<script src="vistas/js/consumos.js"></script>
<script src="vistas/js/validar.js"></script>
<!--
<script src="vistas/js/consumos.js"></script>
<script src="vistas/js/reportes.js"></script>
-->

</body>
</html>

