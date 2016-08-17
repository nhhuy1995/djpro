<?php
/**
 * Created by PhpStorm.
 * User: hoang
 * Date: 4/2/2015
 * Time: 11:24 AM
 */

class PagingHelper {

    /**
     * data.
     *
     * @var \MongoCursor;
     */
    private $data;

    /**
     * Limit.
     *
     * @var integer
     */
    private $limit;

    /**
     * Current page.
     *
     * @var integer
     */
    private $page;

    /**
     * Adapter constructor.
     *
     * @param array $config Config.
     */
    public function __construct($config) {
        if (isset($config['data'])) {
            $this->data = $config['data'];
        }

        if (isset($config['limit'])) {
            $this->limit = $config['limit'];
        }

        if (isset($config['page'])) {
            $this->page	= $config['page'];
        }

    }

    /**
     * Set the current page number
     *
     * @param integer $page Current page.
     *
     * @return void
     */
    public function setCurrentPage($page) {
        $this->page = $page;
    }
    
    public static function generate($config){
    	$limit 		 = $config['limit'];
    	$currentPage = $config['currentPage'];
    	$totalRecord = $config['totalRecord'];
    	$url 		 = $config['url'];
    	
    	$firstPage = $currentPage - 1;
    	$afterPage = $currentPage + 1;
    	
        $result = "<div class='pagination'>";
        
        if ($currentPage > 1){
	        $result.= "<a class='page' href='{$url}?page={$firstPage}'>{$firstPage}</a>";
        }
        $result.= "<a class='page active' href='{$url}?page={$currentPage}'>{$currentPage}</a>";
        
        if ($totalRecord >= $limit){
	        $result.= "<a class='page' href='{$url}?page={$afterPage}'>{$afterPage}</a>";
        }
        $result.= "</div>";
    	
    	return $result;
    	
    }

    /**
     * Returns a slice of the resultset to show in the pagination
     *
     * @return stdClass
     */
    public function getPaginate() {
        $limit = intval($this->limit);
        $pageNumber = intval($this->page);
        $data = $this->data;

        if ($pageNumber <= 0) {
            $pageNumber = 1;
        }

        $page = new \stdClass();
        $number = count($data);

        $roundedTotal = $number / floatval($limit);
        $totalPages = intval($roundedTotal);

        /**
         * Increase total_pages if wasn't integer
         */
        if ($totalPages != $roundedTotal) {
            $totalPages++;
        }

        //Fix next
        if ($pageNumber < $totalPages) {
            $next = $pageNumber + 1;
        } else {
            $next = $totalPages;
        }


        $page->next = $next;

        if ($pageNumber > 1) {
            $before = $pageNumber - 1;
        } else {
            $before = 1;
        }

        $page->first = 1;
        $page->before = $before;
        $page->current = $pageNumber;
        $page->last = $totalPages;
        $page->total_pages = $totalPages;
        $page->total_items = $number;

        return $page;
    }

}