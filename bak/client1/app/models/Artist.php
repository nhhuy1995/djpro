<?php
namespace DjClient\Models;

use DjClient\Library\Makelink;
use Phalcon\Mvc\Collection;
use DjClient\Library\Helper;

/**
 * Class Artist
 * @package DjCms\Models
 * @author hungln
 * @description Artist Collection in Db
 */
class Artist extends BaseCollection
{
    public static $_STATUS_ACTIVE = 1;
    public static $_STATUS_WAIT = 3;

    public static $_artist_type = array(
        "dj", "producer", "singer", "composer"
    );

    public function getSource()
    {
        return "artist";
    }

    public function initialize()
    {
        $this->useImplicitObjectIds(false);
    }

    public static function getAllArtistTypes()
    {
        return array_combine(
            static::$_artist_type,
            array("Dj", "Nhà sản xuất", "Ca sĩ", "Nhạc sĩ")
        );
    }

    public static function getArtistByID($listid)
    {
        if (empty($listid) || !is_array($listid)) $listid = array();
        $listartist = Artist::findAndReturnArray(array(
            'fields' => array('_id','username','priavatar','link'),
            'condition' => array('_id' => array('$in' => $listid)),
        ));
        foreach ($listartist as &$item) {
            $item['link'] = Makelink::link_view_artist($item['username'], $item['_id']);
        }
        return $listartist;
    }

    /**
     * Insert tags not exists and return all id of tag
     * @param array$listTag
     * @param ControllerBase $context
     * @return array
     */
    public static function standardListArtist($listArtist, $uid, $defaultStatus = 1) {
        $uniqueList = array();
        foreach($listArtist as $key => $artist) {
            $lowerName = mb_convert_case($artist, MB_CASE_LOWER, 'UTF-8');
            if (!in_array($lowerName, $uniqueLowerList)) {
                $uniqueLowerList[] = $lowerName;
                $uniqueList[] = $artist;
            }
        }
        $listArtist = $uniqueList;

        foreach ($listArtist as $key => $value) {
            $criteria = array(
                'condition' => array(
                    '_id' => $value
                )
            );
            $artist = static::findAndReturnArray($criteria);
            if (!empty($artist)) {
                static::enableNewArtist(array_shift($artist));
                continue;
            }

            $artist = static::getArtistByName($value);
            if (!empty($artist)) {
                $listArtist[$key] = $artist['_id'];
                static::enableNewArtist($artist);
                continue;
            }

            $listArtist[$key] = static::insertArtistWithName($value, $uid, $defaultStatus);

        }
        $listArtist = array_values(array_unique($listArtist));

        return $listArtist;
    }

    /**
     * Insert new tag with name
     * @param string $name Name of tag
     * @param string $uid id of user
     * @return string new tag's _id
     */
    public static function insertArtistWithName($name, $uid, $defaultStatus = 1) {
        $artistCl = static::getCollectionInstance();
        $artist['_id'] = strval(strtotime('now')).strval(rand(1000, 9999));
        $artist['username'] = $name;
        $artist['namenonutf'] = strtolower(Helper::convertToUtf8($name));
        $artist['status'] = $defaultStatus;
        $artist['lower_name'] = mb_strtolower($name, 'UTF-8');
        $artist['usercreate'] = $uid;
        $artist['sex'] = 'male';
        $artist['type'] = array('dj');
        $artist['datecreate'] = intval(strtotime('now'));
        $artist['category'] = ['1451019676'];
        $artist['add_new'] = 1;
        $artistCl->insert($artist);
        return $artist['_id'];

    }

    /**
     * Get artist by name
     * @param string $value artist's name
     */
    public static function getArtistByName($value) {
        $criteria = array(
            'condition' => array(
                'lower_name' => mb_strtolower($value, 'UTF-8')
            )
        );
        $artist = static::findAndReturnArray($criteria);
        return array_shift($artist);
    }


    /*
    * Enable new artist
    * @param array $artist
    */
    public static function enableNewArtist($artist) {
        if ($artist['add_new'] == 1) {
            static::updateDocument(
                array('_id' => $artist['_id']),
                array(
                    '$set' => array(
                        "status" => static::$_STATUS_ACTIVE
                    ),
                    '$unset' => array(
                        "add_new" => true
                    )
                )
            );
        }
    }
}