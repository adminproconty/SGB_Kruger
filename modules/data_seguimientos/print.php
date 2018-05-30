<?php
session_start();
ob_start();


require_once "../../config/database.php";

include "../../config/fungsi_tanggal.php";

include "../../config/fungsi_rupiah.php";

$hari_ini = date("d-m-Y");

$no = 1;

$queryges = mysqli_query($mysqli, "SELECT ex.numero_identificacion,ex.numero_operacion,ex.cedente,ex.accion,ex.respuesta,ex.contacto,ex.telefono,ex.observacion,ex.fecha_gestion,ex.valor_compromiso,(select u.username from usuarios u where u.id_user = ex.usuario) as usuario, ex.fecha_gestion as fechag, ex.fecha_seguimiento as fechas FROM gestionextrajudicial ex") 
                                      or die('error: '.mysqli_error($mysqli));
$count  = mysqli_num_rows($queryges);
?>
<html xmlns="http://www.w3.org/1999/xhtml"> 
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>INFORME DE GESTIÓN CON SEGUIMIENTOS</title>
        <link rel="stylesheet" type="text/css" href="../../assets/css/laporan.css" />
    </head>
    <body>
        <div id="title">
           GESTIONES REALIZADAS
        </div>
        
        <hr><br>

        <div id="isi">
            <table width="100%" border="0.3" cellpadding="0" cellspacing="0">
                <thead style="background:#e8ecee">
                    <tr class="tr-title">
                        <th height="5" align="center" valign="middle"><small>NO.</small></th>
                        <th height="100" align="center" valign="middle"><small>OPERACION</small></th>
                        <th height="20" align="center" valign="middle"><small>ACCION</small></th>
                        <th height="20" align="center" valign="middle"><small>RESPUESTA</small></th>
                        <th height="20" align="center" valign="middle"><small>TELEFONO</small></th>
                        <th height="20" align="center" valign="middle"><small>FECHA GESTION</small></th>
                        <th height="20" align="center" valign="middle"><small>FECHA SEGUIMIENTO</small></th>
                    </tr>
                </thead>
                <tbody>
        <?php
       
        while ($datages = mysqli_fetch_assoc($queryges)) {
            if ($datages[fechas] == '0000-00-00 00:00:00'){
				  $fechas = "";
			  } else {
				  $fechas = $datages[fechas];
			  }
          
            echo "  <tr>
					  <td width='15' class='center'>$no</td>
					  <td width='100' class='center'>$datages[numero_operacion]</td>
					  <td width='60' class='center'>$datages[accion]</td>
					  <td width='150' class='center'>$datages[respuesta]</td>
					  <td width='100'align='right'>$datages[telefono]</td>
					  <td width='100'align='right'>$datages[fechag]</td>
					  <td width='100'align='right'>$fechas</td>
                    </tr>";
            $no++;
        }
        ?>  
                </tbody>
            </table>

            
        </div>
    </body>
</html>
<?php
$filename="INFORME_GESTION.pdf"; 
//==========================================================================================================
$content = ob_get_clean();
$content = '<page style="font-family: freeserif">'.($content).'</page>';

require_once('../../assets/plugins/html2pdf_v4.03/html2pdf.class.php');
try
{
    $html2pdf = new HTML2PDF('P','F4','en', false, 'ISO-8859-15',array(10, 10, 10, 10));
    $html2pdf->setDefaultFont('Arial');
    $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
    $html2pdf->Output($filename);
}
catch(HTML2PDF_exception $e) { echo $e; }
?>