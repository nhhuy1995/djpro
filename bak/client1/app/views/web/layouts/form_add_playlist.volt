<input type="hidden" id="atid" value="{{ object._id }}">
<!-- form add playlist -->
<div style="display: none;" id="my-playlist-box">
    <div data-atid="1409135130" id="addPlaylist_at_id"></div>
    <div id="playlist-list-title">
        Chọn Playlist muốn thêm
        <a id="closeAddPlaylist" href="javascript:void(0);" onclick="closeAddPlaylist()">(Đóng lại)</a>
    </div>
    <div style="position: relative; overflow: hidden; width: auto; height: auto;" class="slimScrollDiv">
        <div style="overflow: hidden; width: auto; height: auto;" id="playlist-list"></div>
        <div style="background: none repeat scroll 0% 0% rgb(119, 119, 119); width: 7px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 64px;"
             class="slimScrollBar ui-draggable"></div>
        <div style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: none repeat scroll 0% 0% rgb(68, 68, 68); opacity: 0.2; z-index: 90; right: 1px;"
             class="slimScrollRail"></div>
    </div>
    <div id="add-new-playlist">
        <input type="text" id="add-playlist-name" placeholder="Thêm Playlist mới - gõ tên Playlist vào đây..."
               name="playlist_name">
        <a onclick="addNewPlaylist()" id="add-new-playlist-btn" class="btn btn-success"
           href="javascript:void(0);">Thêm</a>
    </div>
    <div id="my-playlist-list"><a title="Xem danh sách Playlist của bạn" href="./playlist-cua-toi.html">XEM DANH SÁCH
            PLAYLIST CỦA BẠN</a></div>
</div>
<script>
    function showFormAddPlaylist(atid) {
        $('#my-playlist-box').show();
        $('.wrap-playlist').remove();
        $('#atid').val(atid);
        $.get("/incoming/getallplaylist", {}, function (re) {
            var data = re.data;
            var html = '';
            if (data != null) {
                jQuery.each(data, function (index, value) {
                    html +=
                            '<div style="overflow: hidden; width: auto; height: auto;" id="playlist-list" class="wrap-playlist">' +
                            '<div class="playlist-list-item">' +
                            '<div class="playlist-list-name">' +
                            '<a title="Thử Playlist mới" onclick="addSoongToPlaylist(' + value._id + ')" href="javascript:void(0);">' +
                            '<i class="icon-music"></i>' + value.name + '</a>' +
                            '</div>' +
                            '</div>' +
                            '</div>';
                });
                $('.slimScrollDiv').append(html);
            }
        });

    }
    function closeAddPlaylist() {
        $('#my-playlist-box').css('display', 'none');
    }
    function addNewPlaylist() {
        var name = $('#add-playlist-name').val();
        $.get("/incoming/addplaylist", {name: name}, function (re) {
            console.log(re);
            var result = re.data;
            var html = '';
            if (re.status == 200) {
                html +=
                        '<div style="overflow: hidden; width: auto; height: auto;" id="playlist-list">' +
                        '<div class="playlist-list-item">' +
                        '<div class="playlist-list-name">' +
                        '<a title="Thử Playlist mới" onclick="addSoongToPlaylist(+results._id+)" href="javascript:void(0);">' +
                        '<i class="icon-music"></i>' + result.name + '</a>' +
                        '</div>' +
                        '</div>' +
                        '</div>';
                $('.slimScrollDiv').append(html);
                alert('Thêm mới Playlist thành công!');
            }
            else {
                alert(re.mss);
            }
        });
    }
    function addSoongToPlaylist(plid) {
        var atid = $('#atid').val();
        $.get("/incoming/addsoongtoplaylist", {pllid: plid, atid: atid}, function (re) {
            if (re.status == 200) {
                alert('Thêm nhạc vào playlist thành công!');
            }
            else {
                alert(re.mss);
            }
        });
    }
</script>
