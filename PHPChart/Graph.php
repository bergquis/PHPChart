<?php


class PHPChart_Graph extends PHPChart_AbstractChart {
	
	private $xstep = 5;
	private $ystep = 1;
	private $xmin = null;
	private $xmax = null;
	private $ymin = null;
	private $ymax = null;
	private $dx = 0;
	private $dy = 0;
	
	private $linefillalpha = 0;
	
	private $lines = array();
	
	function setLineFillAlpha($alpha) {
		$this->linefillalpha = $alpha;
	}
	
	function getLineFillAlpha() {
		return $this->linefillalpha;
	}
	
	function getLabels() {
		$labels = array();
		foreach($this->lines as $line) {
			$labels[$line->getName()] = $line->getColor(); 
		}
		return $labels;
	}
	
	
	
	function drawLineFill(PHPChart_Graph_Line $line){
		//Draw the polygons
		foreach($line->getdata() as $data) {
			$this->chart->getDriver()->setStrokeColor( new ImagickPixel( $line->getColor() ) );
			$this->chart->getDriver()->setStrokeWidth($line->getWidth());
			
			//draw polygon
			
			list($x, $y) = each($data);
			
			list($x, $y) = each($this->calculateCoordinate(array($x=>$y)));
			
			$points[] = array('y' => $this->ybottom, 'x' => $x);
			foreach ($data as $key => $val) {
				list($x, $y) = each($this->calculateCoordinate(array($key=>$val)));	
				$points[] = array('y' => $y, 'x' => $x); 
			
			}
			$points[] = array('y' => $this->ybottom, 'x' => $x);
			
			$color = $line->getColor(); 
			
			$this->chart->getDriver()->setStrokeColor( new ImagickPixel( $color . '00') );
			$this->chart->getDriver()->setFillColor( new ImagickPixel( $color . sprintf("%02x", $line->getLineFillAlpha())) );
			$this->chart->getDriver()->drawPolygon($points);
			
			
		}
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
	
	
	function drawLine(PHPChart_Graph_Line $line) {
				
		
		
		//Draw the line
		foreach($line->getdata() as $data) {
			$this->chart->getDriver()->setStrokeColor( new ImagickPixel( $line->getColor()) );
			$this->chart->getDriver()->setStrokeWidth($line->getWidth());
			$oldval = false;
			foreach ($data as $key => $val) {
				$thisval = array($key => $val);
				if ($oldval) {
					list($rx1, $ry1) = each($this->calculateCoordinate($oldval));
					list($rx2, $ry2) = each($this->calculateCoordinate($thisval));
					//var_dump($rx1, $ry1, $rx2, $ry2, $this->dx, $this->dy);
					$this->chart->getDriver()->drawline($rx1, $ry1, $rx2, $ry2);
					//$this->id->circle($rx1, $ry1, $rx1+1, $ry1+1);
				}
				$oldval = $thisval;		
			}
			
			
					
			
		}
		
	
	}
	
	function calculateCoordinate(array $point) {
		list($x, $y) = each($point);
		
		$rx = $this->xleft + ($x-1) * $this->dx;
		
		
		$ry = $this->ytop + ($y-1) * $this->dy;
		return array($rx=> $ry);
		
	}
	
	function adjustDimensions() {
		
		//adjust for axis space and such
		$this->xleft += 30;
		$this->ytop += 5;
		$this->ybottom -= 20;
		$this->xright -= 10;
	}
	
	function render() {
		$this->calculateDimensions();
		$this->drawBackground();
		$this->adjustDimensions();
		
		$this->createAxis();
		
		foreach($this->lines as $line) {		
			$this->drawLineFill($line);	
		}
		foreach($this->lines as $line) {
				
			$this->drawLine($line);	
		}
		
	}
	
	
	
	
	function addLine(PHPChart_Graph_Line $line) {
		$line->setGraph($this);
		$this->lines[] = $line;
	}
	
	function setYMax($v)  {
		$this->ymax= $v;
	}
	
	function setYMin($v)  {
		$this->ymin= $v;
	}
	
	function calculateAxisSteps() {
		
		
		
		$adjustxmax = $this->xmax === null;
		$adjustymax = $this->ymax === null;
		$adjustxmin = $this->xmin === null;
		$adjustymin = $this->ymin === null;
		
		if ($this->xmax === null) $this->xmax = -9999;
		if ($this->ymax === null) $this->ymax = -9999;
		if ($this->xmin === null) $this->xmin = 9999;
		if ($this->ymin === null) $this->ymin = 9999;
		
		foreach ($this->lines as $line) {
			list($xmax, $xmin, $ymax, $ymin) = $line->getBoundaries();
			if ($adjustxmax && $this->xmax < $xmax) $this->xmax = $xmax;
			if ($adjustxmin && $this->xmin > $xmin) $this->xmin = $xmin;
			if ($adjustymax && $this->ymax < $ymax) $this->ymax = $ymax;
			if ($adjustymin && $this->ymin > $ymin) $this->ymin = $ymin; 
		}
		
		if ($this->ymax == $this->ymin ) throw new Exception("Graph values are illegal. Both the max and min value for the y-axis are " . $this->ymax);
		if ($this->xmax == $this->xmin ) throw new Exception("Graph values are illegal. Both the max and min value for the x-axis are " . $this->xmin);

		$this->dy = ($this->ybottom-$this->ytop) / ($this->ymax - $this->ymin) ;
		$this->dx =  ($this->xright-$this->xleft) / ($this->xmax - $this->ymin) ;
	}
	
	
	function createAxis() {
		//y axis
		$this->calculateAxisSteps();
		$this->chart->getdriver()->setstrokecolor('black');
		$this->chart->getdriver()->drawline($this->xleft, $this->ytop, $this->xleft, $this->ybottom);
		
		//draw some lines;
		$pstep = $this->dy;
		for ($i = $this->ymin; $i <= $this->ymax; $i+=$this->ystep) {
			$ci =  $i - $this->ymin ;
			$this->chart->getdriver()->drawline($this->xleft-5, $this->ytop + $ci * $pstep, $this->xleft+5, $this->ytop + $ci * $pstep);
			$this->chart->getdriver()->text($this->xleft-30, $this->ytop + $ci * $pstep + 4, $ci + 1);
		}
		
				
		
		$this->chart->getdriver()->drawline($this->xleft, $this->ybottom, $this->xright, $this->ybottom);
		
		//draw some lines;
		$pstep = $this->dx;
		for ($i = $this->xmin; $i <= $this->xmax; $i+=$this->xstep) {
			$ci =  $i - $this->xmin ;
			//var_dump($this->xright);die;
			$this->chart->getdriver()->drawline($this->xleft + $ci * $pstep, $this->ybottom-5, $this->xleft + $ci * $pstep, $this->ybottom+5 );
			$this->chart->getdriver()->text($this->xleft + $ci * $pstep - 4, $this->ybottom + 16, $ci + 1);
			
		}
		
	}
	
	
	
	
} 