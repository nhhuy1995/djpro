<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
{{ partial("partial/header") }}    
</head>
<body>
<div class="navbar navbar-default">
    <div class="navbar-header">
        <a class="navbar-toggle pull-left" href="#menu">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>
        <a class="navbar-brand pull-right" href="http://beta.khongdoduoc.net/"><img alt="Nhạc DJ Mobile" src="/wap/images/misc/logo.png" height="50" /></a>
    </div>
</div>    
<div class="col-lg-12">  
        {{ partial("partial/topNavigation") }}
        <p></p>
        {{ content() }}
</div>
{{ partial("partial/sidebar") }}
</body>
</html>