<?php
/* 
This file contains functions that are useful across the webiste. 

Convention: any variable or function prefixed with "_" is intended to be
a "local" function or variable that shouldn't need to be used outside of this file. 

Additionally, note the unit tests at the bottom. These don't do anything other than fail if somehow the functions above are broken. Set $runTests = False for release, True for development.  
*/
$runTests = True;

/*********************************************************
SQL Functions 
*********************************************************/
/* Useage:

// Returns a string of the result if the result has one row and one column 
$sql->queryValue("select val from tbl where name = 'Jack';")

// Returns a JSON of the table returned. 
$sql->queryValue("select * from tbl;"); 

// Runs the query, and returns a "results" reference. Used internally, but 
// could be useful elsewhere in niche cases. 
$sql->execute("select 1 + 1;");

*/ 
class SQL { 

	private $_conn = "";
	private $_sqluser = "";

	function __construct(){
		// Start: global config 
		// if running locally, we get a username, else it's a null string. 
		if (getenv("USER")){
		    $this->_sqluser = getenv("USER");
		} else {
		    $this->_sqluser = "ubuntu" ;
		}

		// Connect to our sql server
		if (strpos(getenv("DATABASE_URL"), "postgres://") !== false){
			$connection_string = getenv("DATABASE_URL"); 
		} else {
			$connection_string = "host=localhost dbname=" . getenv("DATABASE_URL"); 
		}

		if (!($this->_conn = pg_connect($connection_string))) {
			throw new Exception("SQL Connection error " . pg_last_error());
		}


	}

	public function execute($cmd){
		$res = pg_query($cmd) or die ("Error Executing query " . $cmd); 
		return $res;
	}

	public function queryValue($cmd){
		$res = $this->execute($cmd);
		$num_rows = pg_num_rows($res);
		if ($num_rows > 1) {
			throw new Exception("Query " . $cmd . " returned multiple rows"); 
		} elseif ($num_rows < 1){
			throw new Exception("Query " . $cmd . " returned no rows");
		}
		$row = pg_fetch_row($res);
		if (count($row) > 1){
			throw new Exception("More than one column specified in query " . $cmd);
		}
		pg_free_result($res);
		return json_encode($row[0]);
	}

	public function queryJSON($cmd){
		$res = $this->execute($cmd);
		$json = array();
		if (pg_num_rows($res) > 0){
			while($row = pg_fetch_object($res)){
				$json[] = $row;
			}
			pg_free_result($res);
			return json_encode($json);
		} else {
			pg_free_result($res);
			return "[]";
		}
		
	}

	public function sanitize($str){
		return pg_escape_string($str);
	}

} 

// Supply global variable sql with an instance 
$sql = new SQL();

// Should execute cleanly 
if (!($sql->execute("select 1 + 1;"))){
	throw new Exception("DB Connection Error.");
}
