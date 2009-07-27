<?php

class PHPChart_Pie extends PHPChart_AbstractChart {
	
	private $data = array();
	
	private $xrad;
	private $yrad;
	private $x, $y, $thickness;
	
	function __construct() {
		
	}
	
	
	
	
	function setData(array $data) {
		$this->data= $data;
	}
	
	function getLabels() {
		return array_keys($this->data);
	}
	
	function getSegments() {
		$ret = array();
		$sum = 0;
		foreach($this->data as $d) {
			$sum += $d['value'];
		}
		$vpd = 360/$sum;
		foreach($this->data as $d) {
			
			$d['angle'] = $d['value'] * $vpd;
			$ret[] = $d;
		}
		
		return $ret;
	}
	
	function render() {
		$this->calculateDimensions();
		$this->xrad = ($this->xright - $this->xleft) / 2;
		$this->yrad = ($this->ybottom - $this->ytop) / 2;
		$this->x = $this->xrad + $this->xleft;
		$this->y = $this->yrad + $this->ytop;
		$this->thickness = 40;
		
		//$this->id->pathStart();
		//Draw a segment
		$rot = 0;
		
		foreach ($this->getSegments() as $set) {
			$this->getchart()->getdriver()->setFillColor($set['color']);
			$this->getchart()->getdriver()->setStrokeColor($set['color']);
			$angle = $set['angle'];
			
			$this->getchart()->getdriver()->drawPieSegment($this, $angle, $rot);
			
			$rot += $set['angle'];
			
			
		}
		//var_dump($x, $y, $cx, $cy);
		//$this->id->ellipse($x, $y, $xrad, $yrad, 0, 360);
		
	}
	function getRad() {
		return array($this->xrad, $this->yrad);
	}
	
	function getCenter() {
		return array($this->x, $this->y);
	}
}