<footer>
    <div class="container">
        
        <div class="row">
            <?php $v16896070505752363301iterator = $listCategory_footer; $v16896070505752363301incr = 0; $v16896070505752363301loop = new stdClass(); $v16896070505752363301loop->length = count($v16896070505752363301iterator); $v16896070505752363301loop->index = 1; $v16896070505752363301loop->index0 = 1; $v16896070505752363301loop->revindex = $v16896070505752363301loop->length; $v16896070505752363301loop->revindex0 = $v16896070505752363301loop->length - 1; ?><?php foreach ($v16896070505752363301iterator as $item) { ?><?php $v16896070505752363301loop->first = ($v16896070505752363301incr == 0); $v16896070505752363301loop->index = $v16896070505752363301incr + 1; $v16896070505752363301loop->index0 = $v16896070505752363301incr; $v16896070505752363301loop->revindex = $v16896070505752363301loop->length - $v16896070505752363301incr; $v16896070505752363301loop->revindex0 = $v16896070505752363301loop->length - ($v16896070505752363301incr + 1); $v16896070505752363301loop->last = ($v16896070505752363301incr == ($v16896070505752363301loop->length - 1)); ?>
                <div class="col-md-2 col-sm-3 col-xs-6">
                    <ul class="list1">
                        <li style="font-weight: bold;;"><a href="<?php echo $item['link']; ?>" alt="<?php echo $item['title']; ?>" title="<?php echo $item['title']; ?>"><?php echo $item['title']; ?></a></li>
                        <?php if (isset($item['child'])) { ?>
                            <?php $v16896070505752363302iterator = $item['child']; $v16896070505752363302incr = 0; $v16896070505752363302loop = new stdClass(); $v16896070505752363302loop->length = count($v16896070505752363302iterator); $v16896070505752363302loop->index = 1; $v16896070505752363302loop->index0 = 1; $v16896070505752363302loop->revindex = $v16896070505752363302loop->length; $v16896070505752363302loop->revindex0 = $v16896070505752363302loop->length - 1; ?><?php foreach ($v16896070505752363302iterator as $child) { ?><?php $v16896070505752363302loop->first = ($v16896070505752363302incr == 0); $v16896070505752363302loop->index = $v16896070505752363302incr + 1; $v16896070505752363302loop->index0 = $v16896070505752363302incr; $v16896070505752363302loop->revindex = $v16896070505752363302loop->length - $v16896070505752363302incr; $v16896070505752363302loop->revindex0 = $v16896070505752363302loop->length - ($v16896070505752363302incr + 1); $v16896070505752363302loop->last = ($v16896070505752363302incr == ($v16896070505752363302loop->length - 1)); ?>
                                <li><a href="<?php echo $child['link']; ?>" alt="<?php echo $child['title']; ?>" title="<?php echo $child['title']; ?>"><?php echo $child['title']; ?></a></li>
                            <?php $v16896070505752363302incr++; } ?>
                        <?php } ?>
                    </ul>
                </div>
            <?php $v16896070505752363301incr++; } ?>
            <div class="col-md-2 col-sm-3 col-xs-6">
                <ul class="list1">
                    <li><a href="/dieu-khoan-thoa-thuan.html">Điều khoản thảo thuận</a></li>
                    <li><a href="/chinh-sach-rieng-tu.html">Chính sách riêng tư</a></li>
                    <li><a href="/chinh-sach-ban-quyen.html">Chính sách bản quyền</a></li>
                    <li><a href="/lien-he.html">Liên hệ</a></li>
                    <li><a href="#">Quảng cáo</a></li>
                </ul>
            </div>

            <div class="col-md-4 col-sm-12 col-xs-12">
                <div class="share">
                    <h2>Share online</h2>
                    <ul class="social">
                        <li><a rel="nofollow" class="tooltip-top" title="Share Facebook" href="#"><i class="fa fa-facebook"></i></a></li>
                        <li><a rel="nofollow" class="tooltip-top" title="Share Google +" href="#"><i class="fa fa-google-plus"></i></a></li>
                        <li><a rel="nofollow" class="tooltip-top" title="Share Twitter" href="#"><i class="fa fa-twitter"></i></a></li>
                        <li><a rel="nofollow" class="tooltip-top" title="Share Instagram" href="#"><i class="fa fa-instagram"></i></a></li>
                    </ul>
                </div>
                
            </div>
        </div>
    </div>
</footer>


