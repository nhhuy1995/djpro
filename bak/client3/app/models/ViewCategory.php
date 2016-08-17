<?php
class ViewCategory extends \Phalcon\Mvc\Collection
{
    public function getSource()
    {
        return "viewcategory";
    }
    public $category;
    public $position;
    public $sort;

    function setCategory($category) { $this->category = $category; }
    function getCategory() { return $this->category; }
    function setPosition($position) { $this->position = $position; }
    function getPosition() { return $this->position; }
    function setSort($sort) { $this->sort = $sort; }
    function getSort() { return $this->sort; }



}
?>