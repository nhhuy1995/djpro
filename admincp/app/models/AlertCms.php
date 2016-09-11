<?php
namespace DjCms\Models;

use Phalcon\Mvc\Collection;

/**
 * Class Album
 * @package DjCms\Models
 * @author hungln
 * @description Media Collection in Db
 */
class AlertCms extends BaseCollection {
	private static $_NOT_READ_STATUS = 1;
	private static $_HAS_READ_STATUS = 0;
//    protected static $_collect_instance;
    public function getSource() {
        return "alert_cms";
    }

    public function initialize() {
        $this->useImplicitObjectIds(false);
    }

    public static function getAlertNotRead($userId) {
    	$alert = static::findAndReturnArray(
    		array(
            	'condition' => array(
            		'user_id' => $userId,
            		'unread' => static::$_NOT_READ_STATUS
            	)
    		)
    	);
    	return $alert;
    }

    public static function markReadAllAlert($userId) {
    	$condition = array(
    		'user_id' => $userId,
    		'unread' => static::$_NOT_READ_STATUS
    	);
    	$updateQuery = array(
    		'$set' => array(
    			'unread' => static::$_HAS_READ_STATUS
    		)
    	);

    	static::updateDocument(
    		$condition,
    		$updateQuery,
    		array('multiple' => true)
    	);
    }
}