<?php


abstract class PHPChart_AbstractChart extends PHPChart_Component{
	
	private $palette;
	
	abstract function getLabels();
	
	function setPalette(PHPChart_Palette $palette) {
		$this->palette = $palette;
	}
	
	function getNextColor() {
		if(!$this->palette) $this->palette = new PHPChart_Palette_Basic;
		return $this->palette->getNextColor();
	}
	
}