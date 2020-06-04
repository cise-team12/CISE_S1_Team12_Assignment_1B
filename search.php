<!DOCTYPE html>
<?php
class DatabaseConnection
{
  public $link;
  public $dataSet;

  private $sqlQuery;

  protected $username;
	protected $password;
	protected $database;
	protected $host;

  public function __construct()
  {
    $this->username="root";
  	$this->password="root";
  	$this->database="seer";
  	$this->host="localhost";
  }
  public function dbConnect()
  {
    $this->link = mysqli_connect($this->host,$this->username,$this->password,$this->database);
    return $this->link;
  }
  public function selectData($link, $search,$yearResult,$startDate,$sortSetting, $methodSetting, $resultSetting)
  {
    if($methodSetting == "" && $resultSetting == "")
    {
      $this ->sqlQuery = "SELECT * FROM `article`
            WHERE (title like '%$search%' OR author like '%$search%')
            AND year BETWEEN $yearResult and $startDate
            ORDER BY $sortSetting";
            //echo $this->sqlQuery;
    }
    else if ($methodSetting != "" && $resultSetting == "")
    {
      $this ->sqlQuery = "SELECT * FROM `article`
            WHERE (title like '%$search%' OR author like '%$search%') AND (method like '%$methodSetting%')
            AND year BETWEEN $yearResult and $startDate
            ORDER BY $sortSetting";
            //echo $this->sqlQuery;
    }
    else
    {
      $this ->sqlQuery = "SELECT * FROM `article`
            WHERE (title like '%$search%' OR author like '%$search%') AND (result like '%$resultSetting%')
            AND year BETWEEN $yearResult and $startDate
            ORDER BY $sortSetting";
            //echo $this->sqlQuery;
    }

    $this ->dataSet = mysqli_query($link, $this ->sqlQuery);
    return $this ->dataSet;
  }
  public function outputData($sqlResult)
  {
    if(!$sqlResult)
    {
      echo "<p>Something is wrong with ",	$this->sqlQuery , "</p> <br>";
    }else
    {
      echo "<table class='table table-dark'>";
      echo "<tr>\n"
      ."<th scope=\"col\">Article ID</th>\n"
      ."<th scope=\"col\">Title</th>\n"
      ."<th scope=\"col\">Author</th>\n"
      ."<th scope=\"col\">Method</th>\n"
      ."<th scope=\"col\">Result</th>\n"
      ."<th scope=\"col\">DOI</th>\n"
      ."<th scope=\"col\">Year</th>\n"
      ."</tr>\n";

      while ($row = mysqli_fetch_assoc($sqlResult))
      {
        echo "<tr>";
        echo "<td>",$row["article_id"],"</td>";
        echo "<td>",$row["title"],"</td>";
        echo "<td>",$row["author"],"</td>";
        echo "<td>",$row["method"],"</td>";
        echo "<td>",$row["result"],"</td>";
        echo "<td>",$row["doi"],"</td>";
        echo "<td>",$row["year"],"</td>";
        echo "</tr>";
      }
      echo "</table>";
      mysqli_free_result($sqlResult);
  }

}
}
class DatabaseConnectionTest
{
  private $sqlQuery;

  public function selectData($search,$yearResult,$startDate,$sortSetting, $methodSetting, $resultSetting)
  {
    if($methodSetting == "" && $resultSetting == "")
    {
      $this ->sqlQuery = "SELECT * FROM `article`
            WHERE (title like '%$search%' OR author like '%$search%')
            AND year BETWEEN $yearResult and $startDate
            ORDER BY $sortSetting";
            //echo $this->sqlQuery;
    }
    else if ($methodSetting != "" && $resultSetting == "")
    {
      $this ->sqlQuery = "SELECT * FROM `article`
            WHERE (title like '%$search%' OR author like '%$search%') AND (method like '%$methodSetting%')
            AND year BETWEEN $yearResult and $startDate
            ORDER BY $sortSetting";
            //echo $this->sqlQuery;
    }
    else
    {
      $this ->sqlQuery = "SELECT * FROM `article`
            WHERE (title like '%$search%' OR author like '%$search%') AND (result like '%$resultSetting%')
            AND year BETWEEN $yearResult and $startDate
            ORDER BY $sortSetting";
            //echo $this->sqlQuery;
    }
    return $this->sqlQuery;
  }

}
class InputValues
{
	private $search="";
	private $startDate="";
	private $yearRange="";
	private $yearResult="";
	private $sortSetting="";
  private $methodSetting = "";
  private $resultSetting = "";

