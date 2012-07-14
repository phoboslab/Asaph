<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>Login: Asaph</title>
	<link rel="stylesheet" type="text/css" href="<?php echo ASAPH_POST_CSS; ?>" />
</head>
<body class="Asaph_Post" onload="document.getElementById('name').focus();">
	<h1>Login</h1>
	<form action="post.php" method="post">
		<input type="hidden" name="title" value="<?php printReqVar('title'); ?>"/>
		<input type="hidden" name="image" value="<?php printReqVar('image'); ?>"/>
		<input type="hidden" name="referer" value="<?php printReqVar('referer'); ?>"/>
		<input type="hidden" name="url" value="<?php printReqVar('url'); ?>"/>
		<input type="hidden" name="xhrLocation" value="<?php printReqVar('xhrLocation'); ?>"/>
		<input type="hidden" name="login" value="1"/>
		
		<?php if( isset($loginError) ) { ?><span class="warn">The name or password was not correct!</span><?php } ?>
		<dl>
			<dt>Name:</dt>
			<dd><input id="name" type="text" name="name" value=""/></dd>
			<dt>Password:</dt>
			<dd><input type="password" name="pass" value=""/></dd>
			<dt></dt>
			<dd><input type="submit" name="dologin" value="Login" class="button"/></dd>
		</dl>
	</form>
</body>
</html>
