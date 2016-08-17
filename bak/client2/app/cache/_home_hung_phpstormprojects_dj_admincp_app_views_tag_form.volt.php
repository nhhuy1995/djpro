<div class="container">

    <div class="card">
        <div class="card-header">
            <h2>Thông tin tag</h2>
            <p class="p-t-10"><a href="<?php echo $backlink; ?>" ><i class="md md-arrow-back"></i>Thoát</a></p>
        </div>

        <div class="card-body card-padding">
            <div role="tabpanel">
                <ul role="tablist" class="tab-nav" style="overflow: hidden;" tabindex="1">
                    <li class="active"><a data-toggle="tab" role="tab" aria-controls="home11" href="#home11"
                                          aria-expanded="true">Thông tin chung</a></li>
                </ul>
                <form method="post" action="/tag/formprocess">
                    <input name="id" value="<?php echo $object['_id']; ?>" type="hidden">
                    <input name="redirect" value="<?php echo $backlink; ?>" type="hidden">

                    <div class="tab-content">
                        <div id="home11" class="tab-pane active" role="tabpanel">
                            <div class="card-body card-padding">

                                <div class="form-group fg-float">
                                    <div class="fg-line">
                                        <input type="text" name="name" value="<?php echo $object['name']; ?>" class="input-sm form-control fg-input"  onkeyup="getcategory(this);">
                                    </div>
                                    <label class="fg-label">Tên tag</label>
                                    <div class="suggestion" style="display: none;">
                                        <div onclick="$(this).parent().hide()" class="closebtn"><i class="md md-close"></i></div>
                                        <ul id="sugges_data">
                                        </ul>
                                    </div>
                                </div>
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

<script type="text/javascript">
    //    $("#sort").ForceNumericOnly();
    var t = 400;
    var thread;
    function getcategory(obj) {
        clearTimeout(thread);
        thread = setTimeout(function () {
            var q = $(obj).val();
            var type = $('#type').val();
            $('#sugges_data').html('');
            if (q.length) {
                $.get("/incoming/getlisttag", {q: q}, function (re) {
                    var data = re.data;
                    if (data.length > 0) {
                        data.forEach(function (entry) {
                            var htmlx = '<li onclick="returncategory(this)" data-name="' + entry.name + '" data-id="' + entry._id + '">' + entry.name + '</li>';
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
        $('#parentinput').val($(obj).attr('data-id'));
        $('#parentname').html($(obj).text());
        $('#parentnameinput').val($(obj).attr('data-name'));
        $('.suggestion').hide();
    }

    function hiddenonclick() {
        $('.hidden_on_click').click(function () {
            $(this).parent().remove();
        })
    }

</script>

