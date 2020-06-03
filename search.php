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
  public function selectData($link, $search,$yearResult,$startDate,$sortSetting)
  {
    $this ->sqlQuery = "SELECT * FROM `article`
          WHERE (title like '%$search%' OR author like '%$search%' OR method like '%$search%')
          AND year BETWEEN $yearResult and $startDate
          ORDER BY $sortSetting";
          echo $this->sqlQuery;
    $this ->dataSet = mysqli_query($link, $this ->sqlQuery);
    return $this ->dataSet;
  }
  public function outputData($sqlResult)
  {
    if(!$sqlResult)
    {
      echo "<p>Something is wrong with ",	$this->sqlQuery , "</p> <br>";
      //echo "<p>Year Result ",	$yearResult, "</p> <br>";
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
class InputValues
{
	public $search="";
	public $startDate="";
	public $yearRange="";
	public $yearResult="";
	public $sortSetting="";

  /*public function __construct($i)
  {
  }*/
  public function setSearch()
  {
		if(isset($_POST["search"]))
		{
			$this->search = $_POST["search"];
		}else{
			$this->search = "";
		}
  }
	public function getSearch()
  {
		return $this->search;
  }
	public function setStartDate()
  {
	$this->startDate = 2020;
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
	public function getEndDate()
  {
		return $this->yearResult;
  }
	public function setSort()
  {
		if(isset($_POST["sort"]))
		{
			$this->sortSetting = $_POST["sort"];

      /*if($this->sortSetting = 'description')
      {
        $this->sortSetting = 'method';
      }*/

		}else{
			$this->sortSetting = "title";
		}
  }
	public function getSort()
  {
		return $this->sortSetting;
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

				$sqlResult = $db->selectData($connection, $search,$yearResult,$startDate,$sortSetting);
        $db->outputData($sqlResult);

				}
			}

	?>
<p><a class="btn btn-primary btn-lg btn-block" href="index.html" role="button">Search an another Article</a></p>
</body>
</html>
