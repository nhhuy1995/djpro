<?php
namespace DjClient\Models;

use Phalcon\Mvc\Collection;

/**
 * Class Ads
 * @package DjCms\Models
 * @author hungln
 * @description Media Collection in Db
 */
class Ads extends BaseCollection {
	private $_key_ads_test = 'ads_test_true';

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

    public function getAdsContents($position) {
    	if (!is_array($position))
    		$position = array($position);
    	$query = array(
    		'condition' => array(
                '_id' => array(
    			    '$in' => $position
    		    )
            )
    	);

    	$ads = static::findAndReturnArray($query, true);
    	foreach ($ads as $key => $ad) {
    		$code = array_search($key, $this->_position_ads);
    		$returnData[$code] = $ad;
    		if ($_GET[$this->_key_ads_test] == 'yes') 
    			$returnData[$code]['current_content'] = $ad['draft_content'];
    	}
    	return (object)$returnData;
    }

    public function getAdsSidebarRight() {
    	return $this->getAdsContents(
            array(
                $this->_position_ads['HOME_DESKTOP_TOP'],
                $this->_position_ads['HOME_TABLET_TOP'],
                $this->_position_ads['HOME_MOBILE_TOP'],
                $this->_position_ads['HOME_DESKTOP_RIGHT_1'],
                $this->_position_ads['HOME_DESKTOP_RIGHT_2'],
                $this->_position_ads['HOME_DESKTOP_RIGHT_3'],
                $this->_position_ads['MUSIC_PLAY_DESKTOP_ABOVE_SUGGEST'],
                $this->_position_ads['MUSIC_PLAY_DESKTOP_BELOW_SUGGEST']
            )
        );
    }

    public function addAdsInLyric($ads) {
        $key = $this->_position_ads['MUSIC_PLAY_DESKTOP_LYRIC'];
        $adsLyric = $this->getAdsContents($key);
        $ads->MUSIC_PLAY_DESKTOP_LYRIC = $adsLyric->MUSIC_PLAY_DESKTOP_LYRIC;
    }
}