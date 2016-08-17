<div class="container">

    <div class="card">
        <div class="card-header">
            <h2>Thông tin tag</h2>

            <p class="p-t-10"><a href="<?php echo $backlink; ?>"><i class="md md-arrow-back"></i>Thoát</a></p>
        </div>

        <div class="card-body card-padding">
            <div role="tabpanel">
                <ul role="tablist" class="tab-nav" style="overflow: hidden;" tabindex="1">
                    <li class="active">
                        <a data-toggle="tab" role="tab" aria-controls="home11" href="#home11" aria-expanded="true">
                            Thông tin chung
                        </a>
                    </li>
                    <li><a data-toggle="tab" role="tab" aria-controls="home22" href="#home22">Sắp xếp chi tiết </a></li>
                </ul>
                    <input name="_id" value="<?php echo $settingObj['_id']; ?>" type="hidden" id="input_menu_id">
                    <input name="redirect" value="<?php echo $backlink; ?>" type="hidden">

                    <div class="tab-content">
                        <div id="home11" class="tab-pane active" role="tabpanel">
                            <div class="card-body">
                                <div class="form-group fg-float">
                                    <div class="fg-line">
                                        <input type="text" name="name" value="<?php echo $settingObj['name']; ?>"
                                               class="input-sm form-control fg-input" required id="input_menu_name">
                                    </div>
                                    <label class="fg-label">Tiêu đề</label>
                                </div>

                                <div class="form-group fg-float">
                                    <div class="fg-line">
                                        <input type="text" name="name" value="<?php echo $settingObj['key']; ?>"
                                               class="input-sm form-control fg-input" required id="input_menu_key">
                                    </div>
                                    <label class="fg-label">Key lưu trữ trong database</label>
                                    <div class="m-t-10 pull-right c-red">Key lưu trữ trong database. Suy nghĩ kỹ trước khi chỉnh sửa</div>
                                </div>

                                <div class="form-group fg-float">
                                    <div class="fg-line">
                                        <input type="text" name="name" value="<?php echo $settingObj['description']; ?>"
                                               class="input-sm form-control fg-input" required id="input_menu_description">
                                    </div>
                                    <label class="fg-label">Mô tả</label>
                                </div>
                            </div>
                        </div>
                        <div id="home22" class="tab-pane" role="tabpanel">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8 listview ">
                                        <h4 class="">List Item</h4>
                                        <div class="lv-body">
                                            <div class="lv-body">
                                                <ol class="sortable" id="listOfMenuItem" class="lv-item media"><?php $this->_macros['addMenuItem'] = function($__p = null) { if (isset($__p[0])) { $value = $__p[0]; } else { if (isset($__p["value"])) { $value = $__p["value"]; } else {  throw new \Phalcon\Mvc\View\Exception("Macro 'addMenuItem' was called without parameter: value");  } }  ?>
                                                        <?php if ($value['catid'] != '') { ?>
                                                            <?php $elemType = 'category'; ?>
                                                        <?php } else { ?>
                                                            <?php $elemType = 'link'; ?>
                                                        <?php } ?>
                                                        <li id="menuItem_<?php echo $value['item_id']; ?>" class="menu-item-in-list">
                                                            <div class="lv-item media">
                                                                <div class="media-body">
                                                                    <div class="lv-title"><?php echo $value['title']; ?></div>
                                                                    <div class="lv-actions actions">
                                                                        <a aria-expanded="true" href="javascript:void(0)" onclick="displayPopUpEdit(this)" >
                                                                            <i class="md md-settings"></i>
                                                                        </a>
                                                                        <a aria-expanded="true" href="javascript:void(0)" onclick="removeMenuItem(this)" >
                                                                            <i class="md md-delete"></i>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <span data-type="<?php echo $value['type']; ?>" data-link="<?php echo $value['link']; ?>" data-catid="<?php echo $value['cat_id']; ?>" data-indexmenu="<?php echo $value['item_id']; ?>" data-title="<?php echo $value['title']; ?>"></span>
                                                            <?php if (isset($value['child'])) { ?>
                                                                <ol>
                                                                    <?php foreach ($value['child'] as $subvalue) { ?>
                                                                        <?php echo $this->callMacro('addMenuItem', array($subvalue)); ?>
                                                                    <?php } ?>
                                                                </ol>
                                                            <?php } ?>
                                                        </li><?php }; $this->_macros['addMenuItem'] = \Closure::bind($this->_macros['addMenuItem'], $this); ?>
                                                    <?php foreach ($settingObj['value'] as $item) { ?>
                                                        <?php echo $this->callMacro('addMenuItem', array($item)); ?>
                                                    <?php } ?>
                                                </ol>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 m-b-25 p-relative" id="toolbarRightTab">
                                        
                                        <div role="tabpanel">
                                            <ul role="tablist" class="tab-nav" style="overflow: hidden;" tabindex="2" id="tablistdetail2">
                                                <li class="active">
                                                    <a data-toggle="tab" role="tab" aria-controls="addItemTab1" href="#addItemLink" aria-expanded="true">
                                                        Add Link
                                                    </a>
                                                </li>
                                                <li><a data-toggle="tab" role="tab" aria-controls="addItemCategory" href="#addItemCategory">Add Category</a></li>
                                            </ul>
                                            <div class="tab-content">
                                                <div id="addItemLink" class="tab-pane active" role="tabpanel">
                                                    <div class="form-group m-t-10">
                                                        <div class="fg-line">
                                                            <input type="text" id="inputTitleCustomLink" class="form-control" placeholder="Gõ tiêu đề của link">
                                                        </div>
                                                        <div class="fg-line m-t-5">
                                                            <input type="text" id="inputRealCustomLink" class="form-control" placeholder="Nhập đường link">
                                                        </div>
                                                        <input type="hidden" name="menuItemId" id="inputMenuItemId">
                                                        <a id="buttonAddLink" onclick="addCustomLinkMenu(this)" href="javascript:void(0)" class="btn bgm-teal pull-right m-t-5 waves-effect"> Add link To Menu</a>
                                                    </div>
                                                </div>
                                                <div id="addItemCategory" class="tab-pane" role="tabpanel">
                                                    <div class="form-group m-t-10">
                                                        <div class="fg-line">
                                                            <input type="text" onkeyup="getcategoryToAdd(this);" placeholder="Gõ tiêu đề của tin tức vào đây..." class="form-control input-name-category">
                                                        </div>
                                                        <div style="display: none; width: 90%;" class="suggestion">
                                                            <div class="closebtn" onclick="$(this).parent().hide()"><i class="md md-close"></i></div>
                                                            <ul class="sugges_data">
                                                            </ul>
                                                        </div>
                                                        <a onclick="addCategoryToMenu(this)" href="javascript:void(0)" class="btn bgm-teal pull-right m-t-5 waves-effect"> Add Category To Menu</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group fg-float margin-top-10" style="display: inline;">
                        <a class="btn btn-primary waves-effect" href="javascript:void(0)" onclick="updateMainMenu()">Chấp nhận</a>
                    </div>
                    <div class="clearfix"></div>
            </div>

        </div>
    </div>
