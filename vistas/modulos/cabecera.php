<header class="main-header">
	<!-- Logotipo -->
	<a href="inicio" class="logo">
      <!-- Logo cuando el menu esta minimisado -->
      <span class="logo-mini">
      	<img src="vistas/img/plantilla/willycafe-mini.ico" class="img-responsive" style="padding: 10px">
      </span>
      
      <!-- Logo para cuando el menu esta en estado normal -->
      <span class="logo-lg">
      	<!--      	 
      	<i><img src="vistas/img/plantilla/willycafe-mini.ico"></i>
      	
      	<img src="vistas/img/plantilla/willycafe.png" class="img-responsive" style="padding: 10px 0px">
      	-->
      	<b>Willy </b>Cafe 
      	
      </span>
    </a>
    <!-- Fin Logotipo -->
	<!-- Barra de Navegacion -->
	<nav class="navbar navbar-static-top" role="navigation">
		<!-- Boton de Navegacion--> 
		<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
	        <span class="sr-only">Navegacion de Palanca</span>
	        <!-- <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span> -->
      </a>
      <!-- Perfil de Usuario -->
      <div class="navbar-custom-menu">
      	<ul class="nav navbar-nav">
      		<li class="dropdown user user-menu">
      			<a href="#" class="dropdown-toggle" data-toggle="dropdown">
      				<!-- Aca van los datos del usuario que inicia Sesion -->
      				<?php 
      				if(!empty($_SESSION["foto"])){
      					echo '<img src="' . $_SESSION["foto"] . '" class="user-image">';
      				} else{
      					echo '<img src="vistas/img/usuarios/default/anonymous.jpg" class="user-image">';
      				}
      				?>      				

      				<span class="hidden-xs"><?php echo $_SESSION["nombre"] ?></span> 
      				<!-- Fin -->
      			</a>
		        <!-- Menu delplegable del Usuario -->
	            <ul class="dropdown-menu">
	              <!-- Imagen de Usuario -->
	              <li class="user-header">
	              	<!-- Aca van los datos del usuario que inicia Sesion -->
      				<?php 
      				if(!empty($_SESSION["foto"])){
      					echo '<img src="' . $_SESSION["foto"] . '" class="img-circle" alt="User Image">';
      				} else{
      					echo '<img src="vistas/img/usuarios/default/anonymous.jpg" class="img-circle" alt="User Image">';
      				}
      				?>  
      				<!-- Fin -->
	                <p>
	                   <?php echo $_SESSION["perfil"] . " - " . $_SESSION["nombre"] ?>
	                  <small>Miembro desde Nov. 2017</small>
	                </p>
	              </li>
	              <!-- Menú de pie de página-->
	              <li class="user-footer">
	                <div class="pull-left">
	                  <a href="#" class="btn btn-default btn-flat">Perfil</a>
	                </div>
	                <div class="pull-right">
	                  <a href="salir" class="btn btn-default btn-flat">Cerrar Sesion</a>
	                </div>
	              </li>
	            </ul>
		        <!--
		        <ul class="dropdown-menu">
			      	<li class="user-body">
			      		<div class="pull-right">
			      			<a href="" class="btn btn-default btn form-control-static">Cerrar Sesion</a>
			      		</div>
			      	</li>
		      	</ul>
		      	-->	
		      </li>
      	</ul>
      </div>
      
	</nav>
	<!-- Fin Barra de Navegacion -->
	<!-- -->
	<!-- -->
</header>