
<header id="header">
    <section class="bg {{ class }}">
        <div class="navbar">
            <div class="header-top">
                <div class="container">
                    <div class="row">
                        <div class="col-md-3 col-sm-3"><h1 class="logo">DJ.PRO.VN</h1></div>
                        <div class="col-md-5 col-sm-4">
                            <form action="/tim-kiem.html" method="get" class="search" id="frmsearch">
                                <input type="text" id="txt_keyword" autocomplete="off" onkeypress="searchsugget(this)" value="{{ _GET['q'] }}"  placeholder="--- Nhập từ khóa ---"
                                       name="q">

                                <div id="suggession_seach"></div>
                                <a href="javascript:void(0)" onclick="searchsubmit()"><i class="fa fa-search"></i></a>
                            </form>
                        </div>
                        <div class="col-md-4 col-sm-5">

                            <div class="col-mobile">
                                {% if session['_id'] %}
                                    <ul class="navuser">
                                        <li><a href="/user.html"><img src="{{ session['priavatar'] }}"
                                                                     alt=""/> {{ session['username'] }}</a>
                                        </li>
                                        <li class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i
                                                        class="fa fa-cog"></i>Bảng điều khiển</a>
                                            <ul class="dropdown-menu">
                                                <li><a href="/user.html"><i class="fa fa-info"></i> Thông tin cá nhân</a>

                                                <li><a href="{{ session['link'] }} "><i class="fa fa-user"></i> Trang cá nhân</a>
                                                </li>
                                                <li class="pull-right"><a href="javascript:void(0)" data-toggle="modal" data-target="#postmusic"><i class="fa fa-upload"></i> Đăng nhạc</a>
                                                </li>
                                                <li><a href="/playlist-cua-toi.html"><i class="fa fa-music"></i>
                                                        Playlist của bạn</a></li>
                                                <li><a href="/nhac-da-duyet.html"><i
                                                                class="fa fa-microphone"></i> Nhạc đã duyệt</a>
                                                </li>
                                                <li><a href="/nhac-cho-duyet.html"><i
                                                                class="fa fa-microphone"></i> Nhạc chờ duyệt</a>
                                                </li>
                                                <li><a href="/nhac-da-xoa.html"><i
                                                                class="fa fa-microphone"></i> Nhạc đã xóa</a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0)" data-toggle="modal" data-target="#require_music"><i
                                                                class="fa fa-pencil-square-o "></i> Yêu cầu nhạc</a>
                                                </li>
                                                <li><a href="/doi-mat-khau.html"><i class="fa fa-key"></i> Đổi mật khẩu</a>
                                                </li>
                                                <li><a onclick="return confirm('Bạn chắc chắn muốn thoát?')" href="/logout.html"><i class="fa fa-sign-out"></i> Thoát</a></li>
                                            </ul>
                                        </li>
                                    </ul><!--đã login-->
                                {% else %}
                                    <ul class="main-nav">
                                        <li><a href="javascript:void(0)" class="cd-signup"><i class="fa fa-user"></i> Đăng ký</a>|</li>
                                        <li><a href="javascript:void(0)" class="cd-signin"><i class="fa fa-lock"></i> Đăng nhập</a></li>
                                    </ul>
                                {% endif %}


                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End-header-top-->
            <div class="navbar-header">
                <div class="container">
                    <button data-target=".navbar-collapse" data-toggle="collapse"
                            class="navbar-toggle btn responsive-menu collapsed" type="button">
                        <span class="sr-only">menu</span>
                    </button>

                </div>
                <!-- /.container -->
            </div>
            <!-- /.navbar-header -->
            <div id="sticky-menu" class="navbar-collapse collapse">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <ul class="sm sm-clean" id="main-menu">
                                <li><a href="/" class="active"><i class="fa fa-home"></i></a></li>
                                {% for item in listcategory_header %}
                                    <li>
                                        <a href="/{{ item['link'] }}" class="has-submenu">
                                            {% if item['child'] is defined %}
                                                <span class="sub-arrow">+</span>
                                            {% endif %}
                                            {{ item['title'] }}
                                        </a>
                                        {% if item['child'] is defined %}
                                            <ul>
                                                {% if item['countchildcolumn'] <= 1 %}
                                                    {% for itemchild in item['child'] %}
                                                        <li>
                                                            <a href="{{ itemchild['link'] }}">{{ itemchild['title'] }}</a>
                                                        </li>
                                                    {% endfor %}
                                                {% else %}
                                                    <li>
                                                        <!-- The mega drop down contents -->
                                                        <div class="mega-menu colum{{ item['countchildcolumn'] }}">
                                                            {% set cssColumn = 12 / item['countchildcolumn'] %}
                                                            {% set cssColumn = "col-md-" ~ cssColumn ~ " col-sm-" ~ cssColumn %}
                                                            {% for indexItemChild, itemchild in item['child'] %}
                                                                {% if indexItemChild % 6 == 0 %}
                                                                    <div class="{{ cssColumn }} col-xs-12">
                                                                    <div class="bvmenu">
                                                                {% endif %}
                                                                <a href="{{ itemchild['link'] }}">{{ itemchild['title'] }}</a>
                                                                {% if indexItemChild % 6 == 5 or loop.last %}
                                                                    </div>
                                                                    </div>
                                                                {% endif %}
                                                            {% endfor %}
                                                        </div>
                                                    </li>
                                                {% endif %}

                                            </ul>
                                        {% endif %}
                                    </li>
                                {% endfor %}

                            </ul>
                            <!-- /.nav -->
                            {% if session['_id'] %}
                                <div class="pull-right"><i class="fa fa-cloud-upload fa-lg"></i>
                                    <a data-target="#postmusic" data-toggle="modal" href="javascript:void(0)"> Đăng nhạc!</a>
                                </div>
                            {% else %}
                                <div class="pull-right main-nav"><i class="fa fa-cloud-upload fa-lg"></i>
                                    <a class="cd-login" href="javascript:void(0)"> Đăng nhạc!</a>
                                </div>
                            {% endif %}
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.sticky-menu -->
        </div>
        <!-- /.navbar-collapse -->

    </section>
</header>