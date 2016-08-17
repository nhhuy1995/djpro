$(document).ready(function(){

    $('#show-more-tracklist').click(function(){
        $('#track-list').removeClass('row-5');
        $(this).hide();
        $('#show-less-tracklist').show();
        $('#show-less-tracklist').css("display","block");
    });
    $('#show-less-tracklist').click(function(){
        $('#track-list').addClass('row-5');
        $(this).hide();
        $('#show-more-tracklist').show();
    });
    

    $('nav#menu').mmenu({
        slidingSubmenus: false
    });

    $(window).resize(function(){$('.fb-comments iframe,.fb-comments span:first-child').css({'width':$('#commentboxcontainer').width()});});


    $('#show-fb-cm').click(function(){
        $('#member-cm').hide();
        $('#facebook-cm').show();
        $(this).addClass('disabled');
        $('#show-member-cm').removeClass('disabled');
    });

    $('#show-member-cm').click(function(){
        $('#facebook-cm').hide();
        $('#member-cm').show();
        $(this).addClass('disabled');
        $('#show-fb-cm').removeClass('disabled');
    });

    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id))
            return;
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/vi_VN/all.js#xfbml=1&appId=";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

});

function not_login(){
    alert('Bạn chưa đăng nhập !');
}

function likearticle(atid, ownerid, type){
    var params = {act:'likearticle',val:atid, ownerId: ownerid};
    if (type !== undefined) params.type = type;
    $.post('/service/likeArticle', params, function(re){
        alert(re.message);
    });
}

function dislikearticle(atid, type){
    var conf=confirm('Bạn chắn chắn muốn dislike ?');
    if(conf==true){
        var params = {act:'dislikearticle', val:atid};
        if (type !== undefined) params.type = type;
        $.post('/service/disLikeArticle', params, function(re){
            alert(re.message);
        });
    }
}

function nomination(atid){
    var conf=confirm('Bạn chắn chắn muốn đề cử bài này lên danh sách bài hát hay ? Hãy giúp chúng tôi lựa chọn những bài THỰC SỰ CHẤT LƯỢNG !');
    if(conf==true){
        $.post('/service/nomination',{act:'nomination',val:atid},function(re){
            alert(re.message);
        });
    }
    return false;
}
function errorArticle(atid){
    $.post('/service/reportSpam',{act:'errorarticle',val:atid},function(re){
        var data = eval(re);
        alert(data.message);
    });
    return false;
}

function updateIosLink(atid){
    var conf=confirm('Bạn chắn chắn muốn yêu cầu cập nhật link nghe trên iOS cho bài hát này ?');
    if(conf==true){
        $.post('/ajaxprocess.se',{act:'a3',val:atid},function(re){
            var data = eval(re);
            if(data.status==1) $('#updateLinkModal').modal('show');
            else alert(data.message);
        });
    }
    return false;
}

function becomeFan(djid) {
    var conf=confirm('Bạn có muốn trở thành Fan của dj này ?');
    if(conf==true){
        $.post('/service/becomeFan',{act:'becomefan', djid:djid},function(re){
            alert(re.message);
        });
    }
}

function showAddPlaylist(atid) {
    var db = {act: "loadallplaylist"};
    $.get("/service/loadAllPlayList", db, function (re) {
        if (re.status ==1) {
            $("#playlist-list").empty();
            var str_temp = "";
            var playlist = re.data;
            if (playlist != null) {
                playlist.forEach( function(elem) {
                    str_temp += createRowPlaylist(atid, elem);
                });
                $("#addPlaylist_at_id").attr('data-atid', atid);
                $("#playlist-list").append(str_temp);
            }
            $("#my-playlist-box").show();
        } else {
            alert(re.message);
        }
    });
}

function addToPlaylist(atid, playlistID) {
    $("#loading").show();
    var db = {act: "addtoplaylist", atid: atid, plid: playlistID};
    $.post("/service/addToPlaylist", db, function (re) {
        if (re.status == 0) {
            notifiBL(re.message, "error");
            $("#loading").hide();
        } else {
            notifiBL(re.message, "success");
            //$("#background-popup").fadeOut(200);
            $("#my-playlist-box").fadeOut(200);
            $("#loading").hide();
        }
    });
}

