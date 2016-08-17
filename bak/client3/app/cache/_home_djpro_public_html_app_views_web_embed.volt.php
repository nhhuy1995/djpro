<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="">
    <meta property="og:url" content="<?php echo $DOMAIN; ?><?php echo $object->link; ?>"/>
    <meta property="og:type" content="website"/>
    <meta property="og:title" content="<?php echo $object->name; ?>"/>
    <meta property="og:description" content="<?php echo $object->description; ?>"/>
    <meta property="og:image" content="<?php echo $DOMAIN; ?><?php echo $object->priavatar; ?>"/>
    <title><?php echo (empty($title) ? ('Trang chủ') : ($title)); ?></title>
    <link rel="stylesheet" href="/web/skins/style.css" type="text/css" media="all">
    <link rel="stylesheet" href="/web/skins/responsive.css" type="text/css" media="all">
    <link rel="stylesheet" href="/web/skins/update.css" type="text/css" media="all">
    <link rel="stylesheet" href="/web/skins/font-awesome.css" type="text/css" media="all">
    
    <link rel="stylesheet" href="/web/css/style.css"/>
    <link rel="stylesheet" href="/web/skins/jplayer.css"/>
    <link rel="stylesheet" href="/web/plugin/jquery.select2/css/select2.min.css"/>
    
    <script type="text/javascript" src="/web/js/jquery.min.js"></script>
    <script type="text/javascript" src="/web/js/customer.js"></script>
    <script type="text/javascript" src="/web/js/cookie.js"></script>
    <script type="text/javascript" src="/web/js/cookie.js"></script>
    <script type="text/javascript" src="/web/js/dj_core.js"></script>
</head>
<body>
    <?php echo $this->getContent(); ?>
</body>

</html>