</div>
<script type="text/template" id="templateMenuItem">
    <li id="menuItem_<%= indexMenu %>" class="menu-item-in-list">
        <div class="lv-item media">
            <div class="media-body">
                <div class="lv-title"><%= title %></div>
                <div class="lv-actions actions">
                    <a aria-expanded="true" href="javascript:void(0)" onclick="displayPopUpEdit(this)" >
                        <i class="md md-settings"></i>
                    </a>
                    <a aria-expanded="true" href="javascript:void(0)" onclick="removeMenuItem(this)" >
                        <i class="md md-delete"></i>
                    </a>
                </div>
            </div>
        </div>
        <span data-type="<%= type %>" data-link="<%= link %>" data-catid="<%= catid %>" data-indexmenu="<%= indexMenu %>" data-title="<%= title %>"></span>
    </li>
</script>
<script type="text/template" id="popupEditLinkItem">
    <div class="pop-up-edit-item">
        <div class="form-group m-t-10">
            <div class="fg-line">
                <input type="text" placeholder="Gõ tiêu đề của link" class="form-control" id="inputEditTitleLinkItem" value="<%= title %>">
            </div>
            <div class="fg-line m-t-5">
                <input type="text" placeholder="Nhập đường link" class="form-control" id="inputEditUrlLinkItem" value="<%= link %>">
            </div>
            <input type="hidden" id="inputMenuItemId" name="menuItemId">
            <a class="btn bgm-red pull-right m-t-10 waves-effect waves-effect pull-left" href="javascript:void(0)"
               onclick="cancelUpdate(this)">Cancel</a>
            <a class="btn bgm-teal pull-right m-t-10 waves-effect waves-effect" href="javascript:void(0)"
               onclick="updateLinkMenuItem(this)">Update</a>
            <span data-type="<%= type %>" data-link="<%= link %>" data-catid="<%= catid %>" data-indexmenu="<%= indexMenu %>" data-title="<%= title %>"></span>
        </div>
    </div>
