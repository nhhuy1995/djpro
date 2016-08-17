<div class="container">
    <div class="card">
        <div class="card-header">
            <h2>Album</h2>

            <p class="p-t-10"><a href="<?php echo $backlink; ?>"><i class="md md-arrow-back"></i>Thoát</a></p>
        </div>
        <div class="card-body card-padding p-t-0">
            <form method="post" action="/topic/formprocess" enctype="multipart/form-data">
                <div role="tabpanel">
                    <ul role="tablist" class="tab-nav" style="overflow: hidden;" tabindex="1">
                        <li class="active"><a data-toggle="tab" role="tab" aria-controls="home11" href="#home11">Thông tin</a></li>
                        <li><a data-toggle="tab" role="tab" aria-controls="home33" href="#home33">Danh sách bài hát</a></li>
                    </ul>

                    <div class="tab-content">
                        <div id="home11" class="tab-pane active" role="tabpanel">
                            <input type="hidden" name="redirect" value="<?php echo $backlink; ?>">
                            <input type="hidden" name="id" value="<?php echo $object['_id']; ?>">

                            <div>
                                <div class="card-body">
                                    <div class="form-group fg-float">
                                        <div class="fg-line">
                                            <input type="text" name="name" value="<?php echo $object['name']; ?>"
                                                   class="input-sm form-control fg-input" required>
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
                                            <input type="text" name="sort" value="<?php echo $object['sort']; ?>"
                                                   class="input-sm form-control fg-input">
                                        </div>
                                        <label class="fg-label">Vị trí</label>
                                    </div>
                                    <div class="form-group fg-float">
                                        <div class="fg-line">
                                            <input type="text" name="avatar_topic" value="<?php echo $object['avatar_topic']; ?>"
                                                   class="input-sm form-control fg-input">
                                        </div>
                                        <label class="fg-label">Ảnh đại diện chủ đề</label>
                                    </div>
                                    <div class="form-group fg-float">
                                        <div class="fg-line">
                                            <input type="text" name="background_topic" value="<?php echo $object['background_topic']; ?>"
                                                   class="input-sm form-control fg-input">
                                        </div>
                                        <label class="fg-label">Ảnh nền chủ đề</label>
                                    </div>

                                    <div class="form-group fg-float">
                                        <div class="fg-line">
                                            <input type="text" name="tag" value="" class="input-sm form-control fg-input" onkeyup="getcategory(this);">
                                        </div>
                                        <label class="fg-label">Tên tag</label>

                                        <div class="suggestion" style="display: none;">
                                            <div onclick="$(this).parent().hide()" class="closebtn"><i class="md md-close"></i></div>
                                            <ul id="sugges_data">
                                            </ul>
                                        </div>
                                        <ul id="listTagOfNews" class="margin-top-10">
                                            <?php if ($object['tags'] == !$empty) { ?>
                                                <?php foreach ($object['tags'] as $tagDetail) { ?>
                                                    <li class="p-5">
                                                        <label class="checkbox checkbox-inline">
                                                            <input class="inputid_home" name="tags[]" value="<?php echo $tagDetail['id']; ?>" type="hidden">
                                                            <input checked type="checkbox" class="checkEnableTag"><i class="input-helper"></i>
                                                            <span><?php echo $tagDetail['name']; ?></span>
                                                        </label>
                                                    </li>
                                                <?php } ?>
                                            <?php } ?>
                                        </ul>
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
                                        <div class="fg-line">
                                            <div class="toggle-switch" data-ts-color="blue">
                                                <label for="ts3" class="ts-label">Trạng thái</label>
                                                <input type="checkbox" hidden="hidden" id="ts3" <?php echo ($object['status'] == 1 ? 'checked' : ''); ?> value="1" name="status">
                                                <label for="ts3" class="ts-helper"></label>
                                            </div>
                                        </div>
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

                                                    <a id="edit_crop" href="#" class="btn btn-info" data-toggle="modal"
                                                       data-target="#myModal">
                                                        <i class="glyphicon glyphicon-pencil"></i> Edit</a>
                                                </div>

                                                <input id="image_priavatar" name="priavatar" type="hidden" value="<?php echo $object['priavatar']; ?>"/>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div id="home33" class="tab-pane" role="tabpanel">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h4 class="">List song</h4>
                                        <ul id="listsongInAlbum" class="listcat p-l-20 sortable">
                                            <?php if ($object['listsong'] == !$empty) { ?>
                                                <?php foreach ($object['listsong'] as $songDetail) { ?>
                                                    <li class="p-5">
                                                        <div>
                                                            <label class="checkbox checkbox-inline">
                                                                <input class="inputid_home" name="listsong[]" value="<?php echo $songDetail['id']; ?>" type="hidden">
                                                                <input checked type="checkbox" class="checkEnableTag"><i class="input-helper"></i>
                                                                <span><?php echo $songDetail['name']; ?></span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                <?php } ?>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group fg-float">
                                            <div class="fg-line">
                                                <input type="text" id="name" onkeyup="getsong(this)" class="input-sm form-control fg-input">
                                            </div>
                                            <label class="fg-label">Tên bài hát</label>

                                            <div class="suggestion" style="display: none;">
                                                <div onclick="$(this).parent().hide()" class="closebtn"><i class="md md-close"></i></div>
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

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">

    <div class="modal-dialog" style="width: 100% !important;">
        <!-- Modal content-->
        <div class="modal-content">

            <!-- This is the form that our event handler fills -->
            <form id="crom_image_form" action="/imagecrop/index" method="post">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Modal Header</h4>
                </div>
                <div class="modal-body">
                    <!-- This is the image we're attaching Jcrop to -->
                    <center>
                        <img src="" id="cropbox"/>
                    </center>
                    <br/>
                    Width:
                    <input id="w" name="w" type="text" class="input-sm form-control"/>
                    Height:
                    <input id="h" name="h" type="text" class="input-sm form-control"/>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="crop_img" name="crop_img"/>
                    <input type="hidden" id="x" name="x"/>
                    <input type="hidden" id="y" name="y"/>
                    <input type="hidden" name="type" value="news"/>
                    <button type="submit" class="btn btn-primary">Crop Image</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
    $(document).ready(function () {
        $('.fileinput').on('change.bs.fileinput', function (event, previewId) {
            $('#edit_crop').click();
        });
    });

    $('#myModal').on('show.bs.modal', function (e) {

        var img = $('#cropbox_source > img').attr('src');
        $('#cropbox').attr('src', img);
        $('#crop_img').val(img);


        if (jcrop != null)jcrop.destroy();

        setTimeout(function () {
            init_jcrop();
        }, 500);

    });

    var jcrop = null;
    var aspectRatio = {
        width: 285,
        height: 285
    }

    $(document).ready(function () {
        $("#selectCropType").on('change', function () {
            var value = $(this).val();
            if (value == "news") {
                aspectRatio.width = 285;
                aspectRatio.height = 285;
            } else {
                aspectRatio.width = 480;
                aspectRatio.height = 360;
            }
            $("#crom_image_form").find("input[name='type']").val(value);
        });
    });

    function init_jcrop() {
        $('.imagePreviewLarge').removeAttr('style');
        jcrop = $.Jcrop('#cropbox', {
            onChange: showCoords,
            onSelect: showCoords,
            setSelect: [0, 0, aspectRatio.width, aspectRatio.height],
            aspectRatio: aspectRatio.width / aspectRatio.height
        });

    }

    // Simple event handler, called from onChange and onSelect
    // event handlers, as per the Jcrop invocation above
    function showCoords(c) {
        $('#x').val(c.x);
        $('#y').val(c.y);
        // $('#x2').val(c.x2);
        // $('#y2').val(c.y2);
        $('#w').val(c.w);
        $('#h').val(c.h);
    }

    var croping = false;
    $("#crom_image_form").submit(function (event) {
        event.preventDefault();

        if (croping) {
            return;
        }

        croping = true;
        $.post($(this).attr('action'), $(this).serialize(), function (data) {

            // allow crop again
            croping = false;

            // get new cropped image
            if (data.image != undefined) {
                $('#cropbox_source').attr('style', '');
                $('#cropbox_source > img').attr('src', data.image);
                $('#cropbox').attr('src', data.image);
                $('#crop_img').val(data.image);

                // remove all file input and bind new data
                $('#image_priavatar').val(data.image);
                $('#myModal').modal('hide'); // dismiss modal

                $('input [type=file]').each(function () {
                    $(this).val('');
                });

            } else {
                alert('Có lỗi xảy ra khi crop ảnh');
            }
        });
    });

    // --------------- Add tag for news ----------------------//
    var t = 400;
    var thread;
    function getcategory(obj) {
        var createTagSuggest = function (entry) {
            var htmlx = '<li onclick="returncategory(this)" data-name="'
                    + entry.name + '" data-id="' + entry._id + '">'
                    + entry.name
                    + '</li>';
            $('#sugges_data').append(htmlx);
        };
        getSuggestRemoteData(obj, '#sugges_data', "/incoming/getlisttag", createTagSuggest);
    }

    function getSuggestRemoteData(obj, suggestElement, urlAjax, callbackCreateElem) {
        clearTimeout(thread);
        thread = setTimeout(function () {
            var q = $(obj).val();
            var suggestObj = $(suggestElement);
            suggestObj.html('');
            if (q.length) {
                $.get(urlAjax, {q: q}, function (re) {
                    var data = re.data;
                    if (data.length > 0) {
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
    function returncategory(obj) {
        var newTagElem = createNewTagElem(obj, 'tags');
        $("#listTagOfNews").append(newTagElem);
        $('.suggestion').hide();
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

    // ----------------- End add Tag -------------------------------//

    // --------------- Add song for album ----------------------//
    $('.sortable').sortable();

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