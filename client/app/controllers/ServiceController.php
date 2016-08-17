<?php
/**
 * Created by PhpStorm.
 * User: hoang
 * Date: 3/31/2015
 * Time: 9:43 AM
 */
header('Content-Type: application/json; charset=UTF-8');

class ServiceController extends ControllerBase{
    protected function initialize(){
    	parent::initialize();
        $this->view->disable();
    }

    public function indexAction(){
    	
    }
    
    /**
     * tro thanh fan ham mo
     */
    public function becomeFanAction(){
    	if ($userId = $this->session->get("userId")) {
    		$db = $this->getConnection();
    		
    		$djid = $this->request->getPost("djid");
    		
    		$db->user->update(array("_id" => $djid), array('$addToSet' => array ('fan' => $userId)));
    		$db->user->update(array("_id" => $userId), array('$addToSet' => array ('follow' => $djid)));
    		$dtr['message'] = "Bạn đã thành Fan của dj này";
    		$dtr['status'] = 1;
    	} else {
    		$dtr['message'] = "Bạn cần đăng nhập để thục hiện chức năng này";
    		$dtr['status'] = 404;
    	}
    	echo json_encode($dtr);
    }

    /**
     * danh sach bai hat nghe nhieu
     */
    public function viewTopMediaAction(){
        $request = $this->request;
        $key = $request->getQuery("key");
        $type = $request->getQuery("type", string, "audio");
        $limit = $request->getQuery("limit", int, 30);
        $p = $request->getQuery("p", int, -1);
        $date = $request->getQuery("date", string, "w");
        $sort = $request->getQuery("sort", string, "view");
        if($p <= 1){
            $p = 1;
        }

        $cp = ($p -1 ) * $limit;

        $dataReturn = array();
        if(!isset($key) || $key == "topnhacsan" || $key == "topvideo"){
            list($prevTime, $nextTime) = Helper::getPeriod($date);
            if ($type == "audio" || $type == "video" || $type == "news" || $type == "ranking-audio" || $type == "ranking-video") {
                $collection = Media;
            } else if ($type == "album") {
                $collection = Album;
            } else if ($type == "playlist") {
                $collection = PlayList;
            } else if ($type == "topic") {
                $collection = TypeMusic;
            }
            if ($sort == 'view') {
                $moduleMedia = ModuleMediaView;
            } else if ($sort == 'down') {
                $moduleMedia = ModuleMediaDown;
            }

            $moduleMediaDatas = $moduleMedia::aggregate(array(
                    array('$match' => array(
                            "type" => "$type",
                            "date" => array(
                                '$lte' => $nextTime * 1,
                                '$gte' => $prevTime * 1
                            )
                        )
                    ), array(
                        '$group' => array(
                            '_id' => '$mid',
                            'count' => array(
                                '$sum' => '$' . $sort
                            )
                        )
                    ), array(
                        '$sort' => array(
                            "count" => -1
                        )
                    ),
                    array(
                        '$skip' => 0
                    ), array(
                        '$limit' => 10
                    )
                )
            );

            $mediaItemIds = array();
            foreach($moduleMediaDatas['result'] as $item){
                $mediaItemIds[] = $item['_id'];
            }

            $mediaDatas = Media::find(array("conditions" => array('_id' => array('$in' => $mediaItemIds))));

            $index = 1;

            foreach($mediaDatas as $media) {
                $user = User::find(array("conditions" => array("_id" => $media->usercreate)));
                $media->mediacreateby = $user[0]->name;
                $media->$sort = $media_m[$media->_id];
                $media->index = $index;
                $media->intenetlink = '/bai-hat/'. Helper::urlFriendly($media->name,$media->_id);
                $mediaData[] = $media;

                ++$index;
            }
            $dataReturn['status'] = 1;
            $dataReturn['message'] = "Success";
            $dataReturn['data'] = $mediaData;
        } else if($key == "topdecu"){
            list($prevTime, $nextTime) = Helper::getPeriod($date);
            $listNomination = ModuleMediaNomination::aggregate(array(
                    array('$match' => array("date" => array('$lte' => $nextTime * 1, '$gte' => $prevTime * 1))),
                    array('$group' => array('_id' => '$mid', 'count' => array('$sum' => '$nomination'))),
                    array('$sort' => array("count" => -1)), array('$skip' => 0), array('$limit' => 20)
                )
            );

            $tmp_listId = array();
            $tmp_listNomination = $listNomination['result'];
            foreach ($tmp_listNomination as $elem) {
                $tmp_listId[] = $elem['_id'];
                $tmp_listVote[$elem['_id']] = $elem['count'];
            }

            $mediaDatas = Media::find(array("conditions" => array("_id" => array('$in' => $tmp_listId))));
            $index = 0;
            foreach ($mediaDatas as $media) {
                $media->index = ++$index;
                $user = User::find(array("conditions" => array("_id"=>$media['usercreate'])));
                $media->intenetlink = '/bai-hat/'. Helper::urlFriendly($media->name, $media->_id);
                $media->mediacreateby = $user[0]->name;
                $media->totalVote =  $tmp_listVote[$media->_id];
                $mediaData[] = $media;
            }

            $dataReturn['status'] = 1;
            $dataReturn['message'] = "Success";
            $dataReturn['data'] = $mediaData;
        }
        echo json_encode($dataReturn);
    }

