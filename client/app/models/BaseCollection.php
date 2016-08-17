<?php
namespace DjClient\Models;

use Phalcon\Mvc\Collection;

/**
 * Class BaseCollection
 * @author hungln
 * @package DjCms\Models
 * Base Collection for Mongo
 */
class BaseCollection extends Collection
{
    public static $TYPE_NEWS = 'news';
    public static $TYPE_IMAGES = 'images';
    public static $STATUS_ON = 1;
    public static $STATUS_HIDDEN = 0;
    protected static $TYPE_VIDEO = 'video';
    protected static $TYPE_ARTIST = 'artist';
    protected static $TYPE_MUSIC = 'audio';
    protected static $TYPE_ALBUM = 'album';
    protected static $TYPE_PLAYLIST = 'playlist';
    protected static $TYPE_TOPIC = 'topic';
    /**
     * @var $_collect_instance
     */
    private static $_collect_instance = array();

    /**
     * @return \MongoCollection Static Instance
     */
    public static function getCollectionInstance()
    {
        $class = get_called_class();
        if (array_key_exists($class, self::$_collect_instance) === false) {
            self::$_collect_instance[$class] = new static();
        }
        $_source = self::$_collect_instance[$class]->getSource();
        $connection = self::$_collect_instance[$class]->getConnection();
        return $connection->$_source;
    }

    /**
     * Insert new document
     * @param array $params All document's properties
     */
    public static function insertDocument($params)
    {
        static::getCollectionInstance()->insert($params);
    }

    /**
     * Update documents on Collection
     * @param array $condition
     * @param array $update
     * @param array $option
     * @return mixed Result of action update document
     */
    public static function updateDocument($condition, $update, $option = array())
    {
        return static::getCollectionInstance()->update($condition, $update, $option);;
    }

    /**
     * Delete documents on Colleciton
     * @param array $criteria criteria for delete
     * @param array $option option for delete
     */
    public static function deleteDocument($criteria, $option = array())
    {
        static::getCollectionInstance()->remove($criteria, $option);
    }

    /**
     * @param array $params define criteria to execute query like
     * condition, fields, skip, limit, sort
     * @param bool|false $needKeys
     * @return array Array of value after find
     */
    public static function findAndReturnArray($params = array(), $needKeys = false)
    {
        $paramsDefault = array(
            "condition" => array(),
            "fields" => array(),
            "skip" => 0,
            "limit" => -1,
            "sort" => array()
        );
        $params = array_merge($paramsDefault, $params);
        if ($params['limit'] < 0) {
            $cursor = static::getCollectionInstance()
                ->find($params['condition'], $params['fields'])
                ->skip($params['skip'])->sort($params['sort']);
        } else {
            $cursor = static::getCollectionInstance()
                ->find($params['condition'], $params['fields'])
                ->skip($params['skip'])->limit($params['limit'])
                ->sort($params['sort']);
        }
        return iterator_to_array($cursor, $needKeys);
    }

}