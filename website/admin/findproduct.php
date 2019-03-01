<?php 

$row = array();

session_start();
if (!isset($_SESSION['state'])) {
    header('location: index.php');
}
if (isset($_POST['submit'])) {
	require 'databaseaccess.php';
	$database = new DbConnect();  
	$databaseconnect = $database->connect();

	$itemcode = $_POST['itemcode'];

	$sql1 = "SELECT * FROM product WHERE itemcode = '$itemcode'";

	$result1 = mysqli_query($databaseconnect,$sql1);
	$count = mysqli_num_rows($result1);
	if($count){

	  $row = $result1->fetch_assoc();
	  
	}else{
		$errors[] = 'No Products Found.';
	}
}
?>

<html>
<head>
	<title>Search Product</title>

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

	<div align="center">
          <form action="findproduct.php" method="post">
          	<h3 align= "center">Search Product.</h3>
          
            Item code : <input type="text" placeholder="Item code" name="itemcode" required/>

            
            <button type= "submit" name="submit">Search</button>

          </form>
        </div>

        <?php 
        if (sizeof($row)) {
        	echo "
        	<div class='search'>

			<table style='width:70%' align='center'>
			  <tr>
			    <th>Item Code</th>
			    <th>Price</th> 
			    <th>Note</th>
			    <th>Saree Image</th> 
			    <th>Material Image</th>
			    <th></th>
			  </tr>
			  <tr>
			    <td>".$row['itemcode']."</td>
			    <td>".$row['price']."</td>
			    <td>".$row['note']."</td>
			    <td><img src='".$row['simage']."' height = '200px'></td>
			    <td><img src='".$row['mimage']."'  height = '200px'></td>
			    <td><button type='button'><a href='edit_product.php?icode=".$row['itemcode']."'>Edit</a></button></td> 
			  </tr>
			  
			</table>
			</div>";
        } 
        ?>
</body>
</html>