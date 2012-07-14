<?php header('Content-Type: application/rss+xml; charset=utf-8'); echo '<?xml version="1.0" encoding="utf-8"?>';?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
<channel>
	<atom:link href="http://<?php echo Asaph_Config::$domain.ASAPH_LINK_PREFIX ?>feed" rel="self" type="application/rss+xml" />
	<title><?php echo htmlspecialchars( Asaph_Config::$title ); ?></title>
	<link><?php echo ASAPH_BASE_URL; ?></link>
	<description><?php echo htmlspecialchars( Asaph_Config::$title ); ?></description>
	<language>en</language>
	
	<?php foreach( $posts as $p ) { ?>
		<item>
			<title><?php echo $p['title']; ?></title>
			<link><?php echo $p['source']; ?></link>
			<description>
				<?php if( $p['image'] ) { ?>
					&lt;a href=&quot;http://<?php echo Asaph_Config::$domain.$p['image']; ?>&quot;&gt;
						&lt;img src=&quot;http://<?php echo Asaph_Config::$domain.$p['thumb']; ?>&quot; alt=&quot;&quot;/&gt;
					&lt;/a&gt;
				<?php } else { ?>
					&lt;p&gt;
						<?php echo htmlspecialchars(nl2br($p['title'])); ?>
					&lt;/p&gt;
				<?php } ?>
			</description>
			<pubDate><?php echo date('r', $p['created']); ?></pubDate>
			<guid isPermaLink="false"><?php echo ASAPH_BASE_URL.$p['id']; ?></guid>
		</item>
	<?php } ?>

</channel>
</rss>
