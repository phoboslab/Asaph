<?php include(ASAPH_PATH.'admin/templates/head.html.php'); ?>

<h2>Add User</h2>
<form action="<?php echo Asaph_Config::$absolutePath; ?>admin/" method="post">
	<?php if( !empty($status) ) { ?>
		<div class="warn">
			<?php if( $status == 'passwords-not-equal' ) { ?>The passwords do not match<?php } ?>
			<?php if( $status == 'username-empty' ) { ?>The username was empty<?php } ?>
		</div>
	<?php } ?>
	<dl>
		<dt>Name:</dt>
		<dd><input id="title" type="text" name="name" class="long" value="<?php echo !empty($_POST['name']) ? $_POST['name'] : '' ; ?>"/></dd>
		
		<dt>Password:</dt>
		<dd>
			<input id="title" type="password" name="password" value=""/>
		</dd>
		
		<dt>(repeat):</dt>
		<dd><input id="title" type="password" name="password2" value=""/></dd>
		<dt></dt>
		<dd>
			<input type="submit" name="addUser" value="Add User" class="button"/>
		</dd>
	</dl>
</form>

<?php include(ASAPH_PATH.'admin/templates/foot.html.php'); ?>