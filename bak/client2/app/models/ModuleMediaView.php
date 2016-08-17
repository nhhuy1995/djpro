<?php
class ModuleMediaView extends \Phalcon\Mvc\Collection
{
    public function getSource()
    {
        return "modulemediaview";
    }

    public $itemid;
    public $sort;
    public $type;
    public $date;
}
?>