<?php


class PHPChart_Legend extends PHPChart_Component {
	
	private $labels = array();
	
	protected $ytop = 300;
	protected $ybottom = null;
	protected $xleft = null;
	protected $xright = null;
	protected $height = null;
	protected $width =- 200;
	
	function addLabel($string, $color) {
		$this->labels[$string] = $color;
	}
	
	function render() {
		$this->chart->drawRectangle($this->height, $this->width);
	}
	
}