<footer>
    <div class="container">
        <div class="row">
            <?php $v2737003169237636241iterator = $listCategory_footer; $v2737003169237636241incr = 0; $v2737003169237636241loop = new stdClass(); $v2737003169237636241loop->length = count($v2737003169237636241iterator); $v2737003169237636241loop->index = 1; $v2737003169237636241loop->index0 = 1; $v2737003169237636241loop->revindex = $v2737003169237636241loop->length; $v2737003169237636241loop->revindex0 = $v2737003169237636241loop->length - 1; ?><?php foreach ($v2737003169237636241iterator as $index => $itemFooterMenu) { ?><?php $v2737003169237636241loop->first = ($v2737003169237636241incr == 0); $v2737003169237636241loop->index = $v2737003169237636241incr + 1; $v2737003169237636241loop->index0 = $v2737003169237636241incr; $v2737003169237636241loop->revindex = $v2737003169237636241loop->length - $v2737003169237636241incr; $v2737003169237636241loop->revindex0 = $v2737003169237636241loop->length - ($v2737003169237636241incr + 1); $v2737003169237636241loop->last = ($v2737003169237636241incr == ($v2737003169237636241loop->length - 1)); ?>
                <?php if ($index % 5 == 0) { ?>
                    <div class="col-md-2 col-sm-3 col-xs-6">
                    <ul class="list1">
                <?php } ?>
                <li><a href="<?php echo $itemFooterMenu['link']; ?>"><?php echo $itemFooterMenu['title']; ?></a></li>
                <?php if ($index % 5 == 4 || $v2737003169237636241loop->last) { ?>
                    </ul>
                    </div>
                <?php } ?>
            <?php $v2737003169237636241incr++; } ?>

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
                
                </p>
            </div>
        </div>
    </div>
</footer>