    /**
     * danh sach bai hat tai nhieu
     */
    public function viewTopUserAction() {
        $request = $this->request;
        $limit = $request->getQuery("limit", int, 30);
        $p = $request->getQuery("p", int, -1);
        $date = $request->getQuery("date", string, "w");
        $sort = $request->getQuery("sort", string, "view");
        if($p <= 1){
            $p = 1;
        }

        $cp = ($p -1 ) * $limit;

        list($prevTime, $nextTime) = Helper::getPeriod($date);

        $dataReturn = array();

        if ($sort == 'like') {
            $moduleUser = ModuleUserLike;
        } else if ($sort == 'post') {
            $moduleUser = ModuleUserPosted;
        }

        $userObject = array();
        if (isset($moduleUser)) {
            $cursor = $moduleUser::aggregate(array(
                    array('$match' => array("date" => array('$lte' => $nextTime * 1, '$gte' => $prevTime * 1))),
                    array('$group' => array('_id' => '$uid', 'count' => array('$sum' => '$' . $sort))),
                    array('$sort' => array("count" => -1)), array('$skip' => 0), array('$limit' => 10)
                )
            );
            $index = 1;

            foreach ($cursor['result'] as $value) {
                $user = User::find(array("conditions" => array("_id" => $value->_id)));
                if ($user[0]->_id) {
                    $value->index = $index;
                    $value->username = $user[0]->name;
                    $value->internetlink = Helper::urlFriendly($user[0]->name, $user[0]->_id);
                    $userObject[] = $value;
                    ++$index;
                }
            }
        }

        $dataReturn['status'] = 1;
        $dataReturn['message'] = "Success";
        $dataReturn['data'] = $userObject;
        echo json_encode($dataReturn);
    }