function addNewPlaylist() {
    $("#loading").show();
    var atid = $("#addPlaylist_at_id").attr('data-atid');
    var plname = $("#add-playlist-name").val();
    if (plname.length < 5) {
        alert("Tên Playlist phải ít nhất 5 ký tự !");
        $("#add-playlist-name").focus();
        $("#loading").hide();
    } else {
        var db = {act: "addnewplaylist", name: plname, atid: atid};
        $.post("/service/addNewPlaylist", db, function (re) {
            if (re.status == 0) {
                notifiBL(re.message, "error", 3000);
                $("#loading").hide();
            } else {
                var str_temp = createRowPlaylist(atid, re.data);
                $("#playlist-list").prepend(str_temp);
                $("#add-playlist-name").val("");
                notifiBL(re.message, "success", 3000);
                $("#loading").hide();
            }
        });
    }
}

function createRowPlaylist(atid, elem) {
    var str_temp ="";
    str_temp +=  '<div class="playlist-list-item">'
        +'<div class="playlist-list-name">'
        + '<a href="javascript:void(0);" onclick="addToPlaylist('+atid+','+elem._id+')" title="Thử Playlist mới"'
        + 'id="playlist-'+elem._id+'"><i class="icon-music"></i>' + elem.name+'</a>'
        + '</div>'
        +'</div>';
    return str_temp;
}

$(document).ready(function(){
    if($('#nomination-article').length>0){
        var sec = 60;
        var timer = setInterval(function() {
            $('#nomi-count').text('('+sec--+')');
            if (sec == -1) {
                $('#nomi-count').html('');
                document.getElementById("nomination-article").disabled = false;
                clearInterval(timer);
            }
        }, 1000);
    }
});

function addComment(atid,pid,txtvalue,objhtml,type) {
    var atType = (type === undefined) ? 'audio': type;
    var content = $('#'+txtvalue).val();
    var db = {act:'addcomment',atid:atid,pid:pid,content:content, type: atType};
    if(content.length<=5){ alert('Nội dung bình luận phải có ít nhất 5 kí tự, vui lòng thử lại !'); return false; }
    $('#loading').show();
    $.post('/service/addComment',db,function(data){
        if(data.status==1) {
            if(objhtml==null|| objhtml == undefined)  $("#_tmplComment").tmpl(data.data).prependTo("#cmitem");
            else  $("#_tmplReplyComment").tmpl(data.data).prependTo('#'+objhtml);
            $('.cmt-box .textarea').val("");
            $('#loading').hide();
        } else {
            alert(data.message);
            $('#loading').hide();
        }
    });
}

function loadComment(atid,pid,objhtml, type) {
    $('#loading').show();
    var atType = (type === undefined) ? 'audio': type;
    if((objhtml==null||objhtml==undefined) && type == null) {
        var db =  {act:'loadcomment',atid: atid,pid:pid, type: atType};
    } else {
        var spage = $(objhtml).attr('data-page');
        var db =  {act:'loadcomment',atid: atid,pid:pid,p:spage, type: atType};
        ++spage;
        $(objhtml).attr('data-page',spage);
    }
    $.post('/service/loadComment',db,function(data){
        if(data.status==1 )
        {
            if (data.data) {
                if(pid <=0) //$('#cmitem').append(data.data);
                    $("#_tmplComment").tmpl(data.data).appendTo("#cmitem");
                else {
                    //$('#reply-cmt-'+pid).append(data.data);
                    $("#_tmplReplyComment").tmpl(data.data).appendTo("#reply-cmt-"+pid);
                    $('#view-more-child-'+pid).hide();
                    //$('#show-hide-child-'+pid).show();
                }
                if (data.data.length < 10) {
                    if (objhtml == null) $("#view-main-comment").hide();
                    else $(objhtml).hide();
                }
            } else {
                if (objhtml == null) $("#view-main-comment").hide();
                else $(objhtml).hide();
            }
            if(data.count>0 && $('.cmt-box-title span').html().length<=0) { $('.cmt-box-title span').html('('+data.count+')'); $('.cmt-box-title').show(); };
            $('#loading').hide();
        }
        else if(data.status==15 ) { $(objhtml).hide(); $('#loading').hide(); }
    });
    return false;
}

function showrpform (cm_id) {
    $('#reply-comment-'+cm_id).show();
}

function hiderpform (cm_id) {
    $('#reply-comment-'+cm_id).hide();
}

function showhidecm(cm_id) {
    $('#reply-cmt-'+cm_id).toggle();
}

