<?php


class PHPChart_Graph extends PHPChart_AbstractChart {
	
	private $xstep = 1;
	private $ystep = 1;
	private $xmin = 9999;
	private $xmax = -9999;
	private $ymin = 9999;
	private $ymax = -9999;
	private $dx = 0;
	private $dy = 0;
	
	private $lines = array();
	
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
			$this->chart->getDriver()->setFillColor( new ImagickPixel( $color . '44') );
			$this->chart->getDriver()->drawPolygon($points);
			
			
		}
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
		
		$rx = $this->xleft + $x * $this->dx;
		
		
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
	
	function calculateAxisSteps() {
		
		foreach ($this->lines as $line) {
			list($xmax, $xmin, $ymax, $ymin) = $line->getBoundaries();
			if ($this->xmax < $xmax) $this->xmax = $xmax;
			if ($this->xmin > $xmin) $this->xmin = $xmin;
			if ($this->ymax < $ymax) $this->ymax = $ymax;
			if ($this->ymin > $ymin) $this->ymin = $ymin; 
		}
		
		$this->dy = ($this->ybottom-$this->ytop) / ($this->ymax - $this->ymin + 1) ;
		$this->dx =  ($this->xright-$this->xleft) / ($this->xmax - $this->ymin + 1) ;
	}
	
	
	function createAxis() {
		//y axis
		$this->calculateAxisSteps();
		$this->chart->getdriver()->drawline($this->xleft, $this->ytop, $this->xleft, $this->ybottom);
		
		//draw some lines;
		$pstep = $this->dy;
		for ($i = 0; $this->ytop + ($i + 1) * $pstep <= $this->ybottom; $i+=1) {
			$this->chart->getdriver()->drawline($this->xleft-5, $this->ytop + $i * $pstep, $this->xleft+5, $this->ytop + $i * $pstep);
			$this->chart->getdriver()->text($this->xleft-30, $this->ytop + $i * $pstep + 4, $i + 1);
		}
		
				
		
		$this->chart->getdriver()->drawline($this->xleft, $this->ybottom, $this->xright, $this->ybottom);
		
		//draw some lines;
		$pstep = $this->dx;
		for ($i = 1; $this->xleft + $i * $pstep <= $this->xright; $i+=1) {
			//var_dump($this->xright);die;
			$this->chart->getdriver()->drawline($this->xleft + $i * $pstep, $this->ybottom-5, $this->xleft + $i * $pstep, $this->ybottom+5 );
			$this->chart->getdriver()->text($this->xleft + $i * $pstep - 4, $this->ybottom + 16, $i);
			
		}
		
	}
	
	
	
	
} 