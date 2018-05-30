<?php
session_start();
ob_start();


require_once "../../config/database.php";

include "../../config/fungsi_tanggal.php";

include "../../config/fungsi_rupiah.php";

$hari_ini = date("d-m-Y");


$tgl1     = $_GET['tgl_awal'];
$explode  = explode('-',$tgl1);
$tgl_awal = $explode[2]."-".$explode[1]."-".$explode[0];

$tgl2      = $_GET['tgl_akhir'];
$explode   = explode('-',$tgl2);
$tgl_akhir = $explode[2]."-".$explode[1]."-".$explode[0];

if (isset($_GET['tgl_awal'])) {
    $no    = 1;
    
    $queryges = mysqli_query($mysqli, "SELECT ex.numero_identificacion,ex.numero_operacion,ex.cedente,ex.accion,ex.respuesta,ex.contacto,ex.telefono,ex.observacion,ex.fecha_gestion,ex.valor_compromiso,ex.usuario FROM gestionextrajudicial ex") 
                                      or die('error: '.mysqli_error($mysqli));
    $count  = mysqli_num_rows($queryges);
}
?>
<html xmlns="http://www.w3.org/1999/xhtml"> 
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>GESTION EXTRA JUDICIAL</title>
        <link rel="stylesheet" type="text/css" href="../../assets/css/laporan.css" />
    </head>
    <body>
        <div id="title">
           GESTION EXTRAJUDICIAL
        </div>
    <?php  
    if ($tgl_awal==$tgl_akhir) { ?>
        <div id="title-tanggal">
            Fecha <?php echo tgl_eng_to_ind($tgl1); ?>
        </div>
    <?php
    } else { ?>
        <div id="title-tanggal">
            Desde <?php echo tgl_eng_to_ind($tgl1); ?> Hasta <?php echo tgl_eng_to_ind($tgl2); ?>
        </div>
    <?php
    }
    ?>
        
        <hr><br>
        <div id="isi">
            <table width="100%" border="0.3" cellpadding="0" cellspacing="0">
                <thead style="background:#e8ecee">
                    <tr class="tr-title">
                        <th height="20" align="center" valign="middle"><small>IDENTIFICACION</small></th>
                        <th height="20" align="center" valign="middle"><small>OPERACION </small></th>
                        <th height="20" align="center" valign="middle"><small>CEDENTE</small></th>
                        <th height="20" align="center" valign="middle"><small>ACCION </small></th>
                        <th height="20" align="center" valign="middle"><small>RESPUESTA</small></th>
                        <th height="20" align="center" valign="middle"><small>CONTACTO </small></th>
						<th height="20" align="center" valign="middle"><small>TELEFONO </small></th>
                        <th height="20" align="center" valign="middle"><small>OBSERVACION</small></th>
                    </tr>
                </thead>
                <tbody>
<?php
    
    if($count == 0) {
        echo "  <tr>
                    <td width='40' height='13' align='center' valign='middle'></td>
                    <td width='120' height='13' align='center' valign='middle'></td>
                    <td width='80' height='13' align='center' valign='middle'></td>
                    <td width='80' height='13' align='center' valign='middle'></td>
                    <td style='padding-left:5px;' width='155' height='13' valign='middle'></td>
					<td style='padding-left:5px;' width='50' height='13' valign='middle'></td>
                    <td style='padding-right:10px;' width='50' height='13' align='right' valign='middle'></td>
                    <td width='80' height='13' align='center' valign='middle'></td>
                </tr>";
    }

    else {
   
        while ($data = mysqli_fetch_assoc($queryges)) {
            $tanggal       = $data['fecha'];
            $exp           = explode('-',$tanggal);
            $fecha = $exp[2]."-".$exp[1]."-".$exp[0];

            echo "  <tr>
                        <td width='40' height='13' align='center' valign='middle'>$data[numero_identificacion]</td>
                        <td width='120' height='13' align='center' valign='middle'>$data[numero_operacion]</td>
						<td width='120' height='13' align='center' valign='middle'>$data[cedente]</td>
                        <td width='80' height='13' align='center' valign='middle'>$data[accion]</td>
                        <td style='padding-left:5px;' width='155' height='13' valign='middle'>$data[respuesta]</td>
						<td style='padding-left:5px;' width='50' height='13' valign='middle'>$data[contacto]</td>
                        <td style='padding-right:10px;' width='50' height='13' align='center' valign='middle'>$data[telefono]</td>
                        <td width='80' height='13' align='center' valign='middle'>$data[observacion]</td>
                    </tr>";
            $no++;
        }
    }
?>	
                </tbody>
            </table>

        </div>
    </body>
</html>
<?php
$filename="EJOcana.pdf"; 
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