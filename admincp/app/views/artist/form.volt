<div class="container">

    <div class="card">
        <div class="card-header">
            <h2>Thông tin nghệ sĩ</h2>

            <p class="p-t-10"><a href="{{ backlink }}"><i class="md md-arrow-back"></i>Thoát</a></p>
        </div>

        <div class="card-body card-padding">
            <div role="tabpanel">
                <ul role="tablist" class="tab-nav" style="overflow: hidden;" tabindex="1">
                    <li class="active"><a data-toggle="tab" role="tab" aria-controls="home11" href="#home11"
                                          aria-expanded="true">Thông tin chung</a></li>
                    <li><a data-toggle="tab" role="tab" aria-controls="home22" href="#home22">Quốc gia</a>
                    </li>
                </ul>
                <form method="post" action="/artist/formprocess" enctype="multipart/form-data">
                    <input name="id" value="{{ object['_id'] }}" type="hidden">
                    <input name="redirect" value="{{ backlink }}" type="hidden">

                    <div class="tab-content">
                        <div id="home11" class="tab-pane active" role="tabpanel">
                            <div class="card-body card-padding">
                                <div class="form-group fg-float">
                                    <div class="fg-line" style="width: 95%">
                                        <input type="text" name="realname" value="{{ object['realname'] }}"
                                               class="input-sm form-control fg-input" id="artist_input_name">
                                    </div>
                                    <label class="fg-label">Tên thật</label>
                                </div>
                                <div class="form-group fg-float">
                                    <div class="fg-line" style="width: 95%">
                                        <input type="text" name="username" value="{{ object['username'] }}"
                                               class="input-sm form-control fg-input">
                                    </div>
                                    <label class="fg-label">Tên nghệ danh</label>
                                </div>
                                <div class="form-group fg-float">
                                    <div class="fg-line" style="width: 95%">
                                        <input type="text" name="from" value="{{ object['from'] }}"
                                               class="input-sm form-control fg-input">
                                    </div>
                                    <label class="fg-label">Đến từ</label>
                                </div>
                                <div class="form-group fg-float">
                                    <div class="fg-line" style="width: 95%">
                                        <input type="text" name="birthday" value="{{ object['birthday'] }}"
                                               class="input-sm form-control fg-input" >
                                    </div>
                                    <label class="fg-label">Ngày sinh</label>
                                </div>
                                <div class="form-group fg-float">
                                    <div class="fg-line" style="width: 95%">
                                        <input type="text" name="job" value="{{ object['job'] }}"
                                               class="input-sm form-control fg-input">
                                    </div>
                                    <label class="fg-label">Nghề nghiệp</label>
                                </div>
                                <div class="form-group fg-float">
                                    <div class="fg-line" style="width: 95%">
                                        <input type="text" name="playmusic" value="{{ object['playmusic'] }}"
                                               class="input-sm form-control fg-input">
                                    </div>
                                    <label class="fg-label">Dòng nhạc chơi</label>
                                </div>
                                <div class="form-group fg-float">
                                    <div class="fg-line" style="width: 95%">
                                        <input type="text" name="yearjob" value="{{ object['yearjob'] }}"
                                               class="input-sm form-control fg-input">
                                    </div>
                                    <label class="fg-label">Năm vào nghề</label>
                                </div>
                                <div class="form-group fg-float">
                                    <div class="fg-line" style="width: 95%">
                                        <input type="text" name="clubdid" value="{{ object['clubdid'] }}"
                                               class="input-sm form-control fg-input">
                                    </div>
                                    <label class="fg-label">Club đã làm</label>
                                </div>
                                <div class="form-group fg-float">
                                    <div class="fg-line" style="width: 95%">
                                        <input type="text" name="workingat" value="{{ object['workingat'] }}"
                                               class="input-sm form-control fg-input">
                                    </div>
                                    <label class="fg-label">Đang làm việc tại</label>
                                </div>
                                <div class="form-group fg-float">
                                    <div class="fg-line" style="width: 95%">
                                        <input type="text" name="hobby" value="{{ object['hobby'] }}"
                                               class="input-sm form-control fg-input">
                                    </div>
                                    <label class="fg-label">Sở thích</label>
                                </div>
                                <div class="form-group fg-float">
                                    <div class="fg-line" style="width: 95%">
                                        <input type="text" name="facebook" value="{{ object['facebook'] }}"
                                               class="input-sm form-control fg-input">
                                    </div>
                                    <label class="fg-label">Facebook</label>
                                </div>
                                <div class="form-group fg-float">
                                        <label class="radio radio-inline m-r-20">
                                            <input type="radio" value="na" name="sex" {{ object['sex']=='na'?"checked":"" }}>
                                            <i class="input-helper"></i>
                                            N/A
                                        </label>
                                    <label class="radio radio-inline m-r-20">
                                        <input type="radio" value="male"
                                               name="sex"
                                                {% if object['sex'] is defined %}
                                                    {{ object['sex']=='male'?"checked":"" }}
                                                {% else %}
                                                    checked
                                                {% endif %}
                                        >
                                        <i class="input-helper"></i>
                                        Nam
                                    </label>
                                    <label class="radio radio-inline m-r-20">
                                        <input type="radio" value="female" name="sex" {{ object['sex']=='female'?"checked":"" }}>
                                        <i class="input-helper"></i>
                                        Nữ
                                    </label>
                                </div>
                                <div class="form-group fg-float">
                                    <div class="fg-line">
                                        <input type="text" name="description" value="{{ object['description'] }}"
                                               class="input-sm form-control fg-input">
                                    </div>
                                    <label class="fg-label">Mô tả</label>
                                </div>
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
                                    {% for key, value in artistTypes %}
                                        <label class="checkbox checkbox-inline m-r-20">
                                            <input name="type[]" type="checkbox"
                                                   value="{{ key }}"
                                                    {% if object['type'][key] is defined %}
                                                        {{ object['type'][key]==key?"checked":"" }}
                                                    {% else %}
                                                        {{ key=='dj'?"checked":"" }}
                                                    {% endif %}
                                            >
                                            <i class="input-helper"></i>
                                            {{ value }}
                                        </label>
                                    {% endfor %}
                                </div>
                                <div class="fg-line">
                                    <div class="fg-label">Ảnh đại diện</div>
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-preview thumbnail" data-trigger="fileinput"
                                             id="cropbox_source">
                                            <img
                                                    src="{{ object['_id'] <= 0 or object['priavatar'] is empty ?"/img/240x240.png":object['priavatar'] }}"/>
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
                                               value="{{ object['priavatar'] }}"/> -->
                                    </div>
                                </div>
                                <div class="fg-line">
                                    <div class="fg-label">Ảnh banner</div>
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-preview thumbnail" data-trigger="fileinput"
                                             id="cropbox_source_banner">
                                            <img
                                                    src="{{ object['_id'] <= 0 or object['banner'] is empty ?"/img/1160x341.png":object['banner'] }}"/>
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
                                               value="{{ object['banner'] }}"/> -->
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
                        <div id="home22" class="tab-pane" role="tabpanel">
                            <div class="card-body">
                                {{ categoryview }}
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
        // djCropImage.register = false;
    });
    $(document).ready(function () {
        $('.fileinput').on('change.bs.fileinput', function (event, previewId) {
            $(this).find('.edit_crop').click();
        });
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
        //         width: 1190,
        //         height: 350
        //     }
        // });

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