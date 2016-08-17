<!DOCTYPE html>
<!--[if IE 9 ]>
<html class="ie9"><![endif]-->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo (empty($title) ? ('Admin Backend Title') : ($title)); ?></title>
    <?php echo $this->tag->stylesheetLink('http://fonts.googleapis.com/css?family=Roboto&subset=latin,vietnamese', false); ?>
    <?php echo $this->tag->stylesheetLink('vendors/bower_components/animate.css/animate.min.css'); ?>
    <?php echo $this->tag->stylesheetLink('vendors/bower_components/sweetalert/dist/sweetalert-override.min.css'); ?>
    <?php echo $this->tag->stylesheetLink('vendors/bower_components/material-design-iconic-font/css/material-design-iconic-font.min.css'); ?>
    <?php echo $this->tag->stylesheetLink('vendors/socicon/socicon.min.css'); ?>
    <?php echo $this->tag->stylesheetLink('vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css'); ?>
    <?php echo $this->tag->stylesheetLink('vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css'); ?>
    <?php echo $this->tag->stylesheetLink('vendors/chosen_v1.4.2/chosen.min.css'); ?>
    <?php echo $this->tag->stylesheetLink('css/app.min.1.css'); ?>
    <?php echo $this->tag->stylesheetLink('css/app.min.2.css'); ?>
    <?php echo $this->tag->stylesheetLink('css/bootstrap-editable.css'); ?>
    <?php echo $this->tag->stylesheetLink('css/style.css'); ?>
    <?php echo $this->tag->stylesheetLink('css/jquery.Jcrop.css'); ?>
    <?php echo $this->tag->stylesheetLink('plugin/jquery.select2/css/select2.min.css'); ?>
    <?php if ($this->assets->collection('actionCss')->count()) { ?>
        <?php echo $this->assets->outputCss('actionCss'); ?>
    <?php } ?>

    <?php echo $this->tag->javascriptInclude('vendors/bower_components/moment/min/moment.min.js'); ?>
    <?php echo $this->tag->javascriptInclude('vendors/bower_components/jquery/dist/jquery.min.js'); ?>
    <?php echo $this->tag->javascriptInclude('js/jquery-migrate-1.2.1.js'); ?>
    <?php echo $this->tag->javascriptInclude('vendors/bower_components/jquery-ui/jquery-ui.min.js'); ?>
    <?php echo $this->tag->javascriptInclude('js/underscore.min.js'); ?>
    <?php echo $this->tag->javascriptInclude('plugin/jquery.select2/js/select2.min.js'); ?>
    <?php echo $this->tag->javascriptInclude('js/dj_core.js'); ?>
