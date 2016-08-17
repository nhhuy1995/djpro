<div class="container">

    <div class="card">
        <div class="card-header">
            <h2>Danh sách câu hỏi </h2>
        </div>
        <div class="row">
            <div class="col-md-2">
                <a href="/answer/form">
                    <button class="btn btn-success waves-effec" style="margin-left: 25px;"><i
                                class="md md-add-circle-outline"></i> Thêm mới
                    </button>
                </a>
            </div>
            <div class="col-md-2" style="margin-left: -50px">
                <a href="javascript:void(0)" class="btndeleteform">
                    <button class="btn bgm-red waves-effect"><i class="md  md-cancel"></i> Xóa lựa chọn</button>
                </a>
            </div>
            <form action="" method="get">
                <div class="col-md-9"></div>
                <div class="col-md-3">
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

                            <th data-column-id="sort">Tiêu đề</th>
                            <th data-column-id="category">Thông tin người tạo</th>
                            <th data-column-id="setting" data-order="desc">Thao tác</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($listmedia as $item) { ?>
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
                                    <a href="<?php echo $item['link']; ?>" target="_blank"><span style="color: black;"><?php echo $item['name']; ?></span></a><br/>
                                    <span style="color: #b3b3ac"><?php echo $item['_id']; ?></span><br/>
                                    <span style="color: #b3b3ac">Ca sỹ: <?php echo $item['singer']; ?></span><br/>
                                    <span style="color: #b3b3ac">Nhạc sỹ: <?php echo $item['singer']; ?></span><br/>
                                </td>
                                <td>
                                    <span style="color: #b3b3ac">Người tạo: <b
                                                style="color: black;"><?php echo $item['usercreate']; ?></b></span><br/>
                                    <span style="color: #b3b3ac">Ngày đăng: <b
                                                style="color: black;"><?php echo date('d-m-Y | H:i:s', $item['datecreate']); ?></b></span><br/>

                                </td>

                                <td>
                                    <a href="/answer/<?php echo $controllink['update']; ?>&id=<?php echo $item['_id']; ?>">Sửa</a> |
                                    <?php if ($item['status'] != 2) { ?>
                                        <a onclick="return comfirm('Bạn chắc chắn xóa?')"
                                           href="/answer/<?php echo $controllink['delete']; ?>&id=<?php echo $item['_id']; ?>"
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
