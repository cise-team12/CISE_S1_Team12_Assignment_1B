<?php

use PHPUnit\Framework\TestCase;
class searchTest extends TestCase
{
  public function testTrueAssetsToTrue()
  {
    $condition = true;
    $this->assertTrue($condition);
  }
  public function testRetrieveResult()
  {
    $searchResult = new Result();
    $searchResult->setResult('Performance');
    $this->assertEquals($searchResult->getResult(), 'Performance');
  }
  public function testRetrieveDoi()
  {
    $searchDoi = new Doi();
    $searchDoi->setDoi('test');
    $this->assertEquals($searchResult->getDoi(), 'test');
  }
}
?>
