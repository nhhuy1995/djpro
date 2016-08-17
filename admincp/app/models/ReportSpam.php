<?php
namespace DjCms\Models;
use DjCms\Library\Makelink;

/**
 * Class ReportSpam
 * @package DjCms\Models
 * @author hungln
 * @description Report spam Collection in Db
 */
class ReportSpam extends BaseCollection
{
//    protected static $_collect_instance;
    public function getSource()
    {
        return "error_music";
    }

    public function initialize()
    {
        $this->useImplicitObjectIds(false);
    }

    public static function findWithFullInfor($params = array()) {
        $feedbackCl = parent::findAndReturnArray($params);

        foreach ($feedbackCl as $comment) {
            $userIds[] = $comment['usersendfeedback'];
        }
        $userIds = array_values(array_unique($userIds));
        $listUser = Users::findAndReturnArray(array(
            "condition" => array(
                "_id" => array(
                    '$in' => $userIds
                )
            )
        ), true);


        foreach ($feedbackCl as $feedback) {
            $user_id = $feedback['usersendfeedback'];
            if (isset($listUser[$user_id])) {
                $feedback['username'] = $listUser[$user_id]['username'];
                $feedback['user_link'] = DOMAIN.Makelink::link_view_member($listUser[$user_id]['username'],$listUser[$user_id]['_id']);
                ReportSpam::addArticleInfo($feedback);
                $listFeedback[] = $feedback;
            }
        }
        return $listFeedback;
    }

    public static function addArticleInfo(&$feedback) { 
        $articleType = array("audio", "video");
        $collectionType = array("album", "playlist","topic");

        $condition = array(
            "_id" => $feedback['atid'],
        );

        if (in_array($feedback['type'], $articleType)) {
            $condition['type'] = $feedback['type'];
            $mediaObj = Media::getCollectionInstance()->findOne($condition);

            if ($mediaObj) {
                if ($feedback['type'] == "audio")
                    $feedback['media_link'] = DOMAIN . Makelink::link_view_article_music($mediaObj['name'], $mediaObj['_id']);
                if ($feedback['type'] == "video")
                    $feedback['media_link'] = DOMAIN . Makelink::link_view_article_video($mediaObj['name'], $mediaObj['_id']);
                $feedback['media_name'] = $mediaObj['name'];
            }
        }

        if (in_array($feedback['type'], $collectionType)) {
            $condition['type'] = $feedback['type'];
            $mediaObj = Album::getCollectionInstance()->findOne($condition);
            if ($mediaObj) {
                $feedback['media_link'] = DOMAIN . Makelink::link_view_article_playlist_music($mediaObj['name'], $mediaObj['_id']);
                $feedback['media_name'] = $mediaObj['name'];
            }
        }

        /*if ($feedback['type'] == "topic") {
            $mediaObj = Topic::getCollectionInstance()->findOne($condition);
            if ($mediaObj) {
                $feedback['media_link'] = DOMAIN . Makelink::link_view_article_playlist_music($mediaObj['name'], $mediaObj['_id']);
                $feedback['media_name'] = $mediaObj['name'];
            }
        }*/
    }

}