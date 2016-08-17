<?php
namespace DjCms\Library\Queue;

interface IQueue {
    /**
     * @author: Namtq
     * @param: keyqueue, function callback, prams
     */
    public function addFunction($register_function, $callback_function, $args=null);
    public function getNotifyData($job);
    public function run();
}