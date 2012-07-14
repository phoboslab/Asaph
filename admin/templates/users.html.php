<?php include(ASAPH_PATH.'admin/templates/head.html.php'); ?>

<h2>Users</h2>
<?php foreach( $users as $u ) { ?>
	<div>
		<?php echo sprintf("%03d", $u['id']); ?>. <a href="?user=<?php echo $u['id']; ?>"><?php echo $u['name']; ?></a>
	</div>
<?php } ?>

<h3>
+ <a href="?addUser">Add User</a>
</h3>

<?php include(ASAPH_PATH.'admin/templates/foot.html.php'); ?>