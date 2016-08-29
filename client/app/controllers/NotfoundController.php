<?php
namespace DjClient\Controller;
use DjClient\Library\Helper;
use Phalcon\Mvc\View;
class NotfoundController extends ControllerBase
{
    public function show404Action()
    {
        $this->response->setStatusCode(404, 'Not Found');
//        $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);
//        $this->view->disableLevel(View::LEVEL_MAIN_LAYOUT);
        $this->view->header = Helper::setHeader("Không tìm thấy trang");
    }
}