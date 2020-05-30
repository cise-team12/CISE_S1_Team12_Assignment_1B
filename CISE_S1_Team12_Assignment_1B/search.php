<!DOCTYPE html>
<?php
class DatabaseConnection
{
  	public $username="root";
	public $password="root";
	public $database="seer";
	public $host="localhost";

  /*public function __construct($i)
  {
  }*/
  public function dbConnect()
  {
    return mysqli_connect($this->host,$this->username,$this->password,$this->database);
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
			}else if ($this->yearRange == "lastFiften" ){
				$this->yearResult =  $this->startDate - 15;
			}else if ($this->yearRange == "lastTwenty" ){
				$this->yearResult =  $this->startDate - 20;
			}
		}
  }
	public function getEndDate()
  {
		return $this->endDate;
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
	public function getSort()
  {
		return $this->sortSetting;
  }
}
class SQLSend
{
	private $connection;
	private $search;
	public $startDate;
	public $yearRange;
	public $yearResult;
	private $sortSetting;
	private $sqlString;
	public function __construct($search, $startDate, $yearRange, $yearResult, $sortSetting)
  	{
		$this->connection = new DatabaseConnection();
		$this->$search = $search;
		$this->$startDate = $startDate;
		$this->$yearRange = $yearRange;
		$this->$yearResult = $yearResult;
		$this->$sortSetting = $sortSetting;
	}
	public function QueryDB()
	{
		$this->sqlString = "SELECT * FROM `article`
							WHERE title like '%$search%' OR author like '%$search%' OR method like '%$search%'
							AND year BETWEEN $yearResult and $startDate
							ORDER BY $sortSetting";

		//return mysqli_query($connection, $sqlString);
		return $this->sqlString;
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
		

		if(!$connection){
			echo "connection failure";
		}else{
			if(isset($_POST["enter"])){
				$values = new InputValues();
				$values->setSearch();
				$search = $values->getSearch();
				$values-> setStartDate();
				$startDate = $values ->getStartDate();
				$values-> setEndDate();
				$yearResult = $values ->getEndDate();
				$values ->setSort();
				$sortSetting = $values -> getSort();

				$sqlString = "SELECT * FROM `article`
							WHERE title like '%$search%' OR author like '%$search%' OR method like '%$search%'
							AND year BETWEEN $yearResult and $startDate
							ORDER BY $sortSetting";

				$sqlResult = mysqli_query($connection, $sqlString);
				
				/*$sqlSend = new SQLSend($search, $startDate, $endDate, $sortSetting);
				$sqlStr =$sqlSend->QueryDB(); 
				$sqlResult = mysqli_query($connection, $sqlStr);*/

				if(!$sqlResult){
					echo "<p>Something is wrong with ",	$sqlString , "</p> <br>";
					echo "<p>Year Result ",	$yearResult, "</p> <br>";
				}else{
					echo "<table class='table table-dark'>";
					echo "<tr>\n"
					."<th scope=\"col\">Article ID</th>\n"
					."<th scope=\"col\">Title</th>\n"
					."<th scope=\"col\">Author</th>\n"
					."<th scope=\"col\">Method</th>\n"
					."<th scope=\"col\">Year</th>\n"
					."</tr>\n";

					while ($row = mysqli_fetch_assoc($sqlResult)){
						echo "<tr>";
						echo "<td>",$row["article_id"],"</td>";
						echo "<td>",$row["title"],"</td>";
						echo "<td>",$row["author"],"</td>";
						echo "<td>",$row["method"],"</td>";
						echo "<td>",$row["year"],"</td>";
						echo "</tr>";
					}
					echo "</table>";
					mysqli_free_result($sqlResult);
				}
			}
		}
	?>
<p><a class="btn btn-primary btn-lg btn-block" href="index.html" role="button">Search an another Article</a></p>
</body>
</html>
