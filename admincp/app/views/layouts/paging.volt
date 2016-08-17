<div class="row">
    <div class="col-sm-12">
        <ul class="pagination pull-right p-r-10">
            <ul class="pagination">
                <li class="prev"><a class="button" href="{{ painginfo['currentlink'] }}p={{ painginfo['page']-1<=1?1:painginfo['page']-1 }}"><i class="md md-chevron-left"></i></a></li>
                {% for index,item in painginfo['rangepage'] %}
                    <li class="page-{{ index+1 }} {{ item==painginfo['page']?"active":"" }}"><a class="button bgm-blue" href="{{ painginfo['currentlink'] }}p={{ item }}">{{ item }}</a></li>
                {% endfor %}
                <li class="next"><a class="button" href="{{ painginfo['currentlink'] }}p={{ painginfo['page']+1>=painginfo['totalpage']?painginfo['totalpage']:painginfo['page']+1 }}"><i class="md md-chevron-right"></i></a></li>
            </ul>
        </ul>
    </div>
</div>

