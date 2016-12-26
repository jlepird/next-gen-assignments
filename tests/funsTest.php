<?php

//use PHPUnit\Framework\TestCase;
require __DIR__ .'/../vendor/autoload.php';

include __DIR__ . '/../include/funs.php';

class SQLTest extends PHPUnit_Framework_TestCase
{
	public function testDB(){
		$sql = new SQL();
		$this->assertEquals($sql->queryValue("select 1 + 1;") , "\"2\"");
		$this->assertEquals($sql->queryJSON("select 1 + 1 as bar;"), "[{\"bar\":\"2\"}]" );
		$this->assertEquals($sql->sanitize("'"), "''" );
		$this->assertEquals($sql->queryValue("select 1 where 1=0;"),json_encode("ERROR-- no rows returned"));

		$this->assertEquals($sql->queryJSON("select 1 where 1=0;"), "[]");
	}
}

?>
