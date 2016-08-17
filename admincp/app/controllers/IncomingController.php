<?php
namespace DjCms\Controller;

use DjCms\Models\Artist;
use DjCms\Library\CreateLink;
use DjCms\Library\Helper;
use DjCms\Models\Album;
use DjCms\Models\Category;
use DjCms\Models\Media;
use DjCms\Models\News;
use DjCms\Models\Tag;
use DjCms\Models\Topic;

class IncomingController extends ControllerBase
{
    /**
     *  We don't need to check permission in this now
     *  TODO: need check permission via dependency action
     */
    public function beforeExecuteRoute()
    {

    }

    public function getlistcategoryAction()
    {
        $categorycl = Category::getCollectionInstance();
        $keyword = $_GET['q'];
        $limit = 20;
        if (strlen($keyword) > 0) $query = array('$text' => array('$search' => "\"$keyword\""));
        $data = iterator_to_array($categorycl->find($query)->limit($limit)->sort(array("sort" => 1)), false);
        foreach($data as &$item){
            if($item['type'] == 'audio') $item['typeconvert'] = 'Bài hát';
            if($item['type'] == 'video') $item['typeconvert'] = 'Video';
            if($item['type'] == 'playlist') $item['typeconvert'] = 'Playlist';
            if($item['type'] == 'album') $item['typeconvert'] = 'Album';
            if($item['type'] == 'topic') $item['typeconvert'] = 'Chủ đề';
            if($item['type'] == 'news') $item['typeconvert'] = 'Tin tức';
            if($item['type'] == 'images') $item['typeconvert'] = 'Hình ảnh';
            if($item['type'] == 'artist') $item['typeconvert'] = 'Nghệ sĩ';
        }
        $dtr['status'] = 1;
        $dtr['mss'] = 'Success';
        $dtr['data'] = $data;
        header("Content-Type:application/json;charset=utf-8");
        echo json_encode($dtr);
        die;
    }


    public function changeitemnewsAction()
    {
        $id = $_GET['id'];
        $value = $_GET['value'];
        $name = $_GET['name'];
        Media::updateDocument(array('_id' => $id), array('$set' => array($name => intval($value))));
        $dtr['status'] = 1;
        $dtr['mss'] = "Success";
        header("Content-Type:application/json;charset=utf-8");
        echo json_encode($dtr);
        die;
    }

    public function changeitemalbumAction()
    {
        $id = $_GET['id'];
        $value = $_GET['value'];
        $name = $_GET['name'];
        Album::updateDocument(array('_id' => $id), array('$set' => array($name => intval($value))));
        $dtr['status'] = 1;
        $dtr['mss'] = "Success";
        header("Content-Type:application/json;charset=utf-8");
        echo json_encode($dtr);
        die;
    }

    public function changestatusnewsAction()
    {

        $id = $_GET['id'];
        $status = $_GET['value'];
        $result = Media::updateDocument(array('_id' => $id), array('$set' => array('status' => intval($status))));
        if ($result) {
            $dtr['status'] = 1;
            $dtr['mss'] = "Success";
        } else {
            $dtr['status'] = 2;
            $dtr['mss'] = "Error";
        }
        header("Content-Type:application/json;charset=utf-8");
        echo json_encode($dtr);
        die;

    }

    public function changestatusalbumAction()
    {

        $id = $_GET['id'];
        $status = $_GET['value'];
        $result = Album::updateDocument(array('_id' => $id), array('$set' => array('status' => intval($status))));
        if ($result) {
            $dtr['status'] = 1;
            $dtr['mss'] = "Success";
        } else {
            $dtr['status'] = 2;
            $dtr['mss'] = "Error";
        }
        header("Content-Type:application/json;charset=utf-8");
        echo json_encode($dtr);
        die;

    }

    public function changestatustopicAction()
    {

        $id = $_GET['id'];
        $status = $_GET['value'];
        $result = Topic::updateDocument(array('_id' => $id), array('$set' => array('status' => intval($status))));
        if ($result) {
            $dtr['status'] = 1;
            $dtr['mss'] = "Success";
        } else {
            $dtr['status'] = 2;
            $dtr['mss'] = "Error";
        }
        header("Content-Type:application/json;charset=utf-8");
        echo json_encode($dtr);
        die;

    }



