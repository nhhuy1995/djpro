<?php
class BreadCrumb {
	private $_controller;
	private $_action;
	private $_id;
	private $_slug;
	
	public function __contruct(){
		
	}
	
	public function generate($config, $controller, $action, $params){
		if ($controller && $action){
			$this->_controller = $controller;
			$this->_action = $action;
			
			$this->_id = isset($params['id']) ? $params['id'] : 0;
			
			$this->_slug = isset($params['slug']) ? $params['slug'] : '';
			
			switch ($controller){
				case 'topic':
					return self::topic();
					break;
			}
		}
	}
	
	private function category(){
		
		return $aryBreadCrumbs;
	}
	
	/**
	 * breadCrumb for topic
	 * @return multitype:string multitype:string NULL
	 */
	private function topic(){
		$aryBreadCrumbs[] = array(
				'url' => '/chu-de', 
				'text' => 'Chủ đề'
		);
		
		if ($this->_action == 'view'){
// 			$typeMusic = TypeMusic::findFirst(array(
// 					"conditions" => array(
// 							"_id" => "$this->_id"
// 					)
// 			));
			
			$aryBreadCrumbs[] = array(
					'url' => Helper::makeTopicLink($this->_slug, $this->_id),
					'text' => 'Nghe chủ đề'
			);
		}
		
		return $aryBreadCrumbs;
	}
}