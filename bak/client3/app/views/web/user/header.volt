<header id="header">
    <section class="bg">
        <div class="navbar">

            <div class="navbar-header">
                <div class="container">
                    <button type="button" class="navbar-toggle btn responsive-menu collapsed" data-toggle="collapse"
                            data-target=".navbar-collapse">
                        <span class="sr-only">menu</span>
                    </button>
                </div>
                <!-- /.container -->
            </div>
            <!-- /.navbar-header -->
            <div class="navbar-collapse collapse">
                <div class="container">
                    <div class="row">
                        <ul class="sm sm-clean" id="main-menu">
                            <li><a href="/" class="active"><i class="fa fa-home"></i></a></li>
                            {% for item in listcategory_header %}
                                <li>
                                    <a href="{{ item['link'] }}" class="has-submenu">
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
                    </div>
                </div>
                <!-- /.container -->
            </div>
            <!-- /.navbar-collapse -->
        </div>
    </section>

</header>
 