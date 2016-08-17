<div class="container">

    <div class="card">
        <div class="card-header">
            <h2>Danh sách Chủ đề nổi bật</h2>

            {#<p class="p-t-10"><a href="{{ backlink }}"><i class="md md-arrow-back"></i>Thoát</a></p>#}
        </div>

        <div class="card-body card-padding">
            <div role="tabpanel">
                <ul role="tablist" class="tab-nav" style="overflow: hidden;" tabindex="1">
                    <li class="active"><a data-toggle="tab" role="tab" aria-controls="home11" href="#home11"
                                          aria-expanded="true">Thông tin chung</a></li>
                </ul>
                <form method="post" action="">
                    <div class="tab-content">
                        <div class="card">
                            <div class="listview lv-bordered lv-lg">
                                <div class="lv-header-alt">
                                    <h2 class="lvh-label hidden-xs">Category</h2>
                                </div>
                                <div class="lv-body">
                                    <div class="lv-body">
                                        <div class="sortable" id="listOfNewInSlide">
                                            {% for newsDetail in listcategory %}
                                                <div class="lv-item media">
                                                    <div class="checkbox pull-left">
                                                        <label>
                                                            <input name="listcategoryid[]" type="hidden"
                                                                   class=""
                                                                   value="{{ newsDetail['_id'] }}">
                                                            <input type="checkbox" name="categoryid[]" value="{{ newsDetail['_id'] }}"  checked=""
                                                                   class="enableNewsInSlide">
                                                            <i class="input-helper"></i>
                                                            {{ newsDetail['sort'] }}
                                                        </label>
                                                    </div>
                                                    <div class="media-body">
                                                        <div class="lv-title">{{ newsDetail['name'] }}</div>

                                                        <ul class="lv-attrs">
                                                            <li>Date
                                                                Created: {{ date('d-m-Y',newsDetail['datecreate']) }}</li>

                                                        </ul>
                                                    </div>
                                                </div>
                                            {% endfor %}
                                        </div>
                                    </div>
                                </div>
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
    $(".sortable").sortable();
</script>

