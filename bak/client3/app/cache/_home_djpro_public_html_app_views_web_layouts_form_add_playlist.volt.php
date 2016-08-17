<input type="hidden" id="add-playlist-atid" value="<?php echo $object->_id; ?>">

<!-- form-add-playlist -->
<div class="modal fade" id="my-playlist-box" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><i class="fa fa-plus"></i> Chọn playlist muốn thêm</h4>
            </div>
            <div class="modal-body">

                <ul class="m-add-playlist">
                    <div style="height:150px">
                        <div class="nano">
                            <div class="content list-playlist-item">
                            </div>
                        </div>
                    </div>
                </ul>

                <div class="col-add-plt">
                    <form method="post" action="">
                        <div class="col-md-9 col-sm-9 col-xs-8"><input class="ip-ptl" type="text" name="playlist_name" id="add-playlist-name" placeholder="--- Thêm playlist mới ---"></div>
                        <div class="col-md-3 col-sm-3 col-xs-4"><a class="btn-plt" onclick="addNewPlaylist()" id="add-new-playlist-btn" href="javascript:void(0);">Thêm</a></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- form add playlist -->
<!-- <div style="display: none;" id="my-playlist-box">
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
</div> -->
<script>
    function showFormAddPlaylist(atid) {
        if (typeof atid != 'undefined') {
            $("#add-playlist-atid").val(atid);
        }
        $('.list-playlist-item').empty()
                .append('<li style="text-align:center"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i></li>');

        $.get("/incoming/getallplaylist", {}, function (re) {
            var data = re.data;
            var html = '';
            $('.list-playlist-item').empty();
            if (data != null) {
                jQuery.each(data, function (index, value) {
                    html += '<li>'
                            + '<span><i class="fa fa-music"></i><a  onclick="addSoongToPlaylist(' + value._id + ')" href="javascript:void(0);">' + value.name + '</a></span>'
                    '</li>';
                });
                $('.list-playlist-item').append(html);
            } else {
                alert('Bạn chưa có playlist nào.');
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
                html += '<li>'
                        + '<span><i class="fa fa-music"></i><a  onclick="addSoongToPlaylist(' + result._id + ')" href="javascript:void(0);">' + result.name + '</a></span>'
                '</li>';
                $('.list-playlist-item').append(html);
                alert('Thêm mới Playlist thành công!');
            }
            else {
                alert(re.mss);
            }
        });
    }
    function addSoongToPlaylist(plid) {
        var atid = $('#add-playlist-atid').val();
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
