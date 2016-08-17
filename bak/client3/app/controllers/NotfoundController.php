<?php
namespace DjClient\Controller;
use Phalcon\Mvc\View;
class NotfoundController extends ControllerBase
{
    public function show404Action()
    {
        $this->response->setStatusCode(404, 'Not Found');
//        $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);
//        $this->view->disableLevel(View::LEVEL_MAIN_LAYOUT);
        $this->view->setVars(array(
            "title" => "Không tìm thấy trang",
        ));
    }
}