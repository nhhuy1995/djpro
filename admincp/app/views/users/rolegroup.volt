<div class="container">

    <div class="card">
        <div class="card-header">
            <h2>Nhóm quyền cho người dùng</h2>
        </div>

        <div class="table-responsive">
            <div class="col-md-3 wrap-search">
                <form action="" method="get">
                    <div class="form-group">
                        <div class="fg-line fg-toggled ">
                            <input type="text" class="input-sm form-control fg-input" placeholder="Search" name="q">
                        </div>
                    </div>
                </form>
            </div>
            <form method="post" action="">
                <table id="data-table-selection" class="table table-striped">
                    <thead>
                    <tr>
                        <th data-column-id="id" data-type="numeric" data-identifier="true">
                            <div class="checkbox">
                                <label style="font-weight: bold;">
                                    <input type="checkbox" class="con-sm-1" id="checkallcat">
                                    <i class="input-helper"></i>
                                    Lựa chọn tất cả
                                </label>
                            </div>
                        </th>
                        <th data-column-id="rolegroup">Tên nhóm quyền</th>
                    </tr>
                    </thead>
                    <tbody>
                    {% for item in listRole %}
                        <tr>
                            <td>
                                <div class="checkbox">
                                    <label style="font-weight: bold;">
                                        <input type="checkbox" class="con-sm-1 catitem" name="role[]" {{ item['checked'] }} value="{{ item['_id'] }}">
                                        <i class="input-helper"></i>
                                    </label>
                                </div>
                            </td>
                            <td>{{ item['name'] }}</td>
                        </tr>
                    {% endfor %}
                    </tbody>
                </table>
                <div class="form-group fg-float btnsubmit">
                    <button class="btn btn-primary waves-effect">Chấp nhận</button>
                </div>
            </form>
        </div>
    </div>
</div>
