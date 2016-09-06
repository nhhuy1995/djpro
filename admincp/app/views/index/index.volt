<style>
    #statistical_obj {
        font-weight: bold;
    }
    #block_media{
        padding-bottom: 15px;
    }
</style>
<div class="container">
    <div class="card">
        <div class="card-header">
            <h2>Thống kê</h2>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12" >
                    <div class="col-md-3">
                        <span>Tổng số Bài hát đã duyệt:</span>
                    </div>
                    <div class="col-md-9">
                        <span id="statistical_obj">{{ media['show'] }}</span>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="col-md-3">
                        <span>Tổng số Bài hát chưa duyệt:</span>
                    </div>
                    <div class="col-md-9">
                        <span id="statistical_obj">{{ media['wait'] }}</span>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="col-md-3">
                        <span>Tổng số Bài hát yêu cầu:</span>
                    </div>
                    <div class="col-md-9">
                        <span id="statistical_obj">{{ media['require'] }}</span>
                    </div>
                </div>
                <div class="col-md-12" id="block_media">
                    <div class="col-md-3">
                        <span>Tổng số Bài hát đã xóa:</span>
                    </div>
                    <div class="col-md-9">
                        <span id="statistical_obj">{{ media['delete'] }}</span>
                    </div>
                </div>

                <div class="col-md-12" >
                    <div class="col-md-3">
                        <span>Tổng số Video đã duyệt:</span>
                    </div>
                    <div class="col-md-9">
                        <span id="statistical_obj">{{ video['show'] }}</span>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="col-md-3">
                        <span>Tổng số Video chưa duyệt:</span>
                    </div>
                    <div class="col-md-9">
                        <span id="statistical_obj">{{ video['wait'] }}</span>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="col-md-3">
                        <span>Tổng số Video yêu cầu:</span>
                    </div>
                    <div class="col-md-9">
                        <span id="statistical_obj">{{ video['require'] }}</span>
                    </div>
                </div>
                <div class="col-md-12" id="block_media">
                    <div class="col-md-3">
                        <span>Tổng số Video đã xóa:</span>
                    </div>
                    <div class="col-md-9">
                        <span id="statistical_obj">{{ video['delete'] }}</span>
                    </div>
                </div>

                <div class="col-md-12" >
                    <div class="col-md-3">
                        <span>Tổng số Chủ đề đã duyệt:</span>
                    </div>
                    <div class="col-md-9">
                        <span id="statistical_obj">{{ topic['show'] }}</span>
                    </div>
                </div>
                <div class="col-md-12" id="block_media">
                    <div class="col-md-3">
                        <span>Tổng số Chủ đề đã xóa:</span>
                    </div>
                    <div class="col-md-9">
                        <span id="statistical_obj">{{ topic['delete'] }}</span>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="col-md-3">
                        <span>Tổng số Album đã duyệt:</span>
                    </div>
                    <div class="col-md-9">
                        <span id="statistical_obj">{{ album['show'] }}</span>
                    </div>
                </div>
                <div class="col-md-12" id="block_media">
                    <div class="col-md-3">
                        <span>Tổng số Album đã xóa:</span>
                    </div>
                    <div class="col-md-9">
                        <span id="statistical_obj">{{ album['delete'] }}</span>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="col-md-3">
                        <span>Tổng số Playlist đã duyệt:</span>
                    </div>
                    <div class="col-md-9">
                        <span id="statistical_obj">{{ playlist['show'] }}</span>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="col-md-3">
                        <span>Tổng số Playlist chưa duyệt:</span>
                    </div>
                    <div class="col-md-9">
                        <span id="statistical_obj">{{ playlist['wait'] }}</span>
                    </div>
                </div>
                <div class="col-md-12" id="block_media">
                    <div class="col-md-3">
                        <span>Tổng số Playlist đã xóa:</span>
                    </div>
                    <div class="col-md-9">
                        <span id="statistical_obj">{{ playlist['delete'] }}</span>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="col-md-3">
                        <span>Tổng số Tin tức đã duyệt:</span>
                    </div>
                    <div class="col-md-9">
                        <span id="statistical_obj">{{ news['show'] }}</span>
                    </div>
                </div>
                <div class="col-md-12" id="block_media">
                    <div class="col-md-3">
                        <span>Tổng số Tin tức đã xóa:</span>
                    </div>
                    <div class="col-md-9">
                        <span id="statistical_obj">{{ news['delete'] }}</span>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="col-md-3">
                        <span>Tổng số Ảnh đã duyệt:</span>
                    </div>
                    <div class="col-md-9">
                        <span id="statistical_obj">{{ images['show'] }}</span>
                    </div>
                </div>
                <div class="col-md-12" id="block_media">
                    <div class="col-md-3">
                        <span>Tổng số Ảnh đã xóa:</span>
                    </div>
                    <div class="col-md-9">
                        <span id="statistical_obj">{{ images['delete'] }}</span>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="col-md-3">
                        <span>Tổng số Nghệ sỹ đã duyệt:</span>
                    </div>
                    <div class="col-md-9">
                        <span id="statistical_obj">{{ artist['show'] }}</span>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="col-md-3">
                        <span>Tổng số Nghệ sỹ chưa duyệt:</span>
                    </div>
                    <div class="col-md-9">
                        <span id="statistical_obj">{{ artist['wait'] }}</span>
                    </div>
                </div>
                <div class="col-md-12" id="block_media">
                    <div class="col-md-3">
                        <span>Tổng số Nghệ sỹ đã xóa:</span>
                    </div>
                    <div class="col-md-9">
                        <span id="statistical_obj">{{ artist['delete'] }}</span>
                    </div>
                </div>

                <div class="col-md-12" id="block_media">
                    <div class="col-md-3">
                        <span>Tổng số Tags:</span>
                    </div>
                    <div class="col-md-9">
                        <span id="statistical_obj">{{ tags['show'] }}</span>
                    </div>
                </div>
                {#<div class="col-md-12" id="block_media">
                    <div class="col-md-3">
                        <span>Tổng số Tags đã xóa:</span>
                    </div>
                    <div class="col-md-9">
                        <span id="statistical_obj">{{ tags['delete'] }}</span>
                    </div>
                </div>#}

                <div class="col-md-12">
                    <div class="col-md-3">
                        <span>Tổng số Comment:</span>
                    </div>
                    <div class="col-md-9">
                        <span id="statistical_obj">{{ comment['show'] }}</span>
                    </div>
                </div>
                {#<div class="col-md-12" id="block_media">
                    <div class="col-md-3">
                        <span>Tổng số Comment đã xóa:</span>
                    </div>
                    <div class="col-md-9">
                        <span id="statistical_obj">{{ comment['delete'] }}</span>
                    </div>
                </div>#}
            </div>
        </div>
    </div>
</div>
