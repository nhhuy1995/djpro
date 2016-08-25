<?php
$router = new \Phalcon\Mvc\Router();
$router->add("/", array(
    'controller' => 'index',
    'action' => 'index'
));
$router->add("/trang-chu.html", array(
    'controller' => 'index',
    'action' => 'index'
));
$router->add("/album.html", array(
    'controller' => 'album',
    'action' => 'index'
));
$router->add("/hoi-dap.html", array(
    'controller' => 'index',
    'action' => 'answer'
));
$router->add("/video.html", array(
    'controller' => 'video',
    'action' => 'index'
));
$router->add("/video-chon-loc.html", array(
    'controller' => 'video',
    'action' => 'selective'
));
$router->add("/video-moi.html", array(
    'controller' => 'video',
    'action' => 'new'
));
$router->add("/playlist-music.html", array(
    'controller' => 'playlist',
    'action' => 'music'
));
$router->add("/playlist-video.html", array(
    'controller' => 'playlist',
    'action' => 'video'
));

$router->add("/user.html", array(
    'controller' => 'user',
    'action' => 'updateinfo'
));
$router->add("/tin-tuc.html", array(
    'controller' => 'news',
    'action' => 'index'
));
$router->add("/anh.html", array(
    'controller' => 'images',
    'action' => 'index'
));
$router->add("/dang-nhac.html", array(
    'controller' => 'user',
    'action' => 'upload'
));
$router->add("/playlist-cua-toi.html", array(
    'controller' => 'user',
    'action' => 'playlist'
));
$router->add("/dang-nhap.html", array(
    'controller' => 'user',
    'action' => 'login'
));
$router->add("/dang-ky.html", array(
    'controller' => 'user',
    'action' => 'register'
));
$router->add("/doi-mat-khau.html", array(
    'controller' => 'user',
    'action' => 'changepassword'
));
$router->add("/logout.html", array(
    'controller' => 'user',
    'action' => 'logout'
));
$router->add("/quen-mat-khau.html", array(
    'controller' => 'user',
    'action' => 'forgotpassword'
));
$router->add("/khoi-phuc-mat-khau.html", array(
    'controller' => 'user',
    'action' => 'resetpassword'
));
$router->add("/tim-kiem.html", array(
    'controller' => 'search',
    'action' => 'index'
));
$router->add("/chu-de.html", array(
    'controller' => 'topic',
    'action' => 'index'
));
//topic new
$router->add("/chu-de-moi.html", array(
    'controller' => 'topic',
    'action' => 'new'
));
//topic selective
$router->add("/chu-de-chon-loc.html", array(
    'controller' => 'topic',
    'action' => 'selective'
));
//topic Highlights
$router->add("/chu-de-noi-bat.html", array(
    'controller' => 'topic',
    'action' => 'highlights'
));


$router->add("/dieu-khoan-thoa-thuan.html", array(
    'controller' => 'index',
    'action' => 'dieukhoan'
));
$router->add("/chinh-sach-rieng-tu.html", array(
    'controller' => 'index',
    'action' => 'riengtu'
));
$router->add("/lien-he.html", array(
    'controller' => 'index',
    'action' => 'lienhe'
));
$router->add("/bai-hat-moi.html", array(
    'controller' => 'music',
    'action' => 'new'
));
$router->add("/bai-hat-chon-loc.html", array(
    'controller' => 'music',
    'action' => 'selective'
));

$router->add("/chinh-sach-ban-quyen.html", array(
    'controller' => 'index',
    'action' => 'banquyen'
));
$router->add("/download.html", array(
    'controller' => 'download',
    'action' => 'index'
));
$router->add("/nghe-sy.html", array(
    'controller' => 'artist',
    'action' => 'index'
));
//member detail
$router->add('/{slug}-mb{uid:[0-9]+}.html', array(
    'controller' => 'user',
    'action' => 'member',
    'uid' => 1, // ([0-9]+)
));

