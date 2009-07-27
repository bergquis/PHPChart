<?php

abstract class PHPChart_Component {
	
	protected $ytop = null;
	protected $ybottom = null;
	protected $xleft = null;
	protected $xright = null;
	protected $height = null;
	protected $width = null;
	protected $chart;
	
	protected $margin = array('50', '50', '50', '50');
	
	protected $scalable = true;
	
	function calculateDimensions() {
		list($x1, $y1, $x2, $y2) = $this->chart->getSpace();
		$this->ytop = $y1 + $this->margin[0];
		$this->ybottom = $y2 - $this->margin[2];
		$this->xleft = $x1 + $this->margin[3];
		$this->xright = $x2 - $this->margin[1];
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