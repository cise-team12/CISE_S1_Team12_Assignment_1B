<!DOCTYPE html>
<html>
<head>
	<title>Database Search</title>
</head>
<body>
<h2>Search Result</h2><br>
<?php
$username="root";
$password="";
$database="seer";
$host="localhost";

$connection=mysqli_connect($host,$username,$password,$database);
if(!$connection){
	echo "connection failure";
}
else{
	
if(isset($_POST["enter"]))
		{
			$search=$_POST["search"];

			$sqlString = "SELECT * FROM `article` WHERE title like '$search%' OR author like '$search%' OR description like '$search%'";
		
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
			."</tr>\n";
			
			while ($row = mysqli_fetch_assoc($sqlResult))
			{
				echo "<tr>";
				echo "<td>",$row["articleID"],"</td>";
				echo "<td>",$row["title"],"</td>";
				echo "<td>",$row["author"],"</td>";
				echo "<td>",$row["description"],"</td>";
				echo "</tr>";
			}
				echo "</table>";
			mysqli_free_result($sqlResult);
		}
	}

}


?>

<p><a href="index.html">Search an another Article</a></p>
</body>

</html>