//tag index
$router->add('/tags/{slug}-ti{tId:[0-9]+}.html', array(
    'controller' => 'tags',
    'action' => 'index',
    'tId' => 1, // ([0-9]+)
));
//artist detail
$router->add('/{slug}-art{atId:[0-9]+}.html', array(
    'controller' => 'artist',
    'action' => 'view',
    'atId' => 1, // ([0-9]+)
));
//news detail
$router->add('/{slug}-n{atId:[0-9]+}.html', array(
    'controller' => 'news',
    'action' => 'view',
    'atId' => 1, // ([0-9]+)
));
//Music Detail
$router->add('/{slug}-m{atId:[0-9]+}.html', array(
    'controller' => 'music',
    'action' => 'view',
    'atId' => 1, // ([0-9]+)
));
//Playlist music Detail
$router->add('/{slug}-plm{atId:[0-9]+}.html', array(
    'controller' => 'playlist',
    'action' => 'music',
    'atId' => 1, // ([0-9]+)
));
//Playlist video Detail
$router->add('/{slug}-plv{atId:[0-9]+}.html', array(
    'controller' => 'playlist',
    'action' => 'video',
    'atId' => 1, // ([0-9]+)
));


// video detail
$router->add('/{slug}-av{atId:[0-9]+}.html', array(
    'controller' => 'video',
    'action' => 'view',
    'atId' => 1, // ([0-9]+)
));

//category playlist(topic,album,playlist) detail
$router->add('/{slug}-cp{catId:[0-9]+}.html', array(
    'controller' => 'playlist',
    'action' => 'category',
    'catId' => 1, // ([0-9]+)
));
//category artist detail
$router->add('/{slug}-ca{catId:[0-9]+}.html', array(
    'controller' => 'artist',
    'action' => 'category',
    'catId' => 1, // ([0-9]+)
));
//category news detail
$router->add('/{slug}-cn{catId:[0-9]+}.html', array(
    'controller' => 'news',
    'action' => 'category',
    'catId' => 1, // ([0-9]+)
));
//category images detail
$router->add('/{slug}-ci{catId:[0-9]+}.html', array(
    'controller' => 'images',
    'action' => 'category',
    'catId' => 1, // ([0-9]+)
));
//album detail
$router->add('/{slug}-ab{atId:[0-9]+}.html', array(
    'controller' => 'album',
    'action' => 'view',
    'atId' => 1, // ([0-9]+)
));
//video category detail
$router->add('/{slug}-cv{catId:[0-9]+}.html', array(
    'controller' => 'video',
    'action' => 'category',
    'catId' => 1, // ([0-9]+)
));
//nhac san category detail
$router->add('/{slug}-cm{catId:[0-9]+}.html', array(
    'controller' => 'music',
    'action' => 'category',
    'catId' => 1, // ([0-9]+)
));
//album category detail
$router->add("/album.html", array(
    'controller' => 'album',
    'action' => 'index'
));
//album selective
$router->add("/album-chon-loc.html", array(
    'controller' => 'album',
    'action' => 'selective'
));
//album new
$router->add("/album-moi.html", array(
    'controller' => 'album',
    'action' => 'new'
));
//playlist selective
$router->add("/playlist-chon-loc.html", array(
    'controller' => 'playlist',
    'action' => 'selective'
));
//playlist new
$router->add("/playlist-moi.html", array(
    'controller' => 'playlist',
    'action' => 'new'
));
//playlist category detail
$router->add("/playlist.html", array(
    'controller' => 'playlist',
    'action' => 'index'
));
//music category detail
$router->add("/bai-hat.html", array(
    'controller' => 'music',
    'action' => 'index'
));
/*       page bài hát đã đăng của tôi      */
$router->add("/nhac-da-duyet.html", array(
    'controller' => 'musicofmy',
    'action' => 'indexon'
));
$router->add("/nhac-cho-duyet.html", array(
    'controller' => 'musicofmy',
    'action' => 'indexoff'
));
## nhạc đã xóa
$router->add("/nhac-da-xoa.html", array(
    'controller' => 'musicofmy',
    'action' => 'indexdelete'
));

/* page nominations */
$router->add("/bai-hat-de-cu.html", array(
    'controller' => 'ranking',
    'action' => 'nomination'
));
/* page top100*/
$router->add("/top100.html", array(
    'controller' => 'ranking',
    'action' => 'top100'
));
/* page BXH */
$router->add("/bxh.html", array(
    'controller' => 'ranking',
    'action' => 'index'
));

