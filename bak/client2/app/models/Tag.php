<?php
namespace DjCms\Models;

use DjCms\Controller\ControllerBase;
use DjCms\Library\Helper;
use Phalcon\Mvc\Collection;

/**
 * Class Tag
 * @package DjCms\Models
 * @author huynh
 * @description Tag Collection in Db
 */
class Tag extends BaseCollection
{
    public function getSource()
    {
        return "tag";
    }

    public function initialize()
    {
        $this->useImplicitObjectIds(false);
    }

    /**
     * Insert tags not exists and return all id of tag
     * @param array$listTag
     * @param string $context
     * @return array
     */
    public static function standardListTag($listTag, $uid) {
        $uniqueList = array();
        foreach($listTag as $key => $tag) {
            $lowerName = mb_strtolower($tag);
            if (!in_array($lowerName, $uniqueLowerList)) {
                $uniqueLowerList[] = $lowerName;
                $uniqueList[] = $tag;
            }
        }
        $listTag = $uniqueList;

        foreach ($listTag as $key => $value) {
            $criteria = array(
                'condition' => array(
                    '_id' => $value
                )
            );
            $tag = static::findAndReturnArray($criteria);
            if (!empty($tag)) continue;
            
            $tag = static::getTagByName($value);
            if (!empty($tag)) {
                $listTag[$key] = $tag['_id'];
                continue;
            }
            
            $listTag[$key] = static::insertTagWithName($value, $uid, $defaultStatus);
            
        }
        
        $listTag = array_values(array_unique($listTag));
        
        return $listTag;
    }

    /**
     * Get tag by name
     * @param string $value tag's name
     */
    public static function getTagByName($value) {
        $criteria = array(
            'condition' => array(
                'lower_name' => mb_strtolower($value)
            )
        );
        $tag = static::findAndReturnArray($criteria);
        return array_shift($tag);
    }

    /**
     * Insert new tag with name
     * @param string $name Name of tag
     * @param string $uid id of user
     * @return string new tag's _id
     */
    public static function insertTagWithName($name, $uid) {
        $tagCl = static::getCollectionInstance();
        $tagInfor['_id'] = strval(strtotime('now')).strval(rand(1000, 9999));
        $tagInfor['name'] = $name;
        $tagInfor['namenonaccent'] = Helper::convertToUtf8($tagInfor['name']);
        $tagInfor['lower_name'] = mb_strtolower($name);
        $tagInfor['usercreate'] = $uid;
        $tagInfor['datecreate'] = intval(strtotime('now'));
        $tagCl->insert($tagInfor);
        return $tagInfor['_id'];

    }
}