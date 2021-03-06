<div class="container">

    <div class="card">
        <div class="card-header">
            <h2>Thông tin nghệ sĩ</h2>

            <p class="p-t-10"><a href="<?php echo $backlink; ?>"><i class="md md-arrow-back"></i>Thoát</a></p>
        </div>

        <div class="card-body card-padding">
            <div role="tabpanel">
                <ul role="tablist" class="tab-nav" style="overflow: hidden;" tabindex="1">
                    <li class="active"><a data-toggle="tab" role="tab" aria-controls="home11" href="#home11"
                                          aria-expanded="true">Thông tin chung</a></li>
                    <li><a data-toggle="tab" role="tab" aria-controls="home22" href="#home22">Chuyên mục</a>
                    </li>
                </ul>
                <form method="post" action="/artist/formprocess" enctype="multipart/form-data">
                    <input name="id" value="<?php echo $object['_id']; ?>" type="hidden">
                    <input name="redirect" value="<?php echo $backlink; ?>" type="hidden">

                    <div class="tab-content">
                        <div id="home11" class="tab-pane active" role="tabpanel">
                            <div class="card-body card-padding">

                                <div class="form-group fg-float">
                                    <div class="fg-line" style="width: 95%">
                                        <input type="text" name="username" value="<?php echo $object['username']; ?>"
                                               class="input-sm form-control fg-input" id="artist_input_name">
                                    </div>
                                    <label class="fg-label">Tên người dùng</label>
                                </div>
                                <div class="form-group fg-float">
                                    <div class="fg-line">
                                        <input type="text" name="description" value="<?php echo $object['description']; ?>"
                                               class="input-sm form-control fg-input">
                                    </div>
                                    <label class="fg-label">Mô tả</label>
                                </div>
                                <div class="form-group fg-float">
                                    <?php foreach ($liststatus as $key => $item) { ?>
                                        <label class="radio radio-inline m-r-20">
                                            <input type="radio" value="<?php echo $key; ?>"
                                                   name="status" <?php echo ($object['status'] == $key ? 'checked' : ''); ?>>
                                            <i class="input-helper"></i>
                                            <?php echo $item; ?>
                                        </label>
                                    <?php } ?>
                                </div>
                                <div class="form-group fg-float">
                                    <?php foreach ($artistTypes as $key => $value) { ?>
                                        <label class="checkbox checkbox-inline m-r-20">
                                            <input name="type[]" type="checkbox"
                                                   value="<?php echo $key; ?>" <?php if (isset($object['type'][$key])) { ?> checked="" <?php } ?>>
                                            <i class="input-helper"></i>
                                            <?php echo $value; ?>
                                        </label>
                                    <?php } ?>
                                </div>
                                <div class="fg-line">
                                    <div class="fg-label">Ảnh đại diện</div>
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-preview thumbnail" data-trigger="fileinput"
                                             id="cropbox_source">
                                            <img
                                                    src="<?php echo ($object['_id'] <= 0 || empty($object['priavatar']) ? '/img/300x200.gif' : $this->config->upload->mediaurl . $object['priavatar']); ?>"/>
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
                                               value="<?php echo $object['priavatar']; ?>"/>
                                    </div>
                                </div>
                                <div class="fg-line">
                                    <div class="fg-label">Ảnh banner</div>
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-preview thumbnail" data-trigger="fileinput"
                                             id="cropbox_source_banner">
                                            <img
                                                    src="<?php echo ($object['_id'] <= 0 || empty($object['banner']) ? '/img/300x200.gif' : $this->config->upload->mediaurl . $object['banner']); ?>"/>
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
                                               value="<?php echo $object['banner']; ?>"/>
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
                        <div id="home22" class="tab-pane" role="tabpanel">
                            <div class="card-body">
                                <?php echo $categoryview; ?>
                            </div>
                        </div>
                        <div class="form-group fg-float">
                            <button class="btn btn-primary waves-effect">Chấp nhận</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<script src="/vendors/chosen_v1.4.2/chosen.jquery.min.js"></script>
<script src="/vendors/fileinput/fileinput.min.js"></script>
<script>
    $(document).ready(function () {
        djCropImage.register = false;
    });
    $(document).ready(function () {
        $('.fileinput').on('change.bs.fileinput', function (event, previewId) {
            $(this).find('.edit_crop').click();
        });
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
                width: 1190,
                height: 350
            }
        });

        var checkArtistExists = new djCheckElemExists();
        checkArtistExists.init({
            elem: "#artist_input_name",
            data: function () {
                return {
                    q: $("#artist_input_name").val(),
                    type: 'artist'
                }
            },
            notExistsStatus: 1
        });
    });
</script>