<?php
define( 'ASAPH_PATH', '../' );
require_once( ASAPH_PATH.'lib/asaph_admin.class.php' );

header( 'Content-type: text/html; charset=utf-8' );

$asaphAdmin = new Asaph_Admin( Asaph_Config::$adminPostsPerPage );
if( isset($_POST['login']) ) {
	if( $asaphAdmin->login($_POST['name'], $_POST['pass']) ) {
		header( 'Location: '.Asaph_Config::$absolutePath.'admin/' );
	}
	else {
		$loginError = true;
		include( ASAPH_PATH.'admin/templates/login.html.php' );
	}
}
else if( $asaphAdmin->checkLogin() ) {
	if( isset($_GET['logout']) ) {
		$asaphAdmin->logout();
		header( 'Location: '.Asaph_Config::$absolutePath.'admin/' );
		exit;
	}
	
	// Users
	else if( isset($_GET['users']) ) {
		$users = $asaphAdmin->getUsers();
		include( ASAPH_PATH.'admin/templates/users.html.php' );
	}
	else if( !empty($_GET['user']) ) {
		$user = $asaphAdmin->getUser( $_GET['user'] );
		include( ASAPH_PATH.'admin/templates/edit-user.html.php' );
	}
	else if( isset($_GET['addUser']) ) {
		include( ASAPH_PATH.'admin/templates/add-user.html.php' );
	}
	else if( isset($_POST['deleteUser']) ) {
		$asaphAdmin->deleteUser( $_POST['id'] );
		header( 'Location: '.Asaph_Config::$absolutePath.'admin/?users' );
	}
	else if( isset($_POST['updateUser']) ) {
		$status = $asaphAdmin->updateUser( $_POST['id'], $_POST['name'], $_POST['password'], $_POST['password2'] );
		if( $status === true ) {
			header( 'Location: '.Asaph_Config::$absolutePath.'admin/?users' );
		} else {
			$user = array(
				'id' => intval($_POST['id']),
				'name' => $_POST['name']
			);
			include( ASAPH_PATH.'admin/templates/edit-user.html.php' );
		}
	}
	else if( isset($_POST['addUser']) ) {
		$status = $asaphAdmin->addUser( $_POST['name'], $_POST['password'], $_POST['password2'] );
		if( $status === true ) {
			header( 'Location: '.Asaph_Config::$absolutePath.'admin/?users' );
		} else {
			include( ASAPH_PATH.'admin/templates/add-user.html.php' );
		}
	}
	
	// Posts
	else if( !empty($_GET['post']) ) {
		$post = $asaphAdmin->getPost( $_GET['post'] );
		include( ASAPH_PATH.'admin/templates/edit-post.html.php' );
	}
	else if( isset($_POST['deletePost']) ) {
		$asaphAdmin->deletePost( $_POST['id'] );
		header( 'Location: '.Asaph_Config::$absolutePath.'admin/' );
	}
	else if( isset($_POST['updatePost']) ) {
		$asaphAdmin->updatePost( $_POST['id'], $_POST['created'], $_POST['source'], $_POST['title'] );
		header( 'Location: '.Asaph_Config::$absolutePath.'admin/' );
	}
	else {
		$posts = $asaphAdmin->getPosts( empty($_GET['page']) ? 0 : $_GET['page']-1 );
		$pages = $asaphAdmin->getPages();
		include( ASAPH_PATH.'admin/templates/posts.html.php' );
	}
} else {
	include( ASAPH_PATH.'admin/templates/login.html.php' );
}

?>