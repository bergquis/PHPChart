<?php


class PHPChart_Legend extends PHPChart_Component {
	
	private $labels = array();
	private $achart;
	
	
	
	
	protected $width = 100 ;
	protected $position = PHPChart::RIGHT;
	protected $xscale = false;
	
	
	function __construct(PHPChart_AbstractChart $chart) {
		$this->achart = $chart; 
	}
	
	function addLabel($string, $color) {
		$this->labels[$string] = $color;
	}
	
	function render() {
		$this->chart->getDriver()->setFillColor($this->fillColor);
		$this->calculateDimensions();
		$this->labels = $this->achart->getLabels();
		$this->drawBackground();
		
		$bx = $this->xleft;
		$by = $this->ytop;
		$this->chart->getDriver()->setFontSize($this->fontSize);
		
		foreach($this->labels as $label => $color) {
			$this->chart->getDriver()->setStrokeColor($color);
			$this->chart->getDriver()->setFillColor($color);
			
			$dimensions = $this->chart->getDriver()->getTextDimensions($label);
			
			if ($this->position & PHPChart::BOTTOM) {
				$by = $this->ybottom - ($this->height - $dimensions[1]) / 2;
				$this->chart->getDriver()->drawRectangle($bx, $by,  $bx + $dimensions[1], $by - $dimensions[1]);
				$this->chart->getDriver()->setStrokeColor($this->strokeColor);
				$this->chart->getDriver()->text($bx + $dimensions[2], $by, $label);
				$bx += $dimensions[0] + $dimensions[1] + $dimensions[2];
			}
			if ($this->position & PHPChart::RIGHT) {
				
				$this->chart->getDriver()->drawRectangle($bx, $by,  $bx + $dimensions[1], $by + $dimensions[1]-2);
				$this->chart->getDriver()->setStrokeColor('transparent');
				$this->chart->getDriver()->setFillColor($this->strokeColor);
				$this->chart->getDriver()->text($bx + $dimensions[1] + $dimensions[2], $by + $dimensions[1]-2, $label);
				$by += $dimensions[1] + $dimensions[1];
			}  
		}
		
		
	}
	
}