</head>
<body>
<section id="main">
    <aside id="sidebar">
        <div class="sidebar-inner c-overflow">
            <div class="profile-menu">
                <a href="">
                    <div class="profile-pic">
                        <img src="/img/profile-pics/1.jpg" alt="">
                    </div>

                    <div class="profile-info">
                        Malinda Hollaway
                        <i class="md md-arrow-drop-down"></i>
                    </div>
                </a>

                <ul class="main-menu">
                    <li>
                        <a href="profile-about.html"><i class="md md-person"></i> View Profile</a>
                    </li>
                    <li>
                        <a href=""><i class="md md-settings-input-antenna"></i> Privacy Settings</a>
                    </li>
                    <li>
                        <a href=""><i class="md md-settings"></i> Settings</a>
                    </li>
                    <li>
                        <a href="/security/logout"><i class="md md-history"></i> Logout</a>
                    </li>
                </ul>
            </div>

            <ul class="main-menu">
                <?php foreach ($sidebar as $item) { ?>
                    <li class="<?php echo ($item['child'] == !$empty ? 'sub-menu' : ''); ?> <?php echo $item['active']; ?>">
                        <a href="<?php echo $item['controller']; ?>"><i class="<?php echo $item['icon']; ?>"></i> <?php echo $item['name']; ?></a>
                        <?php if ($item['child'] == !$empty) { ?>
                            <ul>
                                <?php foreach ($item['child'] as $citem) { ?>
                                    <li><a href="<?php echo $citem['controller']; ?>"><?php echo $citem['name']; ?></a></li>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </aside>

    <section id="content">
        <div class="container">
            <?php echo $this->flash->output(); ?>
        </div>
        <?php echo $this->getContent(); ?>
    </section>
</section>

<header id="header">
    <ul class="header-inner">
        <li id="menu-trigger" data-trigger="#sidebar">
            <div class="line-wrap">
                <div class="line top"></div>
                <div class="line center"></div>
                <div class="line bottom"></div>
            </div>
        </li>

        <li class="logo hidden-xs">
            <a href="index.html">Djpro Admincp</a>
        </li>

        <li class="pull-right">
            <ul class="top-menu">
                <li id="toggle-width">
                    <div class="toggle-switch">
                        <input id="tw-switch" type="checkbox" hidden="hidden">
                        <label for="tw-switch" class="ts-helper"></label>
                    </div>
                </li>
                <li id="top-search">
                    <a class="tm-search" href=""></a>
                </li>
            </ul>
        </li>
    </ul>

    <!-- Top Search Content -->
    <div id="top-search-wrap">
        <input type="text" name="mainquery" placeholder="Something here !">
        <i id="top-search-close">&times;</i>
    </div>
</header>

<footer id="footer">
    Developed by <b>Ditech</b> 2015. Copyright &copy; 2015 mSport
</footer>

<!--[if lt IE 9]>
<div class="ie-warning">
    <h1 class="c-white">Warning!!</h1>

    <p>You are using an outdated version of Internet Explorer, please upgrade <br/>to any of the following web browsers
        to access this website.</p>

    <div class="iew-container">
        <ul class="iew-download">
            <li>
                <a href="http://www.google.com/chrome/">
                    <img src="img/browsers/chrome.png" alt="">

                    <div>Chrome</div>
                </a>
            </li>
            <li>
                <a href="https://www.mozilla.org/en-US/firefox/new/">
                    <img src="img/browsers/firefox.png" alt="">

                    <div>Firefox</div>
                </a>
            </li>
            <li>
                <a href="http://www.opera.com/">
                    <img src="img/browsers/opera.png" alt="">

                    <div>Opera</div>
                </a>
            </li>
            <li>
                <a href="https://www.apple.com/safari/">
                    <img src="img/browsers/safari.png" alt="">

                    <div>Safari</div>
                </a>
            </li>
            <li>
                <a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie">
                    <img src="img/browsers/ie.png" alt="">

                    <div>IE (New)</div>
                </a>
            </li>
        </ul>
    </div>
    <p>Sorry for the inconvenience!</p>
</div>
<![endif]-->
<!-- Older IE warning message -->


<!-- Javascript Libraries -->
<?php echo $this->tag->javascriptInclude('vendors/bower_components/bootstrap/dist/js/bootstrap.min.js'); ?>
<?php echo $this->tag->javascriptInclude('vendors/bower_components/jquery.nicescroll/jquery.nicescroll.min.js'); ?>
<?php echo $this->tag->javascriptInclude('vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js'); ?>
<?php echo $this->tag->javascriptInclude('vendors/chosen_v1.4.2/chosen.jquery.min.js'); ?>
<?php echo $this->tag->javascriptInclude('js/jquery.slimscroll.min.js'); ?>
<?php echo $this->tag->javascriptInclude('js/bootstrap3-typeahead.js'); ?>
<?php echo $this->tag->javascriptInclude('js/bootstrap-editable.min.js'); ?>
<?php echo $this->tag->javascriptInclude('vendors/bower_components/Waves/dist/waves.min.js'); ?>
<?php echo $this->tag->javascriptInclude('vendors/bootstrap-growl/bootstrap-growl.min.js'); ?>
<?php echo $this->tag->javascriptInclude('vendors/bower_components/sweetalert/dist/sweetalert.min.js'); ?>
<?php echo $this->tag->javascriptInclude('plugin/tinymce/jquery.tinymce.min.js'); ?>
<?php echo $this->tag->javascriptInclude('js/jquery.Jcrop.js'); ?>
<!-- Placeholder for IE9 -->
<!--[if IE 9 ]>
<?php echo $this->tag->javascriptInclude('vendors/bower_components/jquery-placeholder/jquery.placeholder.min.js'); ?>
<![endif]-->
<script src="/vendors/bootgrid/jquery.bootgrid.min.js"></script>
<?php echo $this->tag->javascriptInclude('js/myfunction.js'); ?>
</body>

<script>
    $(document).ready(function () {
        $('.sidebar-inner').slimscroll({
            height: 'auto',
            wheelStep: 15,
            borderRadius: '0px'
        });
    })
</script>
<?php if ($this->assets->collection('actionJs')->count()) { ?>
    <?php echo $this->assets->outputJs('actionJs'); ?>
<?php } ?>
<?php echo $this->assets->outputInlineJs(); ?>
</html>
