<script type="text/javascript" src="../plugin/uploadify/jquery.uploadify.min.js"></script>
<link rel="stylesheet" type="text/css" href="../plugin/uploadify/uploadify.css"/>
<div class="container">
    <div class="card">
        <div class="card-header">
            <h2>Danh sách media</h2>

            <p class="p-t-10"><a href="{{ backlink }}"><i class="md md-arrow-back"></i>Thoát</a></p>
        </div>
        <div class="card-body card-padding p-t-0">
            <form method="post" action="/media/formprocess" enctype="multipart/form-data">
                <div role="tabpanel">
                    <ul role="tablist" class="tab-nav" style="overflow: hidden;" tabindex="1">
                        <li class="active"><a data-toggle="tab" role="tab" aria-controls="home11" href="#home11">Thông
                                tin</a></li>
                        <li><a data-toggle="tab" role="tab" aria-controls="home22" href="#home22">Chuyên mục</a></li>
                    </ul>

                    <div class="tab-content">
                        <div id="home11" class="tab-pane active" role="tabpanel">
                            <input type="hidden" name="redirect" value="{{ backlink }}">
                            <input type="hidden" name="id" value="{{ object['_id'] }}">
                            <input type="hidden" name="is_convert_quality" value="{{ object['is_convert_quality'] }}">

                            <div>
                                <div class="card-body">
                                    <div class="form-group fg-float">
                                        <label class="radio radio-inline m-r-20">
                                            <input type="radio" value="audio"
                                                   name="type" {% if object['type'] is not defined %} checked{% endif %}{{ object['type'] == 'audio'?"checked":"" }}>
                                            <i class="input-helper"></i>
                                            Bài hát
                                        </label>
                                        <label class="radio radio-inline m-r-20">
                                            <input type="radio" value="video"
                                                   name="type" {{ object['type'] == 'video'?"checked":"" }}>
                                            <i class="input-helper"></i>
                                            Video
                                        </label>
                                        <label class="radio radio-inline m-r-20">
                                            <input type="radio" value="news"
                                                   name="type" {{ object['type'] == 'news'?"checked":"" }}>
                                            <i class="input-helper"></i>
                                            Tin tức
                                        </label>
                                        <label class="radio radio-inline m-r-20">
                                            <input type="radio" value="images"
                                                   name="type" {{ object['type'] == 'images'?"checked":"" }}>
                                            <i class="input-helper"></i>
                                            Ảnh
                                        </label>
                                    </div>
                                    <div class="form-group fg-float">
                                        <div class="fg-line">
                                            <input type="text" name="name" value="{{ object['name'] }}"
                                                   class="input-sm form-control fg-input" required>
                                        </div>
                                        <label class="fg-label">Tiêu đề</label>
                                    </div>


                                    <div class="form-group fg-float news">
                                        <div class="fg-line">
                                            <textarea class="form-control auto-size"
                                                      name="description">{{ object['description'] }}</textarea>
                                        </div>
                                        <label class="fg-label">Mô tả</label>
                                    </div>
                                    <div class="form-group fg-float">
                                        <div class="fg-line">
                                            <input type="text" id="mediaurl" name="mediaurl"
                                                   value="{{ object['mediaurl'] }}"
                                                   class="input-sm form-control fg-input">
                                        </div>
                                        <label class="fg-label">Đường dẫn file</label>
                                    </div>
                                    <div class="form-group fg-float video">
                                        <div class="fg-line">
                                            <input type="file" name="file_upload" id="file_upload"/>
                                        </div>
                                    </div>
                                    <div class="form-group fg-float">
                                        <div class="fg-line">
                                            <input type="text" name="tag" value=""
                                                   class="input-sm form-control fg-input" id="get_tag_input">
                                        </div>
                                        <label class="fg-label">Tên tag</label>

                                        <div class="suggestion" style="display: none;">
                                            <div onclick="$(this).parent().hide()" class="closebtn"><i
                                                        class="md md-close"></i></div>
                                            <ul id="sugges_data">
                                            </ul>
                                        </div>
                                        <ul id="listTagOfNews" class="margin-top-10">
                                            {% if object['tags'] is not empty %}
                                                {% for tagDetail in object['tags'] %}
                                                    <li class="p-5">
                                                        <label class="checkbox checkbox-inline">
                                                            <input class="inputid_home" name="tags[]"
                                                                   value="{{ tagDetail['id'] }}" type="hidden">
                                                            <input checked type="checkbox" class="checkEnableTag"><i
                                                                    class="input-helper"></i>
                                                            <span>{{ tagDetail['name'] }}</span>
                                                        </label>
                                                    </li>
                                                {% endfor %}
                                            {% endif %}
                                        </ul>
                                    </div>
                                    <div class="form-group fg-float">
                                        <div class="fg-line">
                                            <input type="text" name="tag" value=""
                                                   class="input-sm form-control fg-input" id="get_artist_input">
                                        </div>
                                        <label class="fg-label">Tên nghệ sĩ</label>

                                        <div class="suggestion" style="display: none;">
                                            <div onclick="$(this).parent().hide()" class="closebtn"><i
                                                        class="md md-close"></i></div>
                                            <ul id="sugges_artist_data">
                                            </ul>
                                        </div>
                                        <ul id="listArtistInAlbum" class="margin-top-10">
                                            {% if object['artist'] is not empty %}
                                                {% for artistDetail in object['artist'] %}
                                                    <li class="p-5">
                                                        <label class="checkbox checkbox-inline">
                                                            <input class="inputid_home" name="artist[]"
                                                                   value="{{ artistDetail['_id'] }}" type="hidden">
                                                            <input checked type="checkbox" class="checkEnableTag"><i
                                                                    class="input-helper"></i>
                                                            <span>{{ artistDetail['username'] }}</span>
                                                        </label>
                                                    </li>
                                                {% endfor %}
                                            {% endif %}
                                        </ul>
                                    </div>

                                    <div class="form-group fg-float">
                                        <div class="fg-line">
                                            <label class="checkbox checkbox-inline m-r-20">
                                                <input type="checkbox"
                                                       name="ishot" {{ object['ishot']==1?"checked":"" }} value="1"> <i
                                                        class="input-helper"></i>Tin hót
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group fg-float">
                                        <div class="fg-line">
                                            <div class="toggle-switch" data-ts-color="blue">
                                                <label for="ts3" class="ts-label">Trạng thái</label>
                                                <input type="checkbox" hidden="hidden"
                                                       id="ts3" {{ object['status']==1?"checked":"" }} value="1"
                                                       name="status">
                                                <label for="ts3" class="ts-helper"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group fg-float">
                                        <div class="fg-line">
                                            <input type="text" name="view" value="{{ object['view'] }}"
                                                   class="input-sm form-control fg-input">
                                        </div>
                                        <label class="fg-label">Lượt nghe</label>
                                    </div>
                                    <div class="form-group fg-float">
                                        <div class="fg-line">
                                            <input type="text" name="like" value="{{ object['like'] }}"
                                                   class="input-sm form-control fg-input">
                                        </div>
                                        <label class="fg-label">Lượt thích</label>
                                    </div>
                                    <div class="form-group fg-float">
                                        <div class="fg-line">
                                            <input type="text" name="replay" value="{{ object['replay'] }}"
                                                   class="input-sm form-control fg-input">
                                        </div>
                                        <label class="fg-label">Lượt nghe lại</label>
                                    </div>
                                    <div class="form-group fg-float">
                                        <div class="fg-line">
                                            <input type="text" name="spamflag" value="{{ object['spamflag'] }}"
                                                   class="input-sm form-control fg-input">
                                        </div>
                                        <label class="fg-label">Lượt báo xấu</label>
                                    </div>

                                    <div class="form-group fg-float">
                                        <span>
                                        <div class="fg-label">Ảnh đại diện</div>
                                        <div class="col-md-4 pull-right">
                                            <div class="select">
                                                <select class="form-control" id="selectCropType">
                                                    <option value="news">Ảnh dọc</option>
                                                    <option value="video">Ảnh ngang</option>
                                                </select>
                                            </div>
                                        </div>
                                            </span>
                                        <br/><br/>

                                        <div class="fg-line">
                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                <div class="fileinput-preview thumbnail" data-trigger="fileinput"
                                                     id="cropbox_source">
                                                    <img
                                                            src="{{ object['_id'] <= 0 or object['priavatar'] is empty ?"/img/300x200.gif":object['priavatar'] }}"/>
                                                </div>
                                                <div class="image">
                                                    <span class="btn btn-info btn-file">
                                                        <span class="fileinput-new">Select image</span>
                                                        <span class="fileinput-exists">Change</span>
                                                        <input type="file" name="file"/>
                                                    </span>
                                                    <a href="#" class="btn btn-danger"
                                                       data-dismiss="fileinput">Remove</a>

                                                    <a id="edit_image_avatar" href="#" class="btn btn-info edit_crop" data-toggle="modal"
                                                       data-target="#myModal">
                                                        <i class="glyphicon glyphicon-pencil"></i> Edit</a>
                                                </div>

                                                <input id="image_priavatar" name="priavatar" type="hidden"
                                                       value="{{ object['priavatar'] }}"/>
                                            </div>
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
<script src="/vendors/fileinput/fileinput.min.js"></script>
<script src="/vendors/input-mask/input-mask.min.js"></script>
<script src="/vendors/bower_components/autosize/dist/autosize.min.js"></script>
<script src="/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script type="text/javascript">
    //Upload File
    $('#file_upload').uploadify({ 
        'swf': '../plugin/uploadify/uploadify.swf',
//        'uploader': '../plugin/uploadify/uploadify.php',
        'uploader': 'http://s2.download.stream.djscdn.com/upload_media',
        'fileTypeExts': '*.mp3;*.mp4;',
//        'debug': true,
        'onUploadSuccess': function (file, data, response) {
            var obj = JSON.parse(data);
            if (obj.status == 200) {
                $('#mediaurl').val(obj.file.path);
            } else {
                alert(obj.mss);
            }
        }
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

        $("#selectCropType").on('change', function () {
            var value = $(this).val();
            if (value == "news") {
                var aspectRatio =  {
                    width: 240,
                    height: 240
                }
            } else {
                var aspectRatio =  {
                    width: 240,
                    height: 135
                }
            }
            $('#edit_image_avatar').attr('data-aspect-ratio', JSON.stringify(aspectRatio));
            // $("#crom_image_form").find("input[name='type']").val(value);
        });

        var djArtist = new djSelectionData();
        djArtist.init({
            suggestWrapper: '#sugges_artist_data',
            inputElem: "#get_artist_input",
            inputParam: "artist",
            listWrapper: "#listArtistInAlbum",
            urlAjax: "/incoming/getlistartist",
            urlBrandnewAjax: "/incoming/"
        });

        var djTag = new djSelectionData();
        djTag.init({
            allowAddBrandNew: true,
            suggestWrapper: '#sugges_data',
            inputElem: "#get_tag_input",
            inputParam: "tags",
            listWrapper: "#listTagOfNews",
            urlAjax: "/incoming/getlisttag",
            urlBrandnewAjax: "/incoming/inserttag"
        });
    });


</script>