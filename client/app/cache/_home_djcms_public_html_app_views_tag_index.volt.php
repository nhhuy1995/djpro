<div class="container">
    <div class="card">
        <div class="card-header">
            <h2>Danh sách Tag</h2>
        </div>
        <div class="row">
            <div class="col-md-2">
                <a href="/tag/form">
                    <button class="btn btn-success waves-effec" style="margin-left: 25px;"><i
                                class="md md-add-circle-outline"></i> Thêm mới
                    </button>
                </a>
            </div>
            <div class="col-md-7" style="margin-left: -50px">
                <a href="javascript:void(0)" class="btndeleteform">
                    <button class="btn bgm-red waves-effect"><i class="md  md-cancel"></i> Xóa lựa chọn</button>
                </a>
            </div>
            <form action="" method="get">

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
                                    ID
                                </div>
                            </th>
                            <th data-column-id="name">Tên thẻ</th>
                            <th data-column-id="usercreate">Người tạo</th>
                            <th data-column-id="datecreate">Ngày tạo</th>
                            <th data-column-id="setting" data-order="desc">Thao tác</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($listTags as $item) { ?>
                            <tr>
                                <td>
                                    <div class="checkbox">
                                        <label style="font-weight: bold;">
                                            <input type="checkbox" class="con-sm-1 catitem" name="id[]" value="<?php echo $item['_id']; ?>">
                                            <i class="input-helper"></i>
                                        </label>
                                        <?php echo $item['_id']; ?>
                                    </div>
                                </td>
                                <td><a href="<?php echo $item['link']; ?>" target="_blank"><?php echo $item['name']; ?></a></td>
                                <td><?php echo $item['usercreate']['username']; ?></td>
                                <td><?php echo date('d-m-Y | H:i', $item['datecreate']); ?></td>
                                <td>
                                    <a href="<?php echo $controllink['update']; ?>&id=<?php echo $item['_id']; ?>">Sửa</a> |
                                    <a href="<?php echo $controllink['delete']; ?>&id=<?php echo $item['_id']; ?>" class="btndelete">Xóa</a>
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

