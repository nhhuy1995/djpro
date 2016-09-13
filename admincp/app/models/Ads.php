<?php
namespace DjCms\Models;

use Phalcon\Mvc\Collection;

/**
 * Class Ads
 * @package DjCms\Models
 * @author hungln
 * @description Media Collection in Db
 */
class Ads extends BaseCollection {
	private $_position_ads = array (
		'HOME_DESKTOP_TOP' => 'ads_home_desktop_top',
		'HOME_DESKTOP_RIGHT_1' => 'ads_home_desktop_right_1',
		'HOME_DESKTOP_RIGHT_2' => 'ads_home_desktop_right_2',
		'HOME_DESKTOP_RIGHT_3' => 'ads_home_desktop_right_3',
		'HOME_TABLET_TOP' => 'ads_home_tablet_top',
		'HOME_MOBILE_TOP' => 'ads_home_mobile_top',
		
		'MUSIC_PLAY_DESKTOP_LYRIC' => 'ads_music_play_desktop_lyric',
		'MUSIC_PLAY_DESKTOP_ABOVE_SUGGEST' => 'ads_music_play_desktop_above_suggest',
		'MUSIC_PLAY_DESKTOP_BELOW_SUGGEST' => 'ads_music_play_desktop_below_suggest'
	);


	// public static $HOME_DESKTOP_TOP = 'ads_home_desktop_top';
	// public static $HOME_DESKTOP_TOP = 'ads_home_desktop_top';

//    protected static $_collect_instance;
    public function getSource() {
        return "ads";
    }

    public function initialize() {
        $this->useImplicitObjectIds(false);
    }

    public function getAdsPosition() {
    	return $this->_position_ads;
    }
}