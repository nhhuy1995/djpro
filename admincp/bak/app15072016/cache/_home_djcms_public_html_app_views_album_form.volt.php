<div class="container">
    <div class="card">
        <div class="card-header">
            <h2>Album</h2>

            <p class="p-t-10"><a href="<?php echo $backlink; ?>"><i class="md md-arrow-back"></i>Thoát</a></p>
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
                            <input type="hidden" name="redirect" value="<?php echo $backlink; ?>">
                            <input type="hidden" name="id" value="<?php echo $object['_id']; ?>">

                            <div>
                                <div class="form-group fg-float">
                                    <label class="radio radio-inline m-r-20">
                                        <input onclick="hideCategory(this)" type="radio" value="album"
                                               name="type" <?php if ($object['type'] == 'album' || empty($object['type'])) { ?> checked <?php } ?>>
                                        <i class="input-helper"></i>
                                        Album
                                    </label>
                                    <label class="radio radio-inline m-r-20">
                                        <input onclick="hideCategory(this)" type="radio" value="playlist"
                                               name="type" <?php if ($object['type'] == 'playlist') { ?> checked <?php } ?>>
                                        <i class="input-helper"></i>
                                        Playlist
                                    </label>
                                    <label class="radio radio-inline m-r-20">
                                        <input onclick="hideCategory(this)" type="radio" value="topic"
                                               name="type" <?php if ($object['type'] == 'topic') { ?> checked <?php } ?>>
                                        <i class="input-helper"></i>
                                        Topic
                                    </label>
                                </div>
                                <div class="card-body">
                                    <div class="form-group fg-float">
                                        <div class="fg-line" style="width: 95%">
                                            <input type="text" name="name" value="<?php echo $object['name']; ?>"
                                                   class="input-sm form-control fg-input" id="collection_input_name" required>
                                        </div>
                                        <label class="fg-label">Tiêu đề</label>
                                    </div>


                                    <div class="form-group fg-float description_block">
                                        <div class="fg-line">
                                            <textarea class="form-control auto-size"
                                                      name="description"><?php echo $object['description']; ?></textarea>
                                        </div>
                                        <label class="fg-label">Mô tả</label>
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

                                    <div class="form-group fg-float is_special">
                                        <div class="fg-line">
                                            
                                            <label class="checkbox checkbox-inline m-r-20">
                                                <input type="checkbox"
                                                       name="isspecial" <?php echo ($object['isspecial'] == 1 ? 'checked' : ''); ?>
                                                       value="1"> <i class="input-helper"></i>Đặc biệt
                                            </label>
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
                                            <input type="text" name="dislike" value="<?php echo $object['dislike']; ?>"
                                                   class="input-sm form-control fg-input">
                                        </div>
                                        <label class="fg-label">Lượt không thích</label>
                                    </div>
                                    <div class="form-group fg-float">
                                        <div class="fg-line">
                                            <input type="text" name="spamflag" value="<?php echo $object['spamflag']; ?>"
                                                   class="input-sm form-control fg-input">
                                        </div>
                                        <label class="fg-label">Lượt báo xấu</label>
                                    </div>
                                    <div class="fg-line">
                                        <div class="fg-label">Ảnh đại diện</div>
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-preview thumbnail" data-trigger="fileinput"
                                                 id="cropbox_source">
                                                <img
                                                        src="<?php echo ($object['_id'] <= 0 || empty($object['priavatar']) ? '/img/240x240.png' : $this->config->upload->mediaurl . $object['priavatar']); ?>"/>
                                            </div>
                                            <div class="image">
                                            <span class="btn btn-info btn-file">
                                                <span class="fileinput-new">Select image</span>
                                                <span class="fileinput-exists">Change</span>
                                                <input type="file" name="priavatar"/>
                                            </span>
                                                <a href="#" class="btn btn-danger"
                                                   data-dismiss="fileinput">Remove</a>

                                                <a href="#" class="btn btn-info edit_crop" data-toggle="modal"
                                                   data-target="#myModal" id="edit_image_avatar">
                                                    <i class="glyphicon glyphicon-pencil"></i> Edit</a>
                                            </div>

                                            <!-- <input id="image_priavatar" name="priavatar" type="hidden"
                                                   value="<?php echo $object['priavatar']; ?>"/> -->
                                        </div>
                                    </div>
                                    <div class="fg-line banner_block">
                                        <div class="fg-label">Ảnh banner</div>
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-preview thumbnail" data-trigger="fileinput"
                                                 id="cropbox_source_banner">
                                                <img
                                                        src="<?php echo ($object['_id'] <= 0 || empty($object['banner']) ? '/img/1160x403.png' : $this->config->upload->mediaurl . $object['banner']); ?>"/>
                                            </div>
                                            <div class="image">
                                            <span class="btn btn-info btn-file">
                                                <span class="fileinput-new">Select image</span>
                                                <span class="fileinput-exists">Change</span>
                                                <input type="file" name="banner"/>
                                            </span>
                                                <a href="#" class="btn btn-danger"
                                                   data-dismiss="fileinput">Remove</a>

                                                <a href="#" class="btn btn-info edit_crop" data-toggle="modal"
                                                   data-target="#myModal" id="edit_image_banner">
                                                    <i class="glyphicon glyphicon-pencil"></i> Edit</a>
                                            </div>

                                            <!-- <input id="image_banner" name="banner" type="hidden"
                                                   value="<?php echo $object['banner']; ?>"/> -->
                                        </div>
                                    </div>

                                    <div class="fg-line banner_block">
                                        <div class="fg-label">Ảnh banner nhỏ</div>
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-preview thumbnail" data-trigger="fileinput"
                                                 id="cropbox_source_small_banner">
                                                <img
                                                        src="<?php echo ($object['_id'] <= 0 || empty($object['small_banner']) ? '/img/371x136.png' : $this->config->upload->mediaurl . $object['small_banner']); ?>"/>
                                            </div>
                                            <div class="image">
                                            <span class="btn btn-info btn-file">
                                                <span class="fileinput-new">Select image</span>
                                                <span class="fileinput-exists">Change</span>
                                                <input type="file" name="small_banner"/>
                                            </span>
                                                <a href="#" class="btn btn-danger"
                                                   data-dismiss="fileinput">Remove</a>

                                                <a href="#" class="btn btn-info edit_crop" data-toggle="modal"
                                                   data-target="#myModal" id="edit_image_small_banner">
                                                    <i class="glyphicon glyphicon-pencil"></i> Edit</a>
                                            </div>

                                            <!-- <input id="image_small_banner" name="small_banner" type="hidden"
                                                   value="<?php echo $object['small_banner']; ?>"/> -->
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
                        <div id="home33" class="tab-pane" role="tabpanel">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h4 class="">List song</h4>
                                        <ul id="listsongInAlbum" class="listcat p-l-20 sortable">
                                            <?php if (!empty($object['listsong'])) { ?>
                                                <?php foreach ($object['listsong'] as $songDetail) { ?>
                                                    <li class="p-5">
                                                        <div>
                                                            <label class="checkbox checkbox-inline">
                                                                <input class="inputid_home" name="listsong[]"
                                                                       value="<?php echo $songDetail['_id']; ?>" type="hidden">
                                                                <input checked type="checkbox" class="checkEnableTag"><i
                                                                        class="input-helper"></i>
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
        if(type == 'topic'){
            $('.description_block').show();
            $('.banner_block').show();
            $('.is_special').show();
        }else{
            $('.description_block').hide();
            $('.banner_block').hide();
            $('.is_special').hide();
        }
        $('.' + type).show();
    }
    $(document).ready(function () {
        var type = $('input[name="type"]:checked').val();
        $('.album').hide();
        $('.playlist').hide();
        $('.topic').hide();
        if(type == 'topic'){
            $('.description_block').show();
            $('.banner_block').show();
            $('.is_special').show();
        }else{
            $('.description_block').hide();
            $('.banner_block').hide();
            $('.is_special').hide();
        }
        $('.' + type).show();
    });

    $(document).ready(function () {
        // var cropAvatar = new djCropImage();
        // cropAvatar.registerFunction({
        //     bindElem: '#edit_image_avatar',
        //     previewElem: "#cropbox_source",
        //     inputElem: '#image_priavatar',
        //     cropType: 'news',
        //     aspectRatio: {
        //         width: 240,
        //         height: 240
        //     }
        // });
        // var cropBanner = new djCropImage();
        // cropBanner.registerFunction({
        //     bindElem: '#edit_image_banner',
        //     previewElem: '#cropbox_source_banner',
        //     inputElem: '#image_banner',
        //     cropType: 'banner',
        //     aspectRatio: {
        //         width: 2300,
        //         height: 800
        //     }
        // });
        // var cropSmallBanner = new djCropImage();
        // cropSmallBanner.registerFunction({
        //     bindElem: '#edit_image_small_banner',
        //     previewElem: '#cropbox_source_small_banner',
        //     inputElem: '#image_small_banner',
        //     cropType: 'small_banner',
        //     aspectRatio: {
        //         width: 1100,
        //         height: 404
        //     }
        // });

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