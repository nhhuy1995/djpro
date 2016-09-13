<?php
namespace DjCms\Controller;

use DjCms\Library\Helper;
use DjCms\Library\Makelink;
use DjCms\Models\Ads;

class AdsController extends ControllerBase
{
    public function indexAction()
    {
        
    }

    public function homepageAction() {}

    public function homepagetabletAction() {}
    
    public function homepagemobileAction() {}
    
    public function musicplaypageAction() {}

    public function afterExecuteRoute()
    {
    	$ads = new Ads();
       	$this->view->ads = (object) $ads->getAdsPosition();
    }
}