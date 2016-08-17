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
                                            <input type="radio" value="audio" onclick="hideCategory(this)"
                                                   name="type" {% if object['type'] is not defined %} checked{% endif %}{{ object['type'] == 'audio'?"checked":"" }}
                                            >
                                            <i class="input-helper"></i>
                                            Bài hát
                                        </label>
                                        <label class="radio radio-inline m-r-20">
                                            <input type="radio" value="video" onclick="hideCategory(this)"
                                                   name="type" {{ object['type'] == 'video'?"checked":"" }}>
                                            <i class="input-helper"></i>
                                            Video
                                        </label>
                                        <label class="radio radio-inline m-r-20">
                                            <input type="radio" value="news" onclick="hideCategory(this)"
                                                   name="type" {{ object['type'] == 'news'?"checked":"" }}>
                                            <i class="input-helper"></i>
                                            Tin tức
                                        </label>
                                        <label class="radio radio-inline m-r-20">
                                            <input type="radio" value="images" onclick="hideCategory(this)"
                                                   name="type" {{ object['type'] == 'images'?"checked":"" }}>
                                            <i class="input-helper"></i>
                                            Ảnh
                                        </label>
                                    </div>
                                    <div class="form-group fg-float">
                                        <div class="fg-line" style="width: 95%">
                                            <input type="text" name="name" value="{{ object['name'] }}"
                                                   class="input-sm form-control fg-input" id="media_input_name"
                                                   required>
                                        </div>
                                        <label class="fg-label">Tiêu đề</label>
                                    </div>


                                    <div class="form-group fg-float description_block">
                                        <div class="fg-line">
                                            <textarea class="form-control auto-size"
                                                      name="description">{{ object['description'] }}</textarea>
                                        </div>
                                        <label class="fg-label">Mô tả</label>
                                    </div>
                                    <div class="form-group fg-float hideon_block">
                                        <div class="fg-line">
                                            <input type="text" id="mediaurl" name="mediaurl"
                                                   value="{{ object['mediaurl'] }}"
                                                   class="input-sm form-control fg-input">
                                        </div>
                                        <label class="fg-label">Đường dẫn file</label>
                                    </div>
                                    <div class="form-group fg-float hideon_block">
                                        <div class="fg-line">
                                            <input type="file" name="file_upload" id="file_upload"/>
                                        </div>
                                    </div>

                                    <div class="form-group fg-float hideon_block">
                                        <div class="fg-line mg-bt-30">
                                            <label class="fg-label">Tên nghệ sĩ</label>
                                        </div>
                                        <div class="fg-line">
                                            <select id="dj_select_artist" multiple="" name="artist[]"
                                                    style="width: 100%">
                                                {% if object['artist'] is not empty %}
                                                    {% for artist in object['artist'] %}
                                                        <option value="{{ artist['_id'] }}"
                                                                selected="selected">{{ artist['username'] }}</option>
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
                                            <select id="dj_select_tag" multiple="" name="tags[]" style="width: 100%">
                                                {% if object['tags'] is not empty %}
                                                    {% for tagDetail in object['tags'] %}
                                                        <option value="{{ tagDetail['_id'] }}"
                                                                selected="selected">{{ tagDetail['name'] }}</option>
                                                    {% endfor %}
                                                {% endif %}
                                            </select>
                                        </div>
                                    </div>


                                    {#<div class="form-group fg-float hideon_block">
                                        <div class="fg-line">
                                            <label class="checkbox checkbox-inline m-r-20">
                                                <input type="checkbox"
                                                       name="ishot" {{ object['ishot']==1?"checked":"" }} value="1"> <i
                                                        class="input-helper"></i>Tin hót
                                            </label>
                                        </div>
                                    </div>#}
                                    {#   <div class="form-group fg-float">
                                           <div class="fg-line">
                                               <div class="toggle-switch" data-ts-color="blue">
                                                   <label for="ts3" class="ts-label">Trạng thái</label>
                                                   <input type="checkbox" hidden="hidden"
                                                          id="ts3" {{ object['status']==1?"checked":"" }} value="1"
                                                          name="status">
                                                   <label for="ts3" class="ts-helper"></label>
                                               </div>
                                           </div>
                                       </div>#}
                                    <div class="form-group fg-float">
                                        {% for key,item in liststatus %}
                                            <label class="radio radio-inline m-r-20">
                                                <input type="radio" value="{{ key }}"
                                                       name="status"
                                                        {% if object['status'] is defined %}
                                                            {{ object['status']==key?"checked":"" }}
                                                        {% else %}
                                                            {{ key==1?"checked":"" }}
                                                        {% endif %}
                                                >
                                                <i class="input-helper"></i>
                                                {{ item }}
                                            </label>
                                        {% endfor %}
                                    </div>
                                    <div class="form-group fg-float">
                                        <div class="fg-line">
                                            <input type="text" name="view" value="{{ object['view'] }}"
                                                   class="input-sm form-control fg-input">
                                        </div>
                                        <label class="fg-label block_view"></label>
                                    </div>
                                    <div class="form-group fg-float form_download">
                                        <div class="fg-line">
                                            <input type="text" name="download" value="{{ object['download'] }}"
                                                   class="input-sm form-control fg-input">
                                        </div>
                                        <label class="fg-label">Lượt tải</label>
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
                                            <input type="text" name="dislike" value="{{ object['dislike'] }}"
                                                   class="input-sm form-control fg-input">
                                        </div>
                                        <label class="fg-label">Lượt không thích</label>
                                    </div>
                                    <div class="form-group fg-float">
                                        <div class="fg-line">
                                            <input type="text" name="spamflag" value="{{ object['spamflag'] }}"
                                                   class="input-sm form-control fg-input">
                                        </div>
                                        <label class="fg-label">Lượt báo xấu</label>
                                    </div>

                                    <div class="form-group fg-float">
                                        {#<span>
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
                                        <br/><br/>#}

                                        <div class="fg-line">
                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                <div class="fileinput-preview thumbnail" data-trigger="fileinput"
                                                     id="cropbox_source">
                                                    <img id="link_avatar"
                                                         src="{{ object['_id'] <= 0 or object['priavatar'] is empty ?"":object['priavatar'] }}"/>
                                                </div>
                                                <div class="image">
                                                    <span class="btn btn-info btn-file">
                                                        <span class="fileinput-new">Select image</span>
                                                        <span class="fileinput-exists">Change</span>
                                                        <input type="file" name="file"/>
                                                    </span>
                                                    <a href="#" class="btn btn-danger"
                                                       data-dismiss="fileinput">Remove</a>

                                                    <a id="edit_image_avatar" href="#" class="btn btn-info edit_crop"
                                                       data-toggle="modal"
                                                       data-target="#myModal">
                                                        <i class="glyphicon glyphicon-pencil"></i> Edit</a>
                                                </div>

                                                <input id="image_priavatar" name="priavatar" type="hidden"
                                                       value="{{ object['priavatar'] }}"/>
                                                <input name="priavatar_small" type="hidden"
                                                       value="{{ object['priavatar_small'] }}"/>
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
    function hideCategory(obj) {
        var type = $(obj).val();
        var link_avatar = $('#link_avatar').attr('src');
        $('.video').hide();
        $('.news').hide();
        $('.images').hide();
        $('.audio').hide();
        $('.' + type).show();
        if (type == 'news' || type == 'images') {
            $('.description_block').show();
            $('.hideon_block').hide();
            $('.form_download').hide();
        } else {
            $('.description_block').hide();
            $('.hideon_block').show();
            $('.form_download').show();
        }
        if (type == 'news' || type == 'images' || type == 'video') $('.block_view').html('Lượt xem');
        else  $('.block_view').html('Lượt nghe');
        //check avatar
        var avatar = '';
        if (link_avatar == '/img/240x240' || link_avatar == '/img/240x135.png' || link_avatar == '/img/410x206.png' || link_avatar == '') {
            if (type == 'audio') avatar = "/img/240x240";
            else if (type == 'video') avatar = "/img/240x135.png";
            else avatar = "/img/410x206.png";
            $('#link_avatar').attr("src", avatar);
        }
    }
    $(document).ready(function () {
        var type = $('input[name="type"]:checked').val();
        var link_avatar = $('#link_avatar').attr('src');
        $('.video').hide();
        $('.news').hide();
        $('.images').hide();
        $('.audio').hide();
        $('.' + type).show();
        if (type == 'news' || type == 'images') {
            $('.hideon_block').hide();
            $('.description_block').show();
            $('.form_download').hide();
        } else {
            $('.description_block').hide();
            $('.hideon_block').show();
            $('.form_download').show();
        }
        if (type == 'news' || type == 'images' || type == 'video') $('.block_view').html('Lượt xem');
         else  $('.block_view').html('Lượt nghe');
        //check avatar
        var avatar = '';
        if (link_avatar == '/img/240x240.png' || link_avatar == '/img/240x135.png' || link_avatar == '/img/410x206.png' || link_avatar == '') {
            if (type == 'audio') avatar = "/img/240x240";
            else if (type == 'video') avatar = "/img/240x135.png";
            else avatar = "/img/410x206.png";
            $('#link_avatar').attr("src", avatar);
        }
    });
    //Upload File
    $('#file_upload').uploadify({
        'swf': '../plugin/uploadify/uploadify.swf',
        // 'uploader': '../plugin/uploadify/uploadify.php',
        'uploader': 'http://s1.download.stream.djscdn.com/upload_media',
        'fileTypeExts': '*.mp3;*.mp4;*.m4a',
//        'debug': true,
        'onUploadSuccess': function (file, data, response) {
            var obj = JSON.parse(data);
            if (obj.status == 200) {
                $('#mediaurl').val(obj.path[0]);
                if (obj.avatar != undefined) {
                    $("#cropbox_source img").attr('src', obj.avatar);
                    $("input[name=priavatar]").val(obj.avatar);
                    $("input[name=priavatar_small]").val(obj.avatar_small);
                }
            } else {
                alert(obj.mss);
            }
        }
    });

    $(document).ready(function () {
        /*var cropAvatar = new djCropImage();
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
         });*/

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

        var checkMediaExists = new djCheckElemExists();
        checkMediaExists.init({
            elem: "#media_input_name",
            data: function () {
                return {
                    q: $("#media_input_name").val(),
                    type: 'article',
                    sub_type: $('input[name="type"]:checked').val()
                }
            },
            notExistsStatus: 1
        });
    });


</script>

