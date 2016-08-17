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

                            <th data-column-id="sort">Tiêu đề</th>
                            <th data-column-id="category">Thông tin người tạo</th>
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
                                <td>
                                    <span style="color: #b3b3ac">Người tạo: <b
                                                style="color: black;">{{ item['usercreate'] }}</b></span><br/>
                                    <span style="color: #b3b3ac">Ngày đăng: <b
                                                style="color: black;">{{ date('d-m-Y | H:i:s',item['datecreate']) }}</b></span><br/>

                                </td>

                                <td>
                                    <a href="/answer/{{ controllink['update'] }}&id={{ item['_id'] }}">Sửa</a> |
                                    {% if item['status'] != 2 %}
                                        <a onclick="return comfirm('Bạn chắc chắn xóa?')"
                                           href="/answer/{{ controllink['delete'] }}&id={{ item['_id'] }}"
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
