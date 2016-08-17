<div class="container">

    <div class="card">
        <div class="card-header">
            <h2>Tác phẩm chọn lọc</h2>
        </div>
        <div class="table-responsive">
            <div class="col-sm-12" id="wrap-main">
                <table id="data-table-selection" class="table table-striped">
                    <thead>
                    <tr>
                        <th data-column-id="sort">Tiêu đề</th>
                        <th data-column-id="setting" data-order="desc">Thao tác</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($listCollection as $item) { ?>
                        <tr>
                            <td><?php echo $item['name']; ?></td>
                            <td>
                                <a href="/viewcomponent/<?php echo $item['action']; ?>">Sửa</a> |
                            </td>
                        </tr>

                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

