<div class="container">

    <div class="card">
        <div class="card-header">
            <h2>Danh sách Media </h2>
        </div>
        <div class="row">
            <div class="col-md-2">
                <a href="/media/form">
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
                <div class="col-md-2">
                    <div class="form-group fg-float">
                        <div class="fg-line">
                            <div class="select">

                                <select class="form-control" onchange="this.form.submit()" name="catid">
                                    <option value="">--- Loại chuyên mục ---</option>
                                    {% for item in listCategory %}
                                        <option value="{{ item['_id'] }}" {{ _GET['catid']==item['_id']?"selected":"" }}>{{ item['name'] }}</option>
                                    {% endfor %}
                                </select>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group fg-float">
                        <div class="fg-line">
                            <div class="select">
                                <select class="form-control" onchange="this.form.submit()" name="type">
                                    <option value="">--- Loại Media ---</option>
                                    {% for key,item in listype %}
                                        <option value="{{ key }}" {{ _GET['type']== key ?"selected":"" }}>{{ item }}</option>
                                    {% endfor %}
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group fg-float">
                        <div class="fg-line">
                            <div class="select">
                                <select class="form-control" onchange="this.form.submit()" name="status">
                                    <option value="">--- Trạng thái ---</option>
                                    {% for key,item in liststatus %}
                                        <option value="{{ key }}" {{ _GET['status']==key?"selected":"" }} >{{ item }}</option>
                                    {% endfor %}
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <div class="fg-line fg-toggled ">
                            <input type="text" class="input-sm form-control fg-input" value="{{ _GET['q'] }}"
                                   placeholder="Tìm kiếm" name="q">
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="row">
            <div class="col-sm-12" id="wrap-main">
                <form action="{{ controllink['delete'] }}" method="post" id="mainform">
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
                        {% for item in listmedia %}
                            <tr>
                                <td>
                                    <div class="checkbox">
                                        <label style="font-weight: bold;">
                                            <input type="checkbox" class="con-sm-1 catitem" name="id[]"
                                                   value="{{ item['_id'] }}">
                                            <i class="input-helper"></i>
                                        </label>
                                    </div>
                                </td>

                                <td>
                                    <a href="{{ item['link'] }}" target="_blank"><span style="color: black;">{{ item['name'] }}</span></a><br/>
                                    <span style="color: #b3b3ac">{{ item['_id'] }}</span><br/>
                                    <span style="color: #b3b3ac">Ca sỹ: {{ item['singer'] }}</span><br/>
                                    <span style="color: #b3b3ac">Nhạc sỹ: {{ item['singer'] }}</span><br/>
                                </td>
                                <td>{{ item['categoryname']|join(", ") }}</td>

                                <td>
                                    <span style="color: #b3b3ac">Người tạo: <b
                                                style="color: black;"><a href="{{ item['user_link'] }}" target="_blank">{{ item['usercreate'] }}</a></b></span><br/>
                                    <span style="color: #b3b3ac">Ngày đăng: <b
                                                style="color: black;">{{ date('d-m-Y | H:i:s',item['datecreate']) }}</b></span><br/>
                                    <span style="color: #b3b3ac">Lượt xem: <b
                                                style="color: black;">{{ item['view'] }}</b></span><br/>
                                    <span style="color: #b3b3ac">Thể loại: <b
                                                style="color: black;">{{ listype[item['type']] }}</b></span><br/>
                                </td>
                                <td>
                                    {% set cl_status = '' %}
                                    {% if item['status'] == 2 %} {% set cl_status = '/img/icons/cross.png' %} {% endif %}
                                    {% if item['status'] == 1 %} {% set cl_status = '/img/icons/tick.png' %} {% endif %}
                                    {% if item['status'] == 3 %} {% set cl_status = '/img/icons/choduyet.png' %} {% endif %}
                                    <a href="javascript:void(0)"><img src="{{ cl_status }}"></a>
                                    {#<input type="hidden" class="statusvalue" value="{{ item['status'] }}">
                                    {% if item['status']==1 %}
                                        <a href="javascript:void(0)"><img data-id="{{ item['_id'] }}"
                                                                          data-value="{{ item['status'] }}"
                                                                          onclick="changeStatus(this)"
                                                                          src="/img/icons/tick.png"></a>
                                    {% else %}
                                        <a href="javascript:void(0)"><img data-id="{{ item['_id'] }}"
                                                                          data-value="{{ item['status'] }}"
                                                                          onclick="changeStatus(this)"
                                                                          src="/img/icons/cross.png"></a>
                                    {% endif %}#}
                                </td>
                                <td>
                                    <a href="/media/{{ controllink['update'] }}&id={{ item['_id'] }}">Sửa</a> |
                                    {% if item['status'] != 2 %}
                                        <a onclick="return comfirm('Bạn chắc chắn xóa?')"
                                           href="/media/{{ controllink['delete'] }}&id={{ item['_id'] }}"
                                           class="btndelete">Xóa</a>
                                    {% endif %}
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

