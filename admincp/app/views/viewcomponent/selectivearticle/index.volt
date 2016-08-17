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
                    {% for item in listCollection %}
                        <tr>
                            <td>{{ item['name'] }}</td>
                            <td>
                                <a href="/viewcomponent/{{ item['action'] }}">Sửa</a> |
                            </td>
                        </tr>

                    {% endfor %}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

