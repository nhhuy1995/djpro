<?php
/**
 * Created by PhpStorm.
 * User: hung
 * Date: 28/08/2015
 * Time: 10:43
 */
namespace DjCms\Controller;

use DjCms\Library\Helper;
use DjCms\Library\Makelink;
use DjCms\Models\BaseCollection;
use DjCms\Models\Category;
use DjCms\Models\Media;
use DjCms\Models\Setting;

/**
 * Class ViewcomponentController
 * @package DjCms\Controller
 * Modify module content to display in web
 * like slide show, main menu
 */
class ViewcomponentController extends ControllerBase
{
    const SLIDE_SHOW_KEY = "slide_show_home";
    const CATEGORY_HOME_KEY = "main_category_home";
    const LIST_CATEGORY_TYPE = "list_category_type";
    private $selective_article_key = array(
        "audio" => array(
            "name" => "Audio",
            "key" => "selective_audio",
            "view" => "audio",
            "action" => "setselectiveaudio"
        ),
        "video" => array(
            "name" => "Video",
            "key" => "selective_video",
            "view" => "video",
            "action" => "setselectivevideo"
        ),
        "album" => array(
            "name" => "Album",
            "key" => "selective_album",
            "view" => "album",
            "action" => "setselectivealbum"
        ),
        "playlist" => array(
            "name" => "Playlist",
            "key" => "selective_playlist",
            "view" => "playlist",
            "action" => "setselectiveplaylist"
        ),
        "topic" => array(
            "name" => "Topic",
            "key" => "selective_topic",
            "view" => "topic",
            "action" => "setselectivetopic"
        ),

    );

    protected function createKeyActionToCheckPermission($controllerName, $actionName)
    {
        if ($actionName == "setselectiveaudio"
            || $actionName == "setselectivevideo"
            || $actionName == "setselectivealbum"
            || $actionName == "setselectiveplaylist"
            || $actionName == "setselectivetopic"
        )
            $actionName = "selectivearticle";

        if ($actionName == "listmenuform")
            $actionName = "listmenuindex";
        return parent::createKeyActionToCheckPermission($controllerName, $actionName);
    }

    /**
     * Modify news will display in slideshow
     */
    public function slideshowAction()
    {
        $criteria = array("key" => self::SLIDE_SHOW_KEY);
        if ($this->request->isPost()) {
            $uinfo = (array)$this->session->get('uinfo');
            $postvalue['key'] = self::SLIDE_SHOW_KEY;
            $postvalue['value'] = $this->request->get('slideshow');
            $updateQuery = array(
                '$set' => $postvalue,
                '$push' => array(
                    "usermodify" => array(
                        "uid" => $uinfo['_id'], "datecreate" => time()
                    )
                )
            );
            $this->flash->success($this->getLanguage()->update_success);
            Setting::updateDocument(
                $criteria,
                $updateQuery,
                array("upsert" => true)
            );
        }
        $settingObj = (array)Setting::getCollectionInstance()->findOne($criteria);
        if (!isset($postvalue) || !$postvalue) {
            $settingObj = (array)Setting::getCollectionInstance()->findOne($criteria);
        } else $settingObj = $postvalue;
        if (!count($settingObj['value']))
            $settingObj['value'] = array();
        $listNews = Media::findAndReturnArray(array(
            "condition" => array(
                "_id" => array('$in' => $settingObj['value'])
            ),
            "fields" => array("_id", "name", "priavatar", "datecreate", "type")
        ));
        $listNews = Helper::resortarray($listNews, $settingObj['value'], "_id");
        $this->view->setVar("slideshow", $listNews);
    }

