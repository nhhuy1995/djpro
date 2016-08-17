<link rel="stylesheet" href="/web/skins/jplayer.css" type="text/css"/>
<script type="text/javascript" src="/web/playlist/jplayer/jquery.jplayer.min.js"></script>
<script type="text/javascript" src="/web/js/jplayer.playlist.js"></script>
<script type="text/javascript">
    //<![CDATA[
    $(document).ready(function () {
        var repeat = Cookies.get('jPlayer-audio-repeat');
        if (repeat == 'true')
            repeat = true;
        else
            repeat = false;

        var playlistPlayer = new jPlayerPlaylist({
            jPlayer: "#jquery_jplayer",
            cssSelectorAncestor: "#jp_container"
        }, [
        <?php foreach ($listSong as $key => $item) { ?>
        {
            title: "<?php echo $key + 1; ?>. <?php echo $item['name']; ?>",
            artistname: "<?php echo $item['listartist']['username']; ?>",
            artistlink: "<?php echo $item['listartist']['link']; ?>",
            free: true,
            id: "<?php echo $item['_id']; ?>",
            checklike: "<?php echo $item['checklike']; ?>",
            nominations: "<?php echo $item['nominations']; ?>",
            link: "<?php echo $item['link']; ?>",
            type: "<?php echo $item['type']; ?>",
            name: "<?php echo $item['name']; ?>",
            media_link_128k: "<?php echo $item['media_link_128k']; ?>",
            media_link_64k: "<?php echo $item['media_link_64k']; ?>",
            media_link_320k: "<?php echo $item['media_link_320k']; ?>",
            
        },
        <?php } ?>
        ], {
            loop: repeat,
            playlistOptions: {
//                enableRemoveControls: true,
autoPlay: true,
displayItemAction: function (elem) {
    return '<span class="wolf-jp-song-url">'
    <?php if ($session['_id']) { ?>
    + '<a class="addplaylist" href="javascript:void(0)" title="Thêm vào" data-toggle="modal" data-target="#my-playlist-box" onclick="showFormAddPlaylist(' + elem.id + ');"></a>'
    + '<a class="like" ' + (elem.checklike == 1 ? 'id="icon-active"' : '') + ' checklike="' + elem.checklike + '"'
    + 'href="javascript:void(0)" ' + (elem.checklike == 1 ? 'title="Đã like"' : title = "Like") + ' data-id="' + elem.id + '" onclick="likeSong(this);" ></a>'
    + '<a class="decu" ' + (elem.nominations == 1 ? 'id="icon-active"' : '') + ' ' + (elem.nominations == 1 ? 'title="Đã đề cử"' : 'title="Đề cử"') + ' href="javascript:void(0)" onclick="Nominations_song(this)" data-id="' + elem.id + '" ></a>'
    <?php } else { ?>
    + '<a class="addplaylist" href="javascript:void(0)" title="Thêm vào" onclick="showlogin()"></a>'
    + '<a onclick="showlogin()" class="like" ' + (elem.checklike == 1 ? 'id="icon-active"' : '') + ' checklike="' + elem.checklike + '"'
    + 'href="javascript:void(0)" ' + (elem.checklike == 1 ? 'title="Đã like"' : title = "Like") + ' data-id="' + elem.id + '" ></a>'
    + '<a onclick="showlogin()" class="decu" ' + (elem.nominations == 1 ? 'id="icon-active"' : '') + ' ' + (elem.nominations == 1 ? 'title="Đã đề cử"' : 'title="Đề cử"') + ' href="javascript:void(0)" data-id="' + elem.id + '" ></a>'
    <?php } ?>
    + '<a class="taive" href="javascript:void(0)" data-name="' + elem.name + '" data-id="' + elem.id + '" data-link320="' + elem.media_link_320k + '" data-link128="' + elem.media_link_128k + '" data-link64="' + elem.media_link_64k + '" ' +
    'onclick="openFormDownloadOfPlaylist(this)" title="Tải về"></a>'
//                            + '<a class="share" href="javascript:void(0)" title="Chia sẻ" target="_blank"></a>'
+ '<a class="popup" href="' + elem.link + '" title="Nghe cửa sổ mới" target="_blank"></a>'
+ '</span>';


},
playItemCallback: function (item) {
    $.post("/incoming/getlyric", {id: item.id}, function (re) {
        var data = re.data;
        if (re.status == 200) {
            $('.blank_music').attr('href', data.link);
                            if (data.content != '') { //if lyrics not empty
                                //check lyric
                                $('.lyric').show();
                                $('#divLyric').html(data.content);
                                if (data.userinfo.is_role == 1) var color_lyricCreate = '#c73030';
                                else var color_lyricCreate = '#176093';
                                var html = '<h2 class="name_lyric"><b>Lời bài hát: ' + data.name + '</b></h2>' +
                                '<p class="name_post">Lời đăng bởi: <a rel="nofollow" style="color:' + color_lyricCreate + '" href="' + data.userinfo.link + '" title="' + data.userinfo.username + '">' + data.userinfo.username + '</a></p>';
                                $('.pd_name_lyric').html(html);
                                var heightlyric = $('#divLyric').height();
                                if (heightlyric < 255) $('#seeMoreLyric').hide();
                                else $('#seeMoreLyric').show();
                            } else {
                                $('.lyric').hide();
                            }
                            //generate html quality
                            var htmlQuality = '<div class="dropOut"><div class="triangle"></div>' +
                            '<ul>';
                            var insertMediaLink = function (media_link, type, label) {
                                return '<li><a onclick="changeQuality(this)" class="media_quality_select"'
                                + 'href="javascript:void(0)" data-media-src="' + media_link + '"'
                                + 'data-media-type="' + type + '"> ' + label + ' </a></li>';
                            }

                            if (data.media_link_320k != undefined)
                                htmlQuality += insertMediaLink(data.media_link_320k, '320', '320k');
                            if (data.media_link_128k != undefined)
                                htmlQuality += insertMediaLink(data.media_link_128k, '128', '128k');
                            if (data.media_link_64k != undefined)
                                htmlQuality += insertMediaLink(data.media_link_64k, '64', '64k');

                            htmlQuality += '</ul></div>';
                            $('.dropdownContain').html(htmlQuality);

                            var quality = Cookies.get('jPlayer-audio-quality');
                            if (typeof quality == 'string' && quality != 'undefined') {
                                if (typeof data['media_link_' + quality + 'k'] != 'undefined') {
                                    changeQuality(".media_quality_select[data-media-type='" + quality + "']");
                                }

                            }
                        } else {
                            alert(re.msg);
                        }
                    });
}
},
cssSelector: {
    videoPlay: ".jp-video-play",
    play: ".jp-play",
    pause: ".jp-pause",
    stop: ".jp-stop",
    seekBar: ".jp-seek-bar",
    playBar: ".jp-play-bar",
    mute: ".jp-mute",
    unmute: ".jp-unmute",
    volumeBar: ".jp-volume-bar",
    volumeBarValue: ".jp-volume-bar-value",
    volumeMax: ".jp-volume-max",
    playbackRateBar: ".jp-playback-rate-bar",
    playbackRateBarValue: ".jp-playback-rate-bar-value",
    currentTime: ".jp-current-time",
    duration: ".jp-duration",
    title: ".jp-title",
    fullScreen: ".jp-full-screen",
    restoreScreen: ".jp-restore-screen",
    repeat: ".jp-repeat",
    repeatOff: ".jp-repeat-off",
    gui: ".jp-gui",
    noSolution: ".jp-no-solution"
},
stateClass: {
    playing: "jp-state-playing",
    seeking: "jp-state-seeking",
    muted: "jp-state-muted",
    looped: "jp-state-looped",
    fullScreen: "jp-state-full-screen",
    noVolume: "jp-state-no-volume"
},
swfPath: "jplayer",
supplied: "oga, mp3",
wmode: "window",
useStateClassSkin: true,
autoBlur: false,
smoothPlayBar: true,
keyEnabled: true,
});
isPlaylistPage = true;
jPlayerPlaylistSetDefault(playlistPlayer);
});
    //]]>
