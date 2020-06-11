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

  public function testYearResultValueAll()
  {
      $values = new InputValues();
      $values->setTestEndDate(20);
      $this->assertEquals(2000, $values->getEndDate());
  }

  public function testMinDateValue()
  {
    $values = new InputValues();
    $values -> setTestMinDate (2000);
    $this->assertEquals(2000,$values->getMinDate());
  }

  public function testMaxDateValue()
  {
    $values = new InputValues();
    $values -> setTestMaxDate (2020);
    $this->assertEquals(2020,$values->getMaxDate());
  }

  public function testSortValue()
  {
      $values = new InputValues();
      $values->setTestSort('title');
      $this->assertEquals('title', $values->getSort());
  }
  public function testMethodAgileValue()
  {
      $values = new InputValues();
      $values->setTestMethod(TRUE, 'method2', TRUE, 'Agile');
      $this->assertEquals('Agile', $values->getMethod());
  }
 
  public function testMethodDevOpsValue()
  {
      $values = new InputValues();
      $values->setTestMethod(TRUE, 'method2', TRUE,'DevOps');
      $this->assertEquals('DevOps', $values->getMethod());
  } 
  public function testMethodNoDropDown()
  {
      $values = new InputValues();
      $values->setTestMethod(FALSE, "", FALSE, "");
      $this->assertEquals(NULL, $values->getMethod());
  }
  public function testMethodNoValue()
  {
      $values = new InputValues();
      $values->setTestMethod(TRUE, 'method2', TRUE,'');
      $this->assertEquals("", $values->getMethod());
  }
  public function testResultValue()
  {
      $values = new InputValues();
      $values->setTestResult('Improve');
      $this->assertEquals('Improve', $values->getResult());
  }

  public function testTechniqueDevOpsValue()
  {
      $values = new InputValues();
      $values->setTestTechnique(TRUE, 'technique', TRUE, 'DevOps');
      $this->assertEquals('DevOps', $values->getTechnique());
  }

  public function testSQLNoDropDown()
  {
      $db = new DatabaseConnectionTest();
      $expectedString = "SELECT * FROM `article`
            WHERE (title like '%a%' OR author like '%a%')
            AND year BETWEEN 2015 and 2020
            ORDER BY title";
      $this->assertEquals($expectedString, $db->selectData("a", 2015, 2020, "title", "", "", "", "", ""));
      // search, yearResult, startDate, sortSetting, methodSetting, technique,resultSetting, minDate, maxDate
  }
  public function testSQLWithMethod()
  {
      $db = new DatabaseConnectionTest();
      $expectedString = "SELECT * FROM `article`
            WHERE (title like '%a%' OR author like '%a%') AND (method like '%DevOps%')
            AND year BETWEEN 2015 and 2020
            ORDER BY title";
      $this->assertEquals($expectedString, $db->selectData("a", 2015, 2020, "title", "DevOps", "", "" , "", ""));
      // search, yearResult, startDate, sortSetting, methodSetting, technique,resultSetting, minDate, maxDate
  }
  public function testSQLWithResult()
  {
      $db = new DatabaseConnectionTest();
      $expectedString = "SELECT * FROM `article`
            WHERE (title like '%a%' OR author like '%a%') AND (result like '%Improve%')
            AND year BETWEEN 2015 and 2020
            ORDER BY title";
      $this->assertEquals($expectedString, $db->selectData("a", 2015, 2020, "title", "", "", "Improve", "", ""));
      // search, yearResult, startDate, sortSetting, methodSetting, technique,resultSetting, minDate, maxDate
  }
  public function testSQLWithResultCustomRange()
  {
      $db = new DatabaseConnectionTest();
      $expectedString = "SELECT * FROM `article`
            WHERE (title like '%a%' OR author like '%a%') AND (result like '%Improve%')
            AND year BETWEEN 2012 and 2018
            ORDER BY title";
      $this->assertEquals($expectedString, $db->selectData("a", "", "", "title", "", "" , "Improve", 2012, 2018));
      // search, yearResult, startDate, sortSetting, methodSetting, technique,resultSetting, minDate, maxDate
  }
   public function testSQLWithMethodCustomRange()
  {
    $db = new DatabaseConnectionTest();
    $expectedString = "SELECT * FROM `article`
            WHERE (title like '%a%' OR author like '%a%') AND (method like '%Agile%')
            AND year BETWEEN 2012 and 2018
            ORDER BY title";
    $this->assertEquals($expectedString, $db->selectData("a", "", "", "title", "Agile", "", "", 2012, 2018));
    // search, yearResult, startDate, sortSetting, methodSetting, technique,resultSetting, minDate, maxDate
  }
  /*public function testSQLWithTechniqueCustomRange()
  {
    $db = new DatabaseConnectionTest();
    $expectedString = "SELECT * FROM `article`
            WHERE (title like '%a%' OR author like '%a%') AND (method like '%Agile%')
            AND year BETWEEN 2012 and 2018
            ORDER BY title";
    $this->assertEquals($expectedString, $db->selectData("a", "", "", "title", "Agile", "", "", 2012, 2018));
    // search, yearResult, startDate, sortSetting, methodSetting, technique,resultSetting, minDate, maxDate
  }*/
  public function testSQLWithMethodResultCustomRange()
  {
    $db = new DatabaseConnectionTest();
    $expectedString = "SELECT * FROM `article`
            WHERE (title like '%a%' OR author like '%a%') AND (result like '%Improve%') AND (method like '%Agile%')
            AND year BETWEEN 2012 and 2018
            ORDER BY title";
    $this->assertEquals($expectedString, $db->selectData("a", "", "", "title", "Agile", "", "Improve", 2012, 2018));
    // search, yearResult, startDate, sortSetting, methodSetting, technique,resultSetting, minDate, maxDate
  }
  public function testSQLWithCustomRange()
  {
    $db = new DatabaseConnectionTest();
    $expectedString = "SELECT * FROM `article`
            WHERE (title like '%a%' OR author like '%a%')
            AND year BETWEEN 2012 and 2018
            ORDER BY title";
    $this->assertEquals($expectedString, $db->selectData("a", "", "", "title", "", "", "", 2012, 2018));
   // search, yearResult, startDate, sortSetting, methodSetting, technique,resultSetting, minDate, maxDate
  }

  public function testSQLWithTechniqueMethodResultCustomRange()
  {
    $db = new DatabaseConnectionTest();
    $expectedString = "SELECT * FROM `article`
            WHERE (title like '%a%' OR author like '%a%') AND (method like '%Agile%') AND (result like '%Improve%') AND (technique like '%DevOps%')
            AND year BETWEEN 2012 and 2018
            ORDER BY title";
    $this->assertEquals($expectedString, $db->selectData("a", "", "", "title", "Agile", "DevOps", "Improve", 2012, 2018));
    // search, yearResult, startDate, sortSetting, methodSetting, technique,resultSetting, minDate, maxDate
  }

  public function testFullFunctionality()
  {
      $db = new DatabaseConnectionTest();
      $values = new InputValues();
      $values->setTestSearch('a');
      $values->setTestStartDate(2020);
      $values->setTestEndDate(5);
      $values->setTestSort('title');
      $values->setTestMethod(TRUE, 'method2', TRUE, 'Agile');

      $expectedString = "SELECT * FROM `article`
            WHERE (title like '%a%' OR author like '%a%') AND (method like '%Agile%')
            AND year BETWEEN 2015 and 2020
            ORDER BY title";
      $this->assertEquals($expectedString, $db->selectData($values->getSearch(), $values->getEndDate(), $values->getStartDate(), $values->getSort(), $values->getMethod(), "", "", "", ""));
  }

 

}
?>

  }
}
?>
