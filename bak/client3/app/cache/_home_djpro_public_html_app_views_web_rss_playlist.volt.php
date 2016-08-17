<rss version="2.0">
    <channel>
        <title><?php echo $headerName; ?> - <?php echo Phalcon\Text::upper($sitename); ?></title>
        <description><?php echo $headerName; ?> - <?php echo Phalcon\Text::upper($sitename); ?></description>
        <link><?php echo $domainUri; ?></link>
        <copyright><?php echo Phalcon\Text::upper($sitename); ?></copyright>
        <generator><?php echo Phalcon\Text::upper($sitename); ?>:<?php echo Phalcon\Text::upper($sitename); ?></generator>
        <pubDate><?php echo date('d-m-Y'); ?></pubDate>
        <lastBuildDate><?php echo date('d-m-Y'); ?></lastBuildDate>

        
    <?php foreach ($listPlaylist as $item) { ?>
        <item>

            <title><![CDATA[ <?php echo $item['name']; ?> ]]></title>

            <description><![CDATA[ <a href="<?php echo $item['link']; ?>"><img width="140px" src="<?php echo $item['priavatar']; ?>" /><br/></a> <?php echo $item['description']; ?>]]></description>

            <link><?php echo $item['link']; ?></link>

            <pubDate><?php echo $item['public_date']; ?></pubDate>

        </item>
    <?php } ?>

    </channel>
</rss>