{% include "/layouts/header.volt" %}
<div id="content">
    <div class="bg-news">
        <div class="container">
            <ul class="breadcrumbs">
                <li><a href="/"><i class="fa fa-home fa-lg"></i></a></li>
                {% if object.type == 'news' %}
                    <li><a href="/tin-tuc.html">Tin tức</a></li>
                {% else %}
                    <li><a href="/anh.html">Ảnh</a></li>
                {% endif %}
                {% for item in listcategory %}
                    <li><a href="{{ item['link'] }}">{{ item['name'] }}</a></li>
                {% endfor %}
            </ul>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-ldh-9 col-sm-8">

                    <div class="row">
                        <div class="bg-news">
                            <article class="thumbnail-news-view">
                                <h2>{{ object.name }}</h2>
                                <div id="block_description">
                                    <p>{{ object.description }}</p>
                                </div>
                                {#<figure class="featured-thumbnail large"><img src="/web/images/htl_2_1.jpg" alt="">
                                </figure>#}
                                <div class="post_content">
                                    {{ object.content }}
                                </div>
                                <div class="block_timer_share">
                                    <div class="block_timer2 pull-left">
                                        <p class="boutdislike">
                                            <i class="fa fa-user"></i> Người gửi:
                                            <a href="{{ object.usercreatelink }}"
                                               style="{% if object.is_role ==1 %} color: #c73030;{% else %} color: #176093;{% endif %}"
                                               title="{{ object.usercreate }}">{{ object.usercreate }}</a>
                                            <span class="role_user">{{ object.usercreate_namerole }}</span>
                                            &nbsp;&nbsp;
                                            <i class="fa fa-calendar-o"></i> {{ date('d/m/y | H:i:s',object.datecreate) }}
                                        </p>

                                    </div>
                                    <input type="hidden" id="url_article" value="{{ currentLink }}"/>
                                    <div class="block_share pull-right">
                                        <a rel="nofollow" href="javascript:void(0)" onclick="share_facebook()" title="Chia sẻ bài viết lên facebook">
                                            <img alt="" src="/web/skins/images/icon_fb.gif"></a>
                                        <a rel="nofollow" href="javascript:void(0)" onclick="share_twitter()" data-url="" title="Chia sẻ bài viết lên twitter">
                                            <img alt="" src="/web/skins/images/icon_tw.gif"></a>
                                        <a rel="nofollow" href="javascript:void(0)" onclick="share_goole()" title="Chia sẻ bài viết lên google+">
                                            <img alt="" src="/web/skins/images/icon_google.gif"></a>
                                    </div>
                                </div>
                                <input type="hidden" id="type" value="news">
                                {% if session['_id'] %}
                                    <ul class="media-func">
                                        <li><i class="fa fa-eye"> {{ object.view }}</i> lượt xem</li>
                                        <li>
                                            <span class="boutlike">
                                                <i class="fa fa-thumbs-up"
                                                   id="icon-like" {% if check_like._id %} style="color: blue;" {% endif %}></i> {{ object.like }}
                                            </span>
                                            <a href="javascript:void(0)"
                                               onclick="likeArticle(this);"
                                               like="{{ object.like }}"
                                               checklike="{{ check_like._id>0 ? 1:0 }}"
                                               data-id="{{ object._id }}">Thích
                                            </a>
                                        </li>
                                        <li>
                                             <span class="boutdislike">
                                            <i class="fa fa-thumbs-down"
                                               id="icon-dislike" {% if check_dislike._id %} style="color: blue;" {% endif %}></i> {{ object.dislike }}
                                                 </span>
                                            <a href="javascript:void(0)" onclick="dislikeArticle(this);"
                                               data-id="{{ object._id }}" checklike="{{ check_dislike._id>0 ? 1:0 }}">Không
                                                thích</a>
                                        </li>
                                    </ul>
                                {% else %}
                                    <ul class="media-func">
                                        <li class=""><i class="fa fa-eye"> {{ object.view }}</i> lượt xem</li>
                                        <li class="main-nav">
                                            <i class="fa fa-thumbs-up"></i> {{ object.like }}
                                            <a class="cd-signin" href="javascript:void(0)">Thích </a>
                                        </li>
                                        <li class="main-nav">
                                            <i class="fa fa-thumbs-down"></i> {{ object.dislike }}
                                            <a class="cd-signin" href="javascript:void(0)">Không thích</a>
                                        </li>
                                    </ul>
                                {% endif %}
                                {% if listtags %}
                                    <div class="block_timer pull-left"><span class="tags">
                                                    <strong><i class="fa fa-tags"></i> Tags:</strong>
                                            {% for item in listtags %}
                                                <a href="{{ item['link'] }}">{{ item['name'] }}</a> &nbsp;
                                            {% endfor %}

                                        </span> &nbsp;&nbsp;&nbsp;&nbsp;
                                    </div>
                                {% endif %}
                                <div style="clear: both"></div>
                                {% include '/layouts/comment.volt' %}
                                <ul class="other-news-detail">
                                    {% if object.type == 'news' %}
                                        <h2><span>Tin liên quan</span></h2>
                                    {% else %}
                                        <h2><span>Ảnh liên quan</span></h2>
                                    {% endif %}
                                    {% for item in articlerelative %}
                                        <li>
                                            <span><a href="{{ item['link'] }}"
                                                     title="{{ item['name'] }}"> {{ item['name'] }}</a></span>
                                        </li>
                                    {% endfor %}
                                </ul>
                            </article>


                        </div>

                    </div>

                </div>

                {% include "/layouts/siderbar_right.volt" %}
            </div>
        </div>
    </div>

</div>
{% include "/layouts/footer.volt" %}
<script type="text/javascript" src="/web/js/myfunction.js"></script>
<script>
    var p = 1;
    $(document).ready(function () {
        loadComment();
    });
    function loadComment() {
        //check button viewmore comment
        var totalpage = {{ total_page_comment }};
        var atid = {{ object._id}};
        $.get("/incoming/loadcomment", {atid: atid, p: p}, function (re) {
            var data = re.data;
            var html = '';
            if (data != null) {
                htmlComment(data, p, atid);
                p++;
            }
        });
        if (p >= totalpage) $('.viewmore').hide();

    }
    function likeMedia(obj) {
        var checklike = $(obj).attr('checklike');
        var atid = $(obj).data('id');
        var type = $('#type').val();
        var total_like = parseInt($(obj).attr('like'));
        $.get("/incoming/likemedia", {atid: atid, checklike: checklike, type: type}, function (re) {
            if (re.status == 200) {
                if (checklike == 0) {
                    $(obj).attr('checklike', 1);
                    $('#icon-like').css('color', 'blue');
                }
                else if (checklike == 1) {
                    $(obj).attr('checklike', 0);
                    $('#icon-like').css('color', '#c73030');
                }
                alert(re.mss);
            }
            else {
                alert(re.mss);
            }
        });
    }

    function dislikeMedia(obj) {
        var type = $('#type').val();
        var checklike = $(obj).attr('checklike');
        var atid = $(obj).data('id');
        var total_like = $(obj).like;
        $.get("/incoming/dislikemedia", {atid: atid, checklike: checklike, type: type}, function (re) {
            if (re.status == 200) {
                if (checklike == 0) {
                    $(obj).attr('checklike', 1);
                    $('#icon-dislike').css('color', 'blue');
                }
                else if (checklike == 1) {
                    $(obj).attr('checklike', 0);
                    $('#icon-dislike').css('color', '#c73030');
                }
                alert(re.mss);
            }
            else {
                alert(re.mss);
            }
        });
    }
</script>