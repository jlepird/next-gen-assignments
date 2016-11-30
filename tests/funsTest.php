<?php

use PHPUnit\Framework\TestCase;

class SQLTest extends TestCase
{
	public function testDB(){
		$sql = new SQL();
		$this->assertEquals($sql->queryValue("select 1 + 1;") , "\"2\"");
		$this->assertEquals($sql->queryJSON("select 1 + 1 as bar;"), "[{\"bar\":\"2\"}]" );
		$this->assertEquals($sql->sanitize("'"), "''" );
	}
}

?>