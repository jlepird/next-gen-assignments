<?php

//use PHPUnit\Framework\TestCase;
require __DIR__ .'/../vendor/autoload.php';

include __DIR__ . '/../include/funs.php';

class SQLTest extends PHPUnit_Framework_TestCase
{
	function __construct(){
		$this->sql = new SQL();
	}

	public function testDB(){
		$this->assertEquals($this->sql->queryValue("select 1 + 1;") , "\"2\"");
		$this->assertEquals($this->sql->queryJSON("select 1 + 1 as bar;"), "[{\"bar\":\"2\"}]" );
		$this->assertEquals($this->sql->sanitize("'"), "''" );

		$this->assertEquals($this->sql->queryJSON("select 1 where 1=0;"), "[]");
	}

	public function testExceptions(){
		$cmd = "select 1 where 1=0;";
		try { 
			$this->sql->queryValue($cmd);
		} catch (Exception $e){
			$this->assertEquals($e->getMessage(), "Query " . $cmd . " returned no rows");
		}
		$cmd = "select * from billetData;";
		try { 
			$this->sql->queryValue($cmd);
		} catch (Exception $e){
			$this->assertEquals($e->getMessage(), "Query " . $cmd . " returned multiple rows");
		}

		$cmd = "select 1, 2;";
		try { 
			$this->sql->queryValue($cmd);
		} catch (Exception $e){
			$this->assertEquals($e->getMessage(), "More than one column specified in query " . $cmd);
		}


	}

}

?>
