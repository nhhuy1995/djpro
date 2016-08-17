<div class="container">
    <div class="card">
        <div class="card-header">
            <h2>Danh sách Artist</h2>
        </div>
        <div class="row">
            <div class="col-md-2">
                <a href="/artist/form">
                    <button class="btn btn-success waves-effec" style="margin-left: 25px;"><i
                                class="md md-add-circle-outline"></i> Thêm mới
                    </button>
                </a>
            </div>
            <div class="col-md-4" style="margin-left: -50px">
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
                                    ID
                                </div>
                            </th>
                            <th data-column-id="priavatar">Ảnh</th>
                            <th data-column-id="username">UserName</th>
                            <th data-column-id="datecreate">Ngày tạo</th>
                            <th data-column-id="datecreate">Người tạo</th>
                            <th data-column-id="datecreate">Chuyên mục</th>
                            <th data-column-id="datecreate">Trạng thái</th>
                            <th data-column-id="setting" data-order="desc">Thao tác</th>
                        </tr>
                        </thead>
                        <tbody>
                        {% for item in listArtist %}
                            <tr>
                                <td>
                                    <div class="checkbox">
                                        <label style="font-weight: bold;">
                                            <input type="checkbox" class="con-sm-1 catitem" name="id[]"
                                                   value="{{ item['_id'] }}">
                                            <i class="input-helper"></i>
                                        </label>
                                        {{ item['_id'] }}
                                    </div>
                                </td>
                                <td>
                                    <a class="thumbnail" style="width: 75px" href="#">
                                        <img alt="" src="{{ config.upload.mediaurl~item['priavatar'] }}">
                                    </a>
                                </td>
                                <td><a href="{{ item['link'] }}" target="_blank">{{ item['username'] }}</a><br>
                                <td>{{ date('d-m-Y | H:i',item['datecreate']) }}</td>
                                <td><a href="{{ item['usercreate']['user_link'] }}" target="_blank">{{ item['usercreate']['username'] }}</a></td>
                                <td>{{ item['categoryname']|join(",") }}</td>
                                <td>
                                    {% set cl_status = '' %}
                                    {% if item['status'] == 2 %} {% set cl_status = '/img/icons/cross.png' %} {% endif %}
                                    {% if item['status'] == 1 %} {% set cl_status = '/img/icons/tick.png' %} {% endif %}
                                    {% if item['status'] == 3 %} {% set cl_status = '/img/icons/choduyet.png' %} {% endif %}
                                    <a href="javascript:void(0)"><img src="{{ cl_status }}"></a>
                                </td>
                                <td>
                                    <a href="{{ controllink['update'] }}&id={{ item['_id'] }}">Sửa</a> |
                                    {% if item['status'] != 2 %}
                                        <a href="{{ controllink['delete'] }}&id={{ item['_id'] }}"
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

