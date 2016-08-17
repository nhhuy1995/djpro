    <link rel="stylesheet" href="/web/skins/jplayer.css"/>
    <script type="text/javascript" src="/web/js/jquery.jplayer.tth.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            var os = (function () {
                var ua = navigator.userAgent.toLowerCase();
                return {
                    isWin2K: /windows nt 5.0/.test(ua),
                    isXP: /windows nt 5.1/.test(ua),
                    isVista: /windows nt 6.0/.test(ua),
                    isWin7: /windows nt 6.1/.test(ua),
                    isWin8: /windows nt 6.2/.test(ua),
                    isWin81: /windows nt 6.3/.test(ua)
                };
            }());

            /*if(os.isXP) {
             var playerSolution = "flash, html";
             }
             else*/
            var playerSolution = "html, flash";

            var repeat = Cookies.get('jPlayer-audio-repeat');
            if (repeat == 'true')
                repeat = true;
            else
                repeat = false;

            $("#jquery_jplayer").jPlayer({
                ready: function () {
                    $(this).jPlayer("setMedia", {
                        title: "{{ object.name }}",
                        mp3: "{{ object.media_url }}",

                    }).jPlayer("play"); // Attempt to auto play the media
                },

                cssSelectorAncestor: "#jp_container",
                swfPath: "/web/playlist/jplayer/jquery.jplayer.swf",
                supplied: "mp3,oga,m4a",
                useStateClassSkin: true,
                autoBlur: false,
                loop: repeat,
                smoothPlayBar: true,
                keyEnabled: true,
                toggleDuration: true,
                wmode: "window",
                solution: playerSolution,
            });

            jQuery(".wolf-jp-popup").click(function () {
                Player = $(this).parent().prev();
                Player.jPlayer("stop");
                var url = jQuery(this).attr("href");
                var popupHeight = jQuery(this).parents(".wolf-jplayer-playlist-container").height();
                var popup = window.open(url, "null", "height=" + popupHeight + ",width=570, top=150, left=150");
                if (window.focus) {
                    popup.focus();
                }
                return false;
            });
            jPlayerSetDefault();
        });
    </script>

    <div class="row">
        <div class="col-md-5 col-sm-12">
            <div class="play-list" style="width: 320px;">
                <div class="album" style="width: 100%;">
                    <div class="record rotate"></div>
                        <img class="cover" src="{{ object.priavatar }}" title="{{ object.name }}"
                                             alt="{{ object.name }}">

                    <div class="glass"></div>
                </div>
            </div>
        </div>
        <div class="col-md-7 col-sm-12">
            <div class="info-song-top">
                <h2>{{ object.name }}</h2>
            </div>
        </div>
    </div>

    <!-- playlist code Html mới -->
    <div class="wolf-jplayer-playlist-container">
        <div class="wolf-jplayer-playlist">

            <div id="jplayer_container" class="jplayer_container">
                <div id="jquery_jplayer" class="jp-jplayer">

                </div>
                <div id="jp_container" class="jp-audio">
                    <!--<div class="ab-rotate rotate"></div>
                    <div class="gl"></div>-->
                    {#<a href="{{ object.link }}" class="wolf-jp-popup" title="Nghe cửa sổ mới"></a>#}

                    <div class="jp-type-playlist">
                        <div class="jp-gui jp-interface">
                            <ul class="jp-controls">
                                <!--<li><a href="javascript:;" class="jp-previous" tabindex="1"></a></li>-->
                                <li><a href="javascript:;" class="jp-play" tabindex="1"></a></li>
                                <li><a href="javascript:;" class="jp-pause" tabindex="1"
                                       style="display: none;"></a></li>
                                <!--<li><a href="javascript:;" class="jp-next" tabindex="1"></a></li>-->
                                <li class="wolf-volume">
                                    <a href="javascript:;" class="jp-mute" tabindex="1"
                                       title="mute"></a>
                                    <a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute"
                                       style="display: none;"></a>
                                </li>
                                <li><a href="javascript:;" class="jp-volume-max wolf-volume"
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
                                {#<li><a href="javascript:;" class="jp-shuffle" tabindex="1"
                                       title="shuffle"></a></li>#}
                                <li><a href="javascript:;" class="jp-shuffle-off" tabindex="1"
                                       title="shuffle off" style="display: none;"></a></li>
                                <li class="drop">
                                    <a class="jp-click" href="javascript:void(0)"></a>

                                    <div class="dropdownContain">
                                        <div class="dropOut">
                                            <div class="triangle"></div>
                                            <ul>
                                                {% if object.media_link_320k %}
                                                    <li><a class="media_quality_select"
                                                           href="javascript:;"
                                                           data-media-src="{{ object.media_link_320k }}"
                                                           data-media-type="320">
                                                            320K
                                                        </a></li>
                                                {% endif %}
                                                {% if object.media_link_128k %}
                                                    <li><a class="media_quality_select"
                                                           href="javascript:;"
                                                           data-media-src="{{ object.media_link_128k }}"
                                                           data-media-type="128">
                                                            128K
                                                        </a></li>
                                                {% endif %}
                                                {% if object.media_link_64k %}
                                                    <li><a class="media_quality_select" style="color: #B302CB"
                                                           href="javascript:;"
                                                           data-media-src="{{ object.media_link_64k }}"
                                                           data-media-type="64">
                                                            64K
                                                        </a></li>
                                                {% endif %}
                                            </ul>
                                        </div>
                                    </div>

                                </li>
                                <li><a href="javascript:;" class="jp-repeat" tabindex="1"
                                       title="repeat"></a></li>
                                <li><a href="javascript:;" class="jp-repeat-off" tabindex="1"
                                       title="repeat off" style="display: none;"></a></li>
                            </ul>


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
    <!--End-->
    <script type='text/javascript'>
        $(document).ready(function () {

            $(".media_quality_select").click(function () {
                var player = $("#jquery_jplayer");
                var audioRrl = $(this).attr("data-media-src");
                var currentTime = jplayerCurrentTime();
                var quality = $(this).attr("data-media-type");
                //set active icon quanlity
                $('.media_quality_select').removeAttr('style');
                $(this).attr('style', 'color: #B302CB');
                player.jPlayer("setMedia", {
                    mp3: audioRrl
                });
                player.jPlayer("play", currentTime);
                Cookies.set('jPlayer-audio-quality', quality, {expires: 7});
            });
        });

        function jplayerCurrentTime() {
            var currentTime = $(".jp-current-time").text();
            var elems = currentTime.split(":");
            return parseInt(elems[0]) * 60 + parseInt(elems[1]);
        }

    </script>