<?php
require_once "config/database.php";
require_once "config/fungsi_tanggal.php";
require_once "config/fungsi_rupiah.php";


if (empty($_SESSION['username']) && empty($_SESSION['password'])){
	echo "<meta http-equiv='refresh' content='0; url=index.php?alert=1'>";
}
else {
	if ($_GET['module'] == 'start') {
		include "modules/start/view.php";
	}

	elseif ($_GET['module'] == 'extrajudicial') {
		include "modules/extrajudicial/view.php";
	}

	elseif ($_GET['module'] == 'form_extrajudicial') {
		include "modules/extrajudicial/form.php";
	}
	

	elseif ($_GET['module'] == 'cargadata') {
		include "modules/cargadata/view.php";
	}

	elseif ($_GET['module'] == 'form_cargadata') {
		include "modules/cargadata/form.php";
	}
	

	elseif ($_GET['module'] == 'data_fechas') {
		include "modules/data_fechas/view.php";
	}
	
	elseif ($_GET['module'] == 'data_seguimientos') {
		include "modules/data_seguimientos/view.php";
	}

	elseif ($_GET['module'] == 'data_general') {
		include "modules/data_general/view.php";
	}

	elseif ($_GET['module'] == 'user') {
		include "modules/user/view.php";
	}


	elseif ($_GET['module'] == 'form_user') {
		include "modules/user/form.php";
	}

	elseif ($_GET['module'] == 'profile') {
		include "modules/profile/view.php";
		}


	elseif ($_GET['module'] == 'form_profile') {
		include "modules/profile/form.php";
	}

	elseif ($_GET['module'] == 'password') {
		include "modules/password/view.php";
	}
}
?>