<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc><?php echo $domainUri; ?></loc>
        <changefreq>always</changefreq>
        <priority>1.0</priority>
    </url>

    
    <?php foreach ($listCategorys as $category) { ?>
        <url>
            <loc><?php echo $domainUri; ?>/<?php echo $category['link']; ?></loc>
            <changefreq>monthly</changefreq>
            <priority>0.9</priority>
        </url>
        <?php if ($category['child']) { ?>
            <?php foreach ($category['child'] as $child) { ?>
                <url>
                    <loc><?php echo $domainUri; ?><?php echo $child['link']; ?></loc>
                    <changefreq>monthly</changefreq>
                    <priority>0.9</priority>
                </url>
            <?php } ?>
        <?php } ?>
    <?php } ?>

</urlset>