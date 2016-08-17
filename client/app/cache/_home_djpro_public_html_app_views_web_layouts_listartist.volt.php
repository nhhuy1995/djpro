<div class="hide-ns">
    <?php if ($item['listartist']) { ?>
    <?php $v16896070505752363301iterator = $item['listartist']; $v16896070505752363301incr = 0; $v16896070505752363301loop = new stdClass(); $v16896070505752363301loop->length = count($v16896070505752363301iterator); $v16896070505752363301loop->index = 1; $v16896070505752363301loop->index0 = 1; $v16896070505752363301loop->revindex = $v16896070505752363301loop->length; $v16896070505752363301loop->revindex0 = $v16896070505752363301loop->length - 1; ?><?php foreach ($v16896070505752363301iterator as $itemchild) { ?><?php $v16896070505752363301loop->first = ($v16896070505752363301incr == 0); $v16896070505752363301loop->index = $v16896070505752363301incr + 1; $v16896070505752363301loop->index0 = $v16896070505752363301incr; $v16896070505752363301loop->revindex = $v16896070505752363301loop->length - $v16896070505752363301incr; $v16896070505752363301loop->revindex0 = $v16896070505752363301loop->length - ($v16896070505752363301incr + 1); $v16896070505752363301loop->last = ($v16896070505752363301incr == ($v16896070505752363301loop->length - 1)); ?>
    <a class="subtitle" href="<?php echo $itemchild['link']; ?>"
       title="<?php echo $itemchild['username']; ?>"><?php echo $itemchild['username']; ?></a><?php if (!$v16896070505752363301loop->last) { ?><span class="bull" style="font-size:12px;">Ft </span><?php } ?>
    <?php $v16896070505752363301incr++; } ?>
    <span class="paragraph-end"></span>
    <?php } ?>
</div>