    public function getlisttagAction()
    {
        $p = $_GET['p'];
        if ($p <= 1) $p = 1;
        $limit = 20;
        $query = array();
        $keyword = Helper::convertToUtf8($this->request->get('q'));
        if (strlen($keyword) > 0)
            $query = array('$text' => array('$search' => "\"$keyword\""));
        $criteria = array(
            "condition" => $query,
            "limit" => $limit,
            "sort" => array("datecreate" => -1)
        );
        $data = Tag::findAndReturnArray($criteria);

        foreach($data as $key => $value) {
            $data[$key]['id'] = $value['_id'];
        }

        $total_count = Tag::count($query);;
//        if ($data) {
            $dtr['status'] = 1;
            $dtr['mss'] = 'Success';
            $dtr['items'] = $data;
            $dtr['total_count'] = $total_count;


//        } else {
//            $dtr['status'] = 2;
//            $dtr['mss'] = 'Error';
//        }

        $this->jsonResponse($dtr);
    }

    public function getlistsongAction()
    {
        $keyword = Helper::convertToUtf8($this->request->get('q'));
        $type = $this->request->get('type');
        if (!strlen($type))
            $type = "audio";

        $query = array(
            '$text' => array('$search' => "\"$keyword\""),
            'type' => $type
        );
        $limit = 20;
        $selectFields = array("name", "_id", "priavatar", "datecreate", "type", "namenonutf");
        ## Filter
        $criteria = array(
            "condition" => $query,
            "fields" => $selectFields,
            "limit" => $limit
        );
        ## bind Data
        $listnewss = Media::findAndReturnArray($criteria);
        foreach ($listnewss as $key => $item) {
            $listnewss[$key]['datecreate'] = date("d-m-Y", $listnewss[$key]['datecreate']);
        }
        $dtr['status'] = 1;
        $dtr['mss'] = "Success";
        $dtr['data'] = $listnewss;

        self::jsonResponse($dtr);
    }

    public function checkelemexistsAction() {
        $keyword = $this->request->get('q');
        $type = $this->request->get('type');
        $subType = $this->request->get('sub_type');

        $checkField = 'namenonutf';

        switch ($type) {
            case 'article':
                $modelClass = 'DjCms\Models\Media';
                break;
            case 'collection':
                $modelClass = 'DjCms\Models\Album';
                break;
            case 'tag':
                $modelClass = 'DjCms\Models\Tag';
                $checkField = 'namenonaccent';
                break;
            case 'artist':
                $modelClass = 'DjCms\Models\Artist';
                $checkField = 'lower_name';
                break;
            default:
                self::jsonResponse(array(
                    'status' => 404,
                    'mss' => 'Invalid request'
                ));
        }

        $query = array(
            $checkField => strtolower(Helper::convertToUtf8($keyword))
        );
        if ($type == 'artist') {
            $query = array(
                $checkField => mb_strtolower($keyword)
            );
        }
        if (!empty($subType))
            $query['type'] = $subType;

        $selectFields = array("_id", "type", $checkField);
        ## Filter
        $criteria = array(
            "condition" => $query,
            "fields" => $selectFields
        );
        ## bind Data
        $listnewss = call_user_func(array($modelClass, 'findAndReturnArray'), $criteria);
        if (!empty($listnewss)) {
            $dtr = array(
                'status' => 303,
                'mss'    => 'Exits'
            );
        } else {
            $dtr = array(
                'status' => 1,
                'mss'    => 'Non exists'
            );
        }

        self::jsonResponse($dtr);
    }

    public function getlistalbumAction()
    {
        $keyword = Helper::convertToUtf8($this->request->get('q'));
        $type = $this->request->get('type');
        if (!strlen($type))
            $type = "album";

        $query = array(
            '$text' => array('$search' => "\"$keyword\""),
            'type' => $type
        );
        $limit = 20;
        $selectFields = array("name", "_id", "priavatar", "datecreate", "type", "namenonutf");
        ## Filter
        $criteria = array(
            "condition" => $query,
            "fields" => $selectFields,
            "limit" => $limit
        );
        ## bind Data
        $listnewss = Album::findAndReturnArray($criteria);
        foreach ($listnewss as $key => $item) {
            $listnewss[$key]['datecreate'] = date("d-m-Y", $listnewss[$key]['datecreate']);
        }
        $dtr['status'] = 1;
        $dtr['mss'] = "Success";
        $dtr['data'] = $listnewss;
        self::jsonResponse($dtr);
    }

