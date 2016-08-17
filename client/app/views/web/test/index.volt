<video id='video' class="video-js vjs-default-skin"></video>
<script src="/web/js/video.js"></script>
<script src="/web/js/videojs-resolution-switcher.js"></script>
<script>
    videojs('video', {
        controls: true,
        plugins: {
            videoJsResolutionSwitcher: {
                default: 'high',
                dynamicLabel: true
            }
        }
    }, function(){

        // Add dynamically sources via updateSrc method
        player.updateSrc([
            {
                src: 'http://media.xiph.org/mango/tears_of_steel_1080p.webm',
                type: 'video/webm',
                label: '360'
            },
            {
                src: 'http://mirrorblender.top-ix.org/movies/sintel-1024-surround.mp4',
                type: 'video/mp4',
                label: '720'
            }
        ])

        player.on('resolutionchange', function(){
            console.info('Source changed to %s', player.src())
        })

    })
</script>