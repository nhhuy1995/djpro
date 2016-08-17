<div class="container">

    <div class="card">
        <div class="card-header">
            <h2>Danh sách Menu</h2>

            <p><a href="/viewcomponent/listmenuform">Thêm mới</a></p>
        </div>
        <div class="table-responsive">
            <div class="col-sm-12" id="wrap-main">
                <table id="data-table-selection" class="table table-striped">
                    <thead>
                    <tr>
                        <th data-column-id="sort">Tiêu đề</th>
                        <th data-column-id="sort">Mô tả</th>
                        <th data-column-id="setting" data-order="desc">Thao tác</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($listMenu as $item) { ?>
                        <tr>
                            <td><?php echo $item['name']; ?></td>
                            <td><?php echo $item['description']; ?></td>
                            <td>
                                <a href="/viewcomponent/listmenuform?_id=<?php echo $item['_id']; ?>">Sửa</a> |
                            </td>
                        </tr>

                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

