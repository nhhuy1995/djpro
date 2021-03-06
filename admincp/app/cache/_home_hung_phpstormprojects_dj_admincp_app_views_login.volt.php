<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie9"><![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Material Admin</title>
    <!-- Vendor CSS -->
    <?php echo $this->tag->stylesheetLink('http://fonts.googleapis.com/css?family=Roboto&subset=latin,vietnamese', false); ?>
    <?php echo $this->tag->stylesheetLink('vendors/bower_components/animate.css/animate.min.css'); ?>
    <?php echo $this->tag->stylesheetLink('vendors/bower_components/material-design-iconic-font/css/material-design-iconic-font.min.css'); ?>
    <?php echo $this->tag->stylesheetLink('css/app.min.1.css'); ?>
    <?php echo $this->tag->stylesheetLink('css/app.min.2.css'); ?>
    <?php echo $this->tag->javascriptInclude('vendors/bower_components/jquery/dist/jquery.min.js'); ?>
    <?php echo $this->tag->javascriptInclude('vendors/bower_components/bootstrap/dist/js/bootstrap.min.js'); ?>
</head>

<body class="login-content">
<?php echo $this->getContent(); ?>


<!-- Older IE warning message -->
<!--[if lt IE 9]>
<div class="ie-warning">
    <h1 class="c-white">Warning!!</h1>
    <p>You are using an outdated version of Internet Explorer, please upgrade <br/>to any of the following web browsers to access this website.</p>
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
<?php echo $this->tag->javascriptInclude('vendors/bower_components/Waves/dist/waves.min.js'); ?>
<!-- Placeholder for IE9 -->
<!--[if IE 9 ]>
<?php echo $this->tag->javascriptInclude('vendors/bower_components/jquery-placeholder/jquery.placeholder.min.js'); ?>
<![endif]-->
<?php echo $this->tag->javascriptInclude('js/functions.js'); ?>

</body>
</html>
