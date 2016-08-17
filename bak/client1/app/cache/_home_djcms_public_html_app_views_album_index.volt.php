<div class="container">

    <div class="card">
        <div class="card-header">
            <h2>Danh sách Album, Playlist, Topic</h2>
        </div>
        <div class="row">
            <div class="col-md-2">
                <a href="/album/form">
                    <button class="btn btn-success waves-effec" style="margin-left: 25px;"><i
                                class="md md-add-circle-outline"></i> Thêm mới
                    </button>
                </a>
            </div>
            <div class="col-md-2" style="margin-left: -30px;">
                <a href="javascript:void(0)" class="btndeleteform">
                    <button class="btn bgm-red waves-effect"><i class="md  md-cancel"></i> Xóa lựa chọn</button>
                </a>
            </div>
            <form action="">
                <div class="col-md-2">
                    <div class="form-group fg-float">
                        <div class="fg-line">
                            <div class="select">
                                <select class="form-control" onchange="this.form.submit()" name="type">
                                    <option value="">--- Loại Collection ---</option>
                                    <option value="album" <?php echo ($_GET['type'] == 'album' ? 'selected' : ''); ?>>Album</option>
                                    <option value="playlist" <?php echo ($_GET['type'] == 'playlist' ? 'selected' : ''); ?>>Playlist
                                    <option value="topic" <?php echo ($_GET['type'] == 'topic' ? 'selected' : ''); ?>>Topic
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group fg-float">
                        <div class="fg-line">
                            <div class="select">
                                <select class="form-control" onchange="this.form.submit()" name="catid">
                                    <option value="<?php echo $_GET['catid']; ?>">--- Loại chuyên mục ---</option>
                                    <?php foreach ($listCategory as $item) { ?>
                                        <option value="<?php echo $item['_id']; ?>" <?php echo ($_GET['catid'] == $item['_id'] ? 'selected' : ''); ?>><?php echo $item['name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group fg-float">
                        <div class="fg-line">
                            <div class="select">
                                <select class="form-control" onchange="this.form.submit()" name="status">
                                    <option value="">--- Trạng thái ---</option>
                                    <?php foreach ($liststatus as $key => $item) { ?>
                                        <option value="<?php echo $key; ?>" <?php echo ($_GET['status'] == $key ? 'selected' : ''); ?>><?php echo $item; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <div class="fg-line fg-toggled ">
                            <input type="text" class="input-sm form-control fg-input" value="<?php echo $_GET['q']; ?>"
                                   placeholder="Tìm kiếm" name="q">
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="row">
            <div class="col-md-2" style="clear: both;margin-left: 26px;">
                <a href="/album/topicisspecial">
                    <button class="btn btn-block waves-effect">Topic Đặc biệt</button>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12" id="wrap-main">
                <form action="<?php echo $controllink['delete']; ?>" method="post" id="mainform">
                    <table id="data-table-selection" class="table table-striped">
                        <thead>
                        <tr>
                            <th data-column-id="id" data-type="numeric" data-identifier="true">
                                <div class="checkbox">
                                    <label style="font-weight: bold;">
                                        <input type="checkbox" class="con-sm-1" id="checkallcat">
                                        <i class="input-helper"></i>

                                    </label>

                                </div>
                            </th>
                            <th data-column-id="newsgroup">Ảnh đại diện</th>
                            <th data-column-id="sort">Tiêu đề</th>
                            <th data-column-id="category">Chuyên mục</th>
                            <th data-column-id="hot">Thông tin</th>
                            <th data-column-id="type">Loại</th>
                            <th data-column-id="datecreate" data-order="desc">Người tạo</th>
                            <th data-column-id="status" data-order="desc">Trạng thái</th>
                            <th data-column-id="datecreate" data-order="desc">Ngày tạo</th>
                            <th data-column-id="setting" data-order="desc">Thao tác</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($listAlbum as $item) { ?>
                            <tr>
                                <td>
                                    <div class="checkbox">
                                        <label style="font-weight: bold;">
                                            <input type="checkbox" class="con-sm-1 catitem" name="id[]"
                                                   value="<?php echo $item['_id']; ?>">
                                            <i class="input-helper"></i>
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <a class="thumbnail" style="width: 75px" href="#">
                                        <img alt="" src="<?php echo $this->config->upload->mediaurl . $item['priavatar']; ?>">
                                    </a>
                                </td>
                                <td>
                                    <span style="color: black;"><?php echo $item['name']; ?></span><br/>
                                    <span style="color: #b3b3ac"><?php echo $item['_id']; ?></span><br/>
                                    <span style="color: #b3b3ac">Tổng số ca khúc: <?php echo $item['countsong']; ?></span>
                                </td>
                                <td><?php echo join($item['categoryname'], ','); ?></td>
                                <td>
                                    <span style="color: #b3b3ac">Lượt nghe: <b
                                                style="color: black;"><?php echo $item['view']; ?></b></span><br/>
                                    <span style="color: #b3b3ac">Lượt thích: <b
                                                style="color: black;"><?php echo $item['like']; ?></b></span>
                                </td>
                                <td>
                                    <?php echo $item['type']; ?>
                                </td>
                                <td><?php echo $item['usercreate']['username']; ?></td>
                                <td>
                                    <?php $cl_status = ''; ?>
                                    <?php if ($item['status'] == 2) { ?> <?php $cl_status = '/img/icons/cross.png'; ?> <?php } ?>
                                    <?php if ($item['status'] == 1) { ?> <?php $cl_status = '/img/icons/tick.png'; ?> <?php } ?>
                                    <?php if ($item['status'] == 3) { ?> <?php $cl_status = '/img/icons/choduyet.png'; ?> <?php } ?>
                                    <a href="javascript:void(0)"><img src="<?php echo $cl_status; ?>"></a>
                                </td>
                                <td><?php echo date('d-m-Y | H:i', $item['datecreate']); ?></td>
                                <td>

                                    <a href="/album/<?php echo $controllink['update']; ?>&id=<?php echo $item['_id']; ?>">Sửa</a> |
                                    <?php if ($item['status'] != 2) { ?>
                                        <a href="/album/<?php echo $controllink['delete']; ?>&id=<?php echo $item['_id']; ?>"
                                           class="btndelete">Xóa</a>
                                    <?php } ?>
                                </td>
                            </tr>

                        <?php } ?>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
        <div class="row">
    <div class="col-sm-12">
        <ul class="pagination pull-right p-r-10">
            <ul class="pagination">
                <li class="prev"><a class="button" href="<?php echo $painginfo['currentlink']; ?>p=<?php echo ($painginfo['page'] - 1 <= 1 ? 1 : $painginfo['page'] - 1); ?>"><i class="md md-chevron-left"></i></a></li>
                <?php foreach ($painginfo['rangepage'] as $index => $item) { ?>
                    <li class="page-<?php echo $index + 1; ?> <?php echo ($item == $painginfo['page'] ? 'active' : ''); ?>"><a class="button bgm-blue" href="<?php echo $painginfo['currentlink']; ?>p=<?php echo $item; ?>"><?php echo $item; ?></a></li>
                <?php } ?>
                <li class="next"><a class="button" href="<?php echo $painginfo['currentlink']; ?>p=<?php echo ($painginfo['page'] + 1 >= $painginfo['totalpage'] ? $painginfo['totalpage'] : $painginfo['page'] + 1); ?>"><i class="md md-chevron-right"></i></a></li>
            </ul>
        </ul>
    </div>
</div>


    </div>
</div>
<script>

    function changeStatus(obj) {
        var val = $(obj).data('value');
        var id = $(obj).data('id');
        var status;
        if (val == 1) {
            status = 0;
            $(obj).data('value', 0);
            $(obj).attr('src', '/img/icons/cross.png');
        }
        else if (val == 0) {
            status = 1;
            $(obj).data('value', 1);
            $(obj).attr('src', '/img/icons/tick.png');
        }
        $.get('/incoming/changestatusalbum', {id: id, value: status}, function (re) {
        });
    }
    function changeItemNews(obj) {
        var ishot = 0;
        var id = $(obj).data('id');
        var name = $(obj).attr('name');
        if ($(obj).is(':checked')) {
            ishot = 1;
        }
        $.get('/incoming/changeitemalbum', {id: id, value: ishot, name: name}, function (re) {
        });
    }
</script>

