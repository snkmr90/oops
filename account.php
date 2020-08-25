<?php 
	require_once 'layout/header.php';
	if($connect->getSession('session_user_id') == null){
		header('location:login.php');
	}
	$table='users';
	$where = ['user_id'=>$connect->getSession('session_user_id')];
	$columns ='*';
	$getdata = $connect->getData($table='users', $columns='*', $joins=null, $orderby=null, $order=null, $where, $wherecond='AND');
	?>
  
<div class="container">
  <div class="row">
    	<div class="col-md-6">
    		<h3>User Dashboard</h3>
    		<div>Hi, <?php if (isset($getdata[0]['user_name'])){ echo $getdata[0]['user_name']; } ?></div>
    		<p>Welcome to your dashboard !</p>

		</div>
   </div>
</div>
<?php 
	require_once 'layout/footer.php';
?>