</script>
<script type="text/template" id="popupEditCatItem">
    <div class="pop-up-edit-item">
        <div class="form-group m-t-10">
            <div class="fg-line">
                <input type="text" onkeyup="getcategoryToAdd(this);" placeholder="Gõ tiêu đề của tin tức vào đây..." class="form-control input-name-category" value="<%= title %>">
            </div>
            <div style="display: none; width: 90%;" class="suggestion">
                <div class="closebtn" onclick="$(this).parent().hide()"><i class="md md-close"></i></div>
                <ul class="sugges_data">
                </ul>
            </div>
            <a class="btn bgm-red pull-right m-t-10 waves-effect waves-effect pull-left" href="javascript:void(0)"
               onclick="cancelUpdate(this)">Cancel</a>
            <a class="btn bgm-teal pull-right m-t-10 waves-effect waves-effect" href="javascript:void(0)"
               onclick="updateCatMenuItem(this)">Update</a>
            <span data-type="<%= type %>" data-link="<%= link %>" data-catid="<%= catid %>" data-indexmenu="<%= indexMenu %>" data-title="<%= title %>"></span>
        </div>
    </div>
</script>
<script src="/js/jquery.nestedsort.min.js"></script>
<script type="text/javascript">

    var t = 400;
    var thread;
    var indexMenu = -1;
    var templateMenuItem = _.template(
        $("script#templateMenuItem").html()
    );
    var templateEditCategoryItem = _.template(
        $("script#popupEditCatItem").html()
    );
    var templateEditLinkItem = _.template(
        $("script#popupEditLinkItem").html()
    );

    $(function () {
        $("ol.sortable").nestedSortable({
            handle: 'div',
            items: 'li',
            toleranceElement: '> div'
        });
        $(".menu-item-in-list").each(function(elem) {
            var elemIndex = $(this).find("span")
                    .first().attr('data-indexmenu');
            elemIndex = parseInt(elemIndex);
           if (elemIndex > indexMenu)
                indexMenu = elemIndex;
        });
    });
    /*** Get Category *****************************************/
