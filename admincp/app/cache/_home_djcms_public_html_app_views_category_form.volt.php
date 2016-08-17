<div class="container">

    <div class="card">
        <div class="card-header">
            <h2>Thông tin Chuyên mục</h2>

            <p class="p-t-10"><a href="<?php echo $backlink; ?>"><i class="md md-arrow-back"></i>Thoát</a></p>
        </div>

        <div class="card-body card-padding">
            <div role="tabpanel">
                <ul role="tablist" class="tab-nav" style="overflow: hidden;" tabindex="1">
                    <li class="active"><a data-toggle="tab" role="tab" aria-controls="home11" href="#home11"
                                          aria-expanded="true">Thông tin chung</a></li>
                </ul>
                <form method="post" action="/category/formprocess">
                    <input name="id" value="<?php echo $object['_id']; ?>" type="hidden">
                    <input name="redirect" value="<?php echo $backlink; ?>" type="hidden">

                    <div class="tab-content">
                        <div id="home11" class="tab-pane active" role="tabpanel">
                            <div class="card-body card-padding">

                                <div class="form-group fg-float">
                                    <div class="fg-line">
                                        <input type="text" name="name" value="<?php echo $object['name']; ?>"
                                               class="input-sm form-control fg-input">
                                    </div>
                                    <label class="fg-label">Tên chuyên mục</label>
                                </div>
                                <div class="form-group fg-float">
                                    
                                    <div class="form-group">
                                        <div class="fg-line">
                                            <div class="select">
                                                <select class="form-control" required name="type" id="list_type">
                                                    <option value="">Loại chuyên mục</option>
                                                    <?php foreach ($list_type as $key => $item) { ?>
                                                        <option onclick="HideShowHTML(this)" <?php echo ($key == $object['type'] ? 'selected' : ''); ?>
                                                                value="<?php echo $key; ?>"><?php echo $item; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group fg-float block_is_topic">
                                    <div class="fg-line">
                                        <label class="checkbox checkbox-inline m-r-20">
                                            <input type="checkbox"
                                                   name="is_topic" <?php echo ($object['is_topic'] == true ? 'checked' : ''); ?>
                                                   value="1"> <i
                                                    class="input-helper"></i>Chủ đề nổi bật
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group fg-float">
                                    <div class="fg-line">
                                        <div class="toggle-switch" data-ts-color="blue">
                                            <label for="ts3" class="ts-label">Trạng thái</label>
                                            <input type="checkbox" hidden="hidden"
                                                   id="ts3"
                                                    <?php if (isset($object['status'])) { ?>
                                                    <?php echo ($object['status'] == 1 ? 'checked' : ''); ?>
                                                    <?php } else { ?>
                                                        checked
                                                    <?php } ?>
                                                   value="1"
                                                   name="status">
                                            <label for="ts3" class="ts-helper"></label>
                                        </div>
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


<script src="/vendors/chosen_v1.4.2/chosen.jquery.min.js"></script>
<script>
    function HideShowHTML(obj){
        var type = $(obj).val();
        if(type == 'topic') $('.block_is_topic').show();
        else $('.block_is_topic').hide();
    }
    $(document).ready(function () {
       var type = $( "#list_type option:selected" ).attr('value');
        if(type == 'topic') $('.block_is_topic').show();
        else $('.block_is_topic').hide();
    });
</script>