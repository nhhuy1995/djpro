<?php
namespace DjClient\Models;

use DjClient\Library\Helper;
use DjClient\Library\Makelink;
use Phalcon\Mvc\Collection;

/**
 * Class MediaRequire
 * @package DjCms\Models
 * @author hungln
 * @description MediaRequire Collection in Db
 */
class MediaRequire extends BaseCollection
{

    public function getSource()
    {
        return "media_require";
    }

    public function initialize()
    {
        $this->useImplicitObjectIds(false);
    }
}