<?php
namespace DjClient\Models;

use Phalcon\Mvc\Collection;

/**
 * Class Token_key
 * @package DjCms\Models
 * @author huynh
 * @description Token_key Collection in Db
 */
class Token_key extends BaseCollection
{
    public function getSource()
    {
        return "token_key";
    }

    public function initialize()
    {
        $this->useImplicitObjectIds(false);
    }
}