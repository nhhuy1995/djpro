<script type="text/javascript" src="../plugin/uploadify/jquery.uploadify.min.js"></script>
<link rel="stylesheet" type="text/css" href="../plugin/uploadify/uploadify.css"/>
<div class="container">
    <div class="card">
        <div class="card-header">
            <h2>Danh sách media</h2>

            <p class="p-t-10"><a href="<?php echo $backlink; ?>"><i class="md md-arrow-back"></i>Thoát</a></p>
        </div>
        <div class="card-body card-padding p-t-0">
            <form method="post" action="/mediarequire/formprocess" enctype="multipart/form-data">
                <div role="tabpanel">
                    <ul role="tablist" class="tab-nav" style="overflow: hidden;" tabindex="1">
                        <li class="active"><a data-toggle="tab" role="tab" aria-controls="home11" href="#home11">Thông
                                tin</a></li>
                        <li><a data-toggle="tab" role="tab" aria-controls="home22" href="#home22">Chuyên mục</a></li>
                    </ul>

                    <div class="tab-content">
                        <div id="home11" class="tab-pane active" role="tabpanel">
                            <input type="hidden" name="redirect" value="<?php echo $backlink; ?>">
                            <input type="hidden" name="id" value="<?php echo $object['_id']; ?>">
                            <input type="hidden" name="is_convert_quality" value="<?php echo $object['is_convert_quality']; ?>">

                            <div>
                                <div class="card-body">
                                    <div class="form-group fg-float">
                                        <label class="radio radio-inline m-r-20">
                                            <input type="radio" value="audio" onclick="hideCategory(this)"
                                                   name="type" <?php if (!isset($object['type'])) { ?> checked<?php } ?><?php echo ($object['type'] == 'audio' ? 'checked' : ''); ?>
                                                    >
                                            <i class="input-helper"></i>
                                            Bài hát
                                        </label>
                                        <label class="radio radio-inline m-r-20">
                                            <input type="radio" value="video" onclick="hideCategory(this)"
                                                   name="type" <?php echo ($object['type'] == 'video' ? 'checked' : ''); ?>>
                                            <i class="input-helper"></i>
                                            Video
                                        </label>
                                        <label class="radio radio-inline m-r-20">
                                            <input type="radio" value="news" onclick="hideCategory(this)"
                                                   name="type" <?php echo ($object['type'] == 'news' ? 'checked' : ''); ?>>
                                            <i class="input-helper"></i>
                                            Tin tức
                                        </label>
                                        <label class="radio radio-inline m-r-20">
                                            <input type="radio" value="images" onclick="hideCategory(this)"
                                                   name="type" <?php echo ($object['type'] == 'images' ? 'checked' : ''); ?>>
                                            <i class="input-helper"></i>
                                            Ảnh
                                        </label>
                                    </div>
                                    <div class="form-group fg-float">
                                        <div class="fg-line" style="width: 95%">
                                            <input type="text" name="name" value="<?php echo $object['name']; ?>"
                                                   class="input-sm form-control fg-input" id="media_input_name" required>
                                        </div>
                                        <label class="fg-label">Tiêu đề</label>
                                    </div>


                                    <div class="form-group fg-float news">
                                        <div class="fg-line">
                                            <textarea class="form-control auto-size"
                                                      name="description"><?php echo $object['description']; ?></textarea>
                                        </div>
                                        <label class="fg-label">Mô tả</label>
                                    </div>
                                    <div class="form-group fg-float">
                                        <div class="fg-line">
                                            <input type="text" id="mediaurl" name="mediaurl"
                                                   value="<?php echo $object['mediaurl']; ?>"
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
                                        <div class="fg-line mg-bt-30">
                                            <label class="fg-label">Tên nghệ sĩ</label>
                                        </div>
                                        <div class="fg-line">
                                            <select id="dj_select_artist"  multiple="" name="artist[]"  style="width: 100%">
                                                <?php if (!empty($object['artist'])) { ?>
                                                    <?php foreach ($object['artist'] as $artist) { ?>
                                                        <option value="<?php echo $artist['_id']; ?>" selected="selected"><?php echo $artist['username']; ?></option>
                                                    <?php } ?>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group fg-float">
                                        <div class="fg-line mg-bt-30">
                                            <label class="fg-label">Tags</label>
                                        </div>
                                        <div class="fg-line">
                                            <select id="dj_select_tag"  multiple="" name="tags[]" style="width: 100%">
                                                <?php if (!empty($object['tags'])) { ?>
                                                    <?php foreach ($object['tags'] as $tagDetail) { ?>
                                                        <option value="<?php echo $tagDetail['_id']; ?>" selected="selected" ><?php echo $tagDetail['name']; ?></option>
                                                    <?php } ?>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="form-group fg-float">
                                        <div class="fg-line">
                                            <label class="checkbox checkbox-inline m-r-20">
                                                <input type="checkbox"
                                                       name="ishot" <?php echo ($object['ishot'] == 1 ? 'checked' : ''); ?> value="1"> <i
                                                        class="input-helper"></i>Tin hót
                                            </label>
                                        </div>
                                    </div>
                                 
                                    <div class="form-group fg-float">
                                        <?php foreach ($liststatus as $key => $item) { ?>
                                            <label class="radio radio-inline m-r-20" <?php if ($key == 2) { ?> style="display: none" <?php } ?>>
                                                <input type="radio" value="<?php echo $key; ?>"
                                                       name="status" <?php echo ($object['status'] == $key ? 'checked' : ''); ?>>
                                                <i class="input-helper"></i>
                                                <?php echo $item; ?>
                                            </label>
                                        <?php } ?>
                                    </div>
                                    <div class="form-group fg-float">
                                        <div class="fg-line">
                                            <input type="text" name="view" value="<?php echo $object['view']; ?>"
                                                   class="input-sm form-control fg-input">
                                        </div>
                                        <label class="fg-label">Lượt nghe</label>
                                    </div>
                                    <div class="form-group fg-float">
                                        <div class="fg-line">
                                            <input type="text" name="like" value="<?php echo $object['like']; ?>"
                                                   class="input-sm form-control fg-input">
                                        </div>
                                        <label class="fg-label">Lượt thích</label>
                                    </div>
                                    <div class="form-group fg-float">
                                        <div class="fg-line">
                                            <input type="text" name="replay" value="<?php echo $object['replay']; ?>"
                                                   class="input-sm form-control fg-input">
                                        </div>
                                        <label class="fg-label">Lượt nghe lại</label>
                                    </div>
                                    <div class="form-group fg-float">
                                        <div class="fg-line">
                                            <input type="text" name="spamflag" value="<?php echo $object['spamflag']; ?>"
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
                                                            src="<?php echo ($object['_id'] <= 0 || empty($object['priavatar']) ? '/img/300x200.gif' : $object['priavatar']); ?>"/>
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
                                                       value="<?php echo $object['priavatar']; ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group fg-float">
                                        <div class="fg-line">
                                    <textarea class="form_editor" name="content"
                                              class="form-control"><?php echo $object['content']; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="home22" class="tab-pane" role="tabpanel">
                            <div class="card-body">
                                <?php echo $categoryview; ?>
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
        $('.video').hide();
        $('.news').hide();
        $('.images').hide();
        $('.audio').hide();
        $('.' + type).show();
    }
    $(document).ready(function () {
        var type = $('input[name="type"]:checked').val();
        $('.video').hide();
        $('.news').hide();
        $('.images').hide();
        $('.audio').hide();
        $('.' + type).show();
    });
    //Upload File
    $('#file_upload').uploadify({
        'swf': '../plugin/uploadify/uploadify.swf',
        'uploader': '../plugin/uploadify/uploadify.php',
//        'uploader': 'http://s2.download.stream.djscdn.com/upload_media',
        'fileTypeExts': '*.mp3;mp4;m4a',
//        'debug': true,
        'onUploadSuccess': function (file, data, response) {
            var obj = JSON.parse(data);
            if (obj.status == 200) {
                $('#mediaurl').val(obj.path[0]);
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

        var checkMediaExists = new djCheckElemExists();
        checkMediaExists.init({
            elem:  "#media_input_name",
            data: function() {
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

