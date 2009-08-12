<?php

abstract class PHPChart_Component {
	
	protected $strokeColor = "#000000";
	
	protected $backgroundColor = "#ffcc9933";
	
	
	protected $ytop = null;
	protected $ybottom = null;
	protected $xleft = null;
	protected $xright = null;
	protected $height = null;
	protected $width = null;
	
	
	
	protected $xscale = true;
	protected $yscale = true;
	
	protected $fontSize;
	
	protected $position = false;
	
	protected $margin = array('2', '2', '2', '2');
	protected $padding = array('5', '5', '5', '5');
	
	protected $borderColor = array('black', 'black', 'black', 'black');
	protected $borderWidth = array(1, 1, 1, 1);  
	
	protected $scalable = true;
	
	function setFontSize($size) {
		$this->fontSize = $size;	
	}
	
	function setPosition($position) {
		$this->position = $position;
	}
	
	
	function drawBackground() {
		$this->getParentComponent()->getDriver()->setStrokeColor($this->strokeColor);
		$this->getParentComponent()->getDriver()->setfillcolor($this->backgroundColor);
		
		$this->getParentComponent()->getDriver()->drawRectangle($this->xleft - $this->padding[3], $this->ytop - $this->padding[0],  $this->xright  + $this->padding[1], $this->ybottom + $this->padding[2]);
	}
	
	function calculateDimensions() {
		list($x1, $y1, $x2, $y2) = $this->getParentComponent()->getSpace();
		$this->yscale = ($this->height == null);
		$this->xscale = ($this->width == null);
		//var_dump($this->xscale, $this->yscale);die;
		if ($this->yscale) {
			$this->ytop = $y1 + $this->margin[0] + $this->padding[0];
			$this->ybottom = $y2 - $this->margin[2] - $this->padding[2] - $this->margin[0] - $this->padding[0];
		} else {
			$this->ybottom = $y2 - $this->margin[2] - $this->padding[2];
			$this->ytop = $this->ybottom - ($this->height);
			$y2 = $this->ytop - $this->margin[0] -  $this->padding[0];
			 
		}
		
		if ($this->xscale) {
			$this->xleft = $x1 + $this->margin[3] + $this->padding[3];
			$this->xright = $x2 - $this->margin[1] - $this->padding[1];
		} else {
			if ($this->position & PHPChart::LEFT) {
				$this->xleft = $x1 + $this->margin[3]  + $this->padding[3];
				$this->xright = $this->xleft + $this->width;
			} else {
				$this->xright = $x2 - $this->margin[1]  - $this->padding[1];
				$this->xleft = $this->xright - $this->width;
				$x2 = $this->xleft;
			}
		}
		
		$this->height = $this->ybottom - $this->ytop;
		$this->width = $this->xright - $this->xleft;
		
		$this->getParentComponent()->setSpace(array($x1, $y1, $x2, $y2));
		 
		
	}

	public function setAbsolutePosition($x, $y) {
	
	}
	
	public function setDimension($x, $y) {
		$this->width = $x;
		$this->height = $y;
	}
	
	public function setMargin(array $margin) {
		$this->$margin = $margin;
	}
	
	
	
	function setBackgroundColor($color) {
		$this->backgroundcolor = $color;
	}
	
	abstract function render();
	
	
	abstract function getParentComponent();
} 