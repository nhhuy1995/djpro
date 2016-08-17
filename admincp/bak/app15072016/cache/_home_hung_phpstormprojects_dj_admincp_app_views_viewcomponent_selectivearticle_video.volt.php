<div class="container">

    <div class="card">
        <div class="card-header">
            <h2>Danh sách chọn lọc Video</h2>

            
        </div>

        <div class="card-body card-padding">
            <div role="tabpanel">
                <ul role="tablist" class="tab-nav" style="overflow: hidden;" tabindex="1">
                    <li class="active"><a data-toggle="tab" role="tab" aria-controls="home11" href="#home11"
                                          aria-expanded="true">Thông tin chung</a></li>
                </ul>
                <form method="post" action="">
                    <input name="id" value="<?php echo $object['_id']; ?>" type="hidden">
                    <input name="redirect" value="<?php echo $backlink; ?>" type="hidden">

                    <div class="tab-content">
                        <div class="card">
                            <div class="listview lv-bordered lv-lg">
                                <div class="lv-header-alt">
                                    <h2 class="lvh-label hidden-xs">SlideShow</h2>
                                </div>
                                <div class="lv-body">
                                    <div class="lv-body">
                                        <div class="sortable" id="listOfNewInSlide">
                                            <?php foreach ($slideshow as $newsDetail) { ?>
                                                <div class="lv-item media">
                                                    <div class="checkbox pull-left">
                                                        <label>
                                                            <input name="slideshow[]" type="hidden" class="newsIdInSlide" value= "<?php echo $newsDetail['_id']; ?>">
                                                            <input type="checkbox" value="" checked="" class="enableNewsInSlide">
                                                            <i class="input-helper"></i>
                                                        </label>
                                                    </div>
                                                    <div class="pull-left">
                                                        <img alt="" src="<?php echo $newsDetail['priavatar']; ?>" class="lv-img-sm">
                                                    </div>
                                                    <div class="media-body">
                                                        <div class="lv-title"><?php echo $newsDetail['name']; ?></div>

                                                        <ul class="lv-attrs">
                                                            <li>Date Created: <?php echo date('d-m-Y', $newsDetail['datecreate']); ?></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group m-t-10">
                            <div class="fg-line">
                                <input type="text" class="form-control newLinkToAdd" placeholder="Gõ tiêu đề của tin tức vào đây..." onkeyup="getcategory(this);">
                            </div>
                            <div class="suggestion" style="display: none;">
                                <div onclick="$(this).parent().hide()" class="closebtn"><i class="md md-close"></i></div>
                                <ul id="sugges_data">
                                </ul>
                            </div>
                        </div>
                        <div class="form-group fg-float margin-top-10">
                            <button class="btn btn-primary waves-effect">Chấp nhận</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<script type="text/javascript">
    //    $("#sort").ForceNumericOnly();
    $(".sortable").sortable();
    var t = 400;
    var thread;
    function getcategory(obj) {
        clearTimeout(thread);
        thread = setTimeout(function () {
            var q = $(obj).val();
            var type = "video";
            $('#sugges_data').html('');
            if (q.length) {
                $.get("/incoming/getlistsong", {q: q, type: type}, function (re) {
                    var data = re.data;
                    if (data.length > 0) {
                        data.forEach(function (entry) {
                            var htmlx = '<li onclick="returncategory(this)" +'
                                    + ' data-name="' + _.escape(entry.name) + '"'
                                    + ' data-id="' + entry._id + '"'
                                    + ' data-datecreate="' + entry.datecreate + '"'
                                    + ' data-avatar="' + entry.priavatar + '"'
                                    + '>'
                                    + entry.name
                                    + ' |  ' + entry.datecreate
                                    + '</li>';
                            $('#sugges_data').append(htmlx);
                        });
                        $('.suggestion').show();
                    }
                    else $('.suggestion').hide();
                });
            } else {
                $('#sugges_data').html('');
                $('.suggestion').hide();
            }
        }, t)
    }
    function returncategory(obj) {
        var newTagElem = createNewSlideElem(obj);
        $("#listOfNewInSlide").append(newTagElem);
        $(".newLinkToAdd").val('');
        $('.suggestion').hide();
    }

    function createNewSlideElem(obj) {
        var objJquery = $(obj);
        var elemId = objJquery.attr('data-id');
        var elemAvatar = objJquery.attr('data-avatar');
        var elemName = objJquery.attr('data-name');
        var elemDate = objJquery.attr('data-datecreate');

        var html =  '<div class="lv-item media">'
                + '<div class="checkbox pull-left">'
                + '<label>'
                + '<input name="slideshow[]" type="hidden" class="newsIdInSlide" value= "' + elemId + '">'
                + '<input type="checkbox" value="" class="enableNewsInSlide" checked="">'
                + '<i class="input-helper"></i>'
                + '</label>'
                + '</div>'
                + '<div class="pull-left">'
                + '<img alt="" src="' + elemAvatar + '" class="lv-img-sm">'
                + '</div>'
                + '<div class="media-body">'
                + '<div class="lv-title">'
                + elemName
                + '</div>'
                + '<ul class="lv-attrs">'
                + '<li> Tạo ngày:  ' + elemDate + '</li>'
                + '</ul>'
                + '</div>'
                + '</div>';
        return html;
    }

    $('.hidden_on_click').click(function () {
        $(this).parent().remove();
    });

    $('body').on('change', '.enableNewsInSlide', function() {
        var obj = $(this);
        if (!this.checked)
            obj.siblings('.newsIdInSlide').attr('disabled', 'disabled');
        else
            obj.siblings('.newsIdInSlide').removeAttr('disabled');
    });
</script>