    /**
     * tra ve danh sach thong tin
     */
    public function loadMoreListAction(){
    	$request = $_REQUEST;
    	
    	$mediaCl = $dbmg->media;
    	$actionType = $request['actionType'];
    	$dataType = $request['dataType'];
    	$prevPage = $request['prevPage'];
    	$nextPage = $request['nextPage'];
    	$posterId = $request['posterId'];
    	$mediaType = isset($request['mediaType']) 
			    	? $request['mediaType'] 
			    	: 'audio';
    	
    	$aryMediaIcons = array(
    			"audio" => "fa-music",
    			"video" => "fa-film",
    			"news"  => "fa fa-newspaper-o"	
    	);
    	
    	$limit = $dataType == 'newest' 
    			? 6 
    			: 5;
    	
    	if($actionType == 'prev'){
    		$skip = ($prevPage - 1) * $limit;
    	} else if ($actionType == 'next'){
    		$skip = ($nextPage - 1) * $limit;
    	}
    	
    	$count = 0;
    	$dataStr = "";
    	
    	if($dataType == 'sameAudio'){
    		$mediaList = Media::find(array(
    				"conditions" => array(
    						"type" => "$mediaType",
    						"status" => "1",
    						"usercreate" => "$posterId",
    				),
    				'skip' => $skip,
    				"limit" => $limit,
    				"sort" => array("_id" => -1)
    		));
    		
    		foreach($mediaList as $media){
    			$count++;
    			$dataStr .= '<div class="song-bit">
	                            <span class="song-icon"><i class="fa ' . $aryMediaIcons[$media->type] . '"></i></span>
	                            <div class="song-name"><h3><a href=" ' . Helper::makeMediaLink($media->name, $media->_id) . ' " title="'. $media->name .'">'. $media->name .'</a></h3></div>
	                        </div>';
    		}
    	} else if($dataType == 'unListen'){
    		$limitTime = (int)strtotime(date("F 1, Y", strtotime("-10 months")));
    		
    		$mediaTotalCount = Media::count(array(
    				"conditions" => array(
    						"type" => "$mediaType",
    						"view" => array(
    								'$gt' => 10
    						),
    						"datecreate" => array(
    								'$gt' => $limitTime
    						)
    				)
    		));
    		 
    		$skip = mt_rand(0, $mediaTotalCount - 5);
    		if($skip <= 0) {
    			$skip=0;
    		}
    		 
    		/*
    		 * danh sach bai hat goi y cho nguoi dung
    		 */
    		$unListenList = Media::find(array(
    				"conditions" => array(
    						"type" => "$mediaType",
    						"view" => array(
    								'$gt' => 10
    						),
    						"datecreate" => array(
    								'$gt' => $limitTime
    						)
    				),
    				'skip' => $skip,
    				"limit" => 5,
    				"sort" => array(
    						"_id" => -1
    				)
    		));
    		
    		foreach($unListenList as $media){
    			$count++;
    			$dataStr .= '<div class="song-bit">
	                            <span class="song-icon"><i class="fa ' . $aryMediaIcons[$media->type] . '"></i></span>
	                            <div class="song-name"><h3><a href=" ' . Helper::makeMediaLink($media->name, $media->_id) . ' " title="'. $media->name .'">'. $media->name .'</a></h3></div>
	                        </div>';
    		}
    	}
    	
    	$dtr['status'] = 1;
    	$dtr['size'] = $count;
    	$dtr['data'] =  $dataStr;
    	echo json_encode($dtr);
    }
    
    /**
     * lay danh sach comment
     */
    function loadCommentAction() {
    	$request = $this->request;
    	$atid = $request->getPost('atid', string, 0);
    	$pid = $request->getPost('pid', string, 0);
    	$type = $request->getPost('type', string, 0);
    	$page = $request->getPost('p', int, 1);
    	
    	$query = array();
    	$query['pid'] = $pid;
    	$query['type'] = $type;
    	$query['status'] = "1";
    	
    	if ($atid){
    		$page = $page ? $page : 1;
    		$limit = 10;
    		$skip = ($page - 1) * $limit;
    		
    		$query['atid'] = "{$atid}";
			$commentList = Comment::find(array(
					"conditions" => $query,
					'skip' => $skip,
					"limit" => $limit
			));
    	} else {
    		$commentList = Comment::find(array(
    				"conditions" => $query,
    		));
    	}
    	
    	$listCommentFinal = array();
    	if (count($commentList)){
    		foreach ($commentList as $comment){
    			$user = User::findFirst(array(
    					"conditions" => array(
    							"_id" => $comment->uid
    					)
    			));
    			
    			if ($user->_id){
    				$comment->id = $comment->_id->{'$id'};
    				$user->userLink = Helper::makeUserLink($user->username, $user->_id);
    				$user->id = $user->_id;
    				
    				$comment->uinfo = $user;
    				
    				$tmp_date= explode("/",date("d/m/Y", $comment->datecreate));
    				$comment->datecreate = $tmp_date[0]." tháng ".$tmp_date[1]. " năm ".$tmp_date[2];
    				
    				if ($pid == "0"){
    					$comment->totalReply = Comment::count(array(
    							"conditions" => array(
    									"pid" => "{$comment->_id}"
    							)
    					));
    				} else {
    					$comment->totalReply = 0;
    				}
    				$listCommentFinal[] = $comment;
    			}
    		}
    	}
    	
    	$dtr['status'] = 1;
    	$dtr['message'] = "Success";
    	$dtr['data'] = $listCommentFinal;
    	$dtr['count'] = count($listCommentFinal);
    	echo json_encode($dtr);
    }
    