</script>

    <div class="row">
        <div class="col-md-5 col-sm-12">
            <div class="play-list" style="width: 320px;">
                <div class="album" style="width: 100%;">
                    <div class="record rotate"></div>
                        <img class="cover" src="<?php echo $object->priavatar; ?>" title="<?php echo $object->name; ?>"
                                             alt="<?php echo $object->name; ?>">

                    <div class="glass"></div>
                </div>
            </div>
        </div>
        <div class="col-md-7 col-sm-12">
            <div class="info-song-top">
                <h2><?php echo $object->name; ?></h2>
            </div>
        </div>
    </div>
    
<div class="wolf-jplayer-playlist-container  wolf-jplayer-scrollbar">
    <div class="wolf-jplayer-playlist">

        <div id="jplayer_container" class="jplayer_container">
            <div id="jquery_jplayer" class="jp-jplayer">

            </div>
            <div id="jp_container" class="jp-audio">
                                    <!--<div class="ab-rotate rotate"></div>
                                    <div class="gl"></div>-->
                                    

                                    <div class="jp-type-playlist">
                                        <div class="jp-gui jp-interface">
                                            <ul class="jp-controls">
                                                <li><a href="javascript:void(0)" class="jp-previous" tabindex="1"></a>
                                                </li>
                                                <li><a href="javascript:void(0)" class="jp-play" tabindex="1"></a></li>
                                                <li><a href="javascript:void(0)" class="jp-pause" tabindex="1"
                                                 style="display: none;"></a></li>
                                                 <li><a href="javascript:void(0)" class="jp-next" tabindex="1"></a></li>
                                                 <li class="wolf-volume">
                                                    <a href="javascript:void(0)" class="jp-mute" tabindex="1"
                                                    title="mute"></a>
                                                    <a href="javascript:void(0)" class="jp-unmute" tabindex="1"
                                                    title="unmute"
                                                    style="display: none;"></a>
                                                </li>
                                                <li><a href="javascript:void(0)" class="jp-volume-max wolf-volume"
                                                 tabindex="1" title="max volume"></a></li>
                                             </ul>
                                             <div class="jp-progress">
                                                <div class="jp-seek-bar" style="width: 100%;">
                                                    <div class="jp-play-bar" style="width: 0%;"></div>
                                                </div>
                                            </div>
                                            <div class="jp-volume-bar wolf-volume" style="display: block;">
                                                <div class="jp-volume-bar-value" style="width: 80%;"></div>
                                            </div>
                                            <div class="jp-current-time">00:00</div>
                                            <div class="jp-duration">01:25</div>

                                            <ul class="jp-toggles">
                                                
                                                
                                                <li><a href="javascript:void(0)" class="jp-shuffle-off" tabindex="1"
                                                 title="shuffle off" style="display: none;"></a></li>
                                                 <li class="drop">
                                                    <a class="jp-click" href="javascript:void(0)"></a>

                                                    <div class="dropdownContain">

                                                    </div>

                                                </li>
                                                <li><a href="javascript:void(0)" class="jp-repeat" tabindex="1"
                                                 title="repeat"></a></li>
                                                 <li><a href="javascript:void(0)" class="jp-repeat-off" tabindex="1"
                                                     title="repeat off" style="display: none;"></a></li>
                                                 </ul>


                                             </div>

                                             <div class="jp-playlist">

                                                <div id="main-scrollbar">
                                                    <div class="nano">
                                                        <div class="content">
                                                            <ul>

                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="jp-no-solution" style="display: none;">
                                                <span>Update Required</span>
                                                To play the media you will need to either update your browser to a recent
                                                version or update your <a href="http://get.adobe.com/flashplayer/"
                                                target="_blank">Flash plugin</a>.
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


<script>
    //change quanlity
    function changeQuality(obj) {
        var player = $("#jquery_jplayer");
        var audioRrl = $(obj).attr("data-media-src");
        var currentTime = jplayerCurrentTime();
        var quality = $(obj).attr("data-media-type");
        //set active icon quanlity
        $('.media_quality_select').removeAttr('style');

        $(obj).attr('style', 'color: #B302CB');
        player.jPlayer("setMedia", {
            mp3: audioRrl
        });
        player.jPlayer("play", currentTime);
        Cookies.set('jPlayer-audio-quality', quality, {expires: 7});
    }
    function jplayerCurrentTime() {
        var currentTime = $(".jp-current-time").text();
        var elems = currentTime.split(":");
        return parseInt(elems[0]) * 60 + parseInt(elems[1]);
    }
</script>