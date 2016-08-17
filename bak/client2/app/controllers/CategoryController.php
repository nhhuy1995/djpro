<?php
/**
 * Created by PhpStorm.
 * User: hoang
 * Date: 3/31/2015
 * Time: 9:43 AM
 */

class CategoryController extends ControllerBase{
    public function indexAction(){
        echo 'danh muc';

        $comment = Comment::find();

        echo '<pre>';
        foreach ($comment as $value){
            var_dump($value->content);
        }

        exit;
    }

    public function viewAction($id){
        $request = $this->request;
        
        ## Assign for Breadcrumb
        /* if (isset($id)) {
        	$breadcrumbs = makeBreadCrumbs($id, $customMakeLink);
        } else {
        	$breadcrumbs = array();
    	}
        
        if ($customMakeLink == "album"){
        	array_unshift($breadcrumbs, array("name"=>"Album", "link"=>"/album-chon-loc.html"));
        }
        	
        if ($customMakeLink == "playlist"){
        	array_unshift($breadcrumbs, array("name"=>"Playlist", "link"=>"/playlist-chon-loc.html"));
        }
        	
        if ($customMakeLink == "topic"){
        	array_unshift($breadcrumbs, array("name"=>"Chủ đề", "link"=>"/chu-de.html"));
        }
        	
        if ($customMakeLink == "video"){
        	array_unshift($breadcrumbs, array("name"=>"Video", "link"=>"/video-chon-loc.html"));
        }
        
        array_unshift($breadcrumbs, array("name"=>"Trang chủ", "link"=>"/"));
        $currentBread = array_pop($breadcrumbs);

        $tpl->assign("parentBreads", $breadcrumbs);
        $tpl->assign("currentBread", $currentBread); */
        
        $category = Category::findFirst(array("conditions" => array("_id" => $id)));
        $this->view->setVar('category', $category);
        
        $categoryType = $category->type;
        $this->view->setVar('categoryType', $categoryType);
        
//         var_dump($category->type);exit;

        $limit = 20;
        $currentPage = $request->getQuery("p", int, 1);
        if($currentPage <= 1){
            $currentPage = 1;
        }

        $skip = ($currentPage -1 ) * $limit;

        $mediaList = Media::find(array(
            "conditions" => array(
                "category" => $id,
                "status" => "1"
            ),
            "skip" => $skip,
            "limit" => $limit,
            "sort" => array("_id" => -1)
        ));
        
        $mediaCount = Media::count(array(
        		"conditions" => array(
        				"category" => $id,
        				"status" => "1"
        		),
        ));
        
        $this->view->setVar("mediaCount", $mediaCount);
        $this->view->setVar("pageTotal", intval($mediaCount / $limit));

        #Bind Select Audio Media
        $moduleTopMedia = ModuleTopMedia::find(array(
                "conditions" => array(
                    "type" => "$categoryType"
                ),
                "limit" => 15,
                "sort" => array("sort" => 1)
            )
        );

        foreach($moduleTopMedia as $value) {
            $moduleTopMediaIds[] = $value->itemid;
        }

        $mediaChoiceList = Media::find(array(
            "conditions" => array(
                "_id" => array(
                    '$in' => $moduleTopMediaIds
                )
            )
        ));
        $this->view->setVar("mediaChoiceList", $mediaChoiceList);

        ## End Bind Ca Khuc Chon Loc
        #Load ChildCat

        $categoryList = Category::find(array(
           "conditions" => array(
               'parentid' => $id
           )
        ));
        
        $this->view->setVar( "categoryList", $categoryList );
        $this->view->setVar( "mediaList", $mediaList );
        $this->view->setVar("p", $currentPage);
    }
}