    /**
     * add comment
     */
    function addCommentAction() {
    	$dtr['status'] = 404;
    	if ($this->session->get("authentication")) {
    		$request = $this->request;
    		$atid = $request->getPost('atid', string, 0);
    		$content = $request->getPost('content', string, null);
    		
    		if ($atid != 0 && $content != null) {
    			$userData = $this->session->get("userData");
    			
    			$parentId = $request->getPost('pid', string, 0);
    			$type = $request->getPost('type', string, 'audio');
    			
    			$comment = new Comment();
    			$comment->uid = $userData['_id'];
    			$comment->atid = $atid;
    			$comment->pid = $parentId;
    			$comment->content = strip_tags($content);
    			$comment->datecreate = time();
    			$comment->status = "1";
    			$comment->type = $type;
    			$comment->save();
    			
    			$comment->uinfo = array(
    					'priavatar' => $userData['priavatar'],
    					'username' => $userData['username'],
    					'userLink' => Helper::makeUserLink($userData['username'], $userData['_id'])
    			);

    			$tmp_date= explode("/",date("d/m/Y", $comment->datecreate));
    			$comment->datecreate = $tmp_date[0]." tháng ".$tmp_date[1]. " năm ".$tmp_date[2];
    			$comment->totalReply = 0;
    			$comment->id = $comment->_id->{'$id'};
    			$dtr['status'] = 1;
    			$dtr['message'] = "Success";
    			$dtr['data'] = $comment;
    		} else {
    			$dtr['message'] = 'Bạn cần điền đầy đủ thông tin';
    		}
    	} else {
    		$dtr['message'] = 'Bạn cần đăng nhập để thực hiện chức năng này';
    	}
    
    	echo json_encode($dtr);
    }
    
    /**
     * load all playlist of user
     */
    public function loadAllPlayListAction(){
    	$userId = $this->session->get("userId");
    	if ($userId) {
    		$playList = PlayList::find(array(
    				"conditions" => array('usercreate' => $userId)
    		));
    		$dtr['status'] = 1;
    		$dtr['data'] =  $playList;
    	} else {
    		$dtr['status'] = 0;
    		$dtr['message'] =  'Bạn cần phải đăng nhập';
    	}
    	echo json_encode($dtr);
    }
    
    /**
     * lay thong tin chi tiet cua playlist de update
     */
    public function loadPlayListDetailAction(){
    	$dtr['status'] = 404;
    	
    	$id = $this->request->getQuery('id');
    	
    	$playList = PlayList::findFirst(array(
    			"conditions" => array(
    					"_id" => "$id"
    			)
    	));
    	
    	if ($playList->_id && count($playList->song)){
    		$playListSong = $playList->song;
    		
    		$mediaList = Media::find(array(
    				"conditions" => array(
    						"_id" => array(
    								'$in' => $playListSong
    						)
    				)
    		));
    		
    		$playList->song = $mediaList;
    		$dtr['status'] = 1;
    		$dtr['data'] = $playList;
    		
    	} else {
    		$dtr['message'] =  "Không có thông tin về playlist này.";
    	}
    	
    	echo json_encode($dtr);
    }
    
