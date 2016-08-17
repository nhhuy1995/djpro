<?php
/**
 * Created by PhpStorm.
 * User: hung
 * Date: 6/6/2015
 * Time: 10:12 PM
 */
namespace DjCms\Library;
use Phalcon\Flash\Session as FlashInNext;

/**
 * Class MyFlash
 * @package DjCms\Library
 * Flash Message with custom style
 */
class FlashSession extends FlashInNext
{
    /**
     * @param string $type Type of message
     * @param array|string $message Content of message
     */
    public function message($type, $message)
    {
        $finalMessage = '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'
            .'<div class="icon">'
            .'<i class="fa fa-check"></i>'
            .'</div>'
            .$message;
        parent::message($type, $finalMessage);
    }
}