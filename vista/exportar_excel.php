<?php

if (isset($_POST["btn_exportar_XLS"])) {
    $label = unserialize($_POST["label"]);
    $data = unserialize($_POST["data"]);
}

$long = count($label);
$arreglo = array(array('Descripción',	'Valor de la descripción'));
for($i=0; $i<$long; $i++){
    $arreglo[] = array($label[$i], floatval($data[$i]));
}

/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');
define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
date_default_timezone_set('Europe/London');
require_once dirname(__FILE__) . '/../controlador/Clases/PHPExcel.php';

header("Content-Type: application/xls");    
header("Content-Disposition: attachment; filename=excelfilename.xls");  
header("Pragma: no-cache"); 
header("Expires: 0");

$objPHPExcel = new PHPExcel();
$objWorksheet = $objPHPExcel->getActiveSheet();
$objWorksheet->fromArray(
	$arreglo
);
$dataSeriesLabels = array(
	new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$B$1', NULL, 1),	//	2010
);
$xAxisTickValues = array(
	new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$A$2:$A$9', NULL, 12),	//	Jan to Dec
);
$dataSeriesValues = array(
	new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$B$2:$B$9', NULL, 12),
);
//	Build the dataseries
$series = new PHPExcel_Chart_DataSeries(
	PHPExcel_Chart_DataSeries::TYPE_RADARCHART,		// plotType
	NULL,											// plotGrouping (Radar charts don't have any grouping)
	range(0, count($dataSeriesValues)-1),			// plotOrder
	$dataSeriesLabels,								// plotLabel
	$xAxisTickValues,								// plotCategory
	$dataSeriesValues,								// plotValues
    NULL,                                           // plotDirection
	NULL,											// smooth line
	PHPExcel_Chart_DataSeries::STYLE_MARKER			// plotStyle
);
//	Set up a layout object for the Pie chart
$layout = new PHPExcel_Chart_Layout();
//	Set the series in the plot area
$plotArea = new PHPExcel_Chart_PlotArea($layout, array($series));
//	Set the chart legend
$legend = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_RIGHT, NULL, false);
$title = new PHPExcel_Chart_Title('Gráfico Araña');
//	Create the chart
$chart = new PHPExcel_Chart(
	'chart1',		// name
	$title,			// title
	$legend,		// legend
	$plotArea,		// plotArea
	true,			// plotVisibleOnly
	0,				// displayBlanksAs
	NULL,			// xAxisLabel
	NULL			// yAxisLabel		- Radar charts don't have a Y-Axis
);
//	Set the position where the chart should appear in the worksheet
$chart->setTopLeftPosition('E2');
$chart->setBottomRightPosition('N18');
//	Add the chart to the worksheet
$objWorksheet->addChart($chart);
// Save Excel 2007 file
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->setIncludeCharts(TRUE);
$objWriter->setOffice2003Compatibility(true);
$objWriter->save('php://output');
//$objWriter->save(str_replace('.php', '.xlsx', __FILE__));
