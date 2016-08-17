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
                            <input type="text" class="input-sm form-control fg-input" value="{{ _GET['q'] }}"
                                   placeholder="Tên danh mục hoặc mã danh mục" name="q">
                        </div>
                    </div>
                </div>
                <div class="col-md-3 wrap-search">
                    <div class="form-group fg-float">
                        <div class="fg-line">
                            <div class="select">
                                <select class="form-control" onchange="this.form.submit()" name="type">
                                    <option value="{{ _GET['type'] }}">--- Loại chuyên mục ---</option>
                                    {% for key,item in list_type %}
                                        <option {{ key==_GET['type']?"selected":"" }}
                                                value="{{ key }}">{{ item }}</option>
                                    {% endfor %}
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
                    <button class="btn btn-block waves-effect">Chủ đề nổi bật</button>
                </a>
            </div>
            {# <div class="col-md-1" style="margin-left: -40px;">
                 {% if _GET['parentid'] %}
                     <p><a href="/category/index"><i class="md md-keyboard-backspace md-2x"></i></a></p>
                 {% endif %}
             </div>#}
            <div style="clear: both"></div>

            <div class="col-sm-12" id="wrap-main">
                <form action="{{ controllink['delete'] }}" method="post" id="mainform">
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
                        {% for item in listcategory %}
                            <tr>
                                <td class="col-sm-1">
                                    <div class="checkbox">
                                        <label style="font-weight: bold;">
                                            <input type="checkbox" class="con-sm-1 catitem" name="id[]"
                                                   value="{{ item['_id'] }}">
                                            <i class="input-helper"></i>
                                        </label>

                                    </div>
                                </td>
                                <td class="col-sm-3">{{ item['_id'] }}</td>
                                <td>
                                    <a href="/category/index?parentid={{ item['_id'] }}">{{ item['name'] }}</a>
                                </td>
                                <td>{{ item['status'] }}</td>
                                <td>
                                    {{ item['typename'] }}
                                </td>
                                <td>
                                    {% if item['type'] == 'topic' %}
                                        <a href="/category/article?catid={{ item['_id'] }}">Article</a> |
                                    {% endif %}
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
