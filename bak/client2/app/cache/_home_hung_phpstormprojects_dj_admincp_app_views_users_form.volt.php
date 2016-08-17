<div class="container">

    <div class="card">
        <div class="card-header">
            <h2>Thông tin người dùng</h2>
            <p class="p-t-10"><a href="<?php echo $backlink; ?>" ><i class="md md-arrow-back"></i>Thoát</a></p>
        </div>

        <div class="card-body card-padding">
            <div role="tabpanel">
                <ul role="tablist" class="tab-nav" style="overflow: hidden;" tabindex="1">
                    <li class="active"><a data-toggle="tab" role="tab" aria-controls="home11" href="#home11"
                                          aria-expanded="true">Thông tin chung</a></li>
                </ul>
               <form  method="post" action="/users/formprocess" enctype="multipart/form-data">
                   <input name="id" value="<?php echo $userInfo['_id']; ?>" type="hidden">
                   <input name="redirect" value="<?php echo $backlink; ?>" type="hidden">
                   <div class="tab-content">
                       <div id="home11" class="tab-pane active" role="tabpanel">
                           <div class="card-body card-padding">

                               <div class="form-group fg-float">
                                   <div class="fg-line">
                                       <input type="text" name="username" value="<?php echo $userInfo['username']; ?>" class="input-sm form-control fg-input">
                                   </div>
                                   <label class="fg-label">Tên người dùng</label>
                               </div>

                               <div class="form-group fg-float">
                                   <div class="fg-line">
                                       <input type="text" class="form-control fg-input" name="fullname" value="<?php echo $userInfo['fullname']; ?>">
                                   </div>
                                   <label class="fg-label" >Họ và tên</label>
                               </div>
                               <div class="form-group fg-float">
                                   <div class="fg-line">
                                       <input type="text" class="form-control fg-input" name="password" value="">
                                   </div>
                                   <label class="fg-label" >Mật khẩu</label>
                               </div>
                               <div class="form-group fg-float">
                                   <div class="fg-line">
                                       <input type="text" class="form-control fg-input" name="phone" value="<?php echo $userInfo['phone']; ?>">
                                   </div>
                                   <label class="fg-label" >Số điện thoại</label>
                               </div>
                               <div class="form-group fg-float">
                                   <div class="fg-label">Ảnh đại diện</div><br><br>
                                   <div class="fg-line">
                                       <div data-provides="fileinput" class="fileinput fileinput-new">
                                           <div data-trigger="fileinput" style="height: auto" class="fileinput-preview thumbnail">
                                               <img src="<?php echo ($userInfo['_id'] <= 0 ? '/img/300x200.gif' : $this->config->upload->mediaurl . $userInfo['priavatar']); ?>" />
                                           </div>
                                           <div>
                                            <span class="btn btn-info btn-file waves-effect">
                                                <span class="fileinput-new">Select image</span>
                                                <span class="fileinput-exists">Change</span>
                                                <input type="file" name="file">
                                            </span>
                                               <a data-dismiss="fileinput" class="btn btn-danger fileinput-exists waves-effect" href="#">Remove</a>
                                           </div>
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
<script src="/vendors/fileinput/fileinput.min.js"></script>