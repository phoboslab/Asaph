<?php 
require_once( '../lib/asaph_config.class.php' );
header( 'Content-type: text/javascript; charset=utf-8' ); 
?>
function Asaph_RemotePost( postURL, stylesheet ) {
	this.postURL = postURL;
	this.stylesheet = stylesheet;
	
	this.visible = false;
	this.menu = null;
	this.dialog = null;
	this.iframe = null;
	this.checkSuccessInterval = 0;
	this.minImageSize = 32;
	
	
	this.create = function(){
		var that = this;
		var css = document.createElement('link');
		css.type = 'text/css';
		css.rel = 'stylesheet';
		css.href = this.stylesheet;
		if( document.getElementsByTagName("head").item(0) ) {
			document.getElementsByTagName("head").item(0).appendChild( css );
		} else {
			document.getElementsByTagName("body").item(0).appendChild( css );
		}
		
		var closeButton = document.createElement('a');
		closeButton.appendChild( document.createTextNode("x") );
		closeButton.className = 'close';
		closeButton.onclick = function() { return that.toggle(); }
		closeButton.href = '#';
		
		var postButton = document.createElement('a');
		postButton.appendChild( document.createTextNode("Post this Site") );
		postButton.onclick = function() { return that.selectSite(); }
		postButton.href = '#';
		
		var menuBar = document.createElement('div');
		menuBar.id = 'Asaph_Menu';
		menuBar.appendChild( document.createTextNode("Asaph // ") );
		menuBar.appendChild( postButton );
		menuBar.appendChild( closeButton );
		
		this.menu = document.createElement('div');
		this.menu.id = 'Asaph';
		this.menu.className = 'Asaph_Post';
		this.menu.appendChild( menuBar );
		document.body.appendChild( this.menu );
		
		
		var closeDialog = document.createElement('a');
		closeDialog.appendChild( document.createTextNode("^") );
		closeDialog.className = 'close';
		closeDialog.onclick = function() { that.dialog.style.display = 'none'; return false; }
		closeDialog.href = '#';
		
		this.dialog = document.createElement('div');
		this.dialog.id = 'Asaph_Dialog';
		this.iframe = document.createElement('iframe');
		this.iframe.src = 'about:blank';
		this.dialog.appendChild( closeDialog );
		this.dialog.appendChild( this.iframe );
		this.menu.appendChild( this.dialog );
	}
	
	
	this.loadIFrame = function( params ) {
		this.dialog.style.display = 'block';
		var reqUrl = this.postURL + '?nocache=' + parseInt(Math.random()*10000);
		for( p in params ) {
			reqUrl += '&' + p + '=' + encodeURIComponent( params[p] );
		}
		this.iframe.src = reqUrl;
	}
	
	
	this.selectSite = function() {
		var title = document.title;
		var selection = window.getSelection().toString();
		if( selection ) {
			title = '\u201C' + selection + '\u201D';
		}
		this.loadIFrame( {
			'title': title,
			'url': document.location.href,
			'xhrLocation': document.location.href.replace(/#.*$/,'')
		});
		return false;
	}
	
	
	this.selectImage = function( image ) {
		var title = image.title ? image.title : ( image.alt ? image.alt : document.title );
		var imageSrc = image.src;
		if( 
			image.parentNode.tagName.match(/^a$/i) &&
			image.parentNode.href &&
			image.parentNode.href.match(/\.(jpe?g|gif|png)$/i)
		) {
			imageSrc = image.parentNode.href;
		}
		this.loadIFrame( {
			'title': title,
			'image': imageSrc,
			'referer': document.location.href,
			'xhrLocation': document.location.href.replace(/#.*$/,'')
		});
		return false;
	}
	
	
	this.checkSuccess = function() {
		if( document.location.href.match(/#Asaph_Success/) ) {
			var that = this;
			document.location.href = document.location.href.replace(/#.*$/, '#');
			setTimeout( function() { that.hide() }, 500 );
		}
	}
	
	
	this.show = function() {
		this.visible = true;
		var that = this;
		
		this.checkSuccessInterval = setInterval( function() { that.checkSuccess(); }, 500 );
		this.menu.style.display = 'block';
		
		var images = document.getElementsByTagName('img');
		for( var i=0; i<images.length; i++ ) {
			var img = images[i];
			if( img && img.src && img.src.match(/(space|blank)[^\/]*\.gif$/i) ) {
				img.style.display = 'none';
			}
			else if( img && img.src && img.width > this.minImageSize && img.height > this.minImageSize) {
				img.onclick = function( ev ) { 
					ev.stopPropagation(); 
					return that.selectImage(this); 
				};
				img.className = img.className ? img.className + ' Asaph_PostImage' : 'Asaph_PostImage';
			}
		}
	}
	
	
	this.hide = function() {
		this.visible = false;
		
		clearInterval( this.checkSuccessInterval );
		this.menu.style.display = 'none';
		this.dialog.style.display = 'none';
		
		var images = document.getElementsByTagName('img');
		for( var i=0; i<images.length; i++ ) {
			var img = images[i];
			if( img && img.src && img.width > this.minImageSize && img.height > this.minImageSize) {
				img.onclick = null;
				img.className = img.className.replace(/\s*Asaph_PostImage/, '');
			}
		}
	}
	
	
	this.toggle = function() {
		if( !this.visible ) {
			this.show();
		} else {
			this.hide();
		}
		return false;
	}
	
	
	this.create();
}

if( typeof(Asaph_Instance) == 'undefined' )  {
	var Asaph_Instance = new Asaph_RemotePost(
		'<?php echo ASAPH_POST_PHP; ?>', 
		'<?php echo ASAPH_POST_CSS; ?>'
	);
} 
Asaph_Instance.toggle();
