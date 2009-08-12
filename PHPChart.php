<?php

#noe


class PHPChart extends PHPChart_Component {
	
	const LEFT = 1;
	const RIGHT = 2;
	const TOP = 4;
	const BOTTOM = 8; 
	const CENTER = 16;
	
	
	
	
		
	
	private $backgroundcolor = '#ffffff00';
	private $lines = array();
	private $mainchart = null;
	private $legend = null;
	private $components = array();
	private $driver;
	private $format;
	private $x1space;
	private $y1space;
	private $x2space;
	private $y2space;
	protected $margin = array(0,0,0,0); 
	
	
	function __construct($width, $height) {
		$this->height = $height;
		$this->width = $width;
	}
	
	
	
	function setDriver(PHPChart_Driver $driver) {
		$this->driver = $driver;
		$driver->init($this->width, $this->height, $this->backgroundcolor, $this->format);
	}
	
	function getDriver() {
		return $this->driver;
	}
	
	function getParentComponent() {
		return $this;
	}
	
	function getSpace() {
		return array($this->x1space, $this->y1space, $this->x2space, $this->y2space);
	}
	
	function setSpace(array $array) {
		list($this->x1space, $this->y1space, $this->x2space, $this->y2space) = $array;
		
	}
	
	function calculateDimensions() {
		$this->ytop = $this->margin[0] + $this->padding[0];
		$this->ybottom = $this->height - ($this->margin[0] + $this->padding[0] + $this->margin[2] + $this->padding[2]);
		$this->xleft = $this->margin[3] + $this->padding[3];
		$this->xright = $this->width - ($this->margin[3] + $this->padding[3] + $this->margin[1] + $this->padding[1]);
		
	}
	
	function render() {
		
		//Set up some params
		$this->calculateDimensions();
		
		$this->x1space = $this->xleft;
		$this->x2space = $this->xright;
		$this->y1space = $this->ytop;
		$this->y2space = $this->ybottom;
		
		
		$this->drawBackground();	
		$this->legend->render();
		$this->mainchart->render();
		
		
		header("Content-type: image/png");
		
		echo  $this->driver->getimage();
	}
	
	function setChart(PHPChart_AbstractChart $graph) {
		$this->mainchart = $graph;
		$graph->setChart($this);
	}
	
	function setLegend(PHPChart_Legend $graph) {
		$this->legend = $graph;
		$graph->setChart($this);
	}
	
}
