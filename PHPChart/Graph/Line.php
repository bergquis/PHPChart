<?php

class PHPChart_Graph_Line {
	
	private $color = null;
	private $width = 2;
	private $data;
	private $name;
	private $xmax = -9999;
	private $xmin = 9999;
	private $ymax = -9999;
	private $ymin = 9999;
	
	private $alpha = null;
	
	private $graph;
	
	function __construct($name) {
		$this->name = $name;
	}
	
	function getLineFillAlpha() {
		if ($this->alpha === null) $this->alpha = $this->graph->getLineFillAlpha();
		return $this->alpha;
	}
	
	function setLineFillAlpha($alpha) {
		$this->alpha = $alpha;	
	}
	
	function setGraph($graph) {
		$this->graph = $graph;
		if(!$this->color) $this->color = $this->graph->getNextColor();
	}
	
	function getName() {
		return $this->name;
	}
	
	function appendData(array $set) {
		foreach ($set as $x => $y) {
			if ($this->xmax < $x) $this->xmax = $x;
			if ($this->xmin > $x) $this->xmin = $x;
			if ($this->ymax < $y) $this->ymax = $y;
			if ($this->ymin > $y) $this->ymin = $y; 
		}
		$this->data[] = $set;
	}
	
	function getBoundaries() {
		return array($this->xmax, $this->xmin, $this->ymax, $this->ymin);
	}
	
	function setColor($color) {
		$this->color = $color;
	}
	
	function setWidth($width) {
		$this->width = $width;
	} 
	
	function getWidth() {
		return $this->width;
	} 
	
	function getColor() {
		return $this->color;
	}
	
	
	function getData() {
		return $this->data;
	}
	
	
}