<?php

$errors = array();

$product = array();

session_start();
if (!isset($_SESSION['state'])) {
    header('location: index.php');
}

require 'databaseaccess.php';
$database = new DbConnect();  
$databaseconnect = $database->connect();

$sql1 = "SELECT * FROM product";

$result1 = mysqli_query($databaseconnect,$sql1);
$count = mysqli_num_rows($result1);
if($count){

  while($row = $result1->fetch_assoc()) {
        $product[] = $row;
    }
    // echo "<pre>";
    // print_r($product);
    // echo "</pre>";

}else{
	$errors[] = 'No Products Available.';
}

?>

<html>
<head>
	<title>Products</title>

	<link href="assist/css/css.css" rel="stylesheet" type="text/css">

	<style>
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
th, td {
  padding: 15px;
}
.table{
  margin-top: 30px;
}
</style>

</head>
<body>
	<?php require 'assist/navbar.php'; ?>

	<div class="table">

	<table style="width:70%" align="center">
	  <tr>
	    <th>Item Code</th>
	    <th>Price</th> 
	    <th>Note</th>
	    <th>Saree Image</th> 
	    <th>Material Image</th>
	  </tr>
	  <?php for ($i=0; $i < sizeof($product); $i++) { 
	  	echo "<tr>
	    <td>".$product[$i]['itemcode']."</td>
	    <td>".$product[$i]['price']."</td>
	    <td>".$product[$i]['note']."</td>
	    <td><img src='".$product[$i]['simage']."' height = '200px'></td>
	    <td><img src='".$product[$i]['mimage']."'  height = '200px'></td>
	  </tr>";
	  } ?>
	  
	</table>
</div>
<br>

</body>
</html>