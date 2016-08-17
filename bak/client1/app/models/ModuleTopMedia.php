<?php
class ModuleTopMedia extends \Phalcon\Mvc\Collection
{
    public function getSource()
    {
        return "moduletopmedia";
    }

    public $itemid;
    public $sort;
    public $type;
}
?>