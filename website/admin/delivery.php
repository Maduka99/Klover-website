<?php  
session_start();
if (!isset($_SESSION['state'])) {
	header('location: index.php');
}
$product = array();
$area = "test";

if (isset($_POST['submit'])) {
	require 'databaseaccess.php';
	$database = new DbConnect();  
	$databaseconnect = $database->connect();

	$area = $_POST['area'];
	$area = strtoupper($area);

	$sql1 = "SELECT * FROM delivery WHERE area_set LIKE '%$area%'";

	$result1 = mysqli_query($databaseconnect,$sql1);
	$count = mysqli_num_rows($result1);
	if($count){

	  while($row = $result1->fetch_assoc()) {
        $product[] = $row;
    }
	  
	}else{
		$errors[] = 'No Products Found.';
	}
}

?>

<html>
<head>
	<title>Delivery Areas</title>
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
.highlight {
  background-color: yellow;
}
</style>

</head>
<body>
	<?php require 'assist/navbar.php'; ?>
	<div align="center">
		<form action="delivery.php" method="post">
			<h3 align= "center">Check Delivery Area.</h3>

			Area Name : <input type="text" placeholder="Area" name="area" required/>


			<button type= "submit" name="submit">Check</button>

		</form>
	</div>

	 <?php 
        if (sizeof($product)) {
        	echo "
	        	<div class='search' id='inputText'>

				<table style='width:70%' align='center'>
				  <tr>
				    <th>Area Name</th>
				    <th>Price (1st KG)</th> 
				    <th>Price (ADD KG) </th>
				    <th>Area Set</th> 
				    
				  </tr>";

        	for ($i=0; $i < sizeof($product); $i++) { 
	        	echo "
				  <tr>
				    <td>".$product[$i]['area_name']."</td>
				    <td>".$product[$i]['delivery_price']."</td>
				    <td>".$product[$i]['price_2']."</td>
				    <td id='inputText'>".$product[$i]['area_set']."</td>
				  </tr>
				  ";
			}	
			echo "</table>
				</div>";
        } 
        ?>
        <!-- <div > LA</div> -->
</body>
</html>
<script type="text/javascript">
function highlight(text) {
  var inputText = document.getElementById("inputText");
  var innerHTML = inputText.innerHTML; 
  var result = innerHTML.replace(new RegExp(text, 'g'), "<span class='highlight'>" +text+ "</span>");
  inputText.innerHTML = result;
// console.log(result);
  // var index = innerHTML.indexOf(text);
  // if (index >= 0) { 
  //  innerHTML = innerHTML.substring(0,index) + "<span class='highlight'>" + innerHTML.substring(index,index+text.length) + "</span>" + innerHTML.substring(index + text.length);
  //  inputText.innerHTML = innerHTML;
  // }

}

</script>
<script>
    var str = "<?php echo $area ?>";

highlight(str);

</script>