//    function getCategoryInEdit(obj) {
//        getcategory(obj, suggestWrapper, 'returncategoryToUpdate');
//    }
    function getcategoryToAdd(obj) {
        var suggestWrapper = $(obj).parents('.form-group')
                .find('.sugges_data');
        getcategory(obj, suggestWrapper, 'returncategory');

    }
    function getcategory(obj, suggestWrapper, callback) {
        clearTimeout(thread);
        thread = setTimeout(function () {
            var q = $(obj).val();
            var type = $('#type').val();
            suggestWrapper.html('');
            if (q.length) {
                $.get("/incoming/getlistcategory", {q: q}, function (re) {
                    var data = re.data;
                    if (data.length > 0) {
                        data.forEach(function (entry) {
                            var htmlx = '<li onclick="' + callback +'(this)" data-name="' + entry.name + '" data-id="' + entry._id + '">' + entry.name + '</li>';
                            suggestWrapper.append(htmlx);
                        });
                        suggestWrapper.parent().show();
                    }
                    else suggestWrapper.parent().hide();
                });
            } else {
                suggestWrapper.html('');
                suggestWrapper.parent().hide();
            }
        }, t)
    }

    /*** End Get Category *****************************************/

    /*** Add Category To Menu *************************************/
    function returncategory(obj) {
        var objJquery = $(obj);
        var inputObj = objJquery.parents('.form-group')
                .find('.input-name-category');
        inputObj.attr("data-catId", objJquery.attr('data-id'));
        inputObj.val(objJquery.attr('data-name'));
        var dataItem = objJquery.parents('.form-group').find('span');
        if (dataItem.length)
            dataItem.attr('data-catid', objJquery.attr('data-id'));
        $('.suggestion').hide();
    }

    function addCategoryToMenu(obj) {
        var inputObj = $(obj).parents('.form-group')
                .find('.input-name-category');
        var title = inputObj.val(),
                catId = inputObj.attr('data-catid');
        addItemToMenu(title, title, catId);
    }
    /*** End Add Category To Menu *************************************/

    /*** Add Custom Link To Menu *************************************/
    function addCustomLinkMenu(obj) {
        var title = $("#inputTitleCustomLink").val();
        var link = $("#inputRealCustomLink").val();
        addItemToMenu(title, link);
    }
    /*** End Add Custom Link To Menu *************************************/

    /*** Edit Menu Item ***************************************/
    function updateCatMenuItem(obj) {
        var objJquery = $(obj);
        var title = objJquery.parents('.form-group').
                find('.input-name-category').val();
        var dataItem = objJquery.siblings('span').first();
        updateMenuItem(
            dataItem.attr('data-indexmenu'),
            title,
            title,
            dataItem.attr('data-catid')
        );
    }

    function updateLinkMenuItem(obj) {
        var objJquery = $(obj);
        var title = $("#inputEditTitleLinkItem").val();
        var link = $("#inputEditUrlLinkItem").val();
        var dataItem = objJquery.siblings('span').first();
        updateMenuItem(
            dataItem.attr('data-indexmenu'),
            title,
            link,
            dataItem.attr('data-catid')
        );
    }
    /*** End Edit Menu Item ***************************************/

    /*** Common *************************************/
    function displayPopUpEdit(obj) {
        var objJquery = $(obj);
        var popUpObj = objJquery.parents(".media-body")
                .find('.pop-up-edit-item');
        if (popUpObj.length) {
            popUpObj.remove();
            return;
        }
        $(".pop-up-edit-item").remove();
        var dataItem = objJquery.parents('li').first()
                .find('span');
        var data = {
            type: dataItem.attr('data-type'),
            catid : dataItem.attr('data-catid'),
            indexMenu: dataItem.attr('data-indexmenu'),
            link : dataItem.attr('data-link'),
            title : dataItem.attr('data-title')
        };
        if (data.catid.length)
            objJquery.parents(".media-body")
                    .append(templateEditCategoryItem(data));
        else
            objJquery.parents(".media-body")
                    .append(templateEditLinkItem(data));
    }
    function updateMenuItem(indexMenu, title, link, catid) {
        if (catid == null) {
            catid = "";
            type = "link";
        } else {
            type = "category";
        }
        var data = {
            catid : catid,
            indexMenu: indexMenu,
            link : link,
            title : title,
            type : type
        };
        $("#menuItem_" + indexMenu).replaceWith(templateMenuItem(data));
    }
    function addItemToMenu(title, link, catid, type) {
        indexMenu++;
        if (catid == null) {
            catid = "";
            type = "link";
        } else {
            type = "category";
        }
        var data = {
            catid : catid,
            indexMenu: indexMenu,
            link : link,
            title : title,
            type : type
        };
        $("#listOfMenuItem").append(templateMenuItem(data));
    }

    function cancelUpdate(obj) {
        if ($(obj).parents(".pop-up-edit-item").length)
            $(obj).parents(".pop-up-edit-item").remove();
    }
    function removeMenuItem(obj) {
        $(obj).parents('.menu-item-in-list').remove();
    }
    $('.hidden_on_click').click(function () {
        $(this).parent().remove();
    });
    /*** End Common *************************************/



    function updateMainMenu() {
        var listItemInArray = $('ol.sortable').nestedSortable('toArray', {startDepthCount: 0});
        listItemInArray.shift();
        var listData = [];
        listItemInArray.forEach(function(elem){
            var objJquery = $("#menuItem_" + elem.item_id).find("span").first();
            listData.push({
                item_id: elem.item_id,
                parent_id: elem.parent_id,
                depth: elem.depth,
                cat_id: objJquery.attr('data-catid'),
                link: objJquery.attr('data-link'),
                title: objJquery.attr('data-title')
            });
        });
        var dataPost = {
            _id: $("#input_menu_id").val(),
            name: $("#input_menu_name").val(),
            key: $("#input_menu_key").val(),
            description: $("#input_menu_description").val(),
            listData: listData
        }
        $.post('/viewcomponent/listmenuform', dataPost, function (data) {
            window.location.href = "/viewcomponent/listmenuindex";
        });
    }

</script>

