<?php

use PHPUnit\Framework\TestCase;
require 'search.php';
class tests extends TestCase
{
  public function testTrueAssetsToTrue()
  {
    $condition = true;
    $this->assertTrue($condition);
  }
  /*public function testdbConnect()
  {
      $a = new DatabaseConnection();
      $B = $a ->dbConnect();

      $this->assertTrue($b);
  }*/
  public function testSearchValue()
  {
      $values = new InputValues();
      $values->setTestSearch('a');
      $this->assertEquals('a', $values->getSearch());
  }
  public function testStartDateValue()
  {
      $values = new InputValues();
      $values->setTestStartDate(2020);
      $this->assertEquals(2020, $values->getStartDate());
  }
  public function testYearResultValue5()
  {
      $values = new InputValues();
      $values->setTestEndDate(5);
      $this->assertEquals(2015, $values->getEndDate());
  }
  public function testYearResultValue10()
  {
      $values = new InputValues();
      $values->setTestEndDate(10);
      $this->assertEquals(2010, $values->getEndDate());
  }
  public function testYearResultValue15()
  {
      $values = new InputValues();
      $values->setTestEndDate(15);
      $this->assertEquals(2005, $values->getEndDate());
  }
  public function testYearResultValue20()
  {
      $values = new InputValues();
      $values->setTestEndDate(20);
      $this->assertEquals(2000, $values->getEndDate());
  }
  public function testSortValue()
  {
      $values = new InputValues();
      $values->setTestSort('title');
      $this->assertEquals('title', $values->getSort());
  }
}
?>
