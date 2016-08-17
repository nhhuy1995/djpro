<footer>
    <div class="container">
        <div class="row">
            {% for index, itemFooterMenu in listCategory_footer %}
                {% if index % 5 == 0 %}
                    <div class="col-md-2 col-sm-3 col-xs-6">
                    <ul class="list1">
                {% endif %}
                <li><a href="{{ itemFooterMenu['link'] }}">{{ itemFooterMenu['title'] }}</a></li>
                {% if index % 5 == 4 or loop.last %}
                    </ul>
                    </div>
                {% endif %}
            {% endfor %}

            <div class="col-md-4 col-sm-12 col-xs-12">
                <div class="share">
                    <h2>Share online</h2>
                    <ul class="social">
                        <li><a href="#" title="" class="tooltip-top" rel="nofollow"
                               data-original-title="Share Facebook"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="#" title="" class="tooltip-top" rel="nofollow"
                               data-original-title="Share Google +"><i class="fa fa-google-plus"></i></a></li>
                        <li><a href="#" title="" class="tooltip-top" rel="nofollow" data-original-title="Share Twitter"><i
                                        class="fa fa-twitter"></i></a></li>
                        <li><a href="#" title="" class="tooltip-top" rel="nofollow"
                               data-original-title="Share Instagram"><i class="fa fa-instagram"></i></a></li>
                    </ul>
                </div>
                {#<p class="privacy">&copy; <span>2015</span> Design by ldhiep.design@gmail.com &nbsp;|&nbsp;<a href="#">www.dj.pro.vn</a>#}
                </p>
            </div>
        </div>
    </div>
</footer>


