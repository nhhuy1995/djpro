<?php
namespace DjClient\Controller;


use DjClient\Library\Helper;
use DjClient\Library\Makelink;
use DjClient\Models\Category;
use DjClient\Models\Comment;
use DjClient\Models\Media;
use DjClient\Models\Notify;
use DjClient\Models\Tags;

class ImagesController extends ControllerBase
{
    public static $TYPE_IMAGES = 'images';

    public function indexAction()
    {

        $p = $_GET['p'];
        if ($p <= 1) $p = 1;
        $limit = 6;
        $skip = ($p - 1) * $limit;
        $listImages = Media::findAndReturnArray(array(
            'condition' => array('type' => static::$TYPE_IMAGES, 'status' => static::$STATUS_ON),
            'skip' => $skip,
            'limit' => $limit,
            'sort' => array('datecreate' => -1),
        ));
        $data = array();
        foreach ($listImages as $item) {
            $item['link'] = Makelink::link_view_article($item['name'], $item['_id']);
            $data[] = $item;
        }
        $count = Media::findAndReturnArray(array(
            'condition' => array('type' => static::$TYPE_IMAGES, 'status' => static::$STATUS_ON),
        ));
        $this->breadCrumbs->addItem(array(), static::$TYPE_IMAGES);
        $this->view->painginfo = Helper::paginginfo(count($count), $limit, $p);
        $this->view->listimages = $data;
        $this->view->title = "Ảnh";

        $this->view->ads = $this->getAdsSidebarRight();
        $this->view->header = Helper::setHeader('Ảnh','', '');
    }

    public function categoryAction()
    {
        $catid = $this->dispatcher->getParam('catId');
        $catinfo = Category::findById($catid);
        if ($catinfo == false) $this->response->redirect('/error.html');
        else {
            $catinfo->link = Makelink::link_view_category_images($catinfo->name, $catinfo->getId());
            $p = $_GET['p'];
            if ($p <= 1) $p = 1;
            $limit = 6;
            $skip = ($p - 1) * $limit;
            $listImages = Media::findAndReturnArray(array(
                'condition' => array('type' => static::$TYPE_IMAGES, 'category' => $catid, 'status' => static::$STATUS_ON),
                'skip' => $skip,
                'limit' => $limit,
                'sort' => array('datecreate' => -1),
            ));
            $data = array();
            foreach ($listImages as $item) {
                $item['link'] = Makelink::link_view_article($item['name'], $item['_id']);
                $data[] = $item;
            }
            $count = Media::findAndReturnArray(array(
                'condition' => array('type' => static::$TYPE_IMAGES, 'category' => $catid, 'status' => static::$STATUS_ON),
            ));
            $this->breadCrumbs->addItem($catinfo->toArray(), static::$TYPE_IMAGES);
            $this->view->painginfo = Helper::paginginfo(count($count), $limit, $p);
            $this->view->listimages = $data;
            $this->view->catinfo = $catinfo;
            $this->view->header = Helper::setHeader($catinfo->name,'', '');
        }
    }
}

