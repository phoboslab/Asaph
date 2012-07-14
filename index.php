<?php 
// Asaph v1.0 - www.phoboslab.org 

define( 'ASAPH_PATH', '' );
require_once( ASAPH_PATH.'lib/asaph.class.php' );

header( 'Content-type: text/html; charset=utf-8' );

// Is mod_rewrite enabled? (see .htaccess)
if( isset($_GET['rw']) ) {
	define( 'ASAPH_LINK_PREFIX', Asaph_Config::$absolutePath );
	$params = explode( '/', $_GET['rw'] );
} else {
	define( 'ASAPH_LINK_PREFIX', Asaph_Config::$absolutePath.'?' );
	$params = empty($_GET) ? array() : explode( '/', key($_GET) );
}


// about page
if( !empty($params[0]) && $params[0] == 'about' ) {
	include( ASAPH_PATH.Asaph_Config::$templates['about'] );
}
// feed
else if( !empty($params[0]) && $params[0] == 'feed' ) {
	$asaph = new Asaph( Asaph_Config::$postsPerPage );
	$posts = $asaph->getPosts( 0 );
	include( ASAPH_PATH.Asaph_Config::$templates['feed'] );
} 
// blog
else {
	$page = !empty($params[1]) ? $params[1]-1 : 0;
	
	$asaph = new Asaph( Asaph_Config::$postsPerPage );
	$posts = $asaph->getPosts( $page );
	$pages = $asaph->getPages();
	include( ASAPH_PATH.Asaph_Config::$templates['posts'] );
}

?>