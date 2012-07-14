<?php

/* The Asaph_Post class extends the Asaph_Admin class to allow creation
of new post. It is solely used from the bookmarklet */

require_once( ASAPH_PATH.'lib/asaph_admin.class.php' );

class Asaph_Post extends Asaph_Admin {
	
	public function __construct() {
		parent::__construct();
	}
	
	
	public function postUrl( $url, $title ) {
		if( !$this->userId ) {
			return 'not-logged-in';
		}
		
		$this->db->insertRow( ASAPH_TABLE_POSTS, array(
			'userId' => $this->userId,
			'hash' => md5( $url ),
			'created' => date( 'Y-m-d H:i:s' ),
			'source' => $url,
			'thumb' => '',
			'image' => '',
			'title' => trim($title)
		));
		return true;
	}
	
	
	public function postImage( $url, $referer, $title ) {
		if( !$this->userId ) {
			return 'not-logged-in';
		}
		
		// Determine the target path based on the current date (e.g. data/2008/04/)
		$time = time();
		$imageDir = ASAPH_PATH.Asaph_Config::$images['imagePath'] . date('Y/m', $time);
		$thumbDir = ASAPH_PATH.Asaph_Config::$images['thumbPath'] . date('Y/m', $time);
		
		// Extract the image name from the url, remove all special characters from it
		// and determine the local file name
		$imageName = strtolower( substr(strrchr( $url, '/'), 1) );
		$imageName = preg_replace( '/[^a-zA-Z\d\.]+/', '-', $imageName ); 
		$imageName = preg_replace( '/^\-+|\-+$/', '', $imageName ); 
		if( !preg_match('/\.(png|gif|jpg|jpeg)$/i', $imageName) ) {
			$imageName .= '.jpg';
		}
		$thumbName = substr( $imageName, 0, strrpos($imageName, '.') ) . '.jpg';
		
		$imageName = $this->getUniqueFileName( $imageDir, $imageName );
		$thumbName = $this->getUniqueFileName( $thumbDir, $thumbName );
		$imagePath = $imageDir .'/'. $imageName;
		$thumbPath = $thumbDir .'/'. $thumbName;
		
		
		// Create target directories and download the image
		if( 
			!$this->mkdirr($imageDir) ||
			!$this->mkdirr($thumbDir) ||
			!$this->download($url, $referer, $imagePath) 
		) {
			return 'download-failed';
		}
		
		
		// Was this image already posted
		$imageHash = md5_file( $imagePath );
		$c = $this->db->query('SELECT id FROM '.ASAPH_TABLE_POSTS.' WHERE hash = :1', $imageHash);
		if( !empty( $c ) ) {
			unlink( $imagePath );
			return 'duplicate-image';
		}
		
		
		// Create the thumbnail and insert post to the db
		if( 
			!$this->createThumb(
				$imagePath, $thumbPath, 
				Asaph_Config::$images['thumbWidth'], Asaph_Config::$images['thumbHeight'], 
				Asaph_Config::$images['jpegQuality']
			)
		) {
			return 'thumbnail-failed';
		}
		
		$this->db->insertRow( ASAPH_TABLE_POSTS, array(
			'userId' => $this->userId,
			'hash' => $imageHash,
			'created' => date( 'Y-m-d H:i:s', $time ),
			'source' => $referer,
			'thumb' => $thumbName,
			'image' => $imageName,
			'title' => $title
		));
		
		return true;
	}
	
	
	private function download( $url, $referer, $target  ) {
		// Open the target file for writing
		$fpLocal = @fopen( $target, 'w' );
		if( !$fpLocal ) {
			return false;
		}
		
		
		// Use cURL to download if available
		if( is_callable('curl_init') ) { 
			$ch = curl_init();
			curl_setopt( $ch, CURLOPT_URL, $url );
			curl_setopt( $ch, CURLOPT_REFERER, $referer );
			curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 10 );
			curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1 );
			curl_setopt( $ch, CURLOPT_HEADER, 0 );
			curl_setopt( $ch, CURLOPT_FILE, $fpLocal );
			if( !curl_exec($ch) ) {
				fclose( $fpLocal );
				curl_close( $ch );
				return false;
			}
			curl_close( $ch );
		}
		// Otherwise use fopen
		else { 
			$opts = array(
				'http' => array(
					'method' => "GET",
					'header' => "Referer: $referer\r\n"
				)
			);
			
			$context = stream_context_create( $opts );
			$fpRemote = @fopen( $url, 'r', false, $context );
			if( !$fpRemote ) {
				fclose( $fpLocal );
				return false;
			}
			
			while( !feof( $fpRemote ) ) {
				fwrite( $fpLocal, fread($fpRemote, 8192) ); 
			}
			fclose( $fpRemote );
		}
		
		fclose( $fpLocal );
		return true;
	}
	
	
	private function createThumb( $imgPath, $thumbPath, $thumbWidth, $thumbHeight, $quality ) {
		// Get image type and size and check if we can handle it
		list( $srcWidth, $srcHeight, $type ) = getimagesize( $imgPath );
		if( 
			$srcWidth < 1 || $srcWidth > 4096
			|| $srcHeight < 1 || $srcHeight > 4096
		) {
			return false;
		}
		
		switch( $type ) {
			case IMAGETYPE_JPEG: $imgCreate = 'ImageCreateFromJPEG'; break;
			case IMAGETYPE_GIF: $imgCreate = 'ImageCreateFromGIF'; break;
			case IMAGETYPE_PNG: $imgCreate = 'ImageCreateFromPNG'; break;
			default: return false;
		}
		
		// Crop the image horizontal or vertical 
		$srcX = 0;
		$srcY = 0;
		if( ( $srcWidth/$srcHeight ) > ( $thumbWidth/$thumbHeight ) ) {
			$zoom = ($srcWidth/$srcHeight) / ($thumbWidth/$thumbHeight);
			$srcX = ($srcWidth - $srcWidth / $zoom) / 2;
			$srcWidth = $srcWidth / $zoom;
		}
		else {
			$zoom = ($thumbWidth/$thumbHeight) / ($srcWidth/$srcHeight);
			$srcY = ($srcHeight - $srcHeight / $zoom) / 2;
			$srcHeight = $srcHeight / $zoom;
		}
		
		// Resample and create the thumbnail
		$thumb = imageCreateTrueColor( $thumbWidth, $thumbHeight );
		$orig = $imgCreate( $imgPath );
		imageCopyResampled( $thumb, $orig, 0, 0, $srcX, $srcY, $thumbWidth, $thumbHeight, $srcWidth, $srcHeight );
		imagejpeg( $thumb, $thumbPath, $quality );
		
		imageDestroy( $thumb );
		imageDestroy( $orig );
		return true;
	}
}

?>