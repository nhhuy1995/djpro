<?php
namespace DjClient\Controller;
use Phalcon\Mvc\View;
class ErrorController extends ControllerBase
{ 
    public function show404Action()
    {
        echo 1;die;
        $this->response->setStatusCode(404, 'Not Found');
        $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);
//        $this->view->disableLevel(View::LEVEL_MAIN_LAYOUT);
    }
}