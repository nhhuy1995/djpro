/*######################################################################## Start Article JS ##################################################################################################################################################################*/
var article =
{
    like:function(atid)
    {
        $.post('./process.tga',{act:'a1',val:atid},function(re){
            var count=parseInt($('a#like-count').html());
            var data = eval(re);
            if(data.status==10) $('a#like-count').html(count+1);
            alert(data.message);
        });
        return false;
    },
    dislike:function(atid)
    {
        $.post('./process.tga',{act:'a2',val:atid},function(re){
            var count=parseInt($('a#dislike-count').html());
            var data = eval(re);
            if(data.status==10) $('a#dislike-count').html(count+1);
            alert(data.message);
        });
        return false;
    },
    nomination:function(atid)
    {
        var confirmNomi=confirm('HÃ£y giÃºp chÃºng tÃ´i Ä‘á» cá»­ nhá»¯ng bÃ i hÃ¡t thá»±c sá»± cháº¥t lÆ°á»£ng vÃ  cÃ´ng báº±ng. Táº¥t cáº£ cÃ¡c trÆ°á»ng há»£p kick top Ä‘á» cá»­ sáº½ bá»‹ ban nick vÄ©nh viá»…n (ká»ƒ cáº£ kick láº§n Ä‘áº§u tiÃªn)');
        if(confirmNomi==false) return false;
        else{
            $('#loading').show();
            $.post('./process.tga',{act:'a3',val:atid},function(re){
                var data = eval(re);
                $('#loading').hide();
                alert(data.message);
            });
            return false;
        }
    },
    getcomment:function(atid,pid,objhtml,type)
    {
        $('#loading').show();
        if(objhtml==null||objhtml==undefined)
        {
            var db =  {act:'a4',val:atid,pid:pid,type:type};
        }
        else
        {
            var spage = $(objhtml).attr('spage');
            var db =  {act:'a4',val:atid,pid:pid,type:type,spage:spage};
            ++spage;
            $(objhtml).attr('spage',spage);
        }
        $.post('./process.tga',db,function(re){
            var data = eval(re);
            if(data.status==10 )
            {
                if(pid<=0) $('#cmitem').append(data.data);
                else {
                    $('#reply-cmt-'+pid).append(data.data);
                    $('#view-more-child-'+pid).hide();
                    $('#show-hide-child-'+pid).show();
                }
                $('#loading').hide();
            }
            else if(data.status==15 ) { $(objhtml).hide(); $('#loading').hide(); }
        });
        return false;
    },
    showrpform: function (cm_id){
        $('#reply-comment-'+cm_id).show();
    },
    hiderpform: function (cm_id){
        $('#reply-comment-'+cm_id).hide();
    },
    showhidecm: function (cm_id){
        $('#reply-cmt-'+cm_id).toggle();
    },
    replycm:function(atid,pid,txtvalue,objhtml,type)
    {
        $('#loading').show();
        var content = $('#'+txtvalue).val();
        var db = {act:'a5',atid:atid,pid:pid,content:content,type:type};
        $.post('./process.tga',db,function(re){
            var data = eval(re);
            if(data.status==10)
            {
                if(objhtml==null|| objhtml == undefined) $('#cmitem').prepend(data.data);
                else $('#'+objhtml).prepend(data.data);
                $('.cmt-box .textarea').val("");
                $('#loading').hide();
            }
            else
            {
                alert(data.message);
                $('#loading').hide();
            }

        });
    },
    deletecm:function(cmid,idhtml)
    {
        var confirmDel=confirm('Báº¡n cháº¯c cháº¯n muá»‘n xÃ³a comment nÃ y ?');
        if(confirmDel==false) return false;
        var db = {act:'a6',cm:cmid};
        $.post('./process.tga',db,function(re){
            var data = eval(re);
            if(data.status==10)
            {
                $('#'+idhtml).remove();
            }
            else
            {
                alert('KhÃ´ng thá»ƒ gá»­i cáº£m nháº­n. LÃ½ do : '+data.message);
            }

        });
    },
    loadWhoLike:function(atid)
    {
        $('#loading').show();
        var db = {act: 'a14', atid: atid};
        $.post('./process.tga', db, function (re) {
            var data = eval(re);
            loadModa1('Danh sÃ¡ch nhá»¯ng thÃ nh viÃªn thÃ­ch bÃ i nÃ y',data.data);
            $('#loading').hide();
        });
    },
    loadWhoDisLike:function(atid)
    {
        $('#loading').show();
        var db = {act: 'a15', atid: atid};
        $.post('./process.tga', db, function (re) {
            var data = eval(re);
            loadModa1('Danh sÃ¡ch nhá»¯ng thÃ nh viÃªn khÃ´ng thÃ­ch bÃ i nÃ y',data.data);
            $('#loading').hide();
        });
    },
    superComFollower:function(uid)
    {
        $('#loading').show();
        var db = {act: 'a16', uid: uid};
        $.post('./process.tga', db, function (re) {
            var data = eval(re);
            notifiBL(data.message,data.type);
            if(data.status==1) $('#follow-btn').html(data.data);
            $('#loading').hide();
        });
    },
    superComFollowing:function(uid)
    {
        $('#loading').show();
        var db = {act: 'a17', uid: uid};
        $.post('./process.tga', db, function (re) {
            var data = eval(re);
            notifiBL(data.message,data.type);
            if(data.status==1) $('#follow-btn').html(data.data);
            $('#loading').hide();
        });
    },
}

$(document).ready(function(){
    if($('#nomination-article').length>0){
        var sec = 60
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
/*######################################################################## End Article JS ##################################################################################################################################################################*/