    /**
     * add bai hat vo playlist
     */
    public function addToPlaylistAction(){
    	$dtr['status'] = 0;
    	$userId = $this->session->get("userId");
    	if ($userId) {
    		$atid = $this->request->getPost("atid", string, 0);
    		$plid = $this->request->getPost("plid", string, 0);
    		if ($atid != 0 || $plid != 0) {
    			$query = array("_id" => $plid, "usercreate" => $userId);
    			
    			$db = $this->getConnection();
    			
		        $updateResult = $db->playlist->update(
	                $query,
	                array('$addToSet' => (array('song' => $atid))
	            ));
    			
    			$dtr['status'] =1;
    			$dtr['message'] = "Bạn đã thêm thành công bài hát vào playlist";
    		} else {
    			$dtr['message'] = "Cần có đầy đủ thông tin";
    		}
    	} else {
    		$dtr['message'] = "Bạn cần đăng nhập để có thể \n thêm nhạc vào playlist";
    	}
    	echo json_encode($dtr);
    }
    
    /**
     * tạo mới playlist cho user
     */
    public function addNewPlayListAction() {
    	$dbmg = $this->getConnection();
    	$dtr['status'] = 0;
    
    	$playlistCr = $dbmg->playlist;
    	if ($this->session->get("authentication")) {
    		$uid = $this->session->get("userId");
    		$name = $this->request->getPost('name', string, null);
    		$playlistCount = $playlistCr->find(array("name" => $name, "usercreate"=>(string) $uid))->count();
    		if ($playlistCount >= 1) {
    			$dtr['message'] = "Đã có playlist cùng tên này. Vui lòng chọn tên khác";
    		} else {
    			$now = strtotime(date("d-m-Y H:i:s"));
    			$params['_id'] = strval($now);
    			$params['datecreate'] = $params['modifydate'] = $now;
    			$params['usercreate'] = $uid;
    			$params['moretitle'] = $params['name'] = $name;
    			$name_vi = $params['namenoneutf'] = Helper::convert_vi_to_en($name);
    			$params['key'] = Helper::removeAllSpace(strtolower($name_vi));
    			$params['song'] = array();
    			$params['avatar'] = $params['priavatar'] = "";
    			$params['gift'] = $params['download'] = $params['liked'] = $params['spamflag'] = $params['replay'] = $params['view'] =0;
    			$params['status'] = 1;
    			$result = $playlistCr->insert($params);
    			if ($result) {
    				$dtr['status'] = 1;
    				$dtr['data'] = array('_id'=>$now, 'name'=>$name);
    				$dtr['message'] = "Thêm playlist thành công";
    			}
    		}
    	} else {
    		$dtr['message'] = "Bạn cần đăng nhập để có thể thực hiện thao tác này";
    	}
    
    	echo json_encode($dtr);
    }
    
