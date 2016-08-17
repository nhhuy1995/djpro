/*       Update time hoạt động gần nhất cho user         */
$(document).ready(function () {
    var currentdate = new Date();
    $.post('/incoming/updatetimeactivity', {time: currentdate}, function (re) {

    });
});
/*       Update time hoạt động gần nhất sau 30 phút         */
var timecall = 1800000;
setInterval(function () {
    var currentdate = new Date();
    $.post('/incoming/updatetimeactivity', {time: currentdate}, function (re) {
    });
}, timecall);


function searchsubmit() {
    $('#frmsearch').submit();
}
/*function search() {
 window.location.href = '/tim-kiem.html?q=' + $("#KeyName").val();
 }*/

$(function () {
    $("#KeyName").keypress(function (e) {
        if (e.which === 13) {
            search();
        }
    });
})
function seeMoreLyric(obj) {
    $('#divLyric').attr('style', '');
    $(obj).hide();
    $('#hideMoreLyric').attr('style', 'display:block;');
}
function hideMoreLyric(obj) {
    $('#divLyric').attr('style', 'max-height: 255px;overflow: hidden;height: auto');
    $('#seeMoreLyric').attr('style', 'display:block;');
    $(obj).hide();
}
$(document).click(function (e) {
    // -------------------------- SEARCH   -------------------------------
    // Đối tượng container chứa popup
    var container = $(".results ");

    // Nếu click bên ngoài đối tượng container thì ẩn nó đi
    if (!container.is(e.target) && container.has(e.target).length === 0) {
        container.hide();
    }
});
var t = 400;
var thread;
//form search
function searchsugget(obj) {
    clearTimeout(thread);
    thread = setTimeout(function () {
        var q = $(obj).val();
        $.get("/incoming/search", {q: q}, function (re) {
            var data = re.data;
            var html = '';
            html = '<ul class="results auto-complete-list" style="display: block;">' +
                '<div style="height:400px">' +
                '<div class="nano has-scrollbar"> ' +
                '<div class="content" tabindex="0" style="right: -17px;">' +
                    //'<div class="content" tabindex="0">' +
                '<li id="dmmt-title">Tìm kiếm với "' + re.q + '"</li>';
            if (data['audio'] != null || data['album'] != null || data['video'] != null) {
                html += '<li id="search-item" class="auto-complete-list-rollover">';
                if (data['audio'] != null) {
                    html += '<h3>Bài hát</h3>';
                    html += '<ul id="resultTags">';
                    jQuery.each(data['audio'], function (key, item) {
                        html += '<li class="dmmt-autocomplete-item" id="css-build"><a href="' + item.link + '"><strong>' + item.name + '</strong> </a>';
                        /*var listartist = item.listartist;
                         if (listartist != undefined) {
                         jQuery.each(listartist, function (keychild, itemchild) {
                         html += '<a class="dj_name_casi" href="' + itemchild.link + '">' + itemchild.username + '</a> ';
                         if((keychild+1) != listartist.length){
                         html+='<span>ft</span>';
                         }
                         });
                         }*/
                        html += '</li>';
                    });
                    html += '</ul>';
                }
                if (data['artist'] != null) {
                    html += '<br><h3>Nghệ sỹ</h3>';
                    html += '<ul>';
                    jQuery.each(data['artist'], function (key, item) {
                        html += '<li class="dmmt-autocomplete-item" id="css-build"><a href="' + item.link + '"><img src="' + item.priavatar + '">' + item.username + '</a></li> ';
                    });
                    html += '</ul>';
                }
                if (data['album'] != null) {
                    html += '<h3>Album</h3>';
                    html += '<ul>';
                    jQuery.each(data['album'], function (key, item) {
                        html += '<li class="dmmt-autocomplete-item" id="css-build"><a href="' + item.link + '"><img src="' + item.priavatar + '">' + item.name + '</a></li>';
                    });
                    html += '</ul>';
                }
                if (data['playlist'] != null) {
                    html += '<h3>Playlist</h3>';
                    html += '<ul>';
                    jQuery.each(data['playlist'], function (key, item) {
                        html += '<li class="dmmt-autocomplete-item" id="css-build"><a href="' + item.link + '"><img src="' + item.priavatar + '">' + item.name + '</a></li>';
                    });
                    html += '</ul>';
                }
                if (data['topic'] != null) {
                    html += '<h3>Chủ đề</h3>';
                    html += '<ul>';
                    jQuery.each(data['topic'], function (key, item) {
                        html += '<li class="dmmt-autocomplete-item" id="css-build"><a href="' + item.link + '"><img src="' + item.priavatar + '">' + item.name + '</a></li>';
                    });
                    html += '</ul>';
                }
                if (data['video'] != null) {
                    html += '<br><h3>Video</h3>';
                    html += '<ul>';
                    jQuery.each(data['video'], function (key, item) {
                        html += '<li class="dmmt-autocomplete-item" id="css-build"><a href="' + item.link + '"><img src="' + item.priavatar + '">' + item.name + '</a></li> ';
                    });
                    html += '</ul>';
                }

            }
            html += '</li>' +
                '</div>' +
                    <!-- playlist nhạc hiển thị -->
                '<div class="pane" style="display: none;"><div class="slider" style="height: 20px; top: 0px;"></div></div>' +
                '</div>' +
                '</div>' +
                '</ul>';
            $('#suggession_seach').html(html);
        });
    }, t)
}
//end form search

