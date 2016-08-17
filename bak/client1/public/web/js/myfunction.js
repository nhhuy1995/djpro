/**
 * Created by HoangHuy on 10/29/2015.
 */
var p_children = 2;
var vitri = 1;
var index_parent = 1;
function htmlComment(data, page, atid) {
    var html = '';
    jQuery.each(data, function (index, item) {
        html = '<div class="comment_ask "><a href="' + item.link + '" title="' + item.username + '"><img class="imgU" src="' + item.priavatar + '"><strong>' + item.username + '</strong></a>' +
            '<div class="infocom_ask">' + item.content + '</div>' +
            '<div data-cl="0" class="relate_infocom">';
        if (item.is_comment_of_my == 0) {
            html += '<span class="reply" onclick="Show_replyComment(' + index_parent + ')">Trả lời </span>  <b class="dot">●</b>';
            html += '<span class="numlike" > <i class="icon-like"></i> <span class="like" onclick="likeComment(this)" checklike="' + item.checklike + '" data-id="' + atid + '" data-idcm="' + item._id + '" data-stt="' + index_parent + '" data-type="comment"> Thích ';
            html += '<i id="icon-likecomment-' + index_parent + '" ' + (item.checklike > 0 ? "style='color: blue;'" : "style='color: #999999;'") + ' class="fa fa-thumbs-up"></i> ' + ( item.like > 0 ? '(' + item.like + ')' : '') + '</span>';
            html += '</span>';
        }
        ;
        html += '<span class="date1"><b class="dot">●</b> ' + timeSince(item.datecreate) + '</span>' +
            '</div>' +
            '</div>' +
                // sub comment
            '<div class="sub_comment" id="rep_comment_' + index_parent + '" style="display: none;">' +
            '<div style="display: block;" class="block_input_comment width_common" id="comment_reply_wrapper">' +
            '<div class="input_comment">' +
            '<form id="comment_reply_form">' +
            '<textarea class="h100 left block_input" onblur="if (this.value==\'\') this.value = this.defaultValue" onfocus="if (this.value==this.defaultValue) this.value = \'\' " ' +
            '" value="Ý kiến của bạn" id="txtReComment_' + index_parent + '" rows="" cols="" rel="13936932" toogle="13936932" reply_to="0">Ý kiến của bạn</textarea>' +
            '<div class="width_common block_relative">' +
            '<div class="right">' +
            '<input onclick="replyComment(this,' + index_parent + ')" data-id="' + atid + '" data-parentid="' + item._id + '" data-name=' + item.username + ' type="button" id="comment_reply_button" class="btn_send_comment" value="Gửi">' +
            '</div>' +
            '<div style="display: none;" class="left counter_world">' +
            '<strong>20</strong>/1000' +
            '</div>' +
            '<div class="clear">&nbsp;</div>' +
            '</div>' +
            '<input type="hidden" value="1" id="btnReply"></form>' +
            '</div>' +
            '</div>' +
            '</div>';
        if (item.comment_children != null) {
            html += '<div class="comment_reply" id="comment_reply_' + index_parent + '">' +
                '<i class="arrow_box"></i>';
            html += html_replycomment(item.comment_children, (index + 1), item.username, atid, item._id, index_parent);
            html += '</div>';
            if (p_children <= item.total_page_repcomment) {
                html += '<div class="viewmore_children" id="viewmore_' + item._id + '">' +
                    '<div class="item_viewmore_children"><a href="javascript:void(0)" data-name=' + item.username + ' page="2" onclick="load_replycomment(this,' + atid + ',' + item._id + ',' + index + ',' + item.total_page_repcomment + ',' + index_parent + ');"> Xem tất cả ' + item.total_repcomment + ' trả lời</a></div>' +
                    '</div>';
            }

        } else {
            html += '<div class="comment_reply" id="comment_reply_' + index_parent + '" style="display:none;">';
            html += '</div>';
        }
        $('.infocomment').append(html);
        index_parent++;
    });
}