    public function preEditPlaylistAction(){
    	$request = $this->request;
    	
    	$playListId = $request->getPost('playlistId', int, null);
    	$playListName = $request->getPost('playlistName', string, null);
    	$description = $request->getPost('description', string, null);
    	$listAt = $request->getPost('listAt', array(), null);
    	$playlistAvatar = $request->getPost('playlistAvatar', string, null);
    	$refUrl = $request->getPost('refUrl', string, null);
    	
    	$params['name'] = $playListName;
    	$params['description'] = $description;
    	$params['name'] = $playListName;
    	$params['priavatar'] = $playlistAvatar;
    	
    	if (count($listAt)){
    		$params['song'] = $listAt;
    	} else {
    		$params['song'] = array();
    	}
    	
    	if ($this->session->get("authentication")){
	    	if ($playListId){
	    		$db = $this->getConnection();
	    		$query = array(
	    				"_id" => $playListId, 
	    				"usercreate" => $this->session->get("userId")
	    		);
	    		
	    		$update = $db->playlist->update($query, array('$set' => $params), array('upsert' => false));
	    		if ($update['updatedExisting'] == true) {
	    			$this->response->redirect($refUrl);
	    		} else {
	    			echo "<script> alert('Bạn không có playlist này');</script>";
	    			$this->response->redirect($refUrl);
	    		}
	    	} else {
	    		$dtr['message'] = 'Vui lòng chỉ rõ playlist bạn muốn chỉnh sửa';
	    	}
    	} else {
    		$this->response->redirect("/user/login");
    	}
    	echo json_encode($dtr);
    }
    /**
     * xử lý like topic, music, category...
     */
    public function likeArticleAction() {
    	$dbmg = $this->getConnection();
    	
    	$request = $this->request;
    	
	    $dtr['status'] = 404;
	    if ($userId = $this->session->get('userId')) {
	    	$atid = (string)$request->get('val');
	        $type = $request->get('type', string, 'article');
	        $ownerId = (string)$request->get('ownerId');
	        
	        if ($type === 'article') {
	            $mediacl = $dbmg->media;
	            $medialLikeCr = $dbmg->medialiked;
	            ##like
	            $params = array(
	                "atid" => $atid,
	                "userid" => $userId,
	                "type" => 1
	            );
	            $result = $medialLikeCr->update($params, $params, array("upsert" => true));
	            if (!$result['updatedExisting']) {
	                $mediacl->update(
	                    array("_id" => $atid),
	                    array('$inc' => array("liked" => 1))
	                );
	                $moduleuserlike = $dbmg->moduleuserlike;
	                $today = strtotime(date("d-m-Y"));
	                $result = $moduleuserlike->update(
	                    array('uid' => $ownerId, 'date' => $today),
	                    array('$inc' => array("like" => 1)),
	                    array('upsert' => true)
	                );
	                if ($result['ok'] == 1) $dtr['message'] = "Cảm ơn bạn thích tác phẩm này";
	                else $dtr['message'] = "Đã có lỗi xảy ra. Vui lòng thử lại sau";
	            } else {
	                $dtr['message'] = "Bạn đã thích tác phẩm này rồi";
	            }
	        } elseif ($type === 'album') {
	            $albumLikedCr = $dbmg->albumliked;
	            ##like
	            $params = array(
	                "alid" => $atid,
	                "userid" => $userId,
	                "type" => 1
	            );
	            $result = $albumLikedCr->update($params, $params, array("upsert" => true));
	            if (!$result['updatedExisting']) {
	                $albumCr = $dbmg->album;
	                $result = $albumCr->update(
	                    array("_id" => $atid),
	                    array('$inc' => array("liked" => 1))
	                );
	                if ($result['ok'] == 1) $dtr['message'] = "Cảm ơn bạn thích album này";
	                else $dtr['message'] = "Đã có lỗi xảy ra. Vui lòng thử lại sau";
	            } else {
	                $dtr['message'] = "Bạn đã thích album này rồi";
	            }
	        }  elseif ($type === 'playlist') {
	            $playlistLikedCr = $dbmg->playlistliked;
	            ##like
	            $params = array(
	                "plid" => (string)$atid,
	                "userid" => $userId,
	                "type" => 1
	            );
	            $result = $playlistLikedCr->update($params, $params, array("upsert" => true));
	            if (!$result['updatedExisting']) {
	                $playlsitCr = $dbmg->playlist;
	                $result = $playlsitCr->update(
	                    array("_id" => (string)$atid),
	                    array('$inc' => array("liked" => 1))
	                );
	                if ($result['ok'] == 1) $dtr['message'] = "Cảm ơn bạn thích playlist này";
	                else $dtr['message'] = "Đã có lỗi xảy ra. Vui lòng thử lại sau";
	            } else {
	                $dtr['message'] = "Bạn đã thích playlist này rồi";
	            }
	        }
	        $dtr['status'] = 1;
	
	    } else {
	        $dtr['message'] = "Bạn cần đăng nhập để có thể bình chọn";
	    }
	    echo json_encode($dtr);
	}
	
