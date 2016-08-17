<div class="container">

    <div class="card">
        <div class="card-header">
            <h2>Danh sách Danh mục</h2>
        </div>

        <div class="table-responsive">
            <div class="col-md-2">
                <a href="/category/form">
                    <button class="btn btn-success waves-effec" style="margin-left: 25px;"><i
                                class="md md-add-circle-outline"></i> Thêm mới
                    </button>
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
                <div class="col-md-3 wrap-search">
                    <div class="form-group fg-float">
                        <div class="fg-line">
                            <div class="select">
                                <select class="form-control" onchange="this.form.submit()" name="type">
                                    <option value="<?php echo $_GET['type']; ?>">--- Loại chuyên mục ---</option>
                                    <?php foreach ($list_type as $key => $item) { ?>
                                        <option <?php echo ($key == $_GET['type'] ? 'selected' : ''); ?>
                                                value="<?php echo $key; ?>"><?php echo $item; ?></option>
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
            <div class="col-md-3" style="clear: both;margin-left: 26px;">
                <a href="/category/categoryspecial" >
                    <button class="btn btn-block waves-effect">Chủ đề đặc biệt</button>
                </a>
            </div>
           
            <div style="clear: both"></div>

            <div class="col-sm-12" id="wrap-main">
                <form action="<?php echo $controllink['delete']; ?>" method="post" id="mainform">
                    <table id="data-table-selection" class="table table-striped">
                        <thead>
                        <tr>
                            <th class="col-sm-1" data-column-id="id" data-type="numeric" data-identifier="true">
                                <div class="checkbox">
                                    <label style="font-weight: bold;">
                                        <input type="checkbox" class="con-sm-1" id="checkallcat">
                                        <i class="input-helper"></i>

                                    </label>

                                </div>
                            </th>
                            <th class="col-sm-3">ID</th>
                            <th data-column-id="name">Tên chuyên mục</th>
                            <th data-column-id="sort">Trạng thái</th>
                            <th data-column-id="sort">Loại chuyên mục</th>
                            <th data-column-id="setting" data-order="desc">Thao tác</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($listcategory as $item) { ?>
                            <tr>
                                <td class="col-sm-1">
                                    <div class="checkbox">
                                        <label style="font-weight: bold;">
                                            <input type="checkbox" class="con-sm-1 catitem" name="id[]"
                                                   value="<?php echo $item['_id']; ?>">
                                            <i class="input-helper"></i>
                                        </label>

                                    </div>
                                </td>
                                <td class="col-sm-3"><?php echo $item['_id']; ?></td>
                                <td>
                                    <a href="/category/index?parentid=<?php echo $item['_id']; ?>"><?php echo $item['name']; ?></a>
                                </td>
                                <td><?php echo $item['status']; ?></td>
                                <td>
                                    <?php echo $item['typename']; ?>
                                </td>
                                <td>
                                    <?php if ($item['type'] == 'topic') { ?>
                                    <a href="/category/article?catid=<?php echo $item['_id']; ?>">Article</a> |
                                    <?php } ?>
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