  public function setSearch()
  {
		if(isset($_POST["search"]))
		{
			$this->search = $_POST["search"];
		}else{
			$this->search = "";
		}
  }
  public function setTestSearch($search)
  {
		$this->search = $search;
  }
	public function getSearch()
  {
		return $this->search;
  }
	public function setStartDate()
  {
	$this->startDate = 2020;
  }
  public function setTestStartDate($startDate)
  {
		$this->startDate = $startDate;
  }
	public function getStartDate()
  {
		return $this->startDate;
  }
	public function setEndDate()
  {
	if(isset($_POST["year"])){
		$this->yearRange = $_POST["year"];

		$this->setStartDate();
			if ($this->yearRange == "lastFive" ){
				$this->yearResult = $this->startDate - 5;
			}else if ($this->yearRange == "lastTen" ){
				$this->yearResult =  $this->startDate - 10;
			}else if ($this->yearRange == "lastFifteen" ){
				$this->yearResult =  $this->startDate - 15;
			}else if ($this->yearRange == "lastTwenty" ){
				$this->yearResult =  $this->startDate - 20;
			}
		}
  }
  public function setTestEndDate($yearRange)
  {
    $this->yearRange = $yearRange;
    $this->setTestStartDate(2020);
			if ($this->yearRange == 5 ){
				$this->yearResult = $this->startDate - 5;
			}else if ($this->yearRange == 10 ){
				$this->yearResult =  $this->startDate - 10;
			}else if ($this->yearRange == 15 ){
				$this->yearResult =  $this->startDate - 15;
			}else if ($this->yearRange == 20 ){
				$this->yearResult =  $this->startDate - 20;
			}
  }
	public function getEndDate()
  {
		return $this->yearResult;
  }
	public function setSort()
  {
		if(isset($_POST["sort"]))
		{
			$this->sortSetting = $_POST["sort"];

		}else{
			$this->sortSetting = "title";
		}
  }
  public function setTestSort($sort)
  {
    $this->sortSetting = $sort;
  }
	public function getSort()
  {
		return $this->sortSetting;
  }
  public function setMethod()
  {
		if(isset($_POST["dropDownSearch"]))
		{
      if($_POST["dropDownSearch"] == "method2")
      {
        if(isset($_POST["search2"]))
        {
          $this->methodSetting = $_POST["search2"];
        }
        else{
          $this->methodSetting = "";
        }
      }
    }
  }
  public function setTestMethod($dropDownActive, $dropDownSearch, $search2Active, $search2)
  {
    if($dropDownActive == TRUE)
    {
      if($dropDownSearch == "method2")
      {
        if($search2Active == TRUE)
        {
          $this->methodSetting = $search2;
        }
        else
        {
          $this->methodSetting = "";
        }
      }
    }
  }
	public function getMethod()
  {
		return $this->methodSetting;
  }
  public function setResult()
  {
		if(isset($_POST["result"]))
		{
      $this->resultSetting = $_POST["result"];

    }else
    {
			$this->resultSetting = "";

    }
  }
  public function setTestResult($x)
  {
    $this->resultSetting = $x;
  }
	public function getResult()
  {
		return $this->resultSetting;
  }
}

?>
<html>
<head>
	<title>Database Search</title>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
 	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>
<body>
	<h1 class="text-center">Search Result</h1><br>
	<?php

		$db = new DatabaseConnection();
		$connection= $db->dbConnect();

		if(!$connection)
    {
			echo "connection failure";
		}
    else
    {
			if(isset($_POST["enter"]))
      {
				$values = new InputValues();
				$values->setSearch();
				$search = $values->getSearch();
				$values-> setStartDate();
				$startDate = $values ->getStartDate();
				$values-> setEndDate();
				$yearResult = $values ->getEndDate();
				$values ->setSort();
				$sortSetting = $values -> getSort();
        $values ->setMethod();
        $methodSetting = $values -> getMethod();
        $values ->setResult();
				$resultSetting = $values -> getResult();

				$sqlResult = $db->selectData($connection, $search,$yearResult,$startDate,$sortSetting, $methodSetting, $resultSetting);
        $db->outputData($sqlResult);

				}
			}

	?>
<p><a class="btn btn-primary btn-lg btn-block" href="index.html" role="button">Search an another Article</a></p>
</body>
</html>
