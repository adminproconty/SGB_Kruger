<?php 

if ($_SESSION['permisos_acceso']=='Super Admin') { ?>

    <ul class="sidebar-menu">
        <li class="header">MENU</li>

	<?php 

	if ($_GET["module"]=="start") { 
		$active_home="active";
	} else {
		$active_home="";
	}
	?>
		<li class="<?php echo $active_home;?>">
			<a href="?module=start"><i class="fa fa-home"></i> Inicio </a>
	  	</li>
	<?php

  if ($_GET["module"]=="cargadata" || $_GET["module"]=="form_cargadata") { ?>
    <li class="active">
      <a href="?module=cargadata"><i class="fa fa-upload"></i> Carga de Archivos </a>
      </li>
  <?php
  }

  else { ?>
    <li>
      <a href="?module=cargadata"><i class="fa fa-upload"></i> Carga de Archivos </a>
      </li>
  <?php
  }
  
  if ($_GET["module"]=="extrajudicial" || $_GET["module"]=="form_extrajudicial") { ?>
    <li class="active">
      <a href="?module=extrajudicial"><i class="fa fa-folder"></i> Gestión Extra Judicial </a>
      </li>
  <?php
  }

  else { ?>
    <li>
      <a href="?module=extrajudicial"><i class="fa fa-folder"></i> Gestión Extra Judicial </a>
      </li>
  <?php
  }
  
  
	if ($_GET["module"]=="reportes") { ?>
		<li class="active treeview">
          	<a href="javascript:void(0);">
            	<i class="fa fa-file-text"></i> <span>Reportes</span> <i class="fa fa-angle-left pull-right"></i>
          	</a>
      		<ul class="treeview-menu">
        <!--		<li class="active"><a href="?module=data_general"><i class="fa fa-circle-o"></i> Data General</a></li> -->
        		<li><a href="?module=data_fechas"><i class="fa fa-circle-o"></i> Data por Fechas</a></li>  
				<li><a href="?module=data_fechas"><i class="fa fa-circle-o"></i> Data Seguimientos</a></li>  
      		</ul>
    	</li>
    <?php
	}

	elseif ($_GET["module"]=="stock_report") { ?>
		<li class="active treeview">
          	<a href="javascript:void(0);">
            	<i class="fa fa-file-text"></i> <span>Reportes</span> <i class="fa fa-angle-left pull-right"></i>
          	</a>
      		<ul class="treeview-menu">
        		<!--		<li class="active"><a href="?module=data_general"><i class="fa fa-circle-o"></i> Data General</a></li> -->
        		<li><a href="?module=data_fechas"><i class="fa fa-circle-o"></i> Data por Fechas</a></li>
				<li><a href="?module=data_fechas"><i class="fa fa-circle-o"></i> Data Seguimientos</a></li>  
      		</ul>
    	</li>
    <?php
	}

	else { ?>
		<li class="treeview">
          	<a href="javascript:void(0);">
            	<i class="fa fa-file-text"></i> <span>Reportes</span> <i class="fa fa-angle-left pull-right"></i>
          	</a>
      		<ul class="treeview-menu">
        		<!--		<li class="active"><a href="?module=data_general"><i class="fa fa-circle-o"></i> Data General</a></li> -->
        		<li><a href="?module=data_fechas"><i class="fa fa-circle-o"></i> Data por Fechas</a></li>
				<li><a href="?module=data_seguimientos"><i class="fa fa-circle-o"></i> Data Seguimientos</a></li>  
      		</ul>
    	</li>
    <?php
	}


	if ($_GET["module"]=="user" || $_GET["module"]=="form_user") { ?>
		<li class="active">
			<a href="?module=user"><i class="fa fa-user"></i> Administrar usuarios</a>
	  	</li>
	<?php
	}

	else { ?>
		<li>
			<a href="?module=user"><i class="fa fa-user"></i> Administrar usuarios</a>
	  	</li>
	<?php
	}


	if ($_GET["module"]=="password") { ?>
		<li class="active">
			<a href="?module=password"><i class="fa fa-lock"></i> Cambiar contraseña</a>
		</li>
	<?php
	}

	else { ?>
		<li>
			<a href="?module=password"><i class="fa fa-lock"></i> Cambiar contraseña</a>
		</li>
	<?php
	}
	?>
	</ul>

<?php
}

