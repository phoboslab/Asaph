<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title><?php echo htmlspecialchars( Asaph_Config::$title ); ?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo Asaph_Config::$absolutePath; ?>templates/stickney/stickney.css" />
	<link rel="Shortcut Icon" href="<?php echo Asaph_Config::$absolutePath; ?>templates/stickney/asaph.ico" />
	<script type="text/javascript" src="<?php echo Asaph_Config::$absolutePath; ?>templates/stickney/whitebox.js"></script>
</head>
<body>

<div id="title">
	<em><a href="<?php echo ASAPH_LINK_PREFIX ?>about">about</a></em>
	<h1><a href="<?php echo Asaph_Config::$absolutePath; ?>"><?php echo htmlspecialchars( Asaph_Config::$title ); ?></a></h1>
</div>

<p>
	<?php /* Write whatever you want here, but please leave a link to phoboslab/asaph somewhere! */ ?>
	This microblog is powered by <a href="http://www.phoboslab.org/projects/asaph">Asaph</a>.
</p>

</body>
</html>