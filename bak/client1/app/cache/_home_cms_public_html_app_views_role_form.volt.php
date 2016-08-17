<div class="container">

    <div class="card">
        <div class="card-header">
            <h2>Thông tin nhóm quyền</h2>
            <p class="p-t-10"><a href="<?php echo $backlink; ?>" ><i class="md md-arrow-back"></i>Thoát</a></p>
        </div>

        <div class="card-body card-padding">
            <div role="tabpanel">
                <ul role="tablist" class="tab-nav" style="overflow: hidden;" tabindex="1">
                    <li class="active"><a data-toggle="tab" role="tab" aria-controls="home11" href="#home11"
                                          aria-expanded="true">Thông tin chung</a></li>
                    <li class=""><a data-toggle="tab" role="tab" aria-controls="profile11" href="#profile11"
                                    aria-expanded="false">Phân quyền</a></li>
                </ul>

                <form  method="post" action="/role/formprocess">
                    <input type="hidden" name="redirect" value="<?php echo $backlink; ?>">
                    <input type="hidden" name="id" value="<?php echo $roleInfo['_id']; ?>" />
                    <div class="tab-content">
                        <div id="home11" class="tab-pane active" role="tabpanel">
                            <div class="card-body card-padding">

                                <div class="form-group fg-float">
                                    <div class="fg-line">
                                        <input type="text" name="name" value="<?php echo $roleInfo['name']; ?>" class="input-sm form-control fg-input">
                                    </div>
                                    <label class="fg-label">Tên nhóm quyền</label>
                                </div>

                                <div class="form-group fg-float">
                                    <div class="fg-line">
                                        <input type="text" class="form-control fg-input" name="sort" value="<?php echo $roleInfo['sort']; ?>">
                                    </div>
                                    <label class="fg-label" >Vị trí</label>
                                </div>
                            </div>
                        </div>
                        <div id="profile11" class="tab-pane" role="tabpanel">
                            <div class="card-body card-padding">

                                <div class="form-group fg-float">
                                    <div class="checkbox m-b-15">

                                        <label style="font-weight: bold;">
                                            <input type="checkbox" class="con-sm-1"  id="checkallcat">
                                            <i class="input-helper"> </i>
                                            &nbsp; Chọn tất cả
                                        </label>
                                        <ul>
                                            <?php foreach ($module as $key => $item) { ?>
                                            <li class="p-5">
                                                <label style="font-weight: bold;">
                                                    <input type="checkbox" value="<?php echo $key; ?>" class="catitem" <?php echo $item['checked']; ?> name="permission[]">
                                                    <i class="input-helper"></i>
                                                    <?php echo $item['name']; ?>
                                                </label>
                                                <ul class="p-l-25">
                                                    <?php if (isset($item['child'])) { ?>
                                                        <?php foreach ($item['child'] as $value) { ?>
                                                            <li class="p-5">
                                                                <label style="font-weight: bold;">
                                                                    <input type="checkbox" value="<?php echo $key; ?>_<?php echo $value['key']; ?>" <?php echo $value['checked']; ?> class="catitem" name="permission[]">
                                                                    <i class="input-helper"></i>
                                                                    <?php echo $value['name']; ?>
                                                                </label>
                                                            </li>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </ul>
                                                <?php } ?>
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