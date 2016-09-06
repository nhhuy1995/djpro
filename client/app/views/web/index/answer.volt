<script type="text/javascript">
    $(document).ready(function () {
        $(".accordion-desc").fadeOut(0);
        $(".accordion").click(function () {
            $(".accordion-desc").not($(this).next()).slideUp('fast');
            $(this).next().slideToggle(400);
        });
    });
</script>
<style>
    .breadcrumbs li a {
        color: #C73030;
    }
</style>
{% include "/layouts/header.volt" %}
<div id="content">
    <div class="bg-rss-index">
        <div class="container">
            {% include "/layouts/breadcrumb.volt" %}
        </div>
        <div class="container">
            <div class="row">
                {#<div class="td_heading"><h2><a href="#">Hỏi đáp</a><i class="fa fa-angle-right"></i></h2></div>#}
                {% for key,item in listanswer %}
                    <div class="accordion">
                        <a href="javascript:void(0)"><h4>{{ key+1 }}. {{ item['name'] }}</h4><i class="fa fa-question"></i></a>
                    </div>
                    <div class="accordion-desc">
                        <p>
                            {{ item['content'] }}
                        </p>
                        <p>
                        </p>
                    </div>
                {% endfor %}

            </div>
        </div>
    </div>

</div>

<!--===================footer=====================-->
{% include "/layouts/footer.volt" %}