	/**
	 * unlike bai hat, video...
	 */
	public function disLikeArticleAction() {
		$atid = $this->request->getPost("val");
		if ($userId = $this->session->get('userId')) {
			$db = $this->getConnection();
			
			$type = $this->request->getPost("type", string, "article");
			if ($type === 'article') {
				$params = array("atid" => $atid,
					"userid" => $userId,
					"type" => 0
				);
				$result = $db->medialiked->update($params, $params, array("upsert" => true));
				if (!$result['updatedExisting']) {
					$result = $db->media->update(
							array("_id" => $atid),
							array('$inc' => array("disliked" => 1))
					);
				}
			}
			if ($type === 'album') {
				$params = array(
					"alid" => $atid,
					"userid" => $_SESSION['uinfo']->_id,
					"type" => 0
				);
				$result = $db->albumliked->update($params, $params, array("upsert" => true));
				if (!$result['updatedExisting']) {
					$result = $db->album->update(
							array("_id" => $atid),
							array('$inc' => array("disliked" => 1))
					);
				}
			}
			if ($type === 'playlist') {
				$params = array(
					"plid" => $atid,
					"userid" => $_SESSION['uinfo']->_id,
					"type" => 0
				);
				$result = $db->playlistliked->update($params, $params, array("upsert" => true));
				if (!$result['updatedExisting']) {
					$result = $db->playlist->update(
							array("_id" => $atid),
							array('$inc' => array("disliked" => 1))
					);
				}
			}
			$dtr['status'] = 1;
			if ($result['ok'] == 1) {
				$dtr['message'] = "Cảm ơn bạn. Chúng tôi sẽ xem xét lại nội dung";
			} else {
				$dtr['message'] = "Đã có lỗi xảy ra. \n Vui lòng thử lại sau";
			}
		} else {
			$dtr['message'] = "Bạn cần đăng nhập để có thể bình chọn";
		}
		echo json_encode($dtr);
	}
	
	/**
	 * danh sach user like [audio, video, topic, album, playlist...]
	 */
	public function showUserLikeAction(){
		$id = $this->request->getQuery("id");
		$type = $this->request->getQuery("type");
		
		$usercl = $dbmg->user;
		if ($type == 'media') {
			$collection = MediaLiked;
			$field = "atid";
		} else if ($type == 'album') {
			$collection = AlbumLiked;
			$field = "alid";
		} else if ($type == 'playlist') {
			$collection = PlayListLiked;
			$field = "plid";
		}
		if (isset ($collection)) {
			$liked = $collection::find(array(
					"conditions" => array(
							$field => $id,
							"type" => 1
					)
			));
			
			if (count($liked)){
				foreach ($liked as $value) {
					$userIds[] = $value->userid;
				}
			}
			
			if (count($userIds)) {
				$users = User::find(array(
						"conditions" => array(
								"_id" => array('$in' => $userIds)
						),
						"fields" => array("_id", "priavatar", "username")
				));
				
				$index = 1;
				$userList = array();
				foreach ($users as $user) {
					$user->webLink = Helper::makeUserLink($user->name, $user->_id);
					$user->index = $index++;
					$userList[] = $user;
				}
				if (count($userList)){
					$dtr['data'] = $userList;
				} else {
					$dtr['data'] = array();
					$dtr['message'] = "Không có người nào thích tác phẩm này";
				}
			} else {
				$dtr['data'] = array();
				$dtr['message'] = "Không có người nào thích tác phẩm này";
			}
			$dtr['status'] = 1;
		} else {
			$dtr['status'] = 404;
			$dtr['message'] = "Cần chỉ rõ thể loại";
		}
		
		echo json_encode($dtr);
	}
	
