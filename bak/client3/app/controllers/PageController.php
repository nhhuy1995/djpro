<?php
class PageController extends ControllerBase {
	protected $_fileDir = "page/%s.php";
	
	protected $_fileDefault = 'page/404.php';
	/**
	 * noi dung chi tiet cua trang
	 */
	public function viewAction($slug) {
		$file = sprintf($this->_fileDir, $slug);
		if (file_exists($file)){
			$fileContent = file_get_contents($file);
			echo $fileContent;
		} else {
			$fileContent = file_get_contents($this->_fileDefault);
			echo $fileContent;
		}
	}
}