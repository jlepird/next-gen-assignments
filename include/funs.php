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
		$this->_conn = pg_connect(getenv("DATABASE_URL")) 
		or die("SQL Connection error " . pg_last_error());

	}

	public function execute($cmd){
		$res = pg_query($cmd) or die ("Error Executing query " . $cmd); 
		return $res;
	}

	public function queryValue($cmd){
		$res = $this->execute($cmd);
		$num_rows = pg_num_rows($res);
		if ($num_rows > 1) {
			die("Query" . $cmd . "returned multiple rows"); 
		} elseif ($num_rows < 1){
			return "ERROR-- no rows returned";
		}
		$row = pg_fetch_row($res);
		if (count($row) > 1){
			die("More than one column specified in query " . $cmd);
		}
		return $row[0];
		pg_free_result($res);
	}

	public function queryJSON($cmd){
		$res = $this->execute($cmd);
		$json = array();
		if (pg_num_rows($res) > 0){
			while($row = pg_fetch_object($res)){
				$json[] = $row;
			}
			return json_encode($json);
		} else {
			return "[]";
		}
		pg_free_result($res);
	}

	public function sanitize($str){
		return pg_escape_string($str);
	}

} 

// Supply global variable sql with an instance 
$sql = new SQL();

/* 
FUNCTION TESTING
This code here doesn't actually "do" anything other than fail if the functions 
above are somehow screwed up. Only run these during development!
*/ 

if ($runTests){ 
	// Should execute cleanly 
	$sql->execute("select 1 + 1;") or die("SQL Execution error in unit tests.");
	$sql->queryValue("select 1 + 1;") == 2 or die("SQL queryValue error in unit tests.");
	$sql->queryJSON("select 1 + 1 as bar;") == "[{\"bar\":\"2\"}]" or die("SQL queryJSON error in unit tests.");
	$sql->sanitize("'") == "''" or die ("SQL Query Sanitiation Error"); 
}
?> 

