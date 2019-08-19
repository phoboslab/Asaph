<?php

class DB {
	public $sql;
	public $numQueries = 0;
	
	private $link = null;
	private $result;
	private $host, $db, $user, $pass;
	
	
	public function __construct( $host, $db, $user, $pass) {
		$this->host = $host;
		$this->db = $db;
		$this->user = $user;
		$this->pass = $pass;
	}
	
	
	private function connect() {
		$this->link = mysqli_connect( $this->host, $this->user, $this->pass )
			or die( "Couldn't establish link to database-server: ".$this->host );
		mysqli_select_db( $this->db )
			or die( "Couldn't select Database: ".$this->db );
		mysqli_query( 'SET NAMES utf8', $this->link );
	}
	
	
	public function foundRows() {
		$r = $this->query( 'SELECT FOUND_ROWS() AS foundRows' );
		return $r[0]['foundRows'];
	}
	
	
	public function numRows() {
		return mysqli_num_rows( $this->result );
	}
	
	
	public function affectedRows() {
		return mysqli_affected_rows( $this->result );
	}
	
	
	public function insertId() {
		return mysqli_insert_id( $this->link );
	}
	
	
	public function query( $q, $params = array() ) {
		if( $this->link === null ) {
			$this->connect();
		}
		
		if( !is_array( $params ) ) {
			$params = array_slice( func_get_args(), 1 );
		}
		
		if( !empty( $params ) ) {
			$q = preg_replace_callback('/:(\d+)/',
				function($repl) use ($params){
					return $this->quote($params[$repl[1] - 1]);
				},
			$q);
		}
		$this->numQueries++;
		$this->sql = $q;
		$this->result = mysqli_query( $q, $this->link );
		
		if( !$this->result ) {
			return false;
		}
		else if( !( $this->result instanceof mysqli_result ) ) {
			return true;
		}
		
		$rset = array();
		while ( $row = mysqli_fetch_assoc( $this->result ) ) {
			$rset[] = $row;
		}
		return $rset;
	}
	
	
	public function getRow( $q, $params = array() ) {
		if( !is_array( $params ) ) {
			$params = array_slice( func_get_args(), 1 );
		}
		
		$r = $this->query( $q, $params );
		return array_shift( $r );
	}
	
	
	public function updateRow( $table, $idFields, $updateFields ) {
		$updateString = implode( ',', $this->quoteArray( $updateFields ) );
		$idString = implode( ' AND ', $this->quoteArray( $idFields ) );
		return $this->query( "UPDATE $table SET $updateString WHERE $idString" );
	}
	
	
	public function insertRow( $table, $insertFields ) {
		$insertString = implode( ',', $this->quoteArray( $insertFields ) );
		return $this->query( "INSERT INTO $table SET $insertString" );
	}
	
	
	public function getError() {
		if( $e = mysql_error( $this->link ) ) {
			return "MySQL reports: '$e' on query\n".$this->sql;
		}
		return false;
	}
	
	
	public function quote( $s ) {
		if( $this->link === null ) {
			$this->connect();
		}
		if( !isset($s) || $s === false ) {
			return 0;
		}
		else if( $s === true ) {
			return 1;
		}
		else if( is_numeric( $s ) ) {
			return $s;
		}
		else {
			return "'".mysqli_real_escape_string( $this->link, $s )."'";
		}
	}
	
	
	public function quoteArray( &$fields ) {
		$r = array();
		foreach( $fields as $key => &$value ) {
			$r[] = "`$key`=".$this->quote( $value );
		}
		return $r;
	}
}

?>