/*                   check from register               */

function checkUsername_register(obj) {
    clearTimeout(thread);
    thread = setTimeout(function () {
        var user = $(obj).val();
        $.get("/incoming/checkusername", {username: user}, function (re) {
            if (re.status == 300) {
                $('#error_usernameregister').show();
                $('#error_usernameregister').html(re.msg);
                $(obj).css('border', '1px solid red');
            } else {
                $('#error_usernameregister').hide();
                $(obj).removeAttr('style');
            }
        });
    }, t)
}
function checkEmail_register(obj) {
    var kq = 0;
    clearTimeout(thread);
    thread = setTimeout(function () {
        var email = $(obj).val();
        $.get("/incoming/checkemail", {email: email}, function (re) {
            if (re.status == 300) {
                $('#error_emailregister').show();
                $('#error_emailregister').html(re.msg);
                $(obj).css('border', '1px solid red');
            } else {
                $('#error_emailregister').hide();
                $(obj).removeAttr('style');
                kq = 1;
            }
        });
    }, t)
    return kq;
}
function resetText_register() {
    $('.msg_register').remove();
    $('#usernameregister').removeAttr('style');
    $('#error_usernameregister').hide();
    $('#emailregister').removeAttr('style');
    $('#error_emailregister').hide();
    $('#password').removeAttr('style');
    $('#error_password').hide();
    $('#repassword').removeAttr('style');
    $('#error_repassword').hide();
}
function checkPassword_register(obj) {
    var kq = 0;
    clearTimeout(thread);
    thread = setTimeout(function () {
        var password = $(obj).val();
        if (password.length < 6) {
            $('#error_password').show();
            $('#error_password').html('Mật khẩu phải từ 6 kí tự trở lên!');
            $(obj).css('border', '1px solid red');
        } else {
            $('#error_password').hide();
            $(obj).removeAttr('style');
            kq = 1;
        }
    }, t)
    return kq;
}
function checkType_formUpload(obj) {
    var type = $('#type_postmusic option:selected').val();
    var category = $('#category_postmusic option:selected').val();
    $('.category_type_video').hide();
    $('.category_type_audio').hide();
    $('.category_type_' + type).show();
    $.post("/incoming/checkcategory", {category: category, type: type}, function (re) {
        if (re.status == 300) {
            $('.msg_postmusic').attr('style', 'color: red;font-weight: bold;text-align: center;');
            $('#type_postmusic').attr('style', 'border:1px solid red');
            $('#category_postmusic').attr('style', 'border:1px solid red');
            $('.msg_postmusic').html(re.msg);
        } else {
            $('.msg_postmusic').html('');
            $('#type_postmusic').removeAttr('style');
            $('#category_postmusic').removeAttr('style');
        }
    });
}
function checkType_formRequire(obj) {
    var type = $('#type_requiremusic option:selected').val();
    var category = $('#category_requiremusic option:selected').val();
    $('.require_category_type_video').hide();
    $('.require_category_type_audio').hide();
    $('.require_category_type_' + type).show();
    $.post("/incoming/checkcategory", {category: category, type: type}, function (re) {
        if (re.status == 300) {
            $('.msg_requiremusic').attr('style', 'color: red;font-weight: bold;text-align: center;');
            $('#type_requiremusic').attr('style', 'border:1px solid red');
            $('#category_requiremusic').attr('style', 'border:1px solid red');
            $('.msg_requiremusic').html(re.msg);
        } else {
            $('.msg_requiremusic').html('');
            $('#type_requiremusic').removeAttr('style');
            $('#category_requiremusic').removeAttr('style');
        }
    });
}
function check_link_upload(obj) {

    var link = $('#mediaurl').val();
    var type = $(obj).val();
    //var category  = $('#category_postmusic option:selected').val();
    $.post("/incoming/checklinktype", {link: link, type: type}, function (re) {
        if (re.status == 300) {
            $('.msg_postmusic').attr('style', 'color: red;font-weight: bold;text-align: center;');
            $('#linkSupport').attr('style', 'border:1px solid red');
            $('.msg_postmusic').html(re.msg);
        } else {
            $('.msg_postmusic').html('');
            $('#linkSupport').removeAttr('style');
        }
    });
}
function checkName_Media(obj) {
    var name = $(obj).val();
    clearTimeout(thread);
    thread = setTimeout(function () {
        $.post("/incoming/checknamemedia", {name: name}, function (re) {
            if (re.status == 300) {
                $('.msg_postmusic').attr('style', 'color: red;font-weight: bold;text-align: center;');
                $('#signup-username').attr('style', 'border:1px solid red');
                $('.msg_postmusic').html(re.msg);
            } else {
                $('.msg_postmusic').html('');
                $('#signup-username').removeAttr('style');
            }
        });
    }, t)
}
function checkName_RequireMusic(obj) {
    var name = $(obj).val();
    clearTimeout(thread);
    thread = setTimeout(function () {
        $.post("/incoming/checknamemedia", {name: name}, function (re) {
            if (re.status == 300) {
                $('.msg_requiremusic').attr('style', 'color: red;font-weight: bold;text-align: center;');
                $('#require-username').attr('style', 'border:1px solid red');
                $('.msg_requiremusic').html(re.msg);
            } else {
                $('.msg_requiremusic').html('');
                $('#require-username').removeAttr('style');
            }
        });
    }, t)
}
function checkrePassword_register(obj) {
    clearTimeout(thread);
    thread = setTimeout(function () {
        var password = $("#password").val();
        var repassword = $(obj).val();
        if (password != repassword) {
            $('#error_repassword').show();
            $('#error_repassword').html('Mật khẩu không trùng khớp');
            $(obj).css('border', '1px solid red');
        }
        else if (repassword.length < 6) {
            $('#error_repassword').show();
            $('#error_repassword').html('Nhập lại mật khẩu phải từ 6 kí tự trở lên!!');
            $(obj).css('border', '1px solid red');
        }
        else {
            $('#error_repassword').hide();
            $(obj).removeAttr('style');
        }
    }, t)
}
/*      USER        */
function forgotPassword() {
    var formObj = {};
    var data = $('#cd_form_fotgotpass').serializeArray();
    $.each(data, function (i, input) {
        formObj[input.name] = input.value;
    });
    $.post("/incoming/forgotpassword", formObj, function (re) {
        var obj = $('.msg_fotgotpass');
        if (re.status == 200) {
            obj.attr('style', 'color: green;font-weight: bold;text-align: center;');
            obj.html(re.msg);
        } else {
            obj.attr('style', 'color: red;font-weight: bold;text-align: center;');
            obj.html(re.msg);
        }
    });
}
function login() {

    var formObj = {};
    var data = $('.cd-login').serializeArray();
    $.each(data, function (i, input) {
        formObj[input.name] = input.value;
    });
    formObj.password = md5(md5(formObj.password));
    $.post("/incoming/login", formObj, function (re) {
        var obj = $('#msg_login');
        if (re.status == 200) {
            window.location.reload();
        } else {
            obj.html(re.msg);
        }
    });
}
function register() {
    var formObj = {};
    var data = $('.cd-signup').serializeArray();
    $.each(data, function (i, input) {
        formObj[input.name] = input.value;
    });
    //formObj.password = md5(md5(formObj.password));
    //formObj.repassword = md5(md5(formObj.repassword));

    if ($('.confirm_register').is(':checked')) {
        $.post("/incoming/register", formObj, function (re) {
            var obj = $('.msg_register');
            if (re.status == 200) {
                window.location.reload();
            } else {
                var stringrandom = re.randomstring;
                obj.html(re.msg);
                var html = '<i style="color: white;">' + stringrandom + '</i>';
                $('#capcha').html(html);
                $('#capcha-random').val(stringrandom);
            }
        });
    } else alert("Vui lòng 'tích' vào nút Tôi đồng ý với các điều khoản trên website!");

}
$(document).ready(function () {
    var randomcap = randomString(5, '');
    var html = '<i style="color: white;">' + randomcap + '</i>';
    $('#capcha').html(html);
    $('#capcha-random').val(randomcap);
    $('.capcha_upload').html(html);
    $('.capcha-upload-random').val(randomcap);
});
function randomCaptcha() {
    var randomcap = randomString(5, '');
    var html = '<i style="color: white;">' + randomcap + '</i>';
    $('#capcha').html(html);
    $('#capcha-random').val(randomcap);
    $('.capcha_upload').html(html);
    $('.capcha-upload-random').val(randomcap);
}
function randomString(len, charSet) {
    charSet = charSet || 'ABCDEFGHJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var randomString = '';
    for (var i = 0; i < len; i++) {
        var randomPoz = Math.floor(Math.random() * charSet.length);
        randomString += charSet.substring(randomPoz, randomPoz + 1);
    }
    return randomString;
}
/*  --------------------------- form upload music   ---------------------------------------           */
function postmusic() {
    var formObj = {};
    var data = $('.cd-postmusic').serializeArray();
    $.each(data, function (i, input) {
        if (input.name != "artist[]")
            formObj[input.name] = input.value;
    });
    formObj['artist[]'] = $("#upload_form_dj_input").val();
    $.post("/incoming/uploadmusic", formObj, function (re) {
        var obj = $('.msg_postmusic');
        if (re.status == 200) {
            alert(re.msg);
            obj.html('Đã đăng nhạc thành công!');
            obj.attr('style', 'color: green;font-weight: bold;text-align: center;');
            $('#form_postmusic')[0].reset();
            $("#upload_form_dj_input").select2("val", "");
            $("#upload_form_dj_input").empty();
            var randomcap = randomString(5, '');
            var html = '<i style="color: white;">' + randomcap + '</i>';
            $('.capcha_upload').html(html);
            $('.capcha-upload-random').val(randomcap);
        } else {
            obj.html(re.msg);
            obj.attr('style', 'color: red;font-weight: bold;text-align: center;');
        }
    });
}
function require_music() {
    var formObj = {};
    var data = $('.cd-requiremusic').serializeArray();
    $.each(data, function (i, input) {
        if (input.name != "artist[]")
            formObj[input.name] = input.value;
    });

    formObj['artist[]'] = $("#require_form_input_artist").val();

    $.post("/incoming/requiremusic", formObj, function (re) {
        var obj = $('.msg_requiremusic');
        if (re.status == 200) {
            alert(re.msg);
            obj.html('Đã yêu cầu thành công!');
            obj.attr('style', 'color: green;font-weight: bold;text-align: center;');
            $('#form_requiremusic')[0].reset();
            $("#require_form_input_artist").select2("val", "");
            $("#require_form_input_artist").empty();
            var randomcap = randomString(5, '');
            var html = '<i style="color: white;">' + randomcap + '</i>';
            $('.capcha_upload').html(html);
            $('.capcha-upload-random').val(randomcap);
        } else {
            obj.html(re.msg);
            obj.attr('style', 'color: red;font-weight: bold;text-align: center;');
        }
    });
}
var t = 400;
var thread;
var ajaxHintCall;
function getArtist(obj) {
    getRemoteData(obj, $("#sugges_data"), "returnArtist");
}
function getRemoteData(obj, suggestWrapper, callback) {
    clearTimeout(thread);
    thread = setTimeout(function () {
        var q = $(obj).val();
        var type = $('#type').val();
        suggestWrapper.html('');
        if (q.length) {
            if (ajaxHintCall) ajaxHintCall.abort();
            ajaxHintCall = $.get("/incoming/getlistartist", {q: q}, function (re) {
                var data = re.data;
                if (data.length > 0) {
                    data.forEach(function (entry) {
                        var htmlx = '<li onclick="' + callback + '(this)" data-name="' + entry.name + '" data-id="' + entry._id + '">' + entry.name + '</li>';
                        suggestWrapper.append(htmlx);
                    });
                    suggestWrapper.parent().show();
                }
                else suggestWrapper.parent().hide();
            });
        } else {
            suggestWrapper.html('');
            suggestWrapper.parent().hide();
        }
    }, t)
}

