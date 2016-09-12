<div class="container">
    <div class="card">
        <img src="/img/ads/desktop_main_page_header.jpg" class="ads-full-width">
    </div>
    <div class="card">
        <div class="card-header">
            <h2>Vị trí 1: Hiển thị ở mọi trang, với giao diện máy tính</h2>
    
            <ul class="actions">
                <li>
                    <a href="#ads-edit-popup" data-toggle="modal" class="ads-button-edit" data-ads-id="{{ ads.HOME_DESKTOP_TOP }}">
                        <i class="md md-settings"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-8">
            <div class="">
                <img src="/img/ads/desktop_main_page_content_left.jpg" class="ads-full-width">
            </div>
        </div>
    
        <div class="col-sm-4">
            <div class="card">
                <div class="card-header">
                    <h2>Vị trí 2: Bên phải</h2>
    
                    <ul class="actions">
                        <li>
                            <a href="#ads-edit-popup" data-toggle="modal" class="ads-button-edit" data-ads-id="{{ ads.HOME_DESKTOP_RIGHT_1 }}">
                                <i class="md md-settings"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h2>Vị trí 3: Bên phải</h2>
    
                    <ul class="actions">
                        <li>
                            <a href="#ads-edit-popup" data-toggle="modal" class="ads-button-edit" data-ads-id="{{ ads.HOME_DESKTOP_RIGHT_2 }}">
                                <i class="md md-settings"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h2>Vị trí 4: Bên phải</h2>
    
                    <ul class="actions">
                        <li>
                            <a href="#ads-edit-popup" data-toggle="modal" class="ads-button-edit" data-ads-id="{{ ads.HOME_DESKTOP_RIGHT_3 }}">
                                <i class="md md-settings"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ads-edit-popup" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Chỉnh sửa nội dung quảng cáo</h4>
            </div>
            <div class="modal-body">
                <div style="text-align: center" id="ads-loading">
                    <img src="/img/ads/ring_loading.gif">
                </div>
                <input type="hidden" name="" id="ads-edit-id">
                <div class="form-group ads-edit-content">
                    <div class="fg-line">
                        <label>Thành phần Html của quảng cáo đang hiển thị</label>
                    </div>
                    <div class="fg-line">
                        <textarea class="ads-edit-textarea" placeholder="Thành phần Html của quảng cáo đang hiển thị" id="ads-current-content"></textarea>
                    </div>
                </div>
                <div class="form-group ads-edit-content">
                    <div class="fg-line">
                        <label>Thành phần Html của quảng cáo (Nháp)</label>
                    </div>
                    <div class="fg-line">
                        <textarea class="ads-edit-textarea" placeholder="Thành phần Html của quảng cáo (Nháp)" id="ads-draft-content"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer ads-edit-content">
                <button class="btn btn-info waves-effect pull-left" id="ads-update-button">Update</button>
                <button class="btn btn-default waves-effect pull-right" id="ads-edit-cancel-button" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<script>
$(function() {
    var dj_ads = {
        button_sl: '.ads-button-edit',
        current_content_sl: '#ads-current-content',
        draft_content_sl: '#ads-draft-content',
        update_content_sl: '#ads-update-button',
        cancel_update_content_sl: '#ads-edit-cancel-button',
        loading_sl: '#ads-loading',
        edit_content_sl: '.ads-edit-content',
        ads_id_sl: '#ads-edit-id',

        get_content_url: '/incoming/getadscontent',
        update_content_url: '/incoming/updateadscontent'

    }

    $(dj_ads.button_sl).on('click', function() {
        var ads_id = $(this).attr('data-ads-id');
        var data = {
            'ads_id': ads_id
        };
        $(dj_ads.loading_sl).show();
        $(dj_ads.edit_content_sl).hide();

        setTimeout(function() {$.ajax({
            url: dj_ads.get_content_url,
            method: 'post',
            data: data,
            success: function(res) {
                if (res.status == 200) {
                    var mes = res.data;
                    $(dj_ads.current_content_sl).val(mes.current_content);
                    $(dj_ads.draft_content_sl).val(mes.draft_content);
                    $(dj_ads.ads_id_sl).val(ads_id);

                    $(dj_ads.loading_sl).hide();
                    $(dj_ads.edit_content_sl).show();
                } else {
                    $(dj_ads.cancel_update_content_sl).click();
                    alert('Đã có lỗi xảy ra, vui lòng thử lại sau');
                }
            }
        })}, 1000);
    });

    $(dj_ads.update_content_sl).on('click', function () {
        var ads_id = $(dj_ads.ads_id_sl).val();
        var current_content = $(dj_ads.current_content_sl).val();
        var draft_content = $(dj_ads.draft_content_sl).val();
        var data = {
            'ads_id': ads_id,
            'current_content': current_content,
            'draft_content': draft_content
        };

        $.ajax({
            url: dj_ads.update_content_url,
            method: 'post',
            data: data,
            success: function(res) {
                if (res.status == 200) {
                    alert('Cập nhật thành công');
                } else {
                    alert('Đã có lỗi xảy ra, vui lòng thử lại sau');
                }
            }
        })
    });
});
</script>

