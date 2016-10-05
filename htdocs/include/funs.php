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
$sql->queryValue("select val from tbl where name = 'Jack';")l

// Returns a JSON of the table returned. 
$sql->queryValue("select * from tbl;"); 

// Runs the query, and returns a "results" reference. Used internally, but 
// could be useful elsewhere in niche cases. 
$sql->execute("select 1 + 1;");

*/ 
class mySQL { 

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
		$this->_conn = mysqli_connect("localhost", $this->_sqluser, "");
		
		// Give error if the connection failed. 
		if ($this->_conn->connect_error){
		    die("MySQL Connection failed:" . $this->_conn->connect_error);
		}

	}

	public function execute($cmd){
		$res = $this->_conn->query($cmd);
		if ($this->_conn->sqlstate > 0){
			die("Error: " . $this->_conn->sqlstate .
				"\nwhile executing query " . $cmd . "."
				);
		}
		return $res;
	}

	public function queryValue($cmd){
		$res = $this->execute($cmd);
		if ($res->num_rows > 1) {
			die("Query" . $cmd . "returned multiple rows"); 
		} elseif ($res->num_rows < 1){
			return "ERROR-- no rows returned";
		}
		$row = $res->fetch_row();
		if (count($row) > 1){
			die("More than one column specified in query " . $cmd);
		}
		return $row[0];

	}

	public function queryJSON($cmd){
		$res = $this->_conn->query($cmd);
		$json = array();
		if ($res->num_rows > 0){
			while($row = $res->fetch_object()){
				$json[] = $row;
			}
			return json_encode($json);
		} else {
			return "[]";
		}
	}

} 

// Supply global variable sql with an instance 
$sql = new mySQL();

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
}
?> 
