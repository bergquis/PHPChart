<?php

class PHPChart_Graph_Line {
	
	private $color = '#000000';
	private $width = 2;
	private $data;
	private $name;
	
	function __construct($name) {
		$this->name = $name;
	}
	
	function getName() {
		return $this->name;
	}
	
	function appendData(array $set) {
		$this->data[] = $set;
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