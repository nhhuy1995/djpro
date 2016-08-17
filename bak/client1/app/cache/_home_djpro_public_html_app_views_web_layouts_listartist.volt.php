<div class="hide-ns">
    <?php if ($item['listartist']) { ?>
    <?php $v2737003169237636241iterator = $item['listartist']; $v2737003169237636241incr = 0; $v2737003169237636241loop = new stdClass(); $v2737003169237636241loop->length = count($v2737003169237636241iterator); $v2737003169237636241loop->index = 1; $v2737003169237636241loop->index0 = 1; $v2737003169237636241loop->revindex = $v2737003169237636241loop->length; $v2737003169237636241loop->revindex0 = $v2737003169237636241loop->length - 1; ?><?php foreach ($v2737003169237636241iterator as $itemchild) { ?><?php $v2737003169237636241loop->first = ($v2737003169237636241incr == 0); $v2737003169237636241loop->index = $v2737003169237636241incr + 1; $v2737003169237636241loop->index0 = $v2737003169237636241incr; $v2737003169237636241loop->revindex = $v2737003169237636241loop->length - $v2737003169237636241incr; $v2737003169237636241loop->revindex0 = $v2737003169237636241loop->length - ($v2737003169237636241incr + 1); $v2737003169237636241loop->last = ($v2737003169237636241incr == ($v2737003169237636241loop->length - 1)); ?>
    <a class="subtitle" href="<?php echo $itemchild['link']; ?>"
       title="<?php echo $itemchild['username']; ?>"><?php echo $itemchild['username']; ?></a><?php if (!$v2737003169237636241loop->last) { ?><span class="bull" style="font-size:12px;">Ft </span><?php } ?>
    <?php $v2737003169237636241incr++; } ?>
    <span class="paragraph-end"></span>
    <?php } ?>
</div>