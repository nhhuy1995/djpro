$(document).ready(function(){
    $(".supercom-form").validationEngine({
        inlineValidation: false,
        success :  false,
        failure : function() { callFailFunction()  }
    });

    var nameText=$('#name-text');
    var linkText=$('#link-text');
    var infoText=$('#info-text');
    $('#btnReset').click(function(){
        $('#acceptPosting').show();
    });
    $('#music-choose').click(function(){
        nameText.html("Tên bài hát:");
        linkText.html("Link nhạc:");
        infoText.html("Thông tin bài hát, Track List:");
        $('#articleType').val('music');
    });
    $('#video-choose').click(function(){
        nameText.html("Tên video:");
        linkText.html("Link video:");
        infoText.html("Thông tin video:");
        $('#articleType').val('video');
    });

    $('#articleLink').blur(function(){
        var aLink=$('#articleLink').val();
        if(aLink.length>5){
            var db = {act: 'existLink', link: aLink};
            $.post('./sercurity.se', db, function (re) {
                var data = eval(re);
                if(data.status==0) {
                    alert(data.message);
                    $('#acceptPosting').hide();
                }
                else $('#acceptPosting').show();
            });
        }
    });

});