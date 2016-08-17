<?php
namespace DjClient\Services;

use DjClient\Library\Makelink;
use DjClient\Models\Category;
use DjCms\Models\Setting;
use Phalcon\Mvc\User\Component;

class ViewComponent extends Component {

    const MAIN_MENU_HOME = "main_menu_index";
    const MAIN_MENU_DETAIL_PAGE = "main_menu_detail";

    /**
     * @desc Use to create Main menu for page
     * @param $menuName string Menu key value
     */
    public function createMenu($menuName) {
        $menuDetail =  (array) Setting::getCollectionInstance()->findOne(
            array(
                "key" => $menuName
            )
        );
        $this->view->setVar('main_menu', $menuDetail);
    }

    /**
     * @desc Use to create breadcrumb for page
     * @param $categoryId string id of article's category
     *        or own id of category
     * @param $listCategory array Just use to recursive so
     *         don't pass any variable to this
     * @return mixed Category Detail
     */
    public function createBreadcrumb($categoryId, &$listCategory = array()) {
        $catObj = (array) Category::getCollectionInstance()
            ->findOne(array(
                "_id" => $categoryId
            ));
        if ($catObj['type'] == "audio") {
            $catObj['link'] = Makelink::link_view_category_music($catObj['name'], $catObj['_id']);
        }
        if ($catObj['type'] == "video") {
            $catObj['link'] = Makelink::link_view_category_video($catObj['name'], $catObj['_id']);
        }
        if (!count($listCategory)) $catType = $catObj['type'];
        if ($catObj) {
            $listCategory[] = $catObj;
            if ($catObj['parentid']) {
                $this->createBreadcrumb($catObj['parentid'], $listCategory);

            }
        }
        if (isset($catObj['type'])) {
            return $this->prependMainCategory($catType, array_reverse($listCategory));
        }
    }

    /**
     * @desc Prepend Main category for list of category
     * @param $catType string type of category
     * @param $listCategory array list of category
     * @return mixed list category after prepend
     */
    private function prependMainCategory($catType, $listCategory) {
        if ($catType == "audio") {
            array_unshift($listCategory, array(
                "name" => "Nhạc sàn",
                "link" => "/nhac-san.html"
            ));
        }
        if ($catType == "video") {
            array_unshift($listCategory, array(
                "name" => "Video",
                "link" => "/video.html"
            ));
        }
        return $listCategory;
    }
}