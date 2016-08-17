<div class="container">
    <div class="card">
        <div class="card-header">
            <h2>Album</h2>

            <p class="p-t-10"><a href="{{ backlink }}"><i class="md md-arrow-back"></i>Thoát</a></p>
        </div>
        <div class="card-body card-padding p-t-0">
            <form method="post" action="/album/formprocess" enctype="multipart/form-data">
                <div role="tabpanel">
                    <ul role="tablist" class="tab-nav" style="overflow: hidden;" tabindex="1">
                        <li class="active"><a data-toggle="tab" role="tab" aria-controls="home11" href="#home11">Thông
                                tin</a></li>
                        <li><a data-toggle="tab" role="tab" aria-controls="home22" href="#home22">Chuyên mục</a></li>
                        <li><a data-toggle="tab" role="tab" aria-controls="home33" href="#home33">Danh sách bài hát</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div id="home11" class="tab-pane active" role="tabpanel">
                            <input type="hidden" name="redirect" value="{{ backlink }}">
                            <input type="hidden" name="id" value="{{ object['_id'] }}">

                            <div>
                                <div class="form-group fg-float">
                                    <label class="radio radio-inline m-r-20">
                                        <input onclick="hideCategory(this)" type="radio" value="album"
                                               name="type" {% if object['type'] == "album" or object['type'] is empty %} checked {% endif %}>
                                        <i class="input-helper"></i>
                                        Album
                                    </label>
                                    <label class="radio radio-inline m-r-20">
                                        <input onclick="hideCategory(this)" type="radio" value="playlist"
                                               name="type" {% if object['type'] == "playlist" %} checked {% endif %}>
                                        <i class="input-helper"></i>
                                        Playlist
                                    </label>
                                    <label class="radio radio-inline m-r-20">
                                        <input onclick="hideCategory(this)" type="radio" value="topic"
                                               name="type" {% if object['type'] == "topic" %} checked {% endif %}>
                                        <i class="input-helper"></i>
                                        Topic
                                    </label>
                                </div>
                                <div class="card-body">
                                    <div class="form-group fg-float">
                                        <div class="fg-line" style="width: 95%">
                                            <input type="text" name="name" value="{{ object['name'] }}"
                                                   class="input-sm form-control fg-input" id="collection_input_name" required>
                                        </div>
                                        <label class="fg-label">Tiêu đề</label>
                                    </div>


                                    <div class="form-group fg-float">
                                        <div class="fg-line">
                                            <textarea class="form-control auto-size"
                                                      name="description">{{ object['description'] }}</textarea>
                                        </div>
                                        <label class="fg-label">Mô tả</label>
                                    </div>

                                    <div class="form-group fg-float">
                                        <div class="fg-line">
                                            <input type="text" name="sort" value=""
                                                   class="input-sm form-control fg-input">
                                        </div>
                                        <label class="fg-label">Vị trí</label>
                                    </div>

                                    <div class="form-group fg-float">
                                        <div class="fg-line mg-bt-30">
                                            <label class="fg-label">Tên nghệ sĩ</label>
                                        </div>
                                        <div class="fg-line">
                                            <select id="dj_select_artist"  multiple="" name="artist[]"  style="width: 100%">
                                                {% if object['artist'] is not empty %}
                                                    {% for artist in object['artist'] %}
                                                        <option value="{{ artist['_id'] }}" selected="selected">{{ artist['username'] }}</option>
                                                    {% endfor %}
                                                {% endif %}
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group fg-float">
                                        <div class="fg-line mg-bt-30">
                                            <label class="fg-label">Tags</label>
                                        </div>
                                        <div class="fg-line">
                                            <select id="dj_select_tag"  multiple="" name="tags[]" style="width: 100%">
                                                {% if object['tags'] is not empty %}
                                                    {% for tagDetail in object['tags'] %}
                                                        <option value="{{ tagDetail['_id'] }}" selected="selected" >{{ tagDetail['name'] }}</option>
                                                    {% endfor %}
                                                {% endif %}
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group fg-float">
                                        <div class="fg-line">
                                            {#  <label class="checkbox checkbox-inline m-r-20">
                                                  <input type="checkbox"
                                                         name="ishot" {{ object['ishot']==1?"checked":"" }} value="1"> <i
                                                          class="input-helper"></i>Tin hót
                                              </label>#}
                                            <label class="checkbox checkbox-inline m-r-20">
                                                <input type="checkbox"
                                                       name="isspecial" {{ object['isspecial']==1?"checked":"" }}
                                                       value="1"> <i class="input-helper"></i>Đặc biệt
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group fg-float">
                                        {% for key,item in liststatus %}
                                            <label class="radio radio-inline m-r-20">
                                                <input type="radio" value="{{ key }}"
                                                       name="status" {{ object['status']==key?"checked":"" }}>
                                                <i class="input-helper"></i>
                                                {{ item }}
                                            </label>
                                        {% endfor %}
                                    </div>
                                    <div class="fg-line">
                                        <div class="fg-label">Ảnh đại diện</div>
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-preview thumbnail" data-trigger="fileinput"
                                                 id="cropbox_source">
                                                <img
                                                        src="{{ object['_id'] <= 0 or object['priavatar'] is empty ?"/img/300x200.gif":config.upload.mediaurl~object['priavatar'] }}"/>
                                            </div>
                                            <div class="image">
                                            <span class="btn btn-info btn-file">
                                                <span class="fileinput-new">Select image</span>
                                                <span class="fileinput-exists">Change</span>
                                                <input type="file" name="file"/>
                                            </span>
                                                <a href="#" class="btn btn-danger"
                                                   data-dismiss="fileinput">Remove</a>

                                                <a href="#" class="btn btn-info edit_crop" data-toggle="modal"
                                                   data-target="#myModal" id="edit_image_avatar">
                                                    <i class="glyphicon glyphicon-pencil"></i> Edit</a>
                                            </div>

                                            <input id="image_priavatar" name="priavatar" type="hidden"
                                                   value="{{ object['priavatar'] }}"/>
                                        </div>
                                    </div>
                                    <div class="fg-line">
                                        <div class="fg-label">Ảnh banner</div>
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-preview thumbnail" data-trigger="fileinput"
                                                 id="cropbox_source_banner">
                                                <img
                                                        src="{{ object['_id'] <= 0 or object['banner'] is empty ?"/img/300x200.gif":config.upload.mediaurl~object['banner'] }}"/>
                                            </div>
                                            <div class="image">
                                            <span class="btn btn-info btn-file">
                                                <span class="fileinput-new">Select image</span>
                                                <span class="fileinput-exists">Change</span>
                                                <input type="file" name="file"/>
                                            </span>
                                                <a href="#" class="btn btn-danger"
                                                   data-dismiss="fileinput">Remove</a>

                                                <a href="#" class="btn btn-info edit_crop" data-toggle="modal"
                                                   data-target="#myModal" id="edit_image_banner">
                                                    <i class="glyphicon glyphicon-pencil"></i> Edit</a>
                                            </div>

                                            <input id="image_banner" name="banner" type="hidden"
                                                   value="{{ object['banner'] }}"/>
                                        </div>
                                    </div>

                                    <div class="fg-line">
                                        <div class="fg-label">Ảnh banner nhỏ</div>
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-preview thumbnail" data-trigger="fileinput"
                                                 id="cropbox_source_small_banner">
                                                <img
                                                        src="{{ object['_id'] <= 0 or object['small_banner'] is empty ?"/img/300x200.gif":config.upload.mediaurl~object['small_banner'] }}"/>
                                            </div>
                                            <div class="image">
                                            <span class="btn btn-info btn-file">
                                                <span class="fileinput-new">Select image</span>
                                                <span class="fileinput-exists">Change</span>
                                                <input type="file" name="file"/>
                                            </span>
                                                <a href="#" class="btn btn-danger"
                                                   data-dismiss="fileinput">Remove</a>

                                                <a href="#" class="btn btn-info edit_crop" data-toggle="modal"
                                                   data-target="#myModal" id="edit_image_small_banner">
                                                    <i class="glyphicon glyphicon-pencil"></i> Edit</a>
                                            </div>

                                            <input id="image_small_banner" name="small_banner" type="hidden"
                                                   value="{{ object['small_banner'] }}"/>
                                        </div>
                                    </div>

                                    <div class="form-group fg-float">
                                        <div class="fg-line">
                                    <textarea class="form_editor" name="content"
                                              class="form-control">{{ object['content'] }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="home22" class="tab-pane" role="tabpanel">
                            <div class="card-body">
                                {{ categoryview }}
                            </div>
                        </div>
                        <div id="home33" class="tab-pane" role="tabpanel">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h4 class="">List song</h4>
                                        <ul id="listsongInAlbum" class="listcat p-l-20 sortable">
                                            {% if object['listsong'] is not empty %}
                                                {% for songDetail in object['listsong'] %}
                                                    <li class="p-5">
                                                        <div>
                                                            <label class="checkbox checkbox-inline">
                                                                <input class="inputid_home" name="listsong[]"
                                                                       value="{{ songDetail['_id'] }}" type="hidden">
                                                                <input checked type="checkbox" class="checkEnableTag"><i
                                                                        class="input-helper"></i>
                                                                <span>{{ songDetail['name'] }}</span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                {% endfor %}
                                            {% endif %}
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group fg-float">
                                            <div class="fg-line">
                                                <input type="text" id="name" onkeyup="getsong(this)"
                                                       class="input-sm form-control fg-input">
                                            </div>
                                            <label class="fg-label">Tên bài hát</label>

                                            <div class="suggestion" style="display: none;">
                                                <div onclick="$(this).parent().hide()" class="closebtn"><i
                                                            class="md md-close"></i></div>
                                                <ul id="listsuggess_song">
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group fg-float">
                    <button class="btn btn-primary waves-effect">Chấp nhận</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Following CSS are used only for the Demp purposes thus you can remove this anytime. -->
<script src="/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script src="/vendors/chosen_v1.4.2/chosen.jquery.min.js"></script>
<script src="/vendors/fileinput/fileinput.min.js"></script>
<script src="/vendors/input-mask/input-mask.min.js"></script>
<script src="/vendors/bower_components/autosize/dist/autosize.min.js"></script>
<script type="text/javascript">
    function hideCategory(obj) {
        var type = $(obj).val();
        $('.album').hide();
        $('.playlist').hide();
        $('.topic').hide();

        $('.' + type).show();
    }
    $(document).ready(function () {
        var type = $('input[name="type"]:checked').val();
        $('.album').hide();
        $('.playlist').hide();
        $('.topic').hide();

        $('.' + type).show();
    });

    $(document).ready(function () {
        var cropAvatar = new djCropImage();
        cropAvatar.registerFunction({
            bindElem: '#edit_image_avatar',
            previewElem: "#cropbox_source",
            inputElem: '#image_priavatar',
            cropType: 'news',
            aspectRatio: {
                width: 240,
                height: 240
            }
        });
        var cropBanner = new djCropImage();
        cropBanner.registerFunction({
            bindElem: '#edit_image_banner',
            previewElem: '#cropbox_source_banner',
            inputElem: '#image_banner',
            cropType: 'banner',
            aspectRatio: {
                width: 2300,
                height: 800
            }
        });
        var cropSmallBanner = new djCropImage();
        cropSmallBanner.registerFunction({
            bindElem: '#edit_image_small_banner',
            previewElem: '#cropbox_source_small_banner',
            inputElem: '#image_small_banner',
            cropType: 'small_banner',
            aspectRatio: {
                width: 1100,
                height: 404
            }
        });

        var djTag = new djSelectionData();
        djTag.init({
            selectElem: "#dj_select_tag",
            urlAjax: "/incoming/getlisttag",
            placeholder: "Thêm Tags"
        });

        var djArtist = new djSelectionData();
        djArtist.init({
            selectElem: "#dj_select_artist",
            urlAjax: "/incoming/getlistartist",
            placeholder: "Thêm ca sĩ"
        });

        $('.sortable').sortable();

        var checkCollectionExists = new djCheckElemExists();
        checkCollectionExists.init({
            elem:  "#collection_input_name",
            data: function() {
                return {
                    q: $("#collection_input_name").val(),
                    type: 'collection',
                    sub_type: $('input[name="type"]:checked').val()
                }
            },
            notExistsStatus: 1
        });
    });

    // --------------- Core suggest and add Data----------------------//
    var t = 400;
    var thread;

    function getSuggestRemoteData(obj, suggestElement, urlAjax, callbackCreateElem) {
        clearTimeout(thread);
        thread = setTimeout(function () {
            var q = $(obj).val();
            var suggestObj = $(suggestElement);
            suggestObj.html('');
            if (q.length) {
                $.get(urlAjax, {q: q}, function (re) {
                    var data = re.data;
                    if (data && data.length > 0) {
                        data.forEach(callbackCreateElem);
                        suggestObj.parent().show();
                    }
                    else suggestObj.parent().hide();
                });
            } else {
                suggestObj.html('');
                suggestObj.parent().hide();
            }
        }, t)
    }

    function createNewElem(obj, inputParam) {
        var objJquery = $(obj);
        var tagId = objJquery.attr('data-id');
        var tagName = objJquery.attr('data-name');
        var html = '<li class="p-5">'
                + '<label class="checkbox checkbox-inline">'
                + '<input class="inputid_home" name="' + inputParam + '[]" value="' + tagId + '" type="hidden">'
                + '<input checked type="checkbox" class="checkEnableTag"><i class="input-helper"></i>'
                + '<span>' + tagName + '</span>'
                + '</label>'
        '</li>';
        return html;
    }

    $('body').on('change', '.checkEnableTag', function () {
        var obj = $(this);
        if (!this.checked)
            obj.siblings('.inputid_home').attr('disabled', 'disabled');
        else
            obj.siblings('.inputid_home').removeAttr('disabled');
    });

    // --------------- End Core suggest and add Data -----------------//

    // --------------- Add song for album ----------------------//

    function getsong(obj) {
        var createSongSuggest = function (entry) {
            var htmlx = '<li onclick="returnsong(this)" data-name="'
                    + entry.name + '" data-id="' + entry._id + '">'
                    + entry.name
                    + '</li>';
            $('#listsuggess_song').append(htmlx);
        };
        getSuggestRemoteData(obj, '#listsuggess_song', "/incoming/getlistsong", createSongSuggest);
    }

    function returnsong(obj) {
        var newSongElem = createNewElem(obj, 'listsong');
        $("#listsongInAlbum").append(newSongElem);
        $('.suggestion').hide();
    }

    // ----------------- End add song -------------------------------//

</script>