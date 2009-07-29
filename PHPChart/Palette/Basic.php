<?php


class PHPChart_Palette_Basic extends PHPChart_Palette {
	
	private $palette = array(
		'#ff0000',
		'#0ff000',
		'#00ffff',
		'#000ff0',
		'#fffff0',
		'#ffffff',
		'#0fffff',
	) ;
	
	private $i = 0;
	
	function getNextColor() {
		return $this->palette[$this->i++];
	}
	
	
}