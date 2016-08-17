<div class="container">

    <div class="card">
        <div class="card-header">
            <h2>Danh sách Album, Playlist, Topic</h2>
        </div>
        <div class="row">
            <div class="col-md-2">
                <a href="/album/form">
                    <button class="btn btn-success waves-effec" style="margin-left: 25px;"><i
                                class="md md-add-circle-outline"></i> Thêm mới
                    </button>
                </a>
            </div>
            <div class="col-md-2" style="margin-left: -30px;">
                <a href="javascript:void(0)" class="btndeleteform">
                    <button class="btn bgm-red waves-effect"><i class="md  md-cancel"></i> Xóa lựa chọn</button>
                </a>
            </div>
            <form action="">
                <div class="col-md-2">
                    <div class="form-group fg-float">
                        <div class="fg-line">
                            <div class="select">
                                <select class="form-control" onchange="this.form.submit()" name="type">
                                    <option value="">--- Loại Collection ---</option>
                                    <option value="album" {{ _GET['type']=='album'?"selected":"" }}>Album</option>
                                    <option value="playlist" {{ _GET['type']=='playlist'?"selected":"" }}>Playlist
                                    <option value="topic" {{ _GET['type']=='topic'?"selected":"" }}>Topic
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group fg-float">
                        <div class="fg-line">
                            <div class="select">
                                <select class="form-control" onchange="this.form.submit()" name="catid">
                                    <option value="{{ _GET['catid'] }}">--- Loại chuyên mục ---</option>
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
                                        <option value="{{ key }}" {{ _GET['status']==key?"selected":"" }}>{{ item }}</option>
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
            <div class="col-md-2" style="clear: both;margin-left: 26px;">
                <a href="/album/topicisspecial">
                    <button class="btn btn-block waves-effect">Topic Đặc biệt</button>
                </a>
            </div>
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
                            <th data-column-id="newsgroup">Ảnh đại diện</th>
                            <th data-column-id="sort">Tiêu đề</th>
                            <th data-column-id="category">Chuyên mục</th>
                            <th data-column-id="hot">Thông tin</th>
                            <th data-column-id="type">Kiểu</th>
                            <th data-column-id="datecreate" data-order="desc">Người tạo</th>
                            <th data-column-id="status" data-order="desc">Trạng thái</th>
                            <th data-column-id="setting" data-order="desc">Thao tác</th>
                        </tr>
                        </thead>
                        <tbody>
                        {% for item in listAlbum %}
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
                                    <a class="thumbnail" style="width: 75px" href="#">
                                        <img alt="" src="{{ config.upload.mediaurl~item['priavatar'] }}">
                                    </a>
                                </td>
                                <td>
                                    <span style="color: black;"><a href="{{ item['link'] }}" target="_blank">{{ item['name'] }}</a></span><br/>
                                    <span style="color: #b3b3ac">{{ item['_id'] }}</span><br/>
                                    <span style="color: #b3b3ac">Tổng số ca khúc: {{ item['countsong'] }}</span>
                                </td>
                                <td>{{ item['categoryname']|join(", ") }}</td>
                                <td>
                                    <span style="color: #b3b3ac">Lượt nghe: <b
                                                style="color: black;">{{ item['view'] }}</b></span><br/>
                                    <span style="color: #b3b3ac">Lượt thích: <b
                                                style="color: black;">{{ item['like'] }}</b></span><br/>
                                    <span style="color: #b3b3ac">Ngày tạo: <b
                                                style="color: black;">{{ date('d-m-Y | H:i',item['datecreate']) }}</b></span>
                                </td>
                                <td>
                                    {% if item['type'] == 'topic'%} <span>Chủ đề</span> {% endif %}
                                    {% if item['type'] == 'album'%} <span>Album</span>{% endif %}
                                    {% if item['type'] == 'playlist'%} <span>Playlist</span> {% endif %}
                                </td>
                                <td><a href="{{ item['usercreate']['user_link'] }}" target="_blank">{{ item['usercreate']['username'] }}</a></td>
                                <td>
                                    {% set cl_status = '' %}
                                    {% if item['status'] == 2 %} {% set cl_status = '/img/icons/cross.png' %} {% endif %}
                                    {% if item['status'] == 1 %} {% set cl_status = '/img/icons/tick.png' %} {% endif %}
                                    {% if item['status'] == 3 %} {% set cl_status = '/img/icons/choduyet.png' %} {% endif %}
                                    <a href="javascript:void(0)"><img src="{{ cl_status }}"></a>
                                </td>
                                <td>

                                    <a href="/album/{{ controllink['update'] }}&id={{ item['_id'] }}">Sửa</a> |
                                    {% if item['status'] != 2 %}
                                        <a href="/album/{{ controllink['delete'] }}&id={{ item['_id'] }}"
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
        $.get('/incoming/changestatusalbum', {id: id, value: status}, function (re) {
        });
    }
    function changeItemNews(obj) {
        var ishot = 0;
        var id = $(obj).data('id');
        var name = $(obj).attr('name');
        if ($(obj).is(':checked')) {
            ishot = 1;
        }
        $.get('/incoming/changeitemalbum', {id: id, value: ishot, name: name}, function (re) {
        });
    }
</script>

