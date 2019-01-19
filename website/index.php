<html>
<head>
  <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login</title>

  <link href="assist/css/css.css" rel="stylesheet" type="text/css">
  <style type="text/css">
  body {
    background: #636A69; /* fallback for old browsers */
    font-family: "Roboto", sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;      
    }
 }
  </style>
  </head> 

  <?php
    require 'databaseaccess.php';
    session_start();
    if (isset($_SESSION['state'])) {
          header('location: admin.php');
    }
    elseif (isset($_POST['userName'])) {
		$database = new DbConnect();  
     	 $databaseconnect = $database->connect();
      
     	 $user_name = mysqli_real_escape_string($databaseconnect,$_POST['userName']);
      $password = mysqli_real_escape_string($databaseconnect,$_POST['password']);
      // $password = sha1($password);
      
      $sql1 = "SELECT * FROM user WHERE username='$user_name' AND password='$password'";
      $result1 = mysqli_query($databaseconnect,$sql1);
      $count = mysqli_num_rows($result1);
      if($count){

        $_SESSION["state"] = 'login';
        header('location: admin.php');

      }else{
        echo("<p align='center' class='error'>Incorrect Email OR Password.</p>");
      }

      
    }
    ?>
 
  <body>
    <div id ="login" class="signin">

    	<div class="login-page">
    		<div align="center" ><img width="400" src="assist/img/klover_logo.png"></div>
    		
        <!-- <h4 id = "error"></h4>
        <h4 id="test"></h4> -->
        <div class="form">
          <form class="login-form" action="index.php" method="post">
          	<h3 align= "center">Admin Login</h3>
            <input id ="userName" type="text" placeholder="User Name" name="userName"/>
            <input id ="password" type="password" placeholder="password" name="password" />
            <button class="mainbutton" type= "submit">log In</button>
          </form>
        </div>
      </div>
    </div>

  </body>
  </html>