<?php
error_reporting(E_ALL);
include "../PHPChart/Component.php";
include "../PHPChart.php";

include "../PHPChart/AbstractChart.php";
include "../PHPChart/Graph.php";
include "../PHPChart/Graph/Line.php";
include "../PHPChart/Driver.php";
include "../PHPChart/Driver/ImageMagick.php";
include "../PHPChart/Legend.php";
include "../PHPChart/Palette.php";
include "../PHPChart/Palette/Basic.php";

$chart = new PHPChart(600,400);
$chart->setDriver($d = new PHPChart_Driver_ImageMagick);
$lineChart = new PHPChart_Graph;
$lineChart->setLineFillAlpha(140);
$legend = new PHPChart_Legend($lineChart);
$legend->setFontSize(12);


$chart->setChart($lineChart);
$chart->setLegend($legend);
//$chart->setLegend(new PHPChart_Legend);

$data = array(
	1 => 1,
	2 => 5,
	3 => 2,
	4 => 5,
	5 => 9,
	6 => 12,

);
$line = new PHPChart_Graph_Line("Home");
$lineChart->addLine($line);
$line->appendData($data);
$data = array(
	11 => 1,
	12 => 2,
	13 => 5,
	14 => 7,
	15 => 3,
	16 => 2,

);
$line->appendData($data);



$data = array(
	1 => 7,
	2 => 12,
	3 => 6,
	4 => 9,
	5 => 3,
	6 => 10,

);

$line = new PHPChart_Graph_Line("Away");
$lineChart->addLine($line);
$line->setColor('#00ff00');
$line->setWidth(3);
$line->appendData($data);

echo $chart->render();
