function Whitebox( waitFor ) {
	this.waitFor = waitFor;
	this.waitCount = 0;
	this.div = null;
	this.image = null;
	
	this.showInterval = 0;
	this.waitInterval = 0;
	this.visible = false;
	
	this.waitInitialize = function() {
		this.waitCount++;
		if( document.getElementById(this.waitFor) || this.waitCount > 20 ) {
			clearInterval( this.waitInterval );
			this.initialize();
		}
	}
	
	this.initialize = function() {
		var that = this;
		this.div = document.createElement( 'div' );
		this.div.id = 'whitebox';
		document.body.appendChild( this.div );
		
		var anchors = document.getElementsByTagName('a');
		for( var i=0; i<anchors.length; i++ ) {
			var a = anchors[i];
			if( a.rel == 'whitebox' ) {
				a.onclick = function() { return that.show(this); }
			}
		}
	}
	
	this.showCallback = function() {
		if( this.image && (this.image.width > 0 || this.image.complete) ) {
			if( this.image.width > 0 ) {
				clearInterval( this.showInterval );
				
				var yScroll;
				if (self.pageYOffset) {
					yScroll = self.pageYOffset;
				} else if (document.documentElement && document.documentElement.scrollTop){	 // Explorer 6 Strict
					yScroll = document.documentElement.scrollTop;
				} else if (document.body) {// all other Explorers
					yScroll = document.body.scrollTop;
				}
				
				this.div.style.top = Math.max( yScroll + (document.documentElement.clientHeight - this.image.height )/2, 0) + "px";
				this.div.style.left = Math.max((document.documentElement.clientWidth - this.image.width )/2, 0 ) + "px";
			}
			
			this.div.style.display = 'block';
		}
	}
	
	this.show = function( anchor ) {
		if( this.visible ) {
			this.hide();
			return false;
		}
		this.image = new Image();
		this.image.src = anchor.href;
		this.image.title = anchor.title;
		this.image.onclick = function() { return that.hide(); }
		this.div.appendChild( this.image );
		
		this.showInterval = setInterval( function() { that.showCallback() }, 100 );
		this.visible = true;
		return false;
	}
	
	this.hide = function() {
		this.div.style.display = 'none';
		this.div.removeChild( this.image );
		this.image = null;
		this.visible = false;
	}
	
	var that = this;
	this.waitInterval = setInterval( function() { that.waitInitialize() }, 100 );
}

var iv = new Whitebox( 'pages' );
