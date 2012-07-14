<?php include(ASAPH_PATH.'admin/templates/head.html.php'); ?>

<h2>Posts</h2>
<table class="posts">
	<tr>
		<th>Image</th>
		<th>Title/Text</th>
		<th>Date/User</th>
	</tr>
	<?php foreach( $posts as $i => $p ) { ?>
		<tr class="<?php echo $i%2 ? 'odd' : 'even' ; ?>">
			<td class="image">
				<?php if( $p['thumb'] ) { ?>
					<a href="?post=<?php echo $p['id'];?>"><img src="<?php echo $p['thumb']; ?>" alt=""/></a>
				<?php } ?>
			</td>
			<td class="text">
				<a href="?post=<?php echo $p['id'];?>"><?php echo empty($p['title']) ? '<em>none</em>' : $p['title']; ?></a>
				<div class="source">via: <a href="<?php echo $p['source']; ?>"><?php echo $p['sourceDomain']; ?></a></div>
			</td>
			<td class="date">
				<?php echo date( 'Y.m.d - H:i', $p['created'] ); ?>
				<div class="user"><?php echo $p['user']; ?></div>
			</td>
		</tr>
	<?php } ?>
</table>


<div id="pages">
	<div class="pageInfo">
		page <?php echo $pages['current']; ?> of <?php echo $pages['total']; ?>
	</div>
	
	<div class="pageLinks">
		<?php if( $pages['prev'] ) { ?>
			<a href="?posts&amp;page=<?php echo $pages['prev']?>">&laquo; prev</a>
		<?php } else { ?>
			&laquo; prev
		<?php } ?>
		/
		<?php if( $pages['next'] ) { ?>
			<a href="?posts&amp;page=<?php echo $pages['next']?>">next &raquo;</a>
		<?php } else { ?>
			next &raquo;
		<?php } ?>
	</div>
</div>

<?php include(ASAPH_PATH.'admin/templates/foot.html.php'); ?>