    /**
     * Display form to edit category will show in home page
     */
    public function categoryhomeAction()
    {
        $criteria = array("key" => self::CATEGORY_HOME_KEY);
        if ($this->request->isPost()) {
            $uinfo = (array)$this->session->get('uinfo');
            $postvalue['key'] = self::CATEGORY_HOME_KEY;
            $postvalue['value'] = $this->request->get('slideshow');
            $updateQuery = array(
                '$set' => $postvalue,
                '$push' => array(
                    "usermodify" => array(
                        "uid" => $uinfo['_id'], "datecreate" => time()
                    )
                )
            );
            $this->flash->success($this->getLanguage()->update_success);
            Setting::updateDocument(
                $criteria,
                $updateQuery,
                array("upsert" => true)
            );
        }
        $settingObj = (array)Setting::getCollectionInstance()->findOne($criteria);
        if (!isset($postvalue) || !$postvalue) {
            $settingObj = (array)Setting::getCollectionInstance()->findOne($criteria);
        } else $settingObj = $postvalue;
        if (!count($settingObj['value']))
            $settingObj['value'] = array();
        $listNews = Category::findAndReturnArray(array(
            "condition" => array(
                "_id" => array('$in' => $settingObj['value'])
            ),
            "fields" => array("_id", "name", "type")
        ));
        $listNews = Helper::resortarray($listNews, $settingObj['value'], "_id");
        $this->view->setVar("slideshow", $listNews);
    }

    public function listmenuindexAction()
    {
        $criteria = array(
            "condition" => array(
                "type" => self::LIST_CATEGORY_TYPE
            )
        );
        $settingObj = Setting::findAndReturnArray($criteria);
        $this->view->setVar("listMenu", $settingObj);
    }

    public function listmenuformAction()
    {
        if ($this->request->isPost()) {
            $postvalue = Helper::post_to_array("_id,name,key,description");
            $listItemPost = $this->request->get('listData');
            $listItem = $this->analysisMenu($listItemPost);
            $postvalue['value'] = $listItem;
            $postvalue['type'] = self::LIST_CATEGORY_TYPE;

            $uinfo = (array)$this->session->get('uinfo');
            $itemId = $postvalue['_id'];
            unset($postvalue['_id']);
            if (strlen($itemId)) {
                $updateQuery = array(
                    '$set' => $postvalue,
                    '$push' => array(
                        "usermodify" => array(
                            "uid" => $uinfo['_id'], "datecreate" => time()
                        )
                    )
                );
                Setting::updateDocument(
                    array("_id" => new \MongoId($itemId)),
                    $updateQuery,
                    array("upsert" => true)
                );
            } else {
                Setting::insertDocument($postvalue);
            }
            $this->jsonResponse(array(
                'status' => 1,
                'message' => "success"
            ));
        } else {
            $_id = $this->request->get("_id");
            $criteria = array("_id" => new \MongoId($_id));
            $settingObj = (array)Setting::getCollectionInstance()->findOne($criteria);
            $this->view->setVar("settingObj", $settingObj);
        }
    }

    protected function analysisMenu($listItemPost)
    {
        $listCategory = Category::findAndReturnArray(array(), true);
        foreach ($listItemPost as $key => $value) {
            $orderItemId[] = $value['item_id'];
            $listItemPost[$key]['order_id'] = $key;
            $listItemPost[$key]['depth'] = intval($listItemPost[$key]['depth']);
        }

        usort($listItemPost, array('self', 'sortArrayByDepth'));
        $listItem = array_reverse($listItemPost);
        foreach ($listItem as $key => $value) {
            if (strlen($value['cat_id'])) {
                $category = $listCategory[$value['cat_id']];
                $title = $category['name'];
                $listItem[$key]['title'] = $title;
                if ($category['type'] == "video")
                    $listItem[$key]['link'] = Makelink::link_view_category_video($category['name'], $category['_id']);
                else if ($category['type'] == "audio")
                    $listItem[$key]['link'] = Makelink::link_view_category_music($category['name'], $category['_id']);
                else if ($category['type'] == "artist")
                    $listItem[$key]['link'] = Makelink::link_view_category_artist($category['name'], $category['_id']);
                else if ($category['type'] == "news")
                    $listItem[$key]['link'] = Makelink::link_view_category_news($category['name'], $category['_id']);
                else if ($category['type'] == "images")
                    $listItem[$key]['link'] = Makelink::link_view_category_images($category['name'], $category['_id']);
                else
                    $listItem[$key]['link'] = Makelink::link_view_category_playlist($category['name'], $category['_id']);
            }
            if (strlen($value['parent_id'])) {
                foreach ($listItem as $subKey => $subElem) {
                    if (!strcmp($subElem['item_id'], $value['parent_id'])) {
                        $listItem[$subKey]['child'][] = $listItem[$key];
                        break;
                    }
                }
                unset($listItem[$key]);
            }
        }
        $listItem = Helper::resortarray($listItem, $orderItemId, 'item_id');
        foreach ($listItem as $key => $value) {
            if (!empty($value['child']))
                $listItem[$key]['child'] = array_reverse($value['child']);
        }
        return $listItem;
    }

