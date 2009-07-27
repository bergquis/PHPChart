<?php
error_reporting(E_ALL);
include "../PHPChart.php";

include "../PHPChart/Component.php";
include "../PHPChart/Driver.php";
include "../PHPChart/Driver/ImageMagick.php";
include "../PHPChart/AbstractChart.php";
include "../PHPChart/Pie.php";


$chart = new PHPChart();
$chart->setDriver(new PHPChart_Driver_ImageMagick);



$pie = new PHPChart_Pie();

$sets = array(
			array('label' => 'A', 'value' => 23, 'color' =>  '#ff0000'),
			array('label' => 'B', 'value' => 62, 'color' =>  '#0ff000'),
			array('label' => 'C', 'value' => 76, 'color' =>  '#00ff00'),
			array('label' => 'D', 'value' => 54, 'color' =>  '#000ff0'),
			);

$pie->setData($sets);

$chart->setChart($pie);

echo $chart->render();