function load_replycomment(obj, atid, parentid, index, total_page, index_parent) {

    var index = index + 1;
    var name_children = $(obj).data('name');
    var page = $(obj).attr('page');
    $.get("/incoming/loadreplycomment", {atid: atid, parentid: parentid, p: page}, function (re) {
        var data = re.data;
        var html = '';
        if (data != null) {
            html = html_replycomment(data, index, name_children, atid, parentid, index_parent);
            $('#comment_reply_' + index_parent).append(html);
            page = parseInt(page) + 1;
            //p_children++;
            $(obj).attr('page', page);
        }
        if ((page - 1) >= total_page)  $('#viewmore_' + parentid).hide();
    });
}
function html_replycomment(data, index, name_children, atid, parentid, index_parent) {
    var html = '';
    jQuery.each(data, function (keychild, cmchild) {
        html += '<div class="comment_ask"><a href="' + cmchild.link + '" title="' + cmchild.username + '"><img src="' + cmchild.priavatar + '" class="imgU"/><strong>' + cmchild.username + '</strong></a>' +
            '<div class="infocom_ask">' +
            '<div class="conticon">';
        if (cmchild.parent_name != '') {
            html += '<span class="reply_name">@' + cmchild.parent_name + '</span>: ' + cmchild.content + '';
        }
        else {
            html += '<div class="content">' + cmchild.content + '</div>';
        }
        html += '<div class="relate_infocom">';
        if (cmchild.is_comment_of_my == 0) {
            html += '<span class="numlike"> <i class="icon-like"></i>';
            html += '<span class="btnreply" onclick="Show_replyComment_children(' + vitri + ')">Trả lời </span><b class="dot">●</b>';
            html += '<span class="like" onclick="likeComment(this)" checklike="' + cmchild.checklike + '" data-id="' + atid + '" data-stt="' + (vitri) + (keychild + 1000) + '" data-idcm="' + cmchild._id + '" data-type="comment"> Thích ';
            html += '<i id="icon-likecomment-' + (vitri) + (keychild + 1000) + '" ' + (cmchild.checklike > 0 ? "style='color: blue;'" : "style='color: #999999;'") + ' class="fa fa-thumbs-up"></i>' + ( cmchild.like > 0 ? '(' + cmchild.like + ')' : '') + '</span>';
            html += '</span>';
        }
        html += '<span class="date1"><b class="dot">●</b> ' + timeSince(cmchild.datecreate) + '</span>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>' +
                // sub comment
            '<div class="sub_comment" id="rep_comment_children_' + vitri + '" style="display:none">' +
            '<div style="display: block;" class="block_input_comment width_common" id="comment_reply_wrapper">' +
            '<div class="input_comment">' +
            '<form id="comment_reply_form">' +
            '<textarea class="h100 left block_input" onblur="if (this.value==\'\') this.value = this.defaultValue" onfocus="if (this.value==this.defaultValue) this.value = \'\' " ' +
            '" value="Ý kiến của bạn" id="txtReComment_children_' + vitri + '" rows="" cols="" rel="13936932" toogle="13936932" reply_to="0">Ý kiến của bạn</textarea>' +
            '<div class="width_common block_relative">' +
            '<div class="right">' +
            '<input onclick="replyCommentChildren(this,' + vitri + ',' + index + ',' + index_parent + ')" data-id="' + atid + '" data-parentid="' + parentid + '" data-uid="' + cmchild.user_id + '" data-name=' + cmchild.username + ' type="button" id="comment_reply_button" class="btn_send_comment" value="Gửi">' +
            '</div>' +
            '<div style="display: none;" class="left counter_world">' +
            '<strong>20</strong>/1000' +
            '</div>' +
            '<div class="clear">&nbsp;</div>' +
            '</div>' +
            '<input type="hidden" value="1" id="btnReply"></form>' +
            '</div>' +
            '</div>' +
            '</div>'; //end sub comment
        vitri++;
    });

    return html;
}
//send comment
function sendComment(obj) {
    var d = new Date();
    var time = d.getTime();
    var content = $('#content_comment').val();
    var atid = $(obj).data('id');
    var session_username = $('#session_username').val();
    var type = $('#type').val();
    $.post("/incoming/sendcomment", {content: content, atid: atid,type:type}, function (re) {
        var data = re.data;
        var html = '';
        if (re.status == 200) {
            $('#content_comment').val('');//set form comment = empty
            alert('Gửi bình luận thành công!');
            html += '<div class="comment_ask">' +
                '<a href="' + re.link + '" title="' + session_username + '"><img class="imgU" src="' + re.priavatar + '"><strong>' + session_username + '</strong> </a>' +
                '<div class="infocom_ask">' + data.content + '</div>' +
                '<div class="relate_infocom"><span class"date"="">' +
                '<b class="dot">●</b> ' + timeSince(time) + '</span>' +
                '</div>' +
                '</div>';
            $('.infocomment').prepend(html);
        }
        else {
            alert(re.mss);
        }
    });
}
function replyComment(obj, stt) {
    var d = new Date();
    var time = d.getTime();
    var content = $('#txtReComment_' + stt).val();
    var session_username = $('#session_username').val();
    var atid = $(obj).data('id');
    var parentid = $(obj).data('parentid');
    var name_children = $(obj).data('name');
    var type = $('#type').val();
    $.post("/incoming/replycomment", {parentid: parentid, content: content, atid: atid,type:type}, function (re) {
        var data = re.data;
        var html = '';
        if (re.status == 200) {
            alert('Gửi bình luận thành công!');
            html = '<div class="comment_ask">' +
                '<a href="' + re.link + '" title="' + session_username + '"><img class="imgU" src="' + re.priavatar + '"><strong>' + session_username + '</strong></a>' +
                '<div class="infocom_ask"> <div class="conticon"> <span class="reply_name"></span>' + data.content + '' +
                '<div class="relate_infocom">' +
                '<span class="date1"><b class="dot">●</b>' + timeSince(time) + '</span>' +
                '</div></div></div></div>';
            $('#comment_reply_' + stt).prepend(html).show();
            $('#rep_comment_' + stt).css('display', 'none');
        }
        else {
            alert(re.mss);
        }
    });
}
function replyCommentChildren(obj, stt, index, index_parent) {
    var d = new Date();
    var time = d.getTime();
    var content = $('#txtReComment_children_' + stt).val();
    var session_username = $('#session_username').val();
    var atid = $(obj).data('id');
    var parentid = $(obj).data('parentid');
    var uid = $(obj).data('uid');
    var name_children = $(obj).data('name');
    $.post("/incoming/replycomment", {parentid: parentid, uid: uid, content: content, atid: atid}, function (re) {
        var data = re.data;
        var html = '';
        if (re.status == 200) {
            alert('Gửi bình luận thành công!');
            html = '<div class="comment_ask">' +
                '<a href="' + re.link + '" title="' + session_username + '"><img class="imgU" src="' + re.priavatar + '"><strong>' + session_username + '</strong></a>' +
                '<div class="infocom_ask"> <div class="conticon"> <span class="reply_name">@' + name_children + '</span>: ' + data.content + '' +
                '<div class="relate_infocom">' +
                '<span class="date1"><b class="dot">●</b>' + timeSince(time) + '</span>' +
                '</div></div></div></div>';
            $('#comment_reply_' + index_parent).append(html);
            $('#rep_comment_children_' + stt).css('display', 'none');
        }
        else {
            alert(re.mss);
        }
    });
}

