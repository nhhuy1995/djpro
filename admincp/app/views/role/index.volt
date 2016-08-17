<div class="container">

    <div class="card">
        <div class="card-header">
            <h2>Danh sách Nhóm Quyền</h2>
        </div>

        <div class="table-responsive">
            <div class="col-md-2">
                <a href="/role/form">
                    <button class="btn btn-success waves-effec" style="margin-left: 25px;">Thêm mới</button>
                </a>
            </div>
            <div class="col-md-3 wrap-search">
                <form action="" method="get">
                    <div class="form-group">
                        <div class="fg-line fg-toggled ">
                            <input type="text" class="input-sm form-control fg-input" value="{{ _GET['q'] }}" placeholder="Search" name="q">
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-2" style="margin-left: -40px;">
                <a href="javascript:void(0)" class="btndeleteform">
                    <button class="btn bgm-red waves-effect">Xóa lựa chọn</button>
                </a>
            </div>
            <div class="col-sm-12" id="wrap-main">
                <form action="{{ controllink['delete'] }}" method="post" id="mainform">
                    <table id="data-table-selection" class="table table-striped">
                        <thead>
                        <tr>
                            <th>
                                <div class="checkbox">
                                    <label style="font-weight: bold;">
                                        <input type="checkbox" class="con-sm-1" id="checkallcat">
                                        <i class="input-helper"></i>
                                    </label>
                                </div>
                            </th>
                            <th data-column-id="id" data-type="numeric" data-identifier="true">
                                ID
                            </th>
                            <th data-column-id="rolegroup">Tên nhóm quyền</th>
                            <th data-column-id="sort">Vị trí</th>
                            <th data-column-id="datecreate" data-order="desc">Ngày khởi tạo</th>
                            <th data-column-id="setting" data-order="desc">Thao tác</th>
                        </tr>
                        </thead>
                        <tbody>
                        {% for item in listRole %}
                            <tr>
                                <td>
                                    <div class="checkbox">
                                        <label style="font-weight: bold;">
                                            <input type="checkbox" class="con-sm-1 catitem" name="id[]" value="{{ item['_id'] }}">
                                            <i class="input-helper"></i>
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    {{ item['_id'] }}
                                </td>
                                <td>{{ item['name'] }}</td>
                                <td>{{ item['sort'] }}</td>
                                <td>{{ date('d-m-Y | H:i:s',item['datecreate']) }}</td>
                                <td>
                                    <a href="{{ controllink['update'] }}&id={{ item['_id'] }}">Sửa</a> |
                                    <a href="{{ controllink['delete'] }}&id={{ item['_id'] }}" class="btndelete">Xóa</a>
                                </td>
                            </tr>
                        {% endfor %}
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
        {% include "layouts/paging.volt" %}
    </div>
</div>

