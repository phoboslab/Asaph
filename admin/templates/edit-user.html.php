<?php include(ASAPH_PATH.'admin/templates/head.html.php'); ?>

<h2>Edit User: <?php echo sprintf("%03d", $user['id']); ?></h2>
<form action="<?php echo Asaph_Config::$absolutePath; ?>admin/" method="post">
	<?php if( !empty($status) ) { ?>
		<div class="warn">
			<?php if( $status == 'passwords-not-equal' ) { ?>The passwords do not match<?php } ?>
			<?php if( $status == 'username-empty' ) { ?>The username was empty<?php } ?>
		</div>
	<?php } ?>
	<input type="hidden" name="id" value="<?php echo $user['id']; ?>"/>
	<dl>
		<dt>Name:</dt>
		<dd><input type="text" name="name" class="long" value="<?php echo $user['name']; ?>"/></dd>
		
		<dt>Password:</dt>
		<dd>
			<input type="password" name="password" value=""/>
			(leave empty if you don't want to change it)
		</dd>
		
		<dt>(repeat):</dt>
		<dd><input type="password" name="password2" value=""/></dd>
		<dt></dt>
		<dd>
			<input type="submit" name="updateUser" value="Save" class="button"/>
			<input type="submit" name="deleteUser" value="Delete" class="button" onclick="return confirm('Really delete this User and all Posts associated with it?');"/>
		</dd>
	</dl>
</form>

<?php include(ASAPH_PATH.'admin/templates/foot.html.php'); ?>