function Show_replyComment(stt) {
    $('#rep_comment_' + stt).show();
}
function Show_replyComment_children(stt) {
    $('#rep_comment_children_' + stt).show();
}
function likeComment(obj) {
    var checklike = $(obj).attr('checklike');
    var atid = $(obj).data('id');
    var idcm = $(obj).data('idcm');
    var key = $(obj).data('stt');
    var type = $('#type').val();
    $.get("/incoming/likecomment", {idcm: idcm, atid: atid, checklike: checklike, type: type}, function (re) {
        var like = re.like;
        if (re.status == 200) {
            if (checklike == 0) {
                $(obj).attr('checklike', 1);
                //$('#icon-likecomment-' + key).css('color', 'blue');
                $(obj).html('Thích <i class="fa fa-thumbs-up" style="color: blue;" id="icon-likecomment-' + key + '"></i>(' + like + ')');
            }
            else if (checklike == 1) {
                $(obj).attr('checklike', 0);
                //$('#icon-likecomment-' + key).css('color', '#999999');
                if (like == 0) $(obj).html('Thích <i class="fa fa-thumbs-up" style="color: #999999;" id="icon-likecomment-' + key + '"></i>');
                else $(obj).html('Thích <i class="fa fa-thumbs-up" style="color: #999999;" id="icon-likecomment-' + key + '"></i>(' + like + ')');
            }
        }
        else {
            alert(re.mss);
        }
    });
}
function timeSince(ts) {
    now = new Date();
    ts = new Date(ts * 1000);
    var delta = now.getTime() - ts.getTime();

    delta = delta / 1000; //us to s

    var ps, pm, ph, pd, min, hou, sec, days;

    if (delta <= 59) {
        ps = (delta > 1) ? "s" : "";
        //return Math.ceil(delta) +" giây"
        return "vài giây trước";
    }

    if (delta >= 60 && delta <= 3599) {
        min = Math.floor(delta / 60);
        sec = delta - (min * 60);
        pm = (min > 1) ? "s" : "";
        ps = (sec > 1) ? "s" : "";
        //return min+" phÃºt "+pm+" "+sec+" giÃ¢y"+ps;
        return min + " phút trước";
    }

    if (delta >= 3600 && delta <= 86399) {
        hou = Math.floor(delta / 3600);
        min = Math.floor((delta - (hou * 3600)) / 60);
        ph = (hou > 1) ? "s" : "";
        pm = (min > 1) ? "s" : "";
        return hou + " giờ trước";
    }

    if (delta >= 86400) {
        days = Math.floor(delta / 86400);
        hou = Math.floor((delta - (days * 86400)) / 60 / 60);
        pd = (days > 1) ? "s" : "";
        ph = (hou > 1) ? "s" : "";
        return days + " ngày trước";
    }

}
// like and dislike article and nominatios
function sendfeedback(obj) {
    var form = $('#form_feedback');
    var atid = $(obj).data('id');
    var type = $(obj).data('type');
    var checkedValue = form.find("input[name='feedback']:checked").val();
    $.post("/incoming/sendfeedback", {type: type, content: checkedValue, atid: atid}, function (re) {
        alert(re.msg);
    });
}
function likeArticle(obj) {
    var checklike = $(obj).attr('checklike');
    var atid = $(obj).data('id');
    var type = $('#type').val();

    $.get("/incoming/likearticle", {atid: atid, checklike: checklike, type: type}, function (re) {
        if (re.status == 200) {
            if (type == 'news') $('.boutlike').html('<i class="fa fa-thumbs-up" id="icon-like"></i> ' + re.boutlike + '');
            else $('.boutlike').html('<i class="fa fa-thumbs-up"></i> Thích: ' + re.boutlike + '');
            if (checklike == 0) {
                $(obj).attr('checklike', 1);
                $('#icon-like').css('color', 'blue');
            }
            else if (checklike == 1) {
                $(obj).attr('checklike', 0);
                $('#icon-like').css('color', '#c73030');
            }
        }
        else {
            alert(re.mss);
        }
    });
}

