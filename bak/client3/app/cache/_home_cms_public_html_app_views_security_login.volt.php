<!-- Login -->
<div class="lc-block toggled" id="l-login">
    <?php echo $this->flash->output(); ?>
    <form action="" method="post">
        <div class="input-group m-b-20">
            <span class="input-group-addon"><i class="md md-person"></i></span>

            <div class="fg-line">
                <input type="text" class="form-control" name="username" placeholder="Username">
            </div>
        </div>

        <div class="input-group m-b-20">
            <span class="input-group-addon"><i class="md md-accessibility"></i></span>

            <div class="fg-line">
                <input type="password" class="form-control" name="password" placeholder="Password">
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="checkbox">
            <label>
                <input type="checkbox" value="">
                <i class="input-helper"></i>
                Keep me signed in
            </label>
        </div>

        <button class="btn btn-login btn-danger btn-float"><i class="md md-arrow-forward"></i></button>
    </form>
</div>
