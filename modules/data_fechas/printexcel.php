<?php
if (PHP_SAPI == 'cli')
	die('Este ejemplo sólo se puede ejecutar desde un navegador Web');

/** Incluye PHPExcel */
require_once '../../lib/PHPExcel.php';
// Crear nuevo objeto PHPExcel
$objPHPExcel = new PHPExcel();

// Propiedades del documento
$objPHPExcel->getProperties()->setCreator("PROCONTY")
							 ->setLastModifiedBy("PROCONTY")
							 ->setTitle("Gestiones Extrajudiciales")
							 ->setSubject("Gestiones Extrajudiciales")
							 ->setDescription("Documento con las Gestiones Extrajudiciales realizadas por el Estudio Jurídico Ocaña y Ocaña")
							 ->setKeywords("office 2010 openxml php")
							 ->setCategory("Archivo con resultados");



// Combino las celdas desde A1 hasta E1
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:K1');

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'REPORTE DE GESTION EXTRAJUDICIAL')
            ->setCellValue('A2', 'IDENTIFICACION')
            ->setCellValue('B2', 'OPERACION')
            ->setCellValue('C2', 'CEDENTE')
			->setCellValue('D2', 'ACCION')
			->setCellValue('E2', 'RESPUESTA')
			->setCellValue('F2', 'CONTACTO')
			->setCellValue('G2', 'TELEFONO')
			->setCellValue('H2', 'OBSERVACION')
			->setCellValue('I2', 'FECHA_GESTION')
			->setCellValue('J2', 'VALOR_COMPROMISO')
			->setCellValue('K2', 'USUARIO');
			
// Fuente de la primera fila en negrita
$boldArray = array('font' => array('bold' => true,),'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));

$objPHPExcel->getActiveSheet()->getStyle('A1:K2')->applyFromArray($boldArray);		

	
			
//Ancho de las columnas
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);	
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);	
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);	
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);	
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);			
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);			
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);			
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);			
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);			
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(30);

/*Extraer datos de MYSQL*/
	//require_once "../../config/database.php";
	
	# conectare la base de datos
    //$con=@mysqli_connect('localhost', 'root', '', 'medisys');
	$con=@mysqli_connect('localhost', 'proco389_usersgi', '*12345', 'proco389_sgiocana');
    if(!$con){
        die("imposible conectarse: ".mysqli_error($con));
    }
    if (@mysqli_connect_errno()) {
        die("Connect failed: ".mysqli_connect_errno()." : ". mysqli_connect_error());
    }
	
	
			$tgl1     = $_GET['tgl_awal'];
			$explode  = explode('-',$tgl1);
			$tgl_awal = $explode[2]."-".$explode[1]."-".$explode[0];

			$tgl2      = $_GET['tgl_akhir'];
			$explode   = explode('-',$tgl2);
			$tgl_akhir = $explode[2]."-".$explode[1]."-".$explode[0];
	
    $sql="SELECT ex.*, (select u.username from usuarios u where u.id_user = ex.usuario) as usuario FROM gestionextrajudicial ex WHERE ex.fecha_gestion BETWEEN '$tgl_awal' AND '$tgl_akhir'";
	$query=mysqli_query($con,$sql);
	$cel=3;//Numero de fila donde empezara a crear  el reporte
	while ($row=mysqli_fetch_array($query)){
		$numero_identificacion=$row['numero_identificacion'];
		$numero_operacion=$row['numero_operacion'];
		$cedente=$row['cedente'];
		$accion=$row['accion'];
		$respuesta=$row['respuesta'];
		$contacto=$row['contacto'];
		$telefono=$row['telefono'];
		$observacion=$row['observacion'];
		$fecha_gestion=$row['fecha_gestion'];
		$valor_compromiso=$row['valor_compromiso'];
		$usuario=$row['usuario'];
		
			$a="A".$cel;
			$b="B".$cel;
			$c="C".$cel;
			$d="D".$cel;
			$e="E".$cel;
			$f="F".$cel;
			$g="G".$cel;
			$h="H".$cel;
			$i="I".$cel;
			$j="J".$cel;
			$k="K".$cel;
			// Agregar datos
			$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue($a, $numero_identificacion)
			->setCellValue($b, $numero_operacion)
			->setCellValue($c, $cedente)
			->setCellValue($d, $accion)
			->setCellValue($e, $respuesta)
			->setCellValue($f, $contacto)
			->setCellValue($g, $telefono)
			->setCellValue($h, $observacion)
			->setCellValue($i, $fecha_gestion)
			->setCellValue($j, $valor_compromiso)
			->setCellValue($k, $usuario);
			
	$cel+=1;
	}

/*Fin extracion de datos MYSQL*/
$rango="A2:$k";
$styleArray = array('font' => array( 'name' => 'Arial','size' => 10),
'borders'=>array('allborders'=>array('style'=> PHPExcel_Style_Border::BORDER_THIN,'color'=>array('argb' => 'FFF')))
);
$objPHPExcel->getActiveSheet()->getStyle($rango)->applyFromArray($styleArray);
// Cambiar el nombre de hoja de cálculo
$objPHPExcel->getActiveSheet()->setTitle('Extrajudicial');


// Establecer índice de hoja activa a la primera hoja , por lo que Excel abre esto como la primera hoja
$objPHPExcel->setActiveSheetIndex(0);

$filename = "FincaOcana_" . $tgl_awal . ".xls";
// Redirigir la salida al navegador web de un cliente ( Excel5 )
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename='.$filename);
header('Cache-Control: max-age=0');
// Si usted está sirviendo a IE 9 , a continuación, puede ser necesaria la siguiente
header('Cache-Control: max-age=1');

// Si usted está sirviendo a IE a través de SSL , a continuación, puede ser necesaria la siguiente
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
