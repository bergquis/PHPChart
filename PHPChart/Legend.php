<?php


class PHPChart_Legend extends PHPChart_Component {
	
	private $labels = array();
	private $achart;
	
	function __construct(PHPChart_AbstractChart $chart) {
		$this->achart = $chart; 
	}
	
	protected $height = 20;
	
	protected $yscale = false;
	
	function addLabel($string, $color) {
		$this->labels[$string] = $color;
	}
	
	function render() {
		$this->chart->getDriver()->setFillColor($this->fillColor);
		$this->calculateDimensions();
		$this->labels = $this->achart->getLabels();
		$this->drawBackground();
		
		$bx = $this->xleft;
		
		
		foreach($this->labels as $label => $color) {
			$this->chart->getDriver()->setStrokeColor($color);
			$this->chart->getDriver()->setFillColor($color);
			
			$dimensions = $this->chart->getDriver()->getTextDimension($label);
			
			$by = $this->ybottom - ($this->height - $dimensions[1]) / 2;
			$this->chart->getDriver()->drawRectangle($bx, $by,  $bx + $dimensions[1], $by - $dimensions[1]);
			
			$this->chart->getDriver()->setStrokeColor($this->strokeColor);
			$this->chart->getDriver()->text($bx + $dimensions[1] + 5, $by, $label);
			$bx += $dimensions[0] + $dimensions[1] + 20;
		}
		
		
	}
	
}