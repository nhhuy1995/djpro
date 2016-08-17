<!DOCTYPE html>
<!--[if IE 9 ]>
<html class="ie9"><![endif]-->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ title|default('Admin Backend Title') }}</title>
    {{ stylesheet_link("http://fonts.googleapis.com/css?family=Roboto&subset=latin,vietnamese",false) }}
    {{ stylesheet_link("vendors/bower_components/animate.css/animate.min.css") }}
    {{ stylesheet_link("vendors/bower_components/sweetalert/dist/sweetalert-override.min.css") }}
    {{ stylesheet_link("vendors/bower_components/material-design-iconic-font/css/material-design-iconic-font.min.css") }}
    {{ stylesheet_link("vendors/socicon/socicon.min.css") }}
    {{ stylesheet_link("vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css") }}
    {{ stylesheet_link("vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css") }}
    {{ stylesheet_link("vendors/chosen_v1.4.2/chosen.min.css") }}
    {{ stylesheet_link("css/app.min.1.css") }}
    {{ stylesheet_link("css/app.min.2.css") }}
    {{ stylesheet_link("css/bootstrap-editable.css") }}
    {{ stylesheet_link("css/style.css") }}
    {{ stylesheet_link("css/jquery.Jcrop.css") }}
    {{ stylesheet_link("plugin/jquery.select2/css/select2.min.css") }}
    {% if assets.collection('actionCss').count() %}
        {{ assets.outputCss('actionCss') }}
    {% endif %}

    {{ javascript_include("vendors/bower_components/moment/min/moment.min.js") }}
    {{ javascript_include("vendors/bower_components/jquery/dist/jquery.min.js") }}
    {{ javascript_include("js/jquery-migrate-1.2.1.js") }}
    {{ javascript_include("vendors/bower_components/jquery-ui/jquery-ui.min.js") }}
    {{ javascript_include("js/underscore.min.js") }}
    {{ javascript_include("plugin/jquery.select2/js/select2.min.js") }}
    {{ javascript_include("js/dj_core.js") }}
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
                {% for item in sidebar %}
                    <li class="{{ item['child'] is not empty?'sub-menu':'' }} {{ item['active'] }}">
                        <a href="{{ item['controller'] }}"><i class="{{ item['icon'] }}"></i> {{ item['name'] }}</a>
                        {% if item['child'] is not empty %}
                            <ul>
                                {% for citem in item['child'] %}
                                    <li><a href="{{ citem['controller'] }}">{{ citem['name'] }}</a></li>
                                {% endfor %}
                            </ul>
                        {% endif %}
                    </li>
                {% endfor %}
            </ul>
        </div>
    </aside>

    <section id="content">
        <div class="container">
            {{ flash.output() }}
        </div>
        {{ content() }}
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
    {#Developed by <b>Ditech</b> 2015. Copyright &copy; 2015 mSport#}
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
{{ javascript_include("vendors/bower_components/bootstrap/dist/js/bootstrap.min.js") }}
{{ javascript_include("vendors/bower_components/jquery.nicescroll/jquery.nicescroll.min.js") }}
{{ javascript_include("vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js") }}
{{ javascript_include("vendors/chosen_v1.4.2/chosen.jquery.min.js") }}
{{ javascript_include("js/jquery.slimscroll.min.js") }}
{{ javascript_include("js/bootstrap3-typeahead.js") }}
{{ javascript_include("js/bootstrap-editable.min.js") }}
{{ javascript_include("vendors/bower_components/Waves/dist/waves.min.js") }}
{{ javascript_include("vendors/bootstrap-growl/bootstrap-growl.min.js") }}
{{ javascript_include("vendors/bower_components/sweetalert/dist/sweetalert.min.js") }}
{{ javascript_include("plugin/tinymce/jquery.tinymce.min.js") }}
{{ javascript_include("js/jquery.Jcrop.js") }}
<!-- Placeholder for IE9 -->
<!--[if IE 9 ]>
{{ javascript_include("vendors/bower_components/jquery-placeholder/jquery.placeholder.min.js") }}
<![endif]-->
<script src="/vendors/bootgrid/jquery.bootgrid.min.js"></script>
{{ javascript_include("js/myfunction.js") }}
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
{% if assets.collection('actionJs').count() %}
    {{ assets.outputJs('actionJs') }}
{% endif %}
{{ assets.outputInlineJs() }}
</html>
