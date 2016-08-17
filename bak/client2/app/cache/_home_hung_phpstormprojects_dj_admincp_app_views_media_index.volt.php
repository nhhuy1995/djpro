<div class="container">

    <div class="card">
        <div class="card-header">
            <h2>Danh sách Media </h2>
        </div>
        <div class="table-responsive">
            <div class="col-md-2">
                <a href="/media/form">
                    <button class="btn btn-success waves-effec" style="margin-left: 25px;"><i class="md md-add-circle-outline"></i> Thêm mới</button>
                </a>
            </div>
            <form action="" method="get">
                <div class="col-md-3 wrap-search">
                    <div class="form-group">
                        <div class="fg-line fg-toggled ">
                            <input type="text" class="input-sm form-control fg-input" value="<?php echo $_GET['q']; ?>"
                                   placeholder="Tên danh mục hoặc mã danh mục" name="q">
                        </div>
                    </div>
                </div>
                <div class="col-md-2 wrap-search">
                    <div class="form-group fg-float">
                        <div class="fg-line">
                            <div class="select">
                                <select class="form-control" onchange="this.form.submit()" name="type">
                                    <option value="">--- Loại Media ---</option>
                                    <option value="news" <?php echo ($_GET['type'] == 'news' ? 'selected' : ''); ?>>Tin tức</option>
                                    <option value="video" <?php echo ($_GET['type'] == 'video' ? 'selected' : ''); ?>>Video</option>
                                    <option value="audio" <?php echo ($_GET['type'] == 'audio' ? 'selected' : ''); ?>>Bài hát</option>
                                    <option value="image" <?php echo ($_GET['type'] == 'images' ? 'selected' : ''); ?>>Ảnh</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 wrap-search">
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
            </form>
            <div class="col-md-2" style="margin-left: -30px;">
                <a href="javascript:void(0)" class="btndeleteform">
                    <button class="btn bgm-red waves-effect"><i class="md  md-cancel"></i> Xóa lựa chọn</button>
                </a>
            </div>
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

                            <th data-column-id="sort">Tên tác phẩm</th>
                            <th data-column-id="sort">Chuyên mục</th>
                            <th data-column-id="category">Thông tin người tạo</th>
                            <th data-column-id="status" data-order="desc">Trạng thái</th>
                            <th data-column-id="setting" data-order="desc">Thao tác</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($listmedia as $item) { ?>
                            <tr>
                                <td>
                                    <div class="checkbox">
                                        <label style="font-weight: bold;">
                                            <input type="checkbox" class="con-sm-1 catitem" name="id[]" value="<?php echo $item['_id']; ?>">
                                            <i class="input-helper"></i>
                                        </label>
                                    </div>
                                </td>

                                <td>
                                    <span style="color: black;"><?php echo $item['name']; ?></span><br/>
                                    <span style="color: #b3b3ac"><?php echo $item['_id']; ?></span><br/>
                                    <span style="color: #b3b3ac">Ca sỹ: <?php echo $item['singer']; ?></span><br/>
                                    <span style="color: #b3b3ac">Nhạc sỹ: <?php echo $item['singer']; ?></span><br/>
                                </td>
                                <td><?php echo join($item['categoryname'], ','); ?></td>

                                <td>
                                    <span style="color: #b3b3ac">Người tạo: <b style="color: black;"><?php echo $item['usercreate']; ?></b></span><br/>
                                    <span style="color: #b3b3ac">Ngày đăng: <b style="color: black;"><?php echo date('d-m-Y | H:i:s', $item['datecreate']); ?></b></span><br/>
                                    <span style="color: #b3b3ac">Lượt xem: <b style="color: black;"><?php echo $item['view']; ?></b></span><br/>
                                </td>
                                <td>
                                    <input type="hidden" class="statusvalue" value="<?php echo $item['status']; ?>">
                                    <?php if ($item['status'] == 1) { ?>
                                        <a href="javascript:void(0)"><img data-id="<?php echo $item['_id']; ?>" data-value="<?php echo $item['status']; ?>" onclick="changeStatus(this)" src="/img/icons/tick.png"></a>
                                    <?php } else { ?>
                                        <a href="javascript:void(0)"><img data-id="<?php echo $item['_id']; ?>" data-value="<?php echo $item['status']; ?>" onclick="changeStatus(this)" src="/img/icons/cross.png"></a>
                                    <?php } ?>
                                </td>
                                <td>
                                    <a href="/media/<?php echo $controllink['update']; ?>&id=<?php echo $item['_id']; ?>">Sửa</a> |
                                    <a href="/media/<?php echo $controllink['delete']; ?>&id=<?php echo $item['_id']; ?>" class="btndelete">Xóa</a>
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
        $.get('/incoming/changestatusnews', {id: id, value: status}, function (re) {
        });
    }

</script>

