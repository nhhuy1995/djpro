{% include 'layouts/header.volt' %}
<div id="content">
    <div class="bg-cmmusic1">
<section class="error-wrap" style="margin-top:10px; ">
    <div class="container">

        <div class="error">
            <div class="shape">
                <div class="big-title"><h1>404</h1></div>
            </div>
            <div class="title">
                <h1><i class="fa fa-exclamation-triangle"></i> Không tìm thấy <span class="light">đường dẫn này.</span></h1>
            </div>
            <p class="subtitle">Bạn có thể truy cập vào trang chủ hoặc sử dụng ô dưới đây để tìm kiếm</p>
        </div>

        <div class="search-error">
            <form method="get" action="/tim-kiem.html" id="form_system">
                <div class="col-md-10 col-sm-8 col-xs-8"><input class="input-error" type="text" name="q" placeholder="--- Tìm kiếm thông tin ---"/></div>
                <div class="col-md-2 col-sm-4 col-xs-4"><input class="btn-error" type="submit" value="Tìm kiếm"></div>
            </form>
            <form method="get" action="//www.google.com/search" id="form_google" style="display: none">
                <div class="col-md-10 col-sm-8 col-xs-8"><input class="input-error" type="text" name="q" placeholder="--- Tìm kiếm thông tin ---"/></div>
                <input type="hidden" name="sitesearch" value="{{ config.application.site }}">
                <div class="col-md-2 col-sm-4 col-xs-4"><input class="btn-error" type="submit" value="Tìm kiếm"></div>
            </form>
            <div class="select-error">
                <input type="radio" checked name="error_select" onclick="selectError('system')"> Dj.PRO.VN &nbsp;&nbsp;&nbsp;
                <input type="radio" name="error_select" onclick="selectError('google')"> Google
            </div>
        </div>
    </div>
</section><!--End-->
<script>
    function selectError(error) {
        if (error == 'system') {
            $('#form_system').show();
            $('#form_google').hide();
        } else {
            $('#form_system').hide();
            $('#form_google').show();
        }
    }
</script>
    </div>
</div>

{% include 'layouts/footer.volt' %}
