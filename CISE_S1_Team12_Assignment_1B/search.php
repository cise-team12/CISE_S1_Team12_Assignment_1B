<!DOCTYPE html>
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
		$username="root";
		$password="root";
		$database="seer";
		$host="localhost";

		$connection=mysqli_connect($host,$username,$password,$database);

		if(!$connection){
			echo "connection failure";
		}else{
			if(isset($_POST["sort"])){
				$sortSetting = $_POST["sort"];
			}else{
				//This is here incase it comes in useful later, radio buttons default to title anyway so this should never be reached
				$sortSetting = "Default";
			}

		
			if(isset($_POST["enter"])){
				$search=$_POST["search"];
				//define("startYear" , 2020);
				$startYear = 2020;
				$yearRange = $_POST["year"];
				//$yearResult = $startYear - 5;

				$sqlString = "SELECT * FROM `article`
							WHERE title like '%$search%' OR author like '%$search%' OR method like '%$search%'
							AND year BETWEEN $yearResult and $startYear
							ORDER BY $sortSetting";

				$sqlResult = mysqli_query($connection, $sqlString);
				
				if(isset($_POST["year"])){
					if ($yearRange == "lastFive" ){
						$yearResult = $startYear - 5;
					}else if ($yearRange == "lastTen" ){
						$yearResult = $startYear - 10;
					}else if ($yearRange == "lastFiften" ){
						$yearResult = $startYear - 15;
					}else if ($yearRange == "lastTwenty" ){
						$yearResult = $startYear - 20;
					}
					
				}


				if(!$sqlResult){
					echo "<p>Something is wrong with ",	$sqlString , "</p>";
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
					//echo "$startYear";
					//echo "$yearResult";
					mysqli_free_result($sqlResult);
				}
			}
		}
	?>
<p><a class="btn btn-primary btn-lg btn-block" href="index.html" role="button">Search an another Article</a></p>
</body>
</html>
