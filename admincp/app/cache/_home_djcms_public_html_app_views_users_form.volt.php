<div class="container">

    <div class="card">
        <div class="card-header">
            <h2>Thông tin người dùng</h2>
            <p class="p-t-10"><a href="<?php echo $backlink; ?>"><i class="md md-arrow-back"></i>Thoát</a></p>
        </div>

        <div class="card-body card-padding">
            <div role="tabpanel">
                <ul role="tablist" class="tab-nav" style="overflow: hidden;" tabindex="1">
                    <li class="active"><a data-toggle="tab" role="tab" aria-controls="home11" href="#home11"
                                          aria-expanded="true">Thông tin chung</a></li>
                </ul>
                <form method="post" action="/users/formprocess" enctype="multipart/form-data">
                    <input name="id" value="<?php echo $userInfo['_id']; ?>" type="hidden">
                    <input name="redirect" value="<?php echo $backlink; ?>" type="hidden">
                    <div class="tab-content">
                        <div id="home11" class="tab-pane active" role="tabpanel">
                            <div class="card-body card-padding">

                                <div class="form-group fg-float">
                                    <div class="fg-line">
                                        <input type="text" name="username" value="<?php echo $userInfo['username']; ?>"
                                               class="input-sm form-control fg-input">
                                    </div>
                                    <label class="fg-label">Tên người dùng</label>
                                </div>
                                <div class="form-group fg-float">
                                    <div class="fg-line">
                                        <input type="text" name="password" value=""
                                               class="input-sm form-control fg-input">
                                    </div>
                                    <label class="fg-label">Mật khẩu</label>
                                </div>
                                <div class="form-group fg-float">
                                    <div class="fg-line">
                                        <input type="text" class="form-control fg-input" name="email"
                                               value="<?php echo $userInfo['email']; ?>">
                                    </div>
                                    <label class="fg-label">Email</label>
                                </div>
                                <div class="form-group fg-float">
                                    <div class="fg-line">
                                        <input type="text" class="form-control fg-input" name="fullname"
                                               value="<?php echo $userInfo['fullname']; ?>">
                                    </div>
                                    <label class="fg-label">Họ và tên</label>
                                </div>

                                <div class="form-group fg-float">
                                    <div class="fg-line">
                                        <input type="text" class="form-control fg-input" name="address"
                                               value="<?php echo $userInfo['address']; ?>">
                                    </div>
                                    <label class="fg-label">Địa chỉ</label>
                                </div>
                                <div class="form-group fg-float">
                                    <div class="fg-line">
                                        <input type="text" class="form-control fg-input" name="phone"
                                               value="<?php echo $userInfo['phone']; ?>">
                                    </div>
                                    <label class="fg-label">Số điện thoại</label>
                                </div>
                                <div class="form-group fg-float">
                                   <div class="row">
                                       <div class="col-md-2">
                                           <select class="form-control" name="days">
                                               <option value="">Tháng</option>
                                               <?php foreach (range(1, 31) as $key) { ?>
                                                   <option value="<?php echo $key; ?>" <?php if ($userInfo['days'] == $key) { ?> selected <?php } ?>><?php echo $key; ?></option>
                                               <?php } ?>
                                           </select>
                                       </div>
                                       <div class="col-md-2">
                                           <select class="form-control" name="month">
                                               <option value="">Tháng</option>
                                               <?php foreach (range(1, 12) as $key) { ?>
                                                   <option value="<?php echo $key; ?>" <?php if ($userInfo['month'] == $key) { ?> selected <?php } ?>><?php echo $key; ?></option>
                                               <?php } ?>
                                           </select>
                                       </div>
                                       <div class="col-md-2">
                                           <select class="form-control" name="year">
                                               <option value="">Năm</option>
                                               <?php foreach (range(1905, 2016) as $k) { ?>
                                                   <option value="<?php echo $k; ?>" <?php if ($userInfo['year'] == $k) { ?> selected <?php } ?>><?php echo $k; ?></option>
                                               <?php } ?>
                                           </select>
                                       </div>
                                   </div>
                                </div>
                                <div style="clear: both"></div>
                                <div class="form-group fg-float">
                                    <div class="fg-line">
                                        <input type="text" class="form-control fg-input" name="facebook"
                                               value="<?php echo $userInfo['facebook']; ?>">
                                    </div>
                                    <label class="fg-label">Facebook</label>
                                </div>
                                <div class="form-group fg-float">
                                    <div class="fg-line">
                                        <input type="text" class="form-control fg-input" name="yahoo"
                                               value="<?php echo $userInfo['yahoo']; ?>">
                                    </div>
                                    <label class="fg-label">Yahoo! Messenger</label>
                                </div>
                                <div class="form-group fg-float">
                                    <div class="fg-line">
                                        <input type="text" class="form-control fg-input" name="skype"
                                               value="<?php echo $userInfo['skype']; ?>">
                                    </div>
                                    <label class="fg-label">Skype</label>
                                </div>
                                <div class="form-group fg-float">
                                    <div class="fg-line">
                                        <input type="text" class="form-control fg-input" name="job"
                                               value="<?php echo $userInfo['job']; ?>">
                                    </div>
                                    <label class="fg-label">Nghề nghiệp</label>
                                </div>
                                <div class="form-group fg-float">
                                    <div class="fg-line">
                                        <input type="text" class="form-control fg-input" name="hobby"
                                               value="<?php echo $userInfo['hobby']; ?>">
                                    </div>
                                    <label class="fg-label">Sở thích</label>
                                </div>
                                <div class="form-group fg-float">
                                    <label class="radio radio-inline m-r-20">
                                        <input type="radio" value="NA"
                                               name="sex" <?php echo ($userInfo['sex'] == 'NA' ? 'checked' : ''); ?>
                                        >
                                        <i class="input-helper"></i>
                                        N/A
                                    </label>
                                    <label class="radio radio-inline m-r-20">
                                        <input type="radio" value="male"
                                               name="sex" <?php echo ($userInfo['sex'] == 'male' ? 'checked' : ''); ?>
                                        >
                                        <i class="input-helper"></i>
                                        Nam
                                    </label>
                                    <label class="radio radio-inline m-r-20">
                                        <input type="radio" value="female"
                                               name="sex" <?php echo ($userInfo['sex'] == 'female' ? 'checked' : ''); ?>>
                                        <i class="input-helper"></i>
                                        Nữ
                                    </label>
                                </div>
                                <div class="form-group fg-float">
                                    <div class="fg-label">Ảnh đại diện </div>
                                    <br><br>
                                    <div class="fg-line">
                                        <div data-provides="fileinput" class="fileinput fileinput-new">
                                            <div data-trigger="fileinput" style="height: auto"
                                                 class="fileinput-preview thumbnail">
                                                <img src="<?php echo ($userInfo['_id'] <= 0 ? '/img/300x200.gif' : $userInfo['priavatar']); ?>"/>
                                            </div>
                                            <div>
                                            <span class="btn btn-info btn-file waves-effect">
                                                <span class="fileinput-new">Select image</span>
                                                <span class="fileinput-exists">Change</span>
                                                <input type="file" name="file">
                                            </span>
                                                <a data-dismiss="fileinput"
                                                   class="btn btn-danger fileinput-exists waves-effect"
                                                   href="#">Remove</a>
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