	/**
	 * show danh sach user khong thich
	 */
	public function showUserDisLikeAction() {
		$id = $this->request->getQuery("id");
		$type = $this->request->getQuery("type");
		
		$usercl = $dbmg->user;
		if ($type == 'media') {
			$collection = MediaLiked;
			$field = "atid";
		} else if ($type == 'album') {
			$collection = AlbumLiked;
			$field = "alid";
		} else if ($type == 'playlist') {
			$collection = PlayListLiked;
			$field = "plid";
		}
		if (isset ($collection)) {
			$liked = $collection::find(array(
					"conditions" => array(
							$field => $id,
							"type" => 0
					)
			));
			
			if (count($liked)){
				foreach ($liked as $value) {
					$userIds[] = $value->userid;
				}
			}
			
			if (count($userIds)) {
				$users = User::find(array(
						"conditions" => array(
								"_id" => array('$in' => $userIds)
						),
						"fields" => array("_id", "priavatar", "username")
				));
				echo json_encode($users);exit;
				$index = 1;
				$userList = array();
				foreach ($users as $user) {
					$user->webLink = Helper::makeUserLink($user->name, $user->_id);
					$user->index = $index++;
					$userList[] = $user;
				}
				if (count($userList)){
					$dtr['data'] = $userList;
				} else {
					$dtr['data'] = array();
					$dtr['message'] = "Chưa có người nào không thích tác phẩm này";
				}
			} else {
				$dtr['data'] = array();
				$dtr['message'] = "Chưa có người nào không thích tác phẩm này";
			}
			$dtr['status'] = 1;
		} else {
			$dtr['status'] = 404;
			$dtr['message'] = "Cần chỉ rõ thể loại";
		}
		
		echo json_encode($dtr);
	}
	
	/**
	 * report spam
	 */
	public function reportSpamAction(){
		$atid = $this->request->getPost("val");
		
		$db = $this->getConnection();
		
		$db->media->update(
			array("_id" => (string)$atid),
			array('$inc' => array("spamflag" => 1))
		);
		$dtr['status'] = 1;
		$dtr['message'] = "Cảm ơn bạn đã báo cáo. Chúng tôi sẽ xem xét và có những khắc phục sớm";
		echo json_encode($dtr);
	}
	
	/**
	 * đề cử bài hát
	 */
	public function nominationAction(){
		$atid = $this->request->getPost("val");
		
		$db = $this->getConnection();
		
		$media = $db->media->findOne(array("_id" => "$atid"));
	
		##Top nomination
		$type = $media->type;
		if ($type == "audio" || $type == "video") {
			$today = strtotime(date("d-m-Y"));
			$db->modulemedianomination->update(
					array('mid' => $atid, 'date' => $today, 'type' => $type),
					array('$inc' => array("nomination" => 1)),
					array('upsert' => true)
			);
		}
		$dtr['status'] = 1;
		$dtr['message'] = "Cảm ơn bạn đã để cử tác phẩm này";
		echo json_encode($dtr);
	}
	
	/**
	 * autocomplete search data
	 */
	public function suggestSearchAction(){
		$this->view->enable();
		$this->view->setMainView('empty');
		$key = $this->request->getQuery('q', string, null);
		
		if ($key){
			$keyword = new MongoRegex("/".$key."/iu");
			
			// audio
			$audioList = Media::find(array(
					"conditions" => array(
							"fullsearch" => $keyword,
							"type" 		 => "audio"
					),
					"fields" => array("name"),
					"limit"  => 3
			));
			
			// video
			$videoList = Media::find(array(
					"conditions" => array(
							"fullsearch" => $keyword,
							"type" 		 => "video"
					),
					"fields" => array("name", "priavatar"),
					"limit"  => 3
			));
			
			// album
			$albumList = Album::find(array(
					"conditions" => array(
							"fullsearch" => $keyword
					),
					"fields" => array("name", "priavatar"),
					"limit" => 3
			));
			
			// singer
			$singerList = User::find(array(
					"conditions" => array(
							"fullsearch" => $keyword,
							"type" => "singer"
					),
					"fields" => array("name", "priavatar"),
					"limit" => 3
			));
			
			if (count($audioList) == 0
				&& count($videoList) == 0
				&& count($albumList) == 0
				&& count($singerList) == 0) {
				$alertContent = "Không tìm thấy kết quả phù hợp với từ: \"".$_GET['q'] . '"';
				$this->view->setVar("alertContent", $alertContent);
			} else {
				$this->view->setVar("audioList", $audioList);
				$this->view->setVar("videoList", $videoList);
				$this->view->setVar("albumList", $albumList);
				$this->view->setVar("singerList", $singerList);
			}
		}
		
		header('Content-Type: text/html;charset=UTF-8');
	}
}