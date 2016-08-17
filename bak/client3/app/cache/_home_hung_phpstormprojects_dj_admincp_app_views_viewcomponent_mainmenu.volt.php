<div class="container">

    <div class="card">
        <div class="card-header">
            <h2>Thông tin tag</h2>

            <p class="p-t-10"><a href="<?php echo $backlink; ?>"><i class="md md-arrow-back"></i>Thoát</a></p>
        </div>

        <div class="card-body card-padding">
            <div role="tabpanel">
                <ul role="tablist" class="tab-nav" style="overflow: hidden;" tabindex="1">
                    <li class="active"><a data-toggle="tab" role="tab" aria-controls="home11" href="#home11"
                                          aria-expanded="true">Thông tin chung</a></li>
                </ul>

                    <input name="redirect" value="<?php echo $backlink; ?>" type="hidden">

                    <div class="row m-t-10">
                        <div class="col-sm-4 m-b-25">
                            <div aria-multiselectable="true" role="tablist" id="accordionRed" data-collapse-color="red"
                                 class="panel-group">
                                <div class="panel panel-collapse">
                                    <div role="tab" class="panel-heading">
                                        <h4 class="panel-title">
                                            <a aria-expanded="false" href="#accordionRed-one"
                                               data-parent="#accordionRed" data-toggle="collapse" class="collapsed">
                                                Tùy chỉnh đường link
                                            </a>
                                        </h4>
                                    </div>
                                    <div role="tabpanel" class="collapse" id="accordionRed-one" aria-expanded="false"
                                         style="height: 0px;">
                                        <div class="panel-body">
                                            <div class="form-group m-t-10">
                                                <div class="fg-line">
                                                    <input type="text"  placeholder="Gõ tiêu đề của link" class="form-control" id="inputTitleCustomLink">
                                                </div>
                                                <div class="fg-line m-t-5">
                                                    <input type="text"  placeholder="Nhập đường link" class="form-control" id="inputRealCustomLink">
                                                </div>
                                                <input type="hidden" id="inputMenuItemId" name="menuItemId">
                                                <a class="btn bgm-teal pull-right m-t-5" href="javascript:void(0)" onclick="addCustomLinkMenu(this)" id="buttonAddLink"> Add link To Menu</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-collapse">
                                        <div role="tab" class="panel-heading active">
                                            <h4 class="panel-title">
                                                <a aria-expanded="true" href="#accordionRed-two"
                                                   data-parent="#accordionRed" data-toggle="collapse" class="">
                                                    Thêm category
                                                </a>
                                            </h4>
                                        </div>
                                        <div role="tabpanel" class="collapse in" id="accordionRed-two"
                                             aria-expanded="true" style="">
                                            <div class="panel-body">
                                                <div class="form-group m-t-10">
                                                    <div class="fg-line">
                                                        <input type="text" class="form-control newCategoryToAdd" placeholder="Gõ tiêu đề của tin tức vào đây..." onkeyup="getcategoryToAdd(this);">
                                                    </div>
                                                    <div class="suggestion" style="display: none; width: 90%;">
                                                        <div onclick="$(this).parent().hide()" class="closebtn"><i class="md md-close"></i></div>
                                                        <ul id="sugges_data">
                                                        </ul>
                                                    </div>
                                                    <a class="btn bgm-teal pull-right m-t-5" href="javascript:void(0)" onclick="addCategoryToMenu()"> Add Category To Menu</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                        <div class="col-sm-8 m-b-25">
                            <form method="post" action="">
                                <div aria-multiselectable="true" role="tablist"
                                     data-collapse-color="teal" class="panel-group">
                                    <ol class="sortable" id="listOfMenuItem"><?php $this->_macros['addMenuItem'] = function($__p = null) { if (isset($__p[0])) { $value = $__p[0]; } else { if (isset($__p["value"])) { $value = $__p["value"]; } else {  throw new \Phalcon\Mvc\View\Exception("Macro 'addMenuItem' was called without parameter: value");  } }  ?>
                                            <?php if ($value['catid'] != '') { ?>
                                                <?php $elemType = 'category'; ?>
                                            <?php } else { ?>
                                                <?php $elemType = 'link'; ?>
                                            <?php } ?>
                                            <li id="menuItemWrapper_<?php echo $value['item_id']; ?>">
                                                <div class="panel panel-collapse menuItem" data-type="<?php echo $elemType; ?>">
                                                    <div class="panel-heading" role="tab">
                                                        <h4 class="panel-title">
                                                            <a aria-expanded="false" href="#accordionTeal-<?php echo $value['item_id']; ?>" data-parent="#tablistMenu" class="collapsed menuItemTitle" data-toggle="collapse"   data-reallink="<?php echo $value['link'] ?>" onclick="editExistsItem(this)" data-catid="<?php echo $value['cat_id']; ?>" data-title="<?php echo $value['title']; ?>" data-menuItemId="<?php echo $value['item_id']; ?>">
                                                                <?php echo $value['title']; ?>
                                                            </a>
                                                        </h4>
                                                    </div>
                                                    <div id="accordionTeal-<?php echo $value['item_id']; ?>" class="collapse" roleh ="tabpanel">
                                                        <div class="panel-body" data-type="<?php echo $elemType; ?>">
                                                            <span class="displayCustomLink"><?php echo $value['link']; ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php if (isset($value['child'])) { ?>
                                                <ol>
                                                <?php foreach ($value['child'] as $subvalue) { ?>
                                                    <?php echo $this->callMacro('addMenuItem', array($subvalue)); ?>
                                                <?php } ?>
                                                </ol>
                                            <?php } ?>
                                            </li><?php }; $this->_macros['addMenuItem'] = \Closure::bind($this->_macros['addMenuItem'], $this); ?>
                                        <?php foreach ($mainMenu as $item) { ?>
                                            <?php echo $this->callMacro('addMenuItem', array($item)); ?>
                                        <?php } ?>
                                    </ol>
                                </div>
                                <div class="form-group fg-float margin-top-10 pull-right">
                                    <a class="btn btn-primary waves-effect" href="javascript:void(0)" onclick="updateMainMenu()">Chấp nhận</a>
                                </div>
                            </form>
                        </div>
                    </div>
            </div>

        </div>
    </div>