$(document).ready( function() {
    $("#comment-list,#top-decu-by-supercom,#list-album-playlist-song,#notifiBox #wrap-notifi, #wrap-suggest, #wrap-listsong")
        .slimScroll({height: "auto", railVisible: true, railColor: "#444", color: "#777"});
    $("#close-utility-box").click(function() {
        $("#utilityBox").hide();
    });
});

function showRemoveReason(id) {
    $('#loading').show();
    var db = {act: 'showremovereason', id: id};
    $.get('./ajaxprocess.se',db,function(data){
        if(data.status==1) {
            if (data.message == undefined)
                data.message = "Không có lý do cụ thể";
            alert(data.message);
        }
        $('#loading').hide();
    });
}

function showUserLike(id, type) {
    $('#loading').show();
    var db = {act: 'showuserlike', id: id ,type: type};
    $.get('/service/showUserLike',db,function(data){
        if(data.status==1) {
            loadModalInArticle("Danh sách những thành viên thích tác phẩm này", data);
        }
        $('#loading').hide();
    });
}

function showUserDisLike(id, type) {
    $('#loading').show();
    var db = {act: 'showuserdislike', id: id, type: type};
    $.get('/service/showUserDisLike',db,function(data){
        if(data.status==1) {
            loadModalInArticle("Danh sách những thành viên không thích tác phẩm này", data);
        }
        $('#loading').hide();
    });
}

function loadModalInArticle(title,content){
    $('#modal_like_unlike #superComTitle').html(title);
    var listUser = $("#modal_like_unlike #tuoigiAlertContent ul");
    listUser.empty();
    listUser.parent().children("#noneUser_like_dislike").html('');
    if (content.data.length > 0)
        $("#_tmplUserInfor").tmpl(content.data).appendTo(listUser);
    else
        listUser.parent().children("#noneUser_like_dislike").html(content.message);
    $('#modal_like_unlike').modal('show');
}
var next_prev_ajax = {
    "sameaudio_prev": 0,
    "sameaudio_next": 2,
    "unlisten_prev": 0,
    "unlisten_next": 2,
    "newest_prev": 0,
    "newest_next": 2,
};

function moreArticle(actionType,dataType, mediaTypeRelate, domPageAction){
    var prevPage = parseInt($('#prevPage').val());
    var nextPage = parseInt($('#nextPage').val());
    var posterId = parseInt($('#posterId').val());
    /*var prevPage = next_prev_ajax[dataType+'_prev'];
    var nextPage = next_prev_ajax[dataType+'_next'];
    var posterId = parseInt($('#posterId').val());*/

    var mediaType = "audio";
    if (mediaTypeRelate)
        mediaType = mediaTypeRelate;
    if(prevPage==0 && nextPage==2) $('.btn-prev-'+dataType).show();
    if(prevPage==1 && actionType=='prev') $('.btn-prev-'+dataType).hide();
    if(actionType=='next'){
        ++next_prev_ajax[dataType+'_prev'];
        ++next_prev_ajax[dataType+'_next'];
    }
    else {
        --next_prev_ajax[dataType+'_prev'];
        --next_prev_ajax[dataType+'_next'];
    }

    var db = {act: 'morearticle', actionType: actionType, dataType: dataType, mediaType:mediaType, posterId: posterId, prevPage: prevPage, nextPage: nextPage};
    $.post('/service/loadMoreList',db,function(data){
        if(data.status==1) { $('.'+dataType).html(data.data); if(data.size<5) $('.btn-next-'+dataType).hide(); else $('.btn-next-'+dataType).show(); }
    });
}

$(document).ready(function(){
    $("#show-more-songtracklist").click(function () {
        $("#track-list-content").removeClass("rows7");
        $(this).hide();
        $("#show-less-songtracklist").css("display", "inline-block");
    });

    $("#show-less-songtracklist").click(function () {
        $("#track-list-content").addClass("rows7");
        $(this).hide();
        $("#show-more-songtracklist").show();
    });

});
    var timeLimit = 400;
    var suggestThread;
    var inputKeySearch = function() {
        clearTimeout(suggestThread);
        suggestThread = setTimeout(function () {
            var key = $("#q1").val();
            if (key.length > 0)
                loadSuggestion(key);
        }, timeLimit);
    }
    var loadSuggestion = function(key) {
        var db = {act: 'suggestsearch', q: key};
        $.get('/service/suggestSearch',db,function(data){
            $("#search-result-box").html(data);
            var clickToHide = function (event) {
                if (!$(event.target).is(".vietcom-suggest")) {
                    $(".vietcom-suggest").hide();
                    $('body').unbind('click', clickToHide);
                }
            };
            $('body').on('click', clickToHide);
        });

    };

