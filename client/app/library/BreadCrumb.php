<?php
namespace DjClient\Library;

class BreadCrumb {
	protected $items;
	public function __construct(){
		$this->items = array();
	}
	
	public function addItem($item) {
		array_push($this->items, $item);
	}

	public function addListItems($items) {
		$this->items = array_merge((array)$this->items, $items);
	}

	public function getItems() {
		return $this->items;
	}
}