elseif ($_SESSION['permisos_acceso']=='Supervisor') { ?>

    <ul class="sidebar-menu">
        <li class="header">MENU</li>

	<?php 

	if ($_GET["module"]=="start") { 
		$active_home="active";
	} else {
		$active_home="";
	}
	?>
		<li class="<?php echo $active_home;?>">
			<a href="?module=start"><i class="fa fa-home"></i> Inicio </a>
	  	</li>
	<?php

  if ($_GET["module"]=="cargadata" || $_GET["module"]=="form_cargadata") { ?>
    <li class="active">
      <a href="?module=cargadata"><i class="fa fa-upload"></i> Carga de Archivos </a>
      </li>
  <?php
  }

  else { ?>
    <li>
      <a href="?module=cargadata"><i class="fa fa-upload"></i> Carga de Archivos </a>
      </li>
  <?php
  }
  
  if ($_GET["module"]=="extrajudicial" || $_GET["module"]=="form_extrajudicial") { ?>
    <li class="active">
      <a href="?module=extrajudicial"><i class="fa fa-folder"></i> Gestión Extra Judicial </a>
      </li>
  <?php
  }

  else { ?>
    <li>
      <a href="?module=extrajudicial"><i class="fa fa-folder"></i> Gestión Extra Judicial </a>
      </li>
  <?php
  }
  
  
		if ($_GET["module"]=="reportes") { ?>
		<li class="active treeview">
          	<a href="javascript:void(0);">
            	<i class="fa fa-file-text"></i> <span>Reportes</span> <i class="fa fa-angle-left pull-right"></i>
          	</a>
      		<ul class="treeview-menu">
        <!--		<li class="active"><a href="?module=data_general"><i class="fa fa-circle-o"></i> Data General</a></li> -->
        		<li><a href="?module=data_fechas"><i class="fa fa-circle-o"></i> Data por Fechas</a></li>  
      		</ul>
    	</li>
    <?php
	}

	elseif ($_GET["module"]=="stock_report") { ?>
		<li class="active treeview">
          	<a href="javascript:void(0);">
            	<i class="fa fa-file-text"></i> <span>Reportes</span> <i class="fa fa-angle-left pull-right"></i>
          	</a>
      		<ul class="treeview-menu">
        		<!--		<li class="active"><a href="?module=data_general"><i class="fa fa-circle-o"></i> Data General</a></li> -->
        		<li><a href="?module=data_fechas"><i class="fa fa-circle-o"></i> Data por Fechas</a></li>
      		</ul>
    	</li>
    <?php
	}

	else { ?>
		<li class="treeview">
          	<a href="javascript:void(0);">
            	<i class="fa fa-file-text"></i> <span>Reportes</span> <i class="fa fa-angle-left pull-right"></i>
          	</a>
      		<ul class="treeview-menu">
        		<!--		<li class="active"><a href="?module=data_general"><i class="fa fa-circle-o"></i> Data General</a></li> -->
        		<li><a href="?module=data_fechas"><i class="fa fa-circle-o"></i> Data por Fechas</a></li>
      		</ul>
    	</li>
    <?php
	}




	if ($_GET["module"]=="password") { ?>
		<li class="active">
			<a href="?module=password"><i class="fa fa-lock"></i> Cambiar contraseña</a>
		</li>
	<?php
	}

	else { ?>
		<li>
			<a href="?module=password"><i class="fa fa-lock"></i> Cambiar contraseña</a>
		</li>
	<?php
	}
	?>
	</ul>


<?php
}
if ($_SESSION['permisos_acceso']=='CallCenter') { ?>

       <ul class="sidebar-menu">
        <li class="header">MENU</li>

	<?php 

	if ($_GET["module"]=="start") { 
		$active_home="active";
	} else {
		$active_home="";
	}
	?>
		<li class="<?php echo $active_home;?>">
			<a href="?module=start"><i class="fa fa-home"></i> Inicio </a>
	  	</li>
	<?php

  if ($_GET["module"]=="cargadata" || $_GET["module"]=="form_cargadata") { ?>
    <li class="active">
      <a href="?module=cargadata"><i class="fa fa-upload"></i> Carga de Archivos </a>
      </li>
  <?php
  }

  else { ?>
    <li>
      <a href="?module=cargadata"><i class="fa fa-upload"></i> Carga de Archivos </a>
      </li>
  <?php
  }
  
  if ($_GET["module"]=="extrajudicial" || $_GET["module"]=="form_extrajudicial") { ?>
    <li class="active">
      <a href="?module=extrajudicial"><i class="fa fa-folder"></i> Gestión Extra Judicial </a>
      </li>
  <?php
  }

  else { ?>
    <li>
      <a href="?module=extrajudicial"><i class="fa fa-folder"></i> Gestión Extra Judicial </a>
      </li>
  <?php
  }
  
  
		if ($_GET["module"]=="reportes") { ?>
		<li class="active treeview">
          	<a href="javascript:void(0);">
            	<i class="fa fa-file-text"></i> <span>Reportes</span> <i class="fa fa-angle-left pull-right"></i>
          	</a>
      		<ul class="treeview-menu">
        <!--		<li class="active"><a href="?module=data_general"><i class="fa fa-circle-o"></i> Data General</a></li> -->
        		<li><a href="?module=data_fechas"><i class="fa fa-circle-o"></i> Data por Fechas</a></li>  
				<li><a href="?module=data_fechas"><i class="fa fa-circle-o"></i> Data Seguimientos</a></li>  
      		</ul>
    	</li>
    <?php
	}

	elseif ($_GET["module"]=="stock_report") { ?>
		<li class="active treeview">
          	<a href="javascript:void(0);">
            	<i class="fa fa-file-text"></i> <span>Reportes</span> <i class="fa fa-angle-left pull-right"></i>
          	</a>
      		<ul class="treeview-menu">
        		<!--		<li class="active"><a href="?module=data_general"><i class="fa fa-circle-o"></i> Data General</a></li> -->
        		<li><a href="?module=data_fechas"><i class="fa fa-circle-o"></i> Data por Fechas</a></li>
				<li><a href="?module=data_fechas"><i class="fa fa-circle-o"></i> Data Seguimientos</a></li>  
      		</ul>
    	</li>
    <?php
	}

	else { ?>
		<li class="treeview">
          	<a href="javascript:void(0);">
            	<i class="fa fa-file-text"></i> <span>Reportes</span> <i class="fa fa-angle-left pull-right"></i>
          	</a>
      		<ul class="treeview-menu">
        		<!--		<li class="active"><a href="?module=data_general"><i class="fa fa-circle-o"></i> Data General</a></li> -->
        		<li><a href="?module=data_fechas"><i class="fa fa-circle-o"></i> Data por Fechas</a></li>
				<li><a href="?module=data_seguimientos"><i class="fa fa-circle-o"></i> Data Seguimientos</a></li>  
      		</ul>
    	</li>
    <?php
	}



	if ($_GET["module"]=="password") { ?>
		<li class="active">
			<!-- <a href="?module=password"><i class="fa fa-lock"></i> Cambiar contraseña</a> -->
		</li>
	<?php
	}

	else { ?>
		<li>
			<!-- <a href="?module=password"><i class="fa fa-lock"></i> Cambiar contraseña</a> -->
		</li>
	<?php
	}
	?>
	</ul>

<?php
}
?>