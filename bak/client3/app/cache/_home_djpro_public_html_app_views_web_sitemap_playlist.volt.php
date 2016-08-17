<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc><?php echo $domainUri; ?></loc>
        <changefreq>always</changefreq>
        <priority>1.0</priority>
    </url>

    
    <?php foreach ($listPlaylist as $playlist) { ?>
        <url>
            <loc><?php echo $playlist['link']; ?></loc>
            <changefreq>always</changefreq>
            <priority>0.9</priority>
        </url>
    <?php } ?>

</urlset>