    public function getlisttopicAction()
    {
        $keyword = Helper::convertToUtf8($this->request->get('q'));
//        $type = $this->request->get('type');
//        if (!strlen($type))
//            $type = "album";

        $query = array(
            '$text' => array('$search' => "\"$keyword\"")
//            'type' => $type
        );
        $limit = 20;
        $selectFields = array("name", "_id", "priavatar", "datecreate", "type", "namenonutf");
        ## Filter
        $criteria = array(
            "condition" => $query,
            "fields" => $selectFields,
            "limit" => $limit
        );
        ## bind Data
        $listnewss = Album::findAndReturnArray($criteria);
        foreach ($listnewss as $key => $item) {
            $listnewss[$key]['datecreate'] = date("d-m-Y", $listnewss[$key]['datecreate']);
        }
        $dtr['status'] = 1;
        $dtr['mss'] = "Success";
        $dtr['data'] = $listnewss;
        self::jsonResponse($dtr);
    }

    public function getlistartistAction()
    {
        $keyword = Helper::convertToUtf8($this->request->get('q'));
        $type = $this->request->get('type');
        if (!strlen($type))
            $type = "audio";

        $query = array(
            '$text' => array('$search' => "\"$keyword\"")
//                'type' => $type
        );
        $limit = 20;
        $selectFields = array("username", "_id", "priavatar", "datecreate", "namenonutf");
        ## Filter
        $criteria = array(
            "condition" => $query,
            "fields" => $selectFields,
            "limit" => $limit
        );
        ## bind Data
        $total_count = Artist::count($query);
        $listnewss = Artist::findAndReturnArray($criteria);
        foreach ($listnewss as $key => $item) {
            $listnewss[$key]['id'] = $listnewss[$key]['_id'];
            $listnewss[$key]['name'] = $item['username'];
            $listnewss[$key]['datecreate'] = date("d-m-Y", $listnewss[$key]['datecreate']);
        }
        $dtr['status'] = 1;
        $dtr['mss'] = "Success";
        $dtr['items'] = $listnewss;
        $dtr['total_count'] = $total_count;
        $dtr['query'] = $query;
        self::jsonResponse($dtr);
    }

    public function updatemainmenuAction()
    {
        $dbmg = $this->getConnection();
        $listItemPost = $this->request->get('listData');
        foreach ($listItemPost as $value) {
            $orderItemId[] = $value['item_id'];
        }
        usort($listItemPost, array('self', 'sortArray'));
        $listItem = array_reverse($listItemPost);
        foreach ($listItem as $key => $value) {
            if (strlen($value['catid'])) {
                $categoryCl = $dbmg->category;
                $criteria = array("_id" => $value['cat_id']);
                $categoryObj = (array)$categoryCl->findOne($criteria, array("name", "_id"));
                $title = $categoryObj['name'];
                $listItem[$key]['title'] = $title;
                $listItem[$key]['link'] = CreateLink::viewCategory($value['catid'], $title);
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

        $uinfo = (array)$this->session->get('uinfo');
        $postvalue['key'] = ViewcomponentController::MAIN_MENU_KEY;
        $postvalue['value'] = $listItem;
        $settingsCl = $dbmg->settings;
        $updateQuery = array(
            '$set' => $postvalue,
            '$push' => array(
                "usermodify" => array(
                    "uid" => $uinfo['_id'], "datecreate" => time()
                )
            )
        );
        $settingsCl->update(
            array("key" => ViewcomponentController::MAIN_MENU_KEY),
            $updateQuery,
            array("upsert" => true)
        );
        $this->jsonResponse(array(
            'status' => 1,
            'message' => "success"
        ));
    }


    function sortArray($a, $b)
    {
        return strcmp($a['depth'], $b['depth']);
    }

}
