<div class="pagination">
    <ul class="paginationBar">
        <li><a href="<?php echo $painginfo['currentlink']; ?>p=<?php echo ($painginfo['page'] - 1 <= 1 ? 1 : $painginfo['page'] - 1); ?>"
               class="navigation-button"> Trước </a></li>
        <?php foreach ($painginfo['rangepage'] as $index => $item) { ?>
            <li class="<?php echo ($item == $painginfo['page'] ? 'active' : ''); ?>">
                <?php if ($item == $painginfo['page']) { ?>
                    <a class="active"><?php echo $item; ?></a>
                <?php } else { ?>
                    <a href="<?php echo $painginfo['currentlink']; ?>p=<?php echo $item; ?>" class=""><?php echo $item; ?></a>
                <?php } ?>
            </li>
        <?php } ?>
        <li>
            <a href="<?php echo $painginfo['currentlink']; ?>p=<?php echo ($painginfo['page'] + 1 >= $painginfo['totalpage'] ? $painginfo['totalpage'] : $painginfo['page'] + 1); ?>"
               class="navigation-button">Sau</a></li>
    </ul>
</div>

