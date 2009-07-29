<?php

class PHPChart_Pie extends PHPChart_AbstractChart {
	
	private $data = array();
	
	private $xrad;
	private $yrad;
	private $x, $y, $thickness = 4;
	
	function __construct() {
		
	}
	
	function getThickness() {
		return $this->thickness;
	}
	
	
	function setData(array $data) {
		foreach($data as $label) {
			$label['color'] = isset($label['color']) ? $label['color'] : $this->getNextColor();
			$this->data[]= $label ;
		}
	}
	
	function getLabels() {
		$labels = array();
		foreach($this->data as $label) {
			$labels[$label['label'] . ": " . $label['value']] = $label['color'];
		} 
		return $labels;
		 
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
		$this->thickness = $this->height / 10;
		$this->drawBackground();
		$this->xrad = ($this->xright - $this->xleft) / 2;
		$this->yrad = ($this->ybottom - $this->ytop - $this->thickness) / 2;
		$this->x = $this->xrad + $this->xleft;
		$this->y = $this->yrad + $this->ytop;
		
		//var_dump($this->height, $this->thickness, $this->xrad, $this->yrad);
		
		
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