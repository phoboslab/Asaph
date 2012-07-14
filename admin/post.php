<?php
define( 'ASAPH_PATH', '../' );
require_once( ASAPH_PATH.'lib/asaph_post.class.php' );

header( 'Content-type: text/html; charset=utf-8' );

$asaphPost = new Asaph_Post();
if( isset($_POST['login']) ) {
	if( $asaphPost->login($_POST['name'], $_POST['pass']) ) {
		include( ASAPH_PATH.'admin/templates/remote-post.html.php' );
	}
	else {
		$loginError = true;
		include( ASAPH_PATH.'admin/templates/remote-login.html.php' );
	}
}
else if( !empty($_POST['post']) && (!empty($_POST['image']) || !empty($_POST['url'])) ) {
	if( !empty($_POST['image']) ) {
		$status = $asaphPost->postImage( $_POST['image'], $_POST['referer'], $_POST['title'] );
	}
	if( !empty($_POST['url']) ) {
		$status = $asaphPost->postUrl( $_POST['url'], $_POST['title'] );
	}
	
	if( $status === true ) {
		include( ASAPH_PATH.'admin/templates/remote-success.html.php' );
	} else {
		include( ASAPH_PATH.'admin/templates/remote-post.html.php' );
	}
} else if( $asaphPost->checkLogin() ) {
	include( ASAPH_PATH.'admin/templates/remote-post.html.php' );
} else {
	include( ASAPH_PATH.'admin/templates/remote-login.html.php' );
}


// Shortcut function to echo request data in templates
function printReqVar( $s ) {
	if( !empty($_POST[$s]) ) {
		echo htmlspecialchars($_POST[$s]);
	} else if( !empty($_GET[$s]) ) {
		echo htmlspecialchars($_GET[$s]);
	}
}
?>