function dislikeArticle(obj) {
    var type = $('#type').val();
    var checklike = $(obj).attr('checklike');
    var atid = $(obj).data('id');
    $.get("/incoming/dislikearticle", {atid: atid, checklike: checklike, type: type}, function (re) {
        if (re.status == 200) {
            if (type == 'news') $('.boutdislike').html('<i class="fa fa-thumbs-down" id="icon-like"></i> ' + re.boutdislike + '');
            else $('.boutdislike').html('<i class="fa fa-thumbs-down"></i> Không thích: ' + re.boutdislike + '');

            if (checklike == 0) {
                $(obj).attr('checklike', 1);
                $('#icon-dislike').css('color', 'blue');
            }
            else if (checklike == 1) {
                $(obj).attr('checklike', 0);
                $('#icon-dislike').css('color', '#c73030');
            }

        }
        else {
            alert(re.mss);
        }
    });
}
function Nominations(atid) {
    var type = $('#type').val();
    $.post("/incoming/nominations", {atid: atid, type: type}, function (re) {
        if (re.status == 200) {
            $('#icon-nominations').css('color', 'blue');
        }
        else {
            alert(re.mss);
        }
    });
}
// end like and dislike article
function downloadArticle(obj) {
    var id = $(obj).data('id');
    var url = 'download.html?id=' + id;
    window.open(url, '_blank');
}