function returnArtist(obj) {
    var newTagElem = createNewElem(obj);
    $("#listArtist").append(newTagElem);
    $('.suggestion').hide();
}

function createNewElem(obj) {
    var objJquery = $(obj);
    var tagId = objJquery.attr('data-id');
    var tagName = objJquery.attr('data-name');
    var html = '<li>'
        + tagName
        + '<a href="javascript:void(0)" onclick="removeArtist(this)" class="upload-article-remove-artist"><i class="fa fa-remove"></i> </a></li>'
        + '<input type="hidden" name="artist[]" value="' + tagId + '">'
    '</li>';
    return html;
}
/* Open form download of playlist */
function openFormDownloadOfPlaylist(obj) {
    var link_320k = $(obj).data('link320');
    var link_128k = $(obj).data('link128');
    var link_64k = $(obj).data('link64');
    var name = $(obj).data('name');
    var id = $(obj).data('id');
    var html = '';
    $('#down-mp3').modal({
        show: 'true'
    });
    var insertLinkDownload = function (quality, label) {
        return '<li><a href="javascript:void(0)" title="#" onclick="downloadMedia(this)" data-id="' + id + '" data-quality="' + quality + '">' + label + '</a></li>';
    };
    html = '<p>Click vào 1 trong các liên kết bên dưới để Download về máy Bài hát: <strong>' + name + '</strong></p>';
    if (link_320k != '') html += insertLinkDownload('media_link_320k', '320k');
    if (link_128k != '') html += insertLinkDownload('media_link_128k', '128k');
    if (link_64k != '') html += insertLinkDownload('media_link_64k', '64k');
    $('.down-app').html(html);
}
/* Open form list user dislike */
function listUserLikeAndDislike(obj) {
    var id = $(obj).data('id');
    var article_type = $(obj).data('articletype');
    var type = $(obj).data('type');
    var class_icon = 'fa fa-thumbs-up';
    var label = 'Thích';
    $('#user-like').modal({
        show: 'true'
    });
    if (type == 'dislike') {
        class_icon = 'fa fa-thumbs-down';
        label = 'Không thích';
    }
    $.post('/incoming/getuserbyarticle', {id: id, article_type: article_type, type: type}, function (re) {
        var data = re.data;
        var html = '';
        $('.header_formlike').html('<i class="' + class_icon + '"></i> ' + re.total + ' ' + label + '');
        $('#block_list_user').html('');
        if (data.length > 0) {
            $.each(data, function (index, value) {
                html += '<li>' +
                    '<a href="' + value.link + '" title="' + value.username + '" class="thumb pull-left"><img src="' + value.priavatar + '" alt="' + value.username + '" title="' + value.username + '"></a>' +
                    '<h3><a href="' + value.link + '" title="' + value.username + '">' + value.username + '</a></h3>' +
                    '<p><i class="' + class_icon + '"></i></p>' +
                    '</li>';
            });
            $('#block_list_user').html(html);
        } else {
            $('#block_list_user').html('<p style="text-align: center;">Chưa có người ' + label + '</p>');
        }

    });
}
function downloadMedia(obj) {
    var quality = $(obj).data('quality');
    var id = $(obj).data('id');
    window.open('http://s1.download.stream.djscdn.com/download_media?quality=' + quality + '&id=' + id + '', "_blank");
}
function removeArtist(obj) {
    $(obj).parent().remove();
}
function share_facebook() {
    var url = $('#url_article').val();
    var link = 'https://www.facebook.com/sharer/sharer.php?u=' + url;
    window.open(link, "myWindow", "top=270, left=400, width=550, height=500");
};
function share_twitter() {
    var url = $('#url_article').val();
    var link = 'https://twitter.com/home?status=' + url;
    window.open(link, "myWindow", "top=270, left=400, width=550, height=450");
};
function share_goole() {
    var url = $('#url_article').val();
    var link = 'https://plus.google.com/share?url=' + url;
    window.open(link, "myWindow", "top=270, left=400, width=650, height=450");
};