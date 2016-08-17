<?php
namespace DjCms\Models;

use DjCms\Library\Makelink;
use Phalcon\Mvc\Collection;

/**
 * Class Comment
 * @package DjCms\Models
 * @author huynh
 * @description Comment Collection in Db
 */
class Comment extends BaseCollection
{
    public function getSource()
    {
        return "comment";
    }

    public function initialize()
    {
        $this->useImplicitObjectIds(false);
    }

    public static function findWithFullInfor($params = array()) {
        $commentCl = parent::findAndReturnArray($params);
        $articleType = array("audio", "video","news");
        $collectionType = array("album", "playlist","topic");

        foreach ($commentCl as $comment) {
            $userIds[] = $comment['user_id'];
        }
        $userIds = array_values(array_unique($userIds));
        $listUser = Users::findAndReturnArray(array(
            "condition" => array(
                "_id" => array(
                    '$in' => $userIds
                )
            )
        ), true);

        foreach ($commentCl as $comment) {
            $user_id = $comment['user_id'];
            $atid = $comment['atid'];
            $type = $comment['type'];
            if (isset($listUser[$user_id])) {
                $comment['username'] = $listUser[$user_id]['username'];
                if(in_array($type,$articleType)){
                    $mediaObj = Media::getCollectionInstance()->findOne(array('_id' => $atid));
                    if ($mediaObj) {
                        if ($type == "audio")
                            $comment['media_link'] = DOMAIN . Makelink::link_view_article_music($mediaObj['name'], $mediaObj['_id']);
                        if ($type == "video")
                            $comment['media_link'] = DOMAIN . Makelink::link_view_article_video($mediaObj['name'], $mediaObj['_id']);
                        if ($type == "news")
                            $comment['media_link'] = DOMAIN . Makelink::link_view_article($mediaObj['name'], $mediaObj['_id']);
                        $comment['media_name'] = $mediaObj['name'];
                    }
                }
                if(in_array($type,$collectionType)){
                    $mediaObj = Album::getCollectionInstance()->findOne(array('_id' => $atid));
                    if ($mediaObj) {
                        $comment['media_link'] = DOMAIN . Makelink::link_view_article_playlist_music($mediaObj['name'], $mediaObj['_id']);
                        $comment['media_name'] = $mediaObj['name'];
                    }
                }
                $listComment[] = $comment;
            }


        }
        return $listComment;
    }
}