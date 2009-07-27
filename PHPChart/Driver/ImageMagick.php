<?php
class PHPChart_Driver_ImageMagick extends PHPChart_Driver {
	
	private $id;
	private $im;

	
	function init($width, $height, $background, $format) {
		$img = new Imagick();
		$this->id = new ImagickDraw();
		
		$img->newImage( $width, $height, new ImagickPixel( $background ) );
		$img->setImageFormat( "png" );
		$this->im  = $img;
	}
	
	function setFillColor($color) {
		
		$this->id->setFillColor($color);
		
	}
	
	function drawPieSegment($pie, $angle, $rot) {
			list($x, $y) = $pie->getCenter();
			list($xrad, $yrad) = $pie->getRad();

			$cx = $x + $xrad * cos(deg2rad($rot));
			$cy = $y + $yrad * sin(deg2rad($rot));
			
			$cx2 = $x + $xrad * cos(deg2rad($rot + $angle));
			$cy2 = $y + $yrad * sin(deg2rad($rot + $angle));
					
			//Line from center to c
			$this->id->pathStart();
			$this->id->pathMoveToAbsolute($x, $y);
			$this->id->pathLineToAbsolute($cx, $cy);
			//$this->id->line($x, $y, $cx, $cy);
			//var_dump($x, $y, $cx, $cy);
			//Draw the arc
			
			$this->id->PathEllipticArcAbsolute($xrad, $yrad, 0, $angle > 180, true, $cx2, $cy2);
			//$this->id->arc($this->xleft, $this->ytop, $this->xright, $this->ybottom, $rot, $rot + $angle);
			
			//Draw the last line from arc to center
			$this->id->PathLineToAbsolute($x, $y);
			$this->id->pathFinish();
			
			//Draw the depth
			//Draw the line down
			$c = $this->id->getFillColor();
			$hsl = $c->getHSL();
			
			$c->setHSL($hsl['hue'], $hsl['saturation'], $hsl['luminosity'] *  0.7);
			$this->id->setFillColor($c);
			if (sin(deg2rad($rot)) > 0 || sin(deg2rad($rot+$angle)) > 0 || $angle >= 180) {
				if (cos(deg2rad($rot)) < cos(deg2rad($rot+$angle)) && sin(deg2rad($rot)) > 0 && sin(deg2rad($rot+$angle)) > 0 ) {
					$cx2 = $x + $xrad * cos(deg2rad(180));
					$cy2 = $y + $yrad * sin(deg2rad(180));
					$this->id->pathStart();
					$this->id->pathMoveToAbsolute($cx, $cy);
					$this->id->pathLineToAbsolute($cx, $cy + 40);
					$this->id->PathEllipticArcAbsolute($xrad, $yrad, 0, 0, true, $cx2, $cy2 + 40);
					$this->id->pathLineToAbsolute($cx2,$cy2);
					$this->id->PathEllipticArcAbsolute($xrad, $yrad, 0, 0, false, $cx, $cy);
					$this->id->pathFinish();
					$cx2 = $x + $xrad * cos(deg2rad($rot+$angle));
					$cy2 = $y + $yrad * sin(deg2rad($rot+$angle));
					$cx = $x + $xrad * cos(deg2rad(0));
					$cy = $y + $yrad * sin(deg2rad(0));
				}
				if (sin(deg2rad($rot+$angle)) < 0) {
					$cx2 = $x + $xrad * cos(deg2rad(180));
					$cy2 = $y + $yrad * sin(deg2rad(180));
				}
				if (sin(deg2rad($rot)) < 0) {
					$cx = $x + $xrad * cos(deg2rad(0));
					$cy = $y + $yrad * sin(deg2rad(0));
				}
				$this->id->pathStart();
				$this->id->pathMoveToAbsolute($cx, $cy);
				$this->id->pathLineToAbsolute($cx, $cy + 40);
				$this->id->PathEllipticArcAbsolute($xrad, $yrad, 0, 0, true, $cx2, $cy2 + 40);
				$this->id->pathLineToAbsolute($cx2,$cy2);
				$this->id->PathEllipticArcAbsolute($xrad, $yrad, 0, 0, false, $cx, $cy);
				$this->id->pathFinish();
			}
	
	}
	
	function text($x1, $y1, $string) {
		$this->id->annotation($x1, $y1, $string);
	}
	
	
	
	function setStrokeColor($color) {
		$this->id->setStrokeColor($color);
	}	
	
	function setStrokeWidth($size) {
		$this->id->setStrokeWidth($size);
	}
	
	
	function drawLine($x1, $y1, $x2, $y2) {
		$this->id->line($x1, $y1, $x2, $y2);
	}
	
	function drawPolygon(array $points) {
		$this->id->polygon($points);
	}
	
	function getImage() {
		$this->im->drawImage($this->id);
		return $this->im;
	}
	
}