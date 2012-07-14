<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>Admin: Asaph</title>
	<link rel="stylesheet" type="text/css" href="<?php echo Asaph_Config::$absolutePath; ?>admin/templates/admin.css" />
	<link rel="Shortcut Icon" href="<?php echo Asaph_Config::$absolutePath; ?>admin/templates/asaph.ico" />
</head>
<body>


<div id="menu">
	<h1>Asaph</h1>
	<a href="?posts">Posts</a>
	<a href="?users">Users</a>
	
	
	<a class="logout" href="?logout">Logout</a>

	Bookmarklet:
	<a class="bookmarklet" title="Post Bookmarklet" href="javascript:void((function(){var%20e=document.createElement('script');e.type='text/javascript';e.src='<?php echo ASAPH_POST_JS; ?>';document.body.appendChild(e)})());">Asaph</a>
</div>

<div id="content">
