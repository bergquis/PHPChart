<?php

abstract class PHPChart_Driver {
	
	abstract function drawPieSegment($pie, $angle, $rot);
	
	abstract function init($width, $height, $background, $format);
	
	abstract function setFillColor($color);
	
	abstract function setStrokeColor($color);
	
	abstract function setStrokeWidth($color);
	
	abstract function drawLine($x1, $y1, $x2, $y2);
	
	abstract function text($x1, $y1, $string);
		
}