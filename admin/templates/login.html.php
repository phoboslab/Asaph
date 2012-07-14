<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>Login: Asaph</title>
	<link rel="stylesheet" type="text/css" href="<?php echo Asaph_Config::$absolutePath; ?>admin/templates/admin.css" />
	<link rel="Shortcut Icon" href="<?php echo Asaph_Config::$absolutePath; ?>admin/templates/asaph.ico" />
</head>
<body class="Asaph_Post" onload="document.getElementById('name').focus();">

	<div id="menu">
		<h1>Asaph</h1>
	</div>

	<div id="content">
		<h2>Login</h2>
		<form action="<?php echo Asaph_Config::$absolutePath; ?>admin/" method="post">
			<input type="hidden" name="login" value="1"/>
			
			<?php if( !empty($loginError) ) { ?><span class="warn">The name or password was not correct!</span><?php } ?>
			<dl>
				<dt>Name:</dt>
				<dd><input id="name" type="text" name="name" value=""/></dd>
				<dt>Password:</dt>
				<dd><input type="password" name="pass" value=""/></dd>
				<dt></dt>
				<dd><input type="submit" name="dologin" value="Login" class="button"/></dd>
			</dl>
		</form>
	</div>
	<div class="clear"></div>
</body>
</html>
