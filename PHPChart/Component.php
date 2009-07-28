<?php

abstract class PHPChart_Component {
	
	protected $strokeColor = "#000000";
	protected $fillColor = "#ffcc9933";
	
	
	protected $ytop = null;
	protected $ybottom = null;
	protected $xleft = null;
	protected $xright = null;
	protected $height = null;
	protected $width = null;
	protected $chart;
	protected $xscale = true;
	protected $yscale = true;
	
	
	
	protected $margin = array('20', '20', '20', '20');
	protected $padding = array('5', '5', '5', '5');
	
	protected $scalable = true;
	
	function drawBackground() {
		$this->chart->getDriver()->setStrokeColor($this->strokeColor);
		$this->chart->getDriver()->setFillColor($this->fillColor);
		
		$this->chart->getDriver()->drawRectangle($this->xleft - $this->padding[3], $this->ytop,  $this->xleft + $this->width, $this->ybottom);
	}
	
	function calculateDimensions() {
		list($x1, $y1, $x2, $y2) = $this->chart->getSpace();
		
		
		if ($this->yscale) {
			$this->ytop = $y1 + $this->margin[0];
			$this->ybottom = $y2 - $this->margin[2];
		} else {
			$this->ybottom = $y2 - $this->margin[2];
			$this->ytop = $this->ybottom - $this->height;
			 
		}
		
		if ($this->xscale) {
			$this->xleft = $x1 + $this->margin[3];
			$this->xright = $x2 - $this->margin[1];
		} else {
			$this->xleft = $x1 + $this->margin[3]  + $this->padding[3];
			$this->xright = $this->xleft + $this->width;
		}
		
		$this->height = $this->ybottom - $this->ytop;
		$this->width = $this->xright - $this->xleft;
		
		$this->chart->setSpace(array($x1, $y1, $x2, $this->ytop));
		 
		
	}
	
	function calculateProperties() {
		//make sure steps are sensible
		$this->ytop = $ytop = $this->margin[0];
		$this->ybottom = $ybottom = $this->height - $this->margin[2];
		$this->xleft = $xleft = $this->margin[3];
		$this->xright = $xright = $this->width - $this->margin[1];
		
		$this->dx = $pstep = ($xright-$xleft) / $this->xstep ;
		$this->dy = $pstep = ($ybottom-$ytop) / $this->ystep ;
		
	}
	
	public function setAbsolutePosition($x, $y) {
	
	}
	
	public function setDimensions($x, $y) {
		
	}
	
	public function setMargin(array $margin) {
		$this->$margin = $margin;
	}
	
	function setChart(PHPChart $chart) {
		$this->chart = $chart;	
	}
	
	function getChart() {
		return $this->chart;
	}
	
	abstract function render();
	
} 