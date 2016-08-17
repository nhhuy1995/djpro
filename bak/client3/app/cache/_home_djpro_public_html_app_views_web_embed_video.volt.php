<link href="/web/skins/video-js.css" rel="stylesheet">
<!-- <script src="/web/js/video.js"></script> -->
<script src="http://vjs.zencdn.net/5.8.8/video.js"></script>
<script src="/web/js/videojs-resolution-switcher.js"></script>
<!-- Start js-scroller-->
<script type="text/javascript" src="/web/js/jquery.nanoscroller.js"></script>
<script type="text/javascript">
    $(function () {

        $('.nano').nanoScroller({
            preventPageScrolling: true
        });

    });
</script>

<?php if ($checklink) { ?>
    <video id="videodj" poster="<?php echo $object->priavatar; ?>" class="video-js vjs-default-skin"
           width="100%" height="472" loop
           controls preload="auto" autoplay
           data-setup='{"techOrder": ["youtube"],"src": "<?php echo $object->mediaurl; ?>" }'>
        <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to
            a
            web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports
                HTML5 video</a></p>
    </video>
<?php } else { ?>
    <video id="videodj" poster="<?php echo $object->priavatar; ?>"
           class="video-js vjs-default-skin vjs-resolution-button-label vjs-resolution-button"
           height="472" loop
           controls preload="auto" autoplay
           data-setup='{}'
    >
        <?php if ($object->link_video_360) { ?>
            <?php $media_url = $object->link_video_360; ?>
        <?php } else { ?>
            <?php $media_url = $object->direct_media_url; ?>
        <?php } ?>
        <source src="<?php echo $media_url; ?>" type='video/mp4' label="Default"/>
        <?php if ($object->link_video_1080) { ?>
            <source src="<?php echo $object->link_video_1080; ?>" type='video/mp4' label='1080p'/>
        <?php } ?>
        <?php if ($object->link_video_720) { ?>
            <source src="<?php echo $object->link_video_720; ?>" type='video/mp4' label='720p'/>
        <?php } ?>
        <?php if ($object->link_video_480) { ?>
            <source src="<?php echo $object->link_video_480; ?>" type='video/mp4' label='480p'/>
        <?php } ?>
        <?php if ($object->link_video_360) { ?>
            <source src="<?php echo $object->link_video_360; ?>" type='video/mp4' label='360p'/>
        <?php } ?>

        <?php if ($object->link_video_240) { ?>
            <source src="<?php echo $object->link_video_240; ?>" type='video/mp4' label='240p'/>
        <?php } ?>

        <?php if ($object->link_video_144) { ?>
            <source src="<?php echo $object->link_video_144; ?>" type='video/mp4' label='144p'/>
        <?php } ?>

        <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to
            a
            web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports
                HTML5 video</a></p>
    </video>
    <script>
        /*videojs('videodj', {
         plugins: {
         resolutions: true
         }
         });*/
        videojs('videodj').videoJsResolutionSwitcher();
    </script>
<?php } ?>