var jqueryNew=new function(){var self=this;self.installed=false;self.raw="";self.major=-1;self.minor=-1;self.revision=-1;self.revisionStr="";var activeXDetectRules=[{"name":"ShockwaveFlash.ShockwaveFlash.7","version":function(obj){return getActiveXVersion(obj);}},{"name":"ShockwaveFlash.ShockwaveFlash.6","version":function(obj){var version="6,0,21";try{obj.AllowScriptAccess="always";version=getActiveXVersion(obj);}catch(err){}return version;}},{"name":"ShockwaveFlash.ShockwaveFlash","version":function(obj){return getActiveXVersion(obj);}}];var getActiveXVersion=function(activeXObj){var version=-1;try{version=activeXObj.GetVariable("$version");}catch(err){}return version;};var getActiveXObject=function(name){var obj=-1;try{obj=new ActiveXObject(name);}catch(err){obj={activeXError:true};}return obj;};var parseActiveXVersion=function(str){var versionArray=str.split(",");return{"raw":str,"major":parseInt(versionArray[0].split(" ")[1],10),"minor":parseInt(versionArray[1],10),"revision":parseInt(versionArray[2],10),"revisionStr":versionArray[2]};};var parseStandardVersion=function(str){var descParts=str.split(/ +/);var majorMinor=descParts[2].split(/\./);var revisionStr=descParts[3];return{"raw":str,"major":parseInt(majorMinor[0],10),"minor":parseInt(majorMinor[1],10),"revisionStr":revisionStr,"revision":parseRevisionStrToInt(revisionStr)};};var parseRevisionStrToInt=function(str){return parseInt(str.replace(/[a-zA-Z]/g,""),10)||self.revision;};self.majorAtLeast=function(version){return self.major>=version;};self.minorAtLeast=function(version){return self.minor>=version;};self.revisionAtLeast=function(version){return self.revision>=version;};self.versionAtLeast=function(major){var properties=[self.major,self.minor,self.revision];var len=Math.min(properties.length,arguments.length);for(i=0;i<len;i++){if(properties[i]>=arguments[i]){if(i+1<len&&properties[i]==arguments[i]){continue;}else{return true;}}else{return false;}}};self.jqueryNew=function(){if(navigator.plugins&&navigator.plugins.length>0){var type="application/x-shockwave-flash";var mimeTypes=navigator.mimeTypes;if(mimeTypes&&mimeTypes[type]&&mimeTypes[type].enabledPlugin&&mimeTypes[type].enabledPlugin.description){var version=mimeTypes[type].enabledPlugin.description;var versionObj=parseStandardVersion(version);self.raw=versionObj.raw;self.major=versionObj.major;self.minor=versionObj.minor;self.revisionStr=versionObj.revisionStr;self.revision=versionObj.revision;self.installed=true;}}else{if(navigator.appVersion.indexOf("Mac")==-1&&window.execScript){var version=-1;for(var i=0;i<activeXDetectRules.length&&version==-1;i++){var obj=getActiveXObject(activeXDetectRules[i].name);if(!obj.activeXError){self.installed=true;version=activeXDetectRules[i].version(obj);if(version!=-1){var versionObj=parseActiveXVersion(version);self.raw=versionObj.raw;self.major=versionObj.major;self.minor=versionObj.minor;self.revision=versionObj.revision;self.revisionStr=versionObj.revisionStr;}}}}}}();};jqueryNew.JS_RELEASE="1.0.4";
(function($){var _PLUGIN_="mmenu",_VERSION_="4.1.7";if($[_PLUGIN_]){return;}var glbl={$wndw:null,$html:null,$body:null,$page:null,$blck:null,$allMenus:null,$scrollTopNode:null};var _c={},_e={},_d={},_serialnr=0;$[_PLUGIN_]=function($menu,opts,conf){glbl.$allMenus=glbl.$allMenus.add($menu);this.$menu=$menu;this.opts=opts;this.conf=conf;this.serialnr=_serialnr++;this._init();return this;};$[_PLUGIN_].prototype={open:function(){this._openSetup();this._openFinish();return"open";},_openSetup:function(){var _scrollTop=findScrollTop();this.$menu.addClass(_c.current);glbl.$allMenus.not(this.$menu).trigger(_e.close);glbl.$page.data(_d.style,glbl.$page.attr("style")||"").data(_d.scrollTop,_scrollTop).data(_d.offetLeft,glbl.$page.offset().left);var _w=0;glbl.$wndw.off(_e.resize).on(_e.resize,function(e,force){if(force||glbl.$html.hasClass(_c.opened)){var nw=glbl.$wndw.width();if(nw!=_w){_w=nw;glbl.$page.width(nw-glbl.$page.data(_d.offetLeft));}}}).trigger(_e.resize,[true]);if(this.conf.preventTabbing){glbl.$wndw.off(_e.keydown).on(_e.keydown,function(e){if(e.keyCode==9){e.preventDefault();return false;}});}if(this.opts.modal){glbl.$html.addClass(_c.modal);}if(this.opts.moveBackground){glbl.$html.addClass(_c.background);}if(this.opts.position!="left"){glbl.$html.addClass(_c.mm(this.opts.position));}if(this.opts.zposition!="back"){glbl.$html.addClass(_c.mm(this.opts.zposition));}if(this.opts.classes){glbl.$html.addClass(this.opts.classes);}glbl.$html.addClass(_c.opened);this.$menu.addClass(_c.opened);glbl.$page.scrollTop(_scrollTop);this.$menu.scrollTop(0);},_openFinish:function(){var that=this;transitionend(glbl.$page,function(){that.$menu.trigger(_e.opened);},this.conf.transitionDuration);glbl.$html.addClass(_c.opening);this.$menu.trigger(_e.opening);window.scrollTo(0,1);},close:function(){var that=this;transitionend(glbl.$page,function(){that.$menu.removeClass(_c.current).removeClass(_c.opened);glbl.$html.removeClass(_c.opened).removeClass(_c.modal).removeClass(_c.background).removeClass(_c.mm(that.opts.position)).removeClass(_c.mm(that.opts.zposition));if(that.opts.classes){glbl.$html.removeClass(that.opts.classes);}glbl.$wndw.off(_e.resize).off(_e.keydown);glbl.$page.attr("style",glbl.$page.data(_d.style));if(glbl.$scrollTopNode){glbl.$scrollTopNode.scrollTop(glbl.$page.data(_d.scrollTop));}that.$menu.trigger(_e.closed);},this.conf.transitionDuration);glbl.$html.removeClass(_c.opening);this.$menu.trigger(_e.closing);return"close";},_init:function(){this.opts=extendOptions(this.opts,this.conf,this.$menu);this.direction=(this.opts.slidingSubmenus)?"horizontal":"vertical";this._initPage(glbl.$page);this._initMenu();this._initBlocker();this._initPanles();this._initLinks();this._initOpenClose();this._bindCustomEvents();if($[_PLUGIN_].addons){for(var a=0;a<$[_PLUGIN_].addons.length;a++){if(typeof this["_addon_"+$[_PLUGIN_].addons[a]]=="function"){this["_addon_"+$[_PLUGIN_].addons[a]]();}}}},_bindCustomEvents:function(){var that=this;this.$menu.off(_e.open+" "+_e.close+" "+_e.setPage+" "+_e.update).on(_e.open+" "+_e.close+" "+_e.setPage+" "+_e.update,function(e){e.stopPropagation();});this.$menu.on(_e.open,function(e){if($(this).hasClass(_c.current)){e.stopImmediatePropagation();return false;}return that.open();}).on(_e.close,function(e){if(!$(this).hasClass(_c.current)){e.stopImmediatePropagation();return false;}return that.close();}).on(_e.setPage,function(e,$p){that._initPage($p);that._initOpenClose();});var $panels=this.$menu.find(this.opts.isMenu&&this.direction!="horizontal"?"ul, ol":"."+_c.panel);$panels.off(_e.toggle+" "+_e.open+" "+_e.close).on(_e.toggle+" "+_e.open+" "+_e.close,function(e){e.stopPropagation();});if(this.direction=="horizontal"){$panels.on(_e.open,function(e){return openSubmenuHorizontal($(this),that.$menu);});}else{$panels.on(_e.toggle,function(e){var $t=$(this);return $t.triggerHandler($t.parent().hasClass(_c.opened)?_e.close:_e.open);}).on(_e.open,function(e){$(this).parent().addClass(_c.opened);return"open";}).on(_e.close,function(e){$(this).parent().removeClass(_c.opened);return"close";});}},_initBlocker:function(){var that=this;if(!glbl.$blck){glbl.$blck=$('<div id="'+_c.blocker+'" />').css("opacity",0).appendTo(glbl.$body);}glbl.$blck.off(_e.touchstart).on(_e.touchstart,function(e){e.preventDefault();e.stopPropagation();glbl.$blck.trigger(_e.mousedown);}).on(_e.mousedown,function(e){e.preventDefault();if(!glbl.$html.hasClass(_c.modal)){that.$menu.trigger(_e.close);}});},_initPage:function($p){if(!$p){$p=$(this.conf.pageSelector,glbl.$body);if($p.length>1){$[_PLUGIN_].debug("Multiple nodes found for the page-node, all nodes are wrapped in one <"+this.conf.pageNodetype+">.");$p=$p.wrapAll("<"+this.conf.pageNodetype+" />").parent();}}$p.addClass(_c.page);glbl.$page=$p;},_initMenu:function(){var that=this;if(this.conf.clone){this.$menu=this.$menu.clone(true);this.$menu.add(this.$menu.find("*")).filter("[id]").each(function(){$(this).attr("id",_c.mm($(this).attr("id")));});}this.$menu.contents().each(function(){if($(this)[0].nodeType==3){$(this).remove();}});this.$menu.prependTo("body").addClass(_c.menu);this.$menu.addClass(_c.mm(this.direction));if(this.opts.classes){this.$menu.addClass(this.opts.classes);}if(this.opts.isMenu){this.$menu.addClass(_c.ismenu);}if(this.opts.position!="left"){this.$menu.addClass(_c.mm(this.opts.position));}if(this.opts.zposition!="back"){this.$menu.addClass(_c.mm(this.opts.zposition));}},_initPanles:function(){var that=this;this.__refactorClass($("."+this.conf.listClass,this.$menu),"list");if(this.opts.isMenu){$("ul, ol",this.$menu).not(".mm-nolist").addClass(_c.list);}var $lis=$("."+_c.list+" > li",this.$menu);this.__refactorClass($lis.filter("."+this.conf.selectedClass),"selected");this.__refactorClass($lis.filter("."+this.conf.labelClass),"label");this.__refactorClass($lis.filter("."+this.conf.spacerClass),"spacer");$lis.off(_e.setSelected).on(_e.setSelected,function(e,selected){e.stopPropagation();$lis.removeClass(_c.selected);if(typeof selected!="boolean"){selected=true;}if(selected){$(this).addClass(_c.selected);}});this.__refactorClass($("."+this.conf.panelClass,this.$menu),"panel");this.$menu.children().filter(this.conf.panelNodetype).add(this.$menu.find("."+_c.list).children().children().filter(this.conf.panelNodetype)).addClass(_c.panel);var $panels=$("."+_c.panel,this.$menu);$panels.each(function(i){var $t=$(this),id=$t.attr("id")||_c.mm("m"+that.serialnr+"-p"+i);$t.attr("id",id);});$panels.find("."+_c.panel).each(function(i){var $t=$(this),$u=$t.is("ul, ol")?$t:$t.find("ul ,ol").first(),$l=$t.parent(),$a=$l.find("> a, > span"),$p=$l.closest("."+_c.panel);$t.data(_d.parent,$l);if($l.parent().is("."+_c.list)){var $btn=$('<a class="'+_c.subopen+'" href="#'+$t.attr("id")+'" />').insertBefore($a);if(!$a.is("a")){$btn.addClass(_c.fullsubopen);}if(that.direction=="horizontal"){$u.prepend('<li class="'+_c.subtitle+'"><a class="'+_c.subclose+'" href="#'+$p.attr("id")+'">'+$a.text()+"</a></li>");}}});var evt=this.direction=="horizontal"?_e.open:_e.toggle;$panels.each(function(i){var $opening=$(this),id=$opening.attr("id");$('a[href="#'+id+'"]',that.$menu).off(_e.click).on(_e.click,function(e){e.preventDefault();$opening.trigger(evt);});});if(this.direction=="horizontal"){var $selected=$("."+_c.list+" > li."+_c.selected,this.$menu);$selected.add($selected.parents("li")).parents("li").removeClass(_c.selected).end().each(function(){var $t=$(this),$u=$t.find("> ."+_c.panel);if($u.length){$t.parents("."+_c.panel).addClass(_c.subopened);$u.addClass(_c.opened);}}).closest("."+_c.panel).addClass(_c.opened).parents("."+_c.panel).addClass(_c.subopened);}else{$("li."+_c.selected,this.$menu).addClass(_c.opened).parents("."+_c.selected).removeClass(_c.selected);}var $current=$panels.filter("."+_c.opened);if(!$current.length){$current=$panels.first();}$current.addClass(_c.opened).last().addClass(_c.current);if(this.direction=="horizontal"){$panels.find("."+_c.panel).appendTo(this.$menu);}},_initLinks:function(){var that=this;$("."+_c.list+" > li > a",this.$menu).not("."+_c.subopen).not("."+_c.subclose).not('[rel="external"]').not('[target="_blank"]').off(_e.click).on(_e.click,function(e){var $t=$(this),href=$t.attr("href");if(that.__valueOrFn(that.opts.onClick.setSelected,$t)){$t.parent().trigger(_e.setSelected);}var preventDefault=that.__valueOrFn(that.opts.onClick.preventDefault,$t,href.slice(0,1)=="#");if(preventDefault){e.preventDefault();}if(that.__valueOrFn(that.opts.onClick.blockUI,$t,!preventDefault)){glbl.$html.addClass(_c.blocking);}if(that.__valueOrFn(that.opts.onClick.close,$t,preventDefault)){that.$menu.triggerHandler(_e.close);}});},_initOpenClose:function(){var that=this;var id=this.$menu.attr("id");if(id&&id.length){if(this.conf.clone){id=_c.umm(id);}$('a[href="#'+id+'"]').off(_e.click).on(_e.click,function(e){e.preventDefault();that.$menu.trigger(_e.open);});}var id=glbl.$page.attr("id");if(id&&id.length){$('a[href="#'+id+'"]').off(_e.click).on(_e.click,function(e){e.preventDefault();that.$menu.trigger(_e.close);});}},__valueOrFn:function(o,$e,d){if(typeof o=="function"){return o.call($e[0]);}if(typeof o=="undefined"&&typeof d!="undefined"){return d;}return o;},__refactorClass:function($e,c){$e.removeClass(this.conf[c+"Class"]).addClass(_c[c]);}};$.fn[_PLUGIN_]=function(opts,conf){if(!glbl.$wndw){_initPlugin();}opts=extendOptions(opts,conf);conf=extendConfiguration(conf);return this.each(function(){var $menu=$(this);if($menu.data(_PLUGIN_)){return;}$menu.data(_PLUGIN_,new $[_PLUGIN_]($menu,opts,conf));});};$[_PLUGIN_].version=_VERSION_;$[_PLUGIN_].defaults={position:"left",zposition:"back",moveBackground:true,slidingSubmenus:true,modal:false,classes:"",onClick:{setSelected:true}};$[_PLUGIN_].configuration={preventTabbing:true,panelClass:"Panel",listClass:"List",selectedClass:"Selected",labelClass:"Label",spacerClass:"Spacer",pageNodetype:"div",panelNodetype:"ul, ol, div",transitionDuration:400};(function(){var wd=window.document,ua=window.navigator.userAgent,ds=document.createElement("div").style;var _touch="ontouchstart" in wd,_overflowscrolling="WebkitOverflowScrolling" in wd.documentElement.style,_transition=(function(){if("webkitTransition" in ds){return"webkitTransition";}return"transition" in ds;})(),_oldAndroidBrowser=(function(){if(ua.indexOf("Android")>=0){return 2.4>parseFloat(ua.slice(ua.indexOf("Android")+8));}return false;})();$[_PLUGIN_].support={touch:_touch,transition:_transition,oldAndroidBrowser:_oldAndroidBrowser,overflowscrolling:(function(){if(!_touch){return true;}if(_overflowscrolling){return true;}if(_oldAndroidBrowser){return false;}return true;})()};})();$[_PLUGIN_].useOverflowScrollingFallback=function(use){if(glbl.$html){if(typeof use=="boolean"){glbl.$html[use?"addClass":"removeClass"](_c.nooverflowscrolling);}return glbl.$html.hasClass(_c.nooverflowscrolling);}else{_useOverflowScrollingFallback=use;return use;}};$[_PLUGIN_].debug=function(msg){};$[_PLUGIN_].deprecated=function(depr,repl){if(typeof console!="undefined"&&typeof console.warn!="undefined"){console.warn("MMENU: "+depr+" is deprecated, use "+repl+" instead.");}};var _useOverflowScrollingFallback=!$[_PLUGIN_].support.overflowscrolling;function extendOptions(o,c,$m){if(typeof o!="object"){o={};}if($m){if(typeof o.isMenu!="boolean"){var $c=$m.children();o.isMenu=($c.length==1&&$c.is(c.panelNodetype));}return o;}if(typeof o.onClick!="object"){o.onClick={};}if(typeof o.onClick.setLocationHref!="undefined"){$[_PLUGIN_].deprecated("onClick.setLocationHref option","!onClick.preventDefault");if(typeof o.onClick.setLocationHref=="boolean"){o.onClick.preventDefault=!o.onClick.setLocationHref;}}o=$.extend(true,{},$[_PLUGIN_].defaults,o);if($[_PLUGIN_].useOverflowScrollingFallback()){switch(o.position){case"top":case"right":case"bottom":$[_PLUGIN_].debug('position: "'+o.position+'" not supported when using the overflowScrolling-fallback.');o.position="left";break;}switch(o.zposition){case"front":case"next":$[_PLUGIN_].debug('z-position: "'+o.zposition+'" not supported when using the overflowScrolling-fallback.');o.zposition="back";break;}}return o;}function extendConfiguration(c){if(typeof c!="object"){c={};}if(typeof c.panelNodeType!="undefined"){$[_PLUGIN_].deprecated("panelNodeType configuration option","panelNodetype");c.panelNodetype=c.panelNodeType;}c=$.extend(true,{},$[_PLUGIN_].configuration,c);if(typeof c.pageSelector!="string"){c.pageSelector="> "+c.pageNodetype;}return c;}function _initPlugin(){glbl.$wndw=$(window);glbl.$html=$("html");glbl.$body=$("body");glbl.$allMenus=$();$.each([_c,_d,_e],function(i,o){o.add=function(c){c=c.split(" ");for(var d in c){o[c[d]]=o.mm(c[d]);}};});_c.mm=function(c){return"mm-"+c;};_c.add("menu ismenu panel list subtitle selected label spacer current highest hidden page blocker modal background opened opening subopened subopen fullsubopen subclose nooverflowscrolling");_c.umm=function(c){if(c.slice(0,3)=="mm-"){c=c.slice(3);}return c;};_d.mm=function(d){return"mm-"+d;};_d.add("parent style scrollTop offetLeft");_e.mm=function(e){return e+".mm";};_e.add("toggle open opening opened close closing closed update setPage setSelected transitionend touchstart touchend mousedown mouseup click keydown keyup resize");$[_PLUGIN_]._c=_c;$[_PLUGIN_]._d=_d;$[_PLUGIN_]._e=_e;$[_PLUGIN_].glbl=glbl;$[_PLUGIN_].useOverflowScrollingFallback(_useOverflowScrollingFallback);}function openSubmenuHorizontal($opening,$m){if($opening.hasClass(_c.current)){return false;}var $panels=$("."+_c.panel,$m),$current=$panels.filter("."+_c.current);$panels.removeClass(_c.highest).removeClass(_c.current).not($opening).not($current).addClass(_c.hidden);if($opening.hasClass(_c.opened)){$current.addClass(_c.highest).removeClass(_c.opened).removeClass(_c.subopened);}else{$opening.addClass(_c.highest);$current.addClass(_c.subopened);}$opening.removeClass(_c.hidden).removeClass(_c.subopened).addClass(_c.current).addClass(_c.opened);return"open";}function findScrollTop(){if(!glbl.$scrollTopNode){if(glbl.$html.scrollTop()!=0){glbl.$scrollTopNode=glbl.$html;}else{if(glbl.$body.scrollTop()!=0){glbl.$scrollTopNode=glbl.$body;}}}return(glbl.$scrollTopNode)?glbl.$scrollTopNode.scrollTop():0;}function transitionend($e,fn,duration){var s=$[_PLUGIN_].support.transition;if(s=="webkitTransition"){$e.one("webkitTransitionEnd",fn);}else{if(s){$e.one(_e.transitionend,fn);}else{setTimeout(fn,duration);}}}})(jQuery);