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
                                    </div>
                                    <div class="form-group fg-float">
                                        <div class="fg-line" style="width: 95%">
                                            <input type="text" name="name" value="<?php echo $object['name']; ?>"
                                                   class="input-sm form-control fg-input" id="media_input_name"
                                                   required>
                                        </div>
                                        <label class="fg-label">Tiêu đề</label>
                                    </div>
                                    <div class="form-group fg-float hideon_block">
                                        <div class="fg-line">
                                            <input type="text" id="mediaurl" name="mediaurl"
                                                   value="<?php echo $object['mediaurl']; ?>"
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
                                                <?php if (!empty($object['artist'])) { ?>
                                                    <?php foreach ($object['artist'] as $artist) { ?>
                                                        <option value="<?php echo $artist['_id']; ?>"
                                                                selected="selected"><?php echo $artist['username']; ?></option>
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
                                            <select id="dj_select_tag" multiple="" name="tags[]" style="width: 100%">
                                                <?php if (!empty($object['tags'])) { ?>
                                                    <?php foreach ($object['tags'] as $tagDetail) { ?>
                                                        <option value="<?php echo $tagDetail['_id']; ?>"
                                                                selected="selected"><?php echo $tagDetail['name']; ?></option>
                                                    <?php } ?>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group fg-float">
                                        <?php foreach ($liststatus as $key => $item) { ?>
                                            <label class="radio radio-inline m-r-20">
                                                <input type="radio" value="<?php echo $key; ?>"
                                                       name="status"
                                                        <?php if (isset($object['status'])) { ?>
                                                            <?php echo ($object['status'] == $key ? 'checked' : ''); ?>
                                                        <?php } else { ?>
                                                            <?php echo ($key == 1 ? 'checked' : ''); ?>
                                                        <?php } ?>
                                                >
                                                <i class="input-helper"></i>
                                                <?php echo $item; ?>
                                            </label>
                                        <?php } ?>
                                    </div> 
                                    <div class="form-group fg-float">
                                        <div class="fg-line">
                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                <div class="fileinput-preview thumbnail" data-trigger="fileinput"
                                                     id="cropbox_source">
                                                    <img id="link_avatar"
                                                         src="<?php echo ($object['_id'] <= 0 || empty($object['priavatar']) ? '' : $object['priavatar']); ?>"/>
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
        var link_avatar = $('#link_avatar').attr('src');
        $('.video').hide();
        $('.news').hide();
        $('.images').hide();
        $('.audio').hide();
        $('.' + type).show();
        if (type == 'news' || type == 'images') {
            $('.description_block').show();
            $('.hideon_block').hide();
        } else {
            $('.description_block').hide();
            $('.hideon_block').show();
        }
        //check avatar
        var avatar = '';
        if (link_avatar == '/img/220x220.png' || link_avatar == '/img/240x135.png' || link_avatar == '/img/410x206.png' || link_avatar == '') {
            if (type == 'audio') avatar = "/img/220x220.png";
            if (type == 'video') avatar = "/img/240x135.png";
            if (type == 'news' || type == 'images') avatar = "/img/410x206.png";
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
        } else {
            $('.description_block').hide();
            $('.hideon_block').show();
        }
        //check avatar
        var avatar = '';
        if (link_avatar == '/img/220x220.png' || link_avatar == '/img/240x135.png' || link_avatar == '/img/410x206.png' || link_avatar == '') {
            if (type == 'audio') avatar = "/img/220x220.png";
            if (type == 'video') avatar = "/img/240x135.png";
            if (type == 'news' || type == 'images') avatar = "/img/410x206.png";
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

