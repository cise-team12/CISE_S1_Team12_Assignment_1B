<?php

$username="root";
$password="root";
$database="seer";
$host="localhost";

$connection=mysqli_connect($host,$username,$password,$database);
if(!$connection){
	echo "connection failure";
}
else{

if(isset($_POST["sort"]))
{
  $sortSetting = $_POST["sort"];
}
else
{
	//This is here incase it comes in useful later, radio buttons default to title anyway so this should never be reached
  $sortSetting = "Default";
}

if(isset($_POST["enter"]))
		{
			$search=$_POST["search"];

			$sqlString = "SELECT * FROM `article` WHERE title like '%$search%' ORDER BY $sortSetting";

			$sqlResult=mysqli_query($connection, $sqlString);

			if(!$sqlResult)
			{
				echo "<p>Something is wrong with ",	$sqlString , "</p>";
			}
			else {

			echo "<table border=\"1\">";
			echo "<tr>\n"
			."<th scope=\"col\">Article ID</th>\n"
			."<th scope=\"col\">Title</th>\n"
			."<th scope=\"col\">Author</th>\n"
			."<th scope=\"col\">Description</th>\n"
			."<th scope=\"col\">Year</th>\n"
			."</tr>\n";

			while ($row = mysqli_fetch_assoc($sqlResult))
			{
				echo "<tr>";
				echo "<td>",$row["article_id"],"</td>";
				echo "<td>",$row["title"],"</td>";
				echo "<td>",$row["author"],"</td>";
				echo "<td>",$row["description"],"</td>";
				echo "<td>",$row["year"],"</td>";
				echo "</tr>";
			}
				echo "</table>";
			mysqli_free_result($sqlResult);
		}
	}



}


?>
