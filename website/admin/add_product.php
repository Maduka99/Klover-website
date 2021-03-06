<?php
  
  $errors = array();

  $msg =false;

  session_start();
  if (!isset($_SESSION['state'])) {
        header('location: index.php');
  }

  if (isset($_POST["submit"])) {

    require 'databaseaccess.php';
    $database = new DbConnect();  
    $databaseconnect = $database->connect();

    $s_temp_name = $_FILES['simage']['tmp_name'];
    $m_temp_name = $_FILES['mimage']['tmp_name'];
    // $stype = $_FILES['simage']['type'];
    // $stype = substr($stype,6);
    // $mtype = $_FILES['mimage']['type'];
    // $mtype = substr($mtype,6);
    
    $itemcode = mysqli_real_escape_string($databaseconnect,$_POST['itemcode']);
    $price = mysqli_real_escape_string($databaseconnect,$_POST['price']);
    $note = mysqli_real_escape_string($databaseconnect,$_POST['note']);

    $sql1 = "SELECT * FROM product WHERE itemcode='$itemcode'";
    
    $result1 = mysqli_query($databaseconnect,$sql1);
    $count = mysqli_num_rows($result1);
    if($count){
      $errors[] = 'itemcode already exist.';

    }else{
      $upload_to = 'assist/img/products/';

      $s_img_path = $upload_to.$itemcode.'.jpeg';
      $m_img_path = $upload_to.$itemcode.'_m.jpeg';

      $s_file_uploaded = move_uploaded_file($s_temp_name, $s_img_path);
      $m_file_uploaded = move_uploaded_file($m_temp_name, $m_img_path);

      $sql2 = "INSERT INTO product(itemcode,price,note,simage,mimage) VALUES ('$itemcode','$price','$note','$s_img_path','$m_img_path')";

      $result = mysqli_query($databaseconnect,$sql2);
      if(!$result){
        $errors[] = "Error details".mysqli_error($databaseconnect).".";
      }
      else{
        $msg = true;
      }
    }
  }
?>

<html>
<head>
	<title>Products</title>
	<link href="assist/css/css.css" rel="stylesheet" type="text/css">
</head>
<body>
  <?php require 'assist/navbar.php'; ?>
  <div>
    <?php if ($msg) {
      echo "<h3 color='green' align = 'center'>One item Scussfully Added.</h3>" ;


    } 
    if (sizeof($errors)) {
      echo "<h3 class='error' align = 'center'>Error :</h3>";
      for ($i=0; $i < sizeof($errors); $i++) { 
        echo "<h3 class='error' align = 'center'>".($i+1).". ".$errors[$i]."</h3>";
      }

    }
    ?>

  </div>

	<div class= "add_product">
		<div class="form">
          <form action="add_product.php" method="post" enctype="multipart/form-data">
          	<h3 align= "center">Add New Product.</h3>
            <p>
            Item code :<input type="text" placeholder="Item code" name="itemcode" required/></p><br>
            <p>
            Price :<input type="text" placeholder="Price" name="price" required/></p><br>
            <p>
            Note :<textarea name="note" rows="3" placeholder="Note"></textarea></p><br>
            <p>
            Saree Image :<input type="file" accept="image/jpeg" onchange="picf1(event)" name="simage" required><br>(Only jpeg)
              <img id="pic1"/></p><br>
            <p>
            Material Image :<input width="70%" type="file" accept="image/jpeg" onchange="picf2(event)" name="mimage" required><br>(Only jpeg)
              <img id="pic2"/></p><br>
            <button class="mainbutton" type= "submit" name="submit">Save</button>

          </form>
        </div>

	</div>

</body>
<script>
	var picf1 = function(event) {
    var output = document.getElementById('pic1');
    output.src = URL.createObjectURL(event.target.files[0]);
    output.style.display= 'block' ;
  };

  var picf2 = function(event) {
    var output = document.getElementById('pic2');
    output.src = URL.createObjectURL(event.target.files[0]);
    output.style.display= 'block' ;
  };
</script>
</html>

