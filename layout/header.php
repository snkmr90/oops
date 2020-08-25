<?php 
  require_once('config/config.php');
	require_once('classes/connection.php');
  require_once('classes/validations_common.php');
	$connect = new connection;
	$conn = $connect->connect();
	
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Oops Registration</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>
<body>
	<nav class="navbar navbar-default">
  <div class="container-fluid">
  	<div class="row">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">Oops Php</a>
    </div>
    <ul class="nav navbar-nav">
      <?php if($connect->getSession('session_user_id') == null){ ?>
      <li><a href="index.php">Register</a></li>
      <li><a href="login.php">Login</a></li>
      <?php }else{ ?>
      <li><a href="account.php">Account</a></li>
      <li><a href="inc/logout.php">Logout</a></li>
      <?php } ?>
    </ul>
	</div>
  </div>
</nav>