/******  Page search   *****/
//page search audio
$router->add("/tim-kiem/nhac.html", array(
    'controller' => 'search',
    'action' => 'audio'
));
//page search audio
$router->add("/tim-kiem/nghe-sy.html", array(
    'controller' => 'search',
    'action' => 'artist'
));
//page search audio
$router->add("/tim-kiem/album.html", array(
    'controller' => 'search',
    'action' => 'album'
));//page search audio
$router->add("/tim-kiem/playlist.html", array(
    'controller' => 'search',
    'action' => 'playlist'
));
//page search audio
$router->add("/tim-kiem/chu-de.html", array(
    'controller' => 'search',
    'action' => 'topic'
));
//page search audio
$router->add("/tim-kiem/video.html", array(
    'controller' => 'search',
    'action' => 'video'
));
// Routes for sitemap
$router->add('/sitemap.xml', array(
    'controller' => 'sitemap',
    'action' => 'main'
));

$router->add('/category.xml', array(
    'controller' => 'sitemap',
    'action' => 'category'
));

$router->add('/album{page:[0-9]+}.xml', array(
    'controller' => 'sitemap',
    'action' => 'album',
    'page ' => 1
));

$router->add('/playlist{page:[0-9]+}.xml', array(
    'controller' => 'sitemap',
    'action' => 'playlist',
    'page ' => 1
));

$router->add('/(audio|video|news|images){page:[0-9]+}.xml', array(
    'controller' => 'sitemap',
    'action' => 'article',
    'type' => 1,
    'page ' => 2
));

$router->add('/topic{page:[0-9]+}.xml', array(
    'controller' => 'sitemap',
    'action' => 'topic',
    'page ' => 1
));
$router->add('/user{page:[0-9]+}.xml', array(
    'controller' => 'sitemap',
    'action' => 'user',
    'page ' => 1
));
$router->add('/artist{page:[0-9]+}.xml', array(
    'controller' => 'sitemap',
    'action' => 'artist',
    'page ' => 1
));
$router->add('/tags{page:[0-9]+}.xml', array(
    'controller' => 'sitemap',
    'action' => 'tags',
    'page ' => 1
));
$router->add('/error.html', array(
    'controller' => 'notfound',
    'action' => 'show404',
));
#------------------ routes for Rss ------------------------#
$router->add('/rss', array(
    'controller' => 'index',
    'action' => 'rss',
));
$router->add('/(audio|video|news|images){page:[0-9]+}.rss', array(
    'controller' => 'rss',
    'action' => 'article',
    'type' => 1,
    'page ' => 2
));
$router->add('/artist{page:[0-9]+}.rss', array(
    'controller' => 'rss',
    'action' => 'artist',
    'page ' => 1
));
$router->add('/user{page:[0-9]+}.rss', array(
    'controller' => 'rss',
    'action' => 'user',
    'page ' => 1
));
$router->add('/tags{page:[0-9]+}.rss', array(
    'controller' => 'rss',
    'action' => 'tags',
    'page ' => 1
));
$router->add('/topic{page:[0-9]+}.rss', array(
    'controller' => 'rss',
    'action' => 'topic',
    'page ' => 1
));

$router->add('/album{page:[0-9]+}.rss', array(
    'controller' => 'rss',
    'action' => 'album',
    'page ' => 1
));

$router->add('/playlist{page:[0-9]+}.rss', array(
    'controller' => 'rss',
    'action' => 'playlist',
    'page ' => 1
));
//category news


##########  Routes for embed  ###################
$router->add('/ebd_m/{at_id:[0-9]+}', array(
    'controller' => 'embed',
    'action' => 'music',
    'at_id ' => 1
));

$router->add('/ebd_cl/{cl_id:[0-9]+}', array(
    'controller' => 'embed',
    'action' => 'collection',
    'cl_id ' => 1
));

$router->add('/ebd_v/{at_id:[0-9]+}', array(
    'controller' => 'embed',
    'action' => 'video',
    'at_id ' => 1
));
#################################################

$router->handle();
return $router;
?>