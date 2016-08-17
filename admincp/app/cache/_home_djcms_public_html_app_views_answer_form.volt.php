<script type="text/javascript" src="../plugin/uploadify/jquery.uploadify.min.js"></script>
<link rel="stylesheet" type="text/css" href="../plugin/uploadify/uploadify.css"/>
<div class="container">
    <div class="card">
        <div class="card-header">
            <h2>Thông tin câu hỏi</h2>

            <p class="p-t-10"><a href="<?php echo $backlink; ?>"><i class="md md-arrow-back"></i>Thoát</a></p>
        </div>
        <div class="card-body card-padding p-t-0">
            <form method="post" action="/answer/formprocess" enctype="multipart/form-data">
                <div role="tabpanel">
                    <ul role="tablist" class="tab-nav" style="overflow: hidden;" tabindex="1">
                        <li class="active"><a data-toggle="tab" role="tab" aria-controls="home11" href="#home11">Thông
                                tin</a></li>
                    </ul>

                    <div class="tab-content">
                        <div id="home11" class="tab-pane active" role="tabpanel">
                            <input type="hidden" name="redirect" value="<?php echo $backlink; ?>">
                            <input type="hidden" name="id" value="<?php echo $object['_id']; ?>">
                            <div>
                                <div class="card-body">
                                    <div class="form-group fg-float">
                                        <div class="fg-line" style="width: 95%">
                                            <input type="text" name="name" value="<?php echo $object['name']; ?>"
                                                   class="input-sm form-control fg-input" id="media_input_name"
                                                   required>
                                        </div>
                                        <label class="fg-label">Tiêu đề</label>
                                    </div>
                                    <div class="form-group fg-float">
                                        <div class="fg-line" style="width: 95%">
                                            <input type="text" name="sort" value="<?php echo $object['sort']; ?>"
                                                   class="input-sm form-control fg-input"
                                                   required>
                                        </div>
                                        <label class="fg-label">Vị trí</label>
                                    </div>
                                    <div class="form-group fg-float">
                                        <div class="fg-line">
                                    <textarea class="form_editor" name="content"
                                              class="form-control"><?php echo $object['content']; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group fg-float">
                    <button class="btn btn-primary waves-effect">Chấp nhận</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Following CSS are used only for the Demp purposes thus you can remove this anytime. -->
<script src="/vendors/fileinput/fileinput.min.js"></script>
<script src="/vendors/input-mask/input-mask.min.js"></script>
<script src="/vendors/bower_components/autosize/dist/autosize.min.js"></script>
<script src="/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>