</div>
<script src="/js/jquery.nestedsort.min.js"></script>

<script type="text/template" class="templateMenuItem">
    <li id="menuItemWrapper_<%= indexMenu %>">
        <div class="panel panel-collapse menuItem" data-type="<%= type %>">
            <div class="panel-heading" role="tab">
                <h4 class="panel-title">
                    <a aria-expanded="false" href="#accordionTeal-<%= indexMenu %>" data-parent="#tablistMenu" class="collapsed menuItemTitle" data-toggle="collapse"   data-reallink="<%= link %>" onclick="editExistsItem(this)" data-catid="<%= catid %>" data-title="<%= title %>" data-menuItemId="<%= indexMenu %>">
                        <%= title %>
                    </a>
                </h4>
            </div>
            <div id="accordionTeal-<%= indexMenu %>" class="collapse" roleh ="tabpanel">
                <div class="panel-body" data-type="<%= type %>">
                    <span class="displayCustomLink"><%= link %></span>
                </div>
            </div>
        </div>
    </li>
</script>
<script type="text/template" id="templateEditItem">
    <div class="editTabPanel pull-right">
        <a onclick="displayFormUpdate(this)" href="javascript:void(0)" class="btn bgm-teal m-t-5">Edit</a>
        <a onclick="removeMenuItem(this)" href="javascript:void(0)" class="btn bgm-red m-t-5">Remove</a>
    </div>
</script>
<script type="text/template" id="templateEditLinkedItem">
    <div class="editDetailTabPanel m-l-20">
        <div class="fg-line">
            <input type="text"  placeholder="Gõ tiêu đề của link" class="form-control editDetailTitle" value="<%= title %>">
        </div>
        <div class="fg-line m-t-5">
            <input type="text"  placeholder="Nhập đường link" class="form-control editDetailLink" value="<%= link %>">
        </div>
        <a class="btn bgm-teal m-t-5" href="javascript:void(0)" onclick="updateLinkDetail(this)" > Update Link</a>
        <a class="btn bgm-gray pull-right m-t-5 m-l-10" href="javascript:void(0)" onclick="cancelUpdate(this)" > Cancel</a>
    </div>
</script>
<script type="text/template" id="templateEditCatItem">
    <div class="editDetailTabPanel m-l-20 m-b-10">
        <div class="form-group m-t-10">
            <div class="fg-line">
                <input type="text" onkeyup="getCategoryInEdit(this);" placeholder="Gõ tiêu đề của tin tức vào đây..." class="form-control newCategoryUpdate">
            </div>
            <div style="display: none; width: 80%;" class="suggestion">
                <div class="closebtn" onclick="$(this).parent().hide()"><i class="md md-close"></i></div>
                <ul class="sugges_data"></ul>
            </div>
        </div>
        <a class="btn bgm-teal m-t-5" href="javascript:void(0)" onclick="updateCategoryDetail(this)" > Update Category</a>
        <a class="btn bgm-gray pull-right m-t-5 m-l-10" href="javascript:void(0)" onclick="cancelUpdate(this)" > Cancel</a>
    </div>
