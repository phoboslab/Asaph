<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>Post: Asaph</title>
	<link rel="stylesheet" type="text/css" href="<?php echo ASAPH_POST_CSS; ?>" />
</head>
<body class="Asaph_Post">
	<h1 id="Asaph_PostSuccess">
		Posted!
	</h1>
	<script type="text/javascript">
		if( parent ) {
			parent.location = "<?php echo addslashes($_POST['xhrLocation']) ?>#Asaph_Success";
		}
	</script>
</body>
</html>