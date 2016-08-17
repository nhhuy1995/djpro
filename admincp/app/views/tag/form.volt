<div class="container">

    <div class="card">
        <div class="card-header">
            <h2>Thông tin tag</h2>

            <p class="p-t-10"><a href="{{ backlink }}"><i class="md md-arrow-back"></i>Thoát</a></p>
        </div>

        <div class="card-body card-padding">
            <div role="tabpanel">
                <ul role="tablist" class="tab-nav" style="overflow: hidden;" tabindex="1">
                    <li class="active"><a data-toggle="tab" role="tab" aria-controls="home11" href="#home11"
                                          aria-expanded="true">Thông tin chung</a></li>
                </ul>
                <form method="post" action="/tag/formprocess">
                    <input name="id" value="{{ object['_id'] }}" type="hidden">
                    <input name="redirect" value="{{ backlink }}" type="hidden">

                    <div class="tab-content">
                        <div id="home11" class="tab-pane active" role="tabpanel">
                            <div class="card-body card-padding">
                                <div class="form-group fg-float">
                                    <div class="fg-line" style="width: 95%">
                                        <input type="text" name="name" value="{{ object['name'] }}"
                                               class="input-sm form-control fg-input" id="tag_input_name">
                                    </div>
                                    <label class="fg-label">Tên tag</label>
                                    {#<i class="md md-check" style="float:right"></i>#}
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
    $(function() {
        var checkTagExists = new djCheckElemExists();
        checkTagExists.init({
            elem:  "#tag_input_name",
            data: function() {
                return {
                    q: $("#tag_input_name").val(),
                    type: 'tag'
                }
            },
            notExistsStatus: 1
        });
    });
</script>

