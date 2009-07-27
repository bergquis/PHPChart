<?php


class PHPChart_Graph extends PHPChart_AbstractChart {
	
	private $xstep = 20;
	private $ystep = 16;
	private $xmax = 40;
	private $xmin = 1;
	private $ymax = 20;
	private $ymin = 1;
	private $dx = 0;
	private $dy = 0;
	
	private $lines = array();
	
	function getLabels() {
		$labels = array();
		foreach($this->lines as $line) {
			$labels[$line->getName()] = $line->getColor(); 
		}
	}
	
	
	
	function drawLine(PHPChart_Graph_Line $line) {
				
		
		foreach($line->getdata() as $data) {
			$this->chart->getDriver()->setStrokeColor( new ImagickPixel( $line->getColor() ) );
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
			//draw polygon
			
			list($x, $y) = each($data);
			
			list($x, $y) = each($this->calculateCoordinate(array($x=>$y)));
			
			$points[] = array('y' => $this->ybottom, 'x' => $x);
			foreach ($data as $key => $val) {
				list($x, $y) = each($this->calculateCoordinate(array($key=>$val)));	
				$points[] = array('y' => $y, 'x' => $x); 
			
			}
			$points[] = array('y' => $this->ybottom, 'x' => $x);
			$this->chart->getDriver()->setStrokeColor( new ImagickPixel( $line->getColor() . '00') );
			$this->chart->getDriver()->setFillColor( new ImagickPixel( $line->getColor() . '44') );
			$this->chart->getDriver()->drawPolygon($points);
			
			
		}
	
	}
	
	function calculateCoordinate(array $point) {
		list($x, $y) = each($point);
		
		$rx = $this->xleft + $x * $this->dx;
		
		
		$ry = $this->ytop + ($y-1) * $this->dy;
		return array($rx=> $ry);
		
	}
	
	function render() {
		$this->calculateDimensions();
		$this->createAxis();
		foreach($this->lines as $line) {	
			$this->drawLine($line);	
		}
	}
	
	
	
	
	function addLine(PHPChart_Graph_Line $line) {
	
		$this->lines[] = $line;
	}
	
	
	
	function createAxis() {
		//y axis
			
		$this->chart->getdriver()->drawline($this->xleft, $this->ytop, $this->xleft, $this->ybottom);
		
		//draw some lines;
		$this->dy = $pstep = ($this->ybottom-$this->ytop) / $this->ystep ;
		for ($i = 0; $this->ytop + ($i + 1) * $pstep <= $this->ybottom; $i+=1) {
			$this->chart->getdriver()->drawline($this->xleft-5, $this->ytop + $i * $pstep, $this->xleft+5, $this->ytop + $i * $pstep);
			$this->chart->getdriver()->text($this->xleft-30, $this->ytop + $i * $pstep + 4, $i + 1);
		}
		
				
		
		$this->chart->getdriver()->drawline($this->xleft, $this->ybottom, $this->xright, $this->ybottom);
		
		//draw some lines;
		$this->dx = $pstep = ($this->xright-$this->xleft) / $this->xstep ;
		for ($i = 1; $this->xleft + $i * $pstep <= $this->xright; $i+=1) {
			//var_dump($this->xright);die;
			$this->chart->getdriver()->drawline($this->xleft + $i * $pstep, $this->ybottom-5, $this->xleft + $i * $pstep, $this->ybottom+5 );
			$this->chart->getdriver()->text($this->xleft + $i * $pstep - 4, $this->ybottom + 16, $i);
			
		}
		
	
		
		
		
		
	}
	
	
	
	
} 