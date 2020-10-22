
<html>
<head>
	<title>Insertion</title>
	<style>
		body{
			background-color: lightblue;

		}
		.data input{
			width: 20%;
			margin-top: 1%;
			padding: 1%

		}
	</style>
</head>
<body>
<center>
<h1>Insertion of data in database</h1>
<form action="" method="POST">
   <div class="data">
	 <input type="text" name="pname" placeholder="Enter item" /><br/>
     <input type="text" name="price" placeholder="Price" /><br/>
     <input type="submit" name="submit" value="submit" /><br/>
     <h1>Set Default</h1>
     <input type="submit" name="default" value="default" /><br/>
   </div>
</form>
</center>

<?php


if(isset($_POST["submit"])){

	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "Product_details";
	// Create connection
	
	
	$connection = new mysqli($servername,$username,$password,$dbname);

if ($connection->connect_error) {
die("Connection failed: " . $connection->connect_error);
} 

$sql = "INSERT INTO product ( pname, price) VALUES ('".$_POST["pname"]."','".$_POST["price"]."')";


if ($connection->query($sql) === TRUE) {
echo "<script type= 'text/javascript'>alert('New record created successfully');</script>";
} else {
echo "<script type= 'text/javascript'>alert('Error: " . $sql . "<br>" . $connection->error."');</script>";
}
$connection->close();

}

if(isset($_POST["default"])){

if ($connection->connect_error) {
die("Connection failed: " . $connection->connect_error);
} 


$result = ("UPDATE menu SET orders=DEFAULT");
#setting order column to default value


if ($connection->query($result) === TRUE) {
echo "<script type= 'text/javascript'>alert('New record created successfully');</script>";
} else {
echo "<script type= 'text/javascript'>alert('Error: " . $result . "<br>" . $connection->error."');</script>";
}
$connection->close();

}
?>

</body>
</html>