</script>
<script type="text/javascript">
    //    $("#sort").ForceNumericOnly();
    $(function () {
        $("ol.sortable").nestedSortable({
            handle: 'div',
            items: 'li',
            toleranceElement: '> div'
        });
    });

    var t = 400;
    var thread;

    function getCategoryInEdit(obj) {
        var suggestWrapper = $(obj).parents('.form-group').find('.sugges_data');
        console.log($(obj),suggestWrapper);
        getcategory(obj, suggestWrapper, 'returncategoryToUpdate');
    }

    function getcategoryToAdd(obj) {
        getcategory(obj, $('#sugges_data'), 'returncategory');

    }

    // Get list of category by keyword
    // obj: inputDom object
    // suggestWrapper: wrapper of suggestion
    // callback: event bind to suggest elem
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
                        console.log(suggestWrapper.parent());
                    }
                    else suggestWrapper.parent().hide();
                });
            } else {
                suggestWrapper.html('');
                suggestWrapper.parent().hide();
            }
        }, t)
    }

    function returncategory(obj) {
        var objJquery = $(obj),
            inputObj = $(".newCategoryToAdd");
        inputObj.attr("data-catId", objJquery.attr('data-id'));
        inputObj.val(objJquery.attr('data-name'));
        $('.suggestion').hide();
    }

    $('.hidden_on_click').click(function () {
        $(this).parent().remove();
    });

    //--------------------   Edit Menu ------------------------------//
    var templateMenuItem = _.template(
        $( "script.templateMenuItem" ).html()
    );
    var templateEditMenuItem = _.template(
        $( "script#templateEditItem" ).html()
    );
    var templateEditDetailMenuItemLink = _.template(
        $( "script#templateEditLinkedItem" ).html()
    );
    var templateEditDetailMenuItemCategory = _.template(
        $( "script#templateEditCatItem" ).html()
    );
    var indexMenu = $(".menuItem").length -1;

    // Add "Linked" item to menu
    function addCustomLinkMenu(obj) {
        var title = $("#inputTitleCustomLink").val();
        var link = $("#inputRealCustomLink").val();
        addItemToMenu(title, link);
    }

    // Add "Category" item to menu
    function addCategoryToMenu() {
        var inputObj = $(".newCategoryToAdd");
        var title = inputObj.val(),
            catId = inputObj.attr('data-catid');
        addItemToMenu(title, title, catId);
    }

    // Add item to menu
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

    // Remove item in menu
    function removeMenuItem(obj) {
        $(obj).parents('.menuItem').remove();
    }

    // display button ro edit or remove item
    // detail of action dependent of item's type
    function editExistsItem(obj) {
        var objJquery = $(obj);
        var type = objJquery.parents('.menuItem').attr('data-type');
        var objJquery = $(obj);
        var isCollapsed = objJquery.hasClass('collapsed');
        var idTabpanel = objJquery.attr("href");
        var bodyTabPanel = $(idTabpanel + " > .panel-body");
        bodyTabPanel.find(".editTabPanel").remove();
        bodyTabPanel.find(".editDetailTabPanel").remove();
        if (isCollapsed) {
            bodyTabPanel.append(templateEditMenuItem({}));
        }
    }

    /// display form to update "linked" item
    function displayFormUpdate(obj) {
        var objJquery = $(obj);
        var objMenuTitle = objJquery.parents(".menuItem").find('.menuItemTitle');
        var detail = {
            title : objMenuTitle.attr('data-title'),
            link : objMenuTitle.attr('data-reallink')
        };
        if (objMenuTitle.attr('data-catid').length)
            objJquery.parents('.panel-body').append(templateEditDetailMenuItemCategory(detail));
        else
            objJquery.parents('.panel-body').append(templateEditDetailMenuItemLink(detail));
    }

    function returncategoryToUpdate(obj) {
    // bind to suggest item when update cate item in menu
        var objJquery = $(obj),
            inputObj = objJquery.parents('.form-group').find(".newCategoryUpdate");
        inputObj.attr("data-catId", objJquery.attr('data-id'));
        inputObj.val(objJquery.attr('data-name'));
        objJquery.parents('.suggestion').hide();
    }

    // Update "linked" item
    function updateLinkDetail(obj) {
        var objParent = $(obj).parent();
        var title = objParent.find(".editDetailTitle").val(),
            link = objParent.find(".editDetailLink").val();
        updateChangesToItem(objParent, title, link, null);
        cancelUpdate(obj);

    }



    function updateCategoryDetail(obj) {
        var objJquery = $(obj),
            inputObject = objJquery.siblings('.form-group').find('.newCategoryUpdate');
        var title = inputObject.val();
        var catId = inputObject.attr('data-catid');
        updateChangesToItem(objJquery, title, null, catId);
        cancelUpdate(obj);

    }

    function updateChangesToItem(obj, title, link, catid) {
        console.log( title, link, catid);
        var menuItem = obj.parents('.menuItem');
        if (!link) link = title;
        menuItem.find('.menuItemTitle')
                .attr('data-title', title)
                .attr('data-reallink', link)
                .text(title);
        if (catid) menuItem.find('.menuItemTitle').attr('data-catid', catid);
        menuItem.find('.displayCustomLink').text(link)
    }

    // Cancel update detail for item
    function cancelUpdate(obj) {
        if ($(obj).parents(".editDetailTabPanel").length)
            $(obj).parents(".editDetailTabPanel").remove();
    }

    function updateMainMenu() {
        var listItemInArray = $('ol.sortable').nestedSortable('toArray', {startDepthCount: 0});
        listItemInArray.shift();
        var listData = [];
        listItemInArray.forEach(function(elem){
            var objJquery = $("#menuItemWrapper_" + elem.item_id).find(".menuItemTitle");
            listData.push({
                item_id: elem.item_id,
                parent_id: elem.parent_id,
                depth: elem.depth,
                cat_id: objJquery.attr('data-catid'),
                link: objJquery.attr('data-reallink'),
                title: objJquery.attr('data-title')
            });
        });

        $.get('/incoming/updatemainmenu', {listData: listData}, function (data) {

            document.location.reload();
        });
    }

</script>