    protected function sortArrayByDepth($a, $b)
    {
        $compareDepth = $a['depth'] - $b['depth'];
        if ($compareDepth !== 0)
            return $compareDepth;
        return $a['order_id'] - $b['order_id'];
    }

    /*************************  Set selective by type *************************/
    public function selectivearticleAction()
    {
        $this->view->pick("viewcomponent/selectivearticle/index");
        $this->view->setVar("listCollection", $this->selective_article_key);
    }

    public function setselectiveaudioAction()
    {
        $this->setSelectiveMethod('audio', 'DjCms\Models\Media');
    }

    public function setselectivevideoAction()
    {
        $this->setSelectiveMethod('video', 'DjCms\Models\Media');
    }

    public function setselectiveplaylistAction()
    {
        $this->setSelectiveMethod('playlist', 'DjCms\Models\Album');
    }

    public function setselectivealbumAction()
    {
        $this->setSelectiveMethod('album', 'DjCms\Models\Album');
    }

    public function setselectivetopicAction()
    {
        $this->setSelectiveMethod('topic', 'DjCms\Models\Album');
    }

    /**
     * @desc Set proper view to set selective article
     * @param $type string
     * @param $collection BaseCollection
     */
    protected function setSelectiveMethod($type, $collection)
    {
        $keyName = $this->selective_article_key[$type]['key'];
        $viewPage = $this->selective_article_key[$type]['view'];
        $criteria = array("key" => $keyName);
        if ($this->request->isPost()) {
            $uinfo = (array)$this->session->get('uinfo');
            $postvalue['key'] = $keyName;
            $postvalue['value'] = array_values(array_unique($this->request->get('slideshow')));
            $updateQuery = array(
                '$set' => $postvalue,
                '$push' => array(
                    "usermodify" => array(
                        "uid" => $uinfo['_id'], "datecreate" => time()
                    )
                )
            );
            $this->flash->success($this->getLanguage()->update_success);
            Setting::updateDocument(
                $criteria,
                $updateQuery,
                array("upsert" => true)
            );
        }
        $settingObj = (array)Setting::getCollectionInstance()->findOne($criteria);
        if (!isset($postvalue) || !$postvalue) {
            $settingObj = (array)Setting::getCollectionInstance()->findOne($criteria);
        } else $settingObj = $postvalue;
        if (!count($settingObj['value']))
            $settingObj['value'] = array();
        $listNews = $collection::findAndReturnArray(array(
            "condition" => array(
                "_id" => array('$in' => $settingObj['value'])
            ),
            "fields" => array("_id", "name", "priavatar", "datecreate", "type")
        ));
        $listNews = Helper::resortarray($listNews, $settingObj['value'], "_id");
        $this->view->pick("viewcomponent/selectivearticle/" . $viewPage);
        $this->view->setVar("slideshow", $listNews